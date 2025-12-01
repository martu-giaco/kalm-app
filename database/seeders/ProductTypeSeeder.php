<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductType;

class ProductTypeSeeder extends Seeder
{
    public function run()
    {
        $types = [
            ['name' => 'Cuidado Facial'],
            ['name' => 'Cuidado Capilar'],
            ['name' => 'Cuidado Corporal'],
            ['name' => 'Maquillaje'],
        ];

        foreach ($types as $type) {
            ProductType::create($type);
        }
    }
}
