<x-layout :title="'Mis Rutinas'">
    <section class="max-w-6xl mx-auto p-5">
        <h1 class="text-3xl font-semibold text-[#306067] mb-5">Mis Rutinas</h1>

        @forelse($routines as $rutina)
            <a href="{{ route('routines.show', $rutina) }}">
                <div class="w-full flex flex-col mb-3 bg-white px-3 py-5 rounded-lg shadow-md hover:shadow-lg transition">
                    <h2 class="text-xl font-medium text-[#306067]">{{ $rutina->name }}</h2>
                    @if($rutina->time)
                        <span class="text-[#2A4043]">
                            {{ $rutina->time }}
                        </span>
                    @endif
                </div>
            </a>
        @empty
            <p class="text-[#CCE2E5]">¡No tienes rutinas todavía!</p>
        @endforelse

        <a href="{{ route('routines.create') }}" class="fixed right-5 bottom-20 bg-[#2A4043] h-16 w-16 rounded-full flex items-center justify-center shadow-xl">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#FFFF">
                <path d="M440-440H240q-17 0-28.5-11.5T200-480q0-17 11.5-28.5T240-520h200v-200q0-17 11.5-28.5T480-760q17 0 28.5 11.5T520-720v200h200q17 0 28.5 11.5T760-480q0 17-11.5 28.5T720-440H520v200q0 17-11.5 28.5T480-200q-17 0-28.5-11.5T440-240v-200Z"/>
            </svg>
        </a>
    </section>
</x-layout>
