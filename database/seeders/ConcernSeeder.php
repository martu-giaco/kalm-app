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
        $concerns = [
            'Acné',
            'Manchas',
            'Arrugas',
            'Rosácea',
            'Poros Dilatados',
            'Ojeras',
            'Eczema',
            'Puntos Negros',
            'Sin Fragancia',
            'Sin TACC',
            'Puntas Abiertas',
            'Cabello Dañado',
            'Caspa',
            'Caída del cabello',
        ];

        foreach ($concerns as $name) {
            Concern::updateOrCreate(
                ['name' => $name], // condición (único)
                ['name' => $name]  // valores a actualizar (podés agregar más campos)
            );
        }
    }
}
