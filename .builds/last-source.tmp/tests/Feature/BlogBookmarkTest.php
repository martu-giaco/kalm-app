<?php

namespace Tests\Feature;

use App\Models\Blog;
use App\Models\Type;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlogBookmarkTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_save_and_view_bookmarked_blogs(): void
    {
        $user = User::factory()->create();
        $type = Type::create(['name' => 'Skincare']);
        $blog = Blog::create([
            'title' => 'Blog guardado',
            'description' => 'Descripción del blog',
            'content' => 'Contenido del blog',
            'author' => 'Autor',
            'type_id' => $type->id,
            'is_premium' => false,
        ]);

        $this->actingAs($user);

        $response = $this->postJson(route('blog.bookmark', $blog));
        $response->assertOk()
            ->assertJsonPath('bookmarked', true);

        $this->assertContains((string) $blog->id, array_map('strval', $user->fresh()->bookmarked_blogs ?? []));

        $viewResponse = $this->get(route('blog.bookmarks'));
        $viewResponse->assertOk();
        $viewResponse->assertSee($blog->title);
    }
}
