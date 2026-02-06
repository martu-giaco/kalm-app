<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductType;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    /**
     * Muestra la página de inicio con productos, categorías y banners.
     */
    public function index()
    {
        $user = Auth::user();

        // --- 0. Íconos de categorías y tipos ---
        $category_icons = [
            'Limpiadores' => asset('images/icons/limpiadores.svg'),
            'Hidratantes Corporales' => asset('images/icons/hidratantes-corporales.png'),
            'Sueros/Sérums' => asset('images/icons/serums.svg'),
            'Tratamientos' => asset('images/icons/tratamientos.svg'),
            'Exfoliantes' => asset('images/icons/exfoliacion.svg'),
            'Shampoo' => asset('images/icons/shampoo.svg'),
            'Acondicionador' => asset('images/icons/acondicionador.svg'),
            'Hidratantes' => asset('images/icons/hidratante.svg'),
            'Protectores Solares' => asset('images/icons/protector-uv.svg'),
        ];

        $type_icons = [
            'skincare' => '<svg>...</svg>',
            'haircare' => '<svg>...</svg>',
            'limpieza' => '<svg>...</svg>',
            'sol' => '<svg>...</svg>',
        ];

        // --- 1. Categorías ---
        $categories = ProductCategory::all()->map(function ($category) use ($category_icons) {
            if (!$category->slug) {
                $category->slug = Str::slug($category->name); // Genera el slug
            }
            $category->icon_svg = $category_icons[$category->name] ?? '<svg ...></svg>';
            return $category;
        });


        // --- 2. Productos recientes y mejor valorados ---
        $recentProducts = Product::orderByDesc('created_at')->limit(6)->get();
        $topRatedProducts = Product::orderByDesc('rating')->limit(6)->get();

        // --- 3. Banners ---
        $banners = [
            [
                'url' => route('subscription'),
                'img_src' => asset('images/banner-home-1.jpg'),
                'alt' => 'Banner Kälm Premium',
            ],
            [
                'url' => route('subscription'),
                'img_src' => asset('images/banner_discount.png'),
                'alt' => 'Banner Promoción',
            ],
        ];

        // --- 4. Tipos de productos con íconos ---
        $product_types = ProductType::all()->map(function ($type) use ($type_icons) {
            $normalized = strtolower(str_replace([' ', '_'], '', $type->name));
            return [
                'name' => ucfirst($type->name),
                'route' => route('products.type', ['tipo' => $normalized]),
                'icon_svg' => $type_icons[$normalized] ?? $type_icons['skincare'],
            ];
        })->take(6);

        $productsForYouQuery = Product::with('brand', 'type');
        $titleForYou = 'Productos recomendados';

        $isPremiumUser = $user && $user->role === 'premium' && in_array($user->theme, ['skincare', 'haircare']);

        if ($isPremiumUser) {
            $productsForYouQuery->whereHas('type', function ($query) use ($user) {
                $query->where('name', $user->theme);
            });
        } else {
            $productsForYouQuery->latest()->inRandomOrder();
        }

        $productsForYou = $productsForYouQuery->limit(6)->get();

        // --- 6. Favoritos de la comunidad ---
        $communityFavorites = Product::with('brand', 'type')->orderByDesc('rating')->limit(6)->get();

        // --- 7. Secciones para la vista ---
        $product_sections = [
            [
                'title' => $titleForYou,
                'products' => $productsForYou,
                'tag_text' => $isPremiumUser ? 'Tu Tema' : 'Novedad',
                'tag_class' => $isPremiumUser ? 'bg-indigo-100 text-indigo-800' : 'bg-teal-100 text-teal-800',
            ],
            [
                'title' => 'Favoritos de la Comunidad',
                'products' => $communityFavorites,
                'tag_text_func' => fn($p) => "★ {$p->rating}",
                'tag_class' => 'bg-yellow-100 text-yellow-800',
            ],
        ];

        // --- 8. Retornar vista ---
        return view('user.home', compact(
            'categories',
            'recentProducts',
            'topRatedProducts',
            'banners',
            'product_types',
            'product_sections'
        ));
    }
}
