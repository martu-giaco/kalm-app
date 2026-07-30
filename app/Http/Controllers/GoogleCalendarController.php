<?php

namespace App\Http\Controllers;

use App\Models\Routine;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Laravel\Socialite\Facades\Socialite;
use Google\Client;

class GoogleCalendarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Redirige a Google para autorizar acceso a Calendar (scope calendar.events)
     * y vincular la cuenta del usuario ya logueado.
     */
    public function connect()
{
    $client = new Client();
    $client->setScopes(['https://www.googleapis.com/auth/calendar.events']);
    $client->setAccessType('offline');
    $client->setPrompt('consent select_account');

    return redirect($client->createAuthUrl());
}

    /**
     * Callback de Google tras autorizar. Guarda los tokens en el usuario
     * autenticado y lo devuelve al flujo de creación de rutinas.
     */
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            /** @var User $user */
            $user = Auth::user();

            $user->update([
                'google_id' => $googleUser->getId(),
                'google_access_token' => $googleUser->token,
                'google_refresh_token' => $googleUser->refreshToken ?? $user->google_refresh_token,
            ]);

            return redirect()->route('routines.create')
                ->with('feedback', [
                    'message' => '¡Cuenta de Google Calendar vinculada con éxito! 🎉',
                    'type' => 'success',
                ]);

        } catch (\Exception $e) {
            Log::error('Error vinculando Google Calendar: ' . $e->getMessage());

            return redirect()->route('routines.create')
                ->with('feedback', [
                    'message' => 'No pudimos vincular tu Google Calendar. Intentá nuevamente.',
                    'type' => 'error',
                ]);
        }
    }

    /**
     * Crea o actualiza el evento de Google Calendar correspondiente a una rutina.
     *
     * Espera opcionalmente en el request:
     *  - start_datetime (ISO 8601 o cualquier formato que entienda Carbon::parse)
     *  - end_datetime
     *  - recurrence (ej: "RRULE:FREQ=DAILY" para que se repita todos los días)
     *
     * AJUSTAR: los nombres de columna de $routine usados abajo (name, description,
     * routine_id) están tomados de lo que aparece en el resto del código (routines.name,
     * routine_id como clave). Si tu modelo Routine tiene otros campos para el horario
     * (por ejemplo reminder_time, days_of_week), reemplazá guessRoutineStart() por esa
     * lógica real en vez de la que devuelve "mañana a las 9am" por defecto.
     */
    public function syncRoutine(Request $request, Routine $routine)
    {
        /** @var User $user */
        $user = Auth::user();

        if (!$user->google_refresh_token) {
            return back()->withErrors([
                'error' => 'Primero tenés que vincular tu cuenta de Google Calendar.',
            ]);
        }

        try {
            $accessToken = $this->getFreshAccessToken($user);

            $start = $request->filled('start_datetime')
                ? Carbon::parse($request->input('start_datetime'))
                : $this->guessRoutineStart($routine);

            $end = $request->filled('end_datetime')
                ? Carbon::parse($request->input('end_datetime'))
                : (clone $start)->addMinutes(30);

            $eventPayload = [
                'summary' => 'Rutina Kälm: ' . ($routine->name ?? 'Sin nombre'),
                'description' => $routine->description
                    ?? 'Recordatorio de tu rutina personalizada en Kälm.',
                'start' => [
                    'dateTime' => $start->toRfc3339String(),
                    'timeZone' => config('app.timezone', 'America/Argentina/Buenos_Aires'),
                ],
                'end' => [
                    'dateTime' => $end->toRfc3339String(),
                    'timeZone' => config('app.timezone', 'America/Argentina/Buenos_Aires'),
                ],
            ];

            if ($request->filled('recurrence')) {
                $eventPayload['recurrence'] = [$request->input('recurrence')];
            }

            $hasGoogleEventColumn = Schema::hasColumn('routines', 'google_event_id');
            $existingEventId = $hasGoogleEventColumn ? $routine->google_event_id : null;

            if ($existingEventId) {
                $response = Http::withToken($accessToken)
                    ->put(
                        "https://www.googleapis.com/calendar/v3/calendars/primary/events/{$existingEventId}",
                        $eventPayload
                    );
            } else {
                $response = Http::withToken($accessToken)
                    ->post(
                        'https://www.googleapis.com/calendar/v3/calendars/primary/events',
                        $eventPayload
                    );
            }

            if (!$response->successful()) {
                throw new \Exception('Google Calendar respondió con error: ' . $response->body());
            }

            $eventData = $response->json();

            if ($hasGoogleEventColumn && isset($eventData['id']) && !$existingEventId) {
                $routine->google_event_id = $eventData['id'];
                $routine->save();
            }

            return back()->with('feedback', [
                'message' => 'Rutina sincronizada con Google Calendar.',
                'type' => 'success',
            ]);

        } catch (\Exception $e) {
            Log::error('Error sincronizando rutina con Google Calendar: ' . $e->getMessage());

            return back()->withErrors([
                'error' => 'No se pudo sincronizar la rutina con Google Calendar: ' . $e->getMessage(),
            ]);
        }
    }

    /**
     * Desvincula Google Calendar del usuario (borra los tokens guardados).
     */
    public function disconnect()
    {
        /** @var User $user */
        $user = Auth::user();

        $user->update([
            'google_id' => null,
            'google_access_token' => null,
            'google_refresh_token' => null,
        ]);

        return back()->with('feedback', [
            'message' => 'Tu cuenta de Google Calendar fue desvinculada.',
            'type' => 'success',
        ]);
    }

    /**
     * Intercambia el refresh_token guardado por un access_token nuevo y válido.
     * Los access tokens de Google expiran en ~1 hora, por eso no se puede
     * reutilizar el que se guardó en el login.
     */
    private function getFreshAccessToken(User $user): string
    {
        $response = Http::asForm()->post('https://oauth2.googleapis.com/token', [
            'client_id' => config('services.google.client_id'),
            'client_secret' => config('services.google.client_secret'),
            'refresh_token' => $user->google_refresh_token,
            'grant_type' => 'refresh_token',
        ]);

        if (!$response->successful() || !isset($response->json()['access_token'])) {
            throw new \Exception('No se pudo renovar el token de Google: ' . $response->body());
        }

        return $response->json()['access_token'];
    }

    /**
     * Valor por defecto si no se manda start_datetime explícito: mañana a las 9am.
     * AJUSTAR según el campo real de horario de tu modelo Routine.
     */
    private function guessRoutineStart(Routine $routine): Carbon
    {
        return Carbon::tomorrow()->setTime(9, 0);
    }
}
