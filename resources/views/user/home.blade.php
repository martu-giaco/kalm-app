
<x-layout title="Kälm | Inicio">
    <section class="px-5">
        {{-- Categorías --}}
    <div class="mb-6">
        <h2 class="text-xl font-semibold text-(--kalm-dark) mb-4">Categorías</h2>
        @if($categories->isNotEmpty())
            <div class="flex space-x-4 overflow-x-auto pb-2 scrollbar-hide">
                @foreach ($categories as $category)
                    @if(!empty($category->slug))
                        <a href="{{ route('products.byCategory', ['slug' => $category->slug]) }}"
                            class="shrink-0 w-20 flex flex-col items-center">
                            <div
                                class="h-16 w-16 bg-(--kalm-light) rounded-full flex items-center justify-center p-3 text-(--kalm-dark)">
                                {!! $category->icon_svg !!}
                            </div>

                            <span class="text-xs font-medium text-(--kalm-text) mt-2 text-center leading-tight">
                                {{ $category->name }}
                            </span>
                        </a>
                    @endif
                @endforeach
            </div>
        @else
            <p class="text-sm text-(--kalm-text)]">No hay categorías disponibles.</p>
        @endif
    </div>

    {{-- Barra de búsqueda --}}
    <div class="mb-[-3vw] relative">
        <form action="{{ route('products.search') }}" method="GET">
            {{-- Lupa dentro del input --}}
            <span class="absolute left-3 top-1/2 -translate-y-1/2">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#2A4043"><path d="M380-320q-109 0-184.5-75.5T120-580q0-109 75.5-184.5T380-840q109 0 184.5 75.5T640-580q0 44-14 83t-38 69l224 224q11 11 11 28t-11 28q-11 11-28 11t-28-11L532-372q-30 24-69 38t-83 14Zm0-80q75 0 127.5-52.5T560-580q0-75-52.5-127.5T380-760q-75 0-127.5 52.5T200-580q0 75 52.5 127.5T380-400Z"/></svg>
            </span>

            <input type="text" name="q" placeholder="Buscar productos, marcas o ingredientes" value="{{ request('q') }}"
                class="w-full pl-10 p-3 rounded-xl shadow-2xl bg-white border border-[#CCE2E5] text-[#306067] placeholder-[#CCE2E5]
                    focus:outline-none focus:ring-2 focus:ring-[#37A0AF] focus:border-[#37A0AF]">
        </form>
    </div>

    </section>
<section class="px-5 pt-10 rounded-t-3xl bg-white">
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
            <h2 class="text-lg font-semibold text-(--kalm-dark)] mb-4">{{ $section['title'] }}</h2>
            <div class="flex space-x-6 overflow-x-auto pb-4 scrollbar-hide">
                @foreach ($products_with_tag as $product)
                    @include('components.product_card', ['product' => $product, 'class' => 'w-40 md:w-44'])
                @endforeach


            </div>
        </div>
    @endforeach

    {{-- Favoritos --}}
    <div class="mb-8">
        <h2 class="text-lg font-semibold text-(--kalm-dark)] mb-4">Favoritos de la Comunidad</h2>
        <div class="flex space-x-6 overflow-x-auto pb-4 scrollbar-hide">
            @foreach ($topRatedProducts as $product)
                @include('components.product_card', ['product' => $product, 'class' => 'w-40 md:w-44'])
            @endforeach
        </div>
    </div>

    <div class="h-8"></div>

</section>
</x-layout>
