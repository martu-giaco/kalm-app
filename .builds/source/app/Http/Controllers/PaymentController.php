<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\MercadoPagoConfig;
use App\Models\User;

class SubscriptionController extends Controller
{
    public function __construct()
    {
        // Asegura que el usuario esté autenticado para interactuar con la suscripción
        $this->middleware('auth')->except(['webhook']);
    }

    /**
     * Muestra la pantalla de suscripción/pago
     */
    public function show()
    {
        $user = Auth::user();
        return view('user.payment', compact('user'));
    }

    /**
     * Procesa la simulación de pago con tarjeta (Antiguo processPayment)
     * Adaptado para usar el helper privado y redirección unificada.
     */
    public function processPayment(Request $request)
    {
        $request->validate([
            'titular' => 'required|string|max:255',
            'numero' => 'required|digits_between:15,19',
            'vto' => 'required|date|after:today',
            'cvc' => 'required|digits_between:3,4',
        ]);

        // Simulación de pago aprobado
        $pagoAprobado = true;

        if ($pagoAprobado) {
            $this->assignPremiumStatus(Auth::id());

            return redirect()->route('subscription.show')
                ->with('feedback.message', '¡Pago aprobado! Ahora eres premium.')
                ->with('feedback.type', 'success');
        }

        return redirect()->route('subscription.show')
            ->with('feedback.message', 'El pago fue rechazado.')
            ->with('feedback.type', 'error');
    }

