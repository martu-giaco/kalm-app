<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Kälm - Skincare & Haircare' }}</title>
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
</head>

<body class="min-h-screen bg-center bg-cover" >

    <div class="flex flex-col justify-between max-w-2xl min-h-screen px-6 pt-32 pb-20 mx-auto">
        <div>
            <h1 class="text-2xl font-bold text-[#306067]">Método de pago</h1>

        {{-- BLOQUE DE FEEDBACK: muestra feedback.message, status, message y errores --}}
        @php
            $feedbackMessage = session('feedback.message') ?? session('status') ?? session('message') ?? null;
            $feedbackType = session('feedback.type')
                            ?? (session('status') ? 'success' : null)
                            ?? session('type')
                            ?? 'info';
        @endphp

        @if ($feedbackMessage)
            <div class="mx-4 my-4">
                <div class="rounded-xl p-4 shadow-lg
                    @if($feedbackType === 'success') bg-green-50 text-green-800
                    @elseif(in_array($feedbackType, ['error','danger'])) bg-red-50 text-red-800
                    @elseif($feedbackType === 'warning') bg-yellow-50 text-yellow-800
                    @else bg-blue-50 text-blue-800 @endif">
                    {{ $feedbackMessage }}
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="mx-4 my-4">
                <div class="p-4 text-red-800 shadow-lg rounded-xl bg-red-50">
                    <ul class="pl-5 list-disc">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
        {{-- FIN BLOQUE DE FEEDBACK --}}

        <form action="{{ route('auth.authenticate') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="titular" class="block mb-1 text-sm text-[#306067]">Titular de la tarjeta</label>
                <input id="titular" name="titular" aria-label="Titular" type="text" placeholder="Apellido Nombre"
                    class="w-full p-3 bg-transparent rounded-xl border-2 border-[#CCE2E5] placeholder-[#CCE2E5] focus:outline-[#37A0AF] text-md text-[#306067]"
                    required>
            </div>

            <div>
                <label for="numero" class="block mb-1 text-sm text-[#306067]">Número de la tarjeta</label>
                <input id="numero" name="numero" aria-label="Número de la tarjeta" type="text" inputmode="numeric" pattern="\d{15,}" minlength="15" placeholder="XXXX XXXX XXXX XXXX"
                    class="w-full p-3 bg-transparent rounded-xl border-2 border-[#CCE2E5] placeholder-[#CCE2E5] focus:outline-[#37A0AF] text-md text-[#306067]"
                    required title="Ingrese al menos 15 dígitos.">
            </div>

            <div>
                <label for="vto" class="block mb-1 text-sm text-[#306067]">Fecha de vencimiento</label>
                <input id="vto" name="vto" aria-label="Fecha de vencimiento" type="date"
                    min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                    class="w-full p-3 bg-transparent rounded-xl border-2 border-[#CCE2E5] placeholder-[#CCE2E5] focus:outline-[#37A0AF] text-md text-[#306067]"
                    required title="La fecha debe ser en el futuro.">
            </div>

            <div>
                <label for="cvc" class="block mb-1 text-sm text-[#306067]">CVC</label>
                <input id="cvc" name="cvc" aria-label="CVC" type="text" inputmode="numeric" pattern="^\d{3,4}$" minlength="3" maxlength="4" placeholder="XXX"
                    class="w-full p-3 bg-transparent rounded-xl border-2 border-[#CCE2E5] placeholder-[#CCE2E5] focus:outline-[#37A0AF] text-md text-[#306067]"
                    required title="Ingrese 3 o 4 dígitos.">
            </div>
        </div>

        <div class="mt-10">
                        <input type="submit" value="Suscribirme por $7,000/mes"
                            class="btn text-md w-full px-5 mb-2 py-3 border-0 rounded-xl text-white font-bold transition cursor-pointer hover:bg-[#306067] disabled:opacity-80 disabled:cursor-not-allowed bg-[#306067]">
                        <a href="{{ route('home') }}"
                            class="btn w-full inline-flex border-2 border-[#306067] text-[#306067] bg-transparent px-6 py-3 rounded-xl font-bold transition-all duration-300 items-center justify-center gap-2 text-sm">
                            Cancelar
                        </a>
                        <p class="text-[#306067] text-xs text-center mt-3">Esta suscripción se puede cancelar en cualquier momento.</p>
            </div>

        </form>
        </div>


</body>

</html>
