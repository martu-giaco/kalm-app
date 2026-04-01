<x-layout>
    <x-slot:title>Nueva Rutina</x-slot:title>

    <section class="max-w-6xl min-h-screen px-5 mx-auto bg-white pt-7 rounded-t-3xl">
        <h1 class="text-2xl font-semibold text-[#306067] mb-5">Nueva Rutina</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                La información ingresada contiene errores. Por favor, revisar los campos y probar de nuevo.
            </div>
        @endif

        <form action="{{ route('routines.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Nombre --}}
            <div class="mb-4">
                <label for="name" class="form-label mb-2 text-[#2A4043]">
                    Nombre de la rutina
                </label>
                <input type="text" id="name" name="name"
                    class="form-control @error('name') is-invalid @enderror w-full p-3 bg-transparent rounded-xl border-2 border-[#CCE2E5] placeholder-[#CCE2E5] focus:outline-[#37A0AF] text-md text-[#2A4043]"
                    @error('name') aria-invalid="true" aria-errormessage="error-name" @enderror
                    value="{{ old('name') }}">
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- Tipo de rutina --}}
            <div class="mb-4">
                <label for="type_id" class="block mb-1 text-sm text-[#2A4043]">
                    Tipo de Rutina
                </label>
                <select name="type_id" id="type_id"
                    class="w-full p-3 mb-3 bg-transparent rounded-xl border-2 border-[#CCE2E5] placeholder-[#CCE2E5] focus:outline-[#37A0AF] text-md text-[#2A4043]">
                    <option value="">Seleccionar tipo</option>
                    @foreach ($types as $type)
                        <option value="{{ $type->id }}">
                            {{ $type->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Necesidad de rutina --}}
            <div class="mb-4">
                <label for="need_id" class="block mb-1 text-sm text-[#2A4043]">
                    Tipo de piel
                </label>
                <select name="need_id" id="need_id"
                    class="w-full p-3 mb-3 bg-transparent rounded-xl border-2 border-[#CCE2E5] placeholder-[#CCE2E5] focus:outline-[#37A0AF] text-md text-[#2A4043]">
                    <option value="">Seleccionar tipo de piel</option>
                    @foreach ($routine_needs as $need)
                        <option value="{{ $need->need_id }}">
                            {{ $need->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Tiempo de rutina --}}
            <div class="mb-4">
                <label for="time_id" class="block mb-1 text-sm text-[#2A4043]">
                    Tiempo de rutina
                </label>
                <select name="time_id" id="time_id"
                    class="w-full p-3 bg-transparent rounded-xl border-2 border-[#CCE2E5] placeholder-[#CCE2E5] focus:outline-[#37A0AF] text-md text-[#2A4043]">
                    <option value="">Seleccionar tiempo</option>
                    @foreach ($routine_times as $time)
                        <option value="{{ $time->time_id }}">
                            {{ $time->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Botón --}}
            <button type="submit"
                class="btn w-full px-5 py-3 rounded-xl text-white font-bold transition cursor-pointer disabled:opacity-80 disabled:cursor-not-allowed hover:bg-[#306067] bg-[#306067]">
                Crear Rutina
            </button>

        </form>
    </section>
</x-layout>
