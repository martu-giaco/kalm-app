<x-layout :title="'Editar Rutina: ' . $routine->name">
    <section class="max-w-4xl min-h-screen px-6 py-8 mx-auto bg-white dark:bg-[#2A4043] rounded-t-3xl">
        <h1 class="text-2xl font-semibold mb-6 text-[#306067] dark:text-[#CCE2E5]">Editar Rutina</h1>

        @if ($errors->any())
            <div class="p-4 mb-6 text-sm text-red-700 border border-red-200 bg-red-50 rounded-xl">
                La información ingresada contiene errores. Por favor, revisa los campos señalados.
            </div>
        @endif

        @php
            $shouldLockType = $shouldLockType ?? false;
            $selectedType = $shouldLockType
                ? $routine->type
                : (old('type_id') ? $types->firstWhere('id', old('type_id')) : $routine->type);
            $needLabelText =
                $selectedType && strtolower($selectedType->name) === 'haircare' ? 'Tipo de cabello' : 'Tipo de piel';
            $hasGoogleConnected = (bool) auth()->user()->google_refresh_token;
            $routineNeedDefaults = $routineNeedDefaults ?? ['piel' => null, 'cabello' => null];
            $defaultNeedId = $selectedType
                ? (strtolower($selectedType->name) === 'haircare'
                    ? $routineNeedDefaults['cabello']
                    : $routineNeedDefaults['piel'])
                : null;
            $shouldLockNeed = $selectedType && in_array(strtolower($selectedType->name), ['skincare', 'haircare']) && $defaultNeedId;
            $selectedNeedId = $shouldLockNeed ? $defaultNeedId : old('need_id', $routine->need_id ?? $defaultNeedId);
        @endphp

        <form id="editRoutineForm" action="{{ route('routines.update', $routine->getKey()) }}" method="POST">
            @csrf
            @method('PATCH')

            {{-- Canal de notificación --}}
            <input type="hidden" name="notification_channel" value="google_calendar">

            {{-- Nombre --}}
            <div class="mb-5">
                <label for="name" class="block mb-2 text-sm font-medium text-[#2A4043] dark:text-[#CCE2E5]">
                    Nombre de la rutina <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" id="name" value="{{ old('name', $routine->name) }}" required
                    class="w-full p-3 bg-transparent rounded-xl border-2 @error('name') border-red-400 @else border-[#CCE2E5] @enderror focus:outline-none focus:border-[#37A0AF] text-md text-[#2A4043] dark:text-[#E9E5E3] transition">
                @error('name')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tipo de rutina --}}
            <div class="mb-5">
                <label for="type_id" class="block mb-2 text-sm font-medium text-[#2A4043] dark:text-[#CCE2E5]">Tipo de rutina</label>
                @if ($shouldLockType && $routine->type)
                    <div
                        class="w-full p-3 bg-[#CCE2E5]/40 rounded-xl border-2 border-[#37A0AF] text-md text-[#306067] dark:text-[#CCE2E5] font-semibold">
                        {{ $routine->type->name ?? 'No especificado' }}
                    </div>
                    <input type="hidden" name="type_id" value="{{ $routine->type->getKey() }}">
                @else
                    <select name="type_id" id="type_id"
                        data-default-skin-need-id="{{ $routineNeedDefaults['piel'] }}"
                        data-default-hair-need-id="{{ $routineNeedDefaults['cabello'] }}"
                        class="w-full p-3 bg-transparent rounded-xl border-2 @error('type_id') border-red-400 @else border-[#CCE2E5] @enderror focus:outline-none focus:border-[#37A0AF] text-md text-[#2A4043] dark:text-[#E9E5E3] transition">
                        <option value="" class="dark:bg-[#2A4043]">Seleccionar tipo de rutina</option>
                        @foreach ($types as $type)
                            <option value="{{ $type->id }}" class="dark:bg-[#2A4043]"
                                data-need-label="{{ strtolower($type->name) === 'haircare' ? 'Tipo de cabello' : 'Tipo de piel' }}"
                                {{ old('type_id', $routine->type_id) == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                @endif
                @error('type_id')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Necesidad / Tipo de piel o pelo --}}
            <div class="mb-5">
                <label for="need_id" id="need_label"
                    class="block mb-2 text-sm font-medium text-[#2A4043] dark:text-[#CCE2E5]">{{ $needLabelText }}</label>
                @if ($shouldLockNeed)
                    <div class="w-full p-3 bg-[#F3F9FA] dark:bg-[#1E3238] rounded-xl border-2 border-[#CCE2E5] text-[#2A4043] dark:text-[#CCE2E5]">
                        {{ $routine_needs->firstWhere('need_id', $selectedNeedId)?->name ?? 'Seleccionado automáticamente' }}
                    </div>
                    <input type="hidden" name="need_id" value="{{ $selectedNeedId }}">
                @else
                    <select name="need_id" id="need_id"
                        class="w-full p-3 bg-transparent rounded-xl border-2 @error('need_id') border-red-400 @else border-[#CCE2E5] @enderror focus:outline-none focus:border-[#37A0AF] text-md text-[#2A4043] dark:text-[#E9E5E3] transition">
                        <option value="" id="need_placeholder" class="dark:bg-[#2A4043]">Seleccionar {{ strtolower($needLabelText) }}</option>
                        @foreach ($routine_needs as $need)
                            <option value="{{ $need->need_id }}" class="dark:bg-[#2A4043]"
                                {{ $selectedNeedId == $need->need_id ? 'selected' : '' }}>
                                {{ $need->name }}
                            </option>
                        @endforeach
                    </select>
                @endif
                @error('need_id')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tiempo de rutina --}}
            <div class="mb-5">
                <label for="time_id" class="block mb-2 text-sm font-medium text-[#2A4043] dark:text-[#CCE2E5]">Tiempo de rutina</label>
                <select name="time_id" id="time_id"
                    class="w-full p-3 bg-transparent rounded-xl border-2 @error('time_id') border-red-400 @else border-[#CCE2E5] @enderror focus:outline-none focus:border-[#37A0AF] text-md text-[#2A4043] dark:text-[#E9E5E3] transition">
                    <option value="" class="dark:bg-[#2A4043]">Selecciona un momento</option>
                    @foreach ($routine_times as $time)
                        <option value="{{ $time->time_id ?? $time->id }}" class="dark:bg-[#2A4043]"
                            {{ old('time_id', $routine->time_id) == ($time->time_id ?? $time->id) ? 'selected' : '' }}>
                            {{ $time->name }}
                        </option>
                    @endforeach
                </select>
                @error('time_id')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Recordatorio en Google Calendar --}}
            <div class="p-5 mb-6 rounded-2xl border-2 border-[#CCE2E5] bg-[#CCE2E5]/20 dark:bg-[#306067]/30">
                <div class="flex items-center justify-between mb-4">
                    <label for="is_reminder_enabled" class="text-sm font-semibold text-[#306067] dark:text-[#CCE2E5] cursor-pointer">
                        Activar recordatorios en Google Calendar 📅
                    </label>
                    <input type="checkbox" id="is_reminder_enabled" name="is_reminder_enabled" value="1"
                        class="w-5 h-5 accent-[#37A0AF] rounded cursor-pointer"
                        {{ old('is_reminder_enabled', $routine->is_reminder_enabled) ? 'checked' : '' }}>
                </div>

                <div id="notification_details_container"
                    class="{{ old('is_reminder_enabled', $routine->is_reminder_enabled) ? '' : 'hidden' }} space-y-4">

                    @if (!$hasGoogleConnected)
                        <div class="flex flex-col gap-3 p-4 border rounded-xl bg-amber-50 border-amber-200 text-amber-900">
                            <div class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-amber-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <div>
                                    <p class="text-sm font-bold">Google Calendar desconectado</p>
                                    <p class="mt-1 text-xs text-amber-800">
                                        Para poder configurar este recordatorio debés vincular tu cuenta con Google.
                                    </p>
                                </div>
                            </div>
                            @if (Route::has('auth.google.redirect'))
                                <a href="{{ route('auth.google.redirect') }}"
                                    class="inline-flex items-center justify-center gap-2 px-4 py-2.5 text-xs font-bold text-white rounded-xl bg-[#306067] hover:bg-[#254b51] transition">
                                    Conectar con Google
                                </a>
                            @endif
                        </div>
                    @else
                        <div class="flex items-center gap-2 p-3 text-xs text-green-800 border border-green-200 rounded-xl bg-green-50">
                            <svg class="w-4 h-4 text-green-600 fill-current shrink-0" viewBox="0 0 20 20">
                                <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" />
                            </svg>
                            <span>
                                @if ($routine->google_event_id)
                                    Esta rutina está sincronizada activamente con tu Google Calendar.
                                @else
                                    Al guardar, el evento se sincronizará automáticamente en Google Calendar.
                                @endif
                            </span>
                        </div>

                        {{-- Frecuencia --}}
                        <div>
                            <label for="reminder_frequency"
                                class="block mb-2 text-xs font-semibold uppercase tracking-wider text-[#2A4043] dark:text-[#CCE2E5]">
                                Frecuencia de recordatorio
                            </label>
                            <select name="reminder_frequency" id="reminder_frequency"
                                class="w-full p-3 bg-white dark:bg-[#2A4043] rounded-xl border-2 border-[#CCE2E5] focus:outline-none focus:border-[#37A0AF] text-md text-[#2A4043] dark:text-[#E9E5E3] transition">
                                <option value="daily"
                                    {{ old('reminder_frequency', $routine->reminder_frequency ?? 'daily') == 'daily' ? 'selected' : '' }}>
                                    Diario</option>
                                <option value="weekly"
                                    {{ old('reminder_frequency', $routine->reminder_frequency) == 'weekly' ? 'selected' : '' }}>
                                    Semanal</option>
                                <option value="every_x_days"
                                    {{ old('reminder_frequency', $routine->reminder_frequency) == 'every_x_days' ? 'selected' : '' }}>
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
                                    $savedDays = is_array($routine->reminder_days)
                                        ? $routine->reminder_days
                                        : json_decode($routine->reminder_days ?? '[]', true);
                                    $selectedDays = old('reminder_days', $savedDays) ?? [];
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
                                value="{{ old('reminder_interval', $routine->reminder_interval ?? 1) }}"
                                class="w-full p-3 bg-white dark:bg-[#2A4043] rounded-xl border-2 border-[#CCE2E5] text-md text-[#2A4043] dark:text-[#E9E5E3] transition">
                        </div>

                        {{-- Horario --}}
                        <div>
                            <label for="reminder_time"
                                class="block mb-2 text-xs font-semibold uppercase tracking-wider text-[#2A4043] dark:text-[#CCE2E5]">
                                Hora del recordatorio
                            </label>
                            <input type="time" id="reminder_time" name="reminder_time"
                                class="w-full p-3 bg-white dark:bg-[#2A4043] rounded-xl border-2 border-[#CCE2E5] text-md text-[#2A4043] dark:text-[#E9E5E3] transition"
                                value="{{ old('reminder_time', $routine->formatted_time) }}">
                        </div>
                    @endif

                </div>
            </div>

            {{-- Productos de la rutina --}}
            @if ($routine->assignedProducts->count() > 0)
                <div class="mb-8">
                    <h2 class="text-md font-semibold text-[#306067] dark:text-[#CCE2E5] mb-3">Productos en la rutina</h2>
                    <div class="space-y-2" id="products_list">
                        @foreach ($routine->assignedProducts as $product)
                            <x-product-card-delete :product="$product" />
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Botones de Acción --}}
            <div class="flex flex-col-reverse items-center justify-end gap-3 mb-10 md:flex-row">
                <a href="{{ route('routines.show', $routine->getKey()) }}"
                    class="w-full md:w-auto px-6 py-3 text-center border-2 border-[#CCE2E5] text-[#2A4043] dark:text-[#CCE2E5] font-semibold rounded-xl hover:bg-gray-50 dark:hover:bg-[#306067]/40 transition">
                    Cancelar
                </a>
                <button type="submit"
                    class="w-full md:w-auto px-8 py-3 bg-[#306067] hover:bg-[#254b51] text-white font-bold rounded-xl transition cursor-pointer">
                    Actualizar Rutina
                </button>
            </div>
        </form>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const hasGoogleConnected = @json($hasGoogleConnected);
            const typeSelect = document.getElementById('type_id');
            const needSelect = document.getElementById('need_id');
            const needLabel = document.getElementById('need_label');
            const needPlaceholder = document.getElementById('need_placeholder');
            const reminderCheckbox = document.getElementById('is_reminder_enabled');
            const detailsContainer = document.getElementById('notification_details_container');
            const frequencySelect = document.getElementById('reminder_frequency');
            const weeklyDiv = document.getElementById('weekly_days');
            const everyXDiv = document.getElementById('every_x_days');
            const reminderTime = document.getElementById('reminder_time');
            const form = document.getElementById('editRoutineForm');

            // Cambio dinámico de etiqueta Tipo de piel / Tipo de pelo
            const defaultSkinNeedId = typeSelect?.dataset.defaultSkinNeedId;
            const defaultHairNeedId = typeSelect?.dataset.defaultHairNeedId;
            let needTouched = false;

            const updateNeedControl = (labelText) => {
                if (!needSelect) {
                    return;
                }

                const defaultNeedId = labelText === 'Tipo de cabello' ? defaultHairNeedId : defaultSkinNeedId;
                if (defaultNeedId && !needTouched) {
                    needSelect.value = defaultNeedId;
                    needSelect.disabled = true;
                } else {
                    needSelect.disabled = false;
                }
            };

            const currentOption = typeSelect?.options[typeSelect.selectedIndex];
            const initialLabel = currentOption ? currentOption.getAttribute('data-need-label') : null;
            if (initialLabel) {
                updateNeedControl(initialLabel);
            }

            if (typeSelect) {
                typeSelect.addEventListener('change', function() {
                    const selectedOption = typeSelect.options[typeSelect.selectedIndex];
                    const customLabel = selectedOption ? selectedOption.getAttribute('data-need-label') : null;
                    const labelText = customLabel || 'Tipo de piel';

                    if (needLabel) needLabel.textContent = labelText;
                    if (needPlaceholder) needPlaceholder.textContent = 'Seleccionar ' + labelText.toLowerCase();

                    updateNeedControl(labelText);
                });
            }

            if (needSelect) {
                needSelect.addEventListener('change', function() {
                    needTouched = true;
                    needSelect.disabled = false;
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
                if (!reminderCheckbox || !detailsContainer) return;
                const enabled = reminderCheckbox.checked;
                detailsContainer.classList.toggle('hidden', !enabled);
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