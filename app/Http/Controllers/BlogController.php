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

    // Vista principal de blogs
    public function index()
    {
        $user = auth()->user();

        $blogs = Blog::orderByDesc('created_at')->get()->map(function ($blog) use ($user) {
            // Si el usuario es admin o tiene suscripción premium, puede ver todo
            $blog->canView = !$blog->is_premium || $user->role === 'premium' || $user->role === 'admin';
            $blog->blurred = !$blog->canView;
            $blog->tempLikes = [];
            return $blog;
        });

        return view('blogs.index', compact('blogs', 'user'));
    }


    // Formulario para crear blog (solo admin)
    public function create()
    {
        $this->authorizeAdmin();
        return view('blogs.create');
    }

    // Guardar nuevo blog (solo admin)
    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|url',
            'author' => 'required|string|max:255',
            'credentials' => 'nullable|string|max:255',
            'content' => 'required|string',
            'is_premium' => 'nullable|boolean',
        ]);

        Blog::create($validated);

        return redirect()->route('blog.index')->with('success', 'Blog creado correctamente.');
    }

    // Mostrar blog individual
    public function show($id)
    {
        $blog = Blog::findOrFail($id);
        $user = auth()->user();

        // Usuario puede ver si: no es premium o es premium/admin
        $blog->canView = !$blog->is_premium || $user->role === 'premium' || $user->role === 'admin';
        $blog->blurred = !$blog->canView;

        // No abortamos, solo controlamos la vista
        return view('blogs.show', compact('blog', 'user'));
    }



    // Editar blog (solo admin)
    public function edit($id)
    {
        $this->authorizeAdmin();
        $blog = Blog::findOrFail($id);
        return view('blogs.edit', compact('blog'));
    }

    // Actualizar blog (solo admin)
    public function update(Request $request, $id)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|url',
            'author' => 'required|string|max:255',
            'credentials' => 'nullable|string|max:255',
            'content' => 'required|string',
            'is_premium' => 'nullable|boolean',
        ]);

        $blog = Blog::findOrFail($id);
        $blog->update($validated);

        return redirect()->route('blog.index')->with('success', 'Blog actualizado correctamente.');
    }

    // Eliminar blog (solo admin)
    public function destroy($id)
    {
        $this->authorizeAdmin();
        $blog = Blog::findOrFail($id);
        $blog->delete();

        return redirect()->route('blog.index')->with('success', 'Blog eliminado correctamente.');
    }

    // Función para likes temporales (estilo YouTube)
    public function toggleLike(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);
        $userId = auth()->id();

        $likes = $blog->tempLikes ?? [];

        if (in_array($userId, $likes)) {
            $likes = array_diff($likes, [$userId]);
        } else {
            $likes[] = $userId;
        }

        $blog->tempLikes = $likes;

        return response()->json(['likes' => count($likes), 'liked' => in_array($userId, $likes)]);
    }

    private function authorizeAdmin()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'No tenés permiso para realizar esta acción.');
        }
    }
}
