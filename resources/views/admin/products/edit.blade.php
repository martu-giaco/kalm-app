<?php
/** \Illuminate\Support\ViewErrorBag $errors */
?>

<x-layout>
    <div class="container my-5 px-5 bg-white rounded-t-3xl min-h-full pt-5">

        <h1 class="text-3xl font-bold text-[#306067] mb-4">Editar Producto</h1>

        @if ($errors->any())
            <div class="alert alert-danger">La información contiene errores.</div>
        @endif

        <form action="{{ route('admin.product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="mb-3">
                <label for="title" class="block mb-1 text-sm">Título</label>
                <input type="text" name="title" id="title" class="w-full p-3 mb-3 bg-transparent rounded-xl border-2 border-[#CCE2E5] placeholder-[#CCE2E5] focus:outline-[#37A0AF] text-md text-[#2A4043]" value="{{ old('title', $product->title) }}">
            </div>

            <div class="mb-3">
                <label for="author" class="block mb-1 text-sm">Autor</label>
                <input type="text" name="author" id="author" class="w-full p-3 mb-3 bg-transparent rounded-xl border-2 border-[#CCE2E5] placeholder-[#CCE2E5] focus:outline-[#37A0AF] text-md text-[#2A4043]" value="{{ old('author', $product->author) }}">
            </div>

            <div class="mb-3">
                <p class="mb-1 text-sm">Imagen</p>
                @if($product->image)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}" style="max-width: 200px; max-height: 200px;">
                    </div>
                @endif
                <label for="image"
                                class="flex justify-between mb-1 text-md p-3 bg-transparent rounded-xl border-2 border-[#2A4043] placeholder-[#CCE2E5] focus:outline-[#2A4043] text-[#2A4043]">
                                <p>Subir una foto</p>
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                    width="24px" fill="#2A4043">
                                    <path
                                        d="M480-480ZM202.87-111.87q-37.78 0-64.39-26.61t-26.61-64.39v-554.26q0-37.78 26.61-64.39t64.39-26.61h270.91q19.15 0 32.33 13.17 13.17 13.18 13.17 32.33t-13.17 32.33q-13.18 13.17-32.33 13.17H202.87v554.26h554.26v-270.91q0-19.15 13.17-32.33 13.18-13.17 32.33-13.17t32.33 13.17q13.17 13.18 13.17 32.33v270.91q0 37.78-26.61 64.39t-64.39 26.61H202.87ZM240-280h480L570-480 450-320l-90-120-120 160Zm441.91-401.91h-40.95q-17.71 0-29.7-12.05-11.98-12.05-11.98-29.87 0-17.71 12.05-29.69t29.87-11.98h40.71v-40.96q0-17.71 12.05-29.69t29.87-11.98q17.71 0 29.69 11.98t11.98 29.69v40.96h40.96q17.71 0 29.69 11.98t11.98 29.7q0 17.71-11.98 29.81-11.98 12.1-29.69 12.1H765.5v40.95q0 17.71-11.98 29.7-11.98 11.98-29.7 11.98-17.71 0-29.81-12.05-12.1-12.05-12.1-29.87v-40.71Z" />
                                </svg>
                            </label>
                <input style="display: none;" type="file" id="image" name="image" class="w-full p-3 mb-3 bg-transparent rounded-xl border-2 border-[#CCE2E5] placeholder-[#CCE2E5] focus:outline-[#37A0AF] text-md text-[#2A4043] @error('image') is-invalid @enderror" accept="image/*">
                @error('image')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="content" class="block mb-1 text-sm">Contenido</label>
                <textarea name="content" id="content" class="w-full p-3 mb-3 bg-transparent rounded-xl border-2 border-[#CCE2E5] placeholder-[#CCE2E5] focus:outline-[#37A0AF] text-md text-[#2A4043]">{{ old('content', $blog->content) }}</textarea>
            </div>

            <button type="submit" class="btn w-full px-5 py-3 rounded-xl text-white font-bold transition cursor-pointer disabled:opacity-80 disabled:cursor-not-allowed hover:bg-[#306067] bg-[#306067]">Editar Blog</button>
        </form>
    </div>
</x-layout>
