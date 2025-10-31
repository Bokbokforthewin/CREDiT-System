<?php

namespace App\Livewire\Family;

use Livewire\Component;
use App\Models\Family;
use App\Models\FamilyMember;
use App\Models\Department;
use App\Models\MemberDepartmentRule;
use App\Traits\Auditable;
use Illuminate\Support\Facades\Auth; // Added Auth import

class EditLimitsAndRestrictions extends Component
{
    use Auditable;

    public $currentFamilyId;
    public $currentFamilyName;
    
    public $limitSearch = '';
    public $selectedMemberId = null;
    public $selectedMember = null;
    public $departments = [];
    public $members = [];
    public $searchResults = [];
    public $restrictions = [];
    public $limits = [];
    public $showDropdown = false;

    public function mount()
    {
        $userId = Auth::id(); // Get the ID of the logged-in user

        // 1. Explicitly find the FamilyMember record linked by the user_id foreign key.
        $familyMember = FamilyMember::where('user_id', $userId)->first();

        // 2. Check if the FamilyMember exists AND is linked to a family (has family_id set).
        if ($familyMember && $familyMember->family_id) {
            $this->currentFamilyId = $familyMember->family_id;
            
            $family = Family::find($this->currentFamilyId);
            $this->currentFamilyName = $family->family_name ?? 'Your Family';

        } else {
            // Abort if the logged-in user is not associated with a FamilyMember/Family
            abort(403, 'Access Denied: Your account is not configured as a Family Head or linked to a Family Account.');
        }

        $this->loadDepartments();
        $this->loadMembers();
    }

    /**
     * Load all departments
     */
    public function loadDepartments()
    {
        $this->departments = Department::all();
    }

    /**
     * Load members ONLY from the current logged-in family
     */
    public function loadMembers()
    {
        // Query scoped by the authenticated user's family ID
        $this->members = FamilyMember::where('family_id', $this->currentFamilyId)
            ->with(['rules', 'family'])
            ->get();
    }

    /**
     * Updated search handling for dropdown
     */
    public function updatedLimitSearch()
    {
        if (trim($this->limitSearch) === '') {
            $this->searchResults = [];
            $this->showDropdown = false;
            return;
        }

        // Search only by member name within the current family's pre-filtered collection.
        $this->searchResults = $this->members->filter(function ($member) {
            return str_contains(strtolower($member->name), strtolower($this->limitSearch));
        })->take(8);
        
        $this->showDropdown = $this->searchResults->isNotEmpty();
    }

    /**
     * Select a member from dropdown
     */
    public function selectMember($memberId)
    {
        $this->selectedMemberId = $memberId;
        
        $this->selectedMember = $this->members->firstWhere('id', $memberId) 
                                ?? FamilyMember::with(['rules', 'family'])->find($memberId);
        
        $this->showDropdown = false;
        $this->limitSearch = $this->selectedMember->name . ' (' . $this->selectedMember->family->family_name . ')';
        
        $this->loadMemberData();
    }

    /**
     * Load data for selected member
     */
    public function loadMemberData()
    {
        if (!$this->selectedMember) {
            return;
        }

        $this->restrictions = [];
        $this->limits = [];

        foreach ($this->departments as $dept) {
            $rule = $this->selectedMember->rules->firstWhere('department_id', $dept->id);
            
            $this->restrictions[$dept->id] = $rule ? (bool) $rule->is_restricted : false;
            
            $this->limits[$dept->id] = [
                'spending_limit' => $rule->spending_limit ?? '',
                'original_limit' => $rule->original_limit ?? ''
            ];
        }
    }

    /**
     * Update restriction status for a department
     */
    public function updateRestriction($deptId, $isRestricted)
    {
        $this->restrictions[$deptId] = $isRestricted;
        
        // If restricted, clear the limits
        if ($isRestricted) {
            $this->limits[$deptId]['spending_limit'] = '';
            $this->limits[$deptId]['original_limit'] = '';
        }
    }

    /**
     * Clear selection and reset form
     */
    public function clearSelection()
    {
        $this->selectedMemberId = null;
        $this->selectedMember = null;
        $this->limitSearch = '';
        $this->searchResults = [];
        $this->showDropdown = false;
        $this->restrictions = [];
        $this->limits = [];
    }

    /**
     * Save all changes for the selected member
     */
    public function saveChanges()
    {
        if (!$this->selectedMember) {
            session()->flash('error', 'No member selected.');
            return;
        }

        // Final security check: Ensure the member being edited belongs to the current family
        if ($this->selectedMember->family_id !== $this->currentFamilyId) {
             session()->flash('error', 'Security violation: Cannot edit limits for a member outside your family.');
             return;
        }
        
        foreach ($this->departments as $dept) {
            $rule = MemberDepartmentRule::firstOrNew([
                'family_member_id' => $this->selectedMemberId,
                'department_id' => $dept->id
            ]);
            
            $isNew = !$rule->exists;
            $oldRuleValues = $rule->exists ? $rule->getOriginal() : [];
            
            $isRestricted = $this->restrictions[$dept->id] ?? false;
            
            $rule->is_restricted = $isRestricted;

            if ($isRestricted) {
                $rule->spending_limit = null;
                $rule->original_limit = null;
            } else {
                $spendingLimit = trim($this->limits[$dept->id]['spending_limit']);
                $originalLimit = trim($this->limits[$dept->id]['original_limit']);

                $rule->spending_limit = is_numeric($spendingLimit) ? (float) $spendingLimit : null;
                $rule->original_limit = is_numeric($originalLimit) ? (float) $originalLimit : null;
            }

            $rule->save();

            // AUDIT
            if ($isNew) {
                $this->logCreation($rule);
            } else {
                $this->logUpdate($rule, $oldRuleValues);
            }
        }

        session()->flash('success', '✅ Rules updated successfully for ' . $this->selectedMember->name);
        $this->dispatch('rulesSaved');
        $this->clearSelection();
    }

    /**
     * Close dropdown when clicking outside
     */
    public function closeDropdown()
    {
        $this->showDropdown = false;
    }

    public function render()
    {
        return view('livewire.family.edit-limits-and-restrictions', [
            'currentFamilyName' => $this->currentFamilyName
        ])->layout('layouts.app');
    }
}
