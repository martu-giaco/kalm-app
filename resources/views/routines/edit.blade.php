<x-layout :title="'Editar: ' . $routine->name">
    <section class="max-w-4xl min-h-screen px-6 py-8 mx-auto bg-white shadow-sm rounded-t-3xl">
        <h1 class="text-2xl font-semibold mb-6 text-[#306067]">Editar Rutina</h1>

        @if ($errors->any())
            <div class="p-4 mb-6 text-sm text-red-700 border border-red-200 bg-red-50 rounded-xl">
                La información ingresada contiene errores. Por favor, revisa los campos señalados.
            </div>
        @endif

        @php
            $selectedType = null;
            if (old('type_id')) {
                $selectedType = $types->firstWhere('id', old('type_id'));
            } elseif ($routine->type) {
                $selectedType = $routine->type;
            }
            $needLabelText = $selectedType && strtolower($selectedType->name) === 'haircare'
                ? 'Tipo de pelo'
                : 'Tipo de piel';
        @endphp

        <form action="{{ route('routines.update', $routine->routine_id) }}" method="POST">
            @csrf
            @method('PATCH')

            {{-- Nombre --}}
            <div class="mb-5">
                <label for="name" class="block mb-2 text-sm font-medium text-[#2A4043]">
                    Nombre de la rutina <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" id="name" value="{{ old('name', $routine->name) }}" required
                    class="w-full p-3 bg-transparent rounded-xl border-2 @error('name') border-red-400 @else border-[#CCE2E5] @enderror focus:outline-none focus:border-[#37A0AF] text-md text-[#2A4043] transition">
                @error('name')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tipo de rutina --}}
            <div class="mb-5">
                <label for="type_id" class="block mb-2 text-sm font-medium text-[#2A4043]">Tipo de rutina</label>
                @if ($isFromRecommended && $routine->type_id)
                    <div class="w-full p-3 bg-[#CCE2E5]/40 rounded-xl border-2 border-[#37A0AF] text-md text-[#306067] font-semibold">
                        {{ $routine->type?->name ?? 'No especificado' }}
                    </div>
                    <input type="hidden" name="type_id" value="{{ $routine->type_id }}">
                    <p class="mt-1 text-xs text-[#37A0AF]">Esta es una rutina predeterminada. El tipo se asignó automáticamente.</p>
                @else
                    <select name="type_id" id="type_id"
                        class="w-full p-3 bg-transparent rounded-xl border-2 @error('type_id') border-red-400 @else border-[#CCE2E5] @enderror focus:outline-none focus:border-[#37A0AF] text-md text-[#2A4043] transition">
                        <option value="">Seleccionar tipo de rutina</option>
                        @foreach ($types as $type)
                            <option value="{{ $type->id }}"
                                data-need-label="{{ strtolower($type->name) === 'haircare' ? 'tipo de pelo' : 'tipo de piel' }}"
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
                <label for="need_id" id="need_label" class="block mb-2 text-sm font-medium text-[#2A4043]">{{ $needLabelText }}</label>
                <select name="need_id" id="need_id"
                    class="w-full p-3 bg-transparent rounded-xl border-2 @error('need_id') border-red-400 @else border-[#CCE2E5] @enderror focus:outline-none focus:border-[#37A0AF] text-md text-[#2A4043] transition">
                    <option value="" id="need_placeholder">Seleccionar {{ strtolower($needLabelText) }}</option>
                    @foreach ($routine_needs as $need)
                        <option value="{{ $need->need_id }}"
                            {{ old('need_id', $routine->need_id) == $need->need_id ? 'selected' : '' }}>
                            {{ $need->name }}
                        </option>
                    @endforeach
                </select>
                @error('need_id')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tiempo de rutina --}}
            <div class="mb-5">
                <label for="time_id" class="block mb-2 text-sm font-medium text-[#2A4043]">Tiempo de rutina</label>
                <select name="time_id" id="time_id"
                    class="w-full p-3 bg-transparent rounded-xl border-2 @error('time_id') border-red-400 @else border-[#CCE2E5] @enderror focus:outline-none focus:border-[#37A0AF] text-md text-[#2A4043] transition">
                    <option value="">Seleccionar tiempo</option>
                    @foreach ($routine_times as $time)
                        <option value="{{ $time->time_id }}"
                            {{ old('time_id', $routine->time_id) == $time->time_id ? 'selected' : '' }}>
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
                <label for="reminder_frequency" class="block mb-2 text-sm font-medium text-[#2A4043]">Frecuencia de recordatorio</label>
                <select name="reminder_frequency" id="reminder_frequency"
                    class="w-full p-3 bg-transparent rounded-xl border-2 border-[#CCE2E5] focus:outline-none focus:border-[#37A0AF] text-md text-[#2A4043] transition">
                    <option value="none"
                        {{ old('reminder_frequency', $routine->reminder_frequency ?? 'none') == 'none' ? 'selected' : '' }}>
                        Ninguna</option>
                    <option value="daily"
                        {{ old('reminder_frequency', $routine->reminder_frequency ?? 'none') == 'daily' ? 'selected' : '' }}>
                        Diario</option>
                    <option value="weekly"
                        {{ old('reminder_frequency', $routine->reminder_frequency ?? 'none') == 'weekly' ? 'selected' : '' }}>
                        Semanal</option>
                    <option value="every_x_days"
                        {{ old('reminder_frequency', $routine->reminder_frequency ?? 'none') == 'every_x_days' ? 'selected' : '' }}>
                        Personalizado (Cada X días)</option>
                </select>
            </div>

            {{-- Días de la semana (para semanal) --}}
            <div id="weekly_days" class="hidden mb-5">
                <label class="block mb-2 text-sm font-medium text-[#2A4043]">Días de la semana</label>
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
                            <div class="py-2 text-center rounded-xl border-2 border-[#CCE2E5] text-[#2A4043] text-sm font-medium transition peer-checked:bg-[#37A0AF] peer-checked:text-white peer-checked:border-[#37A0AF]">
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
            <div id="every_x_days" class="hidden mb-5">
                <label for="reminder_interval" class="block mb-2 text-sm font-medium text-[#2A4043]">Cada cuántos días</label>
                <input type="number" name="reminder_interval" id="reminder_interval" min="1" max="30"
                    value="{{ old('reminder_interval', $routine->reminder_interval ?? 1) }}"
                    class="w-full p-3 bg-transparent rounded-xl border-2 border-[#CCE2E5] focus:outline-none focus:border-[#37A0AF] text-md text-[#2A4043] transition">
                <p class="mt-1 text-xs text-[#2A4043]/70">
                    Ingresa el número de días entre recordatorios (ej: 3 para cada 3 días).
                </p>
            </div>

            {{-- Recordatorio y Notificaciones --}}
            <div class="p-5 mb-6 rounded-2xl border-2 border-[#CCE2E5] bg-[#CCE2E5]/20">
                <div class="flex items-center justify-between mb-4">
                    <label for="is_reminder_enabled" class="text-sm font-semibold text-[#306067] cursor-pointer">
                        Activar notificaciones para esta rutina
                    </label>
                    <input type="checkbox" id="is_reminder_enabled" name="is_reminder_enabled" value="1"
                        class="w-5 h-5 accent-[#37A0AF] rounded cursor-pointer"
                        {{ old('is_reminder_enabled', $routine->is_reminder_enabled) ? 'checked' : '' }}>
                </div>

                <div id="reminder_time_container" class="mt-3">
                    <label for="reminder_time" class="block mb-2 text-xs font-semibold uppercase tracking-wider text-[#2A4043]">
                        Hora del recordatorio
                    </label>
                    <input type="time" id="reminder_time" name="reminder_time"
                        class="w-full p-3 bg-white rounded-xl border-2 @error('reminder_time') border-red-400 @else border-[#CCE2E5] @enderror focus:outline-none focus:border-[#37A0AF] text-md text-[#2A4043] transition"
                        value="{{ old('reminder_time', $routine->formatted_time) }}">
                    @error('reminder_time')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Productos de la rutina --}}
            @if ($routine->assignedProducts->count() > 0)
                <div class="mb-8">
                    <h2 class="text-md font-semibold text-[#306067] mb-3">Productos en la rutina</h2>
                    <div class="space-y-2" id="products_list">
                        @foreach ($routine->assignedProducts as $product)
                            <x-product-card-delete :product="$product" />
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Botones de Acción --}}
            <div class="flex flex-col-reverse items-center justify-end gap-3 mb-10 md:flex-row">
                <a href="{{ route('routines.show', $routine->routine_id) }}"
                    class="w-full md:w-auto px-6 py-3 text-center border-2 border-[#CCE2E5] text-[#2A4043] font-semibold rounded-xl hover:bg-gray-50 transition">
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
            // Frecuencia de recordatorios
            const frequencySelect = document.getElementById('reminder_frequency');
            const weeklyDiv = document.getElementById('weekly_days');
            const everyXDiv = document.getElementById('every_x_days');

            if (frequencySelect && weeklyDiv && everyXDiv) {
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
                toggleFields();
            }

            // Label dinámico tipo de piel/pelo
            const typeSelect = document.getElementById('type_id');
            const needLabel = document.getElementById('need_label');
            const needPlaceholder = document.getElementById('need_placeholder');

            if (typeSelect && needLabel && needPlaceholder) {
                function updateNeedText() {
                    const selectedOption = typeSelect.options[typeSelect.selectedIndex];
                    const labelText = selectedOption ? (selectedOption.dataset.needLabel || 'tipo de piel') : 'tipo de piel';
                    const capitalized = labelText.charAt(0).toUpperCase() + labelText.slice(1);

                    needLabel.textContent = capitalized;
                    needPlaceholder.textContent = 'Seleccionar ' + labelText;
                }

                typeSelect.addEventListener('change', updateNeedText);
                updateNeedText();
            }
        });
    </script>
</x-layout>