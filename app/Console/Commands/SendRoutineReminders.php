<?php

namespace App\Console\Commands;

use App\Models\Routine;
use App\Services\PushNotificationService;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class SendRoutineReminders extends Command
{
    protected $signature = 'routines:send-reminders';
    protected $description = 'Revisa las rutinas con recordatorio activo y envía notificaciones push cuando corresponda';

    public function handle(PushNotificationService $pushService): int
    {
        $now = Carbon::now();

        Routine::where('is_reminder_enabled', true)
            ->whereNotNull('reminder_time')
            ->chunk(100, function ($routines) use ($now, $pushService) {
                foreach ($routines as $routine) {
                    if ($routine->isDueNow($now)) {
                        $pushService->sendRoutineReminder($routine);
                    }
                }
            });

        return self::SUCCESS;
    }
}