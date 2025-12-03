<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RoutineTime; // ajustá el namespace si hace falta

class RoutineTimeSeeder extends Seeder
{
    public function run()
    {
        $items = [
            ['name' => 'Día',  'time_id' => 1],
            ['name' => 'Noche','time_id' => 2],
            // añade más si corresponde
        ];

        foreach ($items as $item) {
            RoutineTime::updateOrCreate(
                ['name' => $item['name']],       // criterio único
                ['time_id' => $item['time_id']]  // valores a setear/actualizar
            );
        }
    }
}
