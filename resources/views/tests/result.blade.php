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

    <div class="max-w-3xl px-7 py-8 mx-auto">
        <article class="pt-6">

            {{-- Mostrar notificación de éxito si existe --}}
            @if (session('success'))
                <div class="mb-6 p-4 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 rounded-lg shadow-md animate-fadeIn">
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
                {{-- <span class="text-[#37A0AF] text-sm">{{ $routine->types->pluck('name')->join(', ') ?: 'No definido' }} · {{ $routine->routineTime?->name ?? 'No definido' }}</span>
                @if ($routine->routineTime)
                    @if ($routine->routineTime?->name === 'Día')
                        <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#37A0AF" class="ms-1">
                            <path d="M480-760q-17 0-28.5-11.5T440-800v-80q0-17 11.5-28.5T480-920q17 0 28.5 11.5T520-880v80q0 17-11.5 28.5T480-760Zm198 82q-11-11-11-27.5t11-28.5l56-57q12-12 28.5-12t28.5 12q11 11 11 28t-11 28l-57 57q-11 11-28 11t-28-11Zm122 238q-17 0-28.5-11.5T760-480q0-17 11.5-28.5T800-520h80q17 0 28.5 11.5T920-480q0 17-11.5 28.5T880-440h-80ZM480-40q-17 0-28.5-11.5T440-80v-80q0-17 11.5-28.5T480-200q17 0 28.5 11.5T520-160v80q0 17-11.5 28.5T480-40ZM226-678l-57-56q-12-12-12-29t12-28q11-11 28-11t28 11l57 57q11 11 11 28t-11 28q-12 11-28 11t-28-11Zm508 509-56-57q-11-12-11-28.5t11-27.5q11-11 27.5-11t28.5 11l57 56q12 11 11.5 28T791-169q-12 12-29 12t-28-12ZM80-440q-17 0-28.5-11.5T40-480q0-17 11.5-28.5T80-520h80q17 0 28.5 11.5T200-480q0 17-11.5 28.5T160-440H80Zm89 271q-11-11-11-28t11-28l57-57q11-11 27.5-11t28.5 11q12 12 12 28.5T282-225l-56 56q-12 12-29 12t-28-12Zm311-71q-100 0-170-70t-70-170q0-100 70-170t170-70q100 0 170 70t70 170q0 100-70 170t-170 70Zm0-80q66 0 113-47t47-113q0-66-47-113t-113-47q-66 0-113 47t-47 113q0 66 47 113t113 47Zm0-160Z" />
                        </svg>
                    @elseif($routine->routineTime?->name === 'Noche')
                        <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#37A0AF" class="ms-1"><path d="M480.24-116.41q-153.63 0-258.73-104.98Q116.41-326.37 116.41-480q0-133.93 84.74-235.43t223.31-123.05q15.39-3.43 27.54 1.35 12.15 4.78 19.95 14.02 7.79 9.24 9.6 22.2 1.82 12.95-4.75 26.11-13.89 25.04-21.31 51.65-7.42 26.61-7.42 55.5 0 91.69 64.32 155.88 64.33 64.18 156.22 64.18 28.37 0 56.48-7.44 28.11-7.45 50.91-20.58 12.91-5.8 25.13-4.11 12.22 1.7 21.1 8.13 9.88 6.44 14.66 18.23 4.78 11.8 1.59 27.95Q820.17-291 717.63-203.71q-102.54 87.3-237.39 87.3Zm0-91q81.78 0 147.84-43.72 66.05-43.72 98.29-114.78-17.61 4.04-35.1 6.32-17.49 2.29-34.86 1.81-122.04-4.07-207.94-89.37-85.9-85.31-90.45-209.26-.24-17.37 1.93-34.98 2.16-17.61 6.44-34.98-70.82 32.48-114.78 98.65-43.96 66.18-43.96 147.72 0 112.93 79.83 192.76 79.83 79.83 192.76 79.83Zm-13.11-259.48Z"/></svg>
                    @endif
                @endif --}}
                @if ($recommendedRoutine)
                    <h3 class="mt-3 text-lg font-semibold text-[#306067] text-center">
                        {{ $recommendedRoutine->name }}
                    </h3>

                    <div class="flex justify-center items-center gap-2 text-[#37A0AF] text-sm mt-1">
                        <span>{{ $recommendedRoutine->routineTime?->name ?? 'Sin horario' }}</span>
                    </div>

                    <ul class="mt-4 list-disc pl-6 text-[#306067]">
                        @foreach ($recommendedRoutine->steps ?? [] as $step)
                            <li>{{ $step }}</li>
                        @endforeach
                    </ul>

                    @auth
                        <form action="{{ route('routines.fromRecommended', $recommendedRoutine->recommended_id) }}"
                            method="POST">
                            @csrf
                            <button class="mt-5 w-full bg-[#37A0AF] text-white rounded-lg py-3">
                                Guardar rutina en mi perfil
                            </button>
                        </form>
                    @endauth
                @else
                    <p class="text-gray-500 text-center mt-4">
                        No hay una rutina cargada para este resultado.
                    </p>
                @endif


                @auth
                    <a href="{{ route('tests.createRoutine') }}"
                        class="block px-4 py-3 bg-[#37A0AF] text-white rounded-lg w-full text-center">
                        Guardar Rutina
                    </a>
                @endauth

            </div>

            {{-- Productos recomendados --}}
            <h2 class="text-2xl font-semibold text-[#306067] mb-3">Productos recomendados</h2>

            @if ($recommendedProducts->count())
                <div class="flex pb-4 space-x-6 overflow-x-auto scrollbar-hide">
                    @foreach ($recommendedProducts as $product)
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
            @else
                <p class="text-gray-600">No se encontraron productos recomendados para este resultado.</p>
            @endif
        </article>
    </div>

    {{-- Botones de acción --}}
    <div class="sticky bottom-0 flex flex-wrap gap-3 mt-6 p-4 py-7 bg-white w-full">
        @php $testKey = session('test_key'); @endphp

        @auth
            <form action="{{ route('tests.saveResult') }}" method="POST" class="inline w-full">
                @csrf
                <input type="hidden" name="test_key" value="{{ $testKey }}">
                <input type="hidden" name="result_key" value="{{ $resultLabel }}">
                <input type="hidden" name="answers" value='{{ json_encode(session('test_answers', [])) }}'>
                <button type="submit" class="block px-4 py-3 bg-[#164d4f] text-white rounded-lg w-full">Guardar resultado
                    en perfil</button>
            </form>
        @else
            <a href="{{ route('auth.login') }}" class="block px-4 py-3 bg-[#164d4f] text-white rounded-lg w-full">
                Iniciar sesión para guardar
            </a>
        @endauth

        <a href="{{ $testKey ? route('tests.show', $testKey) : route('tests.index') }}"
            class="w-full text-center px-4 py-2 text-[#37A0AF] border-2 border-[#37A0AF] rounded-lg">
            {{ $testKey ? 'Rehacer test' : 'Volver a tests' }}
        </a>

    </div>

</body>

</html>
