<x-layout :title="'Kälm Premium'">

    @php
        $plan = [
            'title' => 'Kälm Premium',
            'price' => 'ARS $7,000',
            'period' => '/mes',
            'buttonText' => 'Quiero ser Premium',
        ];

        $perks = [
            [
                'icon' => 'assignment',
                'title' => 'Rutinas ilimitadas',
                'desc' => 'Creá, activá y desactivá tantas rutinas como necesites sin perder tu historial.',
            ],
            [
                'icon' => 'add_circle',
                'title' => 'Más de 20 productos por rutina',
                'desc' => 'Sumá todos los productos que usás, sin topes ni restricciones.',
            ],
            [
                'icon' => 'experiment',
                'title' => 'Diagnóstico avanzado',
                'desc' => 'Tests adicionales de piel y cabello, con seguimiento de tu evolución.',
            ],
            [
                'icon' => 'news',
                'title' => 'Biblioteca de expertos',
                'desc' => 'Cientos de artículos de dermatólogos, con información clara y actualizada.',
            ],
            [
                'icon' => 'mail',
                'title' => 'Pack de bienvenida',
                'desc' => 'Productos exclusivos para nuevos suscriptores (solo residentes de Argentina).',
            ],
            [
                'icon' => 'schedule',
                'title' => 'Activación inmediata',
                'desc' => 'Empezás a usar todos los beneficios apenas confirmás el pago.',
            ],
        ];

        $comparison = [
            ['label' => 'Rutinas activas',        'free' => 'Hasta 2',        'premium' => 'Ilimitadas'],
            ['label' => 'Productos por rutina',   'free' => 'Hasta 5',        'premium' => '+20'],
            ['label' => 'Diagnóstico',            'free' => 'Test básico',    'premium' => 'Avanzado + seguimiento'],
            ['label' => 'Artículos de expertos',  'free' => 'Acceso limitado','premium' => 'Biblioteca completa'],
            ['label' => 'Pack de bienvenida',     'free' => '—',              'premium' => 'Incluido'],
        ];

        $faqs = [
            [
                'q' => '¿Puedo cancelar cuando quiera?',
                'a' => 'Sí, desde tu perfil y sin permanencia mínima. La baja se hace efectiva al final del período pagado.',
            ],
            [
                'q' => '¿Qué pasa con mis rutinas actuales?',
                'a' => 'Se conservan tal cual están. Premium amplía los límites, no reemplaza lo que ya armaste.',
            ],
            [
                'q' => '¿Cómo se factura?',
                'a' => 'Un cobro mensual automático con el medio de pago que elijas. Podés cambiarlo cuando quieras.',
            ],
        ];
    @endphp

    <!-- ============ HERO ============ -->
    <section class="relative w-full overflow-hidden bg-white dark:bg-[#0D1A1C] transition-colors duration-300 rounded-t-2xl">
        <video autoplay loop muted playsinline
            class="absolute inset-0 object-cover w-full h-full scale-110 blur-sm opacity-80 dark:opacity-30">
            <source src="{{ asset('images/video-final.mp4') }}" type="video/mp4">
        </video>
        <div class="absolute inset-0 bg-white/85 dark:bg-[#0D1A1C]/90"></div>

        <div class="relative z-10 max-w-2xl mx-auto px-4 pt-10 pb-16 text-center">
            <p class="text-xs font-semibold tracking-[0.2em] uppercase text-[#37A0AF] dark:text-[#5CC4D1] mb-4">
                Plan Premium
            </p>
            <h1 class="text-4xl md:text-5xl font-bold text-[#24373A] dark:text-[#EAF5F6] leading-[1.15]">
                Tu cuidado sin límites
            </h1>
            <p class="text-base md:text-lg text-[#4B6467] dark:text-[#9FB8BB] mt-5 leading-relaxed">
                Rutinas ilimitadas, diagnósticos más precisos y el respaldo de expertos.
            </p>
        </div>
    </section>

    <!-- ============ OFERTA PRINCIPAL ============ -->
    <section id="planes" class="w-full bg-white dark:bg-[#0D1A1C] pb-24 px-4 transition-colors duration-300">
        <div class="max-w-4xl mx-auto rounded-3xl border border-[#24373A]/10 dark:border-[#5CC4D1]/15 bg-[#FBFDFD] dark:bg-[#122224] shadow-[0_2px_40px_-12px_rgba(36,55,58,0.18)] dark:shadow-[0_2px_40px_-12px_rgba(0,0,0,0.5)] overflow-hidden">

            <!-- Encabezado del plan -->
            <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6 p-8 md:p-10 border-b border-[#24373A]/8 dark:border-[#5CC4D1]/10">
                <div>
                    <h2 class="text-2xl font-bold text-[#24373A] dark:text-[#EAF5F6]">{{ $plan['title'] }}</h2>
                    <p class="text-sm text-[#4B6467] dark:text-[#9FB8BB] mt-1">Un solo plan. Todos los beneficios.</p>
                </div>
                <div class="text-left md:text-right">
                    <span class="text-4xl font-extrabold text-[#24373A] dark:text-[#EAF5F6]">{{ $plan['price'] }}</span>
                    <span class="text-[#4B6467] dark:text-[#9FB8BB] font-medium">{{ $plan['period'] }}</span>
                </div>
            </div>

            <!-- Beneficios -->
            <div class="p-8 md:p-10">
                <h3 class="text-xs font-semibold tracking-[0.15em] uppercase text-[#37A0AF] dark:text-[#5CC4D1] mb-5">
                    Qué incluye
                </h3>
                <div class="grid sm:grid-cols-2 gap-x-8 gap-y-5">
                    @foreach ($perks as $perk)
                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0 w-6 h-6 mt-0.5 rounded-md bg-[#37A0AF]/10 dark:bg-[#5CC4D1]/10 flex items-center justify-center">
                                <svg class="w-3.5 h-3.5 text-[#37A0AF] dark:text-[#5CC4D1]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-sm text-[#24373A] dark:text-[#EAF5F6]">{{ $perk['title'] }}</p>
                                <p class="text-sm text-[#4B6467] dark:text-[#9FB8BB] mt-0.5">{{ $perk['desc'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Comparativa Free vs Premium -->
            <div class="px-8 md:px-10 pb-10">
                <h3 class="text-xs font-semibold tracking-[0.15em] uppercase text-[#37A0AF] dark:text-[#5CC4D1] mb-5">
                    Free vs. Premium
                </h3>
                <div class="rounded-xl border border-[#24373A]/8 dark:border-[#5CC4D1]/10 overflow-hidden">
                    <div class="grid grid-cols-[1.4fr_1fr_1fr] bg-[#F2F7F7] dark:bg-[#16282B] text-xs font-semibold uppercase tracking-wide text-[#4B6467] dark:text-[#9FB8BB]">
                        <div class="p-3 pl-4">Beneficio</div>
                        <div class="p-3 text-center">Free</div>
                        <div class="p-3 text-center text-[#24373A] dark:text-[#EAF5F6]">Premium</div>
                    </div>
                    @foreach ($comparison as $row)
                        <div class="grid grid-cols-[1.4fr_1fr_1fr] items-center border-t border-[#24373A]/6 dark:border-[#5CC4D1]/8 text-sm">
                            <div class="p-3 pl-4 font-medium text-[#24373A] dark:text-[#EAF5F6]">{{ $row['label'] }}</div>
                            <div class="p-3 text-center text-[#4B6467]/70 dark:text-[#9FB8BB]/60">{{ $row['free'] }}</div>
                            <div class="p-3 text-center font-semibold text-[#1F7A87] dark:text-[#5CC4D1]">{{ $row['premium'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- CTA grande -->
            <div class="px-8 md:px-10 pb-10">
                <a href="{{ route('subscription.checkout') }}"
                    class="cta-boton group relative flex items-center justify-center w-full text-center px-10 py-6 rounded-2xl text-white text-lg md:text-xl font-bold tracking-wide bg-gradient-to-r from-[#37A0AF] to-[#1F5F68] shadow-[0_10px_30px_-8px_rgba(31,95,104,0.55)] hover:shadow-[0_16px_40px_-8px_rgba(31,95,104,0.7)] hover:scale-[1.015] transition-all duration-300">
                    <span>{{ $plan['buttonText'] }}</span>
                    <svg class="w-5 h-5 ml-3 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
                <div class="flex flex-wrap items-center justify-center gap-x-6 gap-y-2 mt-5 text-xs font-medium text-[#4B6467] dark:text-[#9FB8BB]">
                    <span class="flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-[#37A0AF] dark:text-[#5CC4D1]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        Pago seguro
                    </span>
                    <span class="flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-[#37A0AF] dark:text-[#5CC4D1]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        Activación inmediata
                    </span>
                    <span class="flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-[#37A0AF] dark:text-[#5CC4D1]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        Cancelás cuando quieras
                    </span>
                </div>
            </div>
        </div>
    </section>

    <style>
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

        details summary::-webkit-details-marker {
            display: none;
        }

        @media (prefers-reduced-motion: reduce) {

            .cta-boton::before,
            .cta-boton,
            details svg {
                transition: none !important;
            }
        }
    </style>

</x-layout>