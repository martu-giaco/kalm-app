<x-layout>
    <div class="container my-5 px-5 bg-white rounded-t-3xl min-h-full pt-5">
        <div class="flex gap-2 flex-wrap justify-between items-center mb-4">
            <a href="{{ route('admin.users.index') }}" class="bg-transparent border-transparent shadow-none">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#2A4043"><path d="m142-480 294 294q15 15 14.5 35T435-116q-15 15-35 15t-35-15L57-423q-12-12-18-27t-6-30q0-15 6-30t18-27l308-308q15-15 35.5-14.5T436-844q15 15 15 35t-15 35L142-480Z"/></svg>
            </a>

            <div class="flex gap-3">
                @auth
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn font-bold text-white bg-[#306067] border-[#306067]">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#fff"><path d="M200-200h57l391-391-57-57-391 391v57Zm-40 80q-17 0-28.5-11.5T120-160v-97q0-16 6-30.5t17-25.5l505-504q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L313-143q-11 11-25.5 17t-30.5 6h-97Zm600-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z"/></svg>
                        Editar
                    </a>

                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('¿Confirma que desea eliminar este usuario?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn font-bold text-white bg-[#430000] border-[#430000]">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#fff"><path d="M280-120q-33 0-56.5-23.5T200-200v-520q-17 0-28.5-11.5T160-760q0-17 11.5-28.5T200-800h160q0-17 11.5-28.5T400-840h160q17 0 28.5 11.5T600-800h160q17 0 28.5 11.5T800-760q0 17-11.5 28.5T760-720v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM428.5-291.5Q440-303 440-320v-280q0-17-11.5-28.5T400-640q-17 0-28.5 11.5T360-600v280q0 17 11.5 28.5T400-280q17 0 28.5-11.5Zm160 0Q600-303 600-320v-280q0-17-11.5-28.5T560-640q-17 0-28.5 11.5T520-600v280q0 17 11.5 28.5T560-280q17 0 28.5-11.5ZM280-720v520-520Z"/></svg>
                            Eliminar
                        </button>
                    </form>
                @endauth
            </div>
        </div>

        <div class="shadow-lg py-7 px-5 rounded-xl flex gap-4 items-center">
                <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('images/pfp.svg') }}" alt="Avatar de {{ $user->name }}" class="h-24 w-24 rounded-full">
                <div>
                    <h1 class="text-3xl font-bold text-[#306067]">{{ $user->name ?? 'Nombre Desconocido' }}</h1>
                    <p>{{ $user->email }}</p>
                    <div class="px-3 py-1 rounded-xl" style="background-image: linear-gradient(45deg, #37A0AF , #CCE2E5 88%);width: fit-content;">
                        <p class="text-sm">{{ $user->role }}</p>
                    </div>
                </div>
        </div>
    </div>
</x-layout>
