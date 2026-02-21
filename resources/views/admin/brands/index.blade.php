<?php
/** @var \Illuminate\Database\Eloquent\Collection|\App\Models\Post[] $brands */
?>

<x-layout :title="'Marcas - Panel de Administración'">
    <div class="container my-5 bg-white rounded-t-3xl min-h-full pt-5">
        <div class="flex justify-between items-center mb-4 px-5">
            <h1 class="text-3xl font-bold text-[#306067]">Marcas</h1>
            @auth
            <a href="{{ route('admin.home') }}" class="btn font-bold text-white bg-[#306067] border-[#306067] btn-primary mb-3">Crear Marca</a>
            @endauth
        </div>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($brands as $brand)
                    <tr>
                        <td>{{ $brand->id }}</td>
                        <td>{{ $brand->name }}</td>
                        <td>
                            <a href="{{ route('admin.home', $brand) }}" class="btn font-bold text-white bg-[#37A0AF] border-[#37A0AF] btn-info btn-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#FFFFFF"><path d="M240-400q-33 0-56.5-23.5T160-480q0-33 23.5-56.5T240-560q33 0 56.5 23.5T320-480q0 33-23.5 56.5T240-40₀Z"/></svg>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-layout>
