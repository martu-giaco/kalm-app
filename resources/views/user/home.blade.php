<x-layout title="Kälm | Inicio">

    <section class="px-5">
        {{-- Barra de búsqueda --}}
        <div class="mb-[-3vw] relative">
            <form action="{{ route('products.search') }}" method="GET">
                <span class="absolute -translate-y-1/2 left-3 top-1/2">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#306067"><path d="M378.09-314.5q-111.16 0-188.33-77.17-77.17-77.18-77.17-188.33t77.17-188.33q77.17-77.17 188.33-77.17 111.15 0 188.32 77.17 77.18 77.18 77.18 188.33 0 44.48-13.52 83.12-13.53 38.64-36.57 68.16l222.09 222.33q12.67 12.91 12.67 31.94 0 19.04-12.91 31.71-12.68 12.67-31.83 12.67t-31.82-12.67L529.85-364.59q-29.76 23.05-68.64 36.57-38.88 13.52-83.12 13.52Zm0-91q72.84 0 123.67-50.83 50.83-50.82 50.83-123.67t-50.83-123.67q-50.83-50.83-123.67-50.83-72.85 0-123.68 50.83-50.82 50.82-50.82 123.67t50.82 123.67q50.83 50.83 123.68 50.83Z"/></svg>
                </span>

                <input type="text" name="q" placeholder="Buscar productos, marcas o categorías"
                    value="{{ request('q') }}"
                    class="w-full pl-10 p-3 rounded-xl shadow-md bg-white border border-[#CCE2E5] text-[#306067] placeholder-[#CCE2E5]
                        focus:outline-none focus:ring-0 focus:ring-[#37A0AF] focus:border-[#37A0AF]">
            </form>
        </div>
    </section>

    <section class="px-5 py-10 rounded-t-3xl bg-white">
        {{-- Banners --}}
        <div class="relative w-full h-40 mb-8 overflow-hidden rounded-xl"  onclick="premium_modal.showModal()">
            @foreach ($banners as $banner)
                <img src="{{ asset($banner['img_src']) }}" alt="{{ $banner['alt'] }}"
                    class="object-cover w-full h-full">
            @endforeach
        </div>

        {{-- Categorías --}}
        <div class="mb-6">
            <h2 class="text-xl font-semibold text-[var(--kalm-dark)] mb-4">Categorías</h2>

            @php
                // Obtener el slug de la categoría actual de la URL para resaltar la activa.
                // Si la ruta es 'products.byCategory', $currentSlug será el slug. Si es 'products.index', será null.
                $currentSlug = request()->route('slug');
            @endphp

            @if ($categories->isNotEmpty())
                <div class="flex pb-2 space-x-4 overflow-x-auto scrollbar-hide">


                    @foreach ($categories as $category)
                        @if (!empty($category->slug))
                            {{-- Lógica de navegación existente, ahora con resaltado --}}
                            @php
                                $isActive = $category->slug === $currentSlug;
                            @endphp

                            <a href="{{ route('products.byCategory', ['category' => $category->slug]) }}"
                                class="flex flex-col items-center w-20 shrink-0">
                                <div
                                    class="h-16 w-16 rounded-full flex items-center justify-center p-3
                                                {{-- Clase condicional para resaltar la categoría activa --}}
                                                @if ($isActive) bg-[var(--kalm-dark)] text-white @else bg-[var(--kalm-light)] text-[var(--kalm-dark)] @endif">
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

        @foreach ($product_sections as $section)
            @php
                $products_with_tag = $section['products'];
            @endphp

            <div class="mb-8">
                <h2 class="text-lg font-semibold text-[var(--kalm-dark)] mb-2">{{ $section['title'] }}</h2>
                <div class="flex pb-4 space-x-6 overflow-x-auto scrollbar-hide">
                    @foreach ($products_with_tag as $product)
                        <a href="{{ route('products.show', $product->id) }}" class="flex-shrink-0 w-40 md:w-44 group">
                            <div
                                class="overflow-hidden transition duration-300 bg-white shadow-md rounded-xl hover:shadow-lg">

                                {{-- Imagen del producto --}}
                                <div class="w-full h-40 overflow-hidden">
                                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                                        class="object-cover w-full h-full transition duration-300 group-hover:scale-105">
                                </div>

                                {{-- Info simplificada --}}
                                <div class="flex flex-col p-3">
                                    <h3 class="text-sm font-semibold text-[#2A4043] truncate">
                                        {{ $product->name }}
                                    </h3>

                                    @if (!empty($product->brand?->name))
                                        <h3 class="text-[13px] text-[#37A0AF] truncate">
                                            {{ $product->brand->name }}</h3>
                                    @endif
                                    @if (!empty($product->type?->name))
                                        <button class="text-[10px] mt-2 w-20 inline-block text-white truncate bg-[#37A0AF] px-2 py-1 rounded-xl">
                                            ✨{{ $product->type->name }}
                                        </button>
                                    @endif
                                </div>

                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endforeach
    </section>

</x-layout>
