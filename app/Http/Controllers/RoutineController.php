<?php

namespace App\Http\Controllers;

use App\Models\Routine;
use App\Models\RoutineType;
use App\Models\RoutineTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class RoutineController extends Controller
{
    /**
     * Ver todas las rutinas
     */
    public function index()
    {
        $routines = Routine::with(['user', 'types', 'times'])
                            ->latest()
                            ->paginate(10);

        return view('routines.index', compact('routines'));
    }

    /**
     * Formulario para crear una rutina
     */
    public function create()
    {
            return view('routines.create',[
            'types' => RoutineType::orderBy('name')->get(),
            'times' => RoutineTime::orderBy('name')->get(),
        ]);
    }

    /**
     * Guardar una rutina para el usuario autenticado.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'products' => 'nullable|array',
        ]);

        Routine::create([
            'user_id'  => auth()->id(),
            'name'     => $validated['name'],
            'products' => json_encode($validated['products'] ?? []),
        ]);

        return redirect()->route('routines.index')
                        ->with('success', 'Rutina creada correctamente.');
    }

    /**
     * Ver una rutina individual
     */
    public function view(Routine $routine)
    {
        return view('routines.view', compact('routine'));
    }

    /**
     * editar rutina
     */
    public function edit(Routine $routine)
    {
        $this->authorizeOwner($routine);

        return view('routines.edit', compact('routine'));
    }

    //agregar producto a rutina
    public function addProduct(Request $request, Routine $routine)
    {
        // Asegurarse de que la rutina pertenezca al usuario autenticado
        if ($routine->user_id !== auth()->id()) {
            abort(403, 'No tienes permiso para modificar esta rutina');
        }

        // Validar el ID del producto
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
        ]);

        // Obtener productos actuales
        $products = $routine->products ?? [];

        // Evitar duplicados
        if (!in_array($request->product_id, $products)) {
            $products[] = $request->product_id;
        }

        // Guardar el JSON actualizado
        $routine->products = $products;
        $routine->save();

        return back()->with('success', 'Producto agregado correctamente');
    }

    /**
     * Actualizar
     */
    public function update(Request $request, Routine $routine)
    {
        $this->authorizeOwner($routine);

        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'products' => 'nullable|array',
        ]);

        $routine->update([
            'name'     => $validated['name'],
            'products' => json_encode($validated['products'] ?? []),
        ]);

        return redirect()->route('routines.view', $routine)
                        ->with('success', 'Rutina actualizada correctamente.');
    }

    /**
     * Eliminar
     */
    public function destroy(Routine $routine)
    {
        $this->authorizeOwner($routine);

        $routine->delete();

        return redirect()->route('routines.index')
                        ->with('success', 'Rutina eliminada correctamente.');
    }

    /**
     * Verificación
     */
    private function authorizeOwner(Routine $routine)
    {
        if ($routine->user_id !== auth()->id()) {
            abort(403, 'No tenés permiso para realizar esta acción.');
        }
    }

    public function add(Product $product)
{
    // Lógica ejemplo
    auth()->user()->routine()->attach($product->id);

    return back()->with('success', 'Producto agregado a tu rutina');
}

}
