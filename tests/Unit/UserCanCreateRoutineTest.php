<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Routine;

class UserCanCreateRoutineTest extends TestCase
{
    use RefreshDatabase;

    public function test_premium_user_can_create_unlimited_routines()
    {
        $user = User::factory()->create(['role' => 'premium']);

        // create 5 routines
        for ($i = 0; $i < 5; $i++) {
            Routine::create(['name' => "Rutina $i", 'user_id' => $user->id]);
        }

        $this->assertTrue($user->fresh()->canCreateRoutine());
    }

    public function test_free_user_cannot_create_more_than_two_routines()
    {
        $user = User::factory()->create(['role' => 'free']);

        Routine::create(['name' => 'A', 'user_id' => $user->id]);
        Routine::create(['name' => 'B', 'user_id' => $user->id]);

        $this->assertFalse($user->fresh()->canCreateRoutine());
    }

    public function test_free_user_can_create_when_under_limit()
    {
        $user = User::factory()->create(['role' => 'free']);

        Routine::create(['name' => 'A', 'user_id' => $user->id]);

        $this->assertTrue($user->fresh()->canCreateRoutine());
    }
}
