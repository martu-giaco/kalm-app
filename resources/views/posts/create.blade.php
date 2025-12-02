<x-layout title="Crear Post">

    <div class="max-w-xl mx-auto mt-6">

        <h1 class="text-2xl font-bold text-[#306067] mb-4">Crear un nuevo Post</h1>

        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded-xl shadow">
            @csrf

            <textarea name="content" rows="4"
                placeholder="¿Qué está pasando?"
                class="w-full p-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--kalm-main)]"
                maxlength="280">{{ old('content') }}</textarea>

            @error('content')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror

            <input type="file" name="image" class="mt-2">

            <div class="flex justify-between items-center mt-2">
                <span class="text-sm text-gray-500">{{ old('content') ? strlen(old('content')) : 0 }}/280</span>
                <button type="submit" class="bg-[var(--kalm-main)] textblack px-4 py-2 rounded-lg hover:bg-[var(--kalm-dark)] transition">
                    Publicar
                </button>
            </div>
        </form>

    </div>

</x-layout>
