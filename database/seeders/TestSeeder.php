<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Test;

class TestSeeder extends Seeder
{
    public function run(): void
    {
        $tests = [
            [
                'key' => 'piel',
                'title' => '¿Qué tipo de piel tengo?',
                'description' => '10 preguntas para identificar tu tipo de piel.',
                'questions' => json_encode([
                    [
                        'text' => 'Cuando te levantás, antes de lavarte la cara, tu piel se siente...',
                        'options' => [
                            ['text' => 'Cómoda, ni muy seca ni con brillo', 'scoreKey' => 'normal'],
                            ['text' => 'Tirante, como si necesitara crema', 'scoreKey' => 'seca'],
                            ['text' => 'Muy brillante o aceitosa, sobre todo en la frente', 'scoreKey' => 'grasa'],
                            ['text' => 'Con brillo en la frente pero seca en las mejillas', 'scoreKey' => 'mixta'],
                            ['text' => 'Roja o con sensación de ardor', 'scoreKey' => 'sensible'],
                        ],
                    ],
                    [
                        'text' => 'Al final del día, sin haberte lavado la cara, notás que tu piel...',
                        'options' => [
                            ['text' => 'Se ve igual que en la mañana, equilibrada', 'scoreKey' => 'normal'],
                            ['text' => 'Está seca o con partes escamadas', 'scoreKey' => 'seca'],
                            ['text' => 'Brilla mucho o se siente grasosa', 'scoreKey' => 'grasa'],
                            ['text' => 'Tiene partes brillantes y otras secas', 'scoreKey' => 'mixta'],
                            ['text' => 'Se ve irritada o con enrojecimiento', 'scoreKey' => 'sensible'],
                        ],
                    ],
                    [
                        'text' => 'Cuando aplicas una crema o protector solar, tu piel...',
                        'options' => [
                            ['text' => 'Lo absorbe bien, sin reacción', 'scoreKey' => 'normal'],
                            ['text' => 'Se siente seca igual, como si no alcanzara la hidratación', 'scoreKey' => 'seca'],
                            ['text' => 'Se ve más brillante o pesada', 'scoreKey' => 'grasa'],
                            ['text' => 'En algunas zonas se absorbe bien y en otras queda brillosa', 'scoreKey' => 'mixta'],
                            ['text' => 'Se irrita o pica con algunos productos', 'scoreKey' => 'sensible'],
                        ],
                    ],
                    [
                        'text' => '¿Qué tan seguido sentís la necesidad de hidratarte la cara?',
                        'options' => [
                            ['text' => 'A veces, pero no siempre', 'scoreKey' => 'normal'],
                            ['text' => 'Todos los días, o varias veces al día', 'scoreKey' => 'seca'],
                            ['text' => 'Casi nunca, se siente hidratada sola', 'scoreKey' => 'grasa'],
                            ['text' => 'Algunas partes sí, otras no', 'scoreKey' => 'mixta'],
                            ['text' => 'No siempre, porque muchos productos me irritan', 'scoreKey' => 'sensible'],
                        ],
                    ],
                    [
                        'text' => '¿Cómo reacciona tu piel después de bañarte o ducharte con agua caliente?',
                        'options' => [
                            ['text' => 'No noto grandes cambios', 'scoreKey' => 'normal'],
                            ['text' => 'Queda tirante o con picazón', 'scoreKey' => 'seca'],
                            ['text' => 'Se pone brillante o aceitosa', 'scoreKey' => 'grasa'],
                            ['text' => 'Algunas zonas se secan y otras no', 'scoreKey' => 'mixta'],
                            ['text' => 'Se enrojece o se irrita', 'scoreKey' => 'sensible'],
                        ],
                    ],
                    [
                        'text' => 'Cuando hace mucho calor o humedad, tu piel tiende a...',
                        'options' => [
                            ['text' => 'Mantenerse igual', 'scoreKey' => 'normal'],
                            ['text' => 'Sentirse un poco más seca o incómoda', 'scoreKey' => 'seca'],
                            ['text' => 'Volverse más brillante o pegajosa', 'scoreKey' => 'grasa'],
                            ['text' => 'Brillosa en la frente pero seca en mejillas', 'scoreKey' => 'mixta'],
                            ['text' => 'Irritarse o brotarse', 'scoreKey' => 'sensible'],
                        ],
                    ],
                    [
                        'text' => 'Si te mirás al espejo con luz natural, tus poros se ven...',
                        'options' => [
                            ['text' => 'Normales, sin resaltar demasiado', 'scoreKey' => 'normal'],
                            ['text' => 'Muy finos o poco visibles', 'scoreKey' => 'seca'],
                            ['text' => 'Grandes y marcados', 'scoreKey' => 'grasa'],
                            ['text' => 'Más visibles en la frente o nariz, menos en mejillas', 'scoreKey' => 'mixta'],
                            ['text' => 'Normales, pero con tendencia a enrojecerse', 'scoreKey' => 'sensible'],
                        ],
                    ],
                    [
                        'text' => 'Después de hacer ejercicio o sudar, tu piel se ve...',
                        'options' => [
                            ['text' => 'Sonrojada, pero vuelve a la normalidad rápido', 'scoreKey' => 'normal'],
                            ['text' => 'Seca o áspera', 'scoreKey' => 'seca'],
                            ['text' => 'Muy brillante o con sensación grasosa', 'scoreKey' => 'grasa'],
                            ['text' => 'Brillante en la frente y seca en otras partes', 'scoreKey' => 'mixta'],
                            ['text' => 'Muy roja o sensible', 'scoreKey' => 'sensible'],
                        ],
                    ],
                    [
                        'text' => 'Si tocás tu piel a mitad del día, notás que está...',
                        'options' => [
                            ['text' => 'Suave y equilibrada', 'scoreKey' => 'normal'],
                            ['text' => 'Áspera o con zonas secas', 'scoreKey' => 'seca'],
                            ['text' => 'Aceitosa o resbaladiza', 'scoreKey' => 'grasa'],
                            ['text' => 'Diferente según la zona', 'scoreKey' => 'mixta'],
                            ['text' => 'Delicada o sensible al tacto', 'scoreKey' => 'sensible'],
                        ],
                    ],
                    [
                        'text' => '¿Con cuál de estas frases te sentís más identificado/a?',
                        'options' => [
                            ['text' => 'Mi piel se siente bien sin hacerle mucho', 'scoreKey' => 'normal'],
                            ['text' => 'Me cuesta mantenerla hidratada', 'scoreKey' => 'seca'],
                            ['text' => 'Siempre tengo brillo o granitos', 'scoreKey' => 'grasa'],
                            ['text' => 'Mi piel cambia según el clima o la zona', 'scoreKey' => 'mixta'],
                            ['text' => 'Mi piel reacciona con facilidad a todo', 'scoreKey' => 'sensible'],
                        ],
                    ],
                ]),
            ],
            [
                'key' => 'cabello',
                'title' => '¿Qué tipo de cabello tengo?',
                'description' => '10 preguntas para identificar tu tipo de cabello.',
                'questions' => json_encode([
                    [
                        'text' => 'Al despertar, ¿cómo se siente tu cabello?',
                        'options' => [
                            ['text' => 'Suave y manejable, sin sensación de grasa ni resequedad', 'scoreKey' => 'normal'],
                            ['text' => 'Seco, áspero o con puntas abiertas', 'scoreKey' => 'seco'],
                            ['text' => 'Grasoso o pegajoso, especialmente en la raíz', 'scoreKey' => 'graso'],
                            ['text' => 'Graso en la raíz y seco en las puntas', 'scoreKey' => 'mixto'],
                        ],
                    ],
                    [
                        'text' => '¿Con qué frecuencia tu cabello se ensucia o se engrasa?',
                        'options' => [
                            ['text' => 'Se mantiene limpio por varios días', 'scoreKey' => 'normal'],
                            ['text' => 'Se ve opaco y seco, incluso después de lavar', 'scoreKey' => 'seco'],
                            ['text' => 'Se engrasa rápido, incluso al día siguiente del lavado', 'scoreKey' => 'graso'],
                            ['text' => 'Se engrasa en la raíz pero las puntas siguen secas', 'scoreKey' => 'mixto'],
                        ],
                    ],
                    [
                        'text' => '¿Cómo se siente tu cabello después de lavarlo?',
                        'options' => [
                            ['text' => 'Fresco, suave y manejable', 'scoreKey' => 'normal'],
                            ['text' => 'Seco o áspero, difícil de peinar', 'scoreKey' => 'seco'],
                            ['text' => 'Grasoso o pesado en la raíz', 'scoreKey' => 'graso'],
                            ['text' => 'Ligero en las puntas pero pesado o grasoso en la raíz', 'scoreKey' => 'mixto'],
                        ],
                    ],
                    [
                        'text' => '¿Qué tan fácil es peinar tu cabello?',
                        'options' => [
                            ['text' => 'Se peina sin problemas', 'scoreKey' => 'normal'],
                            ['text' => 'Se enreda y se rompe fácilmente', 'scoreKey' => 'seco'],
                            ['text' => 'Se siente pegajoso o pesado', 'scoreKey' => 'graso'],
                            ['text' => 'Se enreda en las puntas, pero la raíz se engrasa rápido', 'scoreKey' => 'mixto'],
                        ],
                    ],
                    [
                        'text' => '¿Cómo se ve tu cabello al final del día sin lavarlo?',
                        'options' => [
                            ['text' => 'Con brillo natural y equilibrado', 'scoreKey' => 'normal'],
                            ['text' => 'Opaco y seco, con puntas ásperas', 'scoreKey' => 'seco'],
                            ['text' => 'Graso o pesado, especialmente en la raíz', 'scoreKey' => 'graso'],
                            ['text' => 'Graso en la raíz, seco en las puntas', 'scoreKey' => 'mixto'],
                        ],
                    ],
                    [
                        'text' => '¿Cómo reacciona tu cabello ante el calor o la humedad?',
                        'options' => [
                            ['text' => 'Se mantiene manejable y natural', 'scoreKey' => 'normal'],
                            ['text' => 'Se vuelve más áspero o seco', 'scoreKey' => 'seco'],
                            ['text' => 'Se engrasa más rápido', 'scoreKey' => 'graso'],
                            ['text' => 'La raíz se engrasa, pero las puntas se resecan', 'scoreKey' => 'mixto'],
                        ],
                    ],
                    [
                        'text' => '¿Tu cabello tiene frizz o se rompe fácilmente?',
                        'options' => [
                            ['text' => 'Poco o nada', 'scoreKey' => 'normal'],
                            ['text' => 'Mucho frizz y se rompe con facilidad', 'scoreKey' => 'seco'],
                            ['text' => 'No demasiado frizz, pero se ve pesado', 'scoreKey' => 'graso'],
                            ['text' => 'Frizz en las puntas, raíz pesada', 'scoreKey' => 'mixto'],
                        ],
                    ],
                    [
                        'text' => '¿Cómo se comporta tu cuero cabelludo?',
                        'options' => [
                            ['text' => 'Equilibrado, sin irritación ni grasa excesiva', 'scoreKey' => 'normal'],
                            ['text' => 'Seco o con descamación', 'scoreKey' => 'seco'],
                            ['text' => 'Grasoso, con sensación de suciedad rápida', 'scoreKey' => 'graso'],
                            ['text' => 'Grasoso en la raíz, seco en otras zonas', 'scoreKey' => 'mixto'],
                        ],
                    ],
                    [
                        'text' => '¿Qué frase describe mejor tu cabello?',
                        'options' => [
                            ['text' => 'Saludable, equilibrado y fácil de manejar', 'scoreKey' => 'normal'],
                            ['text' => 'Seco, áspero o con puntas dañadas', 'scoreKey' => 'seco'],
                            ['text' => 'Graso y pesado', 'scoreKey' => 'graso'],
                            ['text' => 'Raíz grasa y puntas secas', 'scoreKey' => 'mixto'],
                        ],
                    ],
                    [
                        'text' => 'Cuando pasás los dedos por tu cabello, ¿qué sensación tenés?',
                        'options' => [
                            ['text' => 'Suave y uniforme', 'scoreKey' => 'normal'],
                            ['text' => 'Seco o áspero', 'scoreKey' => 'seco'],
                            ['text' => 'Pegajoso o grasoso', 'scoreKey' => 'graso'],
                            ['text' => 'Mezcla: raíz grasa y puntas secas', 'scoreKey' => 'mixto'],
                        ],
                    ],
                ]),
            ]
            ,
        ];

        foreach ($tests as $test) {
            Test::create($test);
        }
    }
}
