<?php

namespace App\Livewire\Business;

use Livewire\Component;
use Livewire\Attributes\On; 
use App\Models\Family;
use App\Models\Charge;
use App\Models\Department;
use App\Models\FamilyMember;
use App\Models\MemberDepartmentRule;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\MonthlyChargesReport;

class Dashboard extends Component
{
    public $search = '';
    public $family;
    public $showModal = false;
    public $charges = [];
    public $selectedMonth;
    public $selectedYear;

    // public $showLimitModal = false;
    // public $activeTab = 'limit';

    // public $limitSearch = '';
    // public $departments = [];
    // public $members = [];
    // public $restrictions = [];
    // public $limits = [];

    public function mount()
    {
        if (auth()->user()->business_role !== 'limits') {
            abort(403);
        }
        $this->selectedMonth = now()->month;
        $this->selectedYear = now()->year;
        $this->loadRules();
    }

    public function loadRules()
    {
        $this->departments = Department::all();
        $this->members = FamilyMember::with('rules')->get();

        $this->restrictions = [];
        $this->limits = [];

        foreach ($this->members as $member) {
            foreach ($this->departments as $dept) {
                $rule = $member->rules->firstWhere('department_id', $dept->id);
                $this->restrictions[$member->id][$dept->id] = $rule ? (bool) $rule->is_restricted : false;

                if (!$this->restrictions[$member->id][$dept->id]) {
                    $this->limits[$member->id][$dept->id] = [
                        'spending_limit' => $rule->spending_limit ?? '',
                        'original_limit' => $rule->original_limit ?? ''
                    ];
                }
            }
        }
        // Update chart data after reset
        $this->monthlyChargesChart = $this->getMonthlyChargesChart();
        $this->topFamiliesChart = $this->getTopFamiliesChart();
        $this->departmentChargesChart = $this->getDepartmentChargesChart();
        $this->restrictionsChart = $this->getRestrictionsChart();
        $this->departmentLinesChart = $this->getDepartmentLinesChart();
    }

    public function openLimitEditor()
    {
        $this->activeTab = 'limit';
        $this->showLimitModal = true;
        $this->loadRules();

        // Update chart data after reset
        $this->monthlyChargesChart = $this->getMonthlyChargesChart();
        $this->topFamiliesChart = $this->getTopFamiliesChart();
        $this->departmentChargesChart = $this->getDepartmentChargesChart();
        $this->restrictionsChart = $this->getRestrictionsChart();
        $this->departmentLinesChart = $this->getDepartmentLinesChart();
    }

    public function closeLimitModal()
    {
        $this->showLimitModal = false;

        // Update chart data after reset
        $this->monthlyChargesChart = $this->getMonthlyChargesChart();
        $this->topFamiliesChart = $this->getTopFamiliesChart();
        $this->departmentChargesChart = $this->getDepartmentChargesChart();
        $this->restrictionsChart = $this->getRestrictionsChart();
        $this->departmentLinesChart = $this->getDepartmentLinesChart();
    }

    public function toggleTab($tab)
    {
        $this->activeTab = $tab;

        // Update chart data after reset
        $this->monthlyChargesChart = $this->getMonthlyChargesChart();
        $this->topFamiliesChart = $this->getTopFamiliesChart();
        $this->departmentChargesChart = $this->getDepartmentChargesChart();
        $this->restrictionsChart = $this->getRestrictionsChart();
        $this->departmentLinesChart = $this->getDepartmentLinesChart();
    }

    public function saveRestrictions()
    {
        foreach ($this->restrictions as $memberId => $departments) {
            foreach ($departments as $deptId => $isRestricted) {
                $rule = MemberDepartmentRule::firstOrNew([
                    'family_member_id' => $memberId,
                    'department_id' => $deptId
                ]);

                $rule->is_restricted = $isRestricted;

                if ($isRestricted) {
                    $rule->spending_limit = null;
                    $rule->original_limit = null;
                }

                $rule->save();
            }
        }

        // Force re-render and Livewire re-evaluation of chart variables
        $this->monthlyChargesChart = $this->getMonthlyChargesChart();
        $this->topFamiliesChart = $this->getTopFamiliesChart();
        $this->departmentChargesChart = $this->getDepartmentChargesChart();
        $this->restrictionsChart = $this->getRestrictionsChart();
        $this->departmentLinesChart = $this->getDepartmentLinesChart();
        // $this->monthlyReportsSentChart = $this->getMonthlyReportsSentChart();

        session()->flash('success', '✅ Restrictions updated successfully.');
        $this->showLimitModal = false;
    }

