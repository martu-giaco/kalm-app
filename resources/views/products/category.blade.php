<!-- filepath: resources/views/products/category.blade.php -->

<x-layout :title="$category->name">

    <div class="px-4 pt-6">
        {{-- Título de la categoría --}}
        <h1 class="text-3xl font-bold text-[var(--kalm-dark)] mb-6">
            {{ $category->name }}
        </h1>

        @if($products->isEmpty())
            <p class="text-[var(--kalm-text)]">No hay productos en esta categoría.</p>
        @else
            {{-- Lista de productos --}}
            <div class="flex flex-col gap-4">
                @foreach($products as $product)
                    <div class="flex items-center border-b border-gray-200 py-3">
                        {{-- Imagen del producto --}}
                        <div class="flex-shrink-0 w-20 h-20 rounded-full overflow-hidden bg-[var(--kalm-light)]">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">

                        </div>

                        {{-- Info del producto --}}
                        <div class="ml-4 flex-1">
                            <h3 class="text-sm font-medium text-[var(--kalm-dark)]">{{ $product->name }}</h3>
                            <p class="text-xs text-[var(--kalm-text)] mt-1">{{ $product->brand->name }}</p>
                            @if(isset($product->resolved_tag_text))
                                <span class="inline-block mt-2 px-2 py-0.5 text-xs font-semibold rounded {{ $product->tag_class ?? 'bg-teal-100 text-teal-800' }}">
                                    {{ $product->resolved_tag_text }}
                                </span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

</x-layout>
