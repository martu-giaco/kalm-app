<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Concern;

class ConcernSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('concerns')->insert([
        ['id' => 1, 'name' => 'Acné'],
        ['id' => 2, 'name' => 'Manchas'],
        ['id' => 3, 'name' => 'Arrugas'],
        ['id' => 4, 'name' => 'Rosácea'],
        ['id' => 5, 'name' => 'Poros Dilatados'],
        ['id' => 6, 'name' => 'Ojeras'],
        ['id' => 7, 'name' => 'Eczema'],
        ['id' => 8, 'name' => 'Puntos Negros'],
        ['id' => 9, 'name' => 'Sin Fragancia'],
        ['id' => 10, 'name' => 'Sin TACC'],
        ['id' => 11, 'name' => 'Puntas Abiertas'],
        ['id' => 12, 'name' => 'Cabello Dañado'],
        ['id' => 13, 'name' => 'Caspa'],
        ['id' => 14, 'name' => 'Caída del cabello'],
        ]);
    }
}
