<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Kälm | Register</title>
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

    <div class="flex flex-col justify-between w-full max-w-2xl min-h-screen px-6 py-10 mx-auto">

        <picture class="h-20 mx-auto mb-2">
            <source srcset="{{ asset('images/logo-kalm-light.svg') }}" media="(prefers-color-scheme: dark)"
                type="image/svg+xml" />
            <img src="{{ asset('images/logo-kalm.svg') }}" alt="logo Kälm" class="h-20 mx-auto mb-2" />
        </picture>
        <div>
            <h1 class="text-2xl font-bold text-[#2A4043] dark:text-[#CCE2E5]">Crear Cuenta</h1>

            <form action="{{ route('auth.register.store') }}" method="POST" class="space-y-4" novalidate>
                @csrf

                <div>
                    <label for="name" class="block mb-1 text-sm text-[#2A4043] dark:text-[#E9E5E3]">Nombre</label>
                    <input id="name" placeholder="Nombre" name="name" aria-label="Nombre"
                        value="{{ old('name') }}" type="text"
                        class="w-full p-3 bg-transparent rounded-xl border-2 border-[#37A0AF] placeholder-[#CCE2E5] focus:outline-[#37A0AF] text-md text-[#2A4043] dark:text-[#E9E5E3] dark:border-[#CCE2E5]"
                        required>

                    @error('name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>



                <div>
                    <label for="email" class="block mb-1 text-sm text-[#2A4043] dark:text-[#E9E5E3]">Email</label>
                    <input id="email" placeholder="Email" aria-label="email" name="email"
                        value="{{ old('email') }}" type="email"
                        class="w-full p-3 bg-transparent rounded-xl border-2 border-[#37A0AF] placeholder-[#CCE2E5] focus:outline-[#37A0AF] text-md text-[#2A4043] dark:text-[#E9E5E3] dark:border-[#CCE2E5]"
                        required>

                    @error('email')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password"
                        class="block mb-1 text-sm text-[#2A4043] dark:text-[#E9E5E3]">Contraseña</label>
                    <input id="password" placeholder="Contraseña" aria-label="Contraseña" name="password"
                        type="password"
                        class="w-full p-3 bg-transparent rounded-xl border-2 border-[#37A0AF] placeholder-[#CCE2E5] focus:outline-[#37A0AF] text-md text-[#2A4043] dark:text-[#E9E5E3] dark:border-[#CCE2E5]"
                        required>

                    @error('password')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation"
                        class="block mb-1 text-sm text-[#2A4043] dark:text-[#E9E5E3]">Repetir contraseña</label>
                    <input id="password_confirmation" placeholder="Repetir contraseña" name="password_confirmation"
                        type="password"
                        class="w-full p-3 bg-transparent rounded-xl border-2 border-[#37A0AF] placeholder-[#CCE2E5] focus:outline-[#37A0AF] text-md text-[#2A4043] dark:text-[#E9E5E3] dark:border-[#CCE2E5]"
                        required>
                </div>

                <input type="submit" value="Registrarme"
                    class="btn w-full px-5 py-3 rounded-xl text-white font-bold transition cursor-pointer hover:bg-[#306067] bg-[#306067] border-none dark:bg-[#E9E5E3] dark:text-[#306067]">
            </form>
            <!-- Botón de Google Social Login -->
            <div class="my-4">
                <a href="{{ route('auth.google.redirect') }}"
                    class="flex items-center justify-center w-full gap-3 px-5 py-3 font-bold text-gray-700 transition-all duration-200 bg-white border border-gray-300 shadow-sm hover:bg-gray-100 rounded-xl">
                    <svg class="w-5 h-5" viewBox="0 0 24 24">
                        <path fill="#4285F4"
                            d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                        <path fill="#34A853"
                            d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                        <path fill="#FBBC05"
                            d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z" />
                        <path fill="#EA4335"
                            d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z" />
                    </svg>
                    Continuar con Google
                </a>
            </div>
        </div>

        <div>
            <p class="decorated text-[#2A4043] text-sm mt-2 mb-3 dark:text-[#E9E5E3]">¿Ya tenés una cuenta?</p>

            <a href="{{ route('auth.login') }}"
                class="btn hover:bg-transparent hover:border-[#306067] hover:text-[#2A4043] w-full inline-flex border-2 border-[#306067] text-[#2A4043] bg-transparent px-6 py-3 rounded-xl font-bold transition-all duration-300 items-center justify-center gap-2 dark:text-[#E9E5E3] dark:border-[#E9E5E3]">
                Iniciar Sesión
            </a>
        </div>

    </div>

</body>

</html>
