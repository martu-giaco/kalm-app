<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Brand; // Importamos Brand
use App\Models\ProductType; // Usando ProductType, como solicitaste
use App\Models\ProductCategory; // Usando ProductCategory, como solicitaste

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // ---------------------------------------------------------------------
        // 1. GARANTIZAR LA EXISTENCIA DE LAS MARCAS (Prevención de Error 1452)
        // ---------------------------------------------------------------------
        // Para evitar el error de clave foránea (1452), nos aseguramos de que
        // todas las marcas necesarias existan antes de insertar productos.
        // Se definen las marcas a partir de los IDs usados en el array de productos.

        $brandNamesMap = [
            1 => 'CeraVe',
            2 => 'La Roche-Posay',
            3 => 'Neutrogena',
            5 => 'Kérastase',
            6 => 'L’Oréal',
            7 => 'Redken',
            8 => 'Icono Cosmetica',
            9 => 'The Ordinary',
            10 => 'Dermaglós',
            11 => 'Eucerin',
            12 => 'Isdin',
            13 => 'Vichy',
            14 => 'Glow Factor',
            15 => 'Paula\'s Choice',
            16 => 'Capilatis',
            17 => 'Olaplex',
            18 => 'Nivea',
            19 => 'Cetaphil',
        ];

        // Almacenar las instancias de marca para mapear el ID de la data al ID real de la DB.
        $actualBrands = [];
        foreach ($brandNamesMap as $keyId => $name) {
            $brand = Brand::firstOrCreate(['name' => $name]);
            $actualBrands[$keyId] = $brand->id;
        }


        // ---------------------------------------------------------------------
        // 2. DATA DE PRODUCTOS (Estructura proporcionada por el usuario)
        // ---------------------------------------------------------------------
        $typesCategories = [
            'Skincare' => [
                'Limpiadores' => [
                    [
                        'name' => 'CeraVe Hydrating Cleanser',
                        'brand_id' => 1,
                        'image' => 'cerave_hydrating_cleanser.jpg',
                        'description' => 'Limpiador hidratante que respeta la barrera cutánea. Ideal para piel normal a seca.',
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
                        'description' => 'Gel limpiador para piel grasa y con tendencia acnéica. Limpia suavemente sin resecar.',
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
                        'description' => 'Limpiador en gel ligero que hidrata y refresca, no comedogénico.',
                        'ingredients' => 'Water, Glycerin, Dimethicone, Hyaluronic Acid',
                        'activos' => 'Ácido Hialurónico',
                        'formato' => '200ml',
                        'rating' => 5,
                        'dondeComprar' => 'Farmacity, Mercado Libre',
                    ],
                    [
                        'name' => 'Icono Cosmetica Gel de Limpieza Facial Purificante', // Producto Nacional (Argentina)
                        'brand_id' => 8,
                        'image' => 'icono_limpiador_purificante.jpg',
                        'description' => 'Gel de limpieza purificante para pieles mixtas a grasas. Formulación con activos botánicos.',
                        'ingredients' => 'Extracto de Hamamelis, Tensioactivos suaves',
                        'activos' => 'Hamamelis, Zinc',
                        'formato' => '150ml',
                        'rating' => 4,
                        'dondeComprar' => 'Tiendas de estética, Mercado Libre',
                    ],
                ],
                'Hidratantes' => [
                    [
                        'name' => 'La Roche-Posay Toleriane Double Repair Moisturizer',
                        'brand_id' => 2,
                        'image' => 'la_roche_toleriane.jpg',
                        'description' => 'Hidratante para piel sensible con ceramidas y niacinamida. Restaura la barrera protectora.',
                        'ingredients' => 'Aqua, Glycerin, Ceramides, Niacinamide',
                        'activos' => 'Ceramidas, Niacinamida',
                        'formato' => '75ml',
                        'rating' => 5,
                        'dondeComprar' => 'Farmacity, Mercado Libre',
                    ],
                    [
                        'name' => 'CeraVe Crema Hidratante',
                        'brand_id' => 1,
                        'image' => 'cerave_moisturizing_cream.jpg',
                        'description' => 'Crema densa para cuerpo y rostro. Hidratación 24 horas con 3 ceramidas esenciales.',
                        'ingredients' => 'Aqua, Glycerin, Ceramides, Petrolatum',
                        'activos' => 'Ceramidas, Ácido Hialurónico',
                        'formato' => '454g',
                        'rating' => 5,
                        'dondeComprar' => 'Farmacity, Tiendas online',
                    ],
                    [
                        'name' => 'The Ordinary Natural Moisturizing Factors + HA',
                        'brand_id' => 9,
                        'image' => 'the_ordinary_nmf_ha.jpg',
                        'description' => 'Fórmula no grasa que ofrece hidratación superficial con Factores Hidratantes Naturales.',
                        'ingredients' => 'Amino Acids, Dermal Lipids, Hyaluronic Acid, Glycerin',
                        'activos' => 'Factores de Humectación Natural, Ácido Hialurónico',
                        'formato' => '100ml',
                        'rating' => 4,
                        'dondeComprar' => 'Tiendas de cosmética especializada, Deciem',
                    ],
                    [
                        'name' => 'Dermaglós Facial Crema Nutritiva de Noche', // Producto Nacional (Argentina)
                        'brand_id' => 10,
                        'image' => 'dermaglos_nutritiva_noche.jpg',
                        'description' => 'Crema nutritiva para la noche con Vitamina A. Mejora la elasticidad y regeneración celular.',
                        'ingredients' => 'Vitamina A, Alantoína, Glicerina',
                        'activos' => 'Vitamina A',
                        'formato' => '50g',
                        'rating' => 4,
                        'dondeComprar' => 'Farmacity, Perfumerías',
                    ],
                ],
                'Protectores Solares' => [
                    [
                        'name' => 'Eucerin Sun Fluid Photoaging Control FPS 50',
                        'brand_id' => 11,
                        'image' => 'eucerin_sun_fluid.jpg',
                        'description' => 'Protector solar facial de amplio espectro, con ácido hialurónico para reducir arrugas.',
                        'ingredients' => 'Filtros UVA/UVB, Licochalcona A, Ácido Glicirretínico',
                        'activos' => 'FPS 50+, Ácido Hialurónico',
                        'formato' => '50ml',
                        'rating' => 5,
                        'dondeComprar' => 'Farmacity, Farmacias',
                    ],
                    [
                        'name' => 'Isdin Fusion Water Magic FPS 50',
                        'brand_id' => 12,
                        'image' => 'isdin_fusion_water.jpg',
                        'description' => 'Protector facial ultraligero a base de agua, de absorción inmediata, ideal para uso diario.',
                        'ingredients' => 'Aqua, Filtros solares, Ácido Hialurónico',
                        'activos' => 'FPS 50, Tecnología Safe-Eye',
                        'formato' => '50ml',
                        'rating' => 5,
                        'dondeComprar' => 'Mercado Libre, Farmacity',
                    ],
                ],
                'Sueros/Sérums' => [
                    [
                        'name' => 'Vichy Mineral 89 Booster',
                        'brand_id' => 13,
                        'image' => 'vichy_mineral_89.jpg',
                        'description' => 'Concentrado fortificante e hidratante con 89% de Agua Volcánica de Vichy y Ácido Hialurónico.',
                        'ingredients' => 'Aqua Volcánica de Vichy, Ácido Hialurónico',
                        'activos' => 'Ácido Hialurónico, Minerales',
                        'formato' => '50ml',
                        'rating' => 5,
                        'dondeComprar' => 'Farmacity, Perfumerías',
                    ],
                    [
                        'name' => 'The Ordinary Niacinamide 10% + Zinc 1%',
                        'brand_id' => 9,
                        'image' => 'the_ordinary_niacinamide.jpg',
                        'description' => 'Sérum de alta concentración de Niacinamida para reducir manchas, poros e imperfecciones.',
                        'ingredients' => 'Niacinamide, Zinc PCA',
                        'activos' => 'Niacinamida 10%, Zinc 1%',
                        'formato' => '30ml',
                        'rating' => 4,
                        'dondeComprar' => 'Tiendas de cosmética especializada',
                    ],
                    [
                        'name' => 'Glow Factor Vitamina C 15%', // Producto Nacional (Argentina)
                        'brand_id' => 14,
                        'image' => 'glow_factor_vitc.jpg',
                        'description' => 'Sérum de Vitamina C pura (ácido L-ascórbico) para acción antioxidante e iluminadora.',
                        'ingredients' => 'Ácido L-Ascórbico 15%, Ácido Ferúlico',
                        'activos' => 'Vitamina C, Ácido Ferúlico',
                        'formato' => '30ml',
                        'rating' => 5,
                        'dondeComprar' => 'Web oficial, Mercado Libre',
                    ],
                ],
                'Exfoliantes' => [
                    [
                        'name' => 'Paula\'s Choice 2% BHA Liquid Exfoliant',
                        'brand_id' => 15,
                        'image' => 'paulas_choice_bha.jpg',
                        'description' => 'Exfoliante químico con ácido salicílico. Desobstruye poros y reduce puntos negros.',
                        'ingredients' => 'Salicylic Acid (BHA), Green Tea Extract',
                        'activos' => 'Ácido Salicílico 2%',
                        'formato' => '118ml',
                        'rating' => 5,
                        'dondeComprar' => 'Web oficial, Tiendas de importación',
                    ],
                ],
            ],
            'Haircare' => [
                'Shampoo' => [
                    [
                        'name' => 'Kérastase Resistance Bain Force Architecte',
                        'brand_id' => 5,
                        'image' => 'kerastase_resistance.jpg',
                        'description' => 'Shampoo reparador para cabellos dañados, quebradizos o con puntas abiertas.',
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
                        'description' => 'Shampoo nutritivo y reparador para cabello muy dañado. Enriquecido con Quinoa Dorada.',
                        'ingredients' => 'Aqua, Sodium Laureth Sulfate, Cocamidopropyl Betaine, Lipidos',
                        'activos' => 'Quinoa Dorada, Proteínas',
                        'formato' => '300ml',
                        'rating' => 5,
                        'dondeComprar' => 'Farmacity, Mercado Libre',
                    ],
                    [
                        'name' => 'Capilatis Ortiga Shampoo para Cabellos Grasos', // Producto Nacional (Argentina)
                        'brand_id' => 16,
                        'image' => 'capilatis_ortiga.jpg',
                        'description' => 'Shampoo con extracto de Ortiga que regula el exceso de sebo en cabellos grasos.',
                        'ingredients' => 'Extracto de Ortiga, Tensoactivos suaves',
                        'activos' => 'Extracto de Ortiga',
                        'formato' => '420ml',
                        'rating' => 4,
                        'dondeComprar' => 'Farmacity, Supermercados',
                    ],
                ],
                'Acondicionador' => [
                    [
                        'name' => 'Redken Extreme Conditioner',
                        'brand_id' => 7,
                        'image' => 'redken_extreme_conditioner.jpg',
                        'description' => 'Acondicionador fortalecedor para cabello débil y quebradizo. Reconstruye la fibra capilar.',
                        'ingredients' => 'Aqua, Cetearyl Alcohol, Behentrimonium Chloride, Proteínas',
                        'activos' => 'Proteínas, Ceramidas',
                        'formato' => '250ml',
                        'rating' => 5,
                        'dondeComprar' => 'Mercado Libre, Salones',
                    ],
                    [
                        'name' => 'Elvive Oleo Extraordinario Nutrición Intensa', // Producto popular globalmente y con buena presencia nacional (L'Oréal)
                        'brand_id' => 6,
                        'image' => 'elvive_oleo.jpg',
                        'description' => 'Acondicionador enriquecido con 6 óleos de flores preciosas para nutrición intensa.',
                        'ingredients' => 'Óleos de flores, Glicerina',
                        'activos' => 'Óleos nutritivos',
                        'formato' => '400ml',
                        'rating' => 4,
                        'dondeComprar' => 'Supermercados, Farmacity',
                    ],
                ],
                'Tratamientos' => [
                    [
                        'name' => 'Olaplex No. 3 Hair Perfector',
                        'brand_id' => 17,
                        'image' => 'olaplex_no3.jpg',
                        'description' => 'Tratamiento pre-shampoo para fortalecer el cabello. Repara los enlaces de disulfuro dañados.',
                        'ingredients' => 'Bis-Aminopropyl Diglycol Dimaleate, Agua',
                        'activos' => 'Molécula Bis-Aminopropyl Diglycol Dimaleate',
                        'formato' => '100ml',
                        'rating' => 5,
                        'dondeComprar' => 'Tiendas especializadas, Salones',
                    ],
                ],
            ],
            'Bodycare' => [
                'Hidratantes Corporales' => [
                    [
                        'name' => 'Nivea Milk Nutritiva Piel Seca', // Producto Nacional/Global muy popular
                        'brand_id' => 18,
                        'image' => 'nivea_milk_nutritiva.jpg',
                        'description' => 'Leche corporal de uso diario para piel seca a muy seca. 48h de hidratación.',
                        'ingredients' => 'Aceite de almendras, Glicerina',
                        'activos' => 'Aceite de Almendras',
                        'formato' => '400ml',
                        'rating' => 4,
                        'dondeComprar' => 'Supermercados, Farmacity',
                    ],
                    [
                        'name' => 'Cetaphil Loción Hidratante Corporal',
                        'brand_id' => 19,
                        'image' => 'cetaphil_lotion.jpg',
                        'description' => 'Loción ligera y no grasa para el cuerpo, ideal para piel sensible o irritada.',
                        'ingredients' => 'Glicerina, Aceite de Macadamia',
                        'activos' => 'Pantenol, Niacinamida',
                        'formato' => '473ml',
                        'rating' => 5,
                        'dondeComprar' => 'Farmacity, Farmacias',
                    ],
                ],
            ],
        ];

        // ---------------------------------------------------------------------
        // 3. CREACIÓN DINÁMICA DE TIPOS, CATEGORÍAS Y PRODUCTOS
        // ---------------------------------------------------------------------

        foreach ($typesCategories as $typeName => $categories) {
            // 3.1 Crear o encontrar el Tipo de Producto
            $type = ProductType::firstOrCreate(['name' => $typeName]);

            foreach ($categories as $categoryName => $products) {
                // 3.2 Crear o encontrar la Categoría de Producto
                $category = ProductCategory::firstOrCreate([
                    'name' => $categoryName,
                    'type_id' => $type->id // Usamos el ID de Type recién creado
                ]);

                foreach ($products as $productData) {
                    // 3.3 Reemplazar el brand_id codificado por el ID real de la DB
                    $originalBrandId = $productData['brand_id'];
                    $productData['brand_id'] = $actualBrands[$originalBrandId];

                    // 3.4 Insertar o Actualizar el Producto
                    Product::updateOrCreate(
                        ['name' => $productData['name']], // Criterio para buscar si ya existe
                        array_merge($productData, [
                            'type_id' => $type->id,
                            'category_id' => $category->id,
                            'image' => 'images/products/' . $productData['image'], // Generamos la ruta completa
                        ])
                    );
                }
            }
        }
    }
}
