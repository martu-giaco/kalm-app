<x-layout title="Crear Producto">
    <div class="container my-5 px-5 bg-white rounded-t-3xl min-h-full pt-5">
        <h1 class="text-3xl font-bold text-[#306067] mb-4">Crear Producto</h1>

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <input type="text" name="name" placeholder="Nombre" class="w-full border rounded p-2" required>
            <input type="number" name="brand_id" placeholder="ID Marca" class="w-full border rounded p-2" required>
            <input type="file" name="image" class="w-full border rounded p-2">
            <textarea name="description" placeholder="Descripción" class="w-full border rounded p-2"></textarea>
            <textarea name="ingredients" placeholder="Ingredientes" class="w-full border rounded p-2"></textarea>
            <textarea name="activos" placeholder="Activos" class="w-full border rounded p-2"></textarea>
            <input type="text" name="paso" placeholder="Paso" class="w-full border rounded p-2">
            <input type="text" name="formato" placeholder="Formato" class="w-full border rounded p-2">
            <input type="text" name="tipo" placeholder="Tipo" class="w-full border rounded p-2">
            <input type="number" name="rating" placeholder="Rating" min="0" max="5" class="w-full border rounded p-2">
            <textarea name="dondeComprar" placeholder="Dónde comprar" class="w-full border rounded p-2"></textarea>

            <button type="submit" class="btn w-full px-5 py-3 rounded-xl text-white font-bold transition cursor-pointer disabled:opacity-80 disabled:cursor-not-allowed hover:bg-[#306067] bg-[#306067]">Crear Producto</button>
        </form>
    </div>
</x-layout>
