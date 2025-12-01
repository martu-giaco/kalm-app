<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class CommunityController extends Controller
{
    public function community()
    {
        // Traemos los posts con su usuario relacionado y paginamos
        $posts = Post::with('user')->latest()->paginate(10);

        // Pasamos los posts a la vista
        return view('user.community', compact('posts'));
    }
}
