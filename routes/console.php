<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

use App\Models\Routine;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Carbon;

// Tarea que se ejecuta de fondo automáticamente cada 60 segundos
Schedule::call(function () {
    // Obtenemos la hora actual en formato de base de datos (Ej: "22:18:00")
    $currentTime = Carbon::now()->format('H:i:00');

    // Buscamos todas las rutinas que tengan las notificaciones activadas para este minuto exacto
    $routines = Routine::where('is_reminder_enabled', true)
                        ->where('reminder_time', $currentTime)
                        ->get();

    foreach ($routines as $routine) {
        $user = $routine->user; // Asegurarte de tener la relación 'user' en tu modelo Routine
        
        if ($user) {
            // Despachamos la notificación WebPush real hacia tu Service Worker
            // (Reemplazá por el nombre real de tu clase de Notificación)
            $user->notify(new \App\Notifications\RoutineReminderNotification($routine));
        }
    }
})->everyMinute();

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
