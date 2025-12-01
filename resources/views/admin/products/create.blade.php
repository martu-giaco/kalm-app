<x-layout title="Crear Producto">
    <div class="p-4">
        <h1 class="text-2xl font-bold mb-4">Crear Producto</h1>

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

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Crear Producto</button>
        </form>
    </div>
</x-layout>
