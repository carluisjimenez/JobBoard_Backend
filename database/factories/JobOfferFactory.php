<?php

namespace Database\Factories;

use App\Models\JobOffer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobOfferFactory extends Factory
{
    protected $model = JobOffer::class;

    public function definition()
    {
        return [
            'job_title' => $this->faker->jobTitle(),
            'description' => $this->faker->paragraph(),
            'location' => $this->faker->city(),
            'salary' => $this->faker->numberBetween(3000, 10000),
            'category' => $this->faker->word(),
            'user_id' => User::factory(),
        ];
    }
}
