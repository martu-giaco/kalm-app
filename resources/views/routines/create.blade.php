<x-layout>
    <x-slot:title>Nueva Rutina</x-slot:title>

    <section class="max-w-6xl mx-auto px-5 pt-5 rounded-t-3xl bg-white min-h-screen">
        <h1 class="mb-3" >Nueva Rutina</h1>
        @if ($errors->any())
            <div class="alert alert-danger">
                La informacion ingresada contiene errores.
                Por favor, revisá los campos y prbá de nuevo
            </div>
        @endif

        <form action="{{ route('routines.store') }}" method="POST" enctype="multipart/form-data" >
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nombre de la rutina</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    class="form-control @error('name') is-invalid @enderror"
                    @error('name') aria-invalid="true" aria-errormessage="error-name" @enderror
                    value="{{ old('name') }}"
                >
                @error('name')
                    <div class="text-danger">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="type" class="form-label">Tipo de rutina</label>
                <input
                    type="text"
                    id="type"
                    name="type"
                    class="form-control @error('type') is-invalid @enderror"
                    @error('type') aria-invalid="true" aria-errormessage="error-type" @enderror
                    value="{{ old('type') }}"
                >
                @error('type')
                    <div class="text-danger">
                        {{ $message }}
                    </div>
                @enderror
            </div>


            <fieldset class="mb-3">
                <legend>Tipo de rutina</legend>
                @foreach ($types as $type)
                <label class="me-3">
                    <input
                        type="checkbox"
                        name="type_id[]"
                        value="{{ $type->type_id }}"
                        @checked(in_array($type->type_id, old('type_id', [])))
                    >
                    {{ $type->name }}
                </label>
                @endforeach
            </fieldset>

            <button type="submit" class="btn btn-primary">Publicar</button>

        </form>
    </section>

</x-layout>
