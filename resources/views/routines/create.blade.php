<x-layout>
    <x-slot:title>Nueva Rutina</x-slot:title>

    <section class="max-w-6xl min-h-screen px-5 mx-auto bg-white dark:bg-[#2A4043] pt-7 rounded-t-3xl">
        <h1 class="text-2xl font-semibold text-[#306067] dark:text-[#CCE2E5] mb-5">Nueva Rutina</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                La información ingresada contiene errores. Por favor, revisar los campos y probar de nuevo.
            </div>
        @endif

        @php
            $selectedType = $types->firstWhere('id', old('type_id'));
            $needLabelText = $selectedType && strtolower($selectedType->name) === 'haircare'
                ? 'Tipo de pelo'
                : 'Tipo de piel';
        @endphp

        <form action="{{ route('routines.store') }}" method="POST" enctype="multipart/form-data">
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
                    <div class="text-danger">{{ $message }}</div>
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
            const typeSelect = document.getElementById('type_id');
            const needLabel = document.getElementById('need_label');
            const needPlaceholder = document.getElementById('need_placeholder');

            if (!typeSelect || !needLabel || !needPlaceholder) {
                return;
            }

            function updateNeedText() {
                const selectedOption = typeSelect.options[typeSelect.selectedIndex];
                const labelText = selectedOption.dataset.needLabel || 'tipo de piel';
                const capitalized = labelText.charAt(0).toUpperCase() + labelText.slice(1);

                needLabel.textContent = capitalized;
                needPlaceholder.textContent = 'Seleccionar ' + labelText;
            }

            typeSelect.addEventListener('change', updateNeedText);
            updateNeedText();
        });
    </script>
</x-layout>
