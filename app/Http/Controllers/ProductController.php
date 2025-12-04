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
        $routines = auth()->user()->routines()->get(); // Trae todas las rutinas del usuario

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
            'topRatedProducts'
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
     */// ProductController.php
    public function byCategory($slug)
{
    $category = ProductCategory::where('slug', $slug)->firstOrFail();

    $products = Product::where('category_id', $category->id)
                       ->with(['brand','type'])
                       ->get();

    return view('products.byCategory', compact('category','products'));
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

        if (request()->ajax()) {
            return response()->json(['favorito' => $isFavorito]);
        }

        return back();
    }



    /**
     * Buscar productos
     */
    public function search(Request $request)
    {
        $query = $request->input('q');

        $products = Product::with(['brand', 'type', 'category'])
            ->when($query, function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                    ->orWhereHas('brand', fn($q2) => $q2->where('name', 'like', "%{$query}%"))
                    ->orWhereHas('type', fn($q2) => $q2->where('name', 'like', "%{$query}%"))
                    ->orWhereHas('category', fn($q2) => $q2->where('name', 'like', "%{$query}%"));
            })
            ->paginate(12);

        return view('products.search', [
            'products' => $products,
            'query' => $query
        ]);
    }
}
