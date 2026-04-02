<x-layout :title="'Mis Rutinas'">
    <section class="h-full px-5 pt-10 bg-white rounded-t-3xl">
        <h1 class="text-2xl font-semibold text-[#306067] mb-5">Mis Rutinas</h1>

        @forelse($routines as $rutina)
            <x-routine-card :rutina="$rutina" />
        @empty
            <p class="text-[#CCE2E5]">¡No tiene rutinas todavía!</p>
        @endforelse

        {{-- Botón flotante para crear nueva rutina --}}
        <div class="fixed z-50 fab bottom-24 right-6">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                fill="#FFFF">
                <path
                    d="M440-440H240q-17 0-28.5-11.5T200-480q0-17 11.5-28.5T240-520h200v-200q0-17 11.5-28.5T480-760q17 0 28.5 11.5T520-720v200h200q17 0 28.5 11.5T760-480q0 17-11.5 28.5T720-440H520v200q0 17-11.5 28.5T480-200q-17 0-28.5-11.5T440-240v-200Z" />
            </svg>
            <a href="{{ route('routines.create') }}"
                class="bg-gradient-to-r from-[#258592] via-[#1d949c] to-[#258592] py-3 px-5 rounded-full flex items-center justify-center shadow-xl">
                <p class="text-white">
                    + Nueva Rutina
                </p>
            </a>
        </div>
</x-layout>
