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
                return back()->withInput()->with('feedback', [
                    'message' => 'Falta responder la pregunta #' . ($index + 1),
                    'type' => 'error'
                ]);
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
            'routine_type_id' => $type?->type_id ?? $type?->id,
        ]);

        // Guardar o actualizar automáticamente si el usuario inició sesión
        if (Auth::check()) {
            $this->saveOrUpdateUserTestResult(Auth::user(), $test->key, $topKey, $answers);
        }

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

            // Recuperar el último resultado guardado si la sesión expiró pero el usuario está autenticado
            if ((!$testKey || !$resultLabel) && Auth::check()) {
                $latestResult = UserTestResult::where('user_id', Auth::id())
                    ->latest('updated_at')
                    ->first();

                if ($latestResult) {
                    $testKey = $latestResult->test_key;
                    $resultLabel = $latestResult->result_key;
                }
            }

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
            $recommendedProducts = collect();
            if ($recommendedRoutine) {
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

        if (!$user) {
            return redirect()->route('auth.login');
        }

        $testKey = $request->input('test_key', session('test_key'));
        $resultKey = $request->input('result_key', session('result_key'));
        $answers = $request->input('answers', session('test_answers'));

        // NUEVO
        $saveOnlyResult = $request->boolean('save_only_result');

        if (!$resultKey || !$testKey) {
            return redirect()->route('tests.index')
                ->with('feedback', [
                    'message' => 'No hay resultado.',
                    'type' => 'error'
                ]);
        }

        if (is_string($answers)) {
            $decoded = json_decode($answers, true);

            if (json_last_error() === JSON_ERROR_NONE) {
                $answers = $decoded;
            }
        }

        $result = $this->saveOrUpdateUserTestResult(
            $user,
            $testKey,
            $resultKey,
            $answers,
            $saveOnlyResult
        );

        if ($result['status'] === 'success') {
            return redirect()->route('profile.results')
                ->with('feedback', [
                    'message' => 'Resultado guardado correctamente.',
                    'type' => 'success'
                ]);
        }

        if ($result['status'] === 'limit_reached') {
            return redirect()->route('tests.result')
                ->with('feedback', [
                    'message' => 'Plan Free permite solo 2 rutinas guardadas.',
                    'type' => 'warning',
                    'routine_limit_info' => $result['limit_info']
                ]);
        }

        return redirect()->route('profile.results');

    } catch (\Exception $e) {

        Log::error('Error en saveResult', [
            'error' => $e->getMessage()
        ]);

        return redirect()->route('profile.results')
            ->with('feedback', [
                'message' => 'Ocurrió un error al guardar el resultado.',
                'type' => 'error'
            ]);
    }
}

    /**
     * Guarda o actualiza (sobreescribe) el resultado del test de un usuario sin duplicarlo.
     * Verifica el plan del usuario y el límite de rutinas para usuarios free.
     *
     * @return array
     */
    private function saveOrUpdateUserTestResult( $user, $testKey, $resultKey, $answers, $saveOnlyResult = false)
    {
        $answersToStore = is_array($answers)
            ? json_encode($answers)
            : $answers;

        $recommendedRoutine = RecommendedRoutine::where('test_key', $testKey)
            ->where('result_key', $resultKey)
            ->first();

        $testResult = UserTestResult::where('user_id', $user->id)
            ->where('test_key', $testKey)
            ->first();

        $routineId = $testResult?->routine_id;
        $routineCreated = false;

        // Si el usuario eligió guardar solo el resultado,
        // no crear ninguna rutina.
        if ($saveOnlyResult) {

            UserTestResult::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'test_key' => $testKey,
                ],
                [
                    'routine_id' => null,
                    'result_key' => $resultKey,
                    'answers' => $answersToStore,
                ]
            );

            return [
                'status' => 'success',
                'routine_created' => false,
            ];
        }

        // Si no tenía rutina o si cambió el tipo de resultado al rehacer el test
        if ($recommendedRoutine && (!$routineId || ($testResult && $testResult->result_key !== $resultKey))) {

            // Verificar si el usuario puede guardar una nueva rutina
            $limitInfo = $user->getRoutineLimitInfo();

            if (!$limitInfo['can_create']) {
                // No puede crear más rutinas - guardar resultado sin rutina
                UserTestResult::updateOrCreate(
                    [
                        'user_id'  => $user->id,
                        'test_key' => $testKey,
                    ],
                    [
                        'routine_id' => null,
                        'result_key' => $resultKey,
                        'answers'    => $answersToStore,
                    ]
                );

                return [
                    'status' => 'limit_reached',
                    'limit_info' => $limitInfo,
                ];
            }

            // Usuario puede crear la rutina
            try {
                $createdRoutine = $this->createRoutineFromRecommended($user, $recommendedRoutine, $testKey);
                $routineId = $createdRoutine->getKey();
                $routineCreated = true;
            } catch (\Exception $e) {
                Log::error('Error creando rutina desde test', ['error' => $e->getMessage()]);
                // No duplicar error, simplemente no guardar rutina
            }
        }

        UserTestResult::updateOrCreate(
            [
                'user_id'  => $user->id,
                'test_key' => $testKey,
            ],
            [
                'routine_id' => $routineId,
                'result_key' => $resultKey,
                'answers'    => $answersToStore,
            ]
        );

        return [
            'status' => 'success',
            'routine_created' => $routineCreated,
        ];
    }

    /**
     * Crear una rutina en el perfil del usuario basada en una rutina recomendada
     * Asume que la validación de límite ya fue hecha
     */
    private function createRoutineFromRecommended($user, $recommendedRoutine, $testKey)
    {
        $productIds = is_string($recommendedRoutine->products)
            ? json_decode($recommendedRoutine->products, true)
            : $recommendedRoutine->products;

        $typeId = null;
        if ($testKey === 'piel') {
            $typeId = Type::where('name', 'Skincare')->first()?->id ?? Type::where('name', 'Skincare')->first()?->type_id;
        } elseif ($testKey === 'cabello') {
            $typeId = Type::where('name', 'Haircare')->first()?->id ?? Type::where('name', 'Haircare')->first()?->type_id;
        }

        $routine = Routine::create([
            'user_id' => $user->id,
            'name' => $recommendedRoutine->name,
            'steps' => $recommendedRoutine->steps,
            'type_id' => $typeId,
        ]);

        if (!empty($productIds) && is_array($productIds)) {
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

        return redirect()->route('routines.edit', $routine->getKey())
            ->with('feedback', ['message' => 'Rutina creada. Personalízala.', 'type' => 'success']);
    }
}
