<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Department;

class DepartmentPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function access(User $user, Department $department)
    {
        return $user->isAdmin() || 
               $user->isBusinessOffice() || 
               $user->department_id === $department->id;
    }
}
