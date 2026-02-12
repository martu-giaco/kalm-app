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
     * Mostrar un test por su key
     */
    public function show($type)
    {
        $test = Test::where('key', $type)->firstOrFail();

        // Asegurarnos que questions sea array
        $test->questions = is_string($test->questions) ? json_decode($test->questions, true) : $test->questions;

        return view('tests.show', compact('test'));
    }

    /**
     * Procesar respuestas del test y guardar en sesión
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

        try {
            $routineType = RoutineType::where('name', $topKey)->firstOrFail();
        } catch (\Exception $e) {
            Log::error('RoutineType no encontrado', ['topKey' => $topKey, 'error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Tipo de rutina no válido: ' . $topKey);
        }

        // Guardar respuestas en sesión (SIN crear rutina aún)
        session([
            'test_answers' => $answers,
            'test_key' => $test->key,
            'result_key' => $topKey,
            'routine_type_id' => $routineType->type_id,
        ]);

        Log::info('Test completado y sesión guardada', [
            'test_key' => $test->key,
            'result_key' => $topKey,
            'type_id' => $routineType->type_id,
        ]);

        // Redirigir al resultado (sin routine_id - no hay rutina aún)
        return redirect()->route('tests.result')
                 ->with('success', 'Test completado correctamente.');
    }

    /**
     * Mostrar la página de resultado del test
     * NO requiere una rutina - solo muestra los resultados
     */
    public function result()
    {
        try {
            // Obtener resultado del test desde la sesión
            $resultKey = session('result_key');
            $resultLabel = $resultKey ?? 'normal';

            if (!$resultKey) {
                return redirect()->route('tests.index')->with('error', 'No hay resultados de test disponibles.');
            }

            // Descripciones de cada tipo
            $descriptions = [
                'normal' => 'Mantienen un equilibrio natural de hidratación y sebo. Lucen saludables, con buena textura y brillo. Solo necesitan cuidados básicos de mantenimiento.',
                'seco' => 'Presentan falta de hidratación y nutrición. La piel puede sentirse tirante o descamada, y el cabello luce opaco, áspero o con puntas abiertas. Necesitan fórmulas nutritivas que restauren suavidad y elasticidad.',
                'graso' => 'Producen exceso de sebo. La piel presenta brillo y poros visibles, y el cabello puede verse pesado o apelmazado. Necesitan fórmulas ligeras y reguladoras.',
                'mixto' => 'Combinan zonas grasas con áreas más secas. La piel suele tener brillo en la zona T y sequedad en mejillas, mientras que el cabello presenta raíces grasas y puntas secas. Requieren productos equilibrantes.',
                'sensible' => 'Son más reactivos y pueden irritarse con facilidad. La piel puede enrojecerse y el cuero cabelludo presentar picazón. Requieren productos suaves y calmantes.',
            ];

            $resultDesc = $descriptions[$resultLabel] ?? 'Descripción no disponible para este resultado.';

            // Productos recomendados: buscar donde la descripción contenga la palabra del resultado
            $recommendedProducts = Product::where('description', 'like', "%{$resultLabel}%")->get();

            // Si no hay productos específicos, mostrar algunos productos populares
            if ($recommendedProducts->isEmpty()) {
                $recommendedProducts = Product::limit(6)->get();
            }

            return view('tests.result', compact('resultLabel', 'resultDesc', 'recommendedProducts'));
        } catch (\Exception $e) {
            Log::error('Error en result: ' . $e->getMessage());
            return redirect()->route('tests.index')->with('error', 'Error al cargar los resultados. Por favor, intenta de nuevo.');
        }
    }

    /**
     * Guardar resultado en el perfil del usuario (requiere login)
     * NO crea rutina, solo guarda el resultado del test
     */
    public function saveResult(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('auth.login');
        }

        $testKey = $request->input('test_key', session('test_key'));
        $resultKey = $request->input('result_key', session('result_key'));
        $answers = $request->input('answers', session('test_answers', []));

        Log::info('SaveResult - Datos recibidos', [
            'test_key' => $testKey,
            'result_key' => $resultKey,
            'answers_type' => gettype($answers),
            'answers' => $answers,
        ]);

        if (!$resultKey) {
            Log::warning('SaveResult - Sin resultKey', ['user_id' => $user->id]);
            return redirect()->route('tests.index')->with('error', 'No hay resultados para guardar.');
        }

        // Asegurarse de serializar las respuestas si vienen como array o JSON
        if (is_array($answers)) {
            $answersToStore = json_encode($answers);
        } elseif (is_string($answers)) {
            // Si viene como string JSON, usarlo tal cual
            $answersToStore = $answers;
        } else {
            $answersToStore = json_encode([$answers]);
        }

        try {
            $result = UserTestResult::create([
                'user_id' => $user->id,
                'routine_id' => null,
                'test_key' => $testKey,
                'result_key' => $resultKey,
                'answers' => $answersToStore,
            ]);

            Log::info('SaveResult - Guardado exitoso', [
                'result_id' => $result->id,
                'user_id' => $user->id,
                'test_key' => $testKey,
                'result_key' => $resultKey,
            ]);

            return redirect()->route('tests.result')
                ->with('success', 'Resultado guardado correctamente en tu perfil.');
        } catch (\Exception $e) {
            Log::error('SaveResult - Error al guardar', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect()->route('tests.result')
                ->with('error', 'Error al guardar el resultado: ' . $e->getMessage());
        }
    }

    /**
     * Crear rutina a partir del resultado del test
     * Disponible para todos los usuarios
     */
    public function createRoutineRedirect()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('auth.login')->with('info', 'Inicia sesión para crear una rutina.');
        }

        // Crear rutina con los datos de la sesión
        $routine = Routine::create([
            'user_id' => $user->id,
            'name' => ucfirst(session('test_key', 'Test')) . ' Routine',
        ]);

        // Agregar tipo a la rutina
        if (session('routine_type_id')) {
            $routine->types()->attach(session('routine_type_id'));
        }

        return redirect()->route('routines.edit', $routine->routine_id)
            ->with('success', 'Rutina creada. Ahora personalízala agregando productos y pasos.');
    }
}
