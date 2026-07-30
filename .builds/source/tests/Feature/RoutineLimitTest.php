<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Routine;

class RoutineLimitTest extends TestCase
{
    use RefreshDatabase;

    public function test_free_user_gets_modal_block_and_store_rejected_when_exceeding_limit()
    {
        $user = User::factory()->create(['role' => 'free']);

        // Act as user and create two routines successfully via POST
        $this->actingAs($user)
            ->post(route('routines.store'), ['name' => 'R1'])
            ->assertRedirect(route('routines.index'))
            ->assertSessionHas('feedback');

        $this->actingAs($user)
            ->post(route('routines.store'), ['name' => 'R2'])
            ->assertRedirect(route('routines.index'))
            ->assertSessionHas('feedback');

        // Third attempt should be rejected
        $this->actingAs($user)
            ->post(route('routines.store'), ['name' => 'R3'])
            ->assertRedirect(route('routines.index'))
            ->assertSessionHas('feedback')
            ->assertSessionHas('feedback.type', 'error');
    }

    public function test_create_button_uses_flag_from_controller()
    {
        $user = User::factory()->create(['role' => 'free']);
        $this->actingAs($user)
            ->get(route('routines.index'))
            ->assertOk()
            ->assertViewHas('canCreate');
    }
}
