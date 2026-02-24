<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Routine;
use App\Models\RoutineType;
use App\Models\RoutineTime;
use App\Models\RoutineNeed;
use App\Models\User;

class RoutineSeeder extends Seeder
{
    public function run()
    {
        // Crear usuario "infalible" si no existe
        $user = User::firstOrCreate(
            ['email' => 'seeduser@example.com'],
            ['name' => 'Usuario Seed', 'password' => bcrypt('password')]
        );

        // Asegurarse de que existan los tipos
        $typesList = ['skincare','haircare'];
        foreach ($typesList as $typeName) {
            RoutineType::firstOrCreate(['name' => $typeName]);
        }

        // Asegurarse de que existan las necesidades
        $needsList = ['Normal','Seca','Oleosa','Mixta','Sensible'];
        foreach ($needsList as $needName) {
            RoutineNeed::firstOrCreate(['name' => $needName]);
        }

        // Asegurarse de que existan los tiempos
        $timesList = ['Día','Noche'];
        foreach ($timesList as $timeName) {
            RoutineTime::firstOrCreate(['name' => $timeName]);
        }

        // Cargar tipos y tiempos existentes
        $types = RoutineType::whereIn('name', $typesList)->get()->keyBy('name');
        $times = RoutineTime::whereIn('name', $timesList)->get()->keyBy('name');

        $examples = [
            ['name' => 'Rutina Normal',   'type' => 'Normal',   'time' => 'Día',   'products' => [1,2,3]],
            ['name' => 'Rutina Seca',     'type' => 'Seca',     'time' => 'Noche', 'products' => [4,5,6]],
            ['name' => 'Rutina Oleosa',    'type' => 'Oleosa',    'time' => 'Día',   'products' => [7,8,9]],
            ['name' => 'Rutina Mixta',    'type' => 'Mixta',    'time' => 'Día',   'products' => [10,11,12]],
            ['name' => 'Rutina Sensible', 'type' => 'Sensible', 'time' => 'Noche', 'products' => [13,14,15]],
            ['name' => 'Rutina Extra 1',  'type' => 'Normal',   'time' => 'Día',   'products' => [16,17]],
            ['name' => 'Rutina Extra 2',  'type' => 'Seca',     'time' => 'Noche', 'products' => [18,19]],
            ['name' => 'Rutina Extra 3',  'type' => 'Oleosa',    'time' => 'Día',   'products' => [20,21,22]],
        ];

        foreach ($examples as $ex) {
            if (!isset($types[$ex['type']])) continue;

            Routine::updateOrCreate(
                [
                    'name' => $ex['name'],
                    'time_id' => $times[$ex['time']]->time_id ?? null,
                    'user_id' => $user->id, // usar el usuario "infalible"
                ],
                [
                    'products' => $ex['products'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
