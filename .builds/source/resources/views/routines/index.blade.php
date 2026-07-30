<x-layout :title="'Mis Rutinas'">
    <section class="min-h-full pb-10 px-5 pt-10 bg-white dark:bg-[#2A4043] rounded-t-3xl">
        <h1 class="text-2xl font-semibold text-[#306067] dark:text-[#CCE2E5] mb-5">Mis Rutinas</h1>

        @forelse($routines as $rutina)
            <x-routine-card :rutina="$rutina" />
        @empty
            <p class="text-[#CCE2E5]">¡No tiene rutinas todavía!</p>
        @endforelse

        {{-- Botón flotante para crear nueva rutina --}}
        @php
            $isLimited = isset($canCreate) ? !$canCreate : false;
        @endphp

        <div class="fixed z-50 fab bottom-24 right-6">
            @if($isLimited)
                <button id="createRoutineBtn"
                    class="bg-gradient-to-r from-[#258592] via-[#1d949c] to-[#258592] py-3 px-5 rounded-full flex items-center justify-center shadow-xl opacity-60 cursor-pointer"
                    type="button">
                    <p class="text-white">+ Nueva Rutina</p>
                </button>
            @else
                <a href="{{ route('routines.create') }}"
                    class="bg-gradient-to-r from-[#258592] via-[#1d949c] to-[#258592] py-3 px-5 rounded-full flex items-center justify-center shadow-xl">
                    <p class="text-white">+ Nueva Rutina</p>
                </a>
            @endif
        </div>

        {{-- Modal aviso límite para usuarios free --}}
        <div id="limitModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40">
            <div class="bg-white rounded-xl p-6 max-w-md mx-4">
                <h3 class="text-lg font-bold text-[#306067] mb-2">Límite de Rutinas alcanzado</h3>
                <p class="text-sm text-[#2A4043] mb-4">El plan Free solo permite crear hasta 2 rutinas. Para crear una nueva, elimina o edita alguna de tus rutinas existentes, o pasate al plan Premium.</p>
                <div class="flex justify-end gap-2">
                    <button id="closeLimitModal" class="px-4 py-2 rounded-xl bg-gray-200">Cerrar</button>
                    <a href="{{ route('subscription.show') }}" class="px-4 py-2 rounded-xl bg-[#306067] text-white">Ver Premium</a>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const btn = document.getElementById('createRoutineBtn');
                const modal = document.getElementById('limitModal');
                const close = document.getElementById('closeLimitModal');
                if (btn) {
                    btn.addEventListener('click', function (e) {
                        modal.classList.remove('hidden');
                        modal.classList.add('flex');
                    });
                }
                if (close) {
                    close.addEventListener('click', function () {
                        modal.classList.add('hidden');
                        modal.classList.remove('flex');
                    });
                }
            });
        </script>
</x-layout>
