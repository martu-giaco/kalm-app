<?php

namespace App\Console\Commands;

use App\Models\PremiumSubscription;
use Illuminate\Console\Command;

class CheckExpiredSubscriptions extends Command
{
    protected $signature = 'subscriptions:check-expired';

    protected $description = 'Marca como vencidas las suscripciones premium que pasaron su fecha de renovación y degrada a los usuarios que superaron el período de gracia.';

    public function handle(): int
    {
        $subscriptions = PremiumSubscription::whereIn('status', ['active', 'overdue'])
            ->with('user')
            ->get();

        $downgraded = 0;
        $markedOverdue = 0;

        foreach ($subscriptions as $subscription) {
            $previousStatus = $subscription->status;

            $subscription->refreshOverdueState();

            if ($subscription->isDirty('status')) {
                if ($subscription->status === 'overdue') {
                    $markedOverdue++;
                }

                if ($subscription->status === 'expired' && $previousStatus !== 'expired') {
                    $user = $subscription->user;

                    if ($user && $user->role === 'premium') {
                        $user->role = $subscription->old_role ?: 'free';
                        $user->save();
                        $downgraded++;
                    }
                }
            }

            $subscription->save();
        }

        $this->info("Revisadas: {$subscriptions->count()} | Nuevas en atraso: {$markedOverdue} | Degradadas a free: {$downgraded}");

        return self::SUCCESS;
    }
}