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

    //redirigir a pantalla de resultados
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

    // Asegurar que las preguntas sean un array
    $questions = is_string($test->questions)
        ? json_decode($test->questions, true)
        : $test->questions;

    // Contar puntajes
    $scores = [];
    foreach ($questions as $index => $q) {
        $key = $request->input('q' . ($index + 1));
        if (!$key) {
            return redirect()->back()->with('error', 'Debes responder todas las preguntas.');
        }

        $scores[$key] = ($scores[$key] ?? 0) + 1;
    }

    // Ordenar para obtener el más votado
    arsort($scores);
    $topKey = array_key_first($scores);  // ej "mixto"

    // Buscar el type_id correspondiente al nombre (normal, seco, graso, mixto, sensible)
    $routineType = RoutineType::where('name', $topKey)->first();

    if (!$routineType) {
        return redirect()->back()->with('error', 'No se encontró el tipo de rutina para: ' . $topKey);
    }

    // Buscar la rutina vinculada a ese tipo
    $routine = Routine::where('routine_type_id', $routineType->type_id)->first();

    if (!$routine) {
        return redirect()->back()->with('error', 'No se encontró una rutina asociada a este tipo.');
    }

    // Redirigir a la pantalla de resultados
    return redirect()->route('tests.result', $routine->routine_id);
}

    /**
     * Mostrar resultado del test
     */
    public function result($routineId)
    {
        $routine = Routine::findOrFail($routineId);

        return view('tests.result', compact('routine'));
    }

}
