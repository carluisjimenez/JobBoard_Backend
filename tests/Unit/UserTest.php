<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_create_a_user(): void
    {
        $user = User::factory()->create([
            'role' => User::ROLE_CANDIDATE
        ]);

        $this->assertDatabaseHas('users', ['email' => $user->email]);
    }

    public function test_it_can_identify_as_candidate(): void
    {
        $user = User::factory()->create(['role' => User::ROLE_CANDIDATE]);

        $this->assertTrue($user->isCandidate());
        $this->assertFalse($user->isRecruiter());
    }

    public function test_it_can_identify_as_recruiter(): void
    {
        $user = User::factory()->create(['role' => User::ROLE_RECRUITER]);

        $this->assertTrue($user->isRecruiter());
        $this->assertFalse($user->isCandidate());
    }
}
