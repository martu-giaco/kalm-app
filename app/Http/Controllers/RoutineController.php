<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Routine;
use App\Models\RoutineType;
use App\Models\Type;
use App\Models\RoutineTime;
use App\Models\RoutineNeed;
use App\Models\Product;
use App\Models\User;
use App\Models\RecommendedRoutine;
use App\Models\UserTestResult;
use App\Services\GoogleCalendarService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RoutineController extends Controller
{
    protected GoogleCalendarService $calendarService;

    public function __construct(GoogleCalendarService $calendarService)
    {
        $this->middleware('auth')->except(['notifyComplete', 'notifyPostpone']);
        $this->calendarService = $calendarService;
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
        $types = RoutineType::orderBy('name')->get();
        $routine_needs = RoutineNeed::orderBy('name')->get();
        $routine_times = RoutineTime::orderBy('name')->get();
        $products = Product::orderBy('name')->get();

        $user = Auth::user();
        if ($user && !$user->canCreateRoutine()) {
            return redirect()->route('routines.index')
                ->with('feedback', [
                    'message' => 'Los usuarios free solo pueden crear hasta 2 rutinas. Elimina o edita una existente, o actualízate a Premium.',
                    'type' => 'error'
                ]);
        }

        return view('routines.create', compact('types', 'routine_needs', 'routine_times', 'products'));
    }

    public function storeFromRecommended($id)
    {
        $rec = RecommendedRoutine::findOrFail($id);

        $user = Auth::user();
        // En RoutineController.php

if ($user && !$user->canCreateRoutine()) {
    return redirect()->route('routines.index')
        ->with('feedback', [
            'message' => 'Has alcanzado el límite de rutinas permitidas para tu plan.',
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
            'notification_channel' => 'google_calendar',
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
            'time_id' => 'nullable',
            'type_id' => 'nullable',
            'need_id' => 'nullable',
            'products' => 'nullable|array',
            'products.*' => 'nullable|exists:products,id',
            'reminder_time' => 'nullable',
            'is_reminder_enabled' => 'nullable|boolean',
            'reminder_frequency' => 'nullable|string',
            'reminder_days' => 'nullable|array',
            'reminder_interval' => 'nullable|integer',
            'notification_channel' => 'nullable|string',
        ]);

        $user = Auth::user();
        if ($user && !$user->canCreateRoutine()) {
            return redirect()->route('routines.index')
                ->with('feedback', [
                    'message' => 'Los usuarios free solo pueden crear hasta 2 rutinas. Prueba actualizar a Premium.',
                    'type' => 'error'
                ]);
        }

        $isReminderEnabled = $request->boolean('is_reminder_enabled');

        $routine = Routine::create([
            'user_id' => $user->getKey(),
            'name' => $validated['name'],
            'time_id' => $validated['time_id'] ?? null,
            'type_id' => $validated['type_id'] ?? null,
            'need_id' => $validated['need_id'] ?? null,
            'reminder_time' => $isReminderEnabled ? ($validated['reminder_time'] ?? '08:00') : null,
            'is_reminder_enabled' => $isReminderEnabled,
            'reminder_frequency' => $isReminderEnabled ? ($validated['reminder_frequency'] ?? 'daily') : 'none',
            'reminder_days' => $isReminderEnabled ? ($validated['reminder_days'] ?? null) : null,
            'reminder_interval' => $isReminderEnabled ? ($validated['reminder_interval'] ?? null) : null,
            'notification_channel' => $validated['notification_channel'] ?? 'google_calendar',
        ]);

        if (!empty($validated['products'])) {
            $productIds = array_filter($validated['products'], fn($id) => !empty($id));
            if (!empty($productIds)) {
                $routine->products()->sync($productIds);
            }
        }

        // Sincronización con Google Calendar si la opción está activada
        if ($routine->is_reminder_enabled) {
            if ($user->google_refresh_token) {
                $eventId = $this->calendarService->syncRoutineEvent($routine, $user);
                if ($eventId) {
                    $routine->update(['google_event_id' => $eventId]);
                }
            } else {
                return redirect()->route('routines.show', $routine->getKey())->with('feedback', [
                    'message' => 'Rutina creada, pero debes vincular tu cuenta con Google Calendar para sincronizar el recordatorio.',
                    'type' => 'warning'
                ]);
            }
        }

        return redirect()->route('routines.show', $routine->getKey())
            ->with('feedback', [
                'message' => 'Rutina creada correctamente.',
                'type' => 'success'
            ]);
    }

    public function show($id)
    {
        $routine = $this->resolveRoutine($id);
        $this->authorizeOwner($routine);

        $routine->load(['type', 'routineNeed', 'routineTime', 'assignedProducts.category']);

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

    public function edit($id)
    {
        $routine = $this->resolveRoutine($id);
        $this->authorizeOwner($routine);

        $types = RoutineType::orderBy('name')->get();
        $routine_needs = RoutineNeed::orderBy('name')->get();
        $routine_times = RoutineTime::orderBy('name')->get();

        $routineKey = $routine->getKey();

        $isFromRecommended = false;
        if (class_exists(\App\Models\UserTestResult::class)) {
            $isFromRecommended = UserTestResult::where('routine_id', $routineKey)->exists();
        }

        return view('routines.edit', compact(
            'routine',
            'types',
            'routine_needs',
            'routine_times',
            'isFromRecommended'
        ));
    }

    public function update(Request $request, $id)
    {
        $routine = $this->resolveRoutine($id);
        $this->authorizeOwner($routine);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'time_id' => 'nullable',
            'type_id' => 'nullable',
            'need_id' => 'nullable',
            'products' => 'nullable|array',
            'products.*' => 'nullable|exists:products,id',
            'reminder_time' => 'nullable',
            'is_reminder_enabled' => 'nullable|boolean',
            'reminder_frequency' => 'nullable|string',
            'reminder_days' => 'nullable|array',
            'reminder_interval' => 'nullable|integer',
            'notification_channel' => 'nullable|string',
        ]);

        $user = Auth::user();
        $isReminderEnabled = $request->boolean('is_reminder_enabled');

        $routine->update([
            'name' => $validated['name'],
            'time_id' => $validated['time_id'] ?? null,
            'type_id' => $validated['type_id'] ?? null,
            'need_id' => $validated['need_id'] ?? null,
            'reminder_time' => $isReminderEnabled ? ($validated['reminder_time'] ?? '08:00') : null,
            'is_reminder_enabled' => $isReminderEnabled,
            'reminder_frequency' => $isReminderEnabled ? ($validated['reminder_frequency'] ?? 'daily') : 'none',
            'reminder_days' => $isReminderEnabled ? ($validated['reminder_days'] ?? null) : null,
            'reminder_interval' => $isReminderEnabled ? ($validated['reminder_interval'] ?? null) : null,
            'notification_channel' => $validated['notification_channel'] ?? 'google_calendar',
        ]);

        if (isset($validated['products'])) {
            $productIds = array_filter($validated['products'], fn($pId) => !empty($pId));
            $routine->products()->sync($productIds);
        }

        // Sincronizar o remover evento de Google Calendar
        if ($routine->is_reminder_enabled && $user->google_refresh_token) {
            $eventId = $this->calendarService->syncRoutineEvent($routine, $user);
            if ($eventId) {
                $routine->update(['google_event_id' => $eventId]);
            }
        } elseif (!$routine->is_reminder_enabled && $routine->google_event_id) {
            $this->calendarService->deleteRoutineEvent($routine, $user);
            $routine->update(['google_event_id' => null]);
        }

        return redirect()->route('routines.show', $routine->getKey())
            ->with('feedback', [
                'message' => 'Rutina actualizada correctamente.',
                'type' => 'success'
            ]);
    }

    public function destroy(Request $request, $id)
    {
        $routine = $this->resolveRoutine($id);
        $this->authorizeOwner($routine);

        $user = Auth::user();

        if ($routine->google_event_id && $user->google_refresh_token) {
            $this->calendarService->deleteRoutineEvent($routine, $user);
        }

        $routine->products()->detach();
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
        $rutina = $this->resolveRoutine($routine);
        $this->authorizeOwner($rutina);

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

    public function removeProduct($routine, Product $product)
    {
        $rutina = $this->resolveRoutine($routine);
        $this->authorizeOwner($rutina);
        $rutina->products()->detach($product->id);

        return redirect()->back()
            ->with('feedback', [
                'message' => 'Producto eliminado de la rutina',
                'type' => 'success'
            ]);
    }

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

        if (!$user->canCreateRoutine()) {
            return redirect()->route('tests.result')
                ->with('feedback', [
                    'message' => 'Aún has alcanzado el límite de rutinas. Elimina más para continuar.',
                    'type' => 'error'
                ]);
        }

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

        $productIds = is_string($recommendedRoutine->products)
            ? json_decode($recommendedRoutine->products, true)
            : $recommendedRoutine->products;

        $typeId = null;
        if ($testKey === 'piel') {
            $typeId = RoutineType::where('name', 'Skincare')->first()?->id ?? RoutineType::where('name', 'Skincare')->first()?->type_id;
        } elseif ($testKey === 'cabello') {
            $typeId = RoutineType::where('name', 'Haircare')->first()?->id ?? RoutineType::where('name', 'Haircare')->first()?->type_id;
        }

        $routine = Routine::create([
            'user_id' => $user->id,
            'name' => $recommendedRoutine->name,
            'steps' => $recommendedRoutine->steps,
            'type_id' => $typeId,
            'notification_channel' => 'google_calendar',
        ]);

        if (!empty($productIds) && is_array($productIds)) {
            $routine->products()->attach($productIds);
        }

        UserTestResult::where('user_id', $user->id)
            ->where('test_key', $testKey)
            ->update(['routine_id' => $routine->getKey()]);

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

    private function resolveRoutine($id): Routine
{
    return Routine::where('routine_id', $id)->firstOrFail();
}

    private function authorizeOwner(Routine $routine)
    {
        if ($routine->user_id && $routine->user_id != Auth::id()) {
            abort(403, 'No tenés permiso para realizar esta acción.');
        }
    }

    public function complete($id)
    {
        $routine = $this->resolveRoutine($id);
        $this->authorizeOwner($routine);

        if (method_exists($routine, 'markCompletedToday')) {
            $routine->markCompletedToday();
        }

        return redirect()->back()->with('feedback', [
            'message' => '¡Rutina marcada como completada por hoy! 🎉',
            'type' => 'success',
        ]);
    }

    public function postpone($id)
    {
        $routine = $this->resolveRoutine($id);
        $this->authorizeOwner($routine);

        if (method_exists($routine, 'snooze')) {
            $routine->snooze(15);
        }

        return redirect()->back()->with('feedback', [
            'message' => 'Recordatorio pospuesto 15 minutos.',
            'type' => 'success',
        ]);
    }

    public function notifyComplete($id)
    {
        $routine = $this->resolveRoutine($id);
        if (method_exists($routine, 'markCompletedToday')) {
            $routine->markCompletedToday();
        }

        return response(
            '<html><body style="font-family:sans-serif;text-align:center;padding:40px;">
                <h2>¡Listo! Marcamos tu rutina como completada 🎉</h2>
                <p>Ya podés cerrar esta pestaña.</p>
            </body></html>'
        );
    }

    public function notifyPostpone($id)
    {
        $routine = $this->resolveRoutine($id);
        if (method_exists($routine, 'snooze')) {
            $routine->snooze(15);
        }

        return response(
            '<html><body style="font-family:sans-serif;text-align:center;padding:40px;">
                <h2>Pospusimos tu recordatorio 15 minutos ⏰</h2>
                <p>Ya podés cerrar esta pestaña.</p>
            </body></html>'
        );
    }
}
