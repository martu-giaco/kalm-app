<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Concern;

class ConcernSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $concerns = [
        'Acné',
        'Manchas',
        'Arrugas',
        'Rosácea',
        'Poros Dilatados',
        'Ojeras',
        'Eczema',
        'Puntos Negros',
        ];

        foreach ($concerns as $concern) {
            Concern::firstOrCreate(['name' => $concern]);
        }
    }
}
