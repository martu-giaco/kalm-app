{{-- resources/views/admin/users/edit.blade.php --}}
<x-layout :title="'Editar usuario'">
    <section class="w-full px-2 pb-20 bg-white h-vh pt-7 rounded-t-3xl">
        <div class="max-w-3xl px-4 mx-auto">
            <h1 class="text-2xl font-semibold mb-6 text-[#306067]">Editar cuenta</h1>

            @if ($errors->any())
                <div class="p-4 mb-4 text-red-800 rounded-xl bg-red-50">
                    <ul class="pl-5 list-disc">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div>
                    <div class="flex items-center mb-4">
                        <div class="avatar">
                            <div class="rounded-full h-28 w-28">
                                @if (isset($user) && $user->avatar)
                                    <img src="{{ asset('storage/' . $user->avatar) }}"
                                        alt="{{ $user->name ?? 'Avatar usuario' }}" class="object-cover w-full h-full"
                                        loading="lazy" decoding="async" />
                                @else
                                    <img src="{{ asset('images/pfp.svg') }}" alt="Avatar por defecto"
                                        class="object-contain w-full h-full" loading="lazy" decoding="async" />
                                @endif
                            </div>
                        </div>
                        <div class="w-full ms-2">
                            <p class="mb-1 text-sm">Foto de perfil</p>
                            <label for="avatar"
                                class="flex justify-between mb-1 text-md p-3 bg-transparent rounded-xl border-2 border-[#2A4043] placeholder-[#CCE2E5] focus:outline-[#2A4043] text-[#2A4043]">
                                <p>Subir una foto</p>
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                    width="24px" fill="#2A4043">
                                    <path
                                        d="M480-480ZM202.87-111.87q-37.78 0-64.39-26.61t-26.61-64.39v-554.26q0-37.78 26.61-64.39t64.39-26.61h270.91q19.15 0 32.33 13.17 13.17 13.18 13.17 32.33t-13.17 32.33q-13.18 13.17-32.33 13.17H202.87v554.26h554.26v-270.91q0-19.15 13.17-32.33 13.18-13.17 32.33-13.17t32.33 13.17q13.17 13.18 13.17 32.33v270.91q0 37.78-26.61 64.39t-64.39 26.61H202.87ZM240-280h480L570-480 450-320l-90-120-120 160Zm441.91-401.91h-40.95q-17.71 0-29.7-12.05-11.98-12.05-11.98-29.87 0-17.71 12.05-29.69t29.87-11.98h40.71v-40.96q0-17.71 12.05-29.69t29.87-11.98q17.71 0 29.69 11.98t11.98 29.69v40.96h40.96q17.71 0 29.69 11.98t11.98 29.7q0 17.71-11.98 29.81-11.98 12.1-29.69 12.1H765.5v40.95q0 17.71-11.98 29.7-11.98 11.98-29.7 11.98-17.71 0-29.81-12.05-12.1-12.05-12.1-29.87v-40.71Z" />
                                </svg>
                            </label>
                            <input id="avatar" type="file" name="avatar" accept="image/*" class="file-input"
                                style="display: none;">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="name" class="block mb-1 text-sm">Nombre</label>
                        <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}"
                            class="w-full p-3 bg-transparent rounded-xl border-2 border-[#37A0AF] placeholder-[#CCE2E5] focus:outline-[#37A0AF] text-md text-[#2A4043]"
                            required>
                    </div>



                    <div class="mb-4">
                        <label for="email" class="block mb-1 text-sm">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}"
                            class="w-full p-3 bg-transparent rounded-xl border-2 border-[#37A0AF] placeholder-[#CCE2E5] focus:outline-[#37A0AF] text-md text-[#2A4043]"
                            required>
                    </div>

                    <div class="mb-4">
                        <label for="role" class="block mb-1 text-sm">Rol</label>
                        <select id="role" name="role"
                            class="w-full p-3 mb-3 bg-transparent rounded-xl border-2 border-[#CCE2E5] placeholder-[#CCE2E5] focus:outline-[#37A0AF] text-md text-[#2A4043]"
                            required>
                            <option value="free" {{ old('role', $user->role) == 'free' ? 'selected' : '' }}>Free</option>
                            <option value="premium" {{ old('role', $user->role) == 'premium' ? 'selected' : '' }}>Premium</option>
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Administrador</option>
                        </select>
                    </div>
                </div>


                <div class="gap-3 mt-7">
                    <button type="submit"
                        class="btn w-full px-5 py-3 rounded-xl text-white font-bold transition cursor-pointer disabled:opacity-80 disabled:cursor-not-allowed hover:bg-[#306067] bg-[#306067]">Guardar
                        cambios</button>
                    <a href="{{ route('admin.users.view', $user->id) }}"
                        class="mt-1 btn w-full inline-flex border-2 border-[#306067] text-[#306067] bg-transparent px-6 py-3 rounded-xl font-semiboldbold transition-all duration-300 items-center justify-center gap-2 text-sm font-bold">Cancelar</a>
                </div>
            </form>
        </div>
    </section>
</x-layout>
