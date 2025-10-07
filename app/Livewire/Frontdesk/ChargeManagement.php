<?php

namespace App\Livewire\Frontdesk;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Charge;
use App\Models\Department;
use App\Models\Family;
use App\Models\FamilyMember;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB; // Needed for database transactions
use App\Traits\Auditable; // <-- ADDED: Import the Auditable trait

class ChargeManagement extends Component
{
    use WithPagination;
    use Auditable; // <-- ADDED: Use the Auditable trait

    public $department;

    // Filters & Search properties
    public $search = '';
    public $selectedMonth;
    public $selectedYear;
    public $selectedDay;

    // Properties for Editing a Charge
    public $editingChargeId = null;
    public $editDescription = '';
    public $editPrice = '';
    public $showEditChargeModal = false;

    // Properties for Deleting a Charge
    public $deletingChargeId = null;
    public $deletingChargeDetails = '';
    public $showDeleteConfirmationModal = false;

    // New: Properties for "Prepare Charges" functionality and its modal
    public $canPrepareCharges = false;
    public $pendingChargesToPrepareCount = 0;
    public $showPrepareConfirmationModal = false;


    protected $listeners = ['chargeUpdated' => '$refresh', 'chargeDeleted' => '$refresh', 'chargesPrepared' => '$refresh'];

    public function mount(Department $department)
    {
        $this->department = $department;

        if (Auth::user()->department_id !== $this->department->id) {
            abort(403, 'Unauthorized access to this department');
        }
        // Initialize filters
        $this->selectedMonth = (int)now()->month;
        $this->selectedYear = (int)now()->year;
        $this->selectedDay = null; // Default to no specific day selected

        // Initial check for "Prepare Charges" button status
        $this->checkIfChargesCanBePrepared();
    }

