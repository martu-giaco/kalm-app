<x-layout :title="'Checkout - Kälm Premium'">

    <section class="flex flex-col items-center justify-center w-full min-h-screen pt-10 pb-20 content-wrapper">
        <h1 class="text-4xl text-center font-bold text-[#306067] mb-2">Confirmar Suscripción</h1>
        <p class="text-[#37A0AF] mb-12 px-4 text-center">Estás a un paso de disfrutar Kälm Premium</p>

        <div class="w-full max-w-md px-4">
            <!-- Resumen de la orden -->
            <div class="bg-white rounded-2xl p-6 mb-6 border-2 border-[#CCE2E5] custom-card">
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
                    <span class="text-3xl font-extrabold text-gradient">ARS $7,000</span>
                </div>
            </div>

            <!-- Datos del usuario -->
            <div class="bg-white rounded-2xl p-6 mb-6 border-2 border-[#CCE2E5] custom-card">
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

            <!-- Términos y condiciones -->
            <div class="flex items-start gap-3 mb-6">
                <input type="checkbox" id="terms" class="w-5 h-5 mt-1 rounded border-2 border-[#CCE2E5] cursor-pointer">
                <label for="terms" class="text-sm text-[#2A4043] select-none cursor-pointer">
                    Acepto los <a href="{{ route('auth.terms.show') }}" class="text-[#37A0AF] font-bold underline">términos y condiciones</a> y autorizo el cobro de ARS $7,000 para la activación de Kälm Premium.
                </label>
            </div>

            <!-- Métodos de pago (Contenedor oficial de Mercado Pago) -->
            <div id="mp-payment-container" class="hidden mb-6 transition-opacity duration-300 opacity-0">
                <h3 class="text-lg font-bold text-[#306067] mb-4">Finalizá tu pago seguro</h3>
                <!-- Contenedor donde se renderiza el botón oficial -->
                <div id="walletBrick_container"></div>
            </div>

            <!-- Botones de navegación alternativos -->
            <div id="back-button-container" class="space-y-3">
                <a href="{{ route('subscription.show') }}"
                    class="w-full py-3 px-6 bg-[#CCE2E5] text-[#2A4043] rounded-xl font-bold text-center hover:bg-[#B5D5D9] transition block">
                    Volver atrás
                </a>
            </div>

            <p class="text-[#306067] text-xs text-center my-6">
                Transacción de prueba (Sandbox) • Podés cancelar en cualquier momento
            </p>
        </div>
    </section>

    <!-- SDK de Mercado Pago v2 -->
    <script src="https://sdk.mercadopago.com/js/v2"></script>

    <script>
        // Inicializar Mercado Pago con la clave pública de pruebas
        const mp = new MercadoPago("{{ config('services.mercadopago.public_key') }}", {
            locale: 'es-AR'
        });
        const bricksBuilder = mp.bricks();
        
        const termsCheckbox = document.getElementById('terms');
        const mpContainer = document.getElementById('mp-payment-container');
        const preferenceId = "{{ $preferenceId }}"; 
        let walletBrickController = null;

        // Función para renderizar el botón oficial de Mercado Pago
        async function renderWalletBrick() {
            if (!preferenceId || walletBrickController) return;

            try {
                walletBrickController = await bricksBuilder.create('wallet', 'walletBrick_container', {
                    initialization: {
                        preferenceId: preferenceId,
                        redirectMode: 'self' // Redirige en la misma pestaña a la pasarela de MP
                    },
                    customization: {
                        texts: {
                            valueProp: 'smart_option', // Muestra "Pagar con Mercado Pago" optimizado
                        },
                    },
                });
            } catch (error) {
                console.error("Error al cargar el Wallet Brick de Mercado Pago:", error);
            }
        }

        // Monitorear el estado del checkbox de Términos y Condiciones
        termsCheckbox.addEventListener('change', async function() {
            if (this.checked) {
                // Renderizar el brick si aún no se hizo
                await renderWalletBrick();
                
                // Mostrar el contenedor animado
                mpContainer.classList.remove('hidden');
                setTimeout(() => {
                    mpContainer.classList.remove('opacity-0');
                    mpContainer.classList.add('opacity-100');
                }, 10);
            } else {
                // Ocultar el contenedor si desmarcan
                mpContainer.classList.remove('opacity-100');
                mpContainer.classList.add('opacity-0');
                setTimeout(() => {
                    mpContainer.classList.add('hidden');
                }, 300);
            }
        });
    </script>

    <style>
        .content-wrapper {
            background: linear-gradient(to bottom, #fafcfc, #f0fafa);
        }

        .custom-card {
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }

        .text-gradient {
            background: linear-gradient(135deg, #37A0AF, #306067);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        @media (max-width: 768px) {
            h1 { font-size: 2rem; }
            h2 { font-size: 1.25rem; }
        }
    </style>

</x-layout>