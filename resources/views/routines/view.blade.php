<x-layout>
    <section class="max-w-6xl mx-auto px-5 pt-5 rounded-t-3xl bg-white min-h-screen">
        <x-slot:title> {{ $routine->name }} </x-slot:title>

        <h1 class="mb-3"> {{ $routine->name }} </h1>
        <p>? pasos · ? productos</p>

        <h4>Productos en la rutina {{ $routine->name }}</h4>
        <ul>
        @foreach ($routine->products ?? [] as $productId)
            @php
                $product = \App\Models\Product::find($productId);
            @endphp
            <li>{{ $product->name ?? 'Producto eliminado' }}</li>
        @endforeach
        </ul>
    </section>
</x-layout>
