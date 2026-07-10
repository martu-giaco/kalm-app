<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Type;
use App\Models\Tag;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Vista principal de blogs
    public function index(Request $request)
    {
        $queryText = $request->input('q');
        $types = Type::all();
        $tags = Tag::all();
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

        $qb = Blog::with(['type', 'tags']);

        if ($queryText) {
            $qb->where(function ($q) use ($queryText) {
                $q->where('title', 'like', "%{$queryText}%") // ⚠️ usar title, no name
                ->orWhere('description', 'like', "%{$queryText}%")
                ->orWhere('content', 'like', "%{$queryText}%")
                ->orWhere('author', 'like', "%{$queryText}%")
                ->orWhereHas('type', fn($q2) =>
                        $q2->where('name', 'like', "%{$queryText}%")
                )
                ->orWhereHas('tags', fn($q2) =>
                        $q2->where('name', 'like', "%{$queryText}%")
                );
            });
        }

        $queryWords = explode(' ', $queryText);

        foreach ($queryWords as $word) {
            $qb->where(function ($q) use ($word) {
                $q->where('title', 'like', "%{$word}%")
                ->orWhere('content', 'like', "%{$word}%");
            });
        }

        if ($request->filled('type_id')) {
            $qb->where('type_id', $request->input('type_id'));
        }

        if ($request->filled('tag_id')) {
            $qb->whereHas('tags', function ($q) use ($request) {
                $q->where('tags.id', $request->input('tag_id'));
            });
        }

        $blogs = Blog::with(['type', 'tags'])
            ->latest()
            ->get();

        $blogs = $blogs->transform(function ($blog) use ($user) {
            $this->applyBlogAccess($blog, $user);

            return $blog;
        });

        $blogsByType = $blogs->groupBy(function ($blog) {
            return $blog->type?->name ?? 'Todos los blogs';
        });

        $blogsByTag = [];

        foreach ($blogs as $blog) {
            foreach ($blog->tags as $tag) {
                $blogsByTag[$tag->name][] = $blog;
            }
        }


        return view('blogs.index', compact('blogs', 'types', 'tags', 'user', 'banners', 'blogsByType', 'blogsByTag'));
    }

    /**
     * Mostrar productos filtrados por tag
     */ // BlogController.php
    public function byTag($slug)
    {
        $tag = Tag::where('slug', $slug)->firstOrFail();

        $user = auth()->user();

        $blogs = Blog::whereHas('tags', function ($query) use ($tag) {
            $query->where('tags.id', $tag->id);})
            ->with(['tags', 'type'])
            ->get();

        $blogs->each(function ($blog) use ($user) {
            $this->applyBlogAccess($blog, $user);
        });

        return view('blogs.byTag', compact('tag', 'blogs'));
    }

    /**
     * Mostrar productos filtrados por type
     */ // BlogController.php
    public function byType($slug)
    {
        $type = Type::where('slug', $slug)->firstOrFail();

        $user = auth()->user();

        $blogs = Blog::where('type_id', $type->id)
            ->with(['tags', 'type'])
            ->get();

        $blogs->each(function ($blog) use ($user) {
            $this->applyBlogAccess($blog, $user);
        });

        return view('blogs.byType', compact('type', 'blogs'));
    }


    // Vista principal de blogs
    public function search(Request $request)
    {
        $queryText = $request->input('q');
        $types = Type::all();
        $tags = Tag::all();
        $user = auth()->user();
        $qb = Blog::with(['type', 'tags']);

        if ($queryText) {
            $qb->where(function ($q) use ($queryText) {
                $q->where('title', 'like', "%{$queryText}%") // ⚠️ usar title, no name
                ->orWhere('description', 'like', "%{$queryText}%")
                ->orWhere('content', 'like', "%{$queryText}%")
                ->orWhere('author', 'like', "%{$queryText}%")
                ->orWhereHas('type', fn($q2) =>
                        $q2->where('name', 'like', "%{$queryText}%")
                )
                ->orWhereHas('tags', fn($q2) =>
                        $q2->where('name', 'like', "%{$queryText}%")
                );
            });
        }

        $queryWords = explode(' ', $queryText);
        foreach ($queryWords as $word) {
            $qb->where(function ($q) use ($word) {
                $q->where('title', 'like', "%{$word}%")
                ->orWhere('content', 'like', "%{$word}%");
            });
        }

        if ($request->filled('type_id')) {
            $qb->where('type_id', $request->input('type_id'));
        }

        if ($request->filled('tag_id')) {
            $qb->whereHas('tags', function ($q) use ($request) {
                $q->where('tags.id', $request->input('tag_id'));
            });
        }

        $blogs = $qb->orderByDesc('created_at')
                    ->paginate(12)
                    ->appends($request->except('page'));

        $blogs->getCollection()->transform(function ($blog) use ($user) {
            $this->applyBlogAccess($blog, $user);

            return $blog;
        });

        return view('blogs.search', compact('blogs', 'types', 'tags', 'user'));
    }


    // Formulario para crear blog (solo admin)
    public function create()
    {
        $this->authorizeAdmin();
        $types = Type::orderBy('name')->get();
        $tags = Tag::all();

        return view('admin.blog.create', compact('types', 'tags'));
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
        $tags = Tag::all();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'author' => 'required|string|max:255',
            'credentials' => 'nullable|string|max:255',
            'content' => 'required|string',
            'description' => 'required|string',
            'is_premium' => 'nullable|boolean',
            'type_id' => 'required|integer|exists:types,id',
            'tags' => 'array',
            'tags.*' => 'exists:tags,id',
        ]);

        // Subida de imagen
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
            $validated['image'] = $path;
        }

        $blog = Blog::create($validated);

        $blog->tags()->sync($request->tags ?? []);

        return redirect()->route('blog.index')->with('feedback', ['message' => 'Blog creado correctamente.', 'type' => 'success']);
    }

    // Mostrar blog individual
    public function show($id)
    {
        $blog = Blog::findOrFail($id);
        $user = auth()->user();

        // Usuario puede ver si: no es premium o es premium/admin
        $this->applyBlogAccess($blog, $user);

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
        $tags = Tag::all();

        return view('admin.blog.edit', compact('blog', 'types', 'tags'));
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
            'tags' => 'array',
            'tags.*' => 'exists:tags,id',
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

        $blog->tags()->sync($request->tags ?? []);

        $blog->update($validated);

        return redirect()->route('admin.blog.index')->with('feedback', ['message' => 'Blog actualizado correctamente.', 'type' => 'success']);
    }

    // Eliminar blog (solo admin)
    public function destroy($id)
    {
        $this->authorizeAdmin();
        $blog = Blog::findOrFail($id);
        $blog->delete();

        return redirect()->route('admin.blog.index')->with('feedback', ['message' => 'Blog eliminado correctamente.', 'type' => 'success']);
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

    private function applyBlogAccess($blog, $user = null)
    {
        $user = $user ?? auth()->user();

        $blog->canView = !$blog->is_premium ||
            ($user && ($user->role === 'premium' || $user->role === 'admin'));
        $blog->blurred = !$blog->canView;

        return $blog;
    }

    private function authorizeAdmin()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'No tenés permiso para realizar esta acción.');
        }
    }
}
