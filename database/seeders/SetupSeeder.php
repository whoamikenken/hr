<?php

namespace Database\Seeders;

use App\Models\Setup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SetupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Setup::factory()->create([
            'description' => 'Campus',
            'table' => 'campuses'
        ]);

        Setup::factory()->create([
            'description' => 'Course',
            'table' => 'courses'
        ]);

        Setup::factory()->create([
            'description' => 'Section',
            'table' => 'sections'
        ]);

        Setup::factory()->create([
            'description' => 'Year Level',
            'table' => 'yearlevels'
        ]);

        Setup::factory()->create([
            'description' => 'Subject',
            'table' => 'subjects'
        ]);

        Setup::factory()->create([
            'description' => 'Annoucement',
            'table' => 'announcements'
        ]);

        Setup::factory()->create([
            'description' => 'Schedule',
            'table' => 'schedules'
        ]);

        Setup::factory()->create([
            'description' => 'Batch Schedule',
            'table' => 'batch_schedules'
        ]);
    }
}
