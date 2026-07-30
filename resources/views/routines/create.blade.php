<x-layout>
    <x-slot:title>Nueva Rutina</x-slot:title>

    <section class="max-w-6xl min-h-screen px-5 mx-auto bg-white dark:bg-[#2A4043] pt-7 rounded-t-3xl">
        <h1 class="text-2xl font-semibold text-[#306067] dark:text-[#CCE2E5] mb-5">Nueva Rutina</h1>

        @php
            $selectedType = $types->firstWhere('id', old('type_id'));
            $needLabelText =
                $selectedType && strtolower($selectedType->name) === 'haircare' ? 'Tipo de cabello' : 'Tipo de piel';
            $hasGoogleConnected = (bool) auth()->user()->google_refresh_token;
        @endphp

        <form id="routineForm" action="{{ route('routines.store') }}" method="POST">
            @csrf

            {{-- Canal predefinido obligatoriamente en Google Calendar --}}
            <input type="hidden" name="notification_channel" value="google_calendar">

            {{-- Nombre --}}
            <div class="mb-4">
                <label for="name" class="form-label mb-2 text-[#2A4043] dark:text-[#CCE2E5]">
                    Nombre de la rutina <span class="text-red-500">*</span>
                </label>
                <input type="text" id="name" name="name" placeholder="Nombre de la rutina"
                    class="form-control @error('name') border-red-400 @else border-[#CCE2E5] @enderror w-full p-3 bg-transparent rounded-xl border-2 placeholder-[#CCE2E5] focus:outline-none focus:border-[#37A0AF] text-md text-[#2A4043] dark:text-[#E9E5E3] dark:placeholder-[#CCE2E5]"
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
                    class="w-full p-3 mb-1 bg-transparent rounded-xl border-2 @error('type_id') border-red-400 @else border-[#CCE2E5] @enderror focus:outline-none focus:border-[#37A0AF] text-md text-[#2A4043] dark:text-[#E9E5E3]">
                    <option value="" class="dark:bg-[#2A4043]">Seleccionar tipo</option>
                    @foreach ($types as $type)
                        <option value="{{ $type->id }}" class="dark:bg-[#2A4043]"
                            data-need-label="{{ strtolower($type->name) === 'haircare' ? 'Tipo de cabello' : 'Tipo de piel' }}"
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
                    class="w-full p-3 mb-1 bg-transparent rounded-xl border-2 @error('need_id') border-red-400 @else border-[#CCE2E5] @enderror focus:outline-none focus:border-[#37A0AF] text-md text-[#2A4043] dark:text-[#E9E5E3]">
                    <option value="" id="need_placeholder" class="dark:bg-[#2A4043]">Seleccionar {{ strtolower($needLabelText) }}</option>
                    @foreach ($routine_needs as $need)
                        <option value="{{ $need->need_id }}" class="dark:bg-[#2A4043]" {{ old('need_id') == $need->need_id ? 'selected' : '' }}>
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
                    class="w-full p-3 bg-transparent rounded-xl border-2 @error('time_id') border-red-400 @else border-[#CCE2E5] @enderror focus:outline-none focus:border-[#37A0AF] text-md text-[#2A4043] dark:text-[#E9E5E3]">
                    <option value="" class="dark:bg-[#2A4043]">Seleccionar tiempo</option>
                    @foreach ($routine_times as $time)
                        <option value="{{ $time->time_id }}" class="dark:bg-[#2A4043]" {{ old('time_id') == $time->time_id ? 'selected' : '' }}>
                            {{ $time->name }}
                        </option>
                    @endforeach
                </select>
                @error('time_id')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- BLOQUE DE RECORDATORIOS GOOGLE CALENDAR --}}
            <div class="p-5 mb-8 rounded-2xl border-2 border-[#CCE2E5] bg-[#CCE2E5]/20 dark:bg-[#306067]/30">

                {{-- Toggle maestro --}}
                <div class="flex items-center justify-between mb-4">
                    <label for="is_reminder_enabled"
                        class="text-sm font-semibold text-[#306067] dark:text-[#CCE2E5] cursor-pointer">
                        Activar recordatorios en Google Calendar 📅
                    </label>
                    <input type="checkbox" id="is_reminder_enabled" name="is_reminder_enabled" value="1"
                        class="w-5 h-5 accent-[#37A0AF] rounded cursor-pointer"
                        {{ old('is_reminder_enabled') ? 'checked' : '' }}>
                </div>

                <div id="reminder_details" class="{{ old('is_reminder_enabled') ? '' : 'hidden' }} space-y-4">

                    @if (!$hasGoogleConnected)
                        {{-- SI NO TIENE GOOGLE CONECTADO: AVISO Y BOTÓN --}}
                        <div class="flex flex-col gap-3 p-4 border rounded-xl bg-amber-50 border-amber-200 text-amber-900">
                            <div class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-amber-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                                <div>
                                    <p class="text-sm font-bold">Conexión requerida</p>
                                    <p class="mt-1 text-xs text-amber-800">
                                        Para agendar recordatorios automáticos debés conectar tu cuenta con Google Calendar.
                                    </p>
                                </div>
                            </div>
                            @if (Route::has('auth.google.redirect'))
                                <a href="{{ route('auth.google.redirect') }}"
                                    class="inline-flex items-center justify-center gap-2 px-4 py-2.5 text-xs font-bold text-white rounded-xl bg-[#306067] hover:bg-[#254b51] transition">
                                    Conectar cuenta de Google
                                </a>
                            @endif
                        </div>
                    @else
                        {{-- SI TIENE GOOGLE CONECTADO: CAMPOS DE CONFIGURACIÓN --}}
                        <div class="flex items-center gap-2 p-3 mb-2 text-xs text-green-800 border border-green-200 rounded-xl bg-green-50">
                            <svg class="w-4 h-4 text-green-600 fill-current shrink-0" viewBox="0 0 20 20">
                                <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" />
                            </svg>
                            <span>Tu cuenta está lista. El evento de rutina se sincronizará automáticamente en Google Calendar.</span>
                        </div>

                        {{-- Frecuencia --}}
                        <div>
                            <label for="reminder_frequency"
                                class="block mb-2 text-xs font-semibold uppercase tracking-wider text-[#2A4043] dark:text-[#CCE2E5]">
                                Frecuencia de recordatorio
                            </label>
                            <select name="reminder_frequency" id="reminder_frequency"
                                class="w-full p-3 bg-white dark:bg-[#2A4043] rounded-xl border-2 @error('reminder_frequency') border-red-400 @else border-[#CCE2E5] @enderror focus:outline-none focus:border-[#37A0AF] text-md text-[#2A4043] dark:text-[#E9E5E3] transition">
                                <option value="daily" {{ old('reminder_frequency', 'daily') == 'daily' ? 'selected' : '' }}>
                                    Diario</option>
                                <option value="weekly" {{ old('reminder_frequency') == 'weekly' ? 'selected' : '' }}>
                                    Semanal</option>
                                <option value="every_x_days"
                                    {{ old('reminder_frequency') == 'every_x_days' ? 'selected' : '' }}>
                                    Personalizado (Cada X días)</option>
                            </select>
                        </div>

                        {{-- Días de la semana --}}
                        <div id="weekly_days" class="hidden">
                            <label class="block mb-2 text-xs font-semibold uppercase tracking-wider text-[#2A4043] dark:text-[#CCE2E5]">
                                Días de la semana
                            </label>
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
                                        <div
                                            class="py-2 text-center rounded-xl border-2 border-[#CCE2E5] text-[#2A4043] dark:text-[#CCE2E5] text-sm font-medium transition peer-checked:bg-[#37A0AF] peer-checked:text-white peer-checked:border-[#37A0AF]">
                                            {{ $day }}
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- Intervalo --}}
                        <div id="every_x_days" class="hidden">
                            <label for="reminder_interval"
                                class="block mb-2 text-xs font-semibold uppercase tracking-wider text-[#2A4043] dark:text-[#CCE2E5]">
                                Cada cuántos días
                            </label>
                            <input type="number" name="reminder_interval" id="reminder_interval" min="1" max="30"
                                value="{{ old('reminder_interval', 1) }}"
                                class="w-full p-3 bg-white dark:bg-[#2A4043] rounded-xl border-2 border-[#CCE2E5] text-md text-[#2A4043] dark:text-[#E9E5E3]">
                        </div>

                        {{-- Horario --}}
                        <div>
                            <label for="reminder_time"
                                class="block mb-2 text-xs font-semibold uppercase tracking-wider text-[#2A4043] dark:text-[#CCE2E5]">
                                Hora del recordatorio
                            </label>
                            <input type="time" id="reminder_time" name="reminder_time"
                                class="w-full p-3 bg-white dark:bg-[#2A4043] rounded-xl border-2 border-[#CCE2E5] text-md text-[#2A4043] dark:text-[#E9E5E3]"
                                value="{{ old('reminder_time', '08:00') }}">
                        </div>
                    @endif

                </div>
            </div>

            {{-- Botón --}}
            <button type="submit"
                class="btn border-none w-full mb-10 px-5 py-3 rounded-xl text-white font-bold transition cursor-pointer hover:bg-[#254b51] bg-[#306067] dark:bg-[#CCE2E5] dark:text-[#2A4043]">
                Crear Rutina
            </button>

        </form>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const hasGoogleConnected = @json($hasGoogleConnected);
            const typeSelect = document.getElementById('type_id');
            const needLabel = document.getElementById('need_label');
            const needPlaceholder = document.getElementById('need_placeholder');
            const reminderCheckbox = document.getElementById('is_reminder_enabled');
            const reminderDetails = document.getElementById('reminder_details');
            const frequencySelect = document.getElementById('reminder_frequency');
            const weeklyDiv = document.getElementById('weekly_days');
            const everyXDiv = document.getElementById('every_x_days');
            const reminderTime = document.getElementById('reminder_time');
            const form = document.getElementById('routineForm');

            // Cambio dinámico de etiqueta Tipo de piel / Tipo de pelo
            if (typeSelect) {
                typeSelect.addEventListener('change', function() {
                    const selectedOption = typeSelect.options[typeSelect.selectedIndex];
                    const customLabel = selectedOption ? selectedOption.getAttribute('data-need-label') : null;
                    const labelText = customLabel || 'Tipo de piel';

                    if (needLabel) needLabel.textContent = labelText;
                    if (needPlaceholder) needPlaceholder.textContent = 'Seleccionar ' + labelText.toLowerCase();
                });
            }

            function toggleWeeklyAndInterval() {
                if (!frequencySelect) return;
                const isWeekly = frequencySelect.value === 'weekly';
                const isEveryX = frequencySelect.value === 'every_x_days';

                if (weeklyDiv) weeklyDiv.classList.toggle('hidden', !isWeekly);
                if (everyXDiv) everyXDiv.classList.toggle('hidden', !isEveryX);
            }

            function toggleReminderDetails() {
                if (!reminderCheckbox || !reminderDetails) return;
                const enabled = reminderCheckbox.checked;
                reminderDetails.classList.toggle('hidden', !enabled);
                if (enabled) {
                    toggleWeeklyAndInterval();
                }
            }

            if (reminderCheckbox) {
                reminderCheckbox.addEventListener('change', toggleReminderDetails);
            }
            if (frequencySelect) {
                frequencySelect.addEventListener('change', toggleWeeklyAndInterval);
            }

            toggleReminderDetails();

            if (form) {
                form.addEventListener('submit', function(e) {
                    if (reminderCheckbox && reminderCheckbox.checked) {
                        if (!hasGoogleConnected) {
                            e.preventDefault();
                            alert('Para activar los recordatorios debés conectar tu cuenta de Google Calendar.');
                            return;
                        }

                        if (reminderTime && !reminderTime.value) {
                            e.preventDefault();
                            alert('Por favor elegí un horario para el recordatorio.');
                            return;
                        }
                    }
                });
            }
        });
    </script>
</x-layout>