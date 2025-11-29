<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tests')->insert([
            'test_id' => 1,
            'key' => 'piel',
            'title' => 'Tu rutina ideal de Skincare',
            'questions' => json_encode([
                [
                    "text" => "Al despertar, ¿cómo se siente tu cabello?",
                    "options" => [
                        [
                            "text" => "Suave y manejable, sin sensación de grasa ni resequedad",
                            "scoreKey" => "normal"
                        ],
                        [
                            "text" => "Seco, áspero o con puntas abiertas",
                            "scoreKey" => "seco"
                        ],
                        [
                            "text" => "Grasoso o pegajoso, especialmente en la raíz",
                            "scoreKey" => "graso"
                        ],
                        [
                            "text" => "Graso en la raíz y seco en las puntas",
                            "scoreKey" => "mixto"
                        ]
                    ]
                ],
                [
                    "text" => "¿Con qué frecuencia tu cabello se ensucia o se engrasa?",
                    "options" => [
                        [
                            "text" => "Se mantiene limpio por varios días",
                            "scoreKey" => "normal"
                        ],
                        [
                            "text" => "Se ve opaco y seco, incluso después de lavar",
                            "scoreKey" => "seco"
                        ],
                        [
                            "text" => "Se engrasa rápido, incluso al día siguiente del lavado",
                            "scoreKey" => "graso"
                        ],
                        [
                            "text" => "Se engrasa en la raíz pero las puntas siguen secas",
                            "scoreKey" => "mixto"
                        ]
                    ]
                ],
                [
                    "text" => "¿Cómo se siente tu cabello después de lavarlo?",
                    "options" => [
                        [
                            "text" => "Fresco, suave y manejable",
                            "scoreKey" => "normal"
                        ],
                        [
                            "text" => "Seco o áspero, difícil de peinar",
                            "scoreKey" => "seco"
                        ],
                        [
                            "text" => "Grasoso o pesado en la raíz",
                            "scoreKey" => "graso"
                        ],
                        [
                            "text" => "Ligero en las puntas pero pesado o grasoso en la raíz",
                            "scoreKey" => "mixto"
                        ]
                    ]
                ],
                [
                    "text" => "¿Cómo se siente tu cabello después de lavarlo?",
                    "options" => [
                        [
                            "text" => "Fresco, suave y manejable",
                            "scoreKey" => "normal"
                        ],
                        [
                            "text" => "Seco o áspero, difícil de peinar",
                            "scoreKey" => "seco"
                        ],
                        [
                            "text" => "Grasoso o pesado en la raíz",
                            "scoreKey" => "graso"
                        ],
                        [
                            "text" => "Ligero en las puntas pero pesado o grasoso en la raíz",
                            "scoreKey" => "mixto"
                        ]
                    ]
                ]
            ]);
    }
}
