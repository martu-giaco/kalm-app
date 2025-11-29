<!-- filepath: resources/views/components/layout.blade.php -->
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
    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>


<body class="d-flex flex-column min-vh-100 bg-light">
<div class="drawer drawer-end">
    <input id="my-drawer-1" type="checkbox" class="drawer-toggle hidden" />
    <div class="flex flex-col min-h-screen header-bg pt-5 drawer-content">
        <!-- HEADER: Visible solo hasta 1000px -->
        <header class="flex min-[1000px]:hidden xl:glass md:glass items-end justify-between
                    w-[95%] max-w-[1500px] mx-auto px-4 py-3
                    rounded-full
                    fixed top-3 left-1/2 -translate-x-1/2 z-50
                    transition-all duration-500 ease-in-out"
        >
            <!-- LOGO IZQUIERDA -->
            <p class="text-4xl logo-text">Kälm</p>

            <!-- BOTONES DERECHA (solo iconos) -->
            <div class="flex gap-4 text-2xl">
            <a href="{{ route('home') }}"><img src="{{ asset('images/notificaciones.svg') }}" alt="notificaciones" class="h-10 w-auto"></a>
            <label for="my-drawer-1" class="cursor-pointer avatar" aria-label="open sidebar">
                <img src="{{ asset('images/pfp.svg') }}" alt="usuario" class="h-10 w-auto rounded-full object-cover" />
            </label>
            </div>
        </header>

        <!-- Navbar -->
        <nav class="fixed z-50 flex items-center justify-evenly bg-white rounded-t-3xl shadow-[0_8px_30px_rgba(55,160,175,0.3)] p-3 w-full left-1/2 -translate-x-1/2 transition-all duration-500 ease-in-out bottom-0  pt-5 px-7 pb-7">

            <div>
                <ul class="flex flex-1 items-center space-x-6 justify-evenly">
                        <li class="flex flex-col md:flex-row items-center font-bold text-(--kälm-dark)">
                            <a class="text-[0px]" href="{{ route('home') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" height="35px" viewBox="0 -960 960 960" width="35px" fill="#306067"><path d="M151.87-202.87v-355.7q0-21.63 9.58-40.9 9.57-19.27 26.72-31.94L425.3-809.26q24.11-18.39 54.7-18.39 30.59 0 54.7 18.39l237.13 177.85q17.15 12.67 26.72 31.94 9.58 19.27 9.58 40.9v355.7q0 37.78-26.61 64.39t-64.39 26.61H607.41q-19.15 0-32.32-13.17-13.18-13.18-13.18-32.33v-199.04q0-19.16-13.17-32.33-13.17-13.17-32.33-13.17h-72.82q-19.16 0-32.33 13.17-13.17 13.17-13.17 32.33v199.04q0 19.15-13.18 32.33-13.17 13.17-32.32 13.17H242.87q-37.78 0-64.39-26.61t-26.61-64.39Z"/></svg>
                                Inicio
                            </a>
                        </li>
                        <li class="flex flex-col md:flex-row items-center font-bold text-(--kälm-dark)">
                            <a class="text-[0px]" href="{{ route('search') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" height="35px" viewBox="0 -960 960 960" width="35px" fill="#306067"><path d="M378.09-314.5q-111.16 0-188.33-77.17-77.17-77.18-77.17-188.33t77.17-188.33q77.17-77.17 188.33-77.17 111.15 0 188.32 77.17 77.18 77.18 77.18 188.33 0 44.48-13.52 83.12-13.53 38.64-36.57 68.16l222.09 222.33q12.67 12.91 12.67 31.94 0 19.04-12.91 31.71-12.68 12.67-31.83 12.67t-31.82-12.67L529.85-364.59q-29.76 23.05-68.64 36.57-38.88 13.52-83.12 13.52Zm0-91q72.84 0 123.67-50.83 50.83-50.82 50.83-123.67t-50.83-123.67q-50.83-50.83-123.67-50.83-72.85 0-123.68 50.83-50.82 50.82-50.82 123.67t50.82 123.67q50.83 50.83 123.68 50.83Z"/></svg>
                                Búsqueda
                            </a>
                        </li>
                        <li class="flex flex-col md:flex-row items-center font-bold text-(--kälm-dark)">
                            <a class="text-[0px]" href="{{ route('home') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" height="35px" viewBox="0 -960 960 960" width="35px" fill="#306067"><path d="M434.5-434.5H237.37q-19.15 0-32.33-13.17-13.17-13.18-13.17-32.33t13.17-32.33q13.18-13.17 32.33-13.17H434.5v-197.13q0-19.15 13.17-32.33 13.18-13.17 32.33-13.17t32.33 13.17q13.17 13.18 13.17 32.33v197.13h197.13q19.15 0 32.33 13.17 13.17 13.18 13.17 32.33t-13.17 32.33q-13.18 13.17-32.33 13.17H525.5v197.13q0 19.15-13.17 32.33-13.18 13.17-32.33 13.17t-32.33-13.17q-13.17-13.18-13.17-32.33V-434.5Z"/></svg>
                                Crear post
                            </a>
                        </li>
                        <li class="flex flex-col md:flex-row items-center font-bold text-(--kälm-dark)">
                            <a class="text-[0px]" href="{{ route('community') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" height="35px" viewBox="0 -960 960 960" width="35px" fill="#306067"><path d="M41.67-236.17q-19.15 0-32.32-13.18-13.18-13.17-13.18-32.32V-303q0-44.91 45.2-72.87 45.2-27.96 118.63-27.96 11.09 0 21.05.38 9.97.38 19.54 1.91-14.72 21.95-21.96 46.11-7.24 24.17-7.24 50.43v68.83H41.67Zm240 0q-19.15 0-32.32-13.18-13.18-13.17-13.18-32.32V-305q0-32.72 17.62-60.05 17.62-27.34 50.34-47.82t77.82-30.72q45.09-10.24 98.04-10.24 53.97 0 98.94 10.24 44.98 10.24 77.7 30.72 32.72 20.48 49.96 47.82 17.24 27.33 17.24 60.05v23.33q0 19.15-13.18 32.32-13.17 13.18-32.32 13.18H281.67Zm506.94 0V-305q0-27.28-6.86-51.42t-20.58-45.12q9.57-1.53 19.18-1.91 9.62-.38 19.65-.38 73.72 0 118.77 27.55 45.06 27.54 45.06 73.28v21.33q0 19.15-13.18 32.32-13.17 13.18-32.32 13.18H788.61Zm-628.59-206.7q-33.98 0-58.19-24.19-24.22-24.19-24.22-58.16 0-35 24.19-58.71 24.19-23.72 58.16-23.72 35 0 58.71 23.68 23.72 23.68 23.72 58.69 0 33.98-23.68 58.19-23.68 24.22-58.69 24.22Zm640 0q-33.98 0-58.19-24.19-24.22-24.19-24.22-58.16 0-35 24.19-58.71 24.19-23.72 58.16-23.72 35 0 58.71 23.68 23.72 23.68 23.72 58.69 0 33.98-23.68 58.19-23.68 24.22-58.69 24.22ZM480-483.59q-51.59 0-87.71-36.11-36.12-36.12-36.12-87.71 0-52.44 36.12-88.13 36.12-35.7 87.71-35.7 52.43 0 88.13 35.7 35.7 35.69 35.7 88.13 0 51.59-35.7 87.71-35.7 36.11-88.13 36.11Z"/></svg>
                                Comunidad
                            </a>
                        </li>
                        <li class="flex flex-col md:flex-row items-center font-bold text-(--kälm-dark)">
                            <a class="text-[0px]" href="{{ route('blog') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" height="35px" viewBox="0 -960 960 960" width="35px" fill="#306067"><path d="M202.87-111.87q-37.78 0-64.39-26.61t-26.61-64.39v-554.26q0-37.78 26.61-64.39t64.39-26.61h399.59q18.15 0 34.68 6.84 16.53 6.83 29.21 19.51l155.43 155.43q12.68 12.68 19.51 29.21 6.84 16.53 6.84 34.68v399.59q0 37.78-26.61 64.39t-64.39 26.61H202.87ZM593.3-757.13v118.33q0 19.15 13.18 32.32 13.17 13.18 32.32 13.18h118.33L593.3-757.13Zm48.61 475.22q17.24 0 28.98-11.86 11.74-11.86 11.74-29.1 0-17.24-11.74-28.98-11.74-11.74-28.98-11.74H318.09q-17.24 0-28.98 11.74-11.74 11.74-11.74 28.98 0 17.24 11.86 29.1 11.86 11.86 29.1 11.86h323.58ZM446.46-594.5q17.24 0 29.09-11.86 11.86-11.86 11.86-29.1 0-17.24-11.86-29.09-11.85-11.86-29.09-11.86H318.33q-17.24 0-29.1 11.86-11.86 11.85-11.86 29.09 0 17.24 11.86 29.1 11.86 11.86 29.1 11.86h128.13Zm195.21 156.41q17.24 0 29.1-11.86 11.86-11.85 11.86-29.09 0-17.24-11.86-29.1Q658.91-520 641.67-520H318.33q-17.24 0-29.1 11.86-11.86 11.86-11.86 29.1 0 17.24 11.86 29.09 11.86 11.86 29.1 11.86h323.34Z"/></svg>
                                Blog
                            </a>
                        </li>
                    @if(auth()->check() && auth()->user()->role === 'admin')
                        <li class="flex flex-col md:flex-row items-center font-bold text-(--kälm-dark)">
                            <a class="text-[0px]" href="{{ route('home') }}">Usuarios</a>
                        </li>
                    @endif
                </ul>
            </div>
        </nav>

        <!-- Contenido principal -->
        <main class="container-fluid grow py-4">
            @if (session()->has('feedback.message'))
                <div class="alert alert-{{ session()->get('feedback.type', 'success') }}">
                    {!! session()->get('feedback.message') !!}
                </div>
            @endif
            {{ $slot }}
        </main>

    </div>
</div>
</body>
</html>
