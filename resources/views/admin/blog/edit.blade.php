<?php
/** \Illuminate\Support\ViewErrorBag $errors */
?>

<x-layout>
    <div class="container my-5 bg-white rounded-t-3xl min-h-[87%]" >
        <x-slot:title>Editar Blog</x-slot:title>

        <h1 class="mb-3">Editar Blog</h1>

        @if ($errors->any())
            <div class="alert alert-danger">La información contiene errores.</div>
        @endif

        <form action="{{ route('blog.edit', $blog) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="title" class="form-label">Título</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $blog->title) }}">
            </div>

            <div class="mb-3">
                <label for="content" class="form-label">Contenido</label>
                <textarea name="content" id="content" class="form-control">{{ old('content', $blog->content) }}</textarea>
            </div>

            <div class="mb-3">
                <label for="author" class="form-label">Autor</label>
                <input type="text" name="author" id="author" class="form-control" value="{{ old('author', $blog->author) }}">
            </div>

            <div class="mb-3">
                <label for="category" class="form-label">Categoría</label>
                <select name="category" id="category" class="form-select">
                    <option value="">Seleccioná una categoría</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ old('category', $blog->category) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Imagen (opcional)</label>
                @if($blog->image)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}" style="max-width: 200px; max-height: 200px;">
                    </div>
                @endif
                <input type="file" id="image" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                @error('image')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Editar Blog</button>
        </form>
    </div>
</x-layout>
