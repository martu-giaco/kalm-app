<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Type;
use Illuminate\Support\Str;

class TypeSeeder extends Seeder
{
    public function run()
    {
        $names = ['Skincare', 'Haircare', 'Bodycare'];

        foreach ($names as $name) {
            $slug = Str::slug($name);
            // create explicitly with slug to ensure deterministic seeds
            Type::firstOrCreate([
                'name' => $name,
            ], [
                'slug' => $slug,
            ]);
        }
    }
}
