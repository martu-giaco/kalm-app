<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Routine;
use App\Models\Type;
use App\Models\RoutineTime;
use App\Models\RoutineNeed;
use App\Models\User;

class RoutineSeeder extends Seeder
{
    public function run()
    {
        $user = User::firstOrCreate(
            ['email' => 'seeduser@example.com'],
            ['name' => 'Usuario Seed', 'password' => bcrypt('password')]
        );

        $typesList = ['skincare','haircare','bodycare'];
        foreach ($typesList as $typeName) {
            Type::firstOrCreate(['name' => $typeName]);
        }

        $needsList = ['Normal','Seca','Oleosa','Mixta','Sensible'];
        foreach ($needsList as $needName) {
            RoutineNeed::firstOrCreate(['name' => $needName]);
        }

        $timesList = ['Día','Noche'];
        foreach ($timesList as $timeName) {
            RoutineTime::firstOrCreate(['name' => $timeName]);
        }

        $types = Type::whereIn('name', $typesList)->get()->keyBy('name');
        $needs = RoutineNeed::whereIn('name', $needsList)->get()->keyBy('name');
        $times = RoutineTime::whereIn('name', $timesList)->get()->keyBy('name');

        $examples = [
            ['name' => 'Rutina Normal',   'type' => 'skincare', 'need' => 'Normal',   'time' => 'Día',   'reminder' => '08:00:00'],
            ['name' => 'Rutina Seca',     'type' => 'skincare', 'need' => 'Seca',     'time' => 'Noche', 'reminder' => '21:30:00'],
            ['name' => 'Rutina Oleosa',    'type' => 'haircare', 'need' => 'Oleosa',    'time' => 'Día',   'reminder' => '09:00:00'],
            ['name' => 'Rutina Mixta',    'type' => 'skincare', 'need' => 'Mixta',    'time' => 'Día',   'reminder' => '08:30:00'],
            ['name' => 'Rutina Sensible', 'type' => 'bodycare', 'need' => 'Sensible', 'time' => 'Noche', 'reminder' => '22:00:00'],
        ];

        foreach ($examples as $ex) {
            if (!isset($types[$ex['type']])) continue;

            Routine::updateOrCreate(
                [
                    'name' => $ex['name'],
                    'user_id' => $user->id,
                ],
                [
                    'time_id' => $times[$ex['time']]->time_id ?? null,
                    'type_id' => $types[$ex['type']]->id ?? null,
                    'need_id' => $needs[$ex['need']]->need_id ?? null,
                    'reminder_time' => $ex['reminder'],
                    'is_reminder_enabled' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}