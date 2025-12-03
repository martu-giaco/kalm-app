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
            ['name' => 'Haircare', 'type_id' => 1],
            ['name' => 'Skincare', 'type_id' => 2],
            // agregá más si corresponde
        ];

        foreach ($items as $item) {
            // Usa firstOrCreate para evitar duplicados por nombre (o por type_id+name)
            RoutineType::firstOrCreate(
                ['name' => $item['name']], // criterio de búsqueda
                ['type_id' => $item['type_id']] // valores a setear si no existe
            );
        }
    }
}
