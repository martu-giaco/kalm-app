<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SkinType;

class SkinTypeSeeder extends Seeder
{
    public function run()
    {
        $types = [
            ['name' => 'Normal'],
            ['name' => 'Seca'],
            ['name' => 'Oleosa'],
            ['name' => 'Mixta'],
            ['name' => 'Sensible'],
        ];

        foreach ($types as $type) {
            SkinType::create($type);
        }
    }
}
