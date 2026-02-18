<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Kälm | Características</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon/favicon-96x96.png') }}" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon/favicon.svg') }}" />
    <link rel="shortcut icon" href="{{ asset('favicon/favicon.ico') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon/apple-touch-icon.png') }}" />
    <link rel="manifest" href="{{ asset('favicon/site.webmanifest') }}" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstyx.cross" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,200..1000;1,200..1000&display=swap"
        rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.4.2/dist/full.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body class="min-h-screen bg-gradient-to-b from-[#A8D8E8] to-[#E8F4F5] flex flex-col">
    <div class="flex-1 flex flex-col justify-between px-6 py-12">
        {{-- Logo superior --}}
        <div class="flex justify-center">
            <img src="{{ asset('images/logo-kalm.svg') }}" alt="logo Kälm" class="h-16 md:h-20">
        </div>

        {{-- Características principales --}}
        <div class="space-y-6 my-8">
            {{-- Característica 1: Rutinas personalizadas --}}
            <div class="bg-white/80 backdrop-blur p-5 rounded-2xl flex items-start gap-4 shadow-sm">
                <div class="flex-shrink-0 flex items-center justify-center w-12 h-12 bg-[#E8F4F5] rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-[#37A0AF]" viewBox="0 -960 960 960" fill="currentColor">
                        <path d="M240-80q-33 0-56.5-23.5T160-160v-640q0-33 23.5-56.5T240-880h320v80H240v640h480v-320h80v320q0 33-23.5 56.5T720-80H240Zm360-240v-80h280v80H600Zm0-120v-80h280v80H600Zm0-120v-80h280v80H600ZM240-240v80-640 560Z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="font-bold text-[#2A4043] text-lg">Rutinas personalizadas</h3>
                    <p class="text-[#37A0AF] text-sm">Adaptadas a tu piel y tu pelo.</p>
                </div>
            </div>

            {{-- Característica 2: Recordatorios diarios --}}
            <div class="bg-white/80 backdrop-blur p-5 rounded-2xl flex items-start gap-4 shadow-sm">
                <div class="flex-shrink-0 flex items-center justify-center w-12 h-12 bg-[#FFE8E8] rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-[#E84C3D]" viewBox="0 -960 960 960" fill="currentColor">
                        <path d="M480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Zm0 240q-100 0-170-70t-70-170q0-100 70-170t170-70q100 0 170 70t70 170q0 100-70 170t-170 70Zm0-280q-42 0-71 29t-29 71q0 42 29 71t71 29q42 0 71-29t29-71q0-42-29-71t-71-29Zm0 160q25 0 42.5-17.5T560-480q0-25-17.5-42.5T500-540q-25 0-42.5 17.5T440-480q0 25 17.5 42.5T500-420Z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="font-bold text-[#2A4043] text-lg">Recordatorios diarios</h3>
                    <p class="text-[#37A0AF] text-sm">Nunca olvides tu cuidado.</p>
                </div>
            </div>

            {{-- Característica 3: Seguimiento visual --}}
            <div class="bg-white/80 backdrop-blur p-5 rounded-2xl flex items-start gap-4 shadow-sm">
                <div class="flex-shrink-0 flex items-center justify-center w-12 h-12 bg-[#FFF4E8] rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-[#FFB84D]" viewBox="0 -960 960 960" fill="currentColor">
                        <path d="M280-280h400v-80H280v80Zm0-160h400v-80H280v80ZM140-80q-24 0-42-18t-18-42v-680q0-24 18-42t42-18h680q24 0 42 18t18 42v680q0 24-18 42t-42 18H140Zm0-60h680v-680H140v680Z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="font-bold text-[#2A4043] text-lg">Seguimiento visual</h3>
                    <p class="text-[#37A0AF] text-sm">Observar tu progreso real.</p>
                </div>
            </div>
        </div>

        {{-- Botones de acción --}}
        <div class="space-y-3">
            <a href="{{ route('auth.register') }}"
                class="w-full block px-6 py-4 bg-[#2A4043] text-white rounded-2xl font-bold text-center hover:bg-[#1a2729] transition text-lg">
                Crear Cuenta
            </a>

            <a href="{{ route('auth.login') }}"
                class="w-full block px-6 py-4 bg-white text-[#2A4043] rounded-2xl font-bold text-center hover:bg-gray-50 transition text-lg border-2 border-[#2A4043]">
                Iniciar sesión
            </a>
        </div>
    </div>
</body>

</html>
