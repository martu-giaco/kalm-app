<?php

namespace App\Services;

use App\Models\Routine;
use App\Notifications\RoutineReminderNotification;

class PushNotificationService
{
    public function sendRoutineReminder(Routine $routine): void
    {
        $user = $routine->user;

        if ($user && $user->pushSubscriptions()->exists()) {
            $user->notify(new RoutineReminderNotification($routine));
        }

        $routine->update(['last_notified_at' => now()]);
    }
}