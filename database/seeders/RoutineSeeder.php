<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Models\Routine;
use App\Models\Product;
use App\Models\RoutineType;
use App\Models\RoutineTime;

class RoutineSeeder extends Seeder
{
    public function run()
    {
        DB::table('routines')->insert([
            ['routine_id'=>10, 'name'=> 'normal', 'routine_type_id'=> '1', 'products'=> json_encode([2, 7, 1, 10]), 'created_at' => now(), 'updated_at' => now()],
            ['routine_id'=>2, 'name'=> 'seca', 'routine_type_id'=> '1', 'products'=> json_encode([2, 7, 1, 10]), 'created_at' => now(), 'updated_at' => now()],
            ['routine_id'=>3, 'name'=> 'grasa', 'routine_type_id'=> '1', 'products'=> json_encode([2, 7, 1, 10]), 'created_at' => now(), 'updated_at' => now()],
            ['routine_id'=>4, 'name'=> 'mixta', 'routine_type_id'=> '1', 'products'=> json_encode([2, 7, 1, 10]), 'created_at' => now(), 'updated_at' => now()],
            ['routine_id'=>5, 'name'=> 'sensible', 'routine_type_id'=> '1', 'products'=> json_encode([2, 7, 1, 10]), 'created_at' => now(), 'updated_at' => now()],
            ['routine_id'=>6, 'name'=> 'normal', 'routine_type_id'=> '2', 'products'=> json_encode([2, 7, 1, 10]), 'created_at' => now(), 'updated_at' => now()],
            ['routine_id'=>7, 'name'=> 'seco', 'routine_type_id'=> '2', 'products'=> json_encode([2, 7, 1, 10]), 'created_at' => now(), 'updated_at' => now()],
            ['routine_id'=>8, 'name'=> 'graso', 'routine_type_id'=> '2', 'products'=> json_encode([2, 7, 1, 10]), 'created_at' => now(), 'updated_at' => now()],
            ['routine_id'=>9, 'name'=> 'mixto', 'routine_type_id'=> '2', 'products'=> json_encode([2, 7, 1, 10]), 'created_at' => now(), 'updated_at' => now()],
        ]);

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
