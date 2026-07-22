<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Kälm | Resultado del Test</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon/favicon-96x96.png') }}" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon/favicon.svg') }}" />
    <link rel="shortcut icon" href="{{ asset('favicon/favicon.ico') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon/apple-touch-icon.png') }}" />
    <link rel="manifest" href="{{ asset('favicon/site.webmanifest') }}" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,200..1000;1,200..1000&display=swap"
        rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.4.2/dist/full.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-fadeIn {
            animation: fadeIn 0.5s ease-out forwards;
        }
    </style>
</head>

<body class="min-h-screen bg-center bg-cover" style="background-image: url('{{ asset('images/fondo.png') }}');">

    <div class="max-w-3xl py-8 mx-auto px-7">
        <div class="flex items-end justify-end w-full max-w-3xl mx-auto">
            <a href="{{ route('profile.results') }}" class="self-end cursor-pointer" aria-label="close sidebar">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" viewBox="0 -960 960 960" fill="#2A4043" aria-hidden="true">
                    <path d="M480-424 284-228q-11 11-28 11t-28-11q-11-11-11-28t11-28l196-196-196-196q-11-11-11-28t11-28q11-11 28-11t28 11l196 196 196-196q11-11 28-11t28 11q11 11 11 28t-11 28L536-480l196 196q11 11 11 28t-11 28q-11 11-28 11t-28-11L480-424Z" />
                </svg>
            </a>
        </div>

        <article class="pt-6">
            {{-- Mostrar notificación de éxito si existe --}}
            @if (session('success'))
                <div class="p-4 mb-6 border-l-4 border-green-500 rounded-lg shadow-md bg-gradient-to-r from-green-50 to-emerald-50 animate-fadeIn">
                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-600" viewBox="0 -960 960 960" fill="currentColor">
                            <path d="M382-240 154-468l51-51 177 177 360-360 51 51-411 411Z"/>
                        </svg>
                        <span class="font-semibold text-green-700">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <div class="mb-7">
                @if ($testKey === 'cabello')
                    <h1 class="text-2xl font-semibold text-[#306067] text-center">Conocé tu cabello:</h1>
                @else
                    <h1 class="text-2xl font-semibold text-[#306067] text-center">Conocé tu piel:</h1>
                @endif

                @if ($testKey === 'cabello')
                    <p class="text-center text-md text-[#37A0AF]">Según tus respuestas,<br>tu tipo de cabello es <span
                        class="font-bold font-3xl text-center text-[#306067] mb-4">{{ ucfirst($resultLabel) }}</span>
                </p>
                @else
                    <p class="text-center text-md text-[#37A0AF]">Según tus respuestas,<br>tu tipo de piel es <span
                        class="font-bold font-3xl text-center text-[#306067] mb-4">{{ ucfirst($resultLabel) }}</span>
                </p>
                @endif

                <p class="mt-5 text-md text-[#306067]">{{ $resultDesc }}</p>
            </div>

            <div class="mb-7">
                <h2 class="text-2xl font-semibold text-[#306067] text-center">Tu rutina ideal</h2>

                @if ($recommendedRoutine)
                    <h3 class="mt-3 text-lg font-semibold text-[#306067] text-center">
                        {{ $recommendedRoutine->name }}
                    </h3>

                    <div class="flex justify-center items-center gap-2 text-[#37A0AF] text-sm mt-1">
                        <span>{{ $recommendedRoutine->routineTime?->name ?? $recommendedRoutine->time_of_day ?? 'Sin horario' }}</span>
                    </div>

                    {{-- Mostrar pasos de la rutina --}}
                    @if ($recommendedRoutine->steps)
                        <div class="mt-6 space-y-4">
                            @php
                                $stepsArray = is_string($recommendedRoutine->steps)
                                    ? json_decode($recommendedRoutine->steps, true)
                                    : $recommendedRoutine->steps;
                            @endphp

                            @foreach ($stepsArray as $index => $step)
                                <div class="bg-gradient-to-r from-[#f0f9fa] to-white p-4 rounded-lg border-l-4 border-[#37A0AF]">
                                    <h4 class="font-semibold text-[#306067] mb-2">{{ $step }}</h4>

                                    {{-- Mostrar productos para este paso --}}
                                    @if ($recommendedProducts->count() > 0)
                                        <div class="flex gap-3 overflow-x-auto scrollbar-hide mt-3">
                                            @foreach ($recommendedProducts->slice($index * 2, 2) as $product)
                                                <div class="flex-shrink-0 w-28 md:w-32">
                                                    <a href="{{ route('products.show', $product->id) }}" class="group">
                                                        <div class="overflow-hidden bg-white shadow-md rounded-lg hover:shadow-lg transition">
                                                            <div class="w-full h-24 overflow-hidden">
                                                                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                                                                    class="object-cover w-full h-full group-hover:scale-105 transition">
                                                            </div>
                                                            <div class="p-2 text-center">
                                                                <p class="text-xs font-semibold text-[#2A4043] truncate">{{ $product->name }}</p>
                                                                @if ($product->brand)
                                                                    <p class="text-[10px] text-[#37A0AF]">{{ $product->brand->name }}</p>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                @else
                    <p class="mt-4 text-center text-gray-500">
                        No hay una rutina cargada para este resultado.
                    </p>
                @endif
            </div>

            {{-- Productos recomendados separados --}}
            @if ($recommendedProducts->count() > 4)
                <h2 class="text-2xl font-semibold text-[#306067] mb-3 mt-8">Otros productos recomendados</h2>

                <div class="flex pb-4 space-x-6 overflow-x-auto scrollbar-hide">
                    @foreach ($recommendedProducts->slice(4) as $product)
                        <a href="{{ route('products.show', $product->id) }}" class="flex-shrink-0 w-40 md:w-44 group">
                            <div
                                class="overflow-hidden transition duration-300 bg-white shadow-md rounded-xl hover:shadow-lg">

                                {{-- Imagen del producto --}}
                                <div class="w-full h-40 overflow-hidden">
                                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                                        class="object-cover w-full h-full transition duration-300 group-hover:scale-105">
                                </div>

                                {{-- Info simplificada --}}
                                <div class="flex flex-col p-3">
                                    <h3 class="text-sm font-semibold text-[#2A4043] truncate">
                                        {{ $product->name }}
                                    </h3>

                                    @if (!empty($product->brand?->name))
                                        <h3 class="text-[13px] text-[#37A0AF] truncate">
                                            {{ $product->brand->name }}</h3>
                                    @endif
                                    @if (!empty($product->type?->name))
                                        <button
                                            class="text-[10px] mt-2 w-20 inline-block text-white truncate bg-[#37A0AF] px-2 py-1 rounded-xl">
                                            ✨{{ $product->type->name }}
                                        </button>
                                    @endif
                                </div>

                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </article>
    </div>

    {{-- Botones de acción --}}
    <div class="sticky bottom-0 flex flex-wrap w-full gap-3 p-4 mt-6 bg-white py-7">
        @php $testKey = session('test_key'); @endphp

        @auth
            <form action="{{ route('tests.saveResult') }}" method="POST" class="inline w-full">
                @csrf
                <input type="hidden" name="test_key" value="{{ $testKey }}">
                <input type="hidden" name="result_key" value="{{ $resultLabel }}">
                <input type="hidden" name="answers" value='{{ json_encode(session('test_answers', [])) }}'>
                <button type="submit" class="block px-4 py-3 bg-[#164d4f] text-white rounded-lg w-full">Guardar Resultado
                    en Perfil</button>
            </form>
        @else
            <a href="{{ route('auth.login') }}" class="block px-4 py-3 bg-[#164d4f] text-white rounded-lg w-full">
                Iniciar Sesión para guardar
            </a>
        @endauth

        <a href="{{ $testKey ? route('tests.show', $testKey) : route('tests.index') }}"
            class="w-full text-center px-4 py-2 text-[#37A0AF] border-2 border-[#37A0AF] rounded-lg">
            {{ $testKey ? 'Rehacer Test' : 'Volver a tests' }}
        </a>

    </div>

</body>

</html>
