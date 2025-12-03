<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Routine;
use App\Models\Product;
use App\Models\RoutineType;
use App\Models\RoutineTime;

class RoutineSeeder extends Seeder
{
    public function run()
    {
        // Obtener tipos y tiempos
        $skincareType = RoutineType::firstOrCreate(['name' => 'Skincare']);
        $haircareType = RoutineType::firstOrCreate(['name' => 'Haircare']);

        $dayTime = RoutineTime::firstOrCreate(['name' => 'Día']);
        $nightTime = RoutineTime::firstOrCreate(['name' => 'Noche']);

        // Productos (suponiendo que ya están en DB)
        $products = Product::all()->keyBy('name');

        // Rutinas Skincare
        $skincareRoutines = [
            'normal' => [
                'time' => $dayTime->name,
                'products' => [
                    $products['Crema Hidratante']->id ?? null,
                    $products['Protector Solar Diario']->id ?? null,
                ],
            ],
            'seca' => [
                'time' => $nightTime->name,
                'products' => [
                    $products['Crema Hidratante']->id ?? null,
                    $products['Serum Ácido Hialurónico']->id ?? null,
                ],
            ],
            'grasa' => [
                'time' => $dayTime->name,
                'products' => [
                    $products['Crema Hidratante']->id ?? null,
                ],
            ],
            'mixta' => [
                'time' => $dayTime->name,
                'products' => [
                    $products['Crema Hidratante']->id ?? null,
                ],
            ],
            'sensible' => [
                'time' => $nightTime->name,
                'products' => [
                    $products['Crema Hidratante']->id ?? null,
                ],
            ],
        ];

        foreach ($skincareRoutines as $name => $data) {
            Routine::updateOrCreate([
    'name' => 'normal',
    'type' => 'Skincare',
    'time' => 'Día',
    'products' => '[]',
]);

        }

        // Rutinas Haircare
        $haircareRoutines = [
            'normal' => [
                'time' => $dayTime->name,
                'products' => [
                    $products['Shampoo Suave']->id ?? null,
                    $products['Acondicionador Ligero']->id ?? null,
                    $products['Mascarilla Nutritiva']->id ?? null,
                ],
            ],
            'seco' => [
                'time' => $nightTime->name,
                'products' => [
                    $products['Shampoo Suave']->id ?? null,
                    $products['Acondicionador Ligero']->id ?? null,
                    $products['Mascarilla Nutritiva']->id ?? null,
                ],
            ],
            'graso' => [
                'time' => $dayTime->name,
                'products' => [
                    $products['Shampoo Suave']->id ?? null,
                    $products['Acondicionador Ligero']->id ?? null,
                ],
            ],
            'mixto' => [
                'time' => $dayTime->name,
                'products' => [
                    $products['Shampoo Suave']->id ?? null,
                    $products['Acondicionador Ligero']->id ?? null,
                    $products['Mascarilla Nutritiva']->id ?? null,
                ],
            ],
        ];

        foreach ($haircareRoutines as $name => $data) {
            Routine::updateOrCreate([
                'name' => 'normal',
                'type' => 'Skincare',
                'time' => 'Día',
                'products' => '[]',
            ]);

        }
    }
}
