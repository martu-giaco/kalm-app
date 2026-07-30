<?php

namespace App\Services;

use App\Models\Routine;
use App\Models\User;
use Google\Client;
use Google\Service\Calendar;
use Google\Service\Calendar\Event;
use Google\Service\Calendar\EventDateTime;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class GoogleCalendarService
{
    protected function getClient(User $user): ?Client
    {
        if (!$user->google_refresh_token) {
            return null;
        }

        $client = new Client();
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->fetchAccessTokenWithRefreshToken($user->google_refresh_token);

        return $client;
    }

    public function syncRoutineEvent(Routine $routine, User $user): ?string
    {
        $client = $this->getClient($user);
        if (!$client) {
            return null;
        }

        $service = new Calendar($client);

        // 1. Sanitizar la hora para prevenir duplicaciones de fecha ("Double date specification")
        $rawTime = $routine->reminder_time ?? '08:00:00';
        $cleanTime = date('H:i:s', strtotime($rawTime));

        // 2. Construir objetos Carbon limpios
        $startDateTime = Carbon::parse(now()->format('Y-m-d') . ' ' . $cleanTime);
        $endDateTime = (clone $startDateTime)->addMinutes(30);

        $timezone = config('app.timezone', 'America/Argentina/Buenos_Aires');
        $rrule = $this->buildRecurrenceRule($routine);

        $summary = 'Rutina: ' . ($routine->name ?? 'Sin nombre');
        $description = 'Recordatorio programado para tu rutina personal en Kälm.';

        try {
            if ($routine->google_event_id) {
                // Actualizar evento existente
                $event = $service->events->get('primary', $routine->google_event_id);
                
                $event->setSummary($summary);
                $event->setDescription($description);

                $start = new EventDateTime();
                $start->setDateTime($startDateTime->toRfc3339String());
                $start->setTimeZone($timezone);
                $event->setStart($start);

                $end = new EventDateTime();
                $end->setDateTime($endDateTime->toRfc3339String());
                $end->setTimeZone($timezone);
                $event->setEnd($end);

                $event->setRecurrence([$rrule]);

                $updatedEvent = $service->events->update('primary', $routine->google_event_id, $event);
                return $updatedEvent->getId();
            } else {
                // Crear nuevo evento
                $eventData = [
                    'summary' => $summary,
                    'description' => $description,
                    'start' => [
                        'dateTime' => $startDateTime->toRfc3339String(),
                        'timeZone' => $timezone,
                    ],
                    'end' => [
                        'dateTime' => $endDateTime->toRfc3339String(),
                        'timeZone' => $timezone,
                    ],
                    'recurrence' => [$rrule],
                ];

                $event = new Event($eventData);
                $newEvent = $service->events->insert('primary', $event);
                return $newEvent->getId();
            }
        } catch (\Exception $e) {
            Log::error("Google Calendar Sync Error: " . $e->getMessage());
            return null;
        }
    }

    public function deleteRoutineEvent(Routine $routine, User $user): bool
    {
        if (!$routine->google_event_id) {
            return true;
        }

        $client = $this->getClient($user);
        if (!$client) {
            return false;
        }

        try {
            $service = new Calendar($client);
            $service->events->delete('primary', $routine->google_event_id);
            return true;
        } catch (\Exception $e) {
            Log::error("Google Calendar Delete Error: " . $e->getMessage());
            return false;
        }
    }

    private function buildRecurrenceRule(Routine $routine): string
    {
        switch ($routine->reminder_frequency) {
            case 'weekly':
                $days = $routine->reminder_days ?? ['mon'];
                if (is_string($days)) {
                    $days = json_decode($days, true) ?? [$days];
                }
                $mappedDays = array_map(fn($d) => strtoupper(substr($d, 0, 2)), $days);
                return 'RRULE:FREQ=WEEKLY;BYDAY=' . implode(',', $mappedDays);

            case 'every_x_days':
                $interval = $routine->reminder_interval ?? 1;
                return 'RRULE:FREQ=DAILY;INTERVAL=' . $interval;

            case 'daily':
            default:
                return 'RRULE:FREQ=DAILY';
        }
    }
}