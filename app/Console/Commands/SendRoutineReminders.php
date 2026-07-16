<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Routine;
use Carbon\Carbon;

class SendRoutineReminders extends Command
{
    protected $signature = 'routines:send-reminders';
    protected $description = 'Envía notificaciones push a los usuarios que deben realizar su rutina ahora';

    public function handle()
    {
        $now = Carbon::now();
        $currentTime = $now->format('H:i'); // Ej: "08:30"
        $currentDayName = strtolower($now->format('D')); // Ej: "mon", "tue"...

        // 1. Buscar rutinas activas cuya hora coincida con el minuto actual
        $routines = Routine::where('is_reminder_enabled', true)
            ->where('reminder_time', $currentTime)
            ->with('user')
            ->get();

        foreach ($routines as $routine) {
            if ($this->shouldSendToday($routine, $now, $currentDayName)) {
                $this->dispatchPushNotification($routine);
            }
        }
    }

    private function shouldSendToday($routine, $now, $currentDayName)
    {
        // Validar lógica según frecuencia (diario, semanal, o x días)
        if ($routine->reminder_frequency === 'daily') {
            return true;
        }

        if ($routine->reminder_frequency === 'weekly') {
            $days = json_decode($routine->reminder_days ?? '[]', true);
            return in_array($currentDayName, $days);
        }

        if ($routine->reminder_frequency === 'every_x_days') {
            // Validar la diferencia de días usando la última fecha de ejecución guardada
            // o calculando los días transcurridos desde que se creó la rutina
            $createdAt = Carbon::parse($routine->created_at)->startOfDay();
            $diffInDays = $now->startOfDay()->diffInDays($createdAt);
            $interval = $routine->reminder_interval ?? 1;

            return ($diffInDays % $interval) === 0;
        }

        return false;
    }

    private function dispatchPushNotification($routine)
    {
        $user = $routine->user;
        if (!$user) return;

        // Aquí construyes el payload dinámico redirigiendo a su vista de detalle de rutina
        $url = route('routines.show', $routine->routine_id); // Genera: /routines/id

        // Enviar vía tu servicio Push elegido (FCM o paquete WebPush)
        // Ejemplo conceptual:
        // $user->notify(new RoutineReminderNotification($routine, $url));
    }
}
