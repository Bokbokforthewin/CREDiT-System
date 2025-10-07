<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Family;
use App\Models\FamilyMember;

class FamilyMemberSeeder extends Seeder
{
    public function run(): void
    {
        $bernardino = Family::where('family_name', 'Bernardino')->first();
        $villan = Family::where('family_name', 'Villan')->first();

        FamilyMember::create([
            'family_id' => $bernardino->id,
            'name' => 'Lowell Rich Bernardino',
            'rfid_code' => 'RFID123456',
            'email' => null,
            'role' => 'member',
        ]);

        FamilyMember::create([
            'family_id' => $bernardino->id,
            'name' => 'Gwen Bernardino',
            'rfid_code' => 'RFID654321',
            'email' => 'lowellrich123@gmail.com',
            'role' => 'head',
        ]);

        FamilyMember::create([
            'family_id' => $villan->id,
            'name' => 'Beejay Villan',
            'rfid_code' => 'RFID987654',
            'email' => 'lowellrich123@gmail.com',
            'role' => 'head',
        ]);
    }
}