<?php

namespace Tests\Unit;

use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use App\Models\JobApplication;
use App\Models\JobOffer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class JobApplicationTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_create_a_job_application()
    {

        $user = User::factory()->create();
        $jobOffer = JobOffer::factory()->create();


        $application = JobApplication::create([
            'user_id' => $user->id,
            'job_offer_id' => $jobOffer->id,
            'message' => 'Me interesa mucho esta posición',
            'status' => 'pending',
        ]);

        $this->assertDatabaseHas('job_applications', [
            'id' => $application->id,
            'user_id' => $user->id,
            'job_offer_id' => $jobOffer->id,
            'message' => 'Me interesa mucho esta posición',
            'status' => 'pending',
        ]);
    }

    #[Test]
    public function job_application_belongs_to_job_offer()
    {
        $jobOffer = JobOffer::factory()->create();
        $application = JobApplication::factory()->create(['job_offer_id' => $jobOffer->id]);

        $this->assertInstanceOf(JobOffer::class, $application->jobOffer);
        $this->assertEquals($jobOffer->id, $application->jobOffer->id);
    }

    #[Test]
    public function job_application_belongs_to_user()
    {
        $user = User::factory()->create();
        $application = JobApplication::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $application->user);
        $this->assertEquals($user->id, $application->user->id);
    }
}
