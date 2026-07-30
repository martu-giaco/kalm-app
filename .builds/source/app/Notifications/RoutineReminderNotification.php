<?php

namespace App\Notifications;

use App\Models\Routine;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class RoutineReminderNotification extends Notification
{
    public function __construct(protected Routine $routine)
    {
    }

    public function via($notifiable): array
    {
        return [WebPushChannel::class];
    }

    public function toWebPush($notifiable, $notification): WebPushMessage
    {
        $typeName = $this->routine->type?->name ?? 'general';

        $completeUrl = URL::temporarySignedRoute(
            'routines.notify.complete',
            now()->addHours(6),
            ['routine' => $this->routine->routine_id]
        );

        $postponeUrl = URL::temporarySignedRoute(
            'routines.notify.postpone',
            now()->addHours(6),
            ['routine' => $this->routine->routine_id]
        );

        return (new WebPushMessage)
            ->title('¡Es hora de tu rutina!')
            ->icon('/images/icon-192.png')
            ->body("Es hora de tu rutina {$this->routine->name} de {$typeName}!")
            ->action('Completar', 'complete')
            ->action('Posponer 15 min', 'postpone')
            ->data([
                'routine_url' => route('routines.show', $this->routine->routine_id),
                'complete_url' => $completeUrl,
                'postpone_url' => $postponeUrl,
            ])
            ->options(['TTL' => 300]);
    }
}