{{-- resources/views/routines/edit.blade.php --}}
<x-layout :title="'Editar: ' . $routine->name">
    <section class="px-5 pt-10 bg-white vh rounded-t-3xl">
        <h1 class="text-2xl font-semibold mb-6 text-[#306067]">Editar Rutina</h1>    <main>
        <form action="{{ route('routines.update', $routine->routine_id) }}" method="POST">
            @csrf
            @method('PATCH')

            {{-- Nombre --}}
            <div class="mb-4">
                <label for="name" class="block mb-1 text-sm">Nombre</label>
                <input type="text" name="name" id="name" value="{{ old('name', $routine->name) }}" required
                    class="w-full p-3 mb-3 bg-transparent rounded-xl border-2 border-[#CCE2E5] placeholder-[#CCE2E5] focus:outline-[#37A0AF] text-md text-[#2A4043]">
            </div>
            {{-- Tipo de rutina --}}
            <div class="mb-4">
                <label for="type_id" class="block mb-1 text-sm">Tipo de rutina</label>
                <select name="type_id" id="type_id" required
                    class="w-full p-3 mb-3 bg-transparent rounded-xl border-2 border-[#CCE2E5] placeholder-[#CCE2E5] focus:outline-[#37A0AF] text-md text-[#2A4043]">
                    <option value="">Seleccionar tipo</option>
                    @foreach ($types as $type)
                        <option value="{{ $type->id }}"
                            {{ old('type_id', $routine->type_id) == $type->id ? 'selected' : '' }}>
                            {{ $type->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Tipo de piel de rutina --}}
            <div class="mb-4">
                <label for="need_id" class="block mb-1 text-sm">Tipo de piel</label>
                <select name="need_id" id="need_id" required
                    class="w-full p-3 mb-3 bg-transparent rounded-xl border-2 border-[#CCE2E5] placeholder-[#CCE2E5] focus:outline-[#37A0AF] text-md text-[#2A4043]">
                    <option value="">Seleccionar tipo de piel</option>
                    @foreach ($routine_needs as $need)
                        <option value="{{ $need->need_id }}"
                            {{ old('need_id', $routine->need_id) == $need->need_id ? 'selected' : '' }}>
                            {{ $need->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            {{-- Tiempo de rutina --}}
            <div class="mb-4">
                <label for="time_id" class="block mb-1 text-sm">Tiempo de rutina</label>
                <select name="time_id" id="time_id" required
                    class="w-full p-3 mb-3 bg-transparent rounded-xl border-2 border-[#CCE2E5] placeholder-[#CCE2E5] focus:outline-[#37A0AF] text-md text-[#2A4043]">
                    <option value="">Seleccionar tiempo</option>
                    @foreach ($routine_times as $time)
                        <option value="{{ $time->time_id }}"
                            {{ old('time_id', $routine->time_id) == $time->time_id ? 'selected' : '' }}>
                            {{ $time->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Frecuencia de recordatorio --}}
            <div class="mb-6">
                <label for="reminder_frequency" class="block mb-1 text-sm">Frecuencia de recordatorio</label>
                <select name="reminder_frequency" id="reminder_frequency"
                    class="w-full p-3 bg-transparent rounded-xl border-2 border-[#CCE2E5] placeholder-[#CCE2E5] focus:outline-[#37A0AF] text-md text-[#2A4043]">
                    <option value="none" {{ old('reminder_frequency', $routine->reminder_frequency ?? 'none') == 'none' ? 'selected' : '' }}>Ninguna</option>
                    <option value="daily" {{ old('reminder_frequency', $routine->reminder_frequency ?? 'none') == 'daily' ? 'selected' : '' }}>Diario</option>
                    <option value="weekly" {{ old('reminder_frequency', $routine->reminder_frequency ?? 'none') == 'weekly' ? 'selected' : '' }}>Semanal</option>
                    <option value="every_x_days" {{ old('reminder_frequency', $routine->reminder_frequency ?? 'none') == 'every_x_days' ? 'selected' : '' }}>Cada X días</option>
                </select>
            </div>

            {{-- Días de la semana (para semanal) --}}
            <div id="weekly_days" class="hidden mb-6">
                <label class="block mb-1 text-sm">Días de la semana</label>
                <div class="grid grid-cols-7 gap-2">
                    @php
                        $days = ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'];
                        $dayValues = ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'];
                        $selectedDays = old('reminder_days', json_decode($routine->reminder_days ?? '[]', true)) ?? [];
                    @endphp
                    @foreach ($days as $index => $day)
                        <label class="cursor-pointer">
                            <input type="checkbox" name="reminder_days[]" value="{{ $dayValues[$index] }}"
                                class="hidden peer"
                                {{ in_array($dayValues[$index], $selectedDays) ? 'checked' : '' }}>
                            <div class="py-2 text-center rounded-xl border border-[#CCE2E5] text-[#2A4043] transition
                                peer-checked:bg-[#37A0AF] peer-checked:text-white peer-checked:border-[#37A0AF]">
                                {{ $day }}
                            </div>
                        </label>
                    @endforeach
                </div>
                <p class="mt-1 text-xs text-[#2A4043]/70">
                    Selecciona los días para recibir el recordatorio semanal.
                </p>
            </div>

            {{-- Intervalo para cada X días --}}
            <div id="every_x_days" class="hidden mb-6">
                <label for="reminder_interval" class="block mb-1 text-sm">Cada cuántos días</label>
                <input type="number" name="reminder_interval" id="reminder_interval" min="1" max="30" value="{{ old('reminder_interval', $routine->reminder_interval ?? 1) }}"
                    class="w-full p-3 bg-transparent rounded-xl border-2 border-[#CCE2E5] placeholder-[#CCE2E5] focus:outline-[#37A0AF] text-md text-[#2A4043]">
                <p class="mt-1 text-xs text-[#2A4043]/70">
                    Ingresa el número de días entre recordatorios (ej: 3 para cada 3 días).
                </p>
            </div>

            {{-- Horario de recordatorio --}}
            <div class="mb-6">
                <label for="reminder_time" class="block mb-1 text-sm">Horario de recordatorio</label>
                <div class="relative">
                    <input
                        type="time"
                        name="reminder_time"
                        id="reminder_time"
                        value="{{ old('reminder_time', $routine->reminder_time ? $routine->reminder_time->format('H:i') : null) }}"
                        class="w-full p-3 bg-transparent rounded-xl border-2 border-[#CCE2E5] placeholder-[#CCE2E5] focus:outline-[#37A0AF] text-md text-[#2A4043]"
                    >
                    <span class="absolute right-3 top-1/2 -translate-y-1/2 text-[#306067]">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="13" r="8"/>
                            <path d="M12 9v4l2 2"/>
                            <path d="M5 3 2 6"/>
                            <path d="m22 6-3-3"/>
                        </svg>
                    </span>
                </div>
                <p class="mt-1 text-xs text-[#2A4043]/70">
                    Elige la hora a la que quieres recibir la notificación.
                </p>
            </div>

            <button type="submit"
                class="btn w-full px-5 py-3 rounded-xl text-white font-bold transition cursor-pointer disabled:opacity-80 disabled:cursor-not-allowed hover:bg-[#306067] bg-[#306067]">
                Actualizar Rutina
            </button>
        </form>
    </main>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const frequencySelect = document.getElementById('reminder_frequency');
        const weeklyDiv = document.getElementById('weekly_days');
        const everyXDiv = document.getElementById('every_x_days');

        function toggleFields() {
            weeklyDiv.classList.add('hidden');
            everyXDiv.classList.add('hidden');

            if (frequencySelect.value === 'weekly') {
                weeklyDiv.classList.remove('hidden');
            } else if (frequencySelect.value === 'every_x_days') {
                everyXDiv.classList.remove('hidden');
            }
        }

        frequencySelect.addEventListener('change', toggleFields);
        toggleFields(); // Inicial
    });
</script></x-layout>

