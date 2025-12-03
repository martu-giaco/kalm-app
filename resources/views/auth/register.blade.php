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
    <link href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.4.2/dist/full.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body class="min-h-screen bg-cover bg-center" style="background-image: url('{{ asset('images/fondo.png') }}');">

    <div class="max-w-2xl mx-auto p-6 flex flex-col justify-between min-h-screen">

        <img src="{{ asset('images/logo-kalm.svg') }}" alt="logo Kälm" class="h-24 mx-auto mt-14">

        <div>
                    <h1 class="text-2xl font-bold text-[#2A4043]">Crear una cuenta</h1>

        <form action="{{ route('auth.register.store') }}" method="POST" class="space-y-4" novalidate>
            @csrf

            <div>
                <label for="name" class="block mb-1 text-sm">Nombre y apellido</label>
                <input id="name" placeholder="Nombre" name="name" value="{{ old('name') }}" type="text"
                        class="w-full p-3 bg-transparent rounded-xl border-2 border-[#37A0AF] placeholder-[#CCE2E5] focus:outline-[#37A0AF] text-md text-[#2A4043]""
                        required>

                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block mb-1 text-sm">Email</label>
                <input id="email" placeholder="Email" name="email" value="{{ old('email') }}" type="email"
                        class="w-full p-3 bg-transparent rounded-xl border-2 border-[#37A0AF] placeholder-[#CCE2E5] focus:outline-[#37A0AF] text-md text-[#2A4043]""
                        required>

                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block mb-1 text-sm">Contraseña</label>
                <input id="password" placeholder="Contraseña" name="password" type="password"
                        class="w-full p-3 bg-transparent rounded-xl border-2 border-[#37A0AF] placeholder-[#CCE2E5] focus:outline-[#37A0AF] text-md text-[#2A4043]""
                        required>

                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block mb-1 text-sm">Repetir contraseña</label>
                <input id="password_confirmation" placeholder="Repetir contraseña" name="password_confirmation" type="password"
                        class="w-full p-3 bg-transparent rounded-xl border-2 border-[#37A0AF] placeholder-[#CCE2E5] focus:outline-[#37A0AF] text-md text-[#2A4043]""
                        required>
            </div>

            <input type="submit" value="Registrarme" class="btn w-full px-5 py-3 rounded-xl text-white font-bold transition cursor-pointer bg-[#306067]">
        </form>
        </div>

        <div>
            <p class="decorated text-[#2A4043] text-sm mt-6 mb-3">¿Ya tenés una cuenta?</p>

            <a href="{{ route('auth.login') }}"
                class="w-full inline-flex border-2 border-[#306067] text-[#2A4043] bg-transparent px-6 py-3 rounded-xl font-bold transition-all duration-300 items-center justify-center gap-2">
                Iniciar Sesión
            </a>
        </div>

    </div>

</body>
</html>
