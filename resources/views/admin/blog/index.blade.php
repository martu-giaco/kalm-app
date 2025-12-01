<?php
/** @var \Illuminate\Database\Eloquent\Collection|\App\Models\Post[] $blogs */
?>

<x-layout>
    <div class="container my-5 bg-white rounded-t-3xl min-h-[87%]">
        <x-slot:title>Listado de Blogs</x-slot:title>

        <h1 class="mb-3">Blogs</h1>

        @auth
        <a href="{{ route('blog.create') }}" class="btn btn-primary mb-3">Crear Post</a>
        @endauth

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Categoría</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($blogs as $blog)
                    <tr>
                        <td>{{ $blog->id }}</td>
                        <td>{{ $blog->title }}</td>
                        <td>{{ $blog->author }}</td>
                        <td>{{ $blog->category }}</td>
                        <td>
                            <a href="{{ route('blog.view', $blog) }}" class="btn btn-info btn-sm">Ver</a>
                            @auth
                            <a href="{{ route('blog.edit', $blog) }}" class="btn btn-sm btn-secondary">Editar</a>
                            <a href="{{ route('blog.destroy', $blog) }}" class="btn btn-danger btn-sm">Eliminar</a>
                            @endauth
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-layout>
