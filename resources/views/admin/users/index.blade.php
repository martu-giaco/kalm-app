<x-layout title="Gestión de Usuarios">
    <div class="container my-5 px-4 sm:px-6 bg-white rounded-t-3xl min-h-full pt-5 pb-10">
        <h1 class="mb-6 text-3xl font-bold text-[#306067]">Usuarios</h1>

        @if($users->isEmpty())
            <div class="p-4 mb-4 text-sm text-[#306067] bg-teal-50 rounded-xl">
                No hay usuarios registrados todavía.
            </div>
        @else
            @php
                $roles = [
                    'admin' => 'Administradores',
                    'premium' => 'Usuarios Premium',
                    'free' => 'Usuarios Free'
                ];
            @endphp

            @foreach($roles as $roleKey => $roleTitle)
                @php
                    $filteredUsers = $users->where('role', $roleKey);
                @endphp

                @if($filteredUsers->isNotEmpty())
                    <div class="mb-8">
                        <h2 class="mb-4 text-2xl font-bold text-[#37A0AF]">{{ $roleTitle }}</h2>

                        {{-- VISTA MÓVIL (Tarjetas en lugar de tabla) --}}
                        <div class="grid grid-cols-1 gap-4 md:hidden">
                            @foreach($filteredUsers as $user)
                                <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 shadow-sm flex items-center justify-between">
                                    <div class="space-y-1 overflow-hidden pr-2">
                                        <div class="flex items-center gap-2">
                                            <span class="text-xs font-semibold px-2 py-0.5 rounded bg-[#306067] text-white">#{{ $user->id }}</span>
                                            <h3 class="font-bold text-[#2A4043] truncate">{{ $user->name }}</h3>
                                        </div>
                                        <p class="text-sm text-gray-600 truncate">{{ $user->email }}</p>
                                    </div>
                                    <a href="{{ route('admin.users.view', $user) }}" class="flex-shrink-0 p-2.5 rounded-xl bg-[#37A0AF] text-white hover:bg-[#306067] transition-colors" title="Ver detalle">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#FFFFFF"><path d="M240-400q-33 0-56.5-23.5T160-480q0-33 23.5-56.5T240-560q33 0 56.5 23.5T320-480q0 33-23.5 56.5T240-400Zm240 0q-33 0-56.5-23.5T400-480q0-33 23.5-56.5T480-560q33 0 56.5 23.5T560-480q0 33-23.5 56.5T480-400Zm240 0q-33 0-56.5-23.5T640-480q0-33 23.5-56.5T720-560q33 0 56.5 23.5T800-480q0 33-23.5 56.5T720-400Z"/></svg>
                                    </a>
                                </div>
                            @endforeach
                        </div>

                        {{-- VISTA DESKTOP (Tabla tradicional) --}}
                        <div class="hidden md:block overflow-x-auto rounded-xl border border-gray-200">
                            <table class="w-full text-left text-sm text-[#2A4043]">
                                <thead class="bg-[#306067] text-white">
                                    <tr>
                                        <th scope="col" class="px-4 py-3">ID</th>
                                        <th scope="col" class="px-4 py-3">Nombre</th>
                                        <th scope="col" class="px-4 py-3">Email</th>
                                        <th scope="col" class="px-4 py-3 text-right">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($filteredUsers as $user)
                                        <tr class="hover:bg-teal-50/50 transition-colors">
                                            <td class="px-4 py-3 font-semibold">{{ $user->id }}</td>
                                            <td class="px-4 py-3 font-medium">{{ $user->name }}</td>
                                            <td class="px-4 py-3 text-gray-600">{{ $user->email }}</td>
                                            <td class="px-4 py-3 text-right">
                                                <a href="{{ route('admin.users.view', $user) }}" class="inline-flex items-center p-2 rounded-lg bg-[#37A0AF] text-white hover:bg-[#306067] transition-colors">
                                                    <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#FFFFFF"><path d="M240-400q-33 0-56.5-23.5T160-480q0-33 23.5-56.5T240-560q33 0 56.5 23.5T320-480q0 33-23.5 56.5T240-400Zm240 0q-33 0-56.5-23.5T400-480q0-33 23.5-56.5T480-560q33 0 56.5 23.5T560-480q0 33-23.5 56.5T480-400Zm240 0q-33 0-56.5-23.5T640-480q0-33 23.5-56.5T720-560q33 0 56.5 23.5T800-480q0 33-23.5 56.5T720-400Z"/></svg>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            @endforeach
        @endif
    </div>
</x-layout>