    /**
     * Crea una preferencia utilizando el SDK oficial nuevo de Mercado Pago
     * y muestra el checkout embebido.
     */
    public function showCheckout()
    {
        try {
            MercadoPagoConfig::setAccessToken(
                config('services.mercadopago.access_token') ?? env('MP_ACCESS_TOKEN')
            );

            $client = new PreferenceClient();

            $preference = $client->create([
                "items" => [
                    [
                        "title" => "Kälm Premium - Suscripción Mensual",
                        "quantity" => 1,
                        "unit_price" => 7000,
                        "currency_id" => "ARS"
                    ]
                ],
                "external_reference" => (string) Auth::id(),
                "payer" => [
                    "email" => Auth::user()->email
                ],
                "back_urls" => [
                    "success" => route('subscription.payment.success'),
                    "failure" => route('subscription.payment.failure'),
                    "pending" => route('subscription.payment.pending'),
                ],
                "auto_return" => "approved",
            ]);

            return view('subscription.checkout', [
                'preferenceId' => $preference->id
            ]);

        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'No se pudo crear la preferencia de Mercado Pago: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Muestra la pantalla de checkout/confirmación utilizando la API REST de Mercado Pago.
     */
    public function checkout()
{
    try {
        $accessToken = config('services.mercadopago.access_token') ?? env('MP_ACCESS_TOKEN');
        $appUrl = rtrim(env('APP_URL', 'http://127.0.0.1:8000'), '/');

        $preferenceData = [
            "items" => [
                [
                    "id" => "premium-monthly",
                    "title" => "Kälm Premium - Suscripción Mensual",
                    "quantity" => 1,
                    "unit_price" => 7000,
                    "currency_id" => "ARS"
                ]
            ],
            "payer" => [
                "email" => Auth::user()->email
            ],
            "back_urls" => [
                "success" => $appUrl . '/premium/success',
                "failure" => $appUrl . '/premium/error',
                "pending" => $appUrl . '/premium/error',
            ],
            
            "auto_return" => "approved" 
        ];

        $response = Http::withToken($accessToken)
            ->withoutVerifying()
            ->post('https://api.mercadopago.com/checkout/preferences', $preferenceData)
            ->json();

        if (!isset($response['id'])) {
            throw new \Exception('Respuesta inválida de Mercado Pago: ' . json_encode($response));
        }

        return view('user.checkout', [
            'preferenceId' => $response['id']
        ]);

    } catch (\Exception $e) {
        return back()->withErrors([
            'error' => 'No se pudo inicializar el checkout de Mercado Pago: ' . $e->getMessage()
        ]);
    }
}

    /**
     * Redirige al usuario directamente a Mercado Pago utilizando un link seguro de checkout (Antiguo mercadoPago).
     */
    public function mercadoPago()
    {
        try {
            $accessToken = config('services.mercadopago.access_token') ?? env('MP_ACCESS_TOKEN');
            $appUrl = rtrim(env('APP_URL', 'http://127.0.0.1:8000'), '/');

            $preferenceData = [
                "items" => [
                    [
                        "title" => "Suscripción Kälm Premium mensual",
                        "quantity" => 1,
                        "unit_price" => 7000.00,
                        "currency_id" => "ARS"
                    ]
                ],
                "payer" => [
                    "email" => Auth::user()->email
                ],
                "external_reference" => (string) Auth::id(),
                "back_urls" => [
                    "success" => $appUrl . '/premium/success',
                    "failure" => $appUrl . '/premium/error',
                    "pending" => $appUrl . '/premium/error'
                ],
                "binary_mode" => true
            ];

            if (!str_contains($appUrl, '127.0.0.1') && !str_contains($appUrl, 'localhost')) {
                $preferenceData['auto_return'] = 'approved';
            }

            $response = Http::withToken($accessToken)
                ->withoutVerifying()
                ->post('https://api.mercadopago.com/checkout/preferences', $preferenceData)
                ->json();

            if (!isset($response['init_point'])) {
                throw new \Exception('Mercado Pago no devolvió init_point: ' . json_encode($response));
            }

            return redirect($response['init_point']);

        } catch (\Exception $e) {
            return redirect()->back()->withErrors([
                'error' => 'Error generando link de pago: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Procesa pagos directos con tarjeta desde API externa / SDK JS.
     */
    public function process(Request $request)
    {
        $request->validate([
            'card_number' => 'required',
            'cardholder_name' => 'required',
            'expiration_month' => 'required|numeric',
            'expiration_year' => 'required|numeric',
            'security_code' => 'required',
            'email' => 'required|email'
        ]);

        try {
            $accessToken = config('services.mercadopago.access_token') ?? env('MP_ACCESS_TOKEN');

            $paymentData = [
                "transaction_amount" => 7000.00,
                "token" => $request->card_token ?? '',
                "description" => "Suscripción Kälm Premium mensual",
                "installments" => 1,
                "payment_method_id" => $request->payment_method_id ?? 'visa',
                "payer" => [
                    "email" => $request->email,
                    "first_name" => $request->cardholder_name
                ]
            ];

            $response = Http::withToken($accessToken)
                ->withoutVerifying()
                ->post('https://api.mercadopago.com/v1/payments', $paymentData)
                ->json();

            if (!isset($response['status']) || $response['status'] !== 'approved') {
                return back()->withErrors([
                    'error' => 'Pago rechazado o fallido: ' . json_encode($response)
                ]);
            }

            $this->assignPremiumStatus(Auth::id());

            return redirect()->route('user.paysuccess');

        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'Pago con tarjeta fallido: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Webhook Mercado Pago para notificaciones automáticas asincrónicas.
     */
    public function webhook(Request $request)
    {
        $data = $request->all();

        if (isset($data['type']) && $data['type'] === 'payment') {
            $paymentId = $data['data']['id'] ?? null;

            if ($paymentId) {
                $accessToken = config('services.mercadopago.access_token') ?? env('MP_ACCESS_TOKEN');

                $payment = Http::withToken($accessToken)
                    ->withoutVerifying()
                    ->get("https://api.mercadopago.com/v1/payments/{$paymentId}")
                    ->json();

                if (isset($payment['status']) && $payment['status'] === 'approved') {
                    $userId = $payment['external_reference'] ?? null;

                    if ($userId) {
                        $this->assignPremiumStatus($userId);
                    } else {
                        $email = $payment['payer']['email'] ?? null;
                        if ($email) {
                            $user = User::where('email', $email)->first();
                            if ($user) {
                                $this->assignPremiumStatus($user->id);
                            }
                        }
                    }
                }
            }
        }

        return response()->json(['received' => true]);
    }

    /**
     * Vista cuando el pago es exitoso (Retorno síncrono del cliente)
     */
    /**
 * Vista cuando el pago es exitoso (Retorno síncrono del cliente)
 */
public function success(Request $request)
{
    // Actualizamos aquí al volver para asegurar inmediatez visual en el front
    if (Auth::check()) {
        $this->assignPremiumStatus(Auth::id()); //
    }

    // Redirige directamente a la ruta 'profile.show' definida en tus rutas
    return redirect()->route('profile.show')
        ->with('feedback.message', '¡Pago aprobado! Ahora eres premium.')
        ->with('feedback.type', 'success');
}

    /**
     * Vista cuando el pago falla
     */
    public function failure(Request $request)
    {
        return view('subscription.failure')
            ->with('feedback.message', 'El pago fue rechazado.')
            ->with('feedback.type', 'error');
    }

    /**
     * Vista cuando el pago queda pendiente
     */
    public function pending(Request $request)
    {
        return view('subscription.pending')
            ->with('feedback.message', 'El pago está pendiente.')
            ->with('feedback.type', 'info');
    }

    /**
     * Helper privado para asignar estado Premium al usuario.
     */
    private function assignPremiumStatus($userId)
    {
        if (!$userId) {
            return;
        }

        $user = User::find($userId);

        if ($user) {
            $user->role = 'premium';
            $user->save();
        }
    }
}
