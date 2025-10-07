<?php

namespace App\Livewire\Business;

use Livewire\Component;
use App\Models\Charge;
use App\Models\Department;
use App\Models\Family;
use App\Models\MemberDepartmentRule;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail; // For sending family reports
use Illuminate\Support\Facades\Auth; // For authorization
use App\Mail\MonthlyChargesReport; // Assuming this mail class exists
use App\Jobs\GenerateAndSendCsvReport; // Assuming this job exists
use App\Traits\Auditable;

class ReportsDashboard extends Component
{
    use Auditable;
    // Filter properties for the main reports display (charts, tables)
    public $search = '';
    public int $month;
    public int $year;
    public $selectedDepartment = null;

    // Confirmation properties for the global process
    public $showConfirmationShade = false; // Controls the top banner visibility
    public $showFinalConfirmationModal = false; // Controls the modal visibility
    public $pendingChargesCount = 0; // Total count of all charges awaiting processing globally
    public $lastProcessedDate;

    // New properties for departmental preparation status overview
    public $departmentsWithPreparedCharges = []; // Departments that have charges with billing_cycle set and not processed
    public $departmentsWithoutPreparedCharges = []; // Departments with no charges in Awaiting Processing state (for current state)

    // Recipient selection for reports
    public $selectedRecipients = [];
    public $selectAll = false; // For toggling all recipients

    // Listen for events that might change the pending confirmation status
    protected $listeners = ['chargesPrepared' => 'checkForPendingConfirmation', 'reportConfirmed' => 'checkForPendingConfirmation'];

    public function mount()
    {
        // Authorization check: Only allow users with 'reports' business_role
        if (Auth::user()->business_role !== 'reports') {
            abort(403, 'Unauthorized access to Reports Dashboard.');
        }

        // Initialize month and year for the main reporting filters (charts/tables)
        $this->month = (int)now()->month;
        $this->year = (int)now()->year;

        // Perform initial check for charges awaiting global confirmation
        $this->checkForPendingConfirmation();

        // Get the last global processed date for display
        $lastProcessed = Charge::max('processed_at');
        $this->lastProcessedDate = $lastProcessed ? Carbon::parse($lastProcessed) : null;
    }

    /**
     * Identifies all charges globally that are 'Awaiting Processing'
     * and categorizes departments based on their preparation status.
     */
    public function checkForPendingConfirmation() // Changed from protected to public
    {
        // Get all active departments for comparison
        $allDepartments = Department::orderBy('name')->get();
        $allDepartmentIds = $allDepartments->pluck('id')->toArray();

        // 1. Find ALL charges that are prepared (billing_cycle is set) but NOT yet processed (processed_at is null)
        $chargesAwaitingProcessing = Charge::whereNotNull('billing_cycle')
            ->whereNull('processed_at')
            ->get();

        $this->pendingChargesCount = $chargesAwaitingProcessing->count();
        $this->showConfirmationShade = $this->pendingChargesCount > 0;

        $preparedDepartmentIds = [];
        $departmentsWithPreparedSummaries = [];

        if ($this->pendingChargesCount > 0) {
            // 2. Group these prepared charges by department to get a summary for each
            $preparedChargesByDepartment = $chargesAwaitingProcessing->groupBy('department_id');

            foreach ($preparedChargesByDepartment as $deptId => $charges) {
                $department = $allDepartments->firstWhere('id', $deptId);
                if ($department) {
                    $preparedDepartmentIds[] = $deptId;
                    
                    // Get earliest/latest billing_cycle for context (optional, but good for transparency)
                    $earliestCycle = $charges->min('billing_cycle');
                    $latestCycle = $charges->max('billing_cycle');

                    $departmentsWithPreparedSummaries[] = (object) [ // Cast to object for easy access in Blade
                        'id' => $department->id,
                        'name' => $department->name,
                        'count' => $charges->count(),
                        'earliest_billing_cycle' => $earliestCycle ? Carbon::parse($earliestCycle)->format('M d, Y H:i A') : 'N/A',
                        'latest_billing_cycle' => $latestCycle ? Carbon::parse($latestCycle)->format('M d, Y H:i A') : 'N/A',
                    ];
                }
            }
        }

        $this->departmentsWithPreparedCharges = collect($departmentsWithPreparedSummaries);

        // 3. Identify departments that have NO charges awaiting processing (for display as 'unprepared')
        $this->departmentsWithoutPreparedCharges = $allDepartments->filter(function ($department) use ($preparedDepartmentIds) {
            return !in_array($department->id, $preparedDepartmentIds);
        })->pluck('name')->toArray(); // Ensure it's an array of names
    }

