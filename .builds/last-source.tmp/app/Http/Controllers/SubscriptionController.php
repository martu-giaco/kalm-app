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
    /**
     * Muestra la pantalla de suscripción/pago
     */
    public function show()
    {
        $user = Auth::user();

        return view('user.payment', compact('user'));
    }


    /**
     * Crea una preferencia utilizando el SDK oficial nuevo de Mercado Pago
     * y muestra el checkout embebido.
     */
    public function showCheckout()
    {
        try {

            /**
             * Configuración del SDK Mercado Pago
             */
            MercadoPagoConfig::setAccessToken(
                config('services.mercadopago.access_token') 
                ?? env('MP_ACCESS_TOKEN')
            );


            /**
             * Cliente de preferencias
             */
            $client = new PreferenceClient();


            /**
             * Creación de preferencia
             */
            $preference = $client->create([

                "items" => [
                    [
                        "title" => "Kälm Premium - Suscripción Mensual",
                        "quantity" => 1,
                        "unit_price" => 7000,
                        "currency_id" => "ARS"
                    ]
                ],


                /**
                 * Permite identificar qué usuario realizó el pago
                 */
                "external_reference" => Auth::id(),


                /**
                 * Información del comprador
                 */
                "payer" => [
                    "email" => Auth::user()->email
                ],


                /**
                 * URLs de retorno
                 */
                "back_urls" => [

                    "success" => route(
                        'subscription.payment.success'
                    ),

                    "failure" => route(
                        'subscription.payment.failure'
                    ),

                    "pending" => route(
                        'subscription.payment.pending'
                    ),

                ],


                /**
                 * Retorno automático solo cuando Mercado Pago
                 * puede verificar una URL válida.
                 */
                "auto_return" => "approved",

            ]);



            /**
             * Enviamos ID de preferencia a la vista
             */
            return view('subscription.checkout', [

                'preferenceId' => $preference->id

            ]);


        } catch (\Exception $e) {


            return back()->withErrors([

                'error' => 
                'No se pudo crear la preferencia de Mercado Pago: '
                . $e->getMessage()

            ]);

        }
    }





    /**
     * Muestra la pantalla de checkout/confirmación
     * utilizando la API REST de Mercado Pago.
     */
    public function checkout()
    {
        try {


            /**
             * Credenciales
             */
            $accessToken = 
                config('services.mercadopago.access_token')
                ?? env('MP_ACCESS_TOKEN');


            $publicKey =
                config('services.mercadopago.public_key')
                ?? env('MP_PUBLIC_KEY');



            /**
             * URL base de la aplicación
             */
            $appUrl = rtrim(

                env(
                    'APP_URL',
                    'http://127.0.0.1:8000'
                ),

                '/'

            );



            /**
             * Datos de la preferencia
             */
            $preferenceData = [


                "items" => [

                    [

                        "id" => "premium-monthly",

                        "title" =>
                            "Kälm Premium - Suscripción Mensual",

                        "quantity" => 1,

                        "unit_price" => 7000,

                        "currency_id" => "ARS"

                    ]

                ],



                /**
                 * Usuario que genera el pago
                 */
                "payer" => [

                    "email" => Auth::user()->email

                ],



                /**
                 * URLs de retorno
                 */
                "back_urls" => [

                    "success" =>
                        $appUrl . '/premium/success',


                    "failure" =>
                        $appUrl . '/premium/error',


                    "pending" =>
                        $appUrl . '/premium/error',

                ]

            ];




            /**
             * Mercado Pago solamente acepta auto_return
             * con dominios públicos HTTPS.
             */
            if (

                !str_contains($appUrl, '127.0.0.1')
                &&
                !str_contains($appUrl, 'localhost')
                &&
                str_starts_with($appUrl, 'https')

            ) {

                $preferenceData['auto_return'] = 'approved';

            }




            /**
             * Crear preferencia vía API
             */
            $response = Http::withToken($accessToken)

                ->withoutVerifying()

                ->post(

                    'https://api.mercadopago.com/checkout/preferences',

                    $preferenceData

                )

                ->json();




            /**
             * Verificación de respuesta
             */
            if (!isset($response['id'])) {


                throw new \Exception(

                    'Respuesta inválida de Mercado Pago: '
                    .
                    json_encode($response)

                );

            }




            /**
             * Vista checkout
             */
            return view('user.checkout', [

                'preferenceId' => $response['id']

            ]);



        } catch (\Exception $e) {


            return back()->withErrors([

                'error' =>

                'No se pudo inicializar el checkout de Mercado Pago: '
                .
                $e->getMessage()

            ]);

        }

    }

        /**
     * Redirige al usuario directamente a Mercado Pago
     * utilizando un link seguro de checkout.
     */
    public function mercadoPago()
    {

        try {


            /**
             * Token de acceso Mercado Pago
             */
            $accessToken =
                config('services.mercadopago.access_token')
                ??
                env('MP_ACCESS_TOKEN');



            /**
             * URL base del sistema
             */
            $appUrl = rtrim(

                env(
                    'APP_URL',
                    'http://127.0.0.1:8000'
                ),

                '/'

            );



            /**
             * Datos para crear preferencia
             */
            $preferenceData = [


                "items" => [

                    [

                        "title" =>
                            "Suscripción Kälm Premium mensual",

                        "quantity" => 1,

                        "unit_price" => 7000.00,

                        "currency_id" => "ARS"

                    ]

                ],



                /**
                 * Usuario comprador
                 */
                "payer" => [

                    "email" =>
                        Auth::user()->email

                ],



                /**
                 * Referencia del usuario
                 */
                "external_reference" => Auth::id(),



                /**
                 * URLs retorno
                 */
                "back_urls" => [

                    "success" =>
                        $appUrl . '/premium/success',


                    "failure" =>
                        $appUrl . '/premium/error',


                    "pending" =>
                        $appUrl . '/premium/error'

                ],



                /**
                 * Fuerza pago completo
                 */
                "binary_mode" => true

            ];





            /**
             * Auto retorno solamente en producción
             */
            if (

                !str_contains($appUrl, '127.0.0.1')
                &&
                !str_contains($appUrl, 'localhost')

            ) {


                $preferenceData['auto_return'] = 'approved';


            }





            /**
             * Creación de preferencia
             */
            $response = Http::withToken($accessToken)

                ->withoutVerifying()

                ->post(

                    'https://api.mercadopago.com/checkout/preferences',

                    $preferenceData

                )

                ->json();





            /**
             * Validar respuesta
             */
            if (!isset($response['init_point'])) {


                throw new \Exception(

                    'Mercado Pago no devolvió init_point: '
                    .
                    json_encode($response)

                );


            }




            /**
             * Redirección al checkout oficial
             */
            return redirect(

                $response['init_point']

            );




        } catch (\Exception $e) {


            return redirect()

                ->back()

                ->withErrors([

                    'error' =>

                    'Error generando link de pago: '
                    .
                    $e->getMessage()

                ]);

        }


    }







    /**
     * Procesa pagos directos con tarjeta.
     *
     * Requiere token generado previamente
     * mediante Mercado Pago JS SDK.
     */
    public function process(Request $request)
    {


        /**
         * Validación de datos enviados
         */
        $request->validate([


            'card_number' =>
                'required',


            'cardholder_name' =>
                'required',


            'expiration_month' =>
                'required|numeric',


            'expiration_year' =>
                'required|numeric',


            'security_code' =>
                'required',


            'email' =>
                'required|email'


        ]);





        try {


            $accessToken =

                config('services.mercadopago.access_token')
                ??
                env('MP_ACCESS_TOKEN');





            /**
             * Datos del pago
             */
            $paymentData = [


                "transaction_amount" => 7000.00,


                /**
                 * Token generado por Mercado Pago JS
                 */
                "token" =>

                    $request->card_token
                    ??
                    '',



                "description" =>

                    "Suscripción Kälm Premium mensual",



                "installments" => 1,



                /**
                 * Método de pago
                 */
                "payment_method_id" =>

                    $request->payment_method_id
                    ??
                    'visa',




                "payer" => [


                    "email" =>

                        $request->email,



                    "first_name" =>

                        $request->cardholder_name


                ]

            ];







            /**
             * Crear pago
             */
            $response = Http::withToken($accessToken)

                ->withoutVerifying()

                ->post(

                    'https://api.mercadopago.com/v1/payments',

                    $paymentData

                )

                ->json();







            /**
             * Validación de estado
             */
            if (

                !isset($response['status'])
                ||
                $response['status'] !== 'approved'

            ) {


                return back()->withErrors([


                    'error' =>

                    'Pago rechazado o fallido: '
                    .
                    json_encode($response)


                ]);


            }






            /**
             * Activación Premium
             */
            $this->assignPremiumStatus(

                Auth::id()

            );







            return redirect()

                ->route('user.paysuccess');






        } catch (\Exception $e) {


            return back()->withErrors([


                'error' =>

                'Pago con tarjeta fallido: '
                .
                $e->getMessage()


            ]);

        }


    }









    /**
     * Webhook Mercado Pago.
     *
     * Recibe notificaciones automáticas
     * cuando cambia el estado de un pago.
     */
    public function webhook(Request $request)
    {


        $data = $request->all();





        /**
         * Solo procesamos pagos
         */
        if (

            isset($data['type'])
            &&
            $data['type'] === 'payment'

        ) {


            $paymentId =

                $data['data']['id']
                ??
                null;





            if ($paymentId) {



                $accessToken =

                    config('services.mercadopago.access_token')
                    ??
                    env('MP_ACCESS_TOKEN');





                /**
                 * Consultar pago real en Mercado Pago
                 */
                $payment = Http::withToken($accessToken)

                    ->withoutVerifying()

                    ->get(

                        "https://api.mercadopago.com/v1/payments/{$paymentId}"

                    )

                    ->json();







                /**
                 * Si está aprobado activar Premium
                 */
                if (

                    isset($payment['status'])
                    &&
                    $payment['status'] === 'approved'

                ) {



                    /**
                     * Primero intenta por referencia
                     */
                    $userId =

                        $payment['external_reference']
                        ??
                        null;




                    if ($userId) {


                        $this->assignPremiumStatus(

                            $userId

                        );


                    } else {



                        /**
                         * Fallback por email
                         */
                        $email =

                            $payment['payer']['email']
                            ??
                            null;




                        if ($email) {


                            $user = User::where(

                                'email',

                                $email

                            )->first();



                            if ($user) {


                                $this->assignPremiumStatus(

                                    $user->id

                                );


                            }


                        }


                    }


                }


            }


        }






        return response()->json([

            'received' => true

        ]);

    }

        /**
     * Vista cuando el pago falla
     */
    public function failure(Request $request)
    {
        return view('subscription.failure');
    }





    /**
     * Vista cuando el pago queda pendiente
     */
    public function pending(Request $request)
    {
        return view('subscription.pending');
    }





    /**
     * Helper privado para asignar estado Premium al usuario.
     *
     * Centraliza la actualización del usuario evitando
     * repetir código en process() y webhook().
     */
    private function assignPremiumStatus($userId)
    {


        /**
         * Si no existe ID no hacemos nada
         */
        if (!$userId) {

            return;

        }





        /**
         * Buscar usuario
         */
        $user = User::find($userId);





        /**
         * Actualizar rol premium
         */
        if ($user) {


            /**
             * Mantiene la estructura original:
             * la base utiliza role = premium
             */
            $user->role = 'premium';


            $user->save();


        }


    }


}
