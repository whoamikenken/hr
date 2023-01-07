<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Department::factory()->create([
            'code' => 'HR',
            'description' => 'Human Resource',
        ]);

        Department::factory()->create([
            'code' => 'ACCT',
            'description' => 'Accounting Department',
        ]);

        Department::factory()->create([
            'code' => 'IT',
            'description' => 'IT Department',
        ]);

        Department::factory()->create([
            'code' => 'MTC',
            'description' => 'Maintenance',
        ]);

        Department::factory()->create([
            'code' => 'TCH',
            'description' => 'Teaching Department',
        ]);

    }
}
