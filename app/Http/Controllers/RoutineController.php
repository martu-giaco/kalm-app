<?php

namespace App\Http\Controllers;

use App\Models\Routine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoutineController extends Controller
{
    // Mostrar formulario de creación
    public function create()
    {
        return view('routine.create');
    }

    // Guardar rutina
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:20',
            'type' => 'nullable|string|max:50',
        ]);

        $routine = new Post();
        $routine->user_id = auth()->id();
        $routine->content = $request->content;
        $routine->is_deleted = false;

        if ($request->hasFile('image')) {
            $routine->image = $request->file('image')->store('routines', 'public');
        }

        $routine->save();

        return redirect()->route('routines.index')->with('success', 'Rutina creada correctamente!');
    }

}
