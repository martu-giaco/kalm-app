<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoutineTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('routine_types')->insert([
            ['type_id'=>1, 'name'=> 'Haircare', 'created_at' => now(), 'updated_at' => now()],
            ['type_id'=>2, 'name'=> 'Skincare', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
