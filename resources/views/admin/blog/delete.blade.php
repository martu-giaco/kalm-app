<?php
/** @var \App\Models\blog $blog */
?>

<x-layout>
    <div class="container my-5">
        <x-slot:title>Eliminar blog {{ $blog->title}}</x-slot:title>

        <h1 class="mb-3">Confirmación para eliminar {{ $blog->title }}</h1>

        <form action="{{ route('blogs.destroy', $blog) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Sí, Eliminar {{ $blog->title }}</button>
        </form>
    </div>
</x-layout>
