<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductType;
use App\Models\ProductCategory;

class ProductCategorySeeder extends Seeder
{
    public function run()
    {
        // Aseguramos que existan los tipos sin incluir 'slug'
        $facial = ProductType::firstOrCreate(['name' => 'Cuidado Facial']);
        $capilar = ProductType::firstOrCreate(['name' => 'Cuidado Capilar']);

        $categories = [
            ['name' => 'Limpiadores', 'type_id' => $facial->id],
            ['name' => 'Hidratantes', 'type_id' => $facial->id],
            ['name' => 'Serums', 'type_id' => $facial->id],
            ['name' => 'Shampoo', 'type_id' => $capilar->id],
            ['name' => 'Acondicionador', 'type_id' => $capilar->id],
            ['name' => 'Mascarillas Capilares', 'type_id' => $capilar->id],
        ];

        foreach ($categories as $cat) {
            // Ajustá 'type_id' si tu FK se llama distinto (ej: 'product_type_id')
            ProductCategory::firstOrCreate(
                ['name' => $cat['name'], 'type_id' => $cat['type_id']]
            );
        }
    }
}
