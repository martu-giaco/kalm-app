<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Preference;
use MercadoPago\Item;
use Illuminate\Models\User;


class PaymentController extends Controller
{
    public function __construct()
    {
        // Asegura que el usuario esté autenticado
        $this->middleware('auth');
    }

    /**
     * Mostrar la página de pago
     */
    public function show()
    {
        return view('user.payment'); // Blade con formulario o botones de pago
    }

    /**
     * Procesar pago con tarjeta simulada
     */
    public function processPayment(Request $request)
    {
        // Validación de datos de tarjeta
        $request->validate([
            'titular' => 'required|string|max:255',
            'numero' => 'required|digits_between:15,19',
            'vto' => 'required|date|after:today',
            'cvc' => 'required|digits_between:3,4',
        ]);

        // Simulación de pago aprobado (aquí iría integración real con Stripe u otra pasarela)
        $pagoAprobado = true;

        if ($pagoAprobado) {
            $user = Auth::user();
            $user->role = 'premium';
            $user->save();

            return redirect()->route('subscription.show')
                ->with('feedback.message', '¡Pago aprobado! Ahora eres premium.')
                ->with('feedback.type', 'success');
        }

        return redirect()->route('subscription.show')
            ->with('feedback.message', 'El pago fue rechazado.')
            ->with('feedback.type', 'error');
    }

    /**
     * Redirigir a MercadoPago Checkout
     */
    public function mercadoPago()
    {
        // Configurar el SDK con tu Access Token
        MercadoPagoConfig::setAccessToken(env('MP_ACCESS_TOKEN'));

        $preference = new Preference();

        // Crear el ítem a cobrar
        $item = new Item();
        $item->title = "Suscripción Premium";
        $item->quantity = 1;
        $item->unit_price = 5000; // Precio en la moneda configurada
        $preference->items = [$item];

        // Configurar URLs de retorno
        $preference->back_urls = [
            "success" => route('subscription.success'),
            "failure" => route('subscription.failure'),
            "pending" => route('subscription.pending'),
        ];

        // Auto-return al sitio si el pago es aprobado
        $preference->auto_return = "approved";

        // Guardar preferencia
        $preference->save();

        // Redirigir al usuario al checkout de MercadoPago
        return redirect($preference->init_point);
    }

    /**
     * Retorno de pago aprobado
     */
    public function success()
    {
        $user = Auth::user();
        $user->role = 'premium';
        $user->save();

        return view('user.subscription-success')
            ->with('feedback.message', '¡Pago aprobado! Ahora eres premium.')
            ->with('feedback.type', 'success');
    }

    /**
     * Retorno de pago fallido
     */
    public function failure()
    {
        return view('user.subscription-failure')
            ->with('feedback.message', 'El pago fue rechazado.')
            ->with('feedback.type', 'error');
    }

    /**
     * Retorno de pago pendiente
     */
    public function pending()
    {
        return view('user.subscription-pending')
            ->with('feedback.message', 'El pago está pendiente.')
            ->with('feedback.type', 'info');
    }
}
