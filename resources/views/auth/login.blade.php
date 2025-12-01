<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Kälm | Log In</title>

    <!-- Tailwind CDN (prototipo) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- DaisyUI (opcional CDN precompilado) -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.4.2/dist/full.css" rel="stylesheet" />

    <!-- Tu CSS compilado (si existe) -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body class="min-h-screen bg-cover bg-center" style="background-image: url('{{ asset('images/fondo.png') }}')">

    <div class="max-w-2xl mx-auto p-6 flex flex-col justify-around">
        <img src="{{ asset('images/logo-kalm.svg') }}" alt="logo Kälm" class="h-24 mx-auto mt-20 mb-5">
        <h1 class="text-2xl font-bold mb-6 text-[var(--kalm-text)]">Iniciar Sesión</h1>

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
                    class="w-full p-3 bg-transparent rounded-xl border-2 border-[var(--kalm-light)] placeholder-[var(--kalm-lighter)] focus:outline-[var(--kalm-light)] text-md text-[var(--kalm-text)]"
                    required>
            </div>

            <div>
                <label for="password" class="block mb-1 text-sm">Contraseña</label>
                <input id="password" name="password" type="password" placeholder="Contraseña"
                    class="w-full p-3 bg-transparent rounded-xl border-2 border-[var(--kalm-light)] placeholder-[var(--kalm-lighter)] focus:outline-[var(--kalm-light)] text-md text-[var(--kalm-text)]"
                    required>
            </div>

            <input type="submit" value="Ingresar"
                class="btn w-full px-5 py-3 rounded-xl text-white font-bold transition cursor-pointer disabled:opacity-80 disabled:cursor-not-allowed bg-[var(--kalm-dark)]">

            <a class="block text-center font-bold text-sm text-[var(--kalm-text)] mt-2" href="#">Olvidé la
                contraseña</a>
        </form>

        <p class="decorated text-[var(--kalm-text)] text-sm mt-6 mb-3">No tengo cuenta</p>

        <a href="{{ route('auth.register') }}"
            class="w-full inline-flex border-2 border-[var(--kalm-dark)] text-[var(--kalm-text)] bg-transparent px-6 py-3 rounded-xl font-bold transition-all duration-300 items-center justify-center gap-2">
            Crear cuenta
        </a>

    </div>

</body>

</html>
