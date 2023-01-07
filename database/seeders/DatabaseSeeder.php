<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Models\Branch;
use App\Models\Jobsite;
use App\Models\Medical;
use App\Models\Student;
use App\Models\Location;
use App\Models\Applicant;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Database\Seeders\LocationSeeder;
use App\Http\Controllers\SubjectController;
use App\Models\Employee;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'username' => "admin",
            'name' => "Juan Dela Cruz",
            'fname' => "Juan",
            'lname' => "Cruz",
            'email' => "test@gmail.com",
            'user_type' => 'Admin',
            'status' => 'verified',
            'email_verified_at' => now(),
            'password' => bcrypt('a'), // password
            'read' => "1,2,3,803,804,8,9,10,11,12,6,7",
            'add' => "1,2,3,4,7,8,9,10,11,14,15,16,12",
            'delete' => "1,2,3,4,7,8,9,10,11,14,15,16,12",
            'edit' => "1,2,3,803,804,8,9,10,11,12,6,7",
            'remember_token' => Str::random(10)
        ]);

        $this->call([
            MenuSeeder::class,
            TablecolumnSeeder::class,
            SetupSeeder::class,
            OfficeSeeder::class,
            DepartmentSeeder::class,
            UsertypeSeeder::class
        ]);

        User::factory(50)->create();
        Employee::factory(100)->create();
    }
}
