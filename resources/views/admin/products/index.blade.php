<?php
/** @var \Illuminate\Database\Eloquent\Collection|\App\Models\Post[] $products */
?>

<x-layout :title="'Productos - Panel de Administración'">
    <div class="container my-5 bg-white rounded-t-3xl min-h-full pt-5">
        <div class="flex justify-between items-center mb-4 px-5">
            <h1 class="text-3xl font-bold text-[#306067]">Productos</h1>
            @auth
            <a href="{{ route('admin.products.create') }}" class="btn font-bold text-white bg-[#306067] border-[#306067] btn-primary mb-3">Crear Producto</a>
            @endauth
        </div>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Marca</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->brand->name }}</td>
                        <td>
                            <a href="{{ route('admin.products.view', $product) }}" class="btn font-bold text-white bg-[#37A0AF] border-[#37A0AF] btn-info btn-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#FFFFFF"><path d="M240-400q-33 0-56.5-23.5T160-480q0-33 23.5-56.5T240-560q33 0 56.5 23.5T320-480q0 33-23.5 56.5T240-400Zm240 0q-33 0-56.5-23.5T400-480q0-33 23.5-56.5T480-560q33 0 56.5 23.5T560-480q0 33-23.5 56.5T480-400Zm240 0q-33 0-56.5-23.5T640-480q0-33 23.5-56.5T720-560q33 0 56.5 23.5T800-480q0 33-23.5 56.5T720-400Z"/></svg>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-layout>
