<?php
/** @var \Illuminate\Database\Eloquent\Collection|\App\Models\Post[] $blogs */
?>

<x-layout :title="'Blogs - Panel de Administración'">
    <div class="container my-5 bg-white rounded-t-3xl min-h-full pt-5">
        <div class="flex justify-between items-center mb-4 px-5">
            <h1 class="text-3xl font-bold text-[#306067]">Blogs</h1>
            @auth
            <a href="{{ route('admin.blog.create') }}" class="btn font-bold text-white bg-[#306067] border-[#306067] btn-primary mb-3">Crear Blog</a>
            @endauth
        </div>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($blogs as $blog)
                    <tr>
                        <td>{{ $blog->id }}</td>
                        <td>{{ $blog->title }}</td>
                        <td>{{ $blog->author }}</td>
                        <td>
                            <a href="{{ route('admin.blog.view', $blog) }}" class="btn font-bold text-white bg-[#37A0AF] border-[#37A0AF] btn-info btn-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#FFFFFF"><path d="M240-400q-33 0-56.5-23.5T160-480q0-33 23.5-56.5T240-560q33 0 56.5 23.5T320-480q0 33-23.5 56.5T240-400Zm240 0q-33 0-56.5-23.5T400-480q0-33 23.5-56.5T480-560q33 0 56.5 23.5T560-480q0 33-23.5 56.5T480-400Zm240 0q-33 0-56.5-23.5T640-480q0-33 23.5-56.5T720-560q33 0 56.5 23.5T800-480q0 33-23.5 56.5T720-400Z"/></svg>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-layout>
