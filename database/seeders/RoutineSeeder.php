<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Routine;
use App\Models\RoutineType;
use App\Models\RoutineTime;

class RoutineSeeder extends Seeder
{
    public function run()
    {
        // Tipos de piel/cabello
        $types = RoutineType::whereIn('name', ['normal','seco','graso','mixto','sensible'])->get()->keyBy('name');

        // Tiempos de rutina
        $times = RoutineTime::whereIn('name', ['Día','Noche'])->get()->keyBy('name');

        // Rutinas ejemplo
        $examples = [
            ['name' => 'Rutina Normal',   'type' => 'normal',   'time' => 'Día',   'products' => [1,2,3]],
            ['name' => 'Rutina Seco',     'type' => 'seco',     'time' => 'Noche', 'products' => [4,5,6]],
            ['name' => 'Rutina Graso',    'type' => 'graso',    'time' => 'Día',   'products' => [7,8,9]],
            ['name' => 'Rutina Mixto',    'type' => 'mixto',    'time' => 'Día',   'products' => [10,11,12]],
            ['name' => 'Rutina Sensible', 'type' => 'sensible', 'time' => 'Noche', 'products' => [13,14,15]],
        ];

        foreach ($examples as $ex) {
            if (!isset($types[$ex['type']])) continue;

            $routine = Routine::updateOrCreate(
                [
                    'name' => $ex['name'],
                    'routine_type_id' => $types[$ex['type']]->type_id,
                    'time_id' => $times[$ex['time']]->time_id ?? null,
                ],
                [
                    'products' => $ex['products'], // se convierte automáticamente a JSON gracias al mutator
                    'user_id' => 1, // opcional, si quieres rutinas globales para usuario admin
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
