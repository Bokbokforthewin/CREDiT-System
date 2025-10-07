<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Department;


class MemberDepartmentRule extends Model
{
    use HasFactory;

    protected $fillable = [
        'family_member_id',
        'department_id',
        'spending_limit',
        'original_limit', // ✅ Add this
        'is_restricted'
    ];

    public function member()
    {
        return $this->belongsTo(FamilyMember::class, 'family_member_id');
    }
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
    public function auditLogs()
    {
        return $this->morphMany(AuditLog::class, 'auditable');
    }
}
