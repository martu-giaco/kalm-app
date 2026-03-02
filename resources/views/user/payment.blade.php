<x-layout :title="'Kälm Premium'">

    <section class="relative flex flex-col items-center w-full justify-center bg-no-repeat bg-cover bg-[url('/assets/imgs/header-bg.png')] pt-50 pb-60 bg-gradiente">
        <div class="absolute inset-0 bg-white/70"></div>
        <div class="relative z-10 w-full max-w-3xl px-4 text-center pt-12">
            <div class="mb-8">
                <h1 class="text-5xl font-extrabold text-[#37A0AF]">Pasá al Plan Premium</h1>
                <div class="h-1 w-16 bg-gradient-to-r from-[#37A0AF] to-[#CCE2E5] mx-auto mt-4 rounded-full"></div>
            </div>
            <p class="text-xl text-[#2A4043] mb-5">No te conformes con lo básico cuando podés tener lo mejor. Con el Plan Premium accedés a beneficios exclusivos pensados para que vivas una experiencia completa, sin límites y sin interrupciones. Más contenido, más herramientas, más ventajas. Todo en un solo lugar.</p>
        </div>


        @php
            $plans = [
                [
                    'id' => 1,
                    'title' => 'Kälm Premium',
                    'price' => 'ARS $7,000 /mes',
                    'perks' => [
                        ['icon' => 'assignment', 'title' => 'Rutinas personalizables ilimitadas', 'desc' => 'Renová tus rutinas sin perder tu historia activando y desactivando rutinas según tu actividad.'],
                        ['icon' => 'add_circle', 'title' => 'Productos ilimitados en rutinas', 'desc' => 'Ahora podés agregar +20 productos a tus rutinas.'],
                        ['icon' => 'experiment', 'title' => 'Diagnóstico a fondo de piel y cabello', 'desc' => 'Disfrutá de tests extra y descubrí aún más sobre tu piel y cabello.'],
                        ['icon' => 'news', 'title' => 'Artículos escritos por profesionales', 'desc' => 'Accedé a cientos de articulos escritos por dermatólogos expertos con tips, explicaciones simples e información actualizada.'],
                        ['icon' => 'mail', 'title' => 'Self-pack de bienvenida', 'desc' => 'Recibí un pack de bienvenida con productos exclusivos para nuevos suscriptores.(*solo aplica para usuarios residentes de Argentina)'],
                    ],
                    'buttonText' => 'Suscribirme por $7,000/mes',
                    'main' => true
                ]
            ];
        @endphp

        <div class="relative z-10 w-full px-4">
            <div class="grid grid-cols-1 md:grid-cols-1 gap-6 mt-6 items-stretch">
            @foreach($plans as $plan)
                <div class="py-4 rounded-2xl flex plan-card {{ $plan['main'] ? 'bg-linear-to-b from-[#37A0AF] to-[#CCE2E5] py-4 px-2' : 'glass-effect' }}">
                    <div class="flex flex-col py-6 px-8 rounded-2xl {{ $plan['main'] ? 'bg-white/80' : '' }} w-full h-full">
                        <h3 class="text-4xl font-bold text-[#306067] mb-2 text-center">{{ $plan['title'] }}</h3>
                        @isset($plan['price'])
                            <span class="text-3xl font-extrabold text-[#37A0AF] mb-6 text-center block">{{ $plan['price'] }}</span>
                            <div class="h-px bg-gradient-to-r from-transparent via-[#37A0AF] to-transparent mb-6"></div>
                        @endisset

                        @if(!empty($plan['perks']))
                            <div class="mt-6 space-y-3 mb-8">
                                @foreach($plan['perks'] as $perk)
                                    <div class="flex items-start gap-3 bg-[#37A0AF] bg-opacity-10 p-3 rounded-lg shadow-sm hover:shadow-lg hover:bg-opacity-20 transition-all duration-300 group">
                                        <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-gradient-to-br from-[#37A0AF] to-[#306067] flex items-center justify-center">
                                            <img src="{{ asset('images/icons/'.$perk['icon'].'.svg') }}" alt="{{ $perk['title'] }}" class="w-4 h-4 invert"/>
                                        </div>
                                        <div class="flex-1">
                                            <p class="font-bold text-[#306067] group-hover:text-[#37A0AF] transition-colors">{{ $perk['title'] }}</p>
                                            <p class="text-[#2A4043] text-sm">{{ $perk['desc'] }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <div class="mt-auto pt-4 flex justify-center">
                            @if($plan['main'])
                                <a href="{{ route('subscription.checkout') }}" class="w-full text-center px-10 py-3 pt-4 bg-gradient-to-r from-[#306067] to-[#2A4043] text-white rounded-2xl shadow-lg hover:shadow-2xl hover:scale-105 transition-all duration-300 boton-header font-semibold tracking-wide">
                                    {{ $plan['buttonText'] }}
                                </a>
                            @else
                                <a href="{{ route('home') }}" class="w-full text-center px-10 py-3 pt-4 bg-[#CCE2E5] text-[#2A4043] rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 boton-header font-semibold">{{ $plan['buttonText'] }}</a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
            </div>
        </div>
    </section>



    <style>
        .gradiente-premium {
            background: linear-gradient(135deg, #37A0AF 0%, #CCE2E5 100%);
            padding: 3px;
        }

        .plan-price {
            background: linear-gradient(135deg, #0f6064, #37A0AF);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .plan-card {
            transition: transform .3s cubic-bezier(0.25, 0.46, 0.45, 0.94), box-shadow .3s ease;
            border: 2px solid rgba(55, 160, 175, 0.1);
            background: white;
            border-radius: 1.25rem;
            max-width: 28rem;
            margin: 0 auto;
        }
        .plan-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(55, 160, 175, 0.2);
            border-color: rgba(55, 160, 175, 0.2);
        }

        .plan-card .mt-4 > .flex {
            transition: box-shadow .2s ease;
        }
        .plan-card .mt-4 > .flex:hover {
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .plan-card h3 {
            letter-spacing: 0.5px;
            line-height: 1.2;
        }

        .plan-card span.text-3xl {
            background: linear-gradient(90deg, #37A0AF, #306067);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: block;
        }

        .plan-card .flex.items-start {
            align-items: flex-start;
        }

        /* Button enhancement */
        .boton-header {
            position: relative;
            overflow: hidden;
        }
        .boton-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.15);
            transition: left 0.3s ease;
            z-index: -1;
        }
        .boton-header:hover::before {
            left: 100%;
        }

        article { display: flex; flex-direction: column; }

        article h2 { margin: 0; }

        @media (min-width: 768px) {
            .gradiente-premium { padding: 4px; }
        }

        /* subtle hover for both cards */
        article:hover { transform: translateY(-6px); transition: transform .25s ease; }

        /* ensure good spacing on small screens */
        @media (max-width: 768px) {
            .max-w-7xl { padding-left: 1rem; padding-right: 1rem; }
            .plan-price { font-size: 1.6rem; }
        }

    </style>

</x-layout>
