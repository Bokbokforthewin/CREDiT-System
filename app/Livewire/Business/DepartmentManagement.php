<?php

namespace App\Livewire\Business;

use Livewire\Component;
use App\Models\Department;
use Illuminate\Validation\Rule; // Import for unique validation with ignore
use Carbon\Carbon; // This was already here, good.
use App\Traits\Auditable; // <-- ADDED: Import the Auditable trait

class DepartmentManagement extends Component
{
    use Auditable; // <-- ADDED: Use the Auditable trait

    // Properties for adding a new department
    public $newDepartmentName = '';
    public $showAddDepartmentModal = false;

    // Properties for editing a department
    public $editingDepartmentId = null;
    public $editingDepartmentName = '';
    public $showEditDepartmentModal = false; // Using the same modal, so can simplify this later if desired

    // Properties for deleting a department
    public $deletingDepartmentId = null;
    public $showDeleteConfirmationModal = false;

    // Mounted lifecycle hook (unchanged from your last provided code)
    public function mount()
    {
        // Example authorization check
        if (auth()->user()->usertype !== 'business_office' && auth()->user()->business_role !== 'limits') {
            abort(403, 'Unauthorized access to Department Management.');
        }
    }

    // Computed property to fetch all departments
    public function getDepartmentsProperty()
    {
        return Department::orderBy('name')->get();
    }

    // --- Add Department Logic ---
    public function openAddDepartmentModal()
    {
        $this->reset(['newDepartmentName', 'editingDepartmentId', 'editingDepartmentName']); // Reset any editing state
        $this->showAddDepartmentModal = true;
    }

    public function saveDepartment()
    {
        $this->validate([
            'newDepartmentName' => 'required|string|unique:departments,name|max:255',
        ]);

        // Perform creation and capture the instance
        $department = Department::create([
            'name' => $this->newDepartmentName,
        ]);

        // AUDIT LOGGING: Log the creation
        $this->logCreation($department);

        $this->reset(['newDepartmentName', 'showAddDepartmentModal']);
        $this->dispatch('notify', type: 'success', message: 'Department added successfully!');
    }

    // --- Edit Department Logic ---
    public function editDepartment($departmentId)
    {
        $department = Department::findOrFail($departmentId);
        $this->editingDepartmentId = $department->id;
        $this->editingDepartmentName = $department->name;
        $this->showAddDepartmentModal = true; // Use the same modal for add/edit
    }

    public function updateDepartment()
    {
        $this->validate([
            'editingDepartmentName' => [
                'required',
                'string',
                'max:255',
                // Ensure unique name, but ignore the current department's name
                Rule::unique('departments', 'name')->ignore($this->editingDepartmentId),
            ],
        ]);

        $department = Department::findOrFail($this->editingDepartmentId);
        
        // AUDIT LOGGING: Capture the old values BEFORE the update
        $oldValues = $department->getOriginal(); 
        
        $department->update(['name' => $this->editingDepartmentName]);

        // AUDIT LOGGING: Log the update, providing the department model and old values
        $this->logUpdate($department, $oldValues);

        $this->reset(['editingDepartmentId', 'editingDepartmentName', 'showAddDepartmentModal']);
        $this->dispatch('notify', type: 'success', message: 'Department updated successfully!');
    }

    // --- Delete Department Logic ---
    public function confirmDelete($departmentId)
    {
        $this->deletingDepartmentId = $departmentId;
        $this->showDeleteConfirmationModal = true;
    }

    public function deleteDepartment()
    {
        if ($this->deletingDepartmentId) {
            $department = Department::findOrFail($this->deletingDepartmentId);
            $departmentName = $department->name; // Capture name for notification
            
            // AUDIT LOGGING: Log the deletion BEFORE the record is destroyed
            $this->logDeletion($department); 
            
            $department->delete();

            $this->reset(['deletingDepartmentId', 'showDeleteConfirmationModal']);
            $this->dispatch('notify', type: 'success', message: "Department '{$departmentName}' deleted successfully!");
        }
    }

    public function cancelDelete()
    {
        $this->reset(['deletingDepartmentId', 'showDeleteConfirmationModal']);
    }

    // Common reset method for all modals (optional, but good for cleanliness)
    public function resetModalState()
    {
        $this->reset([
            'newDepartmentName',
            'showAddDepartmentModal',
            'editingDepartmentId',
            'editingDepartmentName',
            'deletingDepartmentId',
            'showDeleteConfirmationModal',
        ]);
    }

    public function render()
    {
        return view('livewire.business.department-management', [
            'departments' => $this->departments, // Pass the computed property to the view
        ])->layout('layouts.app');
    }
}
