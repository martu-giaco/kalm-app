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

<body class="h-screen w-screen overflow-hidden bg-center bg-cover header-bg font-['Mulish'] selection:bg-[#306067]/20">

    <div class="relative flex flex-col justify-between h-full max-w-lg p-5 mx-auto sm:p-6">

        <!-- HEADER / LOGO -->
        <div class="pt-4 text-center sm:pt-6 shrink-0">
            <picture class="block h-16 mx-auto mb-3 sm:h-20">
                <source srcset="{{ asset('images/logo-kalm-light.svg') }}" media="(prefers-color-scheme: dark)" type="image/svg+xml" />
                <img src="{{ asset('images/logo-kalm.svg') }}" alt="logo Kälm" class="h-16 mx-auto sm:h-20" />
            </picture>

            <span class="inline-block px-3 py-0.5 mb-2 text-[11px] font-bold tracking-wider uppercase rounded-full bg-[#306067]/10 text-[#306067] dark:bg-[#CCE2E5]/10 dark:text-[#CCE2E5]">
                Tu espacio de autocuidado
            </span>

            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#2A4043] tracking-tight mb-1 dark:text-[#CCE2E5]">
                Tu momento de calma
            </h1>

            <p class="text-[#306067] text-xs sm:text-sm max-w-xs mx-auto dark:text-[#E9E5E3] font-medium leading-relaxed">
                Transforma tu piel y cabello construyendo hábitos sostenibles con recordatorios inteligentes.
            </p>
        </div>

        <!-- SECCIÓN DE ONBOARDING GRAFICA -->
        <div class="my-auto py-2 space-y-3 overflow-y-auto max-h-[50vh] sm:max-h-none no-scrollbar">
            
            <!-- Tópico 1: Rutinas personalizadas con indicador gráfico de pasos -->
            <div class="p-3.5 sm:p-4 rounded-2xl bg-white/60 dark:bg-black/30 backdrop-blur-md border border-white/80 dark:border-white/10 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="p-2.5 rounded-xl bg-[#306067]/10 text-[#306067] dark:bg-[#CCE2E5]/15 dark:text-[#CCE2E5] shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9 9 0 010-18c4.97 0 9 3.582 9 8 0 4.418-4.03 8-9 10z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v18"></path>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between mb-1">
                            <h2 class="text-xs sm:text-sm font-bold text-[#2A4043] dark:text-[#CCE2E5] truncate">Rutinas Personalizadas</h2>
                            <!-- Mini UI Gráfica: Barra de progreso de rutina -->
                            <div class="flex items-center gap-1 shrink-0">
                                <span class="w-3 h-1.5 rounded-full bg-[#306067]"></span>
                                <span class="w-3 h-1.5 rounded-full bg-[#306067]"></span>
                                <span class="w-3 h-1.5 rounded-full bg-[#306067]/30 dark:bg-[#CCE2E5]/30"></span>
                            </div>
                        </div>
                        <p class="text-[11px] sm:text-xs text-[#306067]/80 dark:text-[#E9E5E3]/80 leading-snug">
                            Secuencias de día y noche adaptadas a las necesidades reales de tu piel y cabello.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Tópico 2: Recordatorios con elemento gráfico de hora/notificación -->
            <div class="p-3.5 sm:p-4 rounded-2xl bg-white/60 dark:bg-black/30 backdrop-blur-md border border-white/80 dark:border-white/10 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="p-2.5 rounded-xl bg-[#306067]/10 text-[#306067] dark:bg-[#CCE2E5]/15 dark:text-[#CCE2E5] shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between mb-1">
                            <h2 class="text-xs sm:text-sm font-bold text-[#2A4043] dark:text-[#CCE2E5] truncate">Recordatorios Inteligentes</h2>
                            <!-- Mini UI Gráfica: Badge de notificación habilitada -->
                            <span class="text-[9px] font-bold px-1.5 py-0.5 rounded-full bg-[#306067]/15 text-[#306067] dark:bg-[#CCE2E5]/20 dark:text-[#CCE2E5] shrink-0">
                                08:00 AM • ON
                            </span>
                        </div>
                        <p class="text-[11px] sm:text-xs text-[#306067]/80 dark:text-[#E9E5E3]/80 leading-snug">
                            Alertas precisas para mantener constancia y no olvidar ningún paso de tu hábito.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Tópico 3: Seguimiento visual con minigráfico de tendencia SVG -->
            <div class="p-3.5 sm:p-4 rounded-2xl bg-white/60 dark:bg-black/30 backdrop-blur-md border border-white/80 dark:border-white/10 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="p-2.5 rounded-xl bg-[#306067]/10 text-[#306067] dark:bg-[#CCE2E5]/15 dark:text-[#CCE2E5] shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between mb-1">
                            <h2 class="text-xs sm:text-sm font-bold text-[#2A4043] dark:text-[#CCE2E5] truncate">Evolución Visual</h2>
                            <!-- Mini UI Gráfica: Minigráfico de tendencia subiendo -->
                            <svg class="w-10 h-4 text-[#306067] dark:text-[#CCE2E5] shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 40 16">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2 14 L12 10 L22 12 L38 2" />
                            </svg>
                        </div>
                        <p class="text-[11px] sm:text-xs text-[#306067]/80 dark:text-[#E9E5E3]/80 leading-snug">
                            Registra tu progreso fotográfico y evalúa la efectividad de tus productos día a día.
                        </p>
                    </div>
                </div>
            </div>

        </div>

        <!-- BOTONES (MANTENIDOS SIN CAMBIOS FUNCIONALES/ESTILO) -->
        <div class="pt-2 pb-4 shrink-0">
            <a href="{{ route('auth.login') }}"
                class="btn w-full px-5 mb-3 py-3 rounded-xl text-white font-bold transition cursor-pointer hover:bg-[#306067] disabled:opacity-80 disabled:cursor-not-allowed bg-[#306067] dark:bg-[#E9E5E3] dark:hover:bg-[#E9E5E3] dark:text-[#306067] border-none">
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