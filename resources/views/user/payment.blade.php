<x-layout :title="'Método de pago'">

    <div class="w-full max-w-md px-6 py-10 mx-auto">
        <h1 class="text-2xl font-bold text-[#306067] text-start mb-6">Método de pago</h1>

        {{-- Feedback --}}
        @php
            $feedbackMessage = session('feedback.message') ?? (session('status') ?? (session('message') ?? null));
            $feedbackType = session('feedback.type') ?? ((session('status') ? 'success' : null) ?? (session('type') ?? 'info'));
        @endphp

        @if ($feedbackMessage)
            <div
                class="mb-4 p-4 rounded-xl shadow-lg
                    @if ($feedbackType === 'success') bg-green-50 text-green-800
                    @elseif(in_array($feedbackType, ['error', 'danger'])) bg-red-50 text-red-800
                    @elseif($feedbackType === 'warning') bg-yellow-50 text-yellow-800
                    @else bg-blue-50 text-blue-800 @endif">
                {{ $feedbackMessage }}
            </div>
        @endif

        @if ($errors->any())
            <div class="p-4 mb-4 text-red-800 shadow-lg rounded-xl bg-red-50">
                <ul class="pl-5 list-disc">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Formulario de tarjeta --}}
        <form action="{{ route('payment.process') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="titular" class="block mb-1 text-sm text-[#306067]">Titular de la tarjeta</label>
                <input id="titular" name="titular" type="text" placeholder="Apellido Nombre"
                    class="w-full p-3 rounded-xl border-2 border-[#CCE2E5] text-[#306067] placeholder-[#A0C1C5] focus:outline-none focus:border-[#37A0AF]"
                    required>
            </div>

            <div>
                <label for="numero" class="block mb-1 text-sm text-[#306067]">Número de la tarjeta</label>
                <input id="numero" name="numero" type="text" inputmode="numeric" pattern="\d{15,19}" minlength="15"
                    placeholder="XXXX XXXX XXXX XXXX"
                    class="w-full p-3 rounded-xl border-2 border-[#CCE2E5] text-[#306067] placeholder-[#A0C1C5] focus:outline-none focus:border-[#37A0AF]"
                    required>
            </div>

            <div class="flex gap-4">
                <div class="flex-1">
                    <label for="vto" class="block mb-1 text-sm text-[#306067]">Vencimiento</label>
                    <input id="vto" name="vto" type="month" min="{{ date('Y-m') }}"
                        class="w-full p-3 rounded-xl border-2 border-[#CCE2E5] text-[#306067] placeholder-[#A0C1C5] focus:outline-none focus:border-[#37A0AF]"
                        required>
                </div>
                <div class="flex-1">
                    <label for="cvc" class="block mb-1 text-sm text-[#306067]">CVC</label>
                    <input id="cvc" name="cvc" type="text" inputmode="numeric" pattern="\d{3,4}" maxlength="4"
                        placeholder="XXX"
                        class="w-full p-3 rounded-xl border-2 border-[#CCE2E5] text-[#306067] placeholder-[#A0C1C5] focus:outline-none focus:border-[#37A0AF]"
                        required>
                </div>
            </div>

            {{-- Botones de pago --}}
            <div class="mt-6 space-y-3">
                <button type="submit"
                    class="w-full py-3 rounded-xl bg-[#306067] text-white font-bold text-md hover:bg-[#255055] transition">
                    Pagar con tarjeta
                </button>

                <a href="{{ route('payment.mercadopago') }}"
                    class="w-full py-3 rounded-xl border-2 border-[#306067] text-[#306067] text-center font-bold hover:bg-[#E0F0F2] transition block">
                    Pagar con MercadoPago
                </a>

                <a href="{{ route('home') }}"
                    class="block w-full py-3 font-bold text-center text-gray-600 transition border-2 border-gray-300 rounded-xl hover:bg-gray-100">
                    Cancelar
                </a>
            </div>

            <p class="text-[#306067] text-xs text-center mt-3">Esta suscripción se puede cancelar en cualquier momento.</p>
        </form>
    </div>

</x-layout>
