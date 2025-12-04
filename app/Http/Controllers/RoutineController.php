<?php

namespace App\Http\Controllers;

use App\Models\Routine;
use App\Models\RoutineType;
use App\Models\RoutineTime;
use App\Models\Product;
use Illuminate\Http\Request;

class RoutineController extends Controller
{
    /**
     * Mostrar todas las rutinas del usuario autenticado
     */
    public function index()
    {
        $routines = auth()->user()->routines()->with(['types', 'times'])->latest()->paginate(10);
        return view('routines.index', compact('routines'));
    }

    /**
     * Mostrar formulario para crear rutina
     */
    public function create()
    {
        return view('routines.create', [
            'types' => RoutineType::orderBy('name')->get(),
            'times' => RoutineTime::orderBy('name')->get(),
        ]);
    }

    /**
     * Guardar nueva rutina
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'products' => 'nullable|array',
        ]);

        auth()->user()->routines()->create([
            'name' => $validated['name'],
            'products' => json_encode($validated['products'] ?? []),
        ]);

        return redirect()->route('routines.index')->with('success', 'Rutina creada correctamente.');
    }

    /**
     * Ver rutina individual
     */
    public function show(Routine $routine)
    {
        $this->authorizeOwner($routine);
        return view('routines.show', compact('routine'));
    }

    /**
     * Mostrar formulario para editar rutina
     */
    public function edit(Routine $routine)
    {
        $this->authorizeOwner($routine);

        return view('routines.edit', [
            'routine' => $routine,
            'types' => RoutineType::orderBy('name')->get(),
            'times' => RoutineTime::orderBy('name')->get(),
        ]);
    }

    /**
     * Actualizar rutina
     */
    public function update(Request $request, Routine $routine)
    {
        $this->authorizeOwner($routine);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'products' => 'nullable|array',
        ]);

        $routine->update([
            'name' => $validated['name'],
            'products' => json_encode($validated['products'] ?? []),
        ]);

        return redirect()->route('routines.show', $routine)->with('success', 'Rutina actualizada correctamente.');
    }

    /**
     * Eliminar rutina
     */
    public function destroy(Routine $routine)
    {
        $this->authorizeOwner($routine);
        $routine->delete();

        return redirect()->route('routines.index')->with('success', 'Rutina eliminada correctamente.');
    }

    /**
     * Agregar un producto a una rutina desde formulario
     */
    // en RoutineController.php
    public function addProduct(Request $request, $routineId)
    {
        // Obtener la rutina
        $routine = \App\Models\Routine::findOrFail($routineId);

        // Decodificar los productos existentes (JSON)
        $products = json_decode($routine->products ?? '[]', true);

        // Agregar el nuevo producto si no está repetido
        $newProductId = $request->input('product_id');
        if (!in_array($newProductId, $products)) {
            $products[] = $newProductId;
        }

        // Guardar la rutina con los productos actualizados
        $routine->products = json_encode($products);
        $routine->save();

        // Redirigir a la rutina actualizada
        return redirect()->route('routines.show', $routine->routine_id)
            ->with('success', 'Producto agregado a la rutina correctamente.');
    }


    /**
     * Mostrar producto con opción de agregar a rutinas del usuario
     */
    public function productShow(Product $product)
    {
        $routines = auth()->user()->routines; // todas las rutinas del usuario
        return view('products.show', compact('product', 'routines'));
    }

    /**
     * Verificar propietario de rutina
     */
    private function authorizeOwner(Routine $routine)
    {
        if ($routine->user_id !== auth()->id()) {
            abort(403, 'No tenés permiso para realizar esta acción.');
        }
    }
}
