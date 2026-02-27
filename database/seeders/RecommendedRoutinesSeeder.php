<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\RecommendedRoutine;

class RecommendedRoutinesSeeder extends Seeder
{
    public function run()
    {
        DB::table('routines_recommended')->insert();

        // Productos por tipo (IDs según tu tabla products)
        $products = [
            'skincare' => [
                'normal' => [1,2,3],
                'seco' => [4,5,6],
                'graso' => [7,8,9],
                'mixto' => [10,11,12],
                'sensible' => [13,14,15],
            ],
            'haircare' => [
                'normal' => [16,17,18],
                'seco' => [19,20,21],
                'graso' => [22,23,24],
                'mixto' => [25,26,27],
                'sensible' => [28,29,30],
            ],
        ];

        $descriptions = [
            'skincare' => [
                'normal' => 'Mantiene un equilibrio natural de hidratación y sebo.',
                'seco' => 'Hidrata y nutre intensamente la piel seca.',
                'graso' => 'Controla el exceso de grasa y previene brillos.',
                'mixto' => 'Equilibra zonas grasas con áreas más secas.',
                'sensible' => 'Suaviza y protege la piel sensible.',
            ],
            'haircare' => [
                'normal' => 'Mantiene el cabello saludable y brillante.',
                'seco' => 'Hidrata y repara el cabello seco o dañado.',
                'graso' => 'Controla el exceso de grasa y mantiene el cabello limpio.',
                'mixto' => 'Equilibra raíces grasas y puntas secas.',
                'sensible' => 'Cuida el cuero cabelludo sensible y frágil.',
            ],
        ];

        $routines = [];

        foreach (['skincare','haircare'] as $testKey) {
            foreach (['normal','seco','graso','mixto','sensible'] as $resultKey) {
                // Rutina de mañana
                $routines[] = [
                    'test_key' => $testKey,
                    'result_key' => $resultKey,
                    'name' => ucfirst($resultKey) . " - Mañana",
                    'description' => $descriptions[$testKey][$resultKey],
                    'products' => json_encode($products[$testKey][$resultKey]),
                    'time_of_day' => 'mañana',
                    'frequency' => 'diaria',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                // Rutina de noche
                $routines[] = [
                    'test_key' => $testKey,
                    'result_key' => $resultKey,
                    'name' => ucfirst($resultKey) . " - Noche",
                    'description' => $descriptions[$testKey][$resultKey],
                    'products' => json_encode($products[$testKey][$resultKey]),
                    'time_of_day' => 'noche',
                    'frequency' => 'diaria',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('routines_recommended')->insert($routines);
    }
}
