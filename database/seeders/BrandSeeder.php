<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandSeeder extends Seeder
{
    public function run()
    {
        $brands = [
            ['name' => 'CeraVe'],
            ['name' => 'La Roche-Posay'],
            ['name' => 'Olaplex'],
            ['name' => 'Moroccanoil'],
        ];

        foreach ($brands as $brand) {

Brand::firstOrCreate(
    ['name' => 'CeraVe'], // condición para buscar
    ['name' => 'CeraVe']  // datos a crear si no existe
);

Brand::firstOrCreate(['name' => 'La Roche-Posay']);
Brand::firstOrCreate(['name' => 'Neutrogena']);
Brand::firstOrCreate(['name' => 'Bioderma']);

        }
    }
}
