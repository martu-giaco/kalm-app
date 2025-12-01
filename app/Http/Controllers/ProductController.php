<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\ProductCategory;

class ProductController extends Controller
{
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
        $category = ProductCategory::where('slug', $slug)->firstOrFail();

        $products = Product::where('category_id', $category->id)
            ->with(['brand', 'type'])
            ->get();

        return view('products.by_category', compact('category', 'products'));
    }

    // ProductController.php
    public function favorites()
    {
        $user = auth()->user();
        $favoritosIds = $user->favoritos ? json_decode($user->favoritos, true) : [];

        // Traemos los productos que están en favoritos
        $products = Product::whereIn('id', $favoritosIds)->get();

        return view('user.favs', compact('products'));
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


    public function search(Request $request)
    {
        $query = $request->input('q');

        $products = Product::with('brand', 'type')
            ->where('name', 'like', "%{$query}%")
            ->orWhereHas('brand', function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%");
            })
            ->orWhereHas('type', function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%");
            })
            ->paginate(12);

        return view('products.search', compact('products', 'query'));
    }



}
