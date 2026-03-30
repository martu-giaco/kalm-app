<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;
use Illuminate\Support\Facades\DB;

class BrandSeeder extends Seeder
{
    public function run()
    {

        DB::table('brands')->insert([
            ['id' => 1, 'name' => 'CeraVe'],
            ['id' => 2, 'name' => 'La Roche-Posay'],
            ['id' => 3, 'name' => 'Neutrogena'],
            ['id' => 4, 'name' => 'SkinFree'],
            ['id' => 5, 'name' => 'Kérastase'],
            ['id' => 6, 'name' => 'L’Oréal'],
            ['id' => 7, 'name' => 'Redken'],
            ['id' => 8, 'name' => 'Icono Cosmetica'],
            ['id' => 9, 'name' => 'The Ordinary'],
            ['id' => 10, 'name' => 'Dermaglós'],
            ['id' => 11, 'name' => 'Eucerin'],
            ['id' => 12, 'name' => 'Isdin'],
            ['id' => 13, 'name' => 'Vichy'],
            ['id' => 14, 'name' => 'Glow Factor'],
            ['id' => 15, 'name' => 'Paula\'s Choice'],
            ['id' => 16, 'name' => 'Capilatis'],
            ['id' => 17, 'name' => 'Olaplex'],
            ['id' => 18, 'name' => 'Nivea'],
            ['id' => 19, 'name' => 'Cetaphil'],
            ['id' => 20, 'name' => 'Avène'],
            ['id' => 21, 'name' => 'Bioderma'],
            ['id' => 22, 'name' => 'EltaMD'],
            ['id' => 23, 'name' => 'Nécessaire'],
            ['id' => 24, 'name' => 'Aveeno'],
            ['id' => 25, 'name' => 'SkinCeuticals'],
            ['id' => 26, 'name' => 'Blue Lizard'],
            ['id' => 27, 'name' => 'COSRX'],
            ['id' => 28, 'name' => 'Aestura'],
            ['id' => 29, 'name' => 'Moroccanoil'],
            ['id' => 30, 'name' => 'Vegamour'],
        ]);
    }
}
