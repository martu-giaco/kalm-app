<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RoutineType; // Ajustá el namespace si es distinto
use Illuminate\Support\Str;

class RoutineTypeSeeder extends Seeder
{
    public function run()
    {
        $items = [
            ['type_id' => 1, 'name' => 'Haircare'],
            ['type_id' => 2, 'name' => 'Skincare'],
        ];

        foreach ($items as $item) {
            RoutineType::updateOrCreate(
                ['type_id' => $item['type_id']], // fuerza ID específico
                ['name' => $item['name']]
            );
        }
    }
}
