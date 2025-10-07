<?php

namespace App\Livewire\Business;

use App\Models\AuditLog;
use Livewire\Component;
use Livewire\WithPagination;

class AuditSection extends Component
{
    use WithPagination;

    // Filters for the audit log
    public $filters = [
        'search' => '',         // For searching user name or action
        'action_type' => '',    // e.g., 'created', 'updated'
        'model_type' => '',     // e.g., 'Charge', 'Family'
    ];
    
    // List of models available for filtering in the UI
    public $availableModels = [
        'Charge', 
        'Family', 
        'FamilyMember', 
        'Department', 
        'MemberDepartmentRule'
    ];

    /**
     * Resets pagination when any filter changes to ensure the user sees results.
     */
    public function updatingFilters()
    {
        $this->resetPage();
    }

    /**
     * Main query method to fetch, filter, and paginate audit logs.
     */
    public function getAuditLogs()
    {
        // Start the query, eager loading the 'user' relationship for performance
        $query = AuditLog::query()
            ->with('user'); 

        // --- Apply Model Type Filter ---
        if (!empty($this->filters['model_type'])) {
            // Converts simple name 'Charge' to its fully qualified class name 'App\Models\Charge'
            $modelClass = "App\\Models\\" . $this->filters['model_type'];
            $query->where('auditable_type', $modelClass);
        }

        // --- Apply Action Type Filter ---
        if (!empty($this->filters['action_type'])) {
            $query->where('action', $this->filters['action_type']);
        }
        
        // --- Apply Search Filter (User Name or Action) ---
        if (!empty($this->filters['search'])) {
            $searchTerm = '%' . $this->filters['search'] . '%';
            $query->where(function ($q) use ($searchTerm) {
                // Search for the action type
                $q->where('action', 'like', $searchTerm)
                  // Search user who performed the action
                  ->orWhereHas('user', function ($r) use ($searchTerm) {
                      $r->where('name', 'like', $searchTerm);
                  });
            });
        }

        // Sort by newest first and paginate results
        return $query->orderBy('created_at', 'desc')->paginate(10);
    }

    public function render()
    {
        return view('livewire.business.audit-section', [
            'logs' => $this->getAuditLogs(),
            ])->layout('layouts.app');
    }
}
