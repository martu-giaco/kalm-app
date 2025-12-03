<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;
use App\Models\Routine;
use App\Models\RoutineType;

class TestController extends Controller
{
    /**
     * Listado de tests disponibles
     */
    public function index()
    {
        $tests = Test::all();
        return view('tests.index', compact('tests'));
    }

    /**
     * Mostrar test según tipo (piel, cabello, etc.)
     */
    public function show($type)
    {
        $test = Test::where('key', $type)->firstOrFail();

        // Asegurarse que las preguntas sean un array
        $test->questions = is_string($test->questions) ? json_decode($test->questions, true) : $test->questions;

        return view('tests.show', compact('test'));
    }

    /**
     * Procesar respuestas del test
     */
    public function submit(Request $request)
    {
        $request->validate([
            'type' => 'required|string',
        ]);

        $type = $request->input('type');
        $test = Test::where('key', $type)->firstOrFail();

        $questions = is_string($test->questions) ? json_decode($test->questions, true) : $test->questions;

        // Contar respuestas y sumar puntajes
        $scores = [];
        foreach ($questions as $index => $q) {
            $key = $request->input('q' . ($index + 1));
            if ($key) {
                $scores[$key] = ($scores[$key] ?? 0) + 1;
            } else {
                return redirect()->back()->with('error', 'Debes responder todas las preguntas.');
            }
        }

        // Obtener la respuesta con mayor puntaje
        arsort($scores);
        $resultKey = key($scores);

        // Buscar la rutina correspondiente
        $routineType = RoutineType::where('name', ucfirst($type))->first();
        $routine = Routine::where('routine_type_id', $routineType->id ?? null)
            ->where('name', $resultKey)
            ->with(['types', 'times'])
            ->first();

        if (!$routine) {
            return redirect()->back()->with('error', 'Rutina no disponible para este resultado.');
        }

        // Redirigir al resultado
        return redirect()->route('tests.result', ['type' => $type, 'result' => $resultKey]);
    }

    /**
     * Mostrar resultado del test
     */
    public function result($type, $result)
    {
        $routineType = RoutineType::where('name', ucfirst($type))->first();

        if (!$routineType) {
            return redirect()->route('tests.index')->with('error', 'Tipo de test no válido.');
        }

        $routine = Routine::where('routine_type_id', $routineType->id)
            ->where('name', $result)
            ->with(['types', 'times'])
            ->first();

        if (!$routine) {
            return redirect()->route('tests.index')->with('error', 'Rutina no disponible para este resultado.');
        }

        return view('tests.result', compact('routine', 'result'));
    }
}
