<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    // Mostrar formulario de creación
    public function create()
    {
        return view('posts.create');
    }

    // Guardar post
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|max:280',
            'image' => 'nullable|image|max:2048',
            'category' => 'nullable|string|max:50',
        ]);

        $post = new Post();
        $post->user_id = auth()->id();
        $post->content = $request->content;
        $post->category = $request->category ?? 'general';
        $post->is_deleted = false;

        if ($request->hasFile('image')) {
            $post->image = $request->file('image')->store('posts', 'public');
        }

        $post->save();

        return redirect()->route('home')->with('success', 'Post creado correctamente!');
    }

    // Feed de comunidad
    public function community()
{
    // Traer los posts activos con su autor
    $posts = Post::with('user')
                    ->active() // Scope para posts no eliminados
                    ->latest()
                    ->paginate(10);

    return view('user.community', compact('posts'));
}

public function userPosts($userId)
{
    $posts = Post::with('user')
                ->where('user_id', $userId)
                ->active()
                ->latest()
                ->paginate(10);

    return view('user.posts', compact('posts'));
}


    public function show($id)
{
    $post = Post::withCount(['comments', 'post_likes', 'post_saves'])->findOrFail($id);

    return view('components.post_detail', compact('post'));
}



    // Reportar post
    public function report(Post $post)
    {
        $post->update(['is_reported' => true]);
        return back()->with('success', 'Post reportado.');
    }

    // Eliminar post (soft delete)
    public function destroy(Post $post)
    {
        $post->update(['is_deleted' => true]);
        return back()->with('success', 'Post eliminado.');
    }

    // Like toggle
    public function like(Post $post)
    {
        $user = auth()->user();
        if ($post->likes()->where('user_id', $user->id)->exists()) {
            $post->likes()->where('user_id', $user->id)->delete();
        } else {
            $post->likes()->create(['user_id' => $user->id]);
        }

        return back();
    }

    // Save toggle
    public function save(Post $post)
    {
        $user = auth()->user();
        if ($post->saves()->where('user_id', $user->id)->exists()) {
            $post->saves()->where('user_id', $user->id)->delete();
        } else {
            $post->saves()->create(['user_id' => $user->id]);
        }

        return back();
    }
}
