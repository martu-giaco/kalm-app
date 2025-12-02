<x-layout class="px-5 pt-10 rounded-t-3xl bg-white" title="Mis Favoritos">

    {{-- Mensaje si no hay favoritos --}}
    @if($products->isEmpty())
        <p class="text-center text-[var(--kalm-text)] mt-8">No tienes productos favoritos todavía.</p>
    @else

        {{-- Agrupar productos por categoría --}}
        @php
            $productsByCategory = $products->groupBy(fn($product) => $product->category->name ?? 'Sin Categoría');
        @endphp

        @foreach($productsByCategory as $categoryName => $categoryProducts)
            <div class="mb-8">
                {{-- Título de categoría --}}
                <h2 class="text-lg font-semibold text-[#306067] mb-4">{{ $categoryName }}</h2>

                {{-- Agrupar por etiqueta si existe --}}
                @php
                    $productsByTag = $categoryProducts->groupBy(fn($p) => $p->resolved_tag_text ?? '');
                @endphp

                @foreach($productsByTag as $tagText => $tagProducts)
                    <div class="mb-4">
                        @if($tagText)
                            <h3 class="text-sm font-medium text-[var(--kalm-main)] mb-2">{{ $tagText }}</h3>
                        @endif

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            @foreach($tagProducts as $product)
                                @include('components.product_card', ['product' => $product])
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach

    @endif

</x-layout>