    public function saveLimits()
    {
        foreach ($this->limits as $memberId => $depts) {
            foreach ($depts as $deptId => $limitData) {
                if (!empty($this->restrictions[$memberId][$deptId])) {
                    continue;
                }

                $rule = MemberDepartmentRule::firstOrNew([
                    'family_member_id' => $memberId,
                    'department_id' => $deptId
                ]);

                $rule->spending_limit = $limitData['spending_limit'] ?: null;
                $rule->original_limit = $limitData['original_limit'] ?: null;
                $rule->is_restricted = false;

                $rule->save();
            }
        }

        session()->flash('success', '✅ All applicable spending limits have been reset.');
        $this->showLimitModal = false;

        // Update chart data after reset
        $this->monthlyChargesChart = $this->getMonthlyChargesChart();
        $this->topFamiliesChart = $this->getTopFamiliesChart();
        $this->departmentChargesChart = $this->getDepartmentChargesChart();
        $this->restrictionsChart = $this->getRestrictionsChart();
        $this->departmentLinesChart = $this->getDepartmentLinesChart();

        $this->dispatch('chartsUpdated'); // ✅ Livewire v3-compatible event
    }

    // public function resetAllLimits()
    // {
    //     MemberDepartmentRule::whereNotNull('original_limit')->each(function ($rule) {
    //         if (!$rule->is_restricted) {
    //             $rule->spending_limit = $rule->original_limit;
    //             $rule->save();
    //         }
    //     });

    //     // Force re-render and Livewire re-evaluation of chart variables
    //     $this->monthlyChargesChart = $this->getMonthlyChargesChart();
    //     $this->topFamiliesChart = $this->getTopFamiliesChart();
    //     $this->departmentChargesChart = $this->getDepartmentChargesChart();
    //     $this->restrictionsChart = $this->getRestrictionsChart();
    //     $this->departmentLinesChart = $this->getDepartmentLinesChart();
    //     $this->monthlyReportsSentChart = $this->getMonthlyReportsSentChart();

    //     session()->flash('success', '✅ All applicable spending limits have been reset.');
    //     $this->showLimitModal = false;
    // }

    // public function prepareMonthlyReports()
    // {
    //     $pendingCharges = Charge::whereNull('processed_at')->get();
        
    //     if ($pendingCharges->isEmpty()) {
    //         $this->dispatch('notify', 
    //             type: 'error',
    //             message: 'No pending charges found for reporting'
    //         );
    //         return;
    //     }

    //     $billingCycleId = now()->format('Y-m-d_H:i');
        
    //     // Only set billing_cycle, NOT processed_at
    //     Charge::whereNull('processed_at')->update([
    //         'billing_cycle' => $billingCycleId
    //     ]);

    //     logger()->info('Monthly reports prepared', [
    //         'billing_cycle' => $billingCycleId,
    //         'charge_count' => $pendingCharges->count(),
    //         'initiated_by' => auth()->user()->name
    //     ]);

    //     $this->dispatch('notify',
    //         type: 'success',
    //         message: "Prepared {$pendingCharges->count()} charges for billing cycle {$billingCycleId}"
    //     );
    // }
    // Add this new method inside your Dashboard class 👇

    // public function sendMonthlyReportsWithReset()
    // {
    //     // Reset all limits first
    //     MemberDepartmentRule::whereNotNull('original_limit')->each(function ($rule) {
    //         if (!$rule->is_restricted) {
    //             $rule->spending_limit = $rule->original_limit;
    //             $rule->save();
    //         }
    //     });

    //     // Send reports to all family heads
    //     $month = now()->month;
    //     $year = now()->year;

    //     $families = Family::with(['members', 'members.charges'])->get();

    //     foreach ($families as $family) {
    //         $head = $family->members()->where('role', 'head')->first();

    //         if ($head && $head->email) {
    //             $charges = $family->members->flatMap(function ($member) use ($month, $year) {
    //                 return $member->charges()
    //                     ->whereMonth('charge_datetime', $month)
    //                     ->whereYear('charge_datetime', $year)
    //                     ->with(['user', 'department', 'member'])
    //                     ->get();
    //             });

    //             if ($charges->count()) {
                    
    //                 Mail::to($head->email)->queue(new MonthlyChargesReport($family, $charges));
    //             }
    //         }
    //     }

    //     // Update chart data after reset
    //     $this->monthlyChargesChart = $this->getMonthlyChargesChart();
    //     $this->topFamiliesChart = $this->getTopFamiliesChart();
    //     $this->departmentChargesChart = $this->getDepartmentChargesChart();
    //     $this->restrictionsChart = $this->getRestrictionsChart();
    //     $this->departmentLinesChart = $this->getDepartmentLinesChart();
    //     // $this->monthlyReportsSentChart = $this->getMonthlyReportsSentChart();

    //     // Flash single success message
    //     session()->flash('success', '✅ Monthly reports sent and all applicable spending limits reset.');

    //     // Dispatch event for chart re-render
    //     $this->dispatch('chartsUpdated');
    // }


