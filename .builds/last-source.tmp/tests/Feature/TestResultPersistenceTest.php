<?php

namespace Tests\Feature;

use App\Models\RecommendedRoutine;
use App\Models\Routine;
use App\Models\Type;
use App\Models\User;
use App\Models\UserTestResult;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TestResultPersistenceTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_updates_existing_test_result_instead_of_creating_a_duplicate(): void
    {
        $user = User::factory()->create();
        Type::create(['name' => 'Skincare']);

        RecommendedRoutine::create([
            'test_key' => 'piel',
            'result_key' => 'sensible',
            'name' => 'Rutina recomendada',
            'description' => 'Descripción',
            'frequency' => 'diaria',
            'time_of_day' => 'mañana',
            'products' => json_encode([]),
        ]);

        $existingResult = UserTestResult::create([
            'user_id' => $user->id,
            'routine_id' => null,
            'test_key' => 'piel',
            'result_key' => 'normal',
            'answers' => json_encode(['q1' => 'normal']),
        ]);

        $this->actingAs($user)
            ->post(route('tests.saveResult'), [
                'test_key' => 'piel',
                'result_key' => 'sensible',
                'answers' => ['q1' => 'sensible'],
            ])
            ->assertRedirect(route('profile.results'));

        $this->assertEquals(1, UserTestResult::where('user_id', $user->id)->where('test_key', 'piel')->count());
        $this->assertDatabaseHas('user_test_results', [
            'id' => $existingResult->id,
            'user_id' => $user->id,
            'test_key' => 'piel',
            'result_key' => 'sensible',
            'answers' => json_encode(['q1' => 'sensible']),
        ]);
        $this->assertEquals(1, Routine::where('user_id', $user->id)->count());
    }
}
