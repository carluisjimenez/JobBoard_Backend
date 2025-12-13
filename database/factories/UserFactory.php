<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('password123'),
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'role' => $this->faker->randomElement([User::ROLE_CANDIDATE, User::ROLE_RECRUITER]),
        ];
    }
}
