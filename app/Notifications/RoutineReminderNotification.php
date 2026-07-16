<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;
use App\Models\Routine;

class RoutineReminderNotification extends Notification
{
    use Queueable;

    protected $routine;

    public function __construct(Routine $routine)
    {
        $this->routine = $routine;
    }

    public function via($notifiable)
    {
        // Obliga a Laravel a usar el canal de WebPush
        return [WebPushChannel::class];
    }

    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->title('⏰ ¡Hora de tu rutina!')
            ->body("Es momento de realizar tu rutina: {$this->routine->name}")
            ->icon('/images/logo-icon.png')  // Cambia por la ruta real de tu logo
            ->badge('/images/badge-icon.png') // Cambia por tu icono de barra de estado
            ->data([
                // Mapeamos la URL dinámica usando el 'routine_id' que tiene tu modelo
                'url' => route('routines.show', $this->routine->routine_id)
            ])
            ->options(['TTL' => 1000]);
    }
}