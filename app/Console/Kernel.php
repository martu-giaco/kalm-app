<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Routine;
use App\Notifications\RoutineReminderNotification;
use Carbon\Carbon;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        // Se ejecuta automáticamente cada minuto en tu servidor
        $schedule->call(function () {
            $now = Carbon::now();
            $currentTime = $now->format('H:i'); // Ej: "18:30"
            $currentDayName = strtolower($now->format('D')); // Ej: "mon", "tue", "thu"...

            // 1. Traer las rutinas que tengan los recordatorios encendidos
            $routines = Routine::where('is_reminder_enabled', true)
                ->with('user')
                ->get();

            foreach ($routines as $routine) {
                $user = $routine->user;
                if (!$user) continue;

                // 2. Comprobar si la hora coincide (considerando el casteo a datetime de tu modelo Routine)
                $routineTime = $routine->reminder_time ? $routine->reminder_time->format('H:i') : null;
                if ($routineTime !== $currentTime) {
                    continue; 
                }

                $shouldSend = false;

                // 3. Evaluar la frecuencia de la rutina
                if ($routine->reminder_frequency === 'daily') {
                    $shouldSend = true;
                } elseif ($routine->reminder_frequency === 'weekly') {
                    $days = json_decode($routine->reminder_days ?? '[]', true);
                    if (in_array($currentDayName, $days)) {
                        $shouldSend = true;
                    }
                } elseif ($routine->reminder_frequency === 'every_x_days') {
                    $createdAt = Carbon::parse($routine->created_at)->startOfDay();
                    $diffInDays = $now->startOfDay()->diffInDays($createdAt);
                    $interval = $routine->reminder_interval ?? 1;
                    
                    if (($diffInDays % $interval) === 0) {
                        $shouldSend = true;
                    }
                }

                // 4. Enviar notificación push
                if ($shouldSend) {
                    $user->notify(new RoutineReminderNotification($routine));
                }
            }
        })->everyMinute();
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}