    public function searchFamily()
    {
        $this->family = Family::where('family_name', 'like', '%' . $this->search . '%')->first();

        if ($this->family) {
            $memberIds = $this->family->members->pluck('id');

            $start = Carbon::createFromDate($this->selectedYear, $this->selectedMonth, 1)->startOfMonth();
            $end = Carbon::createFromDate($this->selectedYear, $this->selectedMonth, 1)->endOfMonth();

            $this->charges = Charge::whereIn('family_member_id', $memberIds)
                ->whereBetween('charge_datetime', [$start, $end])
                ->with(['member', 'user', 'department'])
                ->orderBy('charge_datetime', 'desc')
                ->get();

            $this->showModal = true;
        } else {
            session()->flash('error', 'Family not found.');
        }

        // Update chart data after reset
        $this->monthlyChargesChart = $this->getMonthlyChargesChart();
        $this->topFamiliesChart = $this->getTopFamiliesChart();
        $this->departmentChargesChart = $this->getDepartmentChargesChart();
        $this->restrictionsChart = $this->getRestrictionsChart();
        $this->departmentLinesChart = $this->getDepartmentLinesChart();
    }

    public function updatedSelectedMonth() { $this->loadCharges(); }
    public function updatedSelectedYear() { $this->loadCharges(); }

    public function loadCharges()
    {
        if (!$this->family) {
            $this->charges = [];
            return;
        }

        $memberIds = $this->family->members->pluck('id');
        $start = Carbon::create($this->selectedYear, $this->selectedMonth, 1)->startOfMonth();
        $end = $start->copy()->endOfMonth();

        $this->charges = Charge::whereIn('family_member_id', $memberIds)
            ->whereBetween('charge_datetime', [$start, $end])
            ->with(['member', 'user', 'department'])
            ->orderBy('charge_datetime', 'desc')
            ->get();
    }

    public function getFilteredMembersProperty()
    {
        if (trim($this->limitSearch) === '') {
            return $this->members->take(5);
        }

        $family = Family::where('family_name', 'like', '%' . $this->limitSearch . '%')->first();
        if ($family) {
            return $this->members->whereIn('id', $family->members->pluck('id'))->take(5);
        }

        return $this->members
            ->filter(fn($member) => str_contains(strtolower($member->full_name), strtolower($this->limitSearch)))
            ->take(5);
    }

    public function closeModal()
    {
        $this->showModal = false;

        // Update chart data after reset
        $this->monthlyChargesChart = $this->getMonthlyChargesChart();
        $this->topFamiliesChart = $this->getTopFamiliesChart();
        $this->departmentChargesChart = $this->getDepartmentChargesChart();
        $this->restrictionsChart = $this->getRestrictionsChart();
        $this->departmentLinesChart = $this->getDepartmentLinesChart();
    }

    // public function sendMonthlyReports()
    // {
    //     $month = now()->month;
    //     $year = now()->year;

    //     $families = Family::with(['members', 'members.charges'])->get();

    //     foreach ($families as $family) {
    //         $head = $family->members()->where('role', 'head')->first();

    //         if ($head && $head->email) {
    //             $charges = $family->members->flatMap(function ($member) use ($month, $year) {
    //                 return $member->charges()
    //                     ->whereMonth('charge_datetime', $month)
    //                     ->whereYear('charge_datetime', $year)
    //                     ->with(['user', 'department', 'member'])
    //                     ->get();
    //             });

    //             if ($charges->count()) {
    //                 Mail::to($head->email)->send(new MonthlyChargesReport($family, $charges));
    //             }
    //         }
    //     }

    //     session()->flash('success', '✅ Monthly reports have been emailed.');
    // }

    public function render()
    {
        return view('livewire.business.dashboard', [
            'monthlyChargesChart' => $this->getMonthlyChargesChart(),
            'topFamiliesChart' => $this->getTopFamiliesChart(),
            'departmentChargesChart' => $this->getDepartmentChargesChart(),
            'restrictionsChart' => $this->getRestrictionsChart(),
            'departmentLinesChart' => $this->getDepartmentLinesChart(),
            'departmentChargeTrendChart' => $this->getDepartmentChargeTrendsChart(),
        ])->layout('layouts.app');
    }

    // CHART DATA METHODS BELOW 👇

    private function getMonthlyChargesChart()
    {
        $monthlyCharges = Charge::selectRaw('MONTH(charge_datetime) as month, SUM(price) as total')
            ->whereYear('charge_datetime', now()->year)
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
            ->whereMonth('charge_datetime', now()->month)
            ->whereYear('charge_datetime', now()->year)
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
            ->whereMonth('charge_datetime', now()->month)
            ->whereYear('charge_datetime', now()->year)
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
        })->reverse(); // last 6 months

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
        // Assign consistent colors per department
        $colors = [
            '#6366f1', // Indigo
            '#10b981', // Emerald
            '#f59e0b', // Amber
            '#ef4444', // Red
            '#3b82f6', // Blue
            '#8b5cf6', // Violet
            '#ec4899', // Pink
        ];

        return $colors[$id % count($colors)];
    }
}
