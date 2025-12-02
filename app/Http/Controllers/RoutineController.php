<?php

namespace App\Http\Controllers;

use App\Models\Routine;
use Illuminate\Http\Request;

class RoutineController extends Controller
{
    /**
     * Ver todas las rutinas (público).
     */
    public function index()
    {
        $routines = Routine::with('user')
                            ->latest()
                            ->paginate(10);

        return view('routines.index', compact('routines'));
    }

    /**
     * Formulario para crear una rutina (solo usuario autenticado).
     */
    public function create()
    {
        return view('routines.create');
    }

    /**
     * Guardar una rutina para el usuario autenticado.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'type'     => 'required|string|max:50',
            'products' => 'nullable|array',
        ]);

        Routine::create([
            'user_id'  => auth()->id(),
            'name'     => $validated['name'],
            'type'     => $validated['type'],
            'products' => json_encode($validated['products'] ?? []),
        ]);

        return redirect()->route('routines.index')
                        ->with('success', 'Rutina creada correctamente.');
    }

    /**
     * Ver una rutina individual (público).
     */
    public function show(Routine $routine)
    {
        return view('routines.show', compact('routine'));
    }

    /**
     * Formulario para editar (solo el dueño puede entrar).
     */
    public function edit(Routine $routine)
    {
        $this->authorizeOwner($routine);

        return view('routines.edit', compact('routine'));
    }

    /**
     * Actualizar (solo el dueño).
     */
    public function update(Request $request, Routine $routine)
    {
        $this->authorizeOwner($routine);

        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'type'     => 'required|string|max:50',
            'products' => 'nullable|array',
        ]);

        $routine->update([
            'name'     => $validated['name'],
            'type'     => $validated['type'],
            'products' => json_encode($validated['products'] ?? []),
        ]);

        return redirect()->route('routines.show', $routine)
                        ->with('success', 'Rutina actualizada correctamente.');
    }

    /**
     * Eliminar (solo el dueño).
     */
    public function destroy(Routine $routine)
    {
        $this->authorizeOwner($routine);

        $routine->delete();

        return redirect()->route('routines.index')
                         ->with('success', 'Rutina eliminada correctamente.');
    }

    /**
     * Verificación: ¿la rutina pertenece al usuario autenticado?
     */
    private function authorizeOwner(Routine $routine)
    {
        if ($routine->user_id !== auth()->id()) {
            abort(403, 'No tenés permiso para realizar esta acción.');
        }
    }
}
