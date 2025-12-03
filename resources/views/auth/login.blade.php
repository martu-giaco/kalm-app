<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Kälm | Log In</title>
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

<body class="min-h-screen bg-cover bg-center" style="background-image: url('{{ asset('images/fondo.png') }}');">

    <div class="max-w-2xl mx-auto p-6 flex flex-col justify-between min-h-screen">
        <img src="{{ asset('images/logo-kalm.svg') }}" alt="logo Kälm" class="h-24 mx-auto mt-14 mb-5">
        <div>
            <h1 class="text-2xl font-bold text-[#2A4043]">Iniciar Sesión</h1>

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
                <div class="rounded-xl p-4 bg-red-50 text-red-800 shadow-lg">
                    <ul class="list-disc pl-5">
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
                <label for="email" class="block mb-1 text-sm">Email</label>
                <input id="email" name="email" type="email" placeholder="Email"
                    class="w-full p-3 bg-transparent rounded-xl border-2 border-[#37A0AF] placeholder-[#CCE2E5] focus:outline-[#37A0AF] text-md text-[#2A4043]"
                    required>
            </div>

            <div>
                <label for="password" class="block mb-1 text-sm">Contraseña</label>
                <input id="password" name="password" type="password" placeholder="Contraseña"
                    class="w-full p-3 bg-transparent rounded-xl border-2 border-[#37A0AF] placeholder-[#CCE2E5] focus:outline-[#37A0AF] text-md text-[#2A4043]"
                    required>
            </div>

            <input type="submit" value="Ingresar"
                class="btn w-full px-5 py-3 rounded-xl text-white font-bold transition cursor-pointer disabled:opacity-80 disabled:cursor-not-allowed bg-[#306067]">

            <a class="block text-center font-bold text-sm text-[#2A4043] mt-2" href="#">Olvidé la
                contraseña</a>
        </form>
        </div>

        <div>
            <p class="decorated text-[#2A4043] text-sm mt-6 mb-3">No tengo cuenta</p>

            <a href="{{ route('auth.register') }}"
                class="w-full inline-flex border-2 border-[#306067] text-[#2A4043] bg-transparent px-6 py-3 rounded-xl font-bold transition-all duration-300 items-center justify-center gap-2">
                Crear cuenta
            </a>
        </div>

    </div>

</body>

</html>
