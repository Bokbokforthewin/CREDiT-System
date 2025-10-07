<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Charge;
use App\Models\Family;
use App\Models\Department;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class FullChargeView extends Component
{
    use WithPagination;

    // Filters & Search properties
    public $search = '';
    public $selectedDepartmentFilter = '';
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

    protected $listeners = ['chargeUpdated' => '$refresh', 'chargeDeleted' => '$refresh'];

    public function mount()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized access to Full Charges Overview.');
        }

        $this->selectedMonth = (int)now()->month;
        $this->selectedYear = (int)now()->year;
        $this->selectedDay = null;
    }

    public function getDepartmentsProperty()
    {
        return Department::orderBy('name')->get();
    }

    public function getChargesProperty()
    {
        $query = Charge::with(['member.family', 'user', 'department']);

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

        if ($this->selectedDepartmentFilter) {
            $query->where('department_id', $this->selectedDepartmentFilter);
        }

        if ($this->selectedMonth && $this->selectedYear) {
            $startOfMonth = Carbon::createFromDate($this->selectedYear, $this->selectedMonth, 1)->startOfMonth();
            $endOfMonth = $startOfMonth->copy()->endOfMonth();
            $query->whereBetween('charge_datetime', [$startOfMonth, $endOfMonth]);
        }

        if ($this->selectedDay) {
            $query->whereDay('charge_datetime', $this->selectedDay);
        }

        // Fetch charges and then map to add the status
        $charges = $query->orderBy('charge_datetime', 'desc')->paginate(10);

        // Add status to each charge
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

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedSelectedMonth()
    {
        $this->resetPage();
    }

    public function updatedSelectedYear()
    {
        $this->resetPage();
    }

    public function updatedSelectedDepartmentFilter()
    {
        $this->resetPage();
    }

    public function updatedSelectedDay()
    {
        $this->resetPage();
    }

    // public function openEditChargeModal($chargeId)
    // {
    //     $charge = Charge::findOrFail($chargeId);
    //     $this->editingChargeId = $charge->id;
    //     $this->editDescription = $charge->description;
    //     $this->editPrice = $charge->price;
    //     $this->showEditChargeModal = true;
    // }

    // public function updateCharge()
    // {
    //     $this->validate([
    //         'editDescription' => 'required|string|max:255',
    //         'editPrice' => 'required|numeric|min:0.01',
    //     ]);

    //     $charge = Charge::findOrFail($this->editingChargeId);
    //     $charge->update([
    //         'description' => $this->editDescription,
    //         'price' => $this->editPrice,
    //     ]);

    //     $this->resetEditModal();
    //     $this->dispatch('notify', type: 'success', message: 'Charge updated successfully!');
    //     $this->gotoPage($this->charges->currentPage());
    // }

    // public function resetEditModal()
    // {
    //     $this->reset(['editingChargeId', 'editDescription', 'editPrice', 'showEditChargeModal']);
    // }

    // public function confirmDelete($chargeId)
    // {
    //     $charge = Charge::with(['member.family', 'department'])->findOrFail($chargeId);
    //     $this->deletingChargeId = $charge->id;
    //     $this->deletingChargeDetails = "Charge ID: {$charge->id}, Desc: {$charge->description}, Price: ₱" . number_format($charge->price, 2) . ", Family: " . ($charge->member->family->family_name ?? 'N/A') . ", Dept: " . ($charge->department->name ?? 'N/A');
    //     $this->showDeleteConfirmationModal = true;
    // }

    // public function deleteCharge()
    // {
    //     if ($this->deletingChargeId) {
    //         $charge = Charge::findOrFail($this->deletingChargeId);
    //         $chargeDetailsForMessage = $this->deletingChargeDetails;

    //         $charge->delete();

    //         $this->resetDeleteModal();
    //         $this->dispatch('notify', type: 'success', message: "Charge '{$chargeDetailsForMessage}' deleted successfully!");
    //         $this->gotoPage($this->charges->currentPage());
    //     }
    // }

    public function resetDeleteModal()
    {
        $this->reset(['deletingChargeId', 'deletingChargeDetails', 'showDeleteConfirmationModal']);
    }

    public function render()
    {
        return view('livewire.admin.full-charge-view', [
            'charges' => $this->charges,
            'departments' => $this->departments,
        ])->layout('layouts.app');
    }
}