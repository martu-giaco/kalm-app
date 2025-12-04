<x-layout title="Crear Post">

    <section class="flex flex-col justify-between mx-auto px-5 pt-10 rounded-t-3xl bg-white">

        <div>
            <h1 class="text-2xl font-bold text-[#306067] mb-2">Crear un nuevo Post</h1>

        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl">
            @csrf

            <textarea name="content" rows="4"
                placeholder="¿Qué está pasando?"
                class="text-[#306067] w-full p-3 border-2 border-[#37A0AF] rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--kalm-main)]"
                maxlength="280">{{ old('content') }}</textarea>
                <p class="text-sm text-end text-[#306067]">{{ old('content') ? strlen(old('content')) : 0 }}/280</p>

            @error('content')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror

            <label class="mt-7 mb-7 btn w-full inline-flex border-2 border-[#306067] text-[#2A4043] bg-transparent px-3 py-2 rounded-xl font-bold transition-all duration-300 items-center justify-between gap-2" for="add-image">
                Subir una imagen
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#2A4043"><path d="M480-480ZM200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h280q17 0 28.5 11.5T520-800q0 17-11.5 28.5T480-760H200v560h560v-280q0-17 11.5-28.5T800-520q17 0 28.5 11.5T840-480v280q0 33-23.5 56.5T760-120H200Zm40-160h480L570-480 450-320l-90-120-120 160Zm440-400h-40q-17 0-28.5-11.5T600-720q0-17 11.5-28.5T640-760h40v-40q0-17 11.5-28.5T720-840q17 0 28.5 11.5T760-800v40h40q17 0 28.5 11.5T840-720q0 17-11.5 28.5T800-680h-40v40q0 17-11.5 28.5T720-600q-17 0-28.5-11.5T680-640v-40Z"/></svg>
            </label>
            <input type="file" id="add-image" name="image" class="hidden">
        </div>

            <div class="flex justify-between items-center mt-2">
                <button type="submit" class="btn w-full px-5 py-3 rounded-xl text-white font-bold transition cursor-pointer disabled:opacity-80 disabled:cursor-not-allowed bg-[#306067]">
                    Publicar
                </button>
            </div>
        </form>

    </section>

</x-layout>
