<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\User;

class SubscriptionController extends Controller
{
    /**
     * Muestra la pantalla de suscripción/pago
     */
    public function show()
    {
        $user = Auth::user();
        return view('user.payment', compact('user'));
    }

    /**
     * Redirige a MercadoPago con un link seguro de checkout
     */
    public function mercadoPago()
{
    $accessToken = env('MP_ACCESS_TOKEN');

    // URL base de tu app, definida en .env
    $appUrl = rtrim(env('APP_URL', 'http://127.0.0.1:8000'), '/');

    $preferenceData = [
        "items" => [
            [
                "title" => "Suscripción Kälm mensual",
                "quantity" => 1,
                "unit_price" => 500.00
            ]
        ],
        "payer" => [
            "email" => Auth::user()->email
        ],
        "back_urls" => [
            "success" => $appUrl . '/premium/success',
            "failure" => $appUrl . '/premium/error',
            "pending" => $appUrl . '/premium/error'
        ],
        "binary_mode" => true,
    ];

    // Solo agregamos auto_return si la URL no es localhost
    if (!str_contains($appUrl, '127.0.0.1') && !str_contains($appUrl, 'localhost')) {
        $preferenceData['auto_return'] = 'approved';
    }

    try {
        $response = Http::withToken($accessToken)
            ->withoutVerifying()
            ->post('https://api.mercadopago.com/checkout/preferences', $preferenceData)
            ->json();

        if (!isset($response['init_point'])) {
            // Mostramos error completo para debug
            dd($response);
        }

        return redirect($response['init_point']);
    } catch (\Exception $e) {
        return redirect()->back()->withErrors([
            'error' => 'Error generando link de pago: ' . $e->getMessage()
        ]);
    }
}


    /**
     * Procesa un pago con tarjeta directo (requiere token de MercadoPago JS SDK)
     */
    public function process(Request $request)
    {
        $accessToken = env('MP_ACCESS_TOKEN');

        $request->validate([
            'card_number' => 'required',
            'cardholder_name' => 'required',
            'expiration_month' => 'required|numeric',
            'expiration_year' => 'required|numeric',
            'security_code' => 'required',
            'email' => 'required|email'
        ]);

        $paymentData = [
            "transaction_amount" => 500.00,
            "token" => $request->card_token ?? '',
            "description" => "Suscripción Kälm mensual",
            "installments" => 1,
            "payment_method_id" => $request->payment_method_id ?? 'visa',
            "payer" => [
                "email" => $request->email,
                "first_name" => $request->cardholder_name
            ]
        ];

        try {
            $response = Http::withToken($accessToken)
                ->withoutVerifying()
                ->post('https://api.mercadopago.com/v1/payments', $paymentData)
                ->json();

            if (!isset($response['status']) || $response['status'] !== 'approved') {
                return redirect()->back()->withErrors(['error' => 'Pago rechazado o fallido: ' . json_encode($response)]);
            }

            // Actualizar usuario como premium
            $user = Auth::user();
            $user->premium = true;
            $user->save();

            return redirect()->route('user.paysuccess');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Pago con tarjeta fallido: ' . $e->getMessage()]);
        }
    }

    /**
     * Webhook de MercadoPago para confirmar pagos
     */
    public function webhook(Request $request)
    {
        $data = $request->all();

        if (isset($data['type']) && $data['type'] === 'payment') {
            $paymentId = $data['data']['id'] ?? null;

            if ($paymentId) {
                $accessToken = env('MP_ACCESS_TOKEN');
                $payment = Http::withToken($accessToken)
                    ->withoutVerifying()
                    ->get("https://api.mercadopago.com/v1/payments/{$paymentId}")
                    ->json();

                if (isset($payment['status']) && $payment['status'] === 'approved') {
                    $email = $payment['payer']['email'] ?? null;
                    $user = $email ? User::where('email', $email)->first() : null;

                    if ($user) {
                        $user->premium = true;
                        $user->save();
                    }
                }
            }
        }

        return response()->json(['received' => true]);
    }

    /**
     * Página de éxito después del pago
     */
    public function success()
    {
        $user = Auth::user();
        return view('subscription.success', compact('user'));
    }

    /**
     * Página de error después del pago
     */
    public function error()
    {
        return view('subscription.error');
    }
}
