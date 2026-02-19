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
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#FFFFFF"><path d="M200-200h57l391-391-57-57-391 391v57Zm-40 80q-17 0-28.5-11.5T120-160v-97q0-16 6-30.5t17-25.5l505-504q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L313-143q-11 11-25.5 17t-30.5 6h-97Zm600-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z"/></svg>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-layout>
