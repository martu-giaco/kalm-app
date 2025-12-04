<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Routine;
use App\Models\RoutineType;
use App\Models\RoutineTime;
use App\Models\Product;

class RoutineController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $routines = Routine::where('user_id', auth()->id())
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('routines.index', compact('routines'));
    }

    public function create()
    {
        return view('routines.create', [
            'types' => RoutineType::orderBy('name')->get(),
            'times' => RoutineTime::orderBy('name')->get(),
        ]);
    }

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

    public function show($routine_id)
    {
        $routine = Routine::findOrFail($routine_id);
        $this->authorizeOwner($routine);
        $routine->load(['types', 'routineTime']);
        return view('routines.show', compact('routine'));
    }

    public function edit($routine_id)
    {
        $routine = Routine::findOrFail($routine_id);
        $this->authorizeOwner($routine);

        $routine_types = RoutineType::orderBy('name')->get();
        $routine_times = RoutineTime::orderBy('name')->get();

        return view('routines.edit', compact('routine', 'routine_types', 'routine_times'));
    }

    public function update(Request $request, $routine_id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'time_id' => 'nullable|exists:routine_times,time_id',
            'products' => 'nullable|array',
        ]);

        $routine = Routine::findOrFail($routine_id);
        $routine->update([
            'name' => $validated['name'],
            'time_id' => $validated['time_id'] ?? null,
            'products' => $validated['products'] ?? [],
        ]);

        return redirect()->route('routines.show', $routine->routine_id)
                         ->with('success', 'Rutina actualizada correctamente.');
    }

    public function destroy(Routine $routine)
    {
        $routine->delete();
        return redirect()->route('routines.index')->with('success', 'Rutina eliminada correctamente.');
    }

    public function addProduct(Request $request, $routine)
    {
        $rutina = Routine::findOrFail($routine);
        $productId = $request->input('product_id');

        if (!$rutina->products()->where('product_id', $productId)->exists()) {
            $rutina->products()->attach($productId);
        }

        return redirect()->back()->with('success', 'Producto agregado a la rutina.');
    }

    public function removeProduct(Routine $routine, Product $product)
    {
        $routine->products()->detach($product->id);
        return redirect()->back()->with('success', 'Producto eliminado de la rutina');
    }

    public function productShow($productId)
    {
        $product = Product::findOrFail($productId);
        $routines = Routine::where('user_id', auth()->id())->get();
        return view('products.show', compact('product', 'routines'));
    }

    private function authorizeOwner(Routine $routine)
    {
        if ($routine->user_id != auth()->id()) {
            abort(403, 'No tenés permiso para realizar esta acción.');
        }
    }
}
