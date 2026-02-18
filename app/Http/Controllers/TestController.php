<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;
use App\Models\Routine;
use App\Models\RoutineType;
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
        return view('tests.index', compact('tests'));
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
                return back()->withInput()->with('error', 'Falta responder la pregunta #' . ($index + 1));
            }

            $answers[$input] = $value;
            $scores[$value] = ($scores[$value] ?? 0) + 1;
        }

        arsort($scores);
        $topKey = array_key_first($scores);

        $routineType = RoutineType::where('name', $topKey)->first();

        session([
            'test_answers' => $answers,
            'test_key' => $test->key,
            'result_key' => $topKey,
            'routine_type_id' => $routineType?->type_id,
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
                    ->with('error', 'No hay resultados disponibles.');
            }

            // Rutina recomendada
            $recommendedRoutine = RecommendedRoutine::with('routineTime')
                ->where('test_key', $testKey)
                ->where('result_key', $resultLabel)
                ->first();

            // Descripciones
            $descriptions = [
                'normal' => 'Mantienen un equilibrio natural de hidratación y sebo. Lucen saludables, con buena textura y brillo. Solo necesitan cuidados básicos de mantenimiento.',
                'seco' => 'Presentan falta de hidratación y nutrición. La piel puede sentirse tirante o descamada, y el cabello luce opaco, áspero o con puntas abiertas. Necesitan fórmulas nutritivas que restauren suavidad y elasticidad.',
                'graso' => 'Producen exceso de sebo. La piel presenta brillo y poros visibles, y el cabello puede verse pesado o apelmazado. Necesitan fórmulas ligeras y reguladoras.',
                'mixto' => 'Combinan zonas grasas con áreas más secas. La piel suele tener brillo en la zona T y sequedad en mejillas, mientras que el cabello presenta raíces grasas y puntas secas. Requieren productos equilibrantes.',
                'sensible' => 'Son más reactivos y pueden irritarse con facilidad. La piel puede enrojecerse. Requieren productos suaves y calmantes.',
            ];

            $resultDesc = $descriptions[$resultLabel] ?? 'Descripción no disponible.';

            // Productos
            $recommendedProducts = Product::where('description', 'like', "%{$resultLabel}%")->get();

            if ($recommendedProducts->isEmpty()) {
                $recommendedProducts = Product::limit(6)->get();
            }

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
                ->with('error', 'Ocurrió un error al mostrar el resultado.');
        }
    }

    /* ===========================
     * GUARDAR RESULTADO
     =========================== */
    public function saveResult(Request $request)
    {
        $user = Auth::user();
        if (!$user) return redirect()->route('auth.login');

        $testKey = $request->input('test_key', session('test_key'));
        $resultKey = $request->input('result_key', session('result_key'));
        $answers = $request->input('answers', session('test_answers'));

        if (!$resultKey) {
            return redirect()->route('tests.index')->with('error', 'No hay resultado.');
        }

        $answersToStore = is_array($answers)
            ? json_encode($answers)
            : $answers;

        UserTestResult::create([
            'user_id' => $user->id,
            'routine_id' => null,
            'test_key' => $testKey,
            'result_key' => $resultKey,
            'answers' => $answersToStore,
        ]);

        return redirect()->route('tests.result')
            ->with('success', 'Resultado guardado correctamente.');
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
            ->with('success', 'Rutina creada. Personalízala.');
    }
}
