<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;
use App\Models\Routine;
use App\Models\RoutineType;
use App\Models\UserTestResult;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class TestController extends Controller
{
    /**
     * Mostrar lista de tests disponibles
     */
    public function index()
    {
        $tests = Test::all();
        return view('tests.index', compact('tests'));
    }

    /**
     * Mostrar un test por su key (route-model-binding por key manual)
     */
    public function show($type)
    {
        $test = Test::where('key', $type)->firstOrFail();

        // Asegurarnos que questions sea array
        $test->questions = is_string($test->questions) ? json_decode($test->questions, true) : $test->questions;

        return view('tests.show', compact('test'));
    }

    /**
     * Procesar respuestas del test.
     * - Si la petición quiere JSON (AJAX), respondemos JSON con detalle.
     * - Si es form normal, redirigimos a la vista de resultado (con o sin rutina).
     */
    public function submit(Request $request)
    {
        $request->validate([
            'type' => 'required|string',
        ]);

        $test = Test::where('key', $request->input('type'))->firstOrFail();
        $questions = is_string($test->questions) ? json_decode($test->questions, true) : $test->questions;

        $scores = [];
        $answers = [];

        foreach ($questions as $index => $q) {
            $inputName = 'q' . ($index + 1);
            $value = $request->input($inputName);

            if ($value === null) {
                return redirect()->back()->withInput()->with('error', 'Falta responder la pregunta #' . ($index + 1));
            }

            $answers[$inputName] = $value;
            $scores[$value] = ($scores[$value] ?? 0) + 1;
        }

        arsort($scores);
        $topKey = array_key_first($scores);

        $routineType = RoutineType::where('name', $topKey)->firstOrFail();

        // Crear rutina correctamente
        $routine = Routine::create([
            'routine_type_id' => $routineType->id,
            'user_id' => auth()->id(), // puede ser null si no hay usuario logueado
            'name' => ucfirst($test->key) . ' Routine',
        ]);

        // Guardar respuestas en sesión
        session([
            'test_answers' => $answers,
            'test_key' => $test->key,
            'result_key' => $topKey,
            'routine_id' => $routine->routine_id,
        ]);

        // Redirigir al resultado
        return redirect()->route('tests.result', $routine->routine_id)
                 ->with('success', 'Rutina creada correctamente.');

    }




    /**
     * Mostrar la página de resultado.
     * $routineId es opcional — si no viene, la vista mostrará resultado sin rutina.
     */
    public function result($routineId)
{
    // Obtener rutina
    $routine = Routine::where('routine_id', $routineId)->firstOrFail();

    // Obtener resultado del test
    $resultKey = session('result_key'); // o según tu lógica
    $resultLabel = $resultKey ?? 'normal';

    // Descripciones de cada tipo
    $descriptions = [
        'normal' => 'Piel/cabello equilibrado.',
        'seco' => 'Tiendes a la sequedad.',
        'graso' => 'Tiendes a la producción de sebo elevada.',
        'mixto' => 'Zona T grasa y mejillas secas.',
        'sensible' => 'Tendencia a rojeces e irritaciones.',
    ];

    $resultDesc = $descriptions[$resultLabel] ?? 'Descripción no disponible para este resultado.';

    // Productos recomendados: buscar donde la descripción contenga la palabra del resultado
    $recommendedProducts = Product::where('description', 'like', "%{$resultLabel}%")->get();

    return view('tests.result', compact('routine', 'resultLabel', 'resultDesc', 'recommendedProducts'));
}



    /**
     * Guardar resultado en el perfil del usuario (requiere login)
     */
    public function saveResult(Request $request, $routineId)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('auth.login');
        }

        // Buscar rutina por routine_id o id
        $routine = Routine::where('routine_id', $routineId)->first();
        if (!$routine) {
            $routine = Routine::findOrFail($routineId);
        }

        $testKey = $request->input('test_key', session('test_key'));
        $resultKey = $request->input('result_key', session('result_key'));
        $answers = $request->input('answers', session('test_answers', []));

        // Asegurarse de serializar las respuestas si vienen como array
        if (is_array($answers)) {
            $answersToStore = json_encode($answers);
        } else {
            $answersToStore = is_string($answers) ? $answers : json_encode([$answers]);
        }

        $saved = UserTestResult::create([
            'user_id' => $user->id,
            // usar el campo público routine_id si existe, sino el id
            'routine_id' => $routine->routine_id ?? $routine->routine_id,
            'test_key' => $testKey,
            'result_key' => $resultKey,
            'answers' => $answersToStore,
        ]);

        if ($saved) {
            return redirect()->route('tests.result', $routine->routine_id ?? $routine->routine_id)
                ->with('success', 'Resultado guardado correctamente en tu perfil.');
        }

        return response()->json([
            'success' => true,
            'topKey' => $topKey,
            'routine_id' => $routine->routine_id,
            'answers' => $answers
        ]);

    }

    /**
     * Redirigir al flujo de creación de rutina (premium) o al upgrade
     */
    public function createRoutineRedirect($routineId)
    {
        if (auth()->check() && (auth()->user()->is_premium ?? false)) {
            return redirect()->route('premium.createRoutine', $routineId);
        }

        return redirect()->route('premium.upgrade')->with('intended_routine', $routineId);
    }
}
