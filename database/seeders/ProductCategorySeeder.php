<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductCategory;
use App\Models\ProductType;

class ProductCategorySeeder extends Seeder
{
    public function run()
    {
        // Traemos tipos para asociar
        $facial = ProductType::where('name', 'Cuidado Facial')->first();
        $capilar = ProductType::where('name', 'Cuidado Capilar')->first();

        $categories = [
            ['name' => 'Limpiadores', 'type_id' => $facial->id],
            ['name' => 'Hidratantes', 'type_id' => $facial->id],
            ['name' => 'Shampoo', 'type_id' => $capilar->id],
            ['name' => 'Acondicionador', 'type_id' => $capilar->id],
        ];

        foreach ($categories as $category) {
            ProductCategory::create($category);
        }
    }
}
