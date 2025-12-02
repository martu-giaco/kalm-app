<x-layout title="Crear Post">

    <div class="mx-auto px-5 bg-white min-h-screen">

        <h1 class="text-2xl font-bold text-[#306067] mb-2">Crear un nuevo Post</h1>

        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl">
            @csrf

            <textarea name="content" rows="4"
                placeholder="¿Qué está pasando?"
                class="text-[#CCE2E5] w-full p-3 border border-[#37A0AF] rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--kalm-main)]"
                maxlength="280">{{ old('content') }}</textarea>
                <p class="text-sm text-end text-[#CCE2E5]">{{ old('content') ? strlen(old('content')) : 0 }}/280</p>

            @error('content')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror

            <label class="mt-5" for="image">Subir una imagen</label>
            <input type="file" name="image" class="mt-2">

            <div class="flex justify-between items-center mt-2">
                <button type="submit" class="btn w-full px-5 py-3 rounded-xl text-white font-bold transition cursor-pointer disabled:opacity-80 disabled:cursor-not-allowed bg-[#306067]">
                    Publicar
                </button>
            </div>
        </form>

    </div>

</x-layout>
