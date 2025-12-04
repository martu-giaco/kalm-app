<x-layout :title="'Resultado de ' . ucfirst($test->key)">
    <div class="max-w-3xl mx-auto px-4 py-8">
        <article class="bg-white rounded-2xl p-6 shadow-lg">

            <h1 class="text-2xl font-semibold text-[#164d4f] mb-4">
                Tu rutina recomendada: {{ ucfirst($routine->name) }}
            </h1>

            <p class="text-gray-700 mb-4">
                Según tus respuestas, esta es la rutina ideal para tu tipo de piel.
            </p>

            <h2 class="text-xl font-semibold text-[#164d4f] mb-2">Productos recomendados:</h2>
            <ul class="list-disc list-inside text-gray-700">
                @foreach($routine->products as $productId)
                    @php
                        $product = App\Models\Product::find($productId);
                    @endphp

                    @if($product)
                        <li>{{ $product->name }}</li>
                    @endif
                @endforeach
            </ul>

        </article>
    </div>
</x-layout>
