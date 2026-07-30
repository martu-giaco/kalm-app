<x-layout :title="'Checkout - Kälm Premium'">

    <section class="flex flex-col items-center justify-center w-full min-h-screen pt-16 pb-20 px-4 content-wrapper transition-colors duration-300 rounded-t-2xl">

        <div class="w-full max-w-md text-center mb-10">
            <p class="text-xs font-semibold tracking-[0.2em] uppercase text-[#37A0AF] dark:text-[#5CC4D1] mb-3">
                Último paso
            </p>
            <h1 class="text-3xl md:text-4xl font-bold text-[#24373A] dark:text-[#EAF5F6]">Confirmar suscripción</h1>
            <p class="text-[#4B6467] dark:text-[#9FB8BB] mt-2">Estás a un paso de disfrutar Kälm Premium.</p>
        </div>

        <div class="w-full max-w-md">

            <!-- Resumen de la orden -->
            <div class="bg-white dark:bg-[#152528] rounded-2xl p-6 mb-5 border border-[#24373A]/10 dark:border-[#5CC4D1]/10 custom-card">
                <h2 class="text-lg font-bold text-[#24373A] dark:text-[#EAF5F6] mb-5">Resumen de tu compra</h2>

                <div class="space-y-3 pb-4 border-b border-[#24373A]/8 dark:border-[#5CC4D1]/10">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-[#4B6467] dark:text-[#9FB8BB]">Producto</span>
                        <span class="font-semibold text-[#24373A] dark:text-[#EAF5F6]">Kälm <span class="text-premium">Premium</span></span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-[#4B6467] dark:text-[#9FB8BB]">Período</span>
                        <span class="font-semibold text-[#24373A] dark:text-[#EAF5F6]">Mensual</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-[#4B6467] dark:text-[#9FB8BB]">Precio</span>
                        <span class="font-semibold text-[#24373A] dark:text-[#EAF5F6]">ARS $7,000</span>
                    </div>
                </div>

                <div class="flex items-center justify-between mt-4">
                    <span class="text-base font-bold text-[#24373A] dark:text-[#EAF5F6]">Total a pagar</span>
                    <span class="text-2xl font-extrabold text-gradient">ARS $7,000</span>
                </div>
            </div>

            <!-- Datos del usuario -->
            <div class="bg-white dark:bg-[#152528] rounded-2xl p-6 mb-5 border border-[#24373A]/10 dark:border-[#5CC4D1]/10 custom-card">
                <h3 class="text-sm font-semibold tracking-wide uppercase text-[#37A0AF] dark:text-[#5CC4D1] mb-4">
                    Datos de la suscripción
                </h3>
                <div class="space-y-3 text-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-[#4B6467] dark:text-[#9FB8BB]">Email</span>
                        <span class="font-medium text-[#24373A] dark:text-[#EAF5F6]">{{ auth()->user()->email }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-[#4B6467] dark:text-[#9FB8BB]">Usuario</span>
                        <span class="font-medium text-[#24373A] dark:text-[#EAF5F6]">{{ auth()->user()->name }}</span>
                    </div>
                </div>
            </div>

            <!-- Términos y condiciones -->
            <div class="flex items-start gap-3 mb-6 px-1">
                <input type="checkbox" id="terms"
                    class="w-5 h-5 mt-0.5 rounded border-2 border-[#24373A]/20 dark:border-[#5CC4D1]/30 text-[#37A0AF] focus:ring-[#37A0AF] cursor-pointer">
                <label for="terms" class="text-sm text-[#4B6467] dark:text-[#9FB8BB] select-none cursor-pointer leading-relaxed">
                    Acepto los <a href="{{ route('auth.terms.show') }}" class="text-[#37A0AF] dark:text-[#5CC4D1] font-semibold underline">Términos y Condiciones</a>
                    y autorizo el cobro de ARS $7,000 para la activación de Kälm <span class="text-premium">Premium</span>.
                </label>
            </div>

            <!-- Métodos de pago (Contenedor oficial de Mercado Pago) -->
            <div id="mp-payment-container" class="hidden mb-6 transition-opacity duration-300 opacity-0">
                <div class="bg-white dark:bg-[#152528] rounded-2xl p-6 border border-[#24373A]/10 dark:border-[#5CC4D1]/10 custom-card">
                   
                    <!-- Contenedor donde se renderiza el botón oficial -->
                    <div id="walletBrick_container"></div>
                </div>
            </div>

            <!-- Sellos de confianza -->
            <div class="flex flex-wrap items-center justify-center gap-x-5 gap-y-2 mb-6 text-xs font-medium text-[#4B6467] dark:text-[#9FB8BB]">
                <span class="flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-[#37A0AF] dark:text-[#5CC4D1]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    Pago seguro con Mercado Pago
                </span>
                <span class="flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-[#37A0AF] dark:text-[#5CC4D1]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    Cancelás cuando quieras
                </span>
            </div>

            <!-- Botones de navegación alternativos -->
            <div id="back-button-container">
                <a href="{{ route('subscription.show') }}"
                    class="w-full py-3 px-6 bg-[#F2F7F7] dark:bg-[#16282B] text-[#24373A] dark:text-[#EAF5F6] border border-[#24373A]/10 dark:border-[#5CC4D1]/10 rounded-xl font-semibold text-center hover:bg-[#E6EFEF] dark:hover:bg-[#1B2F32] transition block">
                    Volver atrás
                </a>
            </div>
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
        /* Brillo accesible para destacar "Premium": el resplandor es aditivo sobre
           un color sólido de alto contraste, y se aquieta con prefers-reduced-motion. */
        .text-premium {
            color: #1F5F68;
            font-weight: 800;
            text-shadow: 0 0 14px rgba(55, 160, 175, 0.45), 0 0 2px rgba(55, 160, 175, 0.6);
            animation: premium-glow 3.5s ease-in-out infinite;
        }

        @media (prefers-color-scheme: dark) {
            .text-premium {
                color: #8FE1E9;
                text-shadow: 0 0 16px rgba(92, 196, 209, 0.6), 0 0 3px rgba(92, 196, 209, 0.7);
            }
        }

        @keyframes premium-glow {

            0%,
            100% {
                text-shadow: 0 0 14px rgba(55, 160, 175, 0.45), 0 0 2px rgba(55, 160, 175, 0.6);
            }

            50% {
                text-shadow: 0 0 20px rgba(55, 160, 175, 0.65), 0 0 3px rgba(55, 160, 175, 0.7);
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .text-premium {
                animation: none;
            }
        }

        .content-wrapper {
            background: linear-gradient(to bottom, #fafcfc, #f0fafa);
        }

        @media (prefers-color-scheme: dark) {
            .content-wrapper {
                background: #0D1A1C;
            }
        }

        .custom-card {
            box-shadow: 0 2px 20px -8px rgba(36, 55, 58, 0.12);
        }

        @media (prefers-color-scheme: dark) {
            .custom-card {
                box-shadow: 0 2px 20px -8px rgba(0, 0, 0, 0.5);
            }
        }

        .text-gradient {
            background: linear-gradient(135deg, #37A0AF, #1F5F68);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        @media (prefers-color-scheme: dark) {
            .text-gradient {
                background: linear-gradient(135deg, #5CC4D1, #8FE1E9);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }
        }

        #terms {
            accent-color: #37A0AF;
        }

        @media (prefers-color-scheme: dark) {
            #terms {
                accent-color: #5CC4D1;
            }
        }

        @media (max-width: 768px) {
            h1 {
                font-size: 1.85rem;
            }

            h2 {
                font-size: 1.125rem;
            }
        }
    </style>

</x-layout>