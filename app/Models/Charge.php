<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Charge extends Model
{
    use HasFactory;

    protected $fillable = [
        'charge_datetime',
        'description',
        'price',
        'user_id',
        'family_id',
        'family_member_id',
        'department_id',
    ];

    public function member()
    {
        return $this->belongsTo(FamilyMember::class, 'family_member_id');
    }

    public function family()
    {
        return $this->belongsTo(Family::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function chargedBy()
    {
        return $this->belongsTo(\App\Models\User::class, 'charged_by');
    }
    public function auditLogs()
    {
        return $this->morphMany(AuditLog::class, 'auditable');
    }
}