    /**
     * Opens the final confirmation modal and pre-populates recipients.
     */
    public function showFinalConfirmation()
    {
        // Only show if there are charges to process
        if ($this->pendingChargesCount === 0) {
            $this->dispatch('notify', type: 'info', message: 'No charges are currently prepared for processing.');
            return;
        }
        // Pre-populate recipients with potential accounting emails
        $this->selectAll = true;;
        $this->selectedRecipients = $this->potentialRecipients->pluck('email')->toArray();
        $this->showFinalConfirmationModal = true;
    }

    /**
     * Processes ALL charges that are prepared and not yet confirmed globally.
     */
    public function confirmAndProcessReports()
    {
        // Validate recipients are selected
        $this->validate([
            'selectedRecipients' => 'required|array|min:1|exists:users,email',
        ]);

        // Get all distinct billing cycle timestamps for charges that are currently
        // in the "awaiting processing" state (prepared but not processed globally).
        // This ensures we only act on the charges that are actually awaiting processing AT THIS MOMENT.
        $activeBillingCycles = Charge::whereNotNull('billing_cycle')
            ->whereNull('processed_at')
            ->distinct()
            ->pluck('billing_cycle')
            ->toArray();

        // If after re-checking, no charges are found to process, notify and exit
        if (empty($activeBillingCycles)) {
            $this->dispatch('notify', type: 'error', message: 'No charges found to process at this time. They might have been processed already.');
            $this->resetConfirmationState();
            return;
        }

        DB::transaction(function () use ($activeBillingCycles) {

            // AUDIT: Log each charge confirmation (processed_at update)
            $chargesToProcess = Charge::whereIn('billing_cycle', $activeBillingCycles)
            ->whereNull('processed_at')
            ->get();

            // 1. Finalize processing by setting processed_at for ALL charges
            //    that are prepared and not yet processed, across ALL departments.
            $updatedCount = Charge::whereIn('billing_cycle', $activeBillingCycles)
                ->whereNull('processed_at')
                ->update(['processed_at' => now()]);

                // AUDIT: Log the batch confirmation as ONE entry
                if ($chargesToProcess->isNotEmpty()) {
                    $referenceCharge = $chargesToProcess->first();
                    
                    $this->logCustomAction(
                        $referenceCharge,
                        'charges_confirmed',
                        [
                            'billing_cycles' => $activeBillingCycles,
                            'total_charges_confirmed' => $updatedCount,
                            'charge_ids' => $chargesToProcess->pluck('id')->toArray(), // All charge IDs
                            'confirmed_by' => auth()->user()->name,
                            'confirmed_at' => now()->toDateTimeString(),
                        ]
                    );
                }

            // 2. Get all newly processed charges for these cycles
            //    We fetch them again to ensure they have the updated 'processed_at' timestamp
            $processedCharges = Charge::whereIn('billing_cycle', $activeBillingCycles)
                ->whereNotNull('processed_at') // Filter by the newly set processed_at
                ->with(['member.family', 'department'])
                ->get();

            // 3. Send emails to family heads
            $this->sendFamilyReports($processedCharges);

            // 4. Reset spending limits (assuming this is a monthly/cyclical action)
            $this->resetSpendingLimits();

            // 5. Send Excel report to accounting (NEW)
            dispatch(new GenerateAndSendCsvReport(
                $activeBillingCycles, // Corrected variable name from activateBillingCycles
                $this->selectedRecipients
            ));

            // AUDIT: Log CSV recipient selection
                $this->logCustomAction(
                    $referenceCharge,
                    'csv_report_sent',
                    [
                        'billing_cycles' => $activeBillingCycles,
                        'total_charges_processed' => $updatedCount,
                        'csv_sent_to' => $this->selectedRecipients,
                        'recipient_count' => count($this->selectedRecipients),
                        'confirmed_by' => auth()->user()->name,
                        'confirmed_at' => now()->toDateTimeString(),
                    ]
                );

                logger()->info('Reports confirmed', [
                    'billing_cycle' => $activeBillingCycles,
                    'charges_processed' => $updatedCount,
                    'confirmed_by' => auth()->user()->name,
                    'excel_sent_to' => implode(', ', $this->selectedRecipients)
                ]);
            });

        // Reset state and re-check for any remaining pending charges (should be zero after global processing)
        $this->resetConfirmationState();
        $this->dispatch('notify',
            type: 'success',
            message: "Successfully processed {$this->pendingChargesCount} charges and sent reports globally."
        );
        $this->dispatch('reportConfirmed'); // Notify other components (e.g., charts) to refresh if needed
    }

