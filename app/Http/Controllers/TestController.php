<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;
use App\Models\Routine;
use App\Models\Type;
use App\Models\UserTestResult;
use App\Models\Product;
use App\Models\RecommendedRoutine;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TestController extends Controller
{
    /* ===========================
     * LISTAR TESTS
     =========================== */
    public function index()
        {
            $tests = Test::all();

            $completedTests = [];

            if (Auth::check()) {
                $completedTests = UserTestResult::where('user_id', Auth::id())
                    ->pluck('test_key')
                    ->toArray();
            }

            return view('tests.index', compact('tests', 'completedTests'));
        }

    /* ===========================
     * MOSTRAR TEST
     =========================== */
    public function show($type)
    {
        $test = Test::where('key', $type)->firstOrFail();
        $test->questions = is_string($test->questions)
            ? json_decode($test->questions, true)
            : $test->questions;

        return view('tests.show', compact('test'));
    }

    /* ===========================
     * PROCESAR TEST
     =========================== */
    public function submit(Request $request)
    {
        $request->validate([
            'type' => 'required|string',
        ]);

        $test = Test::where('key', $request->type)->firstOrFail();
        $questions = is_string($test->questions)
            ? json_decode($test->questions, true)
            : $test->questions;

        $scores = [];
        $answers = [];

        foreach ($questions as $index => $q) {
            $input = 'q' . ($index + 1);
            $value = $request->input($input);

            if (!$value) {
                return back()->withInput()->with('feedback', ['message' => 'Falta responder la pregunta #' . ($index + 1), 'type' => 'error']);
            }

            $answers[$input] = $value;
            $scores[$value] = ($scores[$value] ?? 0) + 1;
        }

        arsort($scores);
        $topKey = array_key_first($scores);

        $type = Type::where('name', $topKey)->first();

        session([
            'test_answers' => $answers,
            'test_key' => $test->key,
            'result_key' => $topKey,
            'routine_type_id' => $type?->type_id,
        ]);

        Log::info('Test completado', session()->all());

        return redirect()->route('tests.result');
    }

    /* ===========================
     * RESULTADO DEL TEST
     =========================== */
    public function result()
    {
        try {
            $testKey = session('test_key');
            $resultLabel = session('result_key');

            if (!$testKey || !$resultLabel) {
                return redirect()->route('tests.index')
                    ->with('feedback', ['message' => 'No hay resultados disponibles.', 'type' => 'error']);
            }

            // BUSCAR EL TEST
                $test = Test::where('key', $testKey)->first();

                    if (!$test) {
                        return redirect()->route('tests.index')
                            ->with('feedback', ['message' => 'Test no encontrado.', 'type' => 'error']);
                    }

            // Rutina recomendada
            $recommendedRoutine = RecommendedRoutine::with(['routineTime'])
                ->where('test_key', $testKey)
                ->where('result_key', $resultLabel)
                ->first();

            // Cargar los productos de la rutina recomendada
            if ($recommendedRoutine) {
                // Acceder al atributo raw sin pasar por el accesor
                $productsJson = $recommendedRoutine->getAttributeValue('products');
                $productIds = is_string($productsJson)
                    ? json_decode($productsJson, true)
                    : $productsJson;

                if (!empty($productIds)) {
                    $recommendedProducts = Product::whereIn('id', $productIds)->with(['brand', 'type', 'category'])->get();
                } else {
                    $recommendedProducts = Product::limit(6)->get();
                }
            } else {
                // Si no hay rutina recomendada, buscar productos por descripción
                $recommendedProducts = Product::limit(6)->get();
            }
            $descriptions = [
                'skin' => [
                    'normal' => 'Tener la piel normal significa que tu piel tiene un equilibrio adecuado de humedad y producción de sebo, lo que le permite lucir saludable, suave y con poros poco visibles. Este tipo de piel no es ni demasiado seca ni demasiado grasa, y generalmente no presenta problemas significativos como acné o sensibilidad. Para cuidar la piel normal, es importante mantener una rutina de cuidado básica que incluya limpieza suave, hidratación ligera y protección solar diaria.',
                    'seco' => 'Tener la piel seca significa que tu piel produce menos aceites naturales de lo necesario, por lo que suele sentirsetirante, áspera o incómoda. Este tipo de piel pierde humedad con facilidad, lo que pude generar descamación y sensibilidad. Las bajas temperaturas, el viento y el uso de productos agresivos pueden empeorar la sequedad. Para cuidar la piel seca, es importante usar limpiadores suaves, hidratantes ricos en emolientes y evitar el uso excesivo de exfoliantes o productos con alcohol.',
                    'graso' => 'Tener la piel grasa significa que tu piel produce un exceso de sebo, lo que puede hacer que luzca brillante y propensa a desarrollar acné. Este tipo de piel suele tener poros dilatados y es más común en adolescentes y adultos jóvenes, aunque puede afectar a personas de todas las edades. Para cuidar la piel grasa, es importante usar limpiadores específicos para controlar el exceso de grasa, evitar productos comedogénicos y mantener una rutina de cuidado que incluya hidratación ligera.',
                    'mixto' => 'Tener la piel mixta significa que tu piel presenta características tanto de piel seca como de piel grasa. Generalmente, la zona T (frente, nariz y mentón) tiende a ser más grasa, mientras que las mejillas pueden ser secas o normales. Este tipo de piel puede ser un desafío para cuidar, ya que requiere productos específicos para cada área. Para cuidar la piel mixta, es importante usar limpiadores suaves, hidratantes equilibrados y productos que ayuden a controlar el exceso de grasa en la zona T sin resecar las áreas secas.',
                    'sensible' => 'Tener la piel sensible significa que tu piel es propensa a reaccionar de manera exagerada a factores externos como el clima, productos de cuidado o incluso el estrés. Este tipo de piel puede presentar enrojecimiento, picazón, ardor o descamación con facilidad. Para cuidar la piel sensible, es importante usar productos hipoalergénicos, evitar ingredientes irritantes como fragancias o alcohol, y mantener una rutina de cuidado suave y consistente.',
                ],
                'hair' => [
                    'normal' => 'Tener el cabello normal significa que tu cabello tiene un equilibrio adecuado de humedad y producción de sebo, lo que le permite lucir saludable, suave y con brillo natural. Este tipo de cabello no es ni demasiado seco ni demasiado graso, y generalmente no presenta problemas significativos como caspa o daño excesivo. Para cuidar el cabello normal, es importante mantener una rutina de cuidado básica que incluya lavado regular con un champú suave, acondicionamiento ligero y protección contra el calor.',
                    'seco' => 'Tener el cabello seco significa que tu cabello carece de humedad y aceites naturales, lo que puede hacer que se sienta áspero, quebradizo y sin brillo. Este tipo de cabello es más propenso a dañarse con el peinado, el uso de herramientas de calor o la exposición al sol. Para cuidar el cabello seco, es importante usar champús hidratantes, acondicionadores ricos en emolientes y tratamientos profundos regularmente para restaurar la humedad.',
                    'graso' => 'Tener el cabello graso significa que tu cabello produce un exceso de sebo, lo que puede hacer que luzca brillante y propenso a desarrollar caspa. Este tipo de cabello suele tener raíces grasas y es más común en adolescentes y adultos jóvenes, aunque puede afectar a personas de todas las edades. Para cuidar el cabello graso, es importante usar champús específicos para controlar el exceso de grasa, evitar productos comedogénicos y mantener una rutina de cuidado que incluya acondicionamiento ligero.',
                    'mixto' => 'Tener el cabello mixto significa que tu cabello presenta características tanto de cabello seco como de cabello graso. Generalmente, las raíces tienden a ser más grasas, mientras que las puntas pueden ser secas o normales. Este tipo de cabello puede ser un desafío para cuidar, ya que requiere productos específicos para cada área. Para cuidar el cabello mixto, es importante usar champús suaves, acondicionadores equilibrados y productos que ayuden a controlar el exceso de grasa en las raíces sin resecar las puntas.',
                    'sensible' => 'Tener el cabello sensible significa que tu cuero cabelludo es propenso a reaccionar de manera exagerada a factores externos como el clima, productos de cuidado o incluso el estrés. Este tipo de cuero cabelludo puede presentar enrojecimiento, picazón, ardor o descamación con facilidad. Para cuidar el cuero cabelludo sensible, es importante usar productos hipoalergénicos, evitar ingredientes irritantes como fragancias o alcohol, y mantener una rutina de cuidado suave y consistente.',
                ]
            ];

            $resultDesc = $descriptions[$test->category][$resultLabel] ?? 'Descripción no disponible.';

            return view('tests.result', compact(
                'testKey',
                'resultLabel',
                'resultDesc',
                'recommendedProducts',
                'recommendedRoutine'
            ));
        } catch (\Exception $e) {
            Log::error('Error en result', ['error' => $e->getMessage()]);
            return redirect()->route('tests.index')
                ->with('feedback', ['message' => 'Ocurrió un error al mostrar el resultado.', 'type' => 'error']);
        }
    }

    /* ===========================
     * GUARDAR RESULTADO
     =========================== */
    public function saveResult(Request $request)
    {
        try {
            $user = Auth::user();
            if (!$user) return redirect()->route('auth.login');

            $testKey = $request->input('test_key', session('test_key'));
            $resultKey = $request->input('result_key', session('result_key'));
            $answers = $request->input('answers', session('test_answers'));

            if (!$resultKey) {
                return redirect()->route('tests.index')->with('feedback', ['message' => 'No hay resultado.', 'type' => 'error']);
            }

            $answersToStore = is_array($answers)
                ? json_encode($answers)
                : $answers;

            // Buscar si existe una rutina recomendada para este resultado
            $recommendedRoutine = RecommendedRoutine::where('test_key', $testKey)
                ->where('result_key', $resultKey)
                ->first();

            // Crear rutina en el perfil del usuario PRIMERO
            $routineId = null;
            if ($recommendedRoutine) {
                $createdRoutine = $this->createRoutineFromRecommended($user, $recommendedRoutine, $testKey);
                $routineId = $createdRoutine->routine_id; // Obtenemos el ID de la rutina creada
            }

            // Guardar el resultado del test CON el ID correcto
            $testResult = UserTestResult::create([
                'user_id' => $user->id,
                'routine_id' => $routineId,
                'test_key' => $testKey,
                'result_key' => $resultKey,
                'answers' => $answersToStore,
            ]);

            return redirect()->route('profile.results')
                ->with('feedback', ['message' => 'Resultado guardado correctamente.', 'type' => 'success']);
        } catch (\Exception $e) {
            Log::error('Error en saveResult', ['error' => $e->getMessage()]);
            return redirect()->route('profile.results')
                ->with('feedback', ['message' => 'Ocurrió un error al guardar el resultado: ' . $e->getMessage(), 'type' => 'error']);
        }
    }

    /**
     * Crear una rutina en el perfil del usuario basada en una rutina recomendada
     */
    private function createRoutineFromRecommended($user, $recommendedRoutine, $testKey)
    {
        $productIds = is_string($recommendedRoutine->products)
            ? json_decode($recommendedRoutine->products, true)
            : $recommendedRoutine->products;

        // Determinar el type_id basado en el test_key
        $typeId = null;
        if ($testKey === 'piel') {
            // Skincare = 1
            $typeId = Type::where('name', 'Skincare')->first()?->id;
        } elseif ($testKey === 'cabello') {
            // Haircare = 2
            $typeId = Type::where('name', 'Haircare')->first()?->id;
        }

        $routine = Routine::create([
            'user_id' => $user->id,
            'name' => $recommendedRoutine->name,
            'steps' => $recommendedRoutine->steps,
            'type_id' => $typeId,
        ]);

        // Asociar productos a la rutina
        if (!empty($productIds)) {
            $routine->products()->attach($productIds);
        }

        return $routine;
    }

    /* ===========================
     * CREAR RUTINA DESDE TEST
     =========================== */
    public function createRoutineRedirect()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('auth.login');
        }

        $routine = Routine::create([
            'user_id' => $user->id,
            'name' => ucfirst(session('test_key', 'Test')) . ' Routine',
        ]);

        if (session('routine_type_id')) {
            $routine->types()->attach(session('routine_type_id'));
        }

        return redirect()->route('routines.edit', $routine->routine_id)
            ->with('feedback', ['message' => 'Rutina creada. Personalízala.', 'type' => 'success']);
    }
}
