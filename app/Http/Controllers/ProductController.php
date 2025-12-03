<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\ProductCategory;
use App\Models\Routine;
use App\Http\Controllers\RoutineController;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Mostrar detalle de un producto.
     * Acepta como identificador un slug o un id numérico.
     */
    public function show($identifier)
    {
        // Construyo la query base
        $query = Product::query();

        // Si la columna 'slug' existe, intento buscar por slug o id.
        if (Schema::hasColumn('products', 'slug')) {
            $product = $query->where('slug', $identifier)
                ->orWhere('id', $identifier)
                ->first();
        } else {
            // Si no hay slug, buscamos por id directamente
            $product = $query->where('id', $identifier)->first();
        }

        if (!$product) {
            abort(404);
        }

        // Si tu vista espera otros datos (relaciones), cargalas aquí, p.ej:
        // $product->load(['brand', 'category', 'images']);

        $user = auth()->user();

        $routines = Routine::where('user_id', $user->id)
                            ->with(['times'])
                            ->get();

        return view('products.show', compact('product', 'routines'));
    }

    /**
     * Mostrar el formulario de creación de producto
     */
    public function create()
    {
        $types = ProductType::all();
        $categories = ProductCategory::all();

        return view('admin.products.create', compact('types', 'categories'));
    }

    /**
     * Almacenar un nuevo producto
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'brand_id' => 'required|exists:brands,id',
            'image' => 'nullable|image',
            'description' => 'nullable|string',
            'ingredients' => 'nullable|string',
            'activos' => 'nullable|string',
            'paso' => 'nullable|string',
            'formato' => 'nullable|string',
            'type_id' => 'required|exists:product_types,id',
            'category_id' => 'required|exists:product_categories,id',
            'rating' => 'nullable|integer|min:0|max:5',
            'dondeComprar' => 'nullable|string',
        ]);

        $data = $request->all();

        // Guardar imagen si existe
        if ($request->hasFile('image')) {
            $data['image_url'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('admin.dashboard')
            ->with('feedback.message', 'Producto creado correctamente');
    }

    /**
     * Mostrar productos filtrados por tipo (ej: skincare / haircare)
     */
    public function byType($typeSlug)
    {
        $type = ProductType::where('slug', $typeSlug)->firstOrFail();

        $products = Product::with(['brand', 'category'])
            ->where('type_id', $type->id)
            ->get();

        return view('products.by_type', compact('products', 'type'));
    }

    /**
     * Mostrar productos filtrados por categoría
     */
    public function byCategory($slug)
    {
        // Intento por slug si la columna existe
        $category = null;
        if (Schema::hasColumn('product_categories', 'slug')) {
            $category = ProductCategory::where('slug', $slug)->first();
        }

        // Fallback: convertir slug a nombre y buscar por name
        if (!$category) {
            // "hidratantes" -> "Hidratantes" (o "Hidratantes" según tu naming)
            $name = Str::of($slug)->replace('-', ' ')->title()->toString();
            $category = ProductCategory::where('name', $name)->first();
        }

        if (!$category) {
            abort(404);
        }

        // Asumiendo relación products() en el modelo
        $products = $category->products()->paginate(20);

        return view('products.index', compact('category', 'products'));
    }


    /**
     * Toggle favoritos del usuario
     */
    public function toggleFavorito(Product $product)
    {
        $user = auth()->user();
        $favoritos = $user->favoritos ? json_decode($user->favoritos, true) : [];

        if (in_array($product->id, $favoritos)) {
            $favoritos = array_diff($favoritos, [$product->id]);
            $isFavorito = false;
        } else {
            $favoritos[] = $product->id;
            $isFavorito = true;
        }

        $user->favoritos = json_encode(array_values($favoritos));
        $user->save();

        if (request()->ajax()) {  // Detecta fetch/AJAX
            return response()->json(['favorito' => $isFavorito]);
        }

        return back();  // Para petición normal
    }


    // app/Http/Controllers/ProductController.php

    public function search(Request $request)
    {
        // Obtener la consulta del input
        $query = $request->input('q');

        // Buscar productos filtrando por nombre, marca o tipo
        $products = Product::with(['brand', 'type', 'category'])
            ->when($query, function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                    ->orWhereHas('brand', fn($q2) => $q2->where('name', 'like', "%{$query}%"))
                    ->orWhereHas('type', fn($q2) => $q2->where('name', 'like', "%{$query}%"))
                    ->orWhereHas('category', fn($q2) => $q2->where('name', 'like', "%{$query}%"));
            })
            ->paginate(12);


        // Pasar los datos a la vista
        return view('products.search', [
            'products' => $products,
            'query' => $query
        ]);
    }




}
