<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Routine;
use App\Models\RoutineType;
use App\Models\RoutineTime;
use App\Models\RoutineNeed;
use App\Models\Product;
use App\Models\RecommendedRoutine;
use Illuminate\Support\Facades\Auth;


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
        $routine_types = RoutineType::orderBy('name')->get();
        $routine_needs = RoutineNeed::orderBy('name')->get();
        $routine_times = RoutineTime::orderBy('name')->get();

        return view('routines.create', compact(
            'routine_types',
            'routine_needs',
            'routine_times'
        ));
    }

    public function storeFromRecommended($id)
    {
        $rec = RecommendedRoutine::findOrFail($id);

        $routine = Routine::create([
            'name' => $rec->name,
            'user_id' => auth()->id(),
            'time_id' => $rec->time_id,
            'type_id' => $rec->type_id,
            'steps' => $rec->steps,
        ]);

        return redirect()->route('routines.index')
            ->with('success', 'Rutina guardada en tu perfil ✨');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'time_id' => 'nullable|exists:routine_times,time_id',
            'type_id' => 'nullable|exists:routine_types,type_id',
            'products' => 'nullable|array',
            'products.*' => 'nullable|exists:products,product_id',
        ]);

        // Crear la rutina
        $routine = new Routine();
        $routine->name = $validated['name'];
        $routine->user_id = auth()->id();
        $routine->time_id = $validated['time_id'] ?? null;
        $routine->type_id = $validated['type_id'] ?? null;
        $routine->save();

        // Filtrar valores vacíos y asociar productos seleccionados (pivot)
        if (!empty($validated['products'])) {
            $productIds = array_filter($validated['products'], fn($id) => !empty($id));
            if (!empty($productIds)) {
                $routine->products()->sync($productIds);
            }
        }

        return redirect()->route('routines.index')
            ->with('success', 'Rutina creada correctamente.');
    }

    public function show($routine_id)
    {
        $routine = Routine::findOrFail($routine_id);
        $this->authorizeOwner($routine);
        $routine->load(['RoutineType', 'RoutineNeed', 'routineTime', 'products']);
        return view('routines.show', compact('routine'));
    }

    public function edit($routine_id)
    {
        $routine = Routine::findOrFail($routine_id);
        $this->authorizeOwner($routine);

        $routine_types = RoutineType::whereIn('name', ['Haircare', 'Skincare'])->orderBy('name')->get();
        $routine_needs = RoutineNeed::orderBy('name')->get();
        $routine_times = RoutineTime::orderBy('name')->get();

        return view('routines.edit', compact('routine', 'routine_types', 'routine_needs', 'routine_times'));
    }

    public function update(Request $request, $routine_id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'time_id' => 'nullable|exists:routine_times,time_id',
            'type_id' => 'nullable|exists:routine_types,type_id',
            'products' => 'nullable|array',
            'products.*' => 'nullable|exists:products,product_id',
        ]);

        $routine = Routine::findOrFail($routine_id);
        $this->authorizeOwner($routine);

        // Actualizar rutina
        $routine->update([
            'name' => $validated['name'],
            'time_id' => $validated['time_id'] ?? null,
            'type_id' => $validated['type_id'] ?? null,
        ]);

        // Actualizar productos
        $productIds = !empty($validated['products']) ? array_filter($validated['products'], fn($id) => !empty($id)) : [];
        $routine->products()->sync($productIds);

        return redirect()->route('routines.show', $routine->routine_id)
            ->with('success', 'Rutina actualizada correctamente.');
    }

    public function destroy(Routine $routine)
    {
        $this->authorizeOwner($routine);
        $routine->delete();
        return redirect()->route('routines.index')->with('success', 'Rutina eliminada correctamente.');
    }

    public function addProduct(Request $request, $routine)
    {
        $rutina = Routine::findOrFail($routine);
        $this->authorizeOwner($rutina);

        $productId = $request->input('product_id');
        if ($productId && !$rutina->products()->where('product_id', $productId)->exists()) {
            $rutina->products()->attach($productId);
        }

        return redirect()->back()->with('success', 'Producto agregado a la rutina.');
    }

    public function removeProduct(Routine $routine, Product $product)
    {
        $this->authorizeOwner($routine);
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
