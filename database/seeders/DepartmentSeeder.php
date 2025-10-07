<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // database/seeders/DepartmentSeeder.php

    public function run()
    {
        $departments = [
            ['name' => 'CPAC Store'],
            ['name' => 'FastFood'],
            ['name' => 'Cafeteria'],
            ['name' => 'Laundry (Wise Wash)'],
            ['name' => 'CPAC Refilling Station'],
            ['name' => 'Garden'],
        ];

        DB::table('departments')->insert($departments);
    }
}
