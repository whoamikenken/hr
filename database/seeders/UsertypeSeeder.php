<?php

namespace Database\Seeders;

use App\Models\Usertype;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsertypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Usertype::factory()->create([
            'code' => 'Admin',
            'description' => 'Administrator has all the permission on modules',
            'modified_by' => 1,
            'read' => "1,2,3,4,7,8,9,10,11,14,15,16,12,13",
            'add' => "1,2,3,4,7,8,9,10,11,14,15,16,12,13",
            'delete' => "1,2,3,4,7,8,9,10,11,14,15,16,12,13",
            'edit' => "1,2,3,4,7,8,9,10,11,14,15,16,12,13",
            'created_by' => 1,
        ]);

        Usertype::factory()->create([
            'code' => 'Student',
            'description' => 'Student account to create schedule',
            'modified_by' => 1,
            'created_by' => 1,
        ]);

        Usertype::factory()->create([
            'code' => 'Professor',
            'description' => 'professor account to approve student schedule request',
            'modified_by' => 1,
            'created_by' => 1,
        ]);
    }
}
