<x-layout>
    @slot('title', 'Pago Pendiente - Kälm')

    <div class="max-w-md mx-auto px-4 py-8 text-center flex flex-col items-center justify-center min-h-[75vh]">
        
        <!-- Icono de Pendiente / Espera -->
        <div class="flex items-center justify-center w-24 h-24 mb-6 border border-yellow-200 rounded-full bg-yellow-50">
            <svg xmlns="http://www.w3.org/2000/svg" height="44px" viewBox="0 -960 960 960" width="44px" fill="#A17A08">
                <path d="m160-800 320 320 320-320H160Zm0 640v-453l274 274q23 23 56 23t56-23l274-274v453H160Zm0 80q-33 0-56.5-23.5T80-160v-640q0-33 23.5-56.5T160-880h640q33 0 56.5 23.5T880-800v640q0 33-23.5 56.5T800-80H160Z"/>
            </svg>
        </div>

        <h1 class="text-2xl font-extrabold text-[#2A4043] tracking-tight">Tu pago se encuentra en proceso</h1>
        <p class="max-w-sm mx-auto mt-2 text-sm text-gray-600">
            Mercado Pago está validando la transacción. Si pagaste a través de un cupón físico (Rapipago/Pago Fácil), recordá que la acreditación puede demorar hasta 24 a 48 horas hábiles.
        </p>

        <div class="w-full p-4 mt-6 text-left border border-yellow-100 bg-yellow-50/50 rounded-2xl">
            <p class="text-xs leading-relaxed text-yellow-900">
                <strong>¿Qué pasa ahora?</strong> Te enviaremos una notificación interna y un correo electrónico en cuanto tu plan **Kälm Premium** sea activado automáticamente por el sistema[cite: 2, 3]. No es necesario que vuelvas a intentar realizar el pago.
            </p>
        </div>

        <div class="w-full mt-8">
            <a href="{{ route('home') }}" class="btn w-full border-0 rounded-xl text-white font-bold bg-[#306067] hover:bg-[#2A4043]">
                Entendido, ir al inicio
            </a>
        </div>
    </div>
</x-layout>