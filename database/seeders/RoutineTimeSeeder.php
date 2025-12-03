<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoutineTimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('routine_times')->insert([
            ['time_id'=>1, 'name'=> 'Día', 'created_at' => now(), 'updated_at' => now()],
            ['time_id'=>2, 'name'=> 'Noche', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
