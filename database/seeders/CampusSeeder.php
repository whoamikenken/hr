<?php

namespace Database\Seeders;

use App\Models\Campus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CampusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Campus::factory()->create([
            'code' => 'MNL',
            'description' => 'Manila',
            'created_by' => 1,
            'color' => 'rgb(234, 255, 5)', 
        ]);

        Campus::factory()->create([
            'code' => 'CVT',
            'description' => 'Cavite',
            'color' => 'rgb(234, 255, 5)', 
            'created_by' => 1,
        ]);
    }
}
