<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoutineType;
use App\Models\RoutineTime;
use App\Models\Product;
use App\Models\Routine;

class RoutineController extends Controller
{
    /**
     * Aplicar middleware auth
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Mostrar todas las rutinas del usuario autenticado
     */
    public function index()
    {
        $userId = auth()->id();

        $routines = Routine::where('user_id', $userId)
            ->orderByDesc('created_at')
            ->paginate(10);

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
            'time_id' => 'nullable|exists:routine_times,time_id',
            'products' => 'nullable|array',
        ]);

        $routine = new Routine();
        $routine->name = $validated['name'];
        $routine->user_id = auth()->id();
        $routine->time_id = $validated['time_id'] ?? null;
        $routine->products = json_encode($validated['products'] ?? []);
        $routine->save();

        return redirect()->route('routines.index')
            ->with('success', 'Rutina creada correctamente.');
    }

    /**
     * Ver rutina individual
     */
    public function show($routine_id)
    {
        $routine = Routine::findOrFail($routine_id);
        $this->authorizeOwner($routine);

        $routine->load(['types', 'routineTime']); // carga relaciones necesarias

        return view('routines.show', compact('routine'));
    }

    /**
     * Mostrar formulario para editar rutina
     */
    public function edit($routine_id)
    {
        $routine = Routine::findOrFail($routine_id);
        $this->authorizeOwner($routine);

        $routine_types = RoutineType::orderBy('name')->get();
        $routine_times = RoutineTime::orderBy('name')->get();

        return view('routines.edit', compact('routine', 'routine_types', 'routine_times'));
    }

    /**
     * Actualizar rutina
     */
    public function update(Request $request, $routine_id)
    {
        $routine = Routine::findOrFail($routine_id);
        $this->authorizeOwner($routine);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'routine_type_id' => 'required|exists:routine_types,type_id',
            'routine_time_id' => 'required|exists:routine_times,time_id',
        ]);

        $routine->update($validated);

        return redirect()->route('routines.show', $routine->routine_id)
                         ->with('success', 'Rutina actualizada correctamente.');
    }

    /**
     * Eliminar rutina
     */
    public function destroy($routine_id)
    {
        $routine = Routine::findOrFail($routine_id);
        $this->authorizeOwner($routine);

        $routine->delete();

        return redirect()->route('routines.index')
            ->with('success', 'Rutina eliminada correctamente.');
    }

    /**
     * Agregar un producto a una rutina
     */
    public function addProduct(Request $request, $routine)
    {
        $rutina = Routine::findOrFail($routine);

        $productId = $request->input('product_id');

        // Evita duplicados
        if (!$rutina->products()->where('product_id', $productId)->exists()) {
            $rutina->products()->attach($productId);
        }

        return redirect()->back()->with('success', 'Producto agregado a la rutina.');
    }

    /**
     * Mostrar producto con opción de agregar a rutinas del usuario
     */
    public function productShow($productId)
    {
        $product = Product::findOrFail($productId);
        $routines = Routine::where('user_id', auth()->id())->get();

        return view('products.show', compact('product', 'routines'));
    }

    /**
     * Verificar propietario de rutina
     */
    private function authorizeOwner(Routine $routine)
    {
        if ($routine->user_id != auth()->id()) {
            abort(403, 'No tenés permiso para realizar esta acción.');
        }
    }
}
