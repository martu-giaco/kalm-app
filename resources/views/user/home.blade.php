<x-layout title="Kälm | Inicio">

    <section class="px-5">
        {{-- Categorías --}}
        <div class="mb-6">
            <h2 class="text-xl font-semibold text-[var(--kalm-dark)] mb-4">Categorías</h2>

            @php
                // Obtener el slug de la categoría actual de la URL para resaltar la activa.
                // Si la ruta es 'products.byCategory', $currentSlug será el slug. Si es 'products.index', será null.
                $currentSlug = request()->route('slug');
            @endphp

            @if($categories->isNotEmpty())
                <div class="flex space-x-4 overflow-x-auto pb-2 scrollbar-hide">


                    @foreach ($categories as $category)
                        @if(!empty($category->slug))
                            {{-- Lógica de navegación existente, ahora con resaltado --}}
                            @php
                                $isActive = ($category->slug === $currentSlug);
                            @endphp

                            <a href="{{ route('products.byCategory', ['category' => $category->slug]) }}"
                                class="shrink-0 w-20 flex flex-col items-center">
                                <div
                                    class="h-16 w-16 rounded-full flex items-center justify-center p-3
                                                {{-- Clase condicional para resaltar la categoría activa --}}
                                                @if($isActive) bg-[var(--kalm-dark)] text-white @else bg-[var(--kalm-light)] text-[var(--kalm-dark)] @endif">
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
        <div class="mb-[-3vw] relative">
            <form action="{{ route('products.search') }}" method="GET">
                <span class="absolute left-3 top-1/2 -translate-y-1/2">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                        fill="#2A4043">
                        <path
                            d="M380-320q-109 0-184.5-75.5T120-580q0-109 75.5-184.5T380-840q109 0 184.5 75.5T640-580q0 44-14 83t-38 69l224 224q11 11 11 28t-11 28q-11 11-28 11t-28-11L532-372q-30 24-69 38t-83 14Zm0-80q75 0 127.5-52.5T560-580q0-75-52.5-127.5T380-760q-75 0-127.5 52.5T200-580q0 75 52.5 127.5T380-400Z" />
                    </svg>
                </span>

                <input type="text" name="q" placeholder="Buscar productos, marcas o ingredientes"
                    value="{{ request('q') }}" class="w-full pl-10 p-3 rounded-xl shadow-2xl bg-white border border-[#CCE2E5] text-[#306067] placeholder-[#CCE2E5]
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

        @foreach ($product_sections as $section)
            @php
                $products_with_tag = $section['products'];
            @endphp

            <div class="mb-8">
                <h2 class="text-lg font-semibold text-[var(--kalm-dark)] mb-4">{{ $section['title'] }}</h2>
                <div class="flex space-x-6 overflow-x-auto pb-4 scrollbar-hide">
                    @foreach ($products_with_tag as $product)
                        <a href="{{ route('products.show', $product->id) }}" class="w-40 md:w-44 flex-shrink-0 group">
                            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition duration-300">

                                {{-- Imagen del producto --}}
                                <div class="w-full h-40 overflow-hidden">
                                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                                        class="w-full h-full object-cover transition duration-300 group-hover:scale-105">
                                </div>

                                {{-- Info simplificada --}}
                                <div class="p-3 flex flex-col gap-1">
                                    <h3 class="text-sm font-semibold text-[var(--kalm-dark)] mb-1 truncate">
                                        {{ $product->name }}
                                    </h3>

                                    @if(!empty($product->brand?->name))
                                        <p class="text-[10px] text-gray-500 truncate">Marca: {{ $product->brand->name }}</p>
                                    @endif
                                    @if(!empty($product->type?->name))
                                        <p class="text-[10px] text-gray-500 truncate">Tipo: {{ $product->type->name }}</p>
                                    @endif
                                    @if(!empty($product->category?->name))
                                        <p class="text-[10px] text-gray-500 truncate">Categoría: {{ $product->category->name }}</p>
                                    @endif
                                </div>

                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endforeach


        <div class="h-8"></div>
    </section>

</x-layout>
