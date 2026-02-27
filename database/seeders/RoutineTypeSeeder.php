<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RoutineType;

class RoutineTypeSeeder extends Seeder
{
    public function run()
    {
        $types = [
            'Skincare',
            'Haircare',
            'Bodycare'
        ];

        foreach ($types as $name) {
            RoutineType::updateOrCreate(
                ['name' => $name], // criterio único
                ['updated_at' => now(), 'created_at' => now()] // solo timestamps
            );
        }
    }
}
