<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class PremiumSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'old_role',
        'status',
        'amount',
        'currency',
        'mp_payment_id',
        'mp_preference_id',
        'mp_merchant_order_id',
        'mp_status',
        'started_at',
        'last_payment_at',
        'current_period_start',
        'expires_at',
        'next_renewal_at',
        'grace_period_days',
        'overdue_since',
        'days_overdue',
        'is_auto_renew',
        'renewal_attempts',
        'cancelled_at',
        'cancellation_reason',
        'last_webhook_payload',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'started_at' => 'datetime',
        'last_payment_at' => 'datetime',
        'current_period_start' => 'datetime',
        'expires_at' => 'datetime',
        'next_renewal_at' => 'datetime',
        'overdue_since' => 'datetime',
        'cancelled_at' => 'datetime',
        'is_auto_renew' => 'boolean',
        'last_webhook_payload' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isActive(): bool
    {
        return $this->status === 'active' && $this->expires_at && $this->expires_at->isFuture();
    }

    public function isOverdue(): bool
    {
        return $this->status === 'overdue';
    }

    /**
     * Días que faltan para el vencimiento (negativo si ya venció).
     */
    public function daysUntilExpiration(): int
    {
        if (!$this->expires_at) {
            return 0;
        }

        return (int) now()->diffInDays($this->expires_at, false);
    }

    /**
     * Recalcula el estado según la fecha de expiración y el período de gracia.
     * No guarda el modelo; el llamador decide cuándo persistir.
     */
    public function refreshOverdueState(): void
    {
        if (!$this->expires_at || $this->status === 'cancelled') {
            return;
        }

        if ($this->expires_at->isFuture()) {
            $this->status = 'active';
            $this->overdue_since = null;
            $this->days_overdue = 0;
            return;
        }

        // Ya venció
        $this->overdue_since = $this->overdue_since ?: $this->expires_at;
        $daysPastDue = (int) $this->overdue_since->diffInDays(now());
        $this->days_overdue = $daysPastDue;

        $this->status = $daysPastDue > $this->grace_period_days ? 'expired' : 'overdue';
    }

    /**
     * Marca un nuevo ciclo mensual pagado (alta o renovación).
     */
    public function startNewCycle(array $mpData = []): void
    {
        $now = now();

        $this->fill(array_filter([
            'mp_payment_id' => $mpData['mp_payment_id'] ?? $this->mp_payment_id,
            'mp_preference_id' => $mpData['mp_preference_id'] ?? $this->mp_preference_id,
            'mp_merchant_order_id' => $mpData['mp_merchant_order_id'] ?? $this->mp_merchant_order_id,
            'mp_status' => $mpData['mp_status'] ?? 'approved',
        ], fn ($v) => $v !== null));

        $this->started_at = $this->started_at ?: $now;
        $this->current_period_start = $now;
        $this->last_payment_at = $now;
        $this->expires_at = $now->copy()->addMonthNoOverflow();
        $this->next_renewal_at = $this->expires_at;
        $this->status = 'active';
        $this->overdue_since = null;
        $this->days_overdue = 0;
        $this->renewal_attempts = 0;
    }
}