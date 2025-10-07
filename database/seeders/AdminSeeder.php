<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'MIS Admin',
            'email' => 'admin@cpac.edu.ph',
            'password' => Hash::make('cpacadmin'),
            'usertype' => 'admin',
        ]);
    }
}