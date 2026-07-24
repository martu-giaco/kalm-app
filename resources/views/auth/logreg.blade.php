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

<body class="min-h-screen bg-center bg-cover header-bg">

    <div class="relative flex flex-col justify-between max-w-2xl min-h-screen p-6 mx-auto">

        <!-- LOGO -->
        <div class="mt-16 text-center">
            <picture class="h-24 mx-auto mb-6">
                <source srcset="{{ asset('images/logo-kalm-light.svg') }}" media="(prefers-color-scheme: dark)" type="image/svg+xml" />
                <img src="{{ asset('images/logo-kalm.svg') }}" alt="logo Kälm" class="h-24 mx-auto mb-6" />
            </picture>

            <h1 class="text-3xl font-extrabold text-[#2A4043] tracking-tight mb-2 dark:text-[#CCE2E5]">
                Tu momento de calma
            </h1>

            <p class="text-[#306067] text-base max-w-sm mx-auto dark:text-[#E9E5E3]">
                Recordatorios inteligentes para tus rutinas de skincare y haircare.
            </p>
        </div>

        <!-- CARDS ONBOARDING -->
        <div class="grid gap-4 mt-2">
            <div class="flex items-center gap-4 p-4 bg-white/70 rounded-2xl shadow-md">
                <div
                    class="w-12 h-12 rounded-full bg-[#306067]/20 flex items-center justify-center text-[#306067] text-xl">
                    🌿
                </div>
                <div>
                    <p class="font-bold text-[#2A4043]">Rutinas personalizadas</p>
                    <p class="text-sm text-gray-600">Adaptadas a tu piel y tu pelo.</p>
                </div>
            </div>

            <div class="flex items-center gap-4 p-4 bg-white/70 rounded-2xl shadow-md">
                <div
                    class="w-12 h-12 rounded-full bg-[#306067]/20 flex items-center justify-center text-[#306067] text-xl">
                    ⏰
                </div>
                <div>
                    <p class="font-bold text-[#2A4043]">Recordatorios diarios</p>
                    <p class="text-sm text-gray-600">Nunca olvides tu cuidado.</p>
                </div>
            </div>

            <div class="flex items-center gap-4 p-4 bg-white/70 rounded-2xl shadow-md">
                <div
                    class="w-12 h-12 rounded-full bg-[#306067]/20 flex items-center justify-center text-[#306067] text-xl">
                    ✨
                </div>
                <div>
                    <p class="font-bold text-[#2A4043]">Seguimiento visual</p>
                    <p class="text-sm text-gray-600">Observar tu progreso real.</p>
                </div>
            </div>
        </div>

        <!-- BOTONES (SIN CAMBIOS FUNCIONALES) -->
        <div class="mb-10">
            <a href="{{ route('auth.login') }}"
                class="btn w-full px-5 mb-4 py-3 rounded-xl text-white font-bold transition cursor-pointer hover:bg-[#306067] disabled:opacity-80 disabled:cursor-not-allowed bg-[#306067] dark:bg-[#E9E5E3] dark:hover:bg-[#E9E5E3] dark:text-[#306067] border-none">
                Iniciar Sesión
            </a>

            <a href="{{ route('auth.register') }}"
                class="btn w-full inline-flex border-2 border-[#306067] text-[#2A4043] bg-transparent px-6 py-3 rounded-xl font-bold transition-all duration-300 items-center justify-center gap-2 dark:border-[#E9E5E3] dark:text-[#E9E5E3]">
                Crear Cuenta
            </a>
        </div>

    </div>

</body>


</html>
