<x-layout>
    <section class="px-5 py-10 bg-white rounded-t-3xl h-full">
            <h1 class="text-2xl font-semibold text-[#306067] mb-3">
                Cambiar contraseña
            </h1>

            <form action="{{ route('profile.password.update') }}" method="POST" class="space-y-4">
                @csrf
                @method('PATCH')

                <div>
                    <label for="current_password" class="block mb-1 text-sm">Contraseña actual</label>
                    <input id="current_password" name="current_password" type="password"
                        class="w-full p-3 bg-transparent rounded-xl border-2 border-[#37A0AF] placeholder-[#CCE2E5] focus:outline-[#37A0AF] text-md text-[#2A4043]"
                        required>

                    @error('current_password')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block mt-2 text-sm">Nueva contraseña</label>
                    <input id="password" name="password" type="password"
                        class="w-full p-3 bg-transparent rounded-xl border-2 border-[#37A0AF] placeholder-[#CCE2E5] focus:outline-[#37A0AF] text-md text-[#2A4043]"
                        required>

                    @error('password')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block mt-2 text-sm">Repetir contraseña</label>
                    <input id="password_confirmation" name="password_confirmation" type="password"
                        class="w-full p-3 bg-transparent rounded-xl border-2 border-[#37A0AF] placeholder-[#CCE2E5] focus:outline-[#37A0AF] text-md text-[#2A4043]"
                        required>
                </div>

                <button type="submit"
                    class="btn w-full px-5 py-4 my-5 rounded-xl text-white font-bold transition hover:bg-[#306067] bg-[#306067]">
                    Actualizar contraseña
                </button>
            </form>
    </section>
</x-layout>
