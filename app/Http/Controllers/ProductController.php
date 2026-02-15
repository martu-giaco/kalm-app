<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Mostrar detalle de un producto.
     * Acepta como identificador un id numérico.
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);

        // Categorías
        $categories = ProductCategory::all();

        // Rutinas del usuario autenticado
        $routines = auth()->user()->routines()->get();

        // Verificar si el producto es favorito
        $user = auth()->user();
        $idsFavoritos = $user->favoritos ?? [];
        // Convertir a enteros para comparación correcta
        $idsFavoritos = array_map('intval', $idsFavoritos);
        $isFavorito = in_array((int) $product->id, $idsFavoritos);

        // Banners
        $banners = [
            ['img_src' => 'banners/banner1.jpg', 'alt' => 'Banner 1'],
            ['img_src' => 'banners/banner2.jpg', 'alt' => 'Banner 2'],
        ];

        // Secciones de productos relacionadas
        $product_sections = [
            [
                'title' => 'Productos similares',
                'products' => Product::where('category_id', $product->category_id)
                    ->where('id', '!=', $product->id)
                    ->get(),
            ],
        ];

        // Productos top rating
        $topRatedProducts = Product::orderBy('rating', 'desc')->take(5)->get();

        return view('products.show', compact(
            'product',
            'categories',
            'routines',
            'banners',
            'product_sections',
            'topRatedProducts',
            'isFavorito'
        ));
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
            'type_id' => 'required|integer|exists:product_types,id',

            'category_id' => 'required|integer|exists:product_categories,id',
            'rating' => 'nullable|integer|min:0|max:5',
            'donde_comprar' => 'nullable|string',
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
     * Mostrar productos filtrados por tipo
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
     */ // ProductController.php
    public function byCategory($slug)
    {
        $category = ProductCategory::where('slug', $slug)->firstOrFail();

        $products = Product::where('category_id', $category->id)
            ->with(['brand', 'type'])
            ->get();

        return view('products.byCategory', compact('category', 'products'));
    }

    /**
     * Mostrar los productos favoritos del usuario autenticado
     */
    public function favorites()
    {
        $user = auth()->user();
        $idsFavoritos = $user->favoritos ?? [];

        // Asegurar que todos los IDs sean enteros
        $idsFavoritos = array_map('intval', $idsFavoritos);

        // Siempre retornar una colección, incluso si está vacía
        if (!empty($idsFavoritos)) {
            // Obtener los productos, manteniendo el orden de los favoritos
            $favorites = Product::whereIn('id', $idsFavoritos)->get();

            // Filtrar para asegurar que todos los productos existan
            $favorites = $favorites->filter(function ($product) use ($idsFavoritos) {
                return in_array((int) $product->id, $idsFavoritos);
            });
        } else {
            $favorites = collect();
        }

        return view('products.favorites', compact('favorites'));
    }

    /**
     * Toggle favoritos del usuario
     */
    public function toggleFavorito(Product $product)
    {
        try {
            $user = auth()->user();

            // Obtener favoritos actuales
            $favoritos = $user->favoritos;
            if (!is_array($favoritos)) {
                $favoritos = [];
            }

            // Convertir todos a enteros
            $favoritos = array_map('intval', $favoritos);
            $productId = (int) $product->id;

            // Log antes
            \Log::info('Favoritos antes', ['favoritos' => $favoritos, 'buscando' => $productId]);

            // Determinar si agregar o remover
            if (in_array($productId, $favoritos)) {
                // Remover
                $favoritos = array_values(array_diff($favoritos, [$productId]));
                $isFavorito = false;
            } else {
                // Agregar
                $favoritos[] = $productId;
                $isFavorito = true;
            }

            // Limpiar duplicados
            $favoritos = array_values(array_unique($favoritos));

            // Log después
            \Log::info('Favoritos después', ['favoritos' => $favoritos, 'isFavorito' => $isFavorito]);

            // Guardar directamente usando update
            $user->update(['favoritos' => $favoritos]);

            // Refrescar el usuario
            $user = $user->fresh();

            \Log::info('Favoritos guardados en BD', ['favoritos' => $user->favoritos]);

            // Retornar JSON
            return response()->json(['favorito' => $isFavorito], 200);
        } catch (\Exception $e) {
            \Log::error('Error al actualizar favoritos', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Error al actualizar favoritos', 'message' => $e->getMessage()], 500);
        }
    }



    /**
     * Buscar productos
     */
    public function search(Request $request)
    {
        $queryText = $request->input('q');

        $types = ProductType::all();
        $categories = ProductCategory::all();

        $qb = Product::with(['brand', 'type', 'category']);

        if ($queryText) {
            $qb->where('name', 'like', "%{$queryText}%")
                ->orWhereHas('brand', fn($q2) => $q2->where('name', 'like', "%{$queryText}%"))
                ->orWhereHas('type', fn($q2) => $q2->where('name', 'like', "%{$queryText}%"))
                ->orWhereHas('category', fn($q2) => $q2->where('name', 'like', "%{$queryText}%"));
        }

        // filtros explícitos por GET
        if ($request->filled('type_id')) {
            $qb->where('type_id', $request->input('type_id'));
        }
        if ($request->filled('category_id')) {
            $qb->where('category_id', $request->input('category_id'));
        }
        if ($request->filled('brand_id')) {
            $qb->where('brand_id', $request->input('brand_id'));
        }

        $products = $qb->orderBy('rating', 'desc')->paginate(12)->appends($request->except('page'));

        return view('products.search', [
            'products' => $products,
            'query' => $queryText,
            'types' => $types,
            'categories' => $categories,
        ]);
    }
}
