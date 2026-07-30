<x-layout>
    @slot('title', '¡Bienvenido a Kälm Premium!')

    <div class="min-h-[85vh] flex items-center justify-center px-4 py-12 bg-white dark:bg-[#0D1A1C] transition-colors duration-300 rounded-t-2xl">
        <div class="w-full max-w-md mx-auto text-center flex flex-col items-center">

            <!-- Icono de Éxito / Corona Premium -->
            <div class="relative mb-6">
                <div class="w-24 h-24 rounded-full bg-[#CCE2E5] dark:bg-[#16282B] flex items-center justify-center animate-bounce">
                    <svg xmlns="http://www.w3.org/2000/svg" height="48px" viewBox="0 -960 960 960" width="48px" class="fill-[#306067] dark:fill-[#5CC4D1]">
                        <path d="M205-400h550q14 0 19 12t-5 22L536-136q-23 23-56 23t-56-23L191-366q-10-10-5-22t19-12Zm-22-113 113-138q11-14 27.5-21.5T358-680h244q18 0 34.5 7.5T664-651l113 138q8 10 3 21.5T762-480H198q-13 0-18-11.5t3-21.5Z"/>
                    </svg>
                </div>
                <div class="absolute p-1 text-white bg-green-500 rounded-full shadow-md -top-1 -right-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
            </div>

            <!-- Encabezado de Suscripción Exitosa -->
            <span class="inline-block rounded-full px-4 py-1.5 mb-3 text-xs font-bold uppercase tracking-wide text-[#2A4043] dark:text-[#0D1A1C] bg-gradient-to-r from-[#37A0AF] to-[#CCE2E5] dark:from-[#5CC4D1] dark:to-[#8FE1E9]">
                ¡Tu plan cambió!
            </span>
            <h1 class="text-3xl font-extrabold text-[#24373A] dark:text-[#EAF5F6] tracking-tight">
                ¡Bienvenido a <span class="text-premium">Premium</span>!
            </h1>
            <p class="max-w-sm mt-3 text-sm text-[#4B6467] dark:text-[#9FB8BB] leading-relaxed">
                Tu cuenta se actualizó con éxito de
                <span class="font-semibold text-[#4B6467]/70 dark:text-[#9FB8BB]/60 line-through">{{ ucfirst($subscription->old_role ?? 'Free') }}</span>
                a <span class="font-semibold text-[#1F5F68] dark:text-[#8FE1E9]">Premium</span>. Disfruta de una experiencia sin límites.
            </p>

            <!-- Aviso de suscripción mensual automática -->
            <div class="w-full mt-6 bg-[#F7FAFB] dark:bg-[#152528] border border-[#24373A]/10 dark:border-[#5CC4D1]/10 rounded-2xl p-4 text-left">
                <p class="text-sm text-[#24373A] dark:text-[#EAF5F6]">
                    <span class="font-bold text-[#1F5F68] dark:text-[#5CC4D1]">Es una suscripción mensual automática.</span>
                    Se te cobrarán <span class="font-bold">ARS $7.000</span> cada mes a través de Mercado Pago mientras
                    la mantengas activa.
                </p>
                @if(($subscription->expires_at ?? null))
                    <p class="text-xs text-[#4B6467] dark:text-[#9FB8BB] mt-2">
                        Próxima renovación: <span class="font-semibold text-[#37A0AF] dark:text-[#5CC4D1]">{{ $subscription->expires_at->translatedFormat('d \ F, Y') }}</span>
                    </p>
                @endif
                <p class="text-xs text-[#4B6467] dark:text-[#9FB8BB] mt-1">
                    Podés gestionar o cancelar la renovación automática cuando quieras desde tu perfil.
                </p>
            </div>

            <!-- Beneficios activos, solo con íconos (sin foto) -->
            <div class="w-full mt-6 bg-white dark:bg-[#152528] rounded-2xl p-5 shadow-sm border border-[#24373A]/10 dark:border-[#5CC4D1]/10 text-left">
                <h2 class="text-xs font-bold text-[#37A0AF] dark:text-[#5CC4D1] uppercase tracking-wider mb-4">
                    Tus nuevos beneficios incluidos
                </h2>

                <div class="space-y-3">
                    @php
                        $activePerks = [
                            [
                                'image' => 'images/benefits/rutinas.jpg',
                                'icon'  => 'assignment',
                                'title' => 'Rutinas personalizables ilimitadas',
                                'desc'  => 'Renovar y guardar todo tu historial sin límites de espacio.',
                            ],
                            [
                                'image' => 'images/benefits/productos.jpg',
                                'icon'  => 'add_circle',
                                'title' => 'Productos ilimitados en rutinas',
                                'desc'  => 'Agregar más de 20 productos orientados a tu tratamiento diario.',
                            ],
                            [
                                'image' => 'images/benefits/articulos.jpg',
                                'icon'  => 'news',
                                'title' => 'Artículos escritos por profesionales',
                                'desc'  => 'Leer tips y explicaciones actualizadas por dermatólogos expertos.',
                            ],
                        ];
                    @endphp

                    @foreach ($activePerks as $perk)
                        <div class="flex items-center gap-3 p-2 rounded-xl hover:bg-[#37A0AF]/5 dark:hover:bg-[#5CC4D1]/5 transition-colors">
                            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-gradient-to-br from-[#37A0AF] to-[#1F5F68] dark:from-[#16282B] dark:to-[#16282B] dark:border dark:border-[#5CC4D1]/25 flex items-center justify-center">
                                <span class="icon-mask" style="--icon-src:url('{{ asset('images/icons/' . $perk['icon'] . '.svg') }}')"></span>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-[#24373A] dark:text-[#EAF5F6]">{{ $perk['title'] }}</h3>
                                <p class="text-xs text-[#4B6467] dark:text-[#9FB8BB] mt-0.5">{{ $perk['desc'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Promoción destacada: Self-pack de bienvenida (aparte, con mockup grande) -->
            <div class="w-full mt-6 rounded-2xl p-[1.5px] bg-gradient-to-r from-[#37A0AF] to-[#CCE2E5] dark:from-[#5CC4D1] dark:to-[#2E7480] shadow-[0_14px_36px_-14px_rgba(55,160,175,0.55)]">
                <div class="relative rounded-2xl bg-white dark:bg-[#122224] overflow-hidden text-left">

                    <span class="absolute mt-4 ml-4 z-10 inline-block px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide text-white bg-gradient-to-r from-[#37A0AF] to-[#1F5F68] dark:from-[#5CC4D1] dark:to-[#2E7480] shadow">
                        Regalo exclusivo
                    </span>

                    <div class="relative w-full aspect-[4/3] bg-[#CCE2E5] dark:bg-[#16282B]">
                        <img src="{{ asset('images/self-pack.png') }}" alt="Caja del self-pack de bienvenida Kälm"
                            loading="lazy" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/25 via-transparent to-transparent"></div>
                    </div>

                    <div class="p-5">
                        <h3 class="text-lg font-extrabold text-[#24373A] dark:text-[#EAF5F6]">
                            Self-pack de bienvenida
                        </h3>
                        <p class="text-sm text-[#4B6467] dark:text-[#9FB8BB] mt-1.5 leading-relaxed">
                            Un pack de productos exclusivos, sin costo, solo por ser Premium.
                            <span class="font-medium text-[#24373A] dark:text-[#EAF5F6]">Válido para residentes de Argentina.</span>
                        </p>

                        <div class="flex items-start gap-2 mt-4 pt-3 border-t border-[#24373A]/8 dark:border-[#5CC4D1]/10">
                            <svg class="w-4 h-4 mt-0.5 flex-shrink-0 text-[#37A0AF] dark:text-[#5CC4D1]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <p class="text-xs text-[#4B6467] dark:text-[#9FB8BB]">
                                Kälm se va a comunicar <span class="font-semibold text-[#24373A] dark:text-[#EAF5F6]">por mail</span>
                                para coordinar la entrega. Revisar su bandeja de entrada en los próximos días.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botón de Acción Principal -->
            <div class="w-full mt-8">
                <a href="{{ route('home') }}"
                    class="cta-boton group relative flex items-center justify-center w-full text-center px-8 py-5 rounded-2xl text-white text-base md:text-lg font-bold tracking-wide bg-gradient-to-r from-[#37A0AF] to-[#1F5F68] shadow-[0_10px_30px_-8px_rgba(31,95,104,0.55)] hover:shadow-[0_16px_40px_-8px_rgba(31,95,104,0.7)] hover:scale-[1.015] transition-all duration-300">
                    <span>Comenzar mi experiencia Premium</span>
                    <svg class="w-5 h-5 ml-3 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <style>
        /* Recolorea los íconos SVG con precisión sin depender del color propio
           del archivo: blanco en modo claro, acento de la paleta oscura en modo oscuro. */
        .icon-mask {
            display: inline-block;
            width: 18px;
            height: 18px;
            background-color: #FFFFFF;
            -webkit-mask-image: var(--icon-src);
            mask-image: var(--icon-src);
            -webkit-mask-size: contain;
            mask-size: contain;
            -webkit-mask-repeat: no-repeat;
            mask-repeat: no-repeat;
            -webkit-mask-position: center;
            mask-position: center;
        }

        @media (prefers-color-scheme: dark) {
            .icon-mask {
                background-color: #5CC4D1;
            }
        }

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

        .cta-boton {
            position: relative;
            overflow: hidden;
        }

        .cta-boton::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(120deg, transparent 0%, rgba(255, 255, 255, 0.18) 45%, transparent 60%);
            transform: translateX(-100%);
            transition: transform 0.6s ease;
        }

        .cta-boton:hover::before {
            transform: translateX(100%);
        }

        @media (prefers-reduced-motion: reduce) {

            .text-premium,
            .cta-boton::before,
            .cta-boton,
            .animate-bounce {
                animation: none !important;
                transition: none !important;
            }
        }
    </style>

</x-layout>