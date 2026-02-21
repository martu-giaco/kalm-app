<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\ProductCategory;
use App\Models\SkinType;
use App\Models\Concern;
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

            // Verificar que el usuario esté autenticado
            if (!$user) {
                return response()->json(['error' => 'No autenticado'], 401);
            }

            // Obtener favoritos actuales
            $favoritos = $user->favoritos ?? [];
            if (!is_array($favoritos)) {
                $favoritos = json_decode($favoritos, true) ?? [];
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
        $skinTypes = SkinType::all();
        $concerns = Concern::all();

        $qb = Product::with(['brand', 'type', 'category', 'skinTypes', 'concerns']);

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
        if ($request->filled('skin_type_id')) {
            $qb->whereHas('skinTypes', function ($q) use ($request) {
                $q->where('skin_types.id', $request->input('skin_type_id'));
            });
        }
        if ($request->filled('concern_id')) {
            $qb->whereHas('concerns', function ($q) use ($request) {
                $q->where('concerns.id', $request->input('concern_id'));
            });
        }

        $products = $qb->orderBy('rating', 'desc')->paginate(12)->appends($request->except('page'));

        return view('products.search', [
            'products' => $products,
            'query' => $queryText,
            'types' => $types,
            'categories' => $categories,
            'skinTypes' => $skinTypes,
            'concerns' => $concerns,
        ]);
    }

    //ADMIN
        public function adminIndex()
        {
            $products = Product::orderBy('created_at', 'desc')->paginate(25);
            return view('admin.products.index', compact('products'));
        }

        // Ver detalle de un producto (route model binding posible)
        public function view(Product $product)
        {
            return view('admin.products.view', compact('product'));
        }

        //Formulario de edición.
        public function edit($id)
        {
            $this->authorizeAdmin();
            $product = Product::findOrFail($id);
            return view('admin.products.edit', compact('product'));
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
         * Actualizar perfil (nombre, email, avatar).
         */
        public function update(Request $request, $id)
        {
            $this->authorizeAdmin();
            $product = Product::findOrFail($id);

            $data = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'max:255', Rule::unique('products')->ignore($product->id)],
                'avatar' => ['nullable', 'image', 'max:2048'], // 2MB máximo
            ]);

            // Subida de avatar
            if ($request->hasFile('avatar')) {
                // Borrar avatar anterior si existe
                if ($product->avatar) {
                    Storage::disk('public')->delete($product->avatar);
                }
                $path = $request->file('avatar')->store('avatars', 'public');
                $data['avatar'] = $path;
            }

            $product->update($data);

            return redirect()->route('admin.products.index')
                ->with('feedback.message', 'Perfil actualizado correctamente')
                ->with('feedback.type', 'success');
        }

        // Eliminar usuario
        public function adminDestroy($id)
        {
            $this->authorizeAdmin();
            $product = Product::findOrFail($id);
            $product->delete();

            return redirect()->route('admin.products.index')->with('success', 'El producto fue eliminado correctamente.');
        }

        private function authorizeAdmin()
        {
            if (auth()->user()->role !== 'admin') {
                abort(403, 'No tenés permiso para realizar esta acción.');
            }
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

                return redirect()->route('admin.products.index')
                    ->with('feedback.message', 'Producto creado correctamente');
            }
}
