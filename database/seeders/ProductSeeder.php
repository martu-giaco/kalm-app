<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\ProductCategory;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Tipos y categorías a usar
        $typesCategories = [
            'Skincare' => [
                'Limpiadores' => [
                    [
                        'name' => 'CeraVe Hydrating Cleanser',
                        'brand_id' => 1,
                        'image' => 'cerave_hydrating_cleanser.jpg',
                        'description' => 'Limpiador hidratante que respeta la barrera cutánea.',
                        'ingredients' => 'Aqua, Glycerin, Ceramides, Hyaluronic Acid',
                        'activos' => 'Ceramidas, Ácido Hialurónico',
                        'formato' => '355ml',
                        'rating' => 5,
                        'dondeComprar' => 'Farmacity, MercadoLibre',
                    ],
                    [
                        'name' => 'La Roche-Posay Effaclar Gel',
                        'brand_id' => 2,
                        'image' => 'la_roche_effaclar_gel.jpg',
                        'description' => 'Gel limpiador para piel grasa y con tendencia acnéica.',
                        'ingredients' => 'Aqua, Zinc PCA, Glycerin, Coco-Betaine',
                        'activos' => 'Zinc PCA',
                        'formato' => '200ml',
                        'rating' => 4,
                        'dondeComprar' => 'Farmacity, Mercado Libre',
                    ],
                    [
                        'name' => 'Neutrogena Hydro Boost Water Gel Cleanser',
                        'brand_id' => 3,
                        'image' => 'neutrogena_hydro_boost.jpg',
                        'description' => 'Limpiador en gel ligero que hidrata y refresca.',
                        'ingredients' => 'Water, Glycerin, Dimethicone, Hyaluronic Acid',
                        'activos' => 'Ácido Hialurónico',
                        'formato' => '200ml',
                        'rating' => 5,
                        'dondeComprar' => 'Farmacity, Mercado Libre',
                    ],
                ],
                'Hidratantes' => [
                    [
                        'name' => 'La Roche-Posay Toleriane Double Repair Moisturizer',
                        'brand_id' => 2,
                        'image' => 'la_roche_toleriane.jpg',
                        'description' => 'Hidratante para piel sensible con ceramidas y niacinamida.',
                        'ingredients' => 'Aqua, Glycerin, Ceramides, Niacinamide',
                        'activos' => 'Ceramidas, Niacinamida',
                        'formato' => '75ml',
                        'rating' => 5,
                        'dondeComprar' => 'Farmacity, Mercado Libre',
                    ],
                ],
            ],
            'Haircare' => [
                'Shampoo' => [
                    [
                        'name' => 'Kérastase Resistance Bain Force Architecte',
                        'brand_id' => 5,
                        'image' => 'kerastase_resistance.jpg',
                        'description' => 'Shampoo reparador para cabellos dañados y quebradizos.',
                        'ingredients' => 'Aqua, Sodium Laureth Sulfate, Cocamidopropyl Betaine, Proteínas',
                        'activos' => 'Ceramidas, Proteínas',
                        'formato' => '250ml',
                        'rating' => 5,
                        'dondeComprar' => 'Mercado Libre, Tiendas profesionales',
                    ],
                    [
                        'name' => 'L’Oréal Serie Expert Absolut Repair',
                        'brand_id' => 6,
                        'image' => 'loreal_absolut_repair.jpg',
                        'description' => 'Shampoo nutritivo y reparador para cabello muy dañado.',
                        'ingredients' => 'Aqua, Sodium Laureth Sulfate, Cocamidopropyl Betaine, Lipidos',
                        'activos' => 'Lipidos, Proteínas',
                        'formato' => '300ml',
                        'rating' => 5,
                        'dondeComprar' => 'Farmacity, Mercado Libre',
                    ],
                ],
                'Acondicionador' => [
                    [
                        'name' => 'Redken Extreme Conditioner',
                        'brand_id' => 7,
                        'image' => 'redken_extreme_conditioner.jpg',
                        'description' => 'Acondicionador fortalecedor para cabello débil y quebradizo.',
                        'ingredients' => 'Aqua, Cetearyl Alcohol, Behentrimonium Chloride, Proteínas',
                        'activos' => 'Proteínas, Ceramidas',
                        'formato' => '250ml',
                        'rating' => 5,
                        'dondeComprar' => 'Mercado Libre, Salones',
                    ],
                ],
            ],
        ];

        // Crear productos según tipo y categoría
        foreach ($typesCategories as $typeName => $categories) {
            $type = ProductType::firstOrCreate(['name' => $typeName]);

            foreach ($categories as $categoryName => $products) {
                $category = ProductCategory::firstOrCreate([
                    'name' => $categoryName,
                    'type_id' => $type->id
                ]);

                foreach ($products as $productData) {
                    Product::create(array_merge($productData, [
                        'type_id' => $type->id,
                        'category_id' => $category->id,
                        'image' => 'images/products/' . $productData['image'], // ruta completa en public
                    ]));
                }
            }
        }
    }
}
