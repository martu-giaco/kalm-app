{{-- resources/views/routines/edit.blade.php --}}
<x-layout :title="'Editar: ' . $routine->name">
    <section class="h-full px-5 pt-10 bg-white rounded-t-3xl">
        <h1 class="text-2xl font-semibold mb-6 text-[#306067]">Editar rutina</h1>

        <main>
            <form action="{{ route('routines.update', $routine->routine_id) }}" method="POST">
                @csrf
                @method('PATCH')

                {{-- Nombre --}}
                <div class="mb-4">
                    <label for="name" class="block mb-1 text-sm">Nombre</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $routine->name) }}" required
                        class="w-full p-3 mb-3 bg-transparent rounded-xl border-2 border-[#CCE2E5] placeholder-[#CCE2E5] focus:outline-[#37A0AF] text-md text-[#2A4043]">
                </div>


                <div class="mb-4">
                    <label for="routine_category" class="block mb-1 text-sm">
                        Skincare / Haircare
                    </label>

                    <select name="routine_category" id="routine_category" required
                        class="w-full p-3 mb-3 bg-transparent rounded-xl border-2 border-[#CCE2E5] placeholder-[#CCE2E5] focus:outline-[#37A0AF] text-md text-[#2A4043]">

                        <option value="">Seleccionar categoría</option>
                        <option value="skincare"
                            {{ old('routine_category', $routine->routine_category ?? '') == 'skincare' ? 'selected' : '' }}>
                            Skincare
                        </option>
                        <option value="haircare"
                            {{ old('routine_category', $routine->routine_category ?? '') == 'haircare' ? 'selected' : '' }}>
                            Haircare
                        </option>
                    </select>
                </div>


                {{-- Tiempo de rutina --}}
                <div class="mb-4">
                    <label for="time_id" class="block mb-1 text-sm">Tiempo de rutina</label>
                    <select name="time_id" id="time_id" required
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

                <button type="submit"
                    class="btn w-full px-5 py-3 rounded-xl text-white font-bold transition cursor-pointer disabled:opacity-80 disabled:cursor-not-allowed hover:bg-[#306067] bg-[#306067]">
                    Actualizar Rutina
                </button>
            </form>
        </main>
    </section>
</x-layout>
