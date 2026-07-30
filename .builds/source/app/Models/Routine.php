<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Carbon;

class Routine extends Model
{
    protected $table = 'routines';
    protected $primaryKey = 'routine_id';
    public $incrementing = true;

    protected $fillable = [
        'name', 'user_id', 'time_id', 'type_id', 'need_id',
        'steps', 'reminder_time', 'is_reminder_enabled',
        'reminder_frequency', 'reminder_days', 'reminder_interval',
        'last_completed_at', 'last_notified_at', 'snoozed_until',
    ];

    protected $casts = [
        'steps' => 'array',
        'is_reminder_enabled' => 'boolean',
        'reminder_time' => 'datetime:H:i',
        'reminder_days' => 'array',
        'last_completed_at' => 'date',
        'last_notified_at' => 'datetime',
        'snoozed_until' => 'datetime',
    ];

    protected $appends = ['formatted_time', 'is_completed_today'];

    // ------------------------------------------------------------------
    // Relaciones
    // ------------------------------------------------------------------

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function routineTime(): BelongsTo
    {
        return $this->belongsTo(RoutineTime::class, 'time_id', 'time_id');
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function routineNeed(): BelongsTo
    {
        return $this->belongsTo(RoutineNeed::class, 'need_id', 'need_id');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'routine_product', 'routine_id', 'product_id');
    }

    public function assignedProducts()
    {
        return $this->products();
    }

    // ------------------------------------------------------------------
    // Accessors
    // ------------------------------------------------------------------

    protected function formattedTime(): Attribute
    {
        return Attribute::get(fn () => $this->reminder_time
            ? Carbon::parse($this->reminder_time)->format('H:i')
            : null
        );
    }

    /**
     * Etiqueta de estado: true = "Completada por hoy", false = "Pendiente".
     */
    protected function isCompletedToday(): Attribute
    {
        return Attribute::get(fn () => $this->last_completed_at?->isToday() ?? false);
    }

    // ------------------------------------------------------------------
    // Lógica de recordatorios / notificaciones
    // ------------------------------------------------------------------

    /**
     * Determina si esta rutina debe disparar una notificación push
     * en el minuto exacto representado por $now.
     */
    public function isDueNow(Carbon $now): bool
    {
        if (!$this->is_reminder_enabled || !$this->reminder_time) {
            return false;
        }

        // Si el usuario pospuso el aviso, esperar hasta que se cumpla el nuevo horario
        if ($this->snoozed_until) {
            return $this->snoozed_until->lessThanOrEqualTo($now);
        }

        // Ya se marcó como hecha hoy: no volver a notificar
        if ($this->is_completed_today) {
            return false;
        }

        // Evitar reenvíos duplicados dentro del mismo minuto de cron
        if ($this->last_notified_at && $this->last_notified_at->diffInSeconds($now) < 55) {
            return false;
        }

        $currentTime = $now->format('H:i');
        $reminderTime = Carbon::parse($this->reminder_time)->format('H:i');

        if ($currentTime !== $reminderTime) {
            return false;
        }

        return match ($this->reminder_frequency) {
            'daily' => true,
            'weekly' => in_array($this->currentDayKey($now), $this->reminder_days ?? []),
            'every_x_days' => $this->matchesInterval($now),
            default => false, // 'none'
        };
    }

    /**
     * Clave de día usada en reminder_days (mon, tue, wed, ...).
     */
    private function currentDayKey(Carbon $now): string
    {
        return match ($now->dayOfWeekIso) {
            1 => 'mon',
            2 => 'tue',
            3 => 'wed',
            4 => 'thu',
            5 => 'fri',
            6 => 'sat',
            7 => 'sun',
        };
    }

    /**
     * Para reminder_frequency = every_x_days: compara contra la última
     * notificación (o la fecha de creación si nunca se notificó).
     */
    private function matchesInterval(Carbon $now): bool
    {
        $interval = $this->reminder_interval ?? 1;
        $reference = ($this->last_notified_at ?? $this->created_at)->copy()->startOfDay();

        return $reference->diffInDays($now->copy()->startOfDay()) >= $interval;
    }

    /**
     * Marca la rutina como completada por hoy y limpia cualquier snooze.
     */
    public function markCompletedToday(): void
    {
        $this->update([
            'last_completed_at' => now()->toDateString(),
            'snoozed_until' => null,
        ]);
    }

    /**
     * Pospone el recordatorio X minutos (default 15).
     */
    public function snooze(int $minutes = 15): void
    {
        $this->update([
            'snoozed_until' => now()->addMinutes($minutes),
        ]);
    }
}
