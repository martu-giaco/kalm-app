<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Tag;
use App\Models\Type;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            'Estilo de Vida y Hábitos',
            'Salud Mental',
            'Salud de la Piel',
            'Ingredientes',
        ];

        foreach ($tags as $tag) {
            Tag::create([
                'name' => $tag,
                'slug' => Str::slug($tag),
            ]);
        }

        Type::all()->each(function ($type) {
            $type->slug = Str::slug($type->name);
            $type->save();
        });
    }
}