    // Computed property to fetch charges based on filters, pagination, and calculated status
    public function getChargesProperty()
    {
        $query = Charge::where('department_id', $this->department->id)
                        ->with(['member.family', 'user', 'department']);

        // Apply search filter (family name, charge description, staff name, account code)
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('description', 'like', '%' . $this->search . '%')
                  ->orWhereHas('member.family', function ($qFamily) {
                      $qFamily->where('family_name', 'like', '%' . $this->search . '%')
                              ->orWhere('account_code', 'like', '%' . $this->search . '%');
                  })
                  ->orWhereHas('user', function ($qUser) {
                      $qUser->where('name', 'like', '%' . $this->search . '%');
                  });
            });
        }

        // Apply month and year filters
        if ($this->selectedMonth && $this->selectedYear) {
            $startOfMonth = Carbon::createFromDate($this->selectedYear, $this->selectedMonth, 1)->startOfMonth();
            $endOfMonth = $startOfMonth->copy()->endOfMonth();
            $query->whereBetween('charge_datetime', [$startOfMonth, $endOfMonth]);
        }

        // Apply day filter
        if ($this->selectedDay) {
            $query->whereDay('charge_datetime', $this->selectedDay);
        }

        // Fetch charges and then map to add the dynamic status
        $charges = $query->orderBy('charge_datetime', 'desc')->paginate(10);

        $charges->through(function ($charge) {
            if ($charge->processed_at !== null) {
                $charge->status = 'Processed';
            } elseif ($charge->billing_cycle !== null) {
                $charge->status = 'Awaiting Processing';
            } else {
                $charge->status = 'Pending';
            }
            return $charge;
        });

        return $charges;
    }

    // New: Method to count pending charges and update button visibility
    public function checkIfChargesCanBePrepared()
    {
        $this->pendingChargesToPrepareCount = Charge::where('department_id', $this->department->id)
                                                 ->whereNull('billing_cycle')
                                                 ->whereNull('processed_at')
                                                 ->count();
        $this->canPrepareCharges = $this->pendingChargesToPrepareCount > 0;
    }

    // New: Opens the confirmation modal for preparing charges
    public function confirmPrepareCharges()
    {
        if ($this->canPrepareCharges) {
            $this->showPrepareConfirmationModal = true;
        } else {
            $this->dispatch('notify', type: 'info', message: 'No pending charges in this department to prepare for billing.');
        }
    }

    // New: Prepares charges for billing (sets billing_cycle timestamp)
    public function prepareChargesForBilling()
    {
        // Close modal first
        $this->showPrepareConfirmationModal = false;

        // Double-check if there are charges to prepare
        if ($this->pendingChargesToPrepareCount === 0) {
             $this->dispatch('notify', 
                type: 'info',
                message: 'No pending charges in this department to prepare for billing.'
            );
            return;
        }

        DB::transaction(function () {
            $currentTime = now(); // Use a consistent timestamp for the entire batch

            // AUDIT: Get charges BEFORE updating them
            $chargesToPrepare = Charge::where('department_id', $this->department->id)
            ->whereNull('billing_cycle')
            ->whereNull('processed_at')
            ->get();

            $updatedCount = Charge::where('department_id', $this->department->id)
                ->whereNull('billing_cycle')
                ->whereNull('processed_at')
                ->update([
                    'billing_cycle' => $currentTime
                ]);

            // AUDIT: Log the batch preparation
        if ($chargesToPrepare->isNotEmpty()) {
            $referenceCharge = $chargesToPrepare->first();
            
            $this->logCustomAction(
                $referenceCharge,
                'charges_prepared',
                [
                    'department_id' => $this->department->id,
                    'department_name' => $this->department->name,
                    'billing_cycle_timestamp' => $currentTime->toDateTimeString(),
                    'total_charges_prepared' => $updatedCount,
                    'charge_ids' => $chargesToPrepare->pluck('id')->toArray(),
                    'prepared_by' => Auth::user()->name,
                    'prepared_at' => now()->toDateTimeString(),
                ]
            );
        }

        logger()->info('Charges prepared for billing by department', [
            'department_id' => $this->department->id,
            'department_name' => $this->department->name,
            'billing_cycle_timestamp' => $currentTime,
            'charge_count' => $updatedCount,
            'initiated_by' => Auth::user()->name
        ]);
        
            $this->dispatch('notify', 
                type: 'success',
                message: "Prepared {$updatedCount} charges for billing in {$this->department->name}."
            );
        });

        // After preparing, re-check button status, refresh charges, and notify other components
        $this->checkIfChargesCanBePrepared();
        $this->resetPage(); // Reset pagination to ensure UI reflects status changes
        $this->dispatch('chargesPrepared'); // Global event for the ReportsDashboard to listen to
    }

    // Methods to reset pagination and re-check prepare status when filters change
    public function updatedSearch()
    {
        $this->resetPage();
        $this->checkIfChargesCanBePrepared();
    }

    public function updatedSelectedMonth()
    {
        $this->resetPage();
        $this->checkIfChargesCanBePrepared();
    }

    public function updatedSelectedYear()
    {
        $this->resetPage();
        $this->checkIfChargesCanBePrepared();
    }

    public function updatedSelectedDay()
    {
        $this->resetPage();
        $this->checkIfChargesCanBePrepared();
    }

    // Open Edit Modal with restrictions
    public function openEditChargeModal($chargeId)
    {
        $charge = $this->charges->firstWhere('id', $chargeId); // Get from already loaded charges
        if (!$charge) {
            $charge = Charge::findOrFail($chargeId); // Fallback if not on current page
        }

        if ($charge->department_id !== $this->department->id) {
            session()->flash('error', 'You are not authorized to edit charges outside your department.');
            return;
        }
        // Frontdesk staff cannot edit 'Awaiting Processing' or 'Processed' charges
        if ($charge->status === 'Awaiting Processing' || $charge->status === 'Processed') {
            $this->dispatch('notify', type: 'error', message: 'This charge is already prepared or processed and cannot be edited by Frontdesk staff.');
            return;
        }

        $this->editingChargeId = $charge->id;
        $this->editDescription = $charge->description;
        $this->editPrice = $charge->price;
        $this->showEditChargeModal = true;
    }

    // Update Charge with restrictions
    public function updateCharge()
    {
        $this->validate([
            'editDescription' => 'required|string|max:255',
            'editPrice' => 'required|numeric|min:0.01',
        ]);

        $charge = Charge::findOrFail($this->editingChargeId);

        if ($charge->department_id !== $this->department->id) {
            session()->flash('error', 'Unauthorized update attempt. Charge does not belong to your department.');
            $this->resetEditModal();
            return;
        }
        // Prevent update if already prepared or processed
        if ($charge->billing_cycle !== null || $charge->processed_at !== null) {
            $this->dispatch('notify', type: 'error', message: 'This charge is already prepared or processed and cannot be updated.');
            $this->resetEditModal();
            return;
        }

        // AUDIT LOGGING: Capture old values before update
        $oldValues = $charge->getOriginal();

        $charge->update([
            'description' => $this->editDescription,
            'price' => $this->editPrice,
        ]);
        
        // AUDIT LOGGING: Log the update
        $this->logUpdate($charge, $oldValues);

        $this->resetEditModal();
        $this->dispatch('notify', type: 'success', message: 'Charge updated successfully!');
        $this->gotoPage($this->charges->currentPage());
        $this->checkIfChargesCanBePrepared(); // Re-check prepare button status
    }

    public function resetEditModal()
    {
        $this->reset(['editingChargeId', 'editDescription', 'editPrice', 'showEditChargeModal']);
    }

    // Confirm Delete with restrictions
    public function confirmDelete($chargeId)
    {
        $charge = $this->charges->firstWhere('id', $chargeId); // Get from already loaded charges
        if (!$charge) {
            $charge = Charge::with(['member.family', 'department'])->findOrFail($chargeId); // Fallback
        }

        if ($charge->department_id !== $this->department->id) {
            session()->flash('error', 'You are not authorized to delete charges outside your department.');
            return;
        }
        // Frontdesk staff cannot delete 'Awaiting Processing' or 'Processed' charges
        if ($charge->status === 'Awaiting Processing' || $charge->status === 'Processed') {
            $this->dispatch('notify', type: 'error', message: 'This charge is already prepared or processed and cannot be deleted by Frontdesk staff.');
            return;
        }

        $this->deletingChargeId = $charge->id;
        $this->deletingChargeDetails = "Charge ID: {$charge->id}, Desc: {$charge->description}, Price: ₱" . number_format($charge->price, 2) . ", Family: " . ($charge->member->family->family_name ?? 'N/A') . ", Dept: " . ($charge->department->name ?? 'N/A');
        $this->showDeleteConfirmationModal = true;
    }

    // Delete Charge with restrictions
    public function deleteCharge()
    {
        if ($this->deletingChargeId) {
            $charge = Charge::findOrFail($this->deletingChargeId);
            $chargeDetailsForMessage = $this->deletingChargeDetails;

            if ($charge->department_id !== $this->department->id) {
                session()->flash('error', 'Unauthorized delete attempt. Charge does not belong to your department.');
                $this->resetDeleteModal();
                return;
            }
            // Prevent deletion if already prepared or processed
            if ($charge->billing_cycle !== null || $charge->processed_at !== null) {
                $this->dispatch('notify', type: 'error', message: 'This charge is already prepared or processed and cannot be deleted.');
                $this->resetDeleteModal();
                return;
            }

            // AUDIT LOGGING: Log the deletion before the record is destroyed
            $this->logDeletion($charge);
            
            $charge->delete();

            $this->resetDeleteModal();
            $this->dispatch('notify', type: 'success', message: "Charge '{$chargeDetailsForMessage}' deleted successfully!");
            $this->gotoPage($this->charges->currentPage());
            $this->checkIfChargesCanBePrepared(); // Re-check prepare button status
        }
    }

    public function resetDeleteModal()
    {
        $this->reset(['deletingChargeId', 'deletingChargeDetails', 'showDeleteConfirmationModal']);
    }

    public function render()
    {
        return view('livewire.frontdesk.charge-management', [
            'charges' => $this->charges,
            'department' => $this->department,
        ])->layout('layouts.app');
    }
}
