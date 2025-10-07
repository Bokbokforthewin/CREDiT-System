<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Family;

class FamilySeeder extends Seeder
{
    public function run(): void
    {
        Family::create(['family_name' => 'Bernardino', 'account_code' => 'BDN_01']);
        Family::create(['family_name' => 'Villan',  'account_code' => 'VLN_02']);
    }
}
