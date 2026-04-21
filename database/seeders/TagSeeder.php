<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\Type;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            'Estilo de Vida y Hábitos',
            'Salud Mental',
            'Salud de la Piel',
            'Ingredientes',
        ];

        foreach ($tags as $tag) {
            Tag::updateOrCreate(
                ['slug' => Str::slug($tag)], // clave única
                ['name' => $tag] // datos a actualizar/crear
            );
        }

        Type::all()->each(function ($type) {
            $type->update([
                'slug' => Str::slug($type->name)
            ]);
        });
    }
}