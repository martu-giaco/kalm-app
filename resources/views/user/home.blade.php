
<x-layout title="Kälm | Inicio">

    {{-- Categorías --}}
    <div class="mb-6">
        <h2 class="text-xl font-semibold text-[var(--kalm-dark)] mb-4">Categorías</h2>
        @if($categories->isNotEmpty())
            <div class="flex space-x-4 overflow-x-auto pb-2 scrollbar-hide">
                @foreach ($categories as $category)
                    @if(!empty($category->slug))
                        <a href="{{ route('products.byCategory', ['slug' => $category->slug]) }}"
                            class="flex-shrink-0 w-20 flex flex-col items-center">
                            <div
                                class="h-16 w-16 bg-[var(--kalm-light)] rounded-full flex items-center justify-center p-3 text-[var(--kalm-dark)]">
                                {!! $category->icon_svg !!}
                            </div>

                            <span class="text-xs font-medium text-[var(--kalm-text)] mt-2 text-center leading-tight">
                                {{ $category->name }}
                            </span>
                        </a>
                    @endif
                @endforeach
            </div>
        @else
            <p class="text-sm text-[var(--kalm-text)]">No hay categorías disponibles.</p>
        @endif
    </div>

    {{-- Barra de búsqueda --}}
    <div class="mb-6 relative">
        <form action="{{ route('products.search') }}" method="GET">
            {{-- Lupa dentro del input --}}
            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1110.5 3a7.5 7.5 0 016.15 13.65z" />
                </svg>
            </span>

            <input type="text" name="q" placeholder="Buscar productos, marcas o ingredientes" value="{{ request('q') }}"
                class="w-full pl-10 p-3 rounded-xl border border-gray-400 bg-white text-gray-700 shadow-sm
                      focus:outline-none focus:ring-2 focus:ring-[var(--kalm-main)] focus:border-[var(--kalm-main)]">
        </form>
    </div>



    {{-- Banners --}}
    <div class="mb-8 h-40 w-full relative overflow-hidden rounded-xl">
        @foreach ($banners as $banner)
            <img src="{{ asset($banner['img_src']) }}" alt="{{ $banner['alt'] }}" class="w-full h-full object-cover">
        @endforeach
    </div>

    {{-- Secciones de productos --}}
    @foreach ($product_sections as $section)
        @php
            $current_tag_text = $section['tag_text'] ?? null;

            $products_with_tag = $section['products']->map(function ($product) use ($section, $current_tag_text) {
                if (isset($section['tag_text_func']) && is_callable($section['tag_text_func'])) {
                    $product->resolved_tag_text = $section['tag_text_func']($product);
                } else {
                    $product->resolved_tag_text = $current_tag_text;
                }
                return $product;
            });
        @endphp

        <div class="mb-8">
            <h2 class="text-lg font-semibold text-[var(--kalm-dark)] mb-4">{{ $section['title'] }}</h2>
            <div class="flex space-x-6 overflow-x-auto pb-4 scrollbar-hide">
                @foreach ($products_with_tag as $product)
                    @include('components.product_card', ['product' => $product, 'class' => 'w-40 md:w-44'])
                @endforeach


            </div>
        </div>
    @endforeach

    {{-- Favoritos --}}
    <div class="mb-8">
        <h2 class="text-lg font-semibold text-[var(--kalm-dark)] mb-4">Favoritos de la Comunidad</h2>
        <div class="flex space-x-6 overflow-x-auto pb-4 scrollbar-hide">
            @foreach ($topRatedProducts as $product)
                @include('components.product_card', ['product' => $product, 'class' => 'w-40 md:w-44'])
            @endforeach
        </div>
    </div>

    <div class="h-8"></div>

</x-layout>
