<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Routine;
use App\Notifications\RoutineReminderNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        // Se ejecuta automáticamente cada minuto en tu servidor
        

$schedule->call(function () {
    // 1. Forzamos a Carbon a mirar la hora real configurada en tu app
    $now = Carbon::now(config('app.timezone')); 
    $currentTime = $now->format('H:i'); // Ejemplo: "22:24"

    // Escribimos en el log para saber qué hora está procesando Laravel internamente
    Log::info("Planificador de Rutinas ejecutado a las: {$currentTime}");

    // 2. Buscamos usando LIKE para evitar problemas si en la BD se guardó con o sin segundos
    $routines = Routine::where('is_reminder_enabled', true)
        ->where('reminder_time', 'LIKE', "{$currentTime}%")
        ->with('user')
        ->get();

    Log::info("Rutinas que coinciden con la hora actual: " . $routines->count());

    foreach ($routines as $routine) {
        $user = $routine->user;
        if ($user) {
            Log::info("Enviando notificación Push al usuario ID: {$user->id} para la rutina: {$routine->name}");
            
            // 3. Despacho de la notificación
            $user->notify(new \App\Notifications\RoutineReminderNotification($routine));
        } else {
            Log::warning("La rutina ID {$routine->routine_id} no tiene un usuario asociado.");
        }
    }
})->everyMinute();
        $schedule->command('routines:send-reminders')->everyMinute();
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
