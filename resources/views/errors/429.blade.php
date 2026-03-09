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

<body class="min-h-screen text-center flex flex-col justify-end mx-auto bg-[#2A4043] p-6">

    <img class="mx-auto" src="{{ asset('images/icons/cancel.svg') }}" alt="error icon">
    <h1 class="text-white text-2xl font-semibold">No pudimos procesar tu solicitud</h1>
    <p class="text-[#CCE2E5] text-md mt-2 mb-20 pb-20">Intentelo nuevamente más tarde</p>

    <a @if(auth()->check() && auth()->user()?->role === 'admin') href="{{ route('admin.home') }}" @else href="{{ route('home') }}" @endif class="mt-20 btn hover:bg-transparent hover:border-[#CCE2E5] hover:text-[#CCE2E5] w-full inline-flex border-2 border-[#CCE2E5] text-[#CCE2E5] bg-transparent px-6 py-3 rounded-xl font-bold transition-all duration-300 items-center justify-center gap-2">Volver al inicio</a>

</body>
</html>
