<x-layout>
    <x-slot:title>Nueva Rutina</x-slot:title>

    <section class="max-w-6xl mx-auto px-5 pt-7 rounded-t-3xl bg-white min-h-screen">
        <h1 class="text-2xl font-semibold text-[#306067] mb-5">Nueva Rutina</h1>
        @if ($errors->any())
            <div class="alert alert-danger">
                La informacion ingresada contiene errores.
                Por favor, revisar los campos y probar de nuevo
            </div>
        @endif

        <form action="{{ route('routines.store') }}" method="POST" enctype="multipart/form-data" >
            @csrf
            <div class="mb-4">
                <label for="name" class="form-label mb-2 text-[#2A4043]">Nombre de la rutina</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    class="form-control @error('name') is-invalid @enderror w-full p-3 bg-transparent rounded-xl border-2 border-[#CCE2E5] placeholder-[#CCE2E5] focus:outline-[#37A0AF] text-md text-[#2A4043]"
                    @error('name') aria-invalid="true" aria-errormessage="error-name" @enderror
                    value="{{ old('name') }}"
                >
                @error('name')
                    <div class="text-danger">
                        {{ $message }}
                    </div>
                @enderror
            </div>


            <fieldset class="mb-4">
                <legend class="mb-2 text-[#2A4043]">Tipo de rutina</legend>

                <select
                    name="type_id[]"
                    id="type_id"
                    class="w-full p-3 mb-3 bg-transparent rounded-xl border-2 border-[#CCE2E5] placeholder-[#CCE2E5] focus:outline-[#37A0AF] text-md text-[#2A4043]"
                >
                    @foreach ($types as $type)
                        <option
                            value="{{ $type->type_id }}"
                            @selected(in_array($type->type_id, old('type_id', [])))
                        >
                            {{ $type->name }}
                        </option>
                    @endforeach
                </select>

                <legend class="mb-2 text-[#2A4043] mt-4">Tiempo de rutina</legend>
                <select name="time_id" id="time_id" class="w-full p-3 bg-transparent rounded-xl border-2 border-[#CCE2E5] placeholder-[#CCE2E5] focus:outline-[#37A0AF] text-md text-[#2A4043]">
                    <option value="">Seleccionar tiempo</option>
                    @foreach ($times as $time)
                        <option value="{{ $time->time_id }}" @selected(old('time_id') == $time->time_id)>{{ $time->name }}</option>
                    @endforeach
                </select>
            </fieldset>

            <button type="submit" class="btn w-full px-5 py-3 rounded-xl text-white font-bold transition cursor-pointer disabled:opacity-80 disabled:cursor-not-allowed hover:bg-[#306067] bg-[#306067]">Crear rutina</button>

        </form>
    </section>

</x-layout>
