<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MemberDepartmentRule;

class MemberDepartmentRuleSeeder extends Seeder
{
    public function run(): void
    {
        MemberDepartmentRule::create([
            'family_member_id' => 1, // Rich
            'department_id' => 1,    // Store
            'spending_limit' => 1000,
            'original_limit' => 1000,
            'is_restricted' => false,
        ]);

        MemberDepartmentRule::create([
            'family_member_id' => 2, // Gwen
            'department_id' => 2,    // Fastfood
            'spending_limit' => 500,
            'original_limit' => 500,
            'is_restricted' => false,
        ]);

        MemberDepartmentRule::create([
            'family_member_id' => 3, // Beejay
            'department_id' => 3,    // Cafeteria
            'spending_limit' => 0,
            'original_limit' => 0,
            'is_restricted' => true,
        ]);
    }
}