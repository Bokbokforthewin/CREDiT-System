<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Family extends Model
{
    use HasFactory;

    protected $fillable = ['family_name','account_code','user_id'];

    public function members()
    {
        return $this->hasMany(FamilyMember::class);
    }

    public function charges()
    {
        return $this->hasMany(\App\Models\Charge::class);
    }
    public function auditLogs()
    {
        return $this->morphMany(AuditLog::class, 'auditable');
    }
}
