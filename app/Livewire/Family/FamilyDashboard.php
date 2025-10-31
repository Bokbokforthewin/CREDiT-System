<?php

namespace App\Livewire\Family;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Charge;
use App\Models\Family;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\FamilyMember;

class FamilyDashboard extends Component
{
    use WithPagination;

    public $family_members = [];
    public $family;
    public $familyName;
    public $familyId;
    public $hasFamilyMember = false;
    public $isFamilyHead = false;

    // Filter properties
    public $search = '';
    public $selectedMonth = '';
    public $selectedYear = '';
    public $selectedDay = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'selectedMonth' => ['except' => ''],
        'selectedYear' => ['except' => ''],
        'selectedDay' => ['except' => ''],
    ];

    public function mount()
    {
        $user = Auth::user();

        // Check if user has a family member record
        $familyMember = FamilyMember::where('user_id', $user->id)->first();

        if ($familyMember) {
            $this->hasFamilyMember = true;
            
            // Get the family through the family member
            $this->family = $familyMember->family;
            
            if ($this->family) {
                $this->familyName = $this->family->family_name;
                $this->familyId = $this->family->id;
                
                // Load family members
                $this->family_members = $this->family->members;
            }
            
            // Check if user is family head
            $this->isFamilyHead = $familyMember->role === 'head';
        } else {
            // Abort if the logged-in user is not associated with a FamilyMember/Family
            abort(403, 'Access Denied: Your account is not configured as a Family Head or linked to a Family Account.');
        }
    }

    // Computed property to fetch charges based on filters
    public function getChargesProperty()
    {
        if (!$this->family) {
            return collect([]);
        }

        // FIX: Eager load all necessary relationships
        $query = Charge::where('family_id', $this->family->id)
            ->with([
                'department', 
                'member', 
                'user'
            ]);

        // Apply search filter
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('description', 'like', '%' . $this->search . '%')
                ->orWhereHas('department', function ($deptQuery) {
                    $deptQuery->where('name', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('member', function ($memberQuery) {
                    $memberQuery->where('name', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('user', function ($userQuery) {
                    $userQuery->where('name', 'like', '%' . $this->search . '%');
                });
            });
        }

        return $query->orderBy('charge_datetime', 'desc')->paginate(10);

        // FIX: Cast to integers and check if not empty
        if (!empty($this->selectedYear)) {
            $query->whereYear('created_at', (int)$this->selectedYear);
        }

        if (!empty($this->selectedMonth)) {
            $query->whereMonth('created_at', (int)$this->selectedMonth);
        }

        if (!empty($this->selectedDay)) {
            $query->whereDay('created_at', (int)$this->selectedDay);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    // Reset methods
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

    public function updatedSelectedDay()
    {
        $this->resetPage();
    }

    // FIX: Add method to clear all filters
    public function clearFilters()
    {
        $this->reset(['search', 'selectedMonth', 'selectedYear', 'selectedDay']);
    }

    public function render()
    {
        return view('livewire.family.family-dashboard', [
            'charges' => $this->getChargesProperty(),  // Explicitly call the computed property
        ])->layout('layouts.app');
    }
}