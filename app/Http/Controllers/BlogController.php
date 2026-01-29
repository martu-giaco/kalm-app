<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;

class BlogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function blog()
    {
        // Vista principal
        return view('blogs.index');
    }

    //Crear Blog
    public function create()
    {
        return view('blogs.create');
    }

    // Editar Blog
    public function update(Request $request, $blog_id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'products' => 'nullable|array',
        ]);

        $blog = Blog::findOrFail($blog_id);
        $blog->update([
            'name' => $validated['name'],
            'time_id' => $validated['time_id'] ?? null,
            'products' => $validated['products'] ?? [],
        ]);

        return redirect()->route('blogs.show', $blog->blog_id)
                        ->with('success', 'Blog actualizado correctamente.');
    }

    //eliminar blog
    public function destroy(Blog $blog)
    {
        $blog->delete();
        return redirect()->route('blogs.index')->with('success', 'Blog eliminado correctamente.');
    }
}
