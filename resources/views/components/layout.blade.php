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

<body class="d-flex flex-column min-vh-100 bg-light">
    <div class="drawer drawer-end">
        <input id="my-drawer-1" type="checkbox" class="drawer-toggle" />

        {{-- Contenedor principal del contenido, ahora sin min-h-screen --}}
        <div class="flex flex-col header-bg drawer-content">
            <header
                class="flex items-center justify-between w-full max-w-[95%] mx-auto px-4 h-16 rounded-full fixed top-3 left-1/2 -translate-x-1/2 z-50 transition-all duration-500 ease-in-out glass-effect">

                <!-- Logo -->
                <p class="text-4xl logo-text leading-none mx-3">Kälm</p>

                @auth
                    <!-- Usuario autenticado -->
                    <div class="flex items-center gap-3 h-full">
                        <!-- Notificaciones -->
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('images/notificaciones.svg') }}" alt="notificaciones" class="h-8 w-auto">
                        </a>

                        <!-- Avatar y nombre -->
                        <label for="my-drawer-1" class="flex items-center gap-2 cursor-pointer h-full"
                            aria-label="open sidebar">
                            <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('images/pfp.svg') }}"
                                alt="{{ auth()->user()->name }}" class="h-10 w-10 rounded-full object-cover">
                            <span class="hidden md:inline-block font-medium text-sm text-[#2A4043] truncate max-w-[120px]">
                                {{ \Illuminate\Support\Str::limit(auth()->user()->name, 18) }}
                            </span>
                        </label>
                    </div>
                @endauth

            </header>


            {{-- Contenedor para el padding fijo del header (para que el contenido no quede debajo) --}}
            <div class="pt-24 flex flex-col">

                <main
                    class="pt-5 fixed top-24 bottom-0 left-0 right-0 mx-auto w-screen grow rounded-t-3xl overflow-hidden overflow-y-auto">

                    @php
                        // Mensajes de feedback
                        $feedbackMessage = session('feedback.message') ?? session('status') ?? session('message') ?? null;
                        $feedbackType = session('feedback.type')
                            ?? (session('status') ? 'success' : null)
                            ?? session('type')
                            ?? 'info';
                    @endphp

                    {{-- Mostrar mensaje de feedback --}}
                    @if ($feedbackMessage)
                        <div class="mx-4 my-4">
                            <div class="rounded-xl p-4 shadow-lg
                                    @if($feedbackType === 'success') bg-green-50 text-green-800
                                    @elseif(in_array($feedbackType, ['error', 'danger'])) bg-red-50 text-red-800
                                    @elseif($feedbackType === 'warning') bg-yellow-50 text-yellow-800
                                    @else bg-blue-50 text-blue-800 @endif">
                                {!! $feedbackMessage !!}
                            </div>
                        </div>
                    @endif

                    {{-- Mostrar errores de validación --}}
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


                    {{ $slot }}

                    @auth
                        {{-- Espacio inferior para usuarios autenticados --}}
                        <div class="pb-24"></div>
                    @endauth

                </main>

            </div>

            @auth
                <nav class="fixed bottom-3 left-1/2 -translate-x-1/2 z-50 w-[95%] max-w-3xl px-5 h-16 rounded-full flex items-center justify-between

                    glass-effect
                    transition-all duration-500 ease-in-out">

                    <ul class="flex flex-1 items-center justify-evenly w-full">
                        <!-- Inicio -->
                        <li class="flex flex-col items-center font-bold text-[#306067]">
                            <a href="{{ route('home') }}" class="flex flex-col items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" height="35px" viewBox="0 -960 960 960" width="35px"
                                    fill="#306067">
                                    <path
                                        d="M151.87-202.87v-355.7q0-21.63 9.58-40.9 9.57-19.27 26.72-31.94L425.3-809.26q24.11-18.39 54.7-18.39 30.59 0 54.7 18.39l237.13 177.85q17.15 12.67 26.72 31.94 9.58 19.27 9.58 40.9v355.7q0 37.78-26.61 64.39t-64.39 26.61H607.41q-19.15 0-32.32-13.17-13.18-13.18-13.18-32.33v-199.04q0-19.16-13.17-32.33-13.17-13.17-32.33-13.17h-72.82q-19.16 0-32.33 13.17-13.17 13.17-13.17 32.33v199.04q0 19.15-13.18 32.33-13.17 13.17-32.32 13.17H242.87q-37.78 0-64.39-26.61t-26.61-64.39Z" />
                                </svg>
                                <span class="sr-only">Inicio</span>
                            </a>
                        </li>

                        <!-- Buscar -->
                        <li class="flex flex-col items-center font-bold text-[#306067]">
                            <a href="{{ route('products.search') }}" class="flex flex-col items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" height="35px" viewBox="0 -960 960 960" width="35px"
                                    fill="#306067">
                                    <path
                                        d="M378.09-314.5q-111.16 0-188.33-77.17-77.17-77.18-77.17-188.33t77.17-188.33q77.17-77.17 188.33-77.17 111.15 0 188.32 77.17 77.18 77.18 77.18 188.33 0 44.48-13.52 83.12-13.53 38.64-36.57 68.16l222.09 222.33q12.67 12.91 12.67 31.94 0 19.04-12.91 31.71-12.68 12.67-31.83 12.67t-31.82-12.67L529.85-364.59q-29.76 23.05-68.64 36.57-38.88 13.52-83.12 13.52Zm0-91q72.84 0 123.67-50.83 50.83-50.82 50.83-123.67t-50.83-123.67q-50.83-50.83-123.67-50.83-72.85 0-123.68 50.83-50.82 50.82-50.82 123.67t50.82 123.67q50.83 50.83 123.68 50.83Z" />
                                </svg>
                                <span class="sr-only">Buscar</span>
                            </a>
                        </li>

                        <!-- Crear -->
                        <li class="flex flex-col items-center font-bold text-[#306067]">
                            <a href="{{ route('posts.create') }}" class="flex flex-col items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" height="35px" viewBox="0 -960 960 960" width="35px"
                                    fill="#306067">
                                    <path
                                        d="M434.5-434.5H237.37q-19.15 0-32.33-13.17-13.17-13.18-13.17-32.33t13.17-32.33q13.18-13.17 32.33-13.17H434.5v-197.13q0-19.15 13.17-32.33 13.18-13.17 32.33-13.17t32.33 13.17q13.17 13.18 13.17 32.33v197.13h197.13q19.15 0 32.33 13.17 13.17 13.18 13.17 32.33t-13.17 32.33q-13.18 13.17-32.33 13.17H525.5v197.13q0 19.15-13.17 32.33-13.18 13.17-32.33 13.17t-32.33-13.17q-13.17-13.18-13.17-32.33V-434.5Z" />
                                </svg>
                                <span class="sr-only">Crear</span>
                            </a>
                        </li>

                        <!-- Comunidad -->
                        <li class="flex flex-col items-center font-bold text-[#306067]">
                            <a href="{{ route('community') }}" class="flex flex-col items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" height="35px" viewBox="0 -960 960 960" width="35px"
                                    fill="#306067">
                                    <path
                                        d="M41.67-236.17q-19.15 0-32.32-13.18-13.18-13.17-13.18-32.32V-303q0-44.91 45.2-72.87 45.2-27.96 118.63-27.96 11.09 0 21.05.38 9.97.38 19.54 1.91-14.72 21.95-21.96 46.11-7.24 24.17-7.24 50.43v68.83H41.67Zm240 0q-19.15 0-32.32-13.18-13.18-13.17-13.18-32.32V-305q0-32.72 17.62-60.05 17.62-27.34 50.34-47.82t77.82-30.72q45.09-10.24 98.04-10.24 53.97 0 98.94 10.24 44.98 10.24 77.7 30.72 32.72 20.48 49.96 47.82 17.24 27.33 17.24 60.05v23.33q0 19.15-13.18 32.32-13.17 13.18-32.32 13.18H281.67Zm506.94 0V-305q0-27.28-6.86-51.42t-20.58-45.12q9.57-1.53 19.18-1.91 9.62-.38 19.65-.38 73.72 0 118.77 27.55 45.06 27.54 45.06 73.28v21.33q0 19.15-13.18 32.32-13.17 13.18-32.32 13.18H788.61Zm-628.59-206.7q-33.98 0-58.19-24.19-24.22-24.19-24.22-58.16 0-35 24.19-58.71 24.19-23.72 58.16-23.72 35 0 58.71 23.68 23.72 23.68 23.72 58.69 0 33.98-23.68 58.19-23.68 24.22-58.69 24.22ZM480-483.59q-51.59 0-87.71-36.11-36.12-36.12-36.12-87.71 0-52.44 36.12-88.13 36.12-35.7 87.71-35.7 52.43 0 88.13 35.7 35.7 35.69 35.7 88.13 0 51.59-35.7 87.71-35.7 36.11-88.13 36.11Z" />
                                </svg>
                                <span class="sr-only">Comunidad</span>
                            </a>
                        </li>

                        <!-- Blog -->
                        <li class="flex flex-col items-center font-bold text-[#306067]">
                            <a href="{{ route('blog') }}" class="flex flex-col items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" height="35px" viewBox="0 -960 960 960" width="35px"
                                    fill="#306067">
                                    <path
                                        d="M202.87-111.87q-37.78 0-64.39-26.61t-26.61-64.39v-554.26q0-37.78 26.61-64.39t64.39-26.61h399.59q18.15 0 34.68 6.84 16.53 6.83 29.21 19.51l155.43 155.43q12.68 12.68 19.51 29.21 6.84 16.53 6.84 34.68v399.59q0 37.78-26.61 64.39t-64.39 26.61H202.87ZM593.3-757.13v118.33q0 19.15 13.18 32.32 13.17 13.18 32.32 13.18h118.33L593.3-757.13Zm48.61 475.22q17.24 0 28.98-11.86 11.74-11.86 11.74-29.1 0-17.24-11.74-28.98-11.74-11.74-28.98-11.74H318.09q-17.24 0-28.98 11.74-11.74 11.74-11.74 28.98 0 17.24 11.86 29.1 11.86 11.86 29.1 11.86h323.58ZM446.46-594.5q17.24 0 29.09-11.86 11.86-11.86 11.86-29.1 0-17.24-11.86-29.09-11.85-11.86-29.09-11.86H318.33q-17.24 0-29.1 11.86-11.86 11.85-11.86 29.09 0 17.24 11.86 29.1 11.86 11.86 29.1 11.86h128.13Zm195.21 156.41q17.24 0 29.1-11.86 11.86-11.85 11.86-29.09 0-17.24-11.86-29.1Q658.91-520 641.67-520H318.33q-17.24 0-29.1 11.86-11.86 11.86-11.86 29.1 0 17.24 11.86 29.09 11.86 11.86 29.1 11.86h323.34Z" />
                                </svg>
                                <span class="sr-only">Blog</span>
                            </a>
                        </li>

                        <!-- Admin -->
                        @if(auth()->check() && auth()->user()->role === 'admin')
                            <li class="flex flex-col items-center font-bold text-[#306067]">
                                <a href="{{ route('admin.users.index') }}" class="flex flex-col items-center">
                                    Usuarios
                                </a>
                            </li>
                        @endif
                    </ul>
                </nav>

            @endauth
        </div>

        <div class="drawer-side z-50">
            <label for="my-drawer-1" aria-label="close sidebar" class="drawer-overlay"></label>
            <div class="menu bg-white min-h-full w-80 p-0 rounded-l-3xl flex flex-col justify-between">
                @auth
                        <div>
                            <div class="flex flex-col border-b p-5 pt-5 border-[#CCE2E5]">
                                <div class="flex justify-between">
                                    <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full
                                                                        @if(auth()->user()->role === 'admin') bg-red-500 text-white
                                                                        @elseif(auth()->user()->role === 'premium') bg-green-500 text-white
                                                                        @else bg-gray-300 text-gray-800 @endif">
                                        {{ ucfirst(auth()->user()->role) }}
                                    </span>
                                    <label for="my-drawer-1" class="self-end cursor-pointer" aria-label="close sidebar">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" viewBox="0 -960 960 960"
                                            fill="#2A4043" aria-hidden="true">
                                            <path
                                                d="M480-424 284-228q-11 11-28 11t-28-11q-11-11-11-28t11-28l196-196-196-196q-11-11-11-28t11-28q11-11 28-11t28 11l196 196 196-196q11-11 28-11t28 11q11 11 11 28t-11 28L536-480l196 196q11 11 11 28t-11 28q-11 11-28 11t-28-11L480-424Z" />
                                        </svg>
                                    </label>
                                </div>

                                <div class="flex justify-between mt-4 items-center">
                                    <div>
                                        <p class="text-md text-[#37A0AF]">Hola,</p>
                                        <h2 class="text-4xl text-[#306067]">{{ auth()->user()->name }}</h2>
                                    </div>

                                    <a href="{{ route('profile.show') }}">
                                        <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('images/pfp.svg') }}"
                                            alt="{{ auth()->user()->username }}" class="h-14 w-14 rounded-full object-cover">
                                    </a>
                                </div>

                                <div class="flex justify-between text-[#37A0AF] mt-2">
                                    <p>{{ '@' . (auth()->user()->username) }}
                                    </p>
                                    <p>{{ auth()->user()->followers_count ?? '0' }} seguidores</p>
                                </div>
                            </div>

                            <ul class="p-3 gap-3">
                                <li>
                                    <a class="flex flex-row text-lg text-[#2A4043] w-full justify-between items-center hover:bg-transparent"
                                        href="{{ route('profile.show') }}">
                                        Mi Perfil
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                            width="24px" fill="#306067" class="p-0">
                                            <path
                                                d="M480-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM160-240v-32q0-34 17.5-62.5T224-378q62-31 126-46.5T480-440q66 0 130 15.5T736-378q29 15 46.5 43.5T800-272v32q0 33-23.5 56.5T720-160H240q-33 0-56.5-23.5T160-240Z" />
                                        </svg>
                                    </a>
                                </li>

                                <li>
                                    <a class="flex flex-row text-lg text-[#2A4043] w-full justify-between items-center hover:bg-transparent"
                                        href="{{ route('tests.index') }}">
                                        Tests
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                            width="24px" fill="#306067" class="p-0">
                                            <path
                                                d="M200-120q-51 0-72.5-45.5T138-250l222-270v-240h-40q-17 0-28.5-11.5T280-800q0-17 11.5-28.5T320-840h320q17 0 28.5 11.5T680-800q0 17-11.5 28.5T640-760h-40v240l222 270q32 39 10.5 84.5T760-120H200Zm80-120h400L544-400H416L280-240Z" />
                                        </svg>
                                    </a>
                                </li>

                                <li>
                                    <a class="flex flex-row text-lg text-[#2A4043] w-full justify-between items-center hover:bg-transparent"
                                        href="{{ route('home') }}">
                                        Mis Resultados
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                            width="24px" fill="#306067" class="p-0">
                                            <path
                                                d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h168q13-36 43.5-58t68.5-22q38 0 68.5 22t43.5 58h168q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm120-160h200q17 0 28.5-11.5T560-320q0-17-11.5-28.5T520-360H320q-17 0-28.5 11.5T280-320q0 17 11.5 28.5T320-280Zm0-160h320q17 0 28.5-11.5T680-480q0-17-11.5-28.5T640-520H320q-17 0-28.5 11.5T280-480q0 17 11.5 28.5T320-440Zm0-160h320q17 0 28.5-11.5T680-640q0-17-11.5-28.5T640-680H320q-17 0-28.5 11.5T280-640q0 17 11.5 28.5T320-600Zm160-190q13 0 21.5-8.5T510-820q0-13-8.5-21.5T480-850q-13 0-21.5 8.5T450-820q0 13 8.5 21.5T480-790Z" />
                                        </svg>
                                    </a>
                                </li>

                                <li>
                                    <a class="flex flex-row text-lg text-[#2A4043] w-full justify-between items-center hover:bg-transparent"
                                        href="{{ route('favorites') }}">
                                        Favoritos
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                            width="24px" fill="#306067" class="p-0">
                                            <path
                                                d="M480-147q-14 0-28.5-5T426-168l-69-63q-106-97-191.5-192.5T80-634q0-94 63-157t157-63q53 0 100 22.5t80 61.5q33-39 80-61.5T660-854q94 0 157 63t63 157q0 115-85 211T602-230l-68 62q-11 11-25.5 16t-28.5 5Z" />
                                        </svg>
                                    </a>
                                </li>

                                <li>
                                    <a class="flex flex-row text-lg text-[#2A4043] w-full justify-between items-center hover:bg-transparent"
                                        href="{{ route('home') }}">
                                        Configuración
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                            width="24px" fill="#306067" class="p-0">
                                            <path
                                                d="M433-80q-27 0-46.5-18T363-142l-9-66q-13-5-24.5-12T307-235l-62 26q-25 11-50 2t-39-32l-47-82q-14-23-8-49t27-43l53-40q-1-7-1-13.5v-27q0-6.5 1-13.5l-53-40q-21-17-27-43t8-49l47-82q14-23 39-32t50 2l62 26q11-8 23-15t24-12l9-66q4-26 23.5-44t46.5-18h94q27 0 46.5 18t23.5 44l9 66q13 5 24.5 12t22.5 15l62-26q25-11 50-2t39 32l47 82q14 23 8 49t-27 43l-53 40q1 7 1 13.5v27q0 6.5-2 13.5l53 40q21 17 27 43t-8 49l-48 82q-14 23-39 32t-50-2l-60-26q-11 8-23 15t-24 12l-9 66q-4 26-23.5 44T527-80h-94Zm49-260q58 0 99-41t41-99q0-58-41-99t-99-41q-59 0-99.5 41T342-480q0 58 40.5 99t99.5 41Z" />
                                        </svg>
                                    </a>
                                </li>

                                <li>
                                    <a class="flex flex-row text-lg text-[#2A4043] w-full justify-between items-center hover:bg-transparent"
                                        href="{{ route('home') }}">
                                        Ayuda
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                            width="24px" fill="#306067" class="p-0">
                                            <path
                                                d="M470-200h-10q-142 0-241-99t-99-241q0-142 99-241t241-99q71 0 132.5 26.5t108 73q46.5 46.5 73 108T800-540q0 134-75.5 249T534-111q-10 5-20 5.5t-18-4.5q-8-5-14-13t-7-19l-5-58Zm-11-121q17 0 29-12t12-29q0-17-12-29t-29-12q-17 0-29 12t-12 29q0 17 12 29t29 12Zm-87-304q11 5 22 .5t18-14.5q9-12 21-18.5t27-6.5q24 0 39 13.5t15 34.5q0 13-7.5 26T480-558q-25 22-37 41.5T431-477q0 12 8.5 20.5T460-448q12 0 20-9t12-21q5-17 18-31t24-25q21-21 31.5-42t10.5-42q0-46-31.5-74T460-720q-32 0-59 15.5T357-662q-6 11-1.5 21.5T372-625Z" />
                                        </svg>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <ul class="p-3 gap-3">
                            <li>
                                <a class="flex flex-row text-lg text-[#2A4043] w-full justify-between items-center hover:bg-transparent"
                                    href="{{ route('home') }}">
                                    Sobre Kälm
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                                        fill="#306067">
                                        <path
                                            d="M480-280q17 0 28.5-11.5T520-320v-160q0-17-11.5-28.5T480-520q-17 0-28.5 11.5T440-480v160q0 17 11.5 28.5T480-280Zm0-320q17 0 28.5-11.5T520-640q0-17-11.5-28.5T480-680q-17 0-28.5 11.5T440-640q0 17 11.5 28.5T480-600Zm0 520q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Z" />
                                    </svg>
                                </a>
                            </li>

                            <li>
                                <form action="{{ route('auth.logout') }}" method="POST" class="w-full flex justify-between">
                                    @csrf
                                    <button type="submit"
                                        class="flex flex-row text-lg text-[#2A4043] w-full justify-between items-center hover:bg-transparent">
                                        Cerrar sesión
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                            width="24px" fill="#306067" class="ml-2">
                                            <path
                                                d="M200-480q0 106 69 185t174 93q16 2 26.5 14t10.5 28q0 17-14.5 28t-32.5 9q-135-17-224-118.5T120-480q0-136 88.5-237.5T432-837q19-2 33.5 8.5T480-800q0 16-10.5 28T443-758q-105 14-174 93t-69 185Zm487 40H400q-17 0-28.5-11.5T360-480q0-17 11.5-28.5T400-520h287l-75-75q-12-12-12-28.5t12-28.5q12 12 28 12t28 12l144 144q12 12 12 28t-12 28L668-308q-12 12-28 11.5T612-309q-12-12-12-28t12-28l75-75Z" />
                                        </svg>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>

                @else
                <div class="p-5 pt-10 border-b">
                    <h2 class="text-2xl">Bienvenido</h2>
                    <p class="text-sm">Inicia sesión o creá una cuenta</p>
                    <div class="mt-4 flex gap-3">
                        <a href="{{ route('auth.login') }}" class="btn btn-ghost">Ingresar</a>
                        <a href="{{ route('auth.register') }}" class="btn">Registrarse</a>
                    </div>
                </div>

                <ul class="p-4">
                    <li><a href="{{ route('home') }}">Inicio</a></li>
                    <li><a href="{{ route('blog') }}">Blog</a></li>
                </ul>
            @endauth
        </div>
    </div>
    </div>
</body>

</html>
