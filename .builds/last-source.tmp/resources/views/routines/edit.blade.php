{{-- resources/views/routines/edit.blade.php --}}
<x-layout :title="'Editar: ' . $routine->name">
    <section class="px-5 pt-10 bg-white vh rounded-t-3xl">
        <h1 class="text-2xl font-semibold mb-6 text-[#306067]">Editar Rutina</h1>
        <main>
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
                <div class="mb-4">
                    <label for="name" class="block mb-1 text-sm">Nombre</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $routine->name) }}" required
                        class="w-full p-3 mb-3 bg-transparent rounded-xl border-2 border-[#CCE2E5] placeholder-[#CCE2E5] focus:outline-[#37A0AF] text-md text-[#2A4043]">
                </div>

                {{-- Tipo de rutina --}}
                <div class="mb-4">
                    <label for="type_id" class="block mb-1 text-sm">Tipo de rutina</label>
                    @if ($isFromRecommended && $routine->type_id)
                        {{-- Es una rutina predeterminada: mostrar tipo automáticamente --}}
                        <div
                            class="w-full p-3 mb-3 bg-[#CCE2E5]/50 rounded-xl border-2 border-[#37A0AF] text-md text-[#306067] font-semibold">
                            {{ $routine->type?->name ?? 'No especificado' }}
                        </div>
                        <input type="hidden" name="type_id" value="{{ $routine->type_id }}">
                        <p class="text-xs text-[#37A0AF]">Esta es una rutina predeterminada. El tipo se asignó
                            automáticamente.</p>
                    @else
                        {{-- Es una rutina manual: permite que el usuario elija --}}
                        <select name="type_id" id="type_id"
                            class="w-full p-3 mb-3 bg-transparent rounded-xl border-2 border-[#CCE2E5] placeholder-[#CCE2E5] focus:outline-[#37A0AF] text-md text-[#2A4043]">
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
                </div>

                {{-- Tipo de piel de rutina --}}
                <div class="mb-4">
                    <label for="need_id" id="need_label" class="block mb-1 text-sm">{{ $needLabelText }}</label>
                    <select name="need_id" id="need_id"
                        class="w-full p-3 mb-3 bg-transparent rounded-xl border-2 border-[#CCE2E5] placeholder-[#CCE2E5] focus:outline-[#37A0AF] text-md text-[#2A4043]">
                        <option value="" id="need_placeholder">Seleccionar {{ strtolower($needLabelText) }}</option>
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
                    <select name="time_id" id="time_id"
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
                            Personalizado</option>
                    </select>
                </div>

                {{-- Días de la semana (para semanal) --}}
                <div id="weekly_days" class="hidden mb-6">
                    <label class="block mb-1 text-sm">Días de la semana</label>
                    <div class="grid grid-cols-7 gap-2">
                        @php
                            $days = ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'];
                            $dayValues = ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'];
                            $selectedDays =
                                old('reminder_days', json_decode($routine->reminder_days ?? '[]', true)) ?? [];
                        @endphp
                        @foreach ($days as $index => $day)
                            <label class="cursor-pointer">
                                <input type="checkbox" name="reminder_days[]" value="{{ $dayValues[$index] }}"
                                    class="hidden peer"
                                    {{ in_array($dayValues[$index], $selectedDays) ? 'checked' : '' }}>
                                <div
                                    class="py-2 text-center rounded-xl border border-[#CCE2E5] text-[#2A4043] transition
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
                    <input type="number" name="reminder_interval" id="reminder_interval" min="1" max="30"
                        value="{{ old('reminder_interval', $routine->reminder_interval ?? 1) }}"
                        class="w-full p-3 bg-transparent rounded-xl border-2 border-[#CCE2E5] placeholder-[#CCE2E5] focus:outline-[#37A0AF] text-md text-[#2A4043]">
                    <p class="mt-1 text-xs text-[#2A4043]/70">
                        Ingresa el número de días entre recordatorios (ej: 3 para cada 3 días).
                    </p>
                </div>

                {{-- Horario de recordatorio --}}
                <!-- Sección de Recordatorio Push -->
                <div class="mb-4 border-0 shadow-sm card">
                    <div class="card-body">
                        <h3 class="gap-2 mb-3 h5 d-flex align-items-center">
                            🔔 Configurar Recordatorio Push
                        </h3>
                        <p class="text-muted small">
                            Activá las alertas para que el navegador te notifique automáticamente cuándo realizar esta
                            rutina.
                        </p>

                        <!-- Switch para Activar/Desactivar el Recordatorio -->
                        <div class="mb-3 form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_reminder_enabled"
                                name="is_reminder_enabled" value="1"
                                {{ old('is_reminder_enabled', $routine->is_reminder_enabled) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold" for="is_reminder_enabled">
                                Activar notificaciones para esta rutina
                            </label>
                        </div>

                        <!-- Selector de Hora (Se puede ocultar o mostrar con JS de ser necesario) -->
                        <div class="mb-3" id="reminder_time_container">
                            <label for="reminder_time" class="form-label small fw-bold text-secondary">Hora del
                                recordatorio</label>
                            <input type="time" id="reminder_time" name="reminder_time"
                                class="form-control @error('reminder_time') is-invalid @enderror"
                                value="{{ old('reminder_time', $routine->formatted_time) }}"
                            @error('reminder_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Botón para Guardar y Procesar los Cambios -->
                <div class="gap-2 d-grid d-md-flex justify-content-md-end">
                    <a href="{{ route('routines.show', $routine->routine_id) }}"
                        class="px-4 btn btn-outline-secondary">
                        Cancelar
                    </a>
                    <button type="submit" class="px-4 btn btn-primary fw-bold">
                        💾 Guardar Recordatorio y Rutina
                    </button>
                </div>


                {{-- Productos de la rutina --}}
                <div class="mb-6">
                    <label class="block mb-3 text-sm font-semibold text-[#306067]">Productos en la rutina</label>
                    @if ($routine->assignedProducts->count() > 0)
                        <div class="mb-4 space-y-2" id="products_list">
                            @foreach ($routine->assignedProducts as $product)
                                <div class="flex items-center justify-between p-3 bg-[#CCE2E5]/50 rounded-lg border border-[#37A0AF]"
                                    id="product_container_{{ $product->id }}">
                                    <span class="text-sm text-[#306067]">{{ $product->name }}</span>
                                    <button type="button"
                                        class="text-xs font-semibold text-red-600 hover:text-red-800"
                                        onclick="removeProduct({{ $product->id }}); return false;">
                                        Eliminar
                                    </button>
                                    <input type="hidden" name="products[]" value="{{ $product->id }}"
                                        id="product_{{ $product->id }}">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <button type="submit"
                    class="btn w-full px-5 py-3 rounded-xl text-white font-bold transition cursor-pointer disabled:opacity-80 disabled:cursor-not-allowed hover:bg-[#306067] bg-[#306067]">
                    Actualizar Rutina
                </button>
            </form>
        </main>
    </section>

    <script>
        // Función para eliminar productos
        function removeProduct(productId) {
            const container = document.getElementById('product_container_' + productId);
            const input = document.getElementById('product_' + productId);

            if (container && input) {
                container.remove();
                input.remove();
            }
        }

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
        });
    </script>
</x-layout>
