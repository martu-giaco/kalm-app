<x-layout>
    <x-slot:title>Nueva Rutina</x-slot:title>

    <section class="max-w-6xl min-h-screen px-5 mx-auto bg-white dark:bg-[#2A4043] pt-7 rounded-t-3xl">
        <h1 class="text-2xl font-semibold text-[#306067] dark:text-[#CCE2E5] mb-5">Nueva Rutina</h1>

        @if ($errors->any())
            <div class="p-4 mb-6 text-sm text-red-700 border border-red-200 bg-red-50 rounded-xl">
                La información ingresada contiene errores. Por favor, revisa los campos señalados.
            </div>
        @endif

        @php
            $selectedType = $types->firstWhere('id', old('type_id'));
            $needLabelText = $selectedType && strtolower($selectedType->name) === 'haircare'
                ? 'Tipo de pelo'
                : 'Tipo de piel';
        @endphp

        <form action="{{ route('routines.store') }}" method="POST">
            @csrf

            {{-- Nombre --}}
            <div class="mb-4">
                <label for="name" class="form-label mb-2 text-[#2A4043] dark:text-[#CCE2E5]">
                    Nombre de la rutina
                </label>
                <input type="text" id="name" name="name" placeholder="Nombre de la rutina"
                    class="form-control @error('name') is-invalid @enderror w-full p-3 bg-transparent rounded-xl border-2 border-[#CCE2E5] placeholder-[#CCE2E5] focus:outline-[#37A0AF] text-md text-[#2A4043] dark:text-[#E9E5E3] dark:placeholder-[#CCE2E5]"
                    @error('name') aria-invalid="true" aria-errormessage="error-name" @enderror
                    value="{{ old('name') }}">
                @error('name')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tipo de rutina --}}
            <div class="mb-4">
                <label for="type_id" class="block mb-1 text-sm text-[#2A4043] dark:text-[#CCE2E5]">
                    Tipo de Rutina
                </label>
                <select name="type_id" id="type_id"
                    class="w-full p-3 mb-3 bg-transparent rounded-xl border-2 border-[#CCE2E5] placeholder-[#CCE2E5] focus:outline-[#37A0AF] text-md text-[#2A4043] dark:text-[#E9E5E3]">
                    <option value="">Seleccionar tipo</option>
                    @foreach ($types as $type)
                        <option value="{{ $type->id }}"
                            data-need-label="{{ strtolower($type->name) === 'haircare' ? 'tipo de pelo' : 'tipo de piel' }}"
                            {{ old('type_id') == $type->id ? 'selected' : '' }}>
                            {{ $type->name }}
                        </option>
                    @endforeach
                </select>
                @error('type_id')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Necesidad de rutina --}}
            <div class="mb-4">
                <label for="need_id" id="need_label" class="block mb-1 text-sm text-[#2A4043] dark:text-[#CCE2E5]">
                    {{ $needLabelText }}
                </label>
                <select name="need_id" id="need_id"
                    class="w-full p-3 mb-3 bg-transparent rounded-xl border-2 border-[#CCE2E5] placeholder-[#CCE2E5] focus:outline-[#37A0AF] text-md text-[#2A4043] dark:text-[#E9E5E3]">
                    <option value="" id="need_placeholder">Seleccionar {{ strtolower($needLabelText) }}</option>
                    @foreach ($routine_needs as $need)
                        <option value="{{ $need->need_id }}"
                            {{ old('need_id') == $need->need_id ? 'selected' : '' }}>
                            {{ $need->name }}
                        </option>
                    @endforeach
                </select>
                @error('need_id')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tiempo de rutina --}}
            <div class="mb-4">
                <label for="time_id" class="block mb-1 text-sm text-[#2A4043] dark:text-[#CCE2E5]">
                    Tiempo de rutina
                </label>
                <select name="time_id" id="time_id"
                    class="w-full p-3 bg-transparent rounded-xl border-2 border-[#CCE2E5] placeholder-[#CCE2E5] focus:outline-[#37A0AF] text-md text-[#2A4043] dark:text-[#E9E5E3]">
                    <option value="">Seleccionar tiempo</option>
                    @foreach ($routine_times as $time)
                        <option value="{{ $time->time_id }}"
                            {{ old('time_id') == $time->time_id ? 'selected' : '' }}>
                            {{ $time->name }}
                        </option>
                    @endforeach
                </select>
                @error('time_id')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Frecuencia de recordatorio --}}
            <div class="mb-5">
                <label for="reminder_frequency" class="block mb-2 text-sm font-medium text-[#2A4043]">
                    Frecuencia de recordatorio
                </label>
                <select name="reminder_frequency" id="reminder_frequency"
                    class="w-full p-3 bg-transparent rounded-xl border-2 border-[#CCE2E5] focus:outline-none focus:border-[#37A0AF] text-md text-[#2A4043] transition">
                    <option value="none" {{ old('reminder_frequency', 'none') == 'none' ? 'selected' : '' }}>Ninguna</option>
                    <option value="daily" {{ old('reminder_frequency') == 'daily' ? 'selected' : '' }}>Diario</option>
                    <option value="weekly" {{ old('reminder_frequency') == 'weekly' ? 'selected' : '' }}>Semanal</option>
                    <option value="every_x_days" {{ old('reminder_frequency') == 'every_x_days' ? 'selected' : '' }}>Personalizado (Cada X días)</option>
                </select>
            </div>

            {{-- Días de la semana (para frecuencia semanal) --}}
            <div id="weekly_days" class="hidden mb-5">
                <label class="block mb-2 text-sm font-medium text-[#2A4043]">Días de la semana</label>
                <div class="grid grid-cols-7 gap-2">
                    @php
                        $days = ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'];
                        $dayValues = ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'];
                        $selectedDays = old('reminder_days', []);
                    @endphp
                    @foreach ($days as $index => $day)
                        <label class="cursor-pointer">
                            <input type="checkbox" name="reminder_days[]" value="{{ $dayValues[$index] }}"
                                class="hidden peer"
                                {{ in_array($dayValues[$index], $selectedDays) ? 'checked' : '' }}>
                            <div class="py-2 text-center rounded-xl border-2 border-[#CCE2E5] text-[#2A4043] text-sm font-medium transition peer-checked:bg-[#37A0AF] peer-checked:text-white peer-checked:border-[#37A0AF]">
                                {{ $day }}
                            </div>
                        </label>
                    @endforeach
                </div>
                <p class="mt-1 text-xs text-[#2A4043]/70">Selecciona los días para recibir el recordatorio.</p>
            </div>

            {{-- Intervalo para cada X días --}}
            <div id="every_x_days" class="hidden mb-5">
                <label for="reminder_interval" class="block mb-2 text-sm font-medium text-[#2A4043]">
                    Cada cuántos días
                </label>
                <input type="number" name="reminder_interval" id="reminder_interval" min="1" max="30"
                    value="{{ old('reminder_interval', 1) }}"
                    class="w-full p-3 bg-transparent rounded-xl border-2 border-[#CCE2E5] focus:outline-none focus:border-[#37A0AF] text-md text-[#2A4043] transition">
                <p class="mt-1 text-xs text-[#2A4043]/70">Ingresa el número de días entre recordatorios (ej: 3 para cada 3 días).</p>
            </div>

            {{-- Sección de Notificaciones y Horario --}}
            <div class="p-5 mb-8 rounded-2xl border-2 border-[#CCE2E5] bg-[#CCE2E5]/20">
                <div class="flex items-center justify-between mb-4">
                    <label for="is_reminder_enabled" class="text-sm font-semibold text-[#306067] cursor-pointer">
                        Activar notificaciones para esta rutina
                    </label>
                    <input type="checkbox" id="is_reminder_enabled" name="is_reminder_enabled" value="1"
                        class="w-5 h-5 accent-[#37A0AF] rounded cursor-pointer"
                        {{ old('is_reminder_enabled') ? 'checked' : '' }}>
                </div>

                <div id="reminder_time_container" class="mt-3">
                    <label for="reminder_time" class="block mb-2 text-xs font-semibold uppercase tracking-wider text-[#2A4043]">
                        Hora del recordatorio
                    </label>
                    <input type="time" id="reminder_time" name="reminder_time"
                        class="w-full p-3 bg-white rounded-xl border-2 @error('reminder_time') border-red-400 @else border-[#CCE2E5] @enderror focus:outline-none focus:border-[#37A0AF] text-md text-[#2A4043] transition"
                        value="{{ old('reminder_time') }}">
                    @error('reminder_time')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Botón --}}
            <button type="submit"
                class="btn border-none w-full mb-10 px-5 py-3 rounded-xl text-white font-bold transition cursor-pointer disabled:opacity-80 disabled:cursor-not-allowed hover:bg-[#306067] bg-[#306067] dark:bg-[#CCE2E5] dark:text-[#2A4043]">
                Crear Rutina
            </button>

        </form>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Lógica para tipo de rutina / necesidad
            const typeSelect = document.getElementById('type_id');
            const needLabel = document.getElementById('need_label');
            const needPlaceholder = document.getElementById('need_placeholder');

            if (typeSelect && needLabel && needPlaceholder) {
                function updateNeedText() {
                    const selectedOption = typeSelect.options[typeSelect.selectedIndex];
                    const labelText = selectedOption.dataset.needLabel || 'tipo de piel';
                    const capitalized = labelText.charAt(0).toUpperCase() + labelText.slice(1);

                    needLabel.textContent = capitalized;
                    needPlaceholder.textContent = 'Seleccionar ' + labelText;
                }
                typeSelect.addEventListener('change', updateNeedText);
                updateNeedText();
            }

            // Lógica para frecuencia de recordatorio
            const frequencySelect = document.getElementById('reminder_frequency');
            const weeklyDiv = document.getElementById('weekly_days');
            const everyXDiv = document.getElementById('every_x_days');

            if (frequencySelect && weeklyDiv && everyXDiv) {
                function toggleReminderFields() {
                    weeklyDiv.classList.add('hidden');
                    everyXDiv.classList.add('hidden');

                    if (frequencySelect.value === 'weekly') {
                        weeklyDiv.classList.remove('hidden');
                    } else if (frequencySelect.value === 'every_x_days') {
                        everyXDiv.classList.remove('hidden');
                    }
                }
                frequencySelect.addEventListener('change', toggleReminderFields);
                toggleReminderFields();
            }
        });
    </script>
</x-layout>