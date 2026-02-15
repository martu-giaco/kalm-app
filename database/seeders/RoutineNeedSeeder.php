<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RoutineNeed;

class RoutineNeedSeeder extends Seeder
{
    public function run()
    {
        $needs = [
            'normal',
            'seco',
            'graso',
            'mixto',
            'sensible',
        ];

        foreach ($needs as $name) {
            RoutineNeed::updateOrCreate(
                ['name' => $name], // criterio único
                ['updated_at' => now(), 'created_at' => now()] // solo timestamps
            );
        }
    }
}
