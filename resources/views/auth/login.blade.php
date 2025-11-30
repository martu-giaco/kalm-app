<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
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
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.4.2/dist/full.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="bg-[{{ asset('images/fondo.png') }}]">
    <div class="w-2xl p-4 flex flex-col justify-around">
        <img src="{{ asset('images/logo-kalm.svg') }}" alt="logo Kälm" class="h-25 mx-auto mt-20 mb-5">
        <x-slot:title>Iniciar Sesion</x-slot:title>

        <h1 class="mb-3">Iniciar Sesión</h1>

        <form action="{{ route('auth.authenticate') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="Email" class="text-(--kälm-text) p-3 bg-transparent rounded-xl border-(--kälm-light) border-2 placeholder-(--kälm-lighter) focus:outline-(--kälm-light) text-md" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" name="password" placeholder="Contraseña" id="password" class="form-control" class="text-(--kälm-text) p-3 bg-transparent rounded-xl border-(--kälm-light) border-2 placeholder-(--kälm-lighter) focus:outline-(--kälm-light) text-md" required>
            </div>
            <input type="submit" value="Ingresar" class="btn w-full px-5 py-3 rounded-xl text-white font-bold transition cursor-pointer disabled:opacity-80 disabled:cursor-not-allowed bg-(--kälm-dark)">
            <a class="text-(--kälm-text) text-center font-bold text-sm" href="">Olvidé la contraseña</a>
        </form>
    </div>

    <div class="w-full mx-auto">
        <p class="decorated text-(--kälm-text) text-sm mb-3">No tengo cuenta</p>
        <button class="w-full border-2 border-(--kälm-dark) text-(--kälm-text) cursor-pointer bg-transparent px-6 py-3 rounded-xl font-bold transition-all duration-300 flex items-center justify-center gap-2">Crear cuenta</button>
    </div>
</body>
</html>

