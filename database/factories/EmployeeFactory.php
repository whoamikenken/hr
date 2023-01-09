<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $gender = fake()->randomElement(['Male', 'Female']);
        $firstName = fake()->firstName();
        $middleName = fake()->lastName($gender);
        $lastName = fake()->lastName($gender);
        $employeeID = fake()->randomNumber(2, false) . "-" . fake()->randomNumber(4, false);
        $email = fake()->freeEmail();

        User::factory()->create([
            'username' => $employeeID,
            'name' => $firstName." ". $middleName." ".$lastName,
            'fname' => $firstName,
            'lname' => $lastName,
            'email' => $email,
            'user_type' => 'Employee',
            'status' => 'verified',
            'email_verified_at' => now(),
            'password' => bcrypt('a'), // password
            'read' => "1,2,3,803,804,8,9,10,11,12,6,7",
            'add' => "1,2,3,4,7,8,9,10,11,14,15,16,12",
            'delete' => "1,2,3,4,7,8,9,10,11,14,15,16,12",
            'edit' => "1,2,3,803,804,8,9,10,11,12,6,7",
            'remember_token' => Str::random(10)
        ]);

        return [
            'employee_id' => $employeeID,
            'employee_code' => fake()->randomNumber(6, false),
            'fname' => $firstName,
            'lname' => $middleName,
            'mname' => $lastName,
            'contact' => "+639" . fake()->randomNumber(9, true),
            'email' => $email,
            'age' => fake()->randomNumber(2, false),
            'address' => fake()->streetAddress() . " " . fake()->cityPrefix(),
            'family_contact_name' => fake()->firstName($gender) . " " . fake()->lastName($gender),
            'family_contact' => fake()->e164PhoneNumber(),
            'date_applied' => Carbon::createFromTimestamp(rand(strtotime("2022-01-01"), strtotime("2022-11-10")))->format('Y-m-d'),
            'gender' => $gender,
            'isactive' => fake()->randomElement(['Active', 'Inactive']),
            'office' => fake()->randomElement(['IT','MO', 'ACCT', 'HR','CCJE','CED', 'ITE','ARC','PSY','MAP', 'GE']),
            'department' => fake()->randomElement(['IT','HR', 'MTC', 'TCH', 'ACCT']),
        ];
    }
}
