<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Type;

class TypeSeeder extends Seeder
{
    public function run()
    {
        $types = [
            ['name' => 'Skincare'],
            ['name' => 'Haircare'],
            ['name' => 'Bodycare'],
        ];

        foreach ($types as $type) {
            Type::create($type);
        }
    }
}
