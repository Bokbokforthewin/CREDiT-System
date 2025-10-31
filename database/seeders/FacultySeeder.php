<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Bernardino Test',
            'email' => 'bernardino@gmail.com',
            'password' => Hash::make('qweqweqwe'),
            'usertype' => 'faculty',
        ]);
    }
}
