<x-layout :title="'Checkout - Kälm Premium'">

    <section class="flex flex-col items-center justify-center w-full pt-10 pb-20">
        <h1 class="text-4xl text-center font-bold text-[#306067] mb-2">Confirmar Suscripción</h1>
        <p class="text-[#37A0AF] mb-12 px-4">Estás a un paso de disfrutar Kälm Premium</p>

        <div class="w-full max-w-md px-4">
            <!-- Resumen de la orden -->
            <div class="bg-white rounded-2xl p-6 mb-6 shadow-md border-2 border-[#CCE2E5]">
                <h2 class="text-2xl font-bold text-[#306067] mb-4">Resumen de tu compra</h2>

                <!-- Detalles del plan -->
                <div class="space-y-4 pb-4 border-b-2 border-[#CCE2E5]">
                    <div class="flex items-center justify-between">
                        <span class="text-[#2A4043]">Producto</span>
                        <span class="font-bold text-[#306067]">Kälm Premium</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-[#2A4043]">Periodo</span>
                        <span class="font-bold text-[#306067]">Mensual</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-[#2A4043]">Precio</span>
                        <span class="text-3xl font-extrabold text-[#37A0AF]">ARS $7,000</span>
                    </div>
                </div>

                <!-- Total -->
                <div class="flex items-center justify-between mt-4">
                    <span class="text-lg font-bold text-[#306067]">Total a pagar</span>
                    <span class="text-3xl font-extrabold" style="background: linear-gradient(135deg, #37A0AF, #CCE2E5); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">ARS $7,000</span>
                </div>
            </div>

            <!-- Datos del usuario -->
            <div class="bg-white rounded-2xl p-6 mb-6 shadow-md border-2 border-[#CCE2E5]">
                <h3 class="text-lg font-bold text-[#306067] mb-4">Datos de la suscripción</h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-[#37A0AF] font-semibold mb-1">Email</p>
                        <p class="text-[#2A4043]">{{ auth()->user()->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-[#37A0AF] font-semibold mb-1">Usuario</p>
                        <p class="text-[#2A4043]">{{ auth()->user()->name }}</p>
                    </div>
                </div>
            </div>

            <!-- Métodos de pago -->
            <div class="bg-gradient-to-r from-[#E8F4F5] to-[#F0FAFB] rounded-2xl p-6 mb-6">
                <h3 class="text-lg font-bold text-[#306067] mb-4">Selecciona tu método de pago</h3>

                <div class="space-y-3">
                    <button disabled class="w-full py-3 px-4 bg-[#306067] text-white rounded-xl font-bold hover:bg-[#255055] transition disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="currentColor">
                            <path d="M202.87-111.87q-37.78 0-64.39-26.61t-26.61-64.39v-554.26q0-37.78 26.61-64.39t64.39-26.61h554.26q37.78 0 64.39 26.61t26.61 64.39v554.26q0 37.78-26.61 64.39t-64.39 26.61H202.87Zm36.54-91q0 10.77 7.24 18.01 7.23 7.23 18 7.23h109.92q10.77 0 18.01-7.23 7.24-7.24 7.24-18.01v-36.78q0-10.77-7.24-18.01-7.24-7.24-18.01-7.24H264.65q-10.77 0-18-7.24-7.23-7.24-7.23-18v-36.78q0-10.77 7.23-18.01 7.23-7.24 18-7.24h109.92q10.77 0 18.01 7.24 7.24 7.24 7.24 18.01v36.78q0 10.77-7.24 18.01-7.24 7.23-18.01 7.23H264.65q-10.77 0-18-7.23-7.23-7.24-7.23-18.01v36.78Zm345.48 0q0 10.77 7.24 18.01 7.23 7.23 18 7.23h109.92q10.77 0 18.01-7.23 7.24-7.24 7.24-18.01v-36.78q0-10.77-7.24-18.01-7.24-7.24-18.01-7.24H610.13q-10.77 0-18-7.24-7.23-7.24-7.23-18v-36.78q0-10.77 7.23-18.01 7.23-7.24 18-7.24h109.92q10.77 0 18.01 7.24 7.24 7.24 7.24 18.01v36.78q0 10.77-7.24 18.01-7.24 7.23-18.01 7.23H610.13q-10.77 0-18-7.23-7.23-7.24-7.23-18.01v36.78Z"/>
                        </svg>
                        Mercado Pago
                    </button>

                    <button disabled class="w-full py-3 px-4 border-2 border-[#37A0AF] text-[#37A0AF] rounded-xl font-bold hover:bg-[#37A0AF]/10 transition disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="currentColor">
                            <path d="M202.87-111.87q-37.78 0-64.39-26.61t-26.61-64.39v-554.26q0-37.78 26.61-64.39t64.39-26.61h554.26q37.78 0 64.39 26.61t26.61 64.39v554.26q0 37.78-26.61 64.39t-64.39 26.61H202.87Zm36.54-91q0 10.77 7.24 18.01 7.23 7.23 18 7.23h109.92q10.77 0 18.01-7.23 7.24-7.24 7.24-18.01v-36.78q0-10.77-7.24-18.01-7.24-7.24-18.01-7.24H264.65q-10.77 0-18-7.24-7.23-7.24-7.23-18v-36.78q0-10.77 7.23-18.01 7.23-7.24 18-7.24h109.92q10.77 0 18.01 7.24 7.24 7.24 7.24 18.01v36.78q0 10.77-7.24 18.01-7.24 7.23-18.01 7.23H264.65q-10.77 0-18-7.23-7.23-7.24-7.23-18.01v36.78Zm345.48 0q0 10.77 7.24 18.01 7.23 7.23 18 7.23h109.92q10.77 0 18.01-7.23 7.24-7.24 7.24-18.01v-36.78q0-10.77-7.24-18.01-7.24-7.24-18.01-7.24H610.13q-10.77 0-18-7.24-7.23-7.24-7.23-18v-36.78q0-10.77 7.23-18.01 7.23-7.24 18-7.24h109.92q10.77 0 18.01 7.24 7.24 7.24 7.24 18.01v36.78q0 10.77-7.24 18.01-7.24 7.23-18.01 7.23H610.13q-10.77 0-18-7.23-7.23-7.24-7.23-18.01v36.78Z"/>
                        </svg>
                        Tarjeta de crédito
                    </button>
                </div>
            </div>

            <!-- Términos y condiciones -->
            <div class="flex items-start gap-3 mb-6">
                <input type="checkbox" id="terms" class="w-5 h-5 mt-1 rounded border-2 border-[#CCE2E5]">
                <label for="terms" class="text-sm text-[#2A4043]">
                    Acepto los <a href="{{ route('auth.terms.show') }}" class="text-[#37A0AF] font-bold underline">términos y condiciones</a> y autorizo el cobro automático mensual de ARS $7,000 para la suscripción a Kälm Premium. Esta suscripción se puede cancelar en cualquier momento.
                </label>
            </div>

            <!-- Botones -->
            <div class="space-y-3">
                <a href="{{ route('subscription.show') }}"
                    class="w-full py-3 px-6 bg-[#CCE2E5] text-[#2A4043] rounded-xl font-bold text-center hover:bg-[#B5D5D9] transition block">
                    Volver atrás
                </a>
            </div>

            <p class="text-[#306067] text-xs text-center my-6">
                Transacción segura • Esta suscripción se puede cancelar sin penalizaciones
            </p>
        </div>
        </div>
    </section>

    <style>
        section {
            background: linear-gradient(to bottom, #fafcfc, #f0fafa);
        }

        .bg-white {
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }

        button[disabled] {
            opacity: 0.6;
            cursor: not-allowed;
        }

        @media (max-width: 768px) {
            h1 {
                font-size: 2rem;
            }
            h2 {
                font-size: 1.25rem;
            }
        }
    </style>

</x-layout>
