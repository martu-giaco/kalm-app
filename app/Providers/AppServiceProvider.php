<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Routine;
use Illuminate\Support\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        putenv('OPENSSL_CONF=C:/laragon/bin/apache/apache-2.4.54-win64-VS16/conf/openssl.cnf');

        App::setLocale(config('app.locale', 'es'));

        // Comparte las rutinas activas del usuario solo con la vista del layout principal
        View::composer('layouts.app', function ($view) {
            if (Auth::check()) {
                $reminders = Routine::where('user_id', Auth::id())
                    ->where('is_reminder_enabled', true)
                    ->whereNotNull('reminder_time')
                    ->get(['routine_id', 'name', 'reminder_time']);

                // Formateamos de forma segura pasando por Carbon
                $reminders->transform(function($routine) {
                    if ($routine->reminder_time) {
                        // Forzamos la creación del objeto Carbon sin importar cómo venga de la BD
                        $routine->formatted_time = Carbon::parse($routine->reminder_time)->format('H:i');
                    }
                    return $routine;
                });

                $view->with('userReminders', $reminders);
            } else {
                $view->with('userReminders', collect());
            }
        });
    }
}
