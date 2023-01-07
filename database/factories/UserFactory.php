<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $firstName = fake()->firstName();
        $lastName = fake()->lastName();
        $ran = fake()->randomNumber(5, false);
        $name = $firstName." ".$lastName;
        $username = $firstName.$ran;
        return [
            'username' => $username,
            'name' => $name,
            'fname' => $firstName,
            'lname' => fake()->lastName(),
            'email' => fake()->safeEmail(),
            'user_type' => fake()->randomElement(['Employee', 'Admin']),
            'status' => fake()->randomElement(['verified', 'unverified']),
            'gender' => fake()->randomElement(['male', 'female']),
            'email_verified_at' => now(),
            'password' => bcrypt('a'), // password
            'remember_token' => Str::random(10)
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
