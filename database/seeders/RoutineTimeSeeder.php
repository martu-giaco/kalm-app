<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RoutineTime;

class RoutineTimeSeeder extends Seeder
{
    public function run()
    {
        $items = [
            ['name' => 'Día'],
            ['name' => 'Noche'],
        ];

        foreach ($items as $item) {
            RoutineTime::updateOrCreate(['name' => $item['name']], $item);
        }
    }
}
