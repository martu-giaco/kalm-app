<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // TEST 1 — CABELLO
        DB::table('tests')->insert([
            'key' => 'cabello',
            'title' => 'Tu rutina ideal de Haircare',
            'description' => 'Descubrí qué tipo de rutina necesita tu cabello.',
            'questions' => json_encode([
                [
                    "text" => "Al despertar, ¿cómo se siente tu cabello?",
                    "options" => [
                        ["text" => "Suave y manejable, sin sensación de grasa ni resequedad", "scoreKey" => "normal"],
                        ["text" => "Seco, áspero o con puntas abiertas", "scoreKey" => "seco"],
                        ["text" => "Grasoso o pegajoso, especialmente en la raíz", "scoreKey" => "graso"],
                        ["text" => "Graso en la raíz y seco en las puntas", "scoreKey" => "mixto"]
                    ]
                ],
                [
                    "text" => "¿Con qué frecuencia tu cabello se ensucia o se engrasa?",
                    "options" => [
                        ["text" => "Se mantiene limpio por varios días", "scoreKey" => "normal"],
                        ["text" => "Se ve opaco y seco, incluso después de lavar", "scoreKey" => "seco"],
                        ["text" => "Se engrasa rápido, incluso al día siguiente del lavado", "scoreKey" => "graso"],
                        ["text" => "Se engrasa en la raíz pero las puntas siguen secas", "scoreKey" => "mixto"]
                    ]
                ],
                [
                    "text" => "¿Cómo se siente tu cabello después de lavarlo?",
                    "options" => [
                        ["text" => "Fresco, suave y manejable", "scoreKey" => "normal"],
                        ["text" => "Seco o áspero, difícil de peinar", "scoreKey" => "seco"],
                        ["text" => "Grasoso o pesado en la raíz", "scoreKey" => "graso"],
                        ["text" => "Ligero en las puntas pero pesado o grasoso en la raíz", "scoreKey" => "mixto"]
                    ]
                ]
            ])
        ]);

        // TEST 2 — PIEL
        DB::table('tests')->insert([
            'key' => 'piel',
            'title' => 'Tu rutina ideal de Skincare',
            'description' => '10 preguntas para identificar tu tipo de piel.',
            'questions' => json_encode([

                [
                    "text" => "Cuando te levantás, antes de lavarte la cara, tu piel se siente...",
                    "options" => [
                        ["text" => "Cómoda, ni muy seca ni con brillo", "scoreKey" => "normal"],
                        ["text" => "Tirante, como si necesitara crema", "scoreKey" => "seca"],
                        ["text" => "Muy brillante o aceitosa, sobre todo en la frente", "scoreKey" => "grasa"],
                        ["text" => "Con brillo en la frente pero seca en las mejillas", "scoreKey" => "mixta"],
                        ["text" => "Roja o con sensación de ardor", "scoreKey" => "sensible"]
                    ]
                ],

                [
                    "text" => "Al final del día, sin haberte lavado la cara, notás que tu piel...",
                    "options" => [
                        ["text" => "Se ve igual que en la mañana, equilibrada", "scoreKey" => "normal"],
                        ["text" => "Está seca o con partes escamadas", "scoreKey" => "seca"],
                        ["text" => "Brilla mucho o se siente grasosa", "scoreKey" => "grasa"],
                        ["text" => "Tiene partes brillantes y otras secas", "scoreKey" => "mixta"],
                        ["text" => "Se ve irritada o con enrojecimiento", "scoreKey" => "sensible"]
                    ]
                ],

                [
                    "text" => "Cuando aplicas una crema o protector solar, tu piel...",
                    "options" => [
                        ["text" => "Lo absorbe bien, sin reacción", "scoreKey" => "normal"],
                        ["text" => "Se siente seca igual, como si no alcanzara la hidratación", "scoreKey" => "seca"],
                        ["text" => "Se ve más brillante o pesada", "scoreKey" => "grasa"],
                        ["text" => "En algunas zonas se absorbe bien y en otras queda brillosa", "scoreKey" => "mixta"],
                        ["text" => "Se irrita o pica con algunos productos", "scoreKey" => "sensible"]
                    ]
                ],

                [
                    "text" => "¿Qué tan seguido sentís la necesidad de hidratarte la cara?",
                    "options" => [
                        ["text" => "A veces, pero no siempre", "scoreKey" => "normal"],
                        ["text" => "Todos los días, o varias veces al día", "scoreKey" => "seca"],
                        ["text" => "Casi nunca, se siente hidratada sola", "scoreKey" => "grasa"],
                        ["text" => "Algunas partes sí, otras no", "scoreKey" => "mixta"],
                        ["text" => "No siempre, porque muchos productos me irritan", "scoreKey" => "sensible"]
                    ]
                ],

                [
                    "text" => "¿Cómo reacciona tu piel después de bañarte con agua caliente?",
                    "options" => [
                        ["text" => "No noto grandes cambios", "scoreKey" => "normal"],
                        ["text" => "Queda tirante o con picazón", "scoreKey" => "seca"],
                        ["text" => "Se pone brillante o aceitosa", "scoreKey" => "grasa"],
                        ["text" => "Algunas zonas se secan y otras no", "scoreKey" => "mixta"],
                        ["text" => "Se enrojece o se irrita", "scoreKey" => "sensible"]
                    ]
                ],

                [
                    "text" => "Cuando hace mucho calor o humedad, tu piel tiende a...",
                    "options" => [
                        ["text" => "Mantenerse igual", "scoreKey" => "normal"],
                        ["text" => "Sentirse un poco más seca o incómoda", "scoreKey" => "seca"],
                        ["text" => "Volverse más brillante o pegajosa", "scoreKey" => "grasa"],
                        ["text" => "Brillosa en la frente pero seca en mejillas", "scoreKey" => "mixta"],
                        ["text" => "Irritarse o brotarse", "scoreKey" => "sensible"]
                    ]
                ],

                [
                    "text" => "Si te mirás al espejo con luz natural, tus poros se ven...",
                    "options" => [
                        ["text" => "Normales, sin resaltar demasiado", "scoreKey" => "normal"],
                        ["text" => "Muy finos o poco visibles", "scoreKey" => "seca"],
                        ["text" => "Grandes y marcados", "scoreKey" => "grasa"],
                        ["text" => "Más visibles en la frente o nariz, menos en mejillas", "scoreKey" => "mixta"],
                        ["text" => "Normales, pero con tendencia a enrojecerse", "scoreKey" => "sensible"]
                    ]
                ],

                [
                    "text" => "Después de hacer ejercicio o sudar, tu piel se ve...",
                    "options" => [
                        ["text" => "Sonrojada, pero vuelve a la normalidad rápido", "scoreKey" => "normal"],
                        ["text" => "Seca o áspera", "scoreKey" => "seca"],
                        ["text" => "Muy brillante o con sensación grasosa", "scoreKey" => "grasa"],
                        ["text" => "Brillante en la frente y seca en otras partes", "scoreKey" => "mixta"],
                        ["text" => "Muy roja o sensible", "scoreKey" => "sensible"]
                    ]
                ],

                [
                    "text" => "Si tocás tu piel a mitad del día, notás que está...",
                    "options" => [
                        ["text" => "Suave y equilibrada", "scoreKey" => "normal"],
                        ["text" => "Áspera o con zonas secas", "scoreKey" => "seca"],
                        ["text" => "Aceitosa o resbaladiza", "scoreKey" => "grasa"],
                        ["text" => "Diferente según la zona", "scoreKey" => "mixta"],
                        ["text" => "Delicada o sensible al tacto", "scoreKey" => "sensible"]
                    ]
                ],

                [
                    "text" => "¿Con cuál de estas frases te identificás más?",
                    "options" => [
                        ["text" => "Mi piel se siente bien sin hacerle mucho", "scoreKey" => "normal"],
                        ["text" => "Me cuesta mantenerla hidratada", "scoreKey" => "seca"],
                        ["text" => "Siempre tengo brillo o granitos", "scoreKey" => "grasa"],
                        ["text" => "Mi piel cambia según el clima o la zona", "scoreKey" => "mixta"],
                        ["text" => "Mi piel reacciona con facilidad a todo", "scoreKey" => "sensible"]
                    ]
                ]

            ])
        ]);
    }
}
