<?php

namespace Database\Factories;

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
        $firstName = fake()->firstName();
        $gender = fake()->randomElement(['Male', 'Female']);
        return [
            'employee_id' => fake()->randomNumber(2, false)."-".fake()->randomNumber(4, false),
            'employee_code' => fake()->randomNumber(6, false),
            'fname' => $firstName,
            'lname' => fake()->lastName($gender),
            'mname' => fake()->lastName($gender),
            'contact' => "+639" . fake()->randomNumber(9, true),
            'email' => fake()->freeEmail(),
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
