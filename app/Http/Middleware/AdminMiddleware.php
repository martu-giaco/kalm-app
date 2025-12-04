<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Maneja una solicitud entrante.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verifica si hay un usuario logueado
        if (!Auth::check()) {
            return redirect()->route('auth.login')
                ->with('feedback.message', 'Debes iniciar sesión para acceder a esta página.');
        }

        // Verifica si el rol es admin
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('home')
                ->with('feedback.message', 'No tiene permiso para acceder a esta página.');
        }

        return $next($request);
    }
}
