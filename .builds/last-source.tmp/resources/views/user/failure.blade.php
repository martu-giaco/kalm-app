<x-layout>
    @slot('title', 'Pago Rechazado - Kälm')

    <div class="max-w-md mx-auto px-4 py-8 text-center flex flex-col items-center justify-center min-h-[75vh]">
        
        <!-- Icono de Error -->
        <div class="flex items-center justify-center w-24 h-24 mb-6 border border-red-200 rounded-full bg-red-50">
            <svg xmlns="http://www.w3.org/2000/svg" height="44px" viewBox="0 -960 960 960" width="44px" fill="#741919">
                <path d="m336-280 144-144 144 144 56-56-144-144 144-144-56-56-144 144-144-144-56 56 144 144-144 144 56 56ZM480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Z"/>
            </svg>
        </div>

        <h1 class="text-2xl font-extrabold text-[#2A4043] tracking-tight">No pudimos procesar tu pago</h1>
        <p class="max-w-sm mx-auto mt-2 text-sm text-gray-600">
            Mercado Pago nos informó que la operación fue rechazada o cancelada. Por favor, verificá los datos de tu tarjeta o el saldo disponible e intentalo nuevamente.
        </p>

        <!-- Sugerencias de solución -->
        <div class="w-full p-4 mt-6 text-left border border-red-100 bg-red-50 rounded-2xl">
            <h2 class="text-xs font-bold text-[#741919] uppercase tracking-wider mb-2">Sugerencias:</h2>
            <ul class="pl-4 space-y-1 text-xs text-red-900 list-disc">
                <li>Comprobá que el límite de compra de tu tarjeta sea suficiente.</li>
                <li>Asegurá que los datos de seguridad dinámicos o CVC ingresados sean correctos.</li>
                <li>También podés intentar abonar mediante Dinero en Cuenta de Mercado Pago.</li>
            </ul>
        </div>

        <!-- Acciones de reintento -->
        <div class="flex flex-col w-full gap-2 mt-8">
            <a href="{{ route('subscription.show') }}" class="btn w-full border-0 rounded-xl text-white font-bold bg-[#306067] hover:bg-[#2A4043]">
                Reintentar Pago
            </a>
            <a href="{{ route('home') }}" class="w-full text-sm font-semibold text-gray-500 btn btn-ghost rounded-xl">
                Volver al inicio
            </a>
        </div>
    </div>
</x-layout>