    /**
     * Gets a list of potential recipients (e.g., accounting staff) for the Excel report.
     * This is a computed property.
     */
    public function getPotentialRecipientsProperty()
    {
        // Adjust 'business_role' or 'usertype' as per your User model's actual fields
        return User::where('usertype', 'business_office') // Assuming 'business_office' covers accounting roles
            ->where('business_role', 'limits') // Or whatever role identifies accounting/report recipients
            ->get(['name', 'email']);
    }

    /**
     * Toggles selection of all recipients.
     */
    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedRecipients = $this->potentialRecipients->pluck('email')->toArray();
        } else {
            $this->selectedRecipients = [];
        }
    }

    /**
     * Sends individual monthly reports to family heads for the processed charges.
     */
    protected function sendFamilyReports($processedCharges)
    {
        // Group charges by family_id to send one report per family
        $processedCharges->groupBy('member.family_id')->each(function ($familyCharges) {
            $family = $familyCharges->first()->member->family; // Get the family model
            $familyHead = $family->members()->where('role', 'head')->first();

            if ($familyHead && $familyHead->email) {
                // Determine a relevant cycle date for the report email (e.g., the latest billing_cycle from these charges)
                $cycleDate = $familyCharges->max('billing_cycle');
                $cycleDate = $cycleDate ? Carbon::parse($cycleDate) : now(); // Fallback to now if no cycle date

                Mail::to($familyHead->email)->queue(
                    new MonthlyChargesReport($family, $familyCharges, $cycleDate)
                );
            }
        });
    }

    /**
     * Resets spending limits for all non-restricted members back to their original limits.
     */
    protected function resetSpendingLimits()
    {
        MemberDepartmentRule::whereNotNull('original_limit')
            ->where('is_restricted', false)
            ->update([
                'spending_limit' => DB::raw('original_limit')
            ]);
        logger()->info('Spending limits reset for non-restricted members.');
    }

    /**
     * Resets temporary state after a confirmation action.
     */
    protected function resetConfirmationState()
    {
        $this->showConfirmationShade = false;
        $this->showFinalConfirmationModal = false;
        $this->selectedRecipients = [];
        $this->selectAll = false;
        $this->checkForPendingConfirmation(); // Re-run to update counts/state
        $this->lastProcessedDate = Charge::max('processed_at'); // Refresh last processed date
    }

    // --- Methods for the main reporting table and charts (largely unchanged from your original code) ---

    /**
     * Fetches all departments for filtering charts/reports.
     * This is a computed property.
     */
    public function getDepartmentsProperty()
    {
        return Department::orderBy('name')->get();
    }

    /**
     * Generates the detailed charges report grouped by department for the main table.
     * This is a computed property.
     */
    public function getChargesReportProperty()
    {
        $startDate = Carbon::create($this->year, $this->month, 1)->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();

        return Charge::query()
            ->select([
                'families.id as family_id',
                'families.account_code',
                'families.family_name',
                'departments.id as department_id',
                'departments.name as department_name',
                DB::raw('SUM(charges.price) as total_charges')
            ])
            ->join('family_members', 'charges.family_member_id', '=', 'family_members.id')
            ->join('families', 'family_members.family_id', '=', 'families.id')
            ->join('departments', 'charges.department_id', '=', 'departments.id')
            ->whereBetween('charges.charge_datetime', [$startDate, $endDate])
            ->when($this->selectedDepartment, function ($query) {
                $query->where('charges.department_id', $this->selectedDepartment);
            })
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('families.account_code', 'like', '%' . $this->search . '%')
                      ->orWhere('families.family_name', 'like', '%' . $this->search . '%')
                      ->orWhere('departments.name', 'like', '%' . $this->search . '%');
                });
            })
            ->groupBy(
                'families.id',
                'families.account_code',
                'families.family_name',
                'departments.id',
                'departments.name'
            )
            ->orderBy('departments.name')
            ->orderBy('families.family_name')
            ->get()
            ->groupBy('department_id');
    }

    /**
     * Sets the current month/year filters based on a predefined period.
     */
    public function setPeriod($period)
    {
        $today = Carbon::now();

        match ($period) {
            'this_month' => [
                $this->month = (int)$today->month,
                $this->year = (int)$today->year
            ],
            'last_month' => [
                $this->month = (int)$today->subMonth()->month,
                $this->year = (int)$today->year
            ],
            'this_year' => $this->year = (int)$today->year,
            default => null
        };
    }

    /**
     * Ensures month and year properties are numeric after Livewire hydration.
     */
    protected function ensureNumericTypes()
    {
        $this->month = (int)$this->month;
        $this->year = (int)$this->year;
    }

    /**
     * Livewire lifecycle hook to ensure types are correct.
     */
    public function hydrate()
    {
        $this->ensureNumericTypes();
    }

    /**
     * Generates a title for the selected reporting period.
     * This is a computed property.
     */
    public function getPeriodTitleProperty()
    {
        $monthNumber = (int)$this->month;
        $monthNames = [
            1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
            5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
            9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
        ];
        return sprintf('%s %d', $monthNames[$monthNumber] ?? 'Invalid Month', $this->year);
    }

    /**
     * Renders the Livewire component view.
     */
    public function render()
    {
        return view('livewire.business.reports-dashboard', [
            'chargesReport' => $this->charges_report,
            'departments' => $this->departments,
            'periodTitle' => $this->period_title,
            'monthlyChargesChart' => $this->getMonthlyChargesChart(),
            'topFamiliesChart' => $this->getTopFamiliesChart(),
            'departmentChargesChart' => $this->getDepartmentChargesChart(),
            'restrictionsChart' => $this->getRestrictionsChart(),
            'departmentLinesChart' => $this->getDepartmentLinesChart(),
            'departmentChargeTrendChart' => $this->getDepartmentChargeTrendsChart(),
        ])->layout('layouts.app');
    }

    // --- Chart Data Generation Methods (unchanged) ---

    private function getMonthlyChargesChart()
    {
        $monthlyCharges = Charge::selectRaw('MONTH(charge_datetime) as month, SUM(price) as total')
            ->whereYear('charge_datetime', $this->year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        return [
            'labels' => array_map(fn($m) => Carbon::create()->month($m)->format('M'), array_keys($monthlyCharges)),
            'datasets' => [[
                'label' => 'Monthly Charges',
                'backgroundColor' => '#60a5fa',
                'data' => array_values($monthlyCharges),
            ]]
        ];
    }

    private function getTopFamiliesChart()
    {
        $topFamilies = Charge::selectRaw('families.family_name, SUM(price) as total')
            ->join('family_members', 'charges.family_member_id', '=', 'family_members.id')
            ->join('families', 'family_members.family_id', '=', 'families.id')
            ->whereMonth('charge_datetime', $this->month)
            ->whereYear('charge_datetime', $this->year)
            ->groupBy('families.family_name')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        return [
            'labels' => $topFamilies->pluck('family_name'),
            'datasets' => [[
                'label' => 'Top Families',
                'backgroundColor' => '#34d399',
                'data' => $topFamilies->pluck('total'),
            ]]
        ];
    }

    private function getDepartmentChargesChart()
    {
        $charges = Charge::selectRaw('departments.name as dept_name, SUM(price) as total')
            ->join('departments', 'charges.department_id', '=', 'departments.id')
            ->whereMonth('charge_datetime', $this->month)
            ->whereYear('charge_datetime', $this->year)
            ->groupBy('dept_name')
            ->pluck('total', 'dept_name')
            ->toArray();

        return [
            'labels' => array_keys($charges),
            'datasets' => [[
                'backgroundColor' => ['#60a5fa', '#f87171', '#34d399', '#fbbf24', '#a78bfa', '#f472b6'],
                'data' => array_values($charges),
            ]]
        ];
    }

    private function getRestrictionsChart()
    {
        $restrictions = MemberDepartmentRule::selectRaw('family_members.name, COUNT(*) as count')
            ->join('family_members', 'member_department_rules.family_member_id', '=', 'family_members.id')
            ->where('is_restricted', true)
            ->groupBy('family_members.name')
            ->orderByDesc('count')
            ->limit(10)
            ->pluck('count', 'family_members.name')
            ->toArray();

        return [
            'labels' => array_keys($restrictions),
            'datasets' => [[
                'label' => 'Restrictions',
                'backgroundColor' => ['#ef4444', '#f59e0b', '#10b981', '#3b82f6', '#8b5cf6', '#ec4899'],
                'data' => array_values($restrictions),
            ]]
        ];
    }

    private function getDepartmentLinesChart()
    {
        $labels = collect(range(1, 12))->map(fn($m) => Carbon::create()->month($m)->format('M'));
        $datasets = [];

        foreach (Department::all() as $dept) {
            $monthly = Charge::where('department_id', $dept->id)
                ->whereYear('charge_datetime', now()->year)
                ->selectRaw('MONTH(charge_datetime) as month, SUM(price) as total')
                ->groupBy('month')
                ->pluck('total', 'month')
                ->toArray();

            $data = [];
            foreach (range(1, 12) as $month) {
                $data[] = $monthly[$month] ?? 0;
            }

            $datasets[] = [
                'label' => $dept->name,
                'data' => $data,
                'borderColor' => '#' . substr(md5($dept->name), 0, 6),
                'fill' => false,
            ];
        }

        return [
            'labels' => $labels,
            'datasets' => $datasets,
        ];
    }

    private function getDepartmentChargeTrendsChart()
    {
        $months = collect(range(0, 5))->map(function ($i) {
            return now()->subMonths($i)->format('F Y');
        })->reverse();

        $departments = Department::all();

        $datasets = $departments->map(function ($department) use ($months) {
            $data = $months->map(function ($month) use ($department) {
                $start = Carbon::parse("first day of $month");
                $end = Carbon::parse("last day of $month");

                $total = Charge::where('department_id', $department->id)
                    ->whereBetween('charge_datetime', [$start, $end])
                    ->sum('price');

                return round($total, 2);
            });

            return [
                'label' => $department->name,
                'data' => $data,
                'backgroundColor' => $this->getDepartmentColor($department->id),
            ];
        });

        return [
            'labels' => $months->values(),
            'datasets' => $datasets->values(),
        ];
    }               

    private function getDepartmentColor($id)
    {
        $colors = [
            '#6366f1', '#10b981', '#f59e0b', '#ef4444',
            '#3b82f6', '#8b5cf6', '#ec4899'
        ];
        return $colors[$id % count($colors)];
    }
}
