<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\JobOffer;
use Illuminate\Foundation\Testing\RefreshDatabase;

class JobOfferTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_create_a_job_offer(): void
    {
        $user = User::factory()->create();

        $offer = JobOffer::create([
            'job_title' => 'Laravel Developer',
            'description' => 'We need a Laravel dev',
            'location' => 'Remote',
            'salary' => 1000,
            'category' => 'IT',
            'user_id' => $user->id
        ]);

        $this->assertDatabaseHas('job_offers', [
            'job_title' => 'Laravel Developer',
            'user_id' => $user->id
        ]);
    }

    public function test_it_belongs_to_a_user(): void
    {
        $user = User::factory()->create();
        $offer = JobOffer::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $offer->user);
        $this->assertEquals($user->id, $offer->user->id);
    }
}
