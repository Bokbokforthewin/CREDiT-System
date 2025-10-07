<?php

namespace App\Livewire\Business;

use Livewire\Component;
use App\Models\Family;
use App\Models\FamilyMember;
use App\Models\Department;
use App\Models\MemberDepartmentRule;
use App\Traits\Auditable; // <-- Added trait import

class LimitsAndRestrictions extends Component
{
    use Auditable; // <-- Added trait usage

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
     * Load all members
     */
    public function loadMembers()
    {
        $this->members = FamilyMember::with(['rules', 'family'])->get();
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

        // Search both by member name and family name
        $memberResults = $this->members->filter(function ($member) {
            return str_contains(strtolower($member->name), strtolower($this->limitSearch));
        });

        $familyResults = Family::where('family_name', 'like', '%' . $this->limitSearch . '%')
            ->with('members')
            ->get()
            ->flatMap(function ($family) {
                return $family->members;
            });

        $this->searchResults = $memberResults->merge($familyResults)->unique('id')->take(8);
        $this->showDropdown = $this->searchResults->isNotEmpty();
    }

    /**
     * Select a member from dropdown
     */
    public function selectMember($memberId)
    {
        $this->selectedMemberId = $memberId;
        $this->selectedMember = FamilyMember::with(['rules', 'family'])->find($memberId);
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

        foreach ($this->departments as $dept) {
            $rule = MemberDepartmentRule::firstOrNew([
                'family_member_id' => $this->selectedMemberId,
                'department_id' => $dept->id
            ]);

            // Capture initial state before modification
            $isNew = !$rule->exists;
            $oldRuleValues = $rule->exists ? $rule->getOriginal() : [];
            
            $isRestricted = $this->restrictions[$dept->id] ?? false;
            
            $rule->is_restricted = $isRestricted;

            if ($isRestricted) {
                $rule->spending_limit = null;
                $rule->original_limit = null;
            } else {
                // FIX: Explicitly cast input to float or null to ensure change detection works reliably
                $spendingLimit = trim($this->limits[$dept->id]['spending_limit']);
                $originalLimit = trim($this->limits[$dept->id]['original_limit']);

                // If the trimmed input is numeric, cast to float; otherwise, set to null.
                $rule->spending_limit = is_numeric($spendingLimit) ? (float) $spendingLimit : null;
                $rule->original_limit = is_numeric($originalLimit) ? (float) $originalLimit : null;
            }

            $rule->save();

            // AUDIT: Log the rule creation or update
            if ($isNew) {
                // Log creation of a new limit/restriction rule
                $this->logCreation($rule);
            } else {
                // Log update to an existing rule (limit change, restriction status change, or limit removal)
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
        return view('livewire.business.limits-and-restrictions')
            ->layout('layouts.app');
    }
}
