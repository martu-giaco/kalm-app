{{-- resources/views/routines/show.blade.php --}}

<x-layout :title="$routine->name">
    <div class="max-w-6xl mx-auto p-4">

        <h1 class="text-2xl font-bold mb-4">{{ $routine->name }}</h1>

        {{-- Productos de la rutina --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @php
                $products = json_decode($routine->products ?? '[]', true);
            @endphp

            @foreach($products as $productId)
                @php
                    $product = \App\Models\Product::find($productId);
                @endphp

                @if($product)
                    <div class="border p-3 rounded-lg shadow hover:shadow-lg transition">
                        <img src="{{ asset($product->img_src) }}" alt="{{ $product->name }}" class="w-full h-32 object-cover mb-2">
                        <h3 class="font-semibold text-[#306067]">{{ $product->name }}</h3>
                    </div>
                @endif
            @endforeach
        </div>

        @if(count($products) === 0)
            <p class="text-gray-500 mt-4">No hay productos en esta rutina.</p>
        @endif

    </div>
</x-layout>
