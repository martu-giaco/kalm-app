<?php

namespace App\Http\Controllers;

use App\Models\PremiumSubscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SubscriptionController extends Controller
{
    public function __construct()
    {
        // El webhook lo llama Mercado Pago (sin sesión), todo lo demás requiere usuario logueado.
        $this->middleware('auth')->except(['webhook']);
    }

    /**
     * Muestra la pantalla de suscripción/pago.
     */
    public function show()
    {
        $user = Auth::user();
        $subscription = $user->premiumSubscription;

        return view('user.payment', compact('user', 'subscription'));
    }

    /**
     * Crea la preferencia de pago (Checkout Pro) y muestra el checkout embebido
     * con el Wallet Brick.
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
                        "currency_id" => "ARS",
                    ],
                ],

                // Nos permite identificar al usuario tanto en el retorno síncrono
                // (success) como en el webhook asincrónico.
                "external_reference" => (string) Auth::id(),

                "payer" => [
                    "email" => Auth::user()->email,
                ],

                "back_urls" => [
                    "success" => $appUrl . '/premium/success',
                    "failure" => $appUrl . '/premium/error',
                    "pending" => $appUrl . '/premium/error',
                ],

                // A dónde Mercado Pago nos notifica el cambio de estado del pago,
                // independientemente de si el usuario vuelve o no al navegador.
                "notification_url" => $appUrl . '/premium/webhook',
            ];

            // Mercado Pago solo permite auto_return con una URL pública https válida.
            if (
                !str_contains($appUrl, '127.0.0.1') &&
                !str_contains($appUrl, 'localhost') &&
                str_starts_with($appUrl, 'https')
            ) {
                $preferenceData['auto_return'] = 'approved';
            }

            $response = Http::withToken($accessToken)
                ->withoutVerifying()
                ->post('https://api.mercadopago.com/checkout/preferences', $preferenceData)
                ->json();

            if (!isset($response['id'])) {
                throw new \Exception('Respuesta inválida de Mercado Pago: ' . json_encode($response));
            }

            return view('user.checkout', [
                'preferenceId' => $response['id'],
            ]);

        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'No se pudo inicializar el checkout de Mercado Pago: ' . $e->getMessage(),
            ]);
        }
    }

    /**
     * Redirige al usuario directamente a Mercado Pago (link de pago, sin Bricks).
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
                        "currency_id" => "ARS",
                    ],
                ],
                "payer" => [
                    "email" => Auth::user()->email,
                ],
                "external_reference" => (string) Auth::id(),
                "back_urls" => [
                    "success" => $appUrl . '/premium/success',
                    "failure" => $appUrl . '/premium/error',
                    "pending" => $appUrl . '/premium/error',
                ],
                "notification_url" => $appUrl . '/premium/webhook',
                "binary_mode" => true,
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
                'error' => 'Error generando link de pago: ' . $e->getMessage(),
            ]);
        }
    }

    /**
     * Pago directo con tarjeta tokenizada (Card Payment Brick / SDK JS).
     */
    public function process(Request $request)
    {
        $request->validate([
            'card_token' => 'required',
            'cardholder_name' => 'required',
            'email' => 'required|email',
        ]);

        try {
            $accessToken = config('services.mercadopago.access_token') ?? env('MP_ACCESS_TOKEN');

            $paymentData = [
                "transaction_amount" => 7000.00,
                "token" => $request->card_token,
                "description" => "Suscripción Kälm Premium mensual",
                "installments" => 1,
                "payment_method_id" => $request->payment_method_id ?? 'visa',
                "external_reference" => (string) Auth::id(),
                "payer" => [
                    "email" => $request->email,
                    "first_name" => $request->cardholder_name,
                ],
            ];

            $response = Http::withToken($accessToken)
                ->withoutVerifying()
                ->post('https://api.mercadopago.com/v1/payments', $paymentData)
                ->json();

            if (!isset($response['status']) || $response['status'] !== 'approved') {
                return back()->withErrors([
                    'error' => 'Pago rechazado o fallido: ' . json_encode($response),
                ]);
            }

            $this->activateOrRenewSubscription(Auth::user(), [
                'mp_payment_id' => $response['id'] ?? null,
                'mp_status' => 'approved',
            ]);

            return redirect()->route('user.subscription-success');

        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'Pago con tarjeta fallido: ' . $e->getMessage(),
            ]);
        }
    }

    /**
     * Webhook de Mercado Pago. Es la fuente de verdad: acá es donde realmente
     * activamos/renovamos la suscripción, sin depender de que el navegador
     * del usuario vuelva a la app.
     */
    public function webhook(Request $request)
    {
        $data = $request->all();

        if (($data['type'] ?? null) === 'payment') {
            $paymentId = $data['data']['id'] ?? null;

            if ($paymentId) {
                $payment = $this->fetchMercadoPagoPayment($paymentId);

                if ($payment && ($payment['status'] ?? null) === 'approved') {
                    $user = $this->resolveUserFromPayment($payment);

                    if ($user) {
                        $this->activateOrRenewSubscription($user, [
                            'mp_payment_id' => $payment['id'] ?? $paymentId,
                            'mp_preference_id' => $payment['preference_id'] ?? null,
                            'mp_merchant_order_id' => $payment['order']['id'] ?? null,
                            'mp_status' => 'approved',
                            'raw_payload' => $payment,
                        ]);
                    } else {
                        Log::warning('Webhook MP: pago aprobado pero no se pudo resolver el usuario', [
                            'payment_id' => $paymentId,
                        ]);
                    }
                }
            }
        }

        return response()->json(['received' => true]);
    }

    /**
     * Retorno síncrono del navegador tras el pago. Mercado Pago manda por
     * query string el payment_id/collection_id y el status, pero eso puede
     * ser manipulado por el cliente: por eso SIEMPRE lo re-validamos contra
     * la API de Mercado Pago antes de otorgar premium.
     */
    public function success(Request $request)
    {
        $paymentId = $request->query('payment_id') ?? $request->query('collection_id');

        if (!$paymentId) {
            return redirect()->route('subscription.failure')
                ->with('feedback.message', 'No pudimos confirmar tu pago. Si ya pagaste, esperá unos segundos y revisá tu perfil.')
                ->with('feedback.type', 'error');
        }

        $payment = $this->fetchMercadoPagoPayment($paymentId);

        if (!$payment || ($payment['status'] ?? null) !== 'approved') {
            return redirect()->route('subscription.failure')
                ->with('feedback.message', 'El pago no figura como aprobado.')
                ->with('feedback.type', 'error');
        }

        // Si Mercado Pago nos dio external_reference, confirmamos que el pago
        // corresponde al usuario logueado (evita que alguien reutilice una
        // vieja URL de retorno de otro usuario).
        $externalReference = $payment['external_reference'] ?? null;
        if ($externalReference && (string) $externalReference !== (string) Auth::id()) {
            abort(403, 'Este pago no corresponde a tu usuario.');
        }

        $subscription = $this->activateOrRenewSubscription(Auth::user(), [
            'mp_payment_id' => $payment['id'] ?? $paymentId,
            'mp_preference_id' => $payment['preference_id'] ?? null,
            'mp_status' => 'approved',
            'raw_payload' => $payment,
        ]);

        $user = User::find(Auth::id());

        return view('user.subscription-success', [
            'user' => $user,
            'subscription' => $subscription,
        ]);
    }

    /**
     * Vista cuando el pago falla.
     */
    public function failure(Request $request)
    {
        return view('subscription.failure')
            ->with('feedback.message', 'El pago fue rechazado.')
            ->with('feedback.type', 'error');
    }

    /**
     * Vista cuando el pago queda pendiente.
     */
    public function pending(Request $request)
    {
        return view('subscription.pending')
            ->with('feedback.message', 'El pago está pendiente.')
            ->with('feedback.type', 'info');
    }

    /**
     * Consulta un pago puntual contra la API de Mercado Pago.
     */
    private function fetchMercadoPagoPayment($paymentId): ?array
    {
        $accessToken = config('services.mercadopago.access_token') ?? env('MP_ACCESS_TOKEN');

        $response = Http::withToken($accessToken)
            ->withoutVerifying()
            ->get("https://api.mercadopago.com/v1/payments/{$paymentId}");

        if (!$response->successful()) {
            Log::warning('No se pudo consultar el pago en Mercado Pago', [
                'payment_id' => $paymentId,
                'status' => $response->status(),
            ]);
            return null;
        }

        return $response->json();
    }

    /**
     * Encuentra al usuario dueño de un pago: primero por external_reference,
     * y si no vino, por el email del pagador como respaldo.
     */
    private function resolveUserFromPayment(array $payment): ?User
    {
        $userId = $payment['external_reference'] ?? null;

        if ($userId) {
            $user = User::find($userId);
            if ($user) {
                return $user;
            }
        }

        $email = $payment['payer']['email'] ?? null;
        if ($email) {
            return User::where('email', $email)->first();
        }

        return null;
    }

    /**
     * Activa o renueva el ciclo mensual premium del usuario y deja el
     * registro correspondiente en premium_subscriptions.
     */
    private function activateOrRenewSubscription(User $user, array $mpData = []): PremiumSubscription
    {
        $subscription = $user->premiumSubscriptions()
            ->whereIn('status', ['active', 'overdue'])
            ->latest()
            ->first();

        if (!$subscription) {
            $subscription = new PremiumSubscription();
            $subscription->user_id = $user->id;
            // Guardamos el rol que tenía ANTES de pasar a premium (normalmente 'free').
            $subscription->old_role = $user->role !== 'premium' ? ($user->role ?? 'free') : 'free';
            $subscription->amount = 7000.00;
            $subscription->currency = 'ARS';
            $subscription->grace_period_days = 3;
            $subscription->is_auto_renew = true;
        }

        if (isset($mpData['raw_payload'])) {
            $subscription->last_webhook_payload = $mpData['raw_payload'];
        }

        $subscription->startNewCycle($mpData);
        $subscription->save();

        if ($user->role !== 'premium') {
            $user->role = 'premium';
            $user->save();
        }

        return $subscription;
    }
}
