<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Routine;
use App\Models\User;
use App\Models\Type;
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
        $routines = Routine::where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->paginate(10);

        $user = Auth::user();
        $canCreate = $user ? $user->canCreateRoutine() : false;

        return view('routines.index', compact('routines', 'canCreate'));
    }

    public function create()
    {
        $types = Type::orderBy('name')->get();
        $routine_needs = RoutineNeed::orderBy('name')->get();
        $routine_times = RoutineTime::orderBy('name')->get();

        $user = Auth::user();
        if ($user && !$user->canCreateRoutine()) {
            return redirect()->route('routines.index')
                ->with('feedback', [
                    'message' => 'Los usuarios free solo pueden crear hasta 2 rutinas. Elimina o edita una existente, o actualizate a Premium.',
                    'type' => 'error'
                ]);
        }

        return view('routines.create', compact('types', 'routine_needs', 'routine_times'));
    }

    public function storeFromRecommended($id)
    {
        $rec = RecommendedRoutine::findOrFail($id);

        $user = Auth::user();
        if (!$user->canCreateRoutine()) {
            return redirect()->route('routines.index')
                ->with('feedback', [
                    'message' => 'Los usuarios free solo pueden guardar hasta 2 rutinas. Prueba actualizar a Premium.',
                    'type' => 'error'
                ]);
        }

        $routine = Routine::create([
            'name' => $rec->name,
            'user_id' => Auth::id(),
            'time_id' => $rec->time_id,
            'type_id' => $rec->type_id,
            'need_id' => $rec->need_id,
            'steps' => $rec->steps,
            'reminder_time' => null,
            'is_reminder_enabled' => false,
        ]);

        return redirect()->route('routines.index')
            ->with('feedback', [
                'message' => 'Rutina guardada en tu perfil ✨',
                'type' => 'success'
            ]);
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'time_id' => 'nullable|exists:routine_times,time_id',
        'type_id' => 'nullable|exists:types,id',
        'need_id' => 'nullable|exists:routine_needs,need_id',
        'products' => 'nullable|array',
        'products.*' => 'nullable|exists:products,id',
        'reminder_time' => 'nullable|date_format:H:i',
        'is_reminder_enabled' => 'boolean',
        'reminder_frequency' => 'required|string|in:none,daily,weekly,every_x_days',
        'reminder_days' => 'nullable|array',
        'reminder_days.*' => 'string|in:mon,tue,wed,thu,fri,sat,sun',
        'reminder_interval' => 'nullable|integer|min:1|max:30',
    ]);

        $user = Auth::user();
        if ($user && !$user->canCreateRoutine()) {
            return redirect()->route('routines.index')
                ->with('feedback', [
                    'message' => 'Los usuarios free solo pueden crear hasta 2 rutinas. Prueba actualizar a Premium.',
                    'type' => 'error'
                ]);
        }

    $routine = new Routine();
    $routine->name = $validated['name'];
    $routine->user_id = $user->getKey();
    $routine->time_id = $validated['time_id'] ?? null;
    $routine->type_id = $validated['type_id'] ?? null;
    $routine->need_id = $validated['need_id'] ?? null;
    $routine->reminder_time = $validated['reminder_time'] ?? null;
    $routine->is_reminder_enabled = $request->has('is_reminder_enabled');
    $routine->reminder_frequency = $validated['reminder_frequency'] ?? 'none';
    $routine->reminder_days = $validated['reminder_days'] ?? null;
    $routine->reminder_interval = $validated['reminder_interval'] ?? null;
    $routine->save();

    if (!empty($validated['products'])) {
        $productIds = array_filter($validated['products'], fn($id) => !empty($id));
        if (!empty($productIds)) {
            $routine->products()->sync($productIds);
        }
    }

        return redirect()->route('routines.index')
            ->with('feedback', [
                'message' => 'Rutina creada correctamente.',
                'type' => 'success'
            ]);
    }

    public function show($routine_id)
    {
        $routine = Routine::findOrFail($routine_id);
        $this->authorizeOwner($routine);

        $routine->load(['Type', 'RoutineNeed', 'routineTime', 'assignedProducts.category']);

        $stepsOrder = [
            'tratamientos' => 'Tratamientos',
            'limpiadores' => 'Limpieza',
            'shampoo' => 'Limpieza',
            'exfoliantes' => 'Exfoliación',
            'tonicos' => 'Tonificación',
            'serums' => 'Tratamiento',
            'hidratantes' => 'Hidratación',
            'acondicionador' => 'Hidratación',
            'hidratantes-corporales' => 'Hidratación',
            'protectores-solares' => 'Protección solar',
        ];

        $groupedProducts = $routine->assignedProducts->groupBy(function ($product) {
            return $product->category?->slug;
        });

        $steps = [];
        $stepNumber = 1;

        foreach ($stepsOrder as $slug => $label) {
            if ($groupedProducts->has($slug)) {
                $steps[] = [
                    'number' => $stepNumber++,
                    'title' => $label,
                    'products' => $groupedProducts[$slug],
                ];
            }
        }

        $productsForYouQuery = Product::with('brand', 'type');
        if ($routine->type_id) {
            $productsForYouQuery->where('type_id', $routine->type_id);
        }

        $productsForYouQuery->whereNotIn('id', $routine->assignedProducts->pluck('id'));
        $productsForYouQuery->inRandomOrder();

        $productsForYou = $productsForYouQuery->limit(12)->get();

        $product_sections = [
            [
                'title' => 'Productos para tu rutina',
                'products' => $productsForYou,
            ],
        ];

        return view('routines.show', compact('routine', 'product_sections', 'steps', 'groupedProducts'));
    }

    public function edit($routine_id)
    {
        $routine = Routine::findOrFail($routine_id);
        $this->authorizeOwner($routine);

        $types = Type::orderBy('name')->get();
        $routine_needs = RoutineNeed::orderBy('name')->get();
        $routine_times = RoutineTime::orderBy('name')->get();

        $isFromRecommended = \App\Models\UserTestResult::where('routine_id', $routine->routine_id)->exists();

        return view('routines.edit', compact('routine', 'types', 'routine_needs', 'routine_times', 'isFromRecommended'));
    }

    public function update(Request $request, $routine_id)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'time_id' => 'nullable|exists:routine_times,time_id',
        'type_id' => 'nullable|exists:types,id',
        'need_id' => 'nullable|exists:routine_needs,need_id',
        'products' => 'nullable|array',
        'products.*' => 'nullable|exists:products,id',
        'reminder_time' => 'nullable|date_format:H:i',
        'is_reminder_enabled' => 'boolean',
        // Agregar las validaciones de los nuevos campos:
        'reminder_frequency' => 'required|string|in:none,daily,weekly,every_x_days',
        'reminder_days' => 'nullable|array',
        'reminder_days.*' => 'string|in:mon,tue,wed,thu,fri,sat,sun',
        'reminder_interval' => 'nullable|integer|min:1|max:30',
    ]);

    $routine = Routine::findOrFail($routine_id);
    $this->authorizeOwner($routine);

    $routine->update([
        'name' => $validated['name'],
        'time_id' => $validated['time_id'] ?? null,
        'type_id' => $validated['type_id'] ?? null,
        'need_id' => $validated['need_id'] ?? null,
        'reminder_time' => $validated['reminder_time'] ?? null,
        'is_reminder_enabled' => $request->has('is_reminder_enabled'),
        // Guardar los nuevos campos validados:
        'reminder_frequency' => $validated['reminder_frequency'],
        'reminder_days' => $validated['reminder_days'] ?? null, // Gracias al cast de Eloquent, se guarda como JSON solo
        'reminder_interval' => $validated['reminder_interval'] ?? null,
    ]);

    if ($request->has('products')) {
        $productIds = $validated['products'] ?? [];
        $productIds = array_filter($productIds, fn($id) => !empty($id));
        $routine->products()->sync($productIds);
    }

    return redirect()->route('routines.show', $routine->routine_id)
        ->with('feedback', [
            'message' => 'Rutina actualizada correctamente.',
            'type' => 'success'
        ]);
}

    public function destroy(Request $request, Routine $routine)
{
    $this->authorizeOwner($routine);
    $routine->delete();

    if ($request->boolean('from_test_result')) {
        return redirect()->route('tests.result')->with('feedback', [
            'message' => 'Rutina eliminada correctamente. Ya podés guardar la nueva rutina del test.',
            'type' => 'success',
        ]);
    }

    return redirect()->route('routines.index')->with('feedback', [
        'message' => 'Rutina eliminada correctamente.',
        'type' => 'success',
    ]);
}

    public function addProduct(Request $request, $routine)
{
    $rutina = Routine::findOrFail($routine);
    $this->authorizeOwner($rutina);

    // CORRECCIÓN: Cambiar 'id' por 'product_id'
    $productId = $request->input('product_id');

    if ($productId && !$rutina->products()->where('products.id', $productId)->exists()) {
        $rutina->products()->attach($productId);
    }

    return redirect()->back()
        ->with('feedback', [
            'message' => 'Producto agregado a la rutina.',
            'type' => 'success'
        ]);
}

    public function removeProduct(Routine $routine, Product $product)
    {
        $this->authorizeOwner($routine);
        $routine->products()->detach($product->id);
        return redirect()->back()
            ->with('feedback', [
                'message' => 'Producto eliminado de la rutina',
                'type' => 'success'
            ]);
    }

    /**
     * Guarda la rutina recomendada después de que el usuario haya eliminado una existente.
     * Usado cuando el usuario alcanzó el límite de 2 rutinas (plan free).
     */
    public function saveRecommendedRoutine(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('auth.login');
        }

        $request->validate([
            'test_key' => 'required|string',
            'result_key' => 'required|string',
        ]);

        $testKey = $request->input('test_key');
        $resultKey = $request->input('result_key');

        // Verificar que el usuario ahora puede crear rutinas
        if (!$user->canCreateRoutine()) {
            return redirect()->route('tests.result')
                ->with('feedback', [
                    'message' => 'Aún has alcanzado el límite de rutinas. Elimina más para continuar.',
                    'type' => 'error'
                ]);
        }

        // Obtener la rutina recomendada
        $recommendedRoutine = RecommendedRoutine::where('test_key', $testKey)
            ->where('result_key', $resultKey)
            ->first();

        if (!$recommendedRoutine) {
            return redirect()->route('tests.result')
                ->with('feedback', [
                    'message' => 'No se encontró la rutina recomendada.',
                    'type' => 'error'
                ]);
        }

        // Crear la rutina
        $productIds = is_string($recommendedRoutine->products)
            ? json_decode($recommendedRoutine->products, true)
            : $recommendedRoutine->products;

        $typeId = null;
        if ($testKey === 'piel') {
            $typeId = Type::where('name', 'Skincare')->first()?->id ?? Type::where('name', 'Skincare')->first()?->type_id;
        } elseif ($testKey === 'cabello') {
            $typeId = Type::where('name', 'Haircare')->first()?->id ?? Type::where('name', 'Haircare')->first()?->type_id;
        }

        $routine = Routine::create([
            'user_id' => $user->id,
            'name' => $recommendedRoutine->name,
            'steps' => $recommendedRoutine->steps,
            'type_id' => $typeId,
        ]);

        if (!empty($productIds) && is_array($productIds)) {
            $routine->products()->attach($productIds);
        }

        // Actualizar el resultado del test para asociarlo con la rutina
        UserTestResult::where('user_id', $user->id)
            ->where('test_key', $testKey)
            ->update(['routine_id' => $routine->routine_id]);

        return redirect()->route('routines.index')
            ->with('feedback', [
                'message' => 'Rutina guardada correctamente ✨',
                'type' => 'success'
            ]);
    }

    public function productShow($productId)
    {
        $product = Product::findOrFail($productId);
        $routines = Routine::where('user_id', Auth::id())->get();
        return view('products.show', compact('product', 'routines'));
    }

    private function authorizeOwner(Routine $routine)
    {
        if ($routine->user_id && $routine->user_id != Auth::id()) {
            abort(403, 'No tenés permiso para realizar esta acción.');
        }
    }

    public function complete(Routine $routine)
{
    $this->authorizeOwner($routine);
    $routine->markCompletedToday();

    return redirect()->back()->with('feedback', [
        'message' => '¡Rutina marcada como completada por hoy! 🎉',
        'type' => 'success',
    ]);
}

public function postpone(Routine $routine)
{
    $this->authorizeOwner($routine);
    $routine->snooze(15);

    return redirect()->back()->with('feedback', [
        'message' => 'Recordatorio pospuesto 15 minutos.',
        'type' => 'success',
    ]);
}

public function notifyComplete(Routine $routine)
{
    $routine->markCompletedToday();

    return response(
        '<html><body style="font-family:sans-serif;text-align:center;padding:40px;">
            <h2>¡Listo! Marcamos tu rutina como completada 🎉</h2>
            <p>Ya podés cerrar esta pestaña.</p>
        </body></html>'
    );
}

public function notifyPostpone(Routine $routine)
{
    $routine->snooze(15);

    return response(
        '<html><body style="font-family:sans-serif;text-align:center;padding:40px;">
            <h2>Pospusimos tu recordatorio 15 minutos ⏰</h2>
            <p>Ya podés cerrar esta pestaña.</p>
        </body></html>'
    );
}
}
