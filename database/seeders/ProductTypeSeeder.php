<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductType;

class ProductTypeSeeder extends Seeder
{
    public function run()
    {
        $types = [
            ['name' => 'Skincare'],
            ['name' => 'Haircare'],
        ];

        foreach ($types as $type) {
            ProductType::create($type);
        }
    }
}
