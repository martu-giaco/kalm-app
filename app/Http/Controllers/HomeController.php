<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Type;
use App\Models\UserTestResult;
use App\Models\SkinType;
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

        // --- Íconos ---
        $category_icons = [
            'Limpiadores' => ['light' => asset('images/icons/limpiadores.svg'), 'dark' => asset('images/icons/limpiadores-dark.svg')],
            'Hidratantes Corporales' => ['light' => asset('images/icons/hidratantes-corporales.svg'), 'dark' => asset('images/icons/hidratantes-corporales-dark.svg')],
            'Sérums' => ['light' => asset('images/icons/serums.svg'), 'dark' => asset('images/icons/serums-dark.svg')],
            'Tratamientos' => ['light' => asset('images/icons/tratamientos.svg'), 'dark' => asset('images/icons/tratamientos-dark.svg')],
            'Exfoliantes' => ['light' => asset('images/icons/exfoliacion.svg'), 'dark' => asset('images/icons/exfoliacion-dark.svg')],
            'Shampoo' => ['light' => asset('images/icons/shampoo.svg'), 'dark' => asset('images/icons/shampoo-dark.svg')],
            'Acondicionador' => ['light' => asset('images/icons/acondicionador.svg'), 'dark' => asset('images/icons/acondicionador-dark.svg')],
            'Hidratantes' => ['light' => asset('images/icons/hidratante.svg'), 'dark' => asset('images/icons/hidratante-dark.svg')],
            'Protectores Solares' => ['light' => asset('images/icons/protector-uv.svg'), 'dark' => asset('images/icons/protector-uv-dark.svg')],
        ];

        // --- Categorías ---
        $categories = ProductCategory::all()->map(function ($category) use ($category_icons) {
            if (!$category->slug) {
                $category->slug = Str::slug($category->name); // Genera el slug
            }

            $icon = $category_icons[$category->name] ?? [
                'light' => asset('images/icons/limpiadores.svg'),
                'dark' => asset('images/icons/limpiadores.svg'),
            ];

            $category->icon_light = $icon['light'] ?? asset('images/icons/limpiadores.svg');
            $category->icon_dark = $icon['dark'] ?? $category->icon_light;

            return $category;
        });


        // --- Productos recientes y mejor valorados ---
        $recentProducts = Product::orderByDesc('created_at')->limit(6)->get();
        $topRatedProducts = Product::orderByDesc('rating')->limit(6)->get();

        // --- Banners ---
        $banners = [
            [
                'url' => route('subscription.show'),
                'img_src' => asset('images/banner-home-1.jpg'),
                'alt' => 'Banner Kälm Premium',
            ]
        ];

        $productsForYou = collect();
        $titleForYou = 'Productos recomendados';
        $matchedSkinType = null;
        $tagText = 'Novedad';
        $tagClass = 'bg-teal-100 text-teal-800';

        $latestTestResult = $user
            ? UserTestResult::where('user_id', $user->id)->latest('updated_at')->first()
            : null;

        $resultKey = $latestTestResult?->result_key;

        if ($resultKey) {
            $skinTypeMap = [
                'normal' => 'Normal',
                'seco' => 'Seca',
                'graso' => 'Oleosa',
                'mixto' => 'Mixta',
                'sensible' => 'Sensible',
            ];

            $matchedSkinType = $skinTypeMap[strtolower($resultKey)] ?? null;

            if ($matchedSkinType) {
                $productsForYou = Product::with('brand', 'type', 'skinTypes')
                    ->whereHas('skinTypes', function ($query) use ($matchedSkinType) {
                        $query->where('name', $matchedSkinType);
                    })
                    ->orderByDesc('rating')
                    ->limit(12)
                    ->get();

                $titleForYou = 'Productos recomendados para ti';
                $tagText = 'Tu tipo';
                $tagClass = 'bg-indigo-100 text-indigo-800';
            }
        }

        if ($productsForYou->isEmpty()) {
            $productsForYouQuery = Product::with('brand', 'type', 'skinTypes');
            $isPremiumUser = $user && $user->role === 'premium' && in_array($user->theme, ['skincare', 'haircare']);

            if ($isPremiumUser) {
                $productsForYouQuery->whereHas('type', function ($query) use ($user) {
                    $query->where('name', $user->theme);
                });
            } else {
                $productsForYouQuery->latest()->inRandomOrder();
            }

            $productsForYou = $productsForYouQuery->limit(12)->get();
        }

        // --- 6. Favoritos de la comunidad ---
        $communityFavorites = Product::with('brand', 'type')->orderByDesc('rating')->limit(6)->get();

        // --- 7. Secciones para la vista ---
        $product_sections = [
            [
                'title' => $titleForYou,
                'products' => $productsForYou,
            ],
            [
                'title' => 'Favoritos de la Comunidad',
                'products' => $communityFavorites,
                'tag_text_func' => fn($p) => "★ {$p->rating}",
                'tag_class' => 'bg-yellow-100 text-yellow-800',
            ],
        ];

        // Verificar si el producto es favorito
        $user = auth()->user();
        $idsFavoritos = $user ? array_map('intval', ($user->favoritos ?? [])) : [];

        foreach ($product_sections as &$section) {
            foreach ($section['products'] as $product) {
                $product->isFavorito = in_array((int) $product->id, $idsFavoritos);
                $product->is_personalized = $matchedSkinType && $section['title'] === $titleForYou && $product->relationLoaded('skinTypes')
                    ? $product->skinTypes->contains('name', $matchedSkinType)
                    : false;
            }
        }
        unset($section);

        // --- 8. Retornar vista ---
        return view('user.home', compact(
            'categories',
            'recentProducts',
            'topRatedProducts',
            'banners',
            'product_sections'
        ));
    }

    public function adminHome()
    {
        return view('admin.home');
    }
}
