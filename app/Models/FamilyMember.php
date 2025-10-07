<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FamilyMember extends Model
{
    use HasFactory;

    protected $fillable = ['family_id', 'name', 'rfid_code', 'email', 'role'];

    public function family()
    {
        return $this->belongsTo(Family::class);
    }

    public function rules()
    {
        return $this->hasMany(MemberDepartmentRule::class);
    }

    public function charges()
    {
        return $this->hasMany(Charge::class);
    }
    public function getFullNameAttribute()
    {
        return $this->name;
    }
    public function auditLogs()
    {
        return $this->morphMany(AuditLog::class, 'auditable');
    }
}
