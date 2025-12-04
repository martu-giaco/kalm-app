{{-- resources/views/routines/edit.blade.php --}}
<x-layout :title="'Editar: ' . $routine->name">
    <div class="max-w-3xl mx-auto p-4 sm:p-6">

        <header class="mb-6">
            <h1 class="text-3xl font-semibold text-[var(--kalm-dark)]">Editar rutina</h1>
            <p class="text-sm text-slate-400 mt-1">
                Modifica los detalles de la rutina.
            </p>
        </header>

        <main class="bg-white rounded-xl border border-slate-100 shadow-sm p-6 space-y-6">

            <form action="{{ route('routines.update', $routine->routine_id) }}" method="POST">
                @csrf
                @method('PATCH')

                {{-- Nombre --}}
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input type="text" name="name" id="name"
                           value="{{ old('name', $routine->name) }}"
                           required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>

                {{-- Tipo de rutina --}}
                <div class="mb-4">
                    <label for="routine_type_id" class="block text-sm font-medium text-gray-700">Tipo de rutina</label>
                    <select name="routine_type_id" id="routine_type_id" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="">Seleccionar tipo</option>
                        @foreach($routine_types as $type)
                            <option value="{{ $type->type_id }}"
                                {{ old('routine_type_id', $routine->routine_type_id) == $type->type_id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Tiempo de rutina --}}
                <div class="mb-4">
                    <label for="routine_time_id" class="block text-sm font-medium text-gray-700">Tiempo de rutina</label>
                    <select name="routine_time_id" id="routine_time_id" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="">Seleccionar tiempo</option>
                        @foreach($routine_times as $time)
                            <option value="{{ $time->time_id }}"
                                {{ old('routine_time_id', $routine->routine_time_id) == $time->time_id ? 'selected' : '' }}>
                                {{ $time->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Actualizar Rutina
                </button>
            </form>

        </main>
    </div>
</x-layout>
