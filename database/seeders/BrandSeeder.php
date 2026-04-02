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
            ['id' => 1,
            'name' => 'CeraVe',
            'logo' => 'images/logos/cerave.jpg',
            ],
            ['id' => 2,
             'name' => 'La Roche-Posay',
             'logo' => 'images/logos/la-roche-posay.jpg',
            ],
            ['id' => 3, 'name' => 'Neutrogena', 'logo' => 'images/logos/neutrogena.jpg'],
            ['id' => 4, 'name' => 'SkinFree', 'logo' => 'images/logos/skinfree.jpg'],
            ['id' => 5, 'name' => 'Kérastase', 'logo' => 'images/logos/kerastase.jpg'],
            ['id' => 6, 'name' => 'L’Oréal', 'logo' => 'images/logos/loreal.jpg'],
            ['id' => 7, 'name' => 'Redken', 'logo' => 'images/logos/redken.jpg'],
            ['id' => 8, 'name' => 'Icono Cosmetica', 'logo' => 'images/logos/icono-cosmetica.jpg'],
            ['id' => 9, 'name' => 'The Ordinary', 'logo' => 'images/logos/the-ordinary.jpg'],
            ['id' => 10, 'name' => 'Dermaglós', 'logo' => 'images/logos/dermaglos.jpg'],
            ['id' => 11, 'name' => 'Eucerin', 'logo' => 'images/logos/eucerin.jpg'],
            ['id' => 12, 'name' => 'Isdin', 'logo' => 'images/logos/isdin.jpg'],
            ['id' => 13, 'name' => 'Vichy', 'logo' => 'images/logos/vichy.jpg'],
            ['id' => 14, 'name' => 'The Glow Factor', 'logo' => 'images/logos/the-glow-factor.jpg'],
            ['id' => 15, 'name' => 'Paula\'s Choice', 'logo' => 'images/logos/paulas-choice.jpg'],
            ['id' => 16, 'name' => 'Capilatis', 'logo' => 'images/logos/capilatis.jpg'],
            ['id' => 17, 'name' => 'Olaplex', 'logo' => 'images/logos/olaplex.jpg'],
            ['id' => 18, 'name' => 'Nivea', 'logo' => 'images/logos/nivea.jpg'],
            ['id' => 19, 'name' => 'Cetaphil', 'logo' => 'images/logos/cetaphil.jpg'],
            ['id' => 20, 'name' => 'Avène', 'logo' => 'images/logos/avene.jpg'],
            ['id' => 21, 'name' => 'Bioderma', 'logo' => 'images/logos/bioderma.jpg'],
            ['id' => 22, 'name' => 'EltaMD', 'logo' => 'images/logos/elta-md.jpg'],
            ['id' => 23, 'name' => 'Nécessaire', 'logo' => 'images/logos/necessaire.jpg'],
            ['id' => 24, 'name' => 'Aveeno', 'logo' => 'images/logos/aveeno.jpg'],
            ['id' => 25, 'name' => 'SkinCeuticals', 'logo' => 'images/logos/skinceuticals.jpg'],
            ['id' => 26, 'name' => 'Blue Lizard', 'logo' => 'images/logos/blue-lizzard.jpg'],
            ['id' => 27, 'name' => 'COSRX', 'logo' => 'images/logos/cosrx.jpg'],
            ['id' => 28, 'name' => 'Aestura', 'logo' => 'images/logos/aestura.jpg'],
            ['id' => 29, 'name' => 'Moroccanoil', 'logo' => 'images/logos/moroccanoil.jpg'],
            ['id' => 30, 'name' => 'Vegamour', 'logo' => 'images/logos/vegamour.jpg'],
            ['id' => 31, 'name' => 'Nizoral', 'logo' => 'images/logos/nizoral.jpg'],
        ]);
    }
}
