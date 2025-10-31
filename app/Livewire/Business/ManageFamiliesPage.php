<?php

namespace App\Livewire\Business;

use Livewire\Component;
use App\Models\Family;
use App\Models\FamilyMember;
use App\Models\User;
use App\Models\Department;
use App\Models\MemberDepartmentRule;
use App\Traits\Auditable;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ManageFamiliesPage extends Component
{
    use WithPagination;
    use Auditable; // <-- use the Auditable trait

    public $search = '';
    public $letter = '';
    public $perPage = 10;

    public $showMemberModal = false;
    public $editModal = false;
    public $deleteModal = false;
    public $headSelected = false;

    public $selectedFamily;
    public $familyMembers = [];
    public $familyName;
    public $accountCode;

    public $memberDeleteIndex = null;
    public $memberToDelete = null;
    public $headValidationError = null;
    public $showAddModal = false;
    public $newFamilyName = '';
    public $newAccountCode = '';
    public $deleteError = null;

    // NEW PROPERTIES for the mandatory first member
    public $newMemberName = '';
    public $newMemberEmail = '';
    public $newMemberRfid = '';
    public function mount()
    {
        if (auth()->user()->business_role !== 'limits') {
            abort(403, 'Unauthorized access to Family Management.');
        }
    }

    public function openAddModal()
    {
        $this->resetValidation();
        $this->newFamilyName = '';
        $this->newAccountCode = '';
        // Reset new member fields
        $this->newMemberName = '';
        $this->newMemberEmail = '';
        $this->newMemberRfid = '';
        
        $this->showAddModal = true;
    }

    public function saveNewFamily()
    {
        // Validation updated: email must be unique in 'users' table
        $this->validate([
            // Family Validation
            'newFamilyName' => 'required|string|max:255|unique:families,family_name',
            'newAccountCode' => 'required|string|max:255|unique:families,account_code',
            // Member Validation (for the Head/User)
            'newMemberName' => 'required|string|max:255',
            'newMemberEmail' => 'required|string|email|max:255|unique:users,email', // <-- VALIDATED AGAINST USERS
            // RFID must be unique across all family members
            'newMemberRfid' => 'required|string|max:255|unique:family_members,rfid_code',
        ]);

        $defaultPassword = 'cpac2025'; 
        $hashedPassword = Hash::make($defaultPassword);

        // Use a database transaction to ensure all three records are created successfully
        DB::transaction(function () use ($hashedPassword) {
            
            // 1. Create the User (The Head of the Family)
            $user = User::create([
                'name' => $this->newMemberName,
                'email' => $this->newMemberEmail,
                'password' => $hashedPassword,
                'usertype' => 'faculty', // Based on your FamilyRegister reference
            ]);

            // 2. Create the Family
            $family = Family::create([
                'family_name' => $this->newFamilyName,
                'account_code' => $this->newAccountCode,
            ]);

            // AUDIT: creation of family
            $this->logCreation($family);

            // 3. Create the FamilyMember Linkage (Head)
            $member = FamilyMember::create([
                'user_id' => $user->id, // <-- LINKED TO THE NEW USER
                'family_id' => $family->id,
                'name' => $this->newMemberName,
                'email' => $this->newMemberEmail,
                'rfid_code' => $this->newMemberRfid,
                'role' => 'head',
                // Note: The password field in family_members is not needed since the user_id links to the 'users' table which holds the password. 
                // However, if the family_members table also has a password column, we can set it here for non-user members, 
                // but since this is the Head, we rely on the User record.
            ]);

            // AUDIT: creation of member
            // We only audit the Family and FamilyMember, assuming the User table auditing is handled elsewhere if needed.
            $this->logCreation($member);
            
            // NOTE: We don't log the user creation here unless the Auditable trait is configured for the User model.
            
        });


        $this->showAddModal = false;
        session()->flash('message', 'Family added successfully.');
    }

    protected $queryString = ['search', 'letter'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingLetter()
    {
        $this->resetPage();
        $this->search = '';
    }

    public function updatedSearch()
    {
        $this->letter = '';
        $this->resetPage();
    }

    public function applySearch()
    {
        $this->resetPage();
    }

    public function openShowMembersModal($id)
    {
        $this->selectedFamily = Family::with('members')->findOrFail($id);
        $this->showMemberModal = true;
    }

    public function openEditModal($id)
    {
        $this->selectedFamily = Family::with('members')->findOrFail($id);
        $this->familyName = $this->selectedFamily->family_name;
        $this->accountCode = $this->selectedFamily->account_code;

        $this->headSelected = $this->selectedFamily->members->contains('role', 'head');

        $this->familyMembers = $this->selectedFamily->members->map(function ($member) {
            return [
                'id' => $member->id,
                'name' => $member->name,
                'email' => $member->email,
                'rfid' => $member->rfid_code,
                'role' => strtolower($member->role),
            ];
        })->toArray();

        $this->editModal = true;
        $this->headValidationError = null;
    }

    public function addMemberField()
    {
        $this->familyMembers[] = [
            'id' => null,
            'name' => '',
            'email' => '',
            'rfid' => '',
            'role' => $this->headSelected ? 'member' : 'head'
        ];

        if (!$this->headSelected && end($this->familyMembers)['role'] === 'head') {
            $this->headSelected = true;
        }
    }

    public function confirmRemoveMember($index)
    {
        $this->memberToDelete = $this->familyMembers[$index]['name'];
        $this->memberDeleteIndex = $index;
    }

    // This method removes a member from the local form array only.
    // Actual DB deletions (and associated audit logs) occur in saveFamilyChanges().
    public function removeMemberConfirmed($index)
    {
        if (isset($this->familyMembers[$index])) {
            // Prevent deleting the head in the UI form
            if ($this->familyMembers[$index]['role'] === 'head') {
                $this->deleteError = "You cannot delete the Head of Family.";
                return;
            }

            // Remove from local form array
            unset($this->familyMembers[$index]);
            $this->familyMembers = array_values($this->familyMembers); // reindex
        }

        $this->memberDeleteIndex = null;
        $this->memberToDelete = null;
    }

    public function toggleHead($index)
    {
        if ($this->familyMembers[$index]['role'] === 'head') {
            $this->familyMembers[$index]['role'] = 'member';
            $this->headSelected = false;
            return;
        }

        foreach ($this->familyMembers as $i => &$member) {
            $member['role'] = ($i === $index) ? 'head' : 'member';
        }

        $this->headSelected = true;
    }

    public function saveFamilyChanges()
    {
        // Trim inputs
        $this->accountCode = trim($this->accountCode);
        $this->familyName = trim($this->familyName);

        // Basic validation (always required)
        $validationRules = [
            'familyName' => 'required|string|max:255',
            'accountCode' => 'required|string|max:255',
        ];

        // Only add member validation if there are members
        if (!empty($this->familyMembers)) {
            // Duplicate RFID check in form
            $rfids = collect($this->familyMembers)->pluck('rfid')->filter();
            if ($rfids->count() !== $rfids->unique()->count()) {
                $this->addError('familyMembers', 'Oops! There are duplicate RFID codes in your current input.');
                return;
            }

            // Collect all member IDs from the current form to exclude from RFID uniqueness check
            $currentMemberIds = collect($this->familyMembers)
                ->pluck('id')
                ->filter()
                ->toArray();

            // Add member validation rules
            $validationRules['familyMembers.*.name'] = 'required|string';
            $validationRules['familyMembers.*.email'] = 'required|email';
            $validationRules['familyMembers.*.rfid'] = [
                'required',
                'string',
                function ($attribute, $value, $fail) use ($currentMemberIds) {
                    $index = explode('.', $attribute)[1];

                    $exists = FamilyMember::where('rfid_code', $value)
                        ->when(!empty($currentMemberIds), function ($query) use ($currentMemberIds) {
                            return $query->whereNotIn('id', $currentMemberIds);
                        })
                        ->exists();

                    if ($exists) {
                        $fail('This RFID is already assigned to another member.');
                    }
                }
            ];

            // Check for head of family
            $headExists = collect($this->familyMembers)->contains(fn($member) => $member['role'] === 'head');
            if (!$headExists) {
                $this->addError('familyMembers', 'There must be one head of the family.');
                return;
            }
        }

        // Perform validation
        $this->validate($validationRules);

        $duplicateAccount = Family::where('account_code', $this->accountCode)
            ->where('id', '!=', $this->selectedFamily->id)
            ->exists();

        if ($duplicateAccount) {
            $this->addError('accountCode', 'This account code is already in use.');
            return;
        }

        // --- AUDIT: capture family original state BEFORE update ---
        $oldFamilyValues = $this->selectedFamily->getOriginal();

        // Update family (DB)
        $this->selectedFamily->update([
            'family_name' => $this->familyName,
            'account_code' => $this->accountCode
        ]);
        
        // --- AUDIT FIX: Log family update immediately here ---
        // We log the family changes now, before processing members, to ensure they are captured.
        $this->logUpdate($this->selectedFamily, $oldFamilyValues);
        // -----------------------------------------------------

        // --- Process members: updates & creates ---
        $existingIds = [];

        foreach ($this->familyMembers as $memberData) {
            if (isset($memberData['id'])) {
                // Update existing member
                $member = FamilyMember::find($memberData['id']);
                if ($member) {
                    $oldMemberValues = $member->getOriginal();

                    $member->update([
                        'name' => $memberData['name'],
                        'email' => $memberData['email'],
                        'rfid_code' => $memberData['rfid'],
                        'role' => strtolower($memberData['role']),
                    ]);

                    $existingIds[] = $member->id;

                    // AUDIT: update member (trait will log only if changes exist)
                    $this->logUpdate($member, $oldMemberValues);
                }
            } else {
                // Create new member
                $new = $this->selectedFamily->members()->create([
                    'name' => $memberData['name'],
                    'email' => $memberData['email'],
                    'rfid_code' => $memberData['rfid'],
                    'role' => strtolower($memberData['role']),
                ]);
                $existingIds[] = $new->id;

                // AUDIT: creation of new member
                $this->logCreation($new);
            }
        }

        // --- Handle deletions (members present in DB but removed in the form) ---
        $toDelete = $this->selectedFamily->members()->whereNotIn('id', $existingIds)->get();

        if ($toDelete->isNotEmpty()) {
            foreach ($toDelete as $deletedMember) {
                // AUDIT: log deletion BEFORE actual delete
                $this->logDeletion($deletedMember);
            }

            // Actually delete them
            $this->selectedFamily->members()->whereNotIn('id', $existingIds)->delete();
        }

        // --- OLD AUDIT LOCATION REMOVED HERE ---

        $this->editModal = false;
        $this->headValidationError = null;
        session()->flash('message', 'Family updated successfully.');
    }

    public function confirmDelete($id)
    {
        $this->selectedFamily = Family::findOrFail($id);
        $this->deleteModal = true;
    }

    public function deleteFamily()
    {
        // Capture members and family state for audit before delete
        $members = $this->selectedFamily->members()->get();

        if ($members->isNotEmpty()) {
            foreach ($members as $m) {
                // AUDIT: log each member deletion
                $this->logDeletion($m);
            }
        }

        // AUDIT: log family deletion BEFORE the actual deletion
        $this->logDeletion($this->selectedFamily);

        // Delete from DB
        $this->selectedFamily->members()->delete();
        $this->selectedFamily->delete();

        $this->deleteModal = false;
        session()->flash('message', 'Family deleted successfully.');
    }

    public function render()
    {
        $families = Family::with('members')
            ->when($this->search, fn($query) =>
                $query->where('family_name', 'like', '%' . $this->search . '%')
            )
            ->when($this->letter && !$this->search, fn($query) =>
                $query->where('family_name', 'like', $this->letter . '%')
            )
            ->orderBy('family_name')
            ->paginate($this->perPage)
            ->withQueryString();

        return view('livewire.business.manage-families-page', [
            'families' => $families,
        ])->layout('layouts.app');
    }
}
