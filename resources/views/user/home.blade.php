<x-layout title="Kälm | Inicio">

    <section class="px-5">
        {{-- Barra de búsqueda --}}
        <div class="mb-[-3vw] relative">
            <form action="{{ route('products.search') }}" method="GET">
                <span class="absolute -translate-y-1/2 left-3 top-1/2">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                        class="fill-[#306067] dark:fill-[#CCE2E5]">
                        <path
                            d="M378.09-314.5q-111.16 0-188.33-77.17-77.17-77.18-77.17-188.33t77.17-188.33q77.17-77.17 188.33-77.17 111.15 0 188.32 77.17 77.18 77.18 77.18 188.33 0 44.48-13.52 83.12-13.53 38.64-36.57 68.16l222.09 222.33q12.67 12.91 12.67 31.94 0 19.04-12.91 31.71-12.68 12.67-31.83 12.67t-31.82-12.67L529.85-364.59q-29.76 23.05-68.64 36.57-38.88 13.52-83.12 13.52Zm0-91q72.84 0 123.67-50.83 50.83-50.82 50.83-123.67t-50.83-123.67q-50.83-50.83-123.67-50.83-72.85 0-123.68 50.83-50.82 50.82-50.82 123.67t50.82 123.67q50.83 50.83 123.68 50.83Z" />
                    </svg>
                </span>

                <input type="text" name="q" placeholder="Buscar productos, marcas o categorías"
                    value="{{ request('q') }}"
                    class="w-full pl-10 p-3 rounded-xl shadow-md bg-white border border-[#CCE2E5] text-[#306067] placeholder-[#CCE2E5] dark:bg-[#306067] dark:border-[#CCE2E5] dark:text-[#E9E5E3] dark:placeholder:text-[#CCE2E5]
                        focus:outline-none focus:ring-0 focus:ring-[#37A0AF] focus:border-[#37A0AF]">
            </form>
        </div>
    </section>

    <section class="px-5 py-10 bg-white dark:bg-[#2A4043] rounded-t-3xl">

        {{-- Banner principal --}}
        <a href="{{ route('subscription.show') }}" class="relative block w-full h-40 mb-8 overflow-hidden rounded-xl">
            @foreach ($banners as $banner)
                <img src="{{ asset($banner['img_src']) }}" alt="{{ $banner['alt'] }}"
                    class="object-cover w-full h-full">
            @endforeach
        </a>




        {{-- Categorías --}}
        <div class="mb-6">
            <h2 class="text-xl font-semibold text-[#2A4043] dark:text-[#E9E5E3] mb-4">Categorías</h2>

            @php
                $currentSlug = request()->route('slug');
            @endphp

            @if ($categories->isNotEmpty())
                <div class="flex pb-2 space-x-4 overflow-x-auto scrollbar-hide">

                    @foreach ($categories as $category)
                        @if (!empty($category->slug))
                            @php
                                $isActive = $category->slug === $currentSlug;
                            @endphp

                            <a href="{{ route('products.byCategory', ['category' => $category->slug]) }}"
                                class="flex flex-col items-center w-20 shrink-0">

                                <div
                                    class="h-21 w-21 rounded-full flex items-center justify-center p-3
                                    @if ($isActive) bg-[#2A4043] text-white @else bg-[var(--kalm-light)] text-[#2A4043] dark:text-[#E9E5E3] @endif">

                                    <picture>
                                        @if (!empty($category->icon_dark))
                                            <source srcset="{{ $category->icon_dark }}" media="(prefers-color-scheme: dark)">
                                        @endif
                                        <img class="w-full" src="{{ $category->icon_light ?? $category->icon_dark }}" alt="{{ $category->name }}">
                                    </picture>
                                </div>

                                <span class="text-xs font-medium text-[#2A4043] dark:text-[#E9E5E3] mt-2 text-center leading-tight">
                                    {{ $category->name }}
                                </span>
                            </a>
                        @endif
                    @endforeach

                </div>
            @else
                <p class="text-sm text-[#2A4043] dark:text-[#E9E5E3]">No hay categorías disponibles.</p>
            @endif
        </div>

        {{-- BANNERS - LAYOUT --}}
        <div class="grid grid-cols-2 grid-rows-2 gap-4 mb-10 h-[260px]">

            {{-- Banner grande (Tests) --}}
            <a href="{{ route('tests.index') }}"
                class="relative col-span-2 row-span-1 overflow-hidden rounded-2xl group">

                <img src="{{ asset('images/banners/tests.png') }}" alt="Tests"
                    class="object-cover w-full h-full transition duration-500 group-hover:scale-105">

                <div class="absolute inset-0 bg-gradient-to-r from-black/60 via-black/30 to-transparent"></div>

                <div class="absolute inset-0 flex flex-col justify-center px-5">
                    <h3 class="text-xl font-bold text-white">Descubrir tu piel y tu cabello</h3>
                    <p class="text-[#CCE2E5] text-sm">Hacer tu test personalizado</p>
                </div>
            </a>

            {{-- Banner Blog --}}
            <a href="{{ route('blog.index') }}" class="relative overflow-hidden rounded-2xl group">

                <img src="{{ asset('images/banners/blogs.png') }}" alt="Blog"
                    class="object-cover w-full h-full transition duration-500 group-hover:scale-105">

                <div class="absolute inset-0 transition bg-black/30 group-hover:bg-black/40"></div>

                <div class="absolute inset-0 flex flex-col justify-end p-3">
                    <h3 class="text-sm font-semibold text-white">Blog</h3>
                    <p class="text-[#CCE2E5] text-xs">Tips y guías</p>
                </div>
            </a>

            {{-- Banner Productos --}}
            <a href="{{ route('products.search') }}" class="relative overflow-hidden rounded-2xl group">

                <img src="{{ asset('images/banners/products.png') }}" alt="Productos"
                    class="object-cover w-full h-full transition duration-500 group-hover:scale-105">

                <div class="absolute inset-0 transition bg-black/30 group-hover:bg-black/40"></div>

                <div class="absolute inset-0 flex flex-col justify-end p-3">
                    <h3 class="text-sm font-semibold text-white">Productos</h3>
                    <p class="text-[#CCE2E5] text-xs">Explorar catálogo</p>
                </div>
            </a>

        </div>

        {{-- Secciones de productos --}}
        @foreach ($product_sections as $section)
            @php
                $products_with_tag = $section['products'];
            @endphp

            <div class="mb-10">
                <div class="flex items-center justify-between mb-2">
                    <h2 class="text-xl font-bold text-[#306067] dark:text-[#CCE2E5]">{{ $section['title'] }}</h2>
                </div>
                <div class="flex pb-4 space-x-6 overflow-x-auto scrollbar-hide">
                    @foreach ($products_with_tag as $product)
                        <x-product-card :product="$product" />
                    @endforeach
                </div>
            </div>
        @endforeach

    </section>

</x-layout>
```
