<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandSeeder extends Seeder
{
    public function run()
    {
        $brands = [
            'CeraVe',
            'La Roche-Posay',
            'Neutrogena',
            'Bioderma',
            'Kérastase',
            'L’Oréal',
            'Redken',
        ];

        foreach ($brands as $brandName) {
            Brand::firstOrCreate(
                ['name' => $brandName] // Busca por nombre
            );
        }
    }
}
