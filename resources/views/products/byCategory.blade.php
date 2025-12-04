<x-layout :title="$category->name">
    <section class="px-5 pt-10 rounded-t-3xl bg-white min-h-screen">

        {{-- Título de la Categoría --}}
        <h1 class="text-3xl font-bold text-[var(--kalm-dark)] mb-6 border-b pb-3 border-gray-100">
            {{ $category->name }}
        </h1>

        @if($products->isEmpty())
            <p class="text-[var(--kalm-text)] text-lg py-10 text-center">
                No hemos encontrado productos en esta categoría.
            </p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 pb-20">
                @foreach($products as $product)
                    <a href="{{ route('products.show', $product->id) }}" class="block group">
                        <div class="bg-white border border-gray-100 rounded-xl shadow-lg hover:shadow-xl transition duration-300 overflow-hidden h-full flex flex-col">

                            {{-- Imagen del producto --}}
                            <div class="w-full h-40 overflow-hidden">
                                <img src="{{ asset('storage/' . $product->image) }}"
                                     alt="{{ $product->name }}"
                                     class="w-full h-full object-cover transition duration-300 group-hover:scale-105">
                            </div>

                            {{-- Información del producto --}}
                            <div class="p-4 flex-1 flex flex-col justify-between">
                                <div>
                                    <h3 class="text-base font-semibold text-[var(--kalm-dark)] mb-1 leading-tight">
                                        {{ $product->name }}
                                    </h3>

                                    @if($product->brand)
                                        <p class="text-xs text-gray-500 mb-2">
                                            Marca: {{ $product->brand->name }}
                                        </p>
                                    @endif

                                    @if($product->type)
                                        <p class="text-xs text-gray-500 mb-2">
                                            Tipo: {{ $product->type->name }}
                                        </p>
                                    @endif
                                </div>

                                @if(!empty($product->resolved_tag_text))
                                    <span
                                        class="inline-block mt-3 px-2 py-0.5 text-xs font-semibold rounded-full self-start {{ $product->tag_class ?? 'bg-teal-100 text-teal-800' }}">
                                        {{ $product->resolved_tag_text }}
                                    </span>
                                @endif
                            </div>

                        </div>
                    </a>
                @endforeach
            </div>
        @endif

    </section>
</x-layout>
