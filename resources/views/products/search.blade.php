{{-- filepath: resources/views/products/search.blade.php --}}

<x-layout title="Kälm | Resultados de Búsqueda">

    <section class="px-5">
        {{-- Barra de búsqueda --}}
        <div class="mb-[-3vw] relative">
            <form action="{{ route('products.search') }}" method="GET">
                <span class="absolute -translate-y-1/2 left-3 top-1/2">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                        fill="#2A4043">
                        <path
                            d="M380-320q-109 0-184.5-75.5T120-580q0-109 75.5-184.5T380-840q109 0 184.5 75.5T640-580q0 44-14 83t-38 69l224 224q11 11 11 28t-11 28q-11 11-28 11t-28-11L532-372q-30 24-69 38t-83 14Zm0-80q75 0 127.5-52.5T560-580q0-75-52.5-127.5T380-760q-75 0-127.5 52.5T200-580q0 75 52.5 127.5T380-400Z" />
                    </svg>
                </span>

                <input type="text" name="q" placeholder="Buscar productos, marcas o ingredientes"
                    value="{{ request('q') }}"
                    class="w-full pl-10 p-3 rounded-xl shadow-md bg-white border border-[#CCE2E5] text-[#306067] placeholder-[#306067]
                        focus:outline-none focus:ring-2 focus:ring-[#37A0AF] focus:border-[#37A0AF]">
            </form>
        </div>
    </section>

        <section>
        {{-- Resultados container --}}
        <div class="pb-6 pt-7 px-5 rounded-t-3xl bg-white">
            {{-- Cabecera resultados --}}
            <div class="w-full flex items-start justify-between gap-4">
                <div class="w-full flex justify-between">
                    @php
                        // Soporta tanto Paginator como Collection
                        $total = method_exists($products, 'total') ? $products->total() : (is_countable($products) ? count($products) : ($products->count() ?? 0));
                    @endphp
                    <h2 class="text-lg font-semibold text-[#306067] mb-1">
                        {{ $total }}
                        resultado{{ $total > 1 ? 's' : '' }} para <span class="font-medium">"{{ $query ?? request('q') ?? '' }}"</span>
                    </h2>
                    {{-- boton filtros --}}
                    <a href="">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#306067"><path d="M713.83-139.48q-64.68 0-109.49-44.81-44.82-44.82-44.82-109.49 0-64.68 44.82-109.49 44.81-44.82 109.49-44.82 64.67 0 109.49 44.82 44.81 44.81 44.81 109.49 0 64.67-44.81 109.49-44.82 44.81-109.49 44.81Zm0-88.61q27.21 0 46.45-19.24 19.24-19.24 19.24-46.45 0-27.22-19.24-46.46-19.24-19.24-46.45-19.24-27.22 0-46.46 19.24-19.24 19.24-19.24 46.46 0 27.21 19.24 46.45 19.24 19.24 46.46 19.24Zm-279.81-20.19H187.8q-19.15 0-32.32-13.18-13.18-13.17-13.18-32.32t13.18-32.33q13.17-13.17 32.32-13.17h246.22q19.15 0 32.33 13.17 13.17 13.18 13.17 32.33t-13.17 32.32q-13.18 13.18-32.33 13.18ZM246.17-511.91q-64.67 0-109.49-44.82-44.81-44.81-44.81-109.49 0-64.67 44.81-109.49 44.82-44.81 109.49-44.81 64.68 0 109.49 44.81 44.82 44.82 44.82 109.49 0 64.68-44.82 109.49-44.81 44.82-109.49 44.82Zm0-88.61q27.22 0 46.46-19.24 19.24-19.24 19.24-46.46 0-27.21-19.24-46.45-19.24-19.24-46.46-19.24-27.21 0-46.45 19.24-19.24 19.24-19.24 46.45 0 27.22 19.24 46.46 19.24 19.24 46.45 19.24Zm526.03-20.2H525.98q-19.15 0-32.33-13.17-13.17-13.18-13.17-32.33t13.17-32.32q13.18-13.18 32.33-13.18H772.2q19.15 0 32.32 13.18 13.18 13.17 13.18 32.32t-13.18 32.33q-13.17 13.17-32.32 13.17Zm-58.37 326.94ZM246.17-666.22Z"/></svg>
                    </a>
            </div>


            </div>

            <div class="mt-5">
                {{-- Empty state --}}
                @if($products->isEmpty())
                    <div class="text-center py-14">
                        <p class="text-sm text-[var(--kalm-text)] mb-4">No se encontraron productos que coincidan con tu
                            búsqueda.</p>
                        <a href="{{ route('products.index') }}"
                            class="inline-block bg-[var(--kalm-dark)] text-white px-4 py-2 rounded-lg">Ver todos los
                            productos</a>
                    </div>
                @else
                    {{-- Lista de productos: cada fila es un enlace entero --}}
                    <div class="space-y-4">
                        @foreach($products as $product)
                            <a href="{{ route('products.show', $product) }}" class="group block">
                                <div
                                    class="flex items-center gap-4 border-b border-gray-200 py-2 transition-shadow bg-white">
                                    {{-- Imagen redonda --}}
                                    <div class="flex-shrink-0 w-20 h-20 overflow-hidden bg-[var(--kalm-light)]">
                                        @php
                                            $img = $product->image ?? null;

                                            if ($img && Str::startsWith($img, ['http://', 'https://'])) {
                                                $imgUrl = $img; // URL absoluta
                                            } elseif ($img) {
                                                $imgUrl = asset($img);
                                            } else {
                                                $imgUrl = asset('images/default.jpg'); // fallback
                                            }
                                        @endphp

                                        <img src="{{ $imgUrl }}" alt="{{ $product->name }}" class="w-full h-full object-cover"
                                            loading="lazy">
                                    </div>

                                    {{-- Info --}}
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between gap-3">
                                            <h2 class="text-sm font-semibold text-[#2A4043] truncate">{{ $product->name }}</h2>

                                            @if(isset($product->price))
                                                <div class="text-sm font-semibold text-[var(--kalm-dark)] whitespace-nowrap">
                                                    ${{ number_format($product->price, 2, ',', '.') }}
                                                </div>
                                            @endif
                                        </div>

                                        <div class="text-xs text-[var(--kalm-text)] gap-2">
                                            <h3 class="text-[13px] text-[#37A0AF] truncate">
                                                {{ $product->brand->name ?? '-' }}
                                            </h3>
                                            <div class="flex flex-wrap gap-2 my-3">
                                                <button class="text-[10px] inline-block text-white truncate bg-[#37A0AF] px-2 py-1 rounded-xl">
                                                    ✨{{ $product->type->name ?? '-' }}
                                                </button>
                                                <button class="text-[10px] inline-block text-white truncate bg-[#37A0AF] px-2 py-1 rounded-xl">
                                                    {{ $product->category->name ?? '-' }}
                                                </button>
                                            </div>
                                        </div>

                                        @if(!empty($product->resolved_tag_text))
                                            <div class="mt-2">
                                                <span
                                                    class="inline-block px-2 py-0.5 text-xs font-semibold rounded {{ $product->tag_class ?? 'bg-teal-100 text-teal-800' }}">
                                                    {{ $product->resolved_tag_text }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>


                    {{-- Paginación removida para mostrar todos los resultados en la misma vista --}}
                @endif
            </div>
        </div>
    </section>
</x-layout>
