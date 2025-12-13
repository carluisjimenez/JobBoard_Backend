<?php

namespace Database\Factories;

use App\Models\JobApplication;
use App\Models\User;
use App\Models\JobOffer;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobApplicationFactory extends Factory
{
    protected $model = JobApplication::class;

    public function definition()
    {
        return [
            'user_id'      => User::factory(),
            'job_offer_id' => JobOffer::factory(),
            'message'      => $this->faker->text(200),
            'status'       => 'pending',
        ];
    }
}
