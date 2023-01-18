<?php

namespace Database\Seeders;

use App\Models\Office;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OfficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Office::factory()->create([
            'code' => 'GE',
            'description' => 'General Education',
            'department' => 'TCH',
            'color' => 'rgb('. fake()->numberBetween(0, 255).','. fake()->numberBetween(0, 255). ',' . fake()->numberBetween(0, 255) . ')'
        ]);

        Office::factory()->create([
            'code' => 'MAP',
            'description' => 'Math and Applied Physics Department',
            'department' => 'TCH',
            'color' => 'rgb(' . fake()->numberBetween(0, 255) . ',' . fake()->numberBetween(0, 255) . ',' . fake()->numberBetween(0, 255) . ')'
        ]);

        Office::factory()->create([
            'code' => 'PSY',
            'description' => 'Psychology Department',
            'department' => 'TCH',
            'color' => 'rgb(' . fake()->numberBetween(0, 255) . ',' . fake()->numberBetween(0, 255) . ',' . fake()->numberBetween(0, 255) . ')'
        ]);

        Office::factory()->create([
            'code' => 'ARC',
            'description' => 'Architecture',
            'department' => 'TCH',
            'color' => 'rgb(' . fake()->numberBetween(0, 255) . ',' . fake()->numberBetween(0, 255) . ',' . fake()->numberBetween(0, 255) . ')'
        ]);

        Office::factory()->create([
            'code' => 'ITE',
            'description' => 'Information Technology Education Department',
            'department' => 'TCH',
            'color' => 'rgb(' . fake()->numberBetween(0, 255) . ',' . fake()->numberBetween(0, 255) . ',' . fake()->numberBetween(0, 255) . ')'
        ]);

        Office::factory()->create([
            'code' => 'CED',
            'description' => 'BSE - Mathematics Department',
            'department' => 'TCH',
            'color' => 'rgb(' . fake()->numberBetween(0, 255) . ',' . fake()->numberBetween(0, 255) . ',' . fake()->numberBetween(0, 255) . ')'
        ]);

        Office::factory()->create([
            'code' => 'CCJE',
            'description' => 'College of Criminal Justice Education',
            'department' => 'TCH',
            'color' => 'rgb(' . fake()->numberBetween(0, 255) . ',' . fake()->numberBetween(0, 255) . ',' . fake()->numberBetween(0, 255) . ')'
        ]);

        Office::factory()->create([
            'code' => 'HR',
            'description' => 'HR Office',
            'department' => 'HR',
            'color' => 'rgb(' . fake()->numberBetween(0, 255) . ',' . fake()->numberBetween(0, 255) . ',' . fake()->numberBetween(0, 255) . ')'
        ]);

        Office::factory()->create([
            'code' => 'ACCT',
            'description' => 'Accounting Office',
            'department' => 'ACCT',
            'color' => 'rgb(' . fake()->numberBetween(0, 255) . ',' . fake()->numberBetween(0, 255) . ',' . fake()->numberBetween(0, 255) . ')'
        ]);

        Office::factory()->create([
            'code' => 'IT',
            'description' => 'IT Office',
            'department' => 'IT',
            'color' => 'rgb(' . fake()->numberBetween(0, 255) . ',' . fake()->numberBetween(0, 255) . ',' . fake()->numberBetween(0, 255) . ')'
        ]);

        Office::factory()->create([
            'code' => 'MO',
            'description' => 'Maintenance Office',
            'department' => 'MTC',
            'color' => 'rgb(' . fake()->numberBetween(0, 255) . ',' . fake()->numberBetween(0, 255) . ',' . fake()->numberBetween(0, 255) . ')'
        ]);
    }
}
