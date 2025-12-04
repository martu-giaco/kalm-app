{{-- resources/views/user/edit.blade.php --}}
<x-layout :title="'Editar perfil'">
    <section class="w-full px-5 pt-10 bg-white rounded-t-3xl min-h-[87%]">
        <div class="max-w-3xl mx-auto px-4">
            <h1 class="text-2xl font-semibold mb-6">Editar perfil</h1>

            @if ($errors->any())
                <div class="mb-4 rounded-xl p-4 bg-red-50 text-red-800">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PATCH')>
                @csrf

                <div>
                    <label class="block text-sm font-medium mb-1">Nombre</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="input input-bordered w-full" required>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Usuario (username)</label>
                    <input type="text" name="username" value="{{ old('username', $user->username) }}" class="input input-bordered w-full">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="input input-bordered w-full" required>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Avatar (opcional)</label>
                    <input type="file" name="avatar" accept="image/*" class="file-input w-full">
                    @if($user->avatar)
                        <p class="text-xs text-[var(--kalm-text)] mt-2">Avatar actual:</p>
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="avatar" class="h-20 w-20 rounded-full object-cover mt-2">
                    @endif
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="btn text-white bg-[#306067]">Guardar cambios</button>
                    <a href="{{ route('profile.show') }}" class="btn btn-ghost">Cancelar</a>
                </div>
            </form>
        </div>
    </section>
</x-layout>
