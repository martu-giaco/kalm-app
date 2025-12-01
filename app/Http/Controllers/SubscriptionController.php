<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    /**
     * Muestra la página de opciones de suscripción.
     */
    public function show()
    {
        // Se podría pasar información sobre los planes de suscripción, precios, etc.
        // Por ahora, solo devolvemos la vista.

        return view('subscription.show');
    }

    /**
     * Procesa la solicitud de actualización de suscripción (ejemplo).
     */
    public function process(Request $request)
    {
        // Esta función manejaría la lógica de pago/actualización.
        // Por ejemplo, si el pago es exitoso, actualizaría el rol del usuario.

        $user = Auth::user();

        // Lógica de validación de pago aquí...

        // Si el pago es exitoso:
        // $user->role = 'premium';
        // $user->save();

        // return redirect()->route('home')->with('status', '¡Felicidades! Ahora eres Premium.');

        return back(); // Placeholder
    }
}
