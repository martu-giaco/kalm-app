<x-layout>
    <section class="px-5 pt-10">
        <h1 class="text-2xl font-semibold text-[#306067] mb-3">Editar Blog</h1>

        <form action="{{ route('blog.update', $blog->id) }}" method="POST">
            @csrf
            @method('PATCH')
            <input type="text" name="title" value="{{ $blog->title }}" placeholder="Título" class="w-full mb-2 input" required>
            <input type="url" name="image" value="{{ $blog->image }}" placeholder="URL de imagen" class="w-full mb-2 input">
            <input type="text" name="author" value="{{ $blog->author }}" placeholder="Autor" class="w-full mb-2 input" required>
            <input type="text" name="credentials" value="{{ $blog->credentials }}" placeholder="Credenciales" class="w-full mb-2 input">
            <textarea name="content" placeholder="Contenido" class="w-full mb-2 textarea" required>{{ $blog->content }}</textarea>
            <label class="flex items-center gap-2">
                <input type="checkbox" name="is_premium" value="1" {{ $blog->is_premium ? 'checked' : '' }}> Premium
            </label>
            <button type="submit" class="mt-2 btn btn-primary">Actualizar</button>
        </form>
    </section>
</x-layout>
