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
        // Obtener tipo y categoría
        $type = ProductType::where('name', 'Cuidado Facial')->first();
        $category = ProductCategory::where('name', 'Limpiadores')->where('type_id', $type->id)->first();

        if ($type && $category) {
            // Lista de productos
            $products = [
                [
                    'name' => 'CeraVe Hydrating Cleanser',
                    'brand_id' => 1,
                    'image' => 'images/products/cerave_hydrating_cleanser.jpg',
                    'description' => 'Limpiador hidratante que respeta la barrera cutánea.',
                    'ingredients' => 'Aqua, Glycerin, Ceramides, Hyaluronic Acid',
                    'activos' => 'Ceramidas, Ácido Hialurónico',
                    'formato' => '355ml',
                    'rating' => 5,
                    'dondeComprar' => 'Farmacias, Amazon'
                ],
                [
                    'name' => 'La Roche-Posay Effaclar Gel',
                    'brand_id' => 2,
                    'image' => 'images/products/la_roche_effaclar_gel.jpg',
                    'description' => 'Gel limpiador para piel grasa y con tendencia acnéica.',
                    'ingredients' => 'Aqua, Zinc PCA, Glycerin, Coco-Betaine',
                    'activos' => 'Zinc PCA',
                    'formato' => '200ml',
                    'rating' => 4,
                    'dondeComprar' => 'Farmacias, Tiendas Online'
                ],
                [
                    'name' => 'Neutrogena Hydro Boost Water Gel Cleanser',
                    'brand_id' => 3,
                    'image' => 'images/products/neutrogena_hydro_boost.jpg',
                    'description' => 'Limpiador en gel ligero que hidrata y refresca.',
                    'ingredients' => 'Water, Glycerin, Dimethicone, Hyaluronic Acid',
                    'activos' => 'Ácido Hialurónico',
                    'formato' => '200ml',
                    'rating' => 5,
                    'dondeComprar' => 'Farmacias, Amazon'
                ],
                [
                    'name' => 'Bioderma Sensibio H2O',
                    'brand_id' => 4,
                    'image' => 'images/products/bioderma_sensibio_h2o.jpg',
                    'description' => 'Agua micelar para piel sensible, limpia y calma la piel.',
                    'ingredients' => 'Aqua, PEG-6 Caprylic/Capric Glycerides, Cucumber Extract',
                    'activos' => 'Extracto de pepino',
                    'formato' => '250ml',
                    'rating' => 5,
                    'dondeComprar' => 'Farmacias, Tiendas Online'
                ],
            ];

            // Crear productos
            foreach ($products as $product) {
                Product::create(array_merge($product, [
                    'type_id' => $type->id,
                    'category_id' => $category->id,
                ]));
            }
        }
    }
}
