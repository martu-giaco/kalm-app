<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SkinType;

class SkinTypeSeeder extends Seeder
{
    public function run()
    {
        $types = [
            ['name' => 'seca'],
            ['name' => 'oleosa'],
            ['name' => 'mixta'],
            ['name' => 'sensible'],
        ];

        foreach ($types as $type) {
            SkinType::create($type);
        }
    }
}
