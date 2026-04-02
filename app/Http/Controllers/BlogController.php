<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Type;
use Illuminate\Support\Facades\Storage;

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

        $banners = [
            [
                'img_src' => 'images/plan-premium.png',
                'alt' => 'Accedé a Premium'
            ],
            [
                'img_src' => 'images/plan-premium.png',
                'alt' => 'Desbloqueá contenido'
            ],
        ];

        $blogs = Blog::orderByDesc('created_at')->get()->map(function ($blog) use ($user) {
            $blog->canView = !$blog->is_premium || $user->role === 'premium' || $user->role === 'admin';
            $blog->blurred = !$blog->canView;
            return $blog;
        });

        return view('blogs.index', compact('blogs', 'user', 'banners'));
    }


    // Formulario para crear blog (solo admin)
    public function create()
    {
        $this->authorizeAdmin();
        $types = Type::orderBy('name')->get();

        return view('admin.blog.create', compact('types'));
    }

    public function adminIndex()
    {
        $blogs = Blog::orderByDesc('created_at')->get();
        return view('admin.blog.index', compact('blogs'));
    }

    // Guardar nuevo blog (solo admin)
    public function store(Request $request)
    {
        $this->authorizeAdmin();
        $types = Type::all();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'author' => 'required|string|max:255',
            'credentials' => 'nullable|string|max:255',
            'content' => 'required|string',
            'description' => 'required|string',
            'is_premium' => 'nullable|boolean',
            'type_id' => 'required|integer|exists:types,id',
        ]);

        // Subida de imagen
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
            $validated['image'] = $path;
        }

        Blog::create($validated);

        return redirect()->route('blog.index', compact('types'))->with('success', 'Blog creado correctamente.');
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

    //ADMIN
    // Ver detalle de un blog (route model binding posible)
    public function view(Blog $blog)
    {
        return view('admin.blog.view', compact('blog'));
    }

    // Editar blog (solo admin)
    public function edit($id)
    {
        $this->authorizeAdmin();
        $blog = Blog::findOrFail($id);
        $types = Type::all();

        return view('admin.blog.edit', compact('blog', 'types'));
    }

    // Actualizar blog (solo admin)
    public function update(Request $request, $id)
    {
        $this->authorizeAdmin();
        $blog = Blog::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'author' => 'required|string|max:255',
            'credentials' => 'nullable|string|max:255',
            'content' => 'required|string',
            'description' => 'required|string',
            'is_premium' => 'nullable|boolean',
            'type_id' => 'required|integer|exists:types,id',
        ]);

        // Subida de imagen
        if ($request->hasFile('image')) {
            // Borrar imagen anterior si existe
            if ($blog->image) {
                Storage::disk('public')->delete($blog->image);
            }
            $path = $request->file('image')->store('images', 'public');
            $validated['image'] = $path;
        }

        $blog->update($validated);

        return redirect()->route('admin.blog.index')->with('success', 'Blog actualizado correctamente.');
    }

    // Eliminar blog (solo admin)
    public function destroy($id)
    {
        $this->authorizeAdmin();
        $blog = Blog::findOrFail($id);
        $blog->delete();

        return redirect()->route('admin.blog.index')->with('success', 'Blog eliminado correctamente.');
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
