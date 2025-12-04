{{-- filepath: resources/views/products/search.blade.php --}}

<x-layout title="Kälm | Resultados de Búsqueda">
    <section class="min-h-screen bg-[var(--kalm-bg)]">
        {{-- Barra de búsqueda: container relativo para icono --}}
        <div class="px-5 pt-6">
            <form action="{{ route('products.search') }}" method="GET" class="relative max-w-3xl mx-auto">
                <label for="q" class="sr-only">Buscar productos, marcas o ingredientes</label>

                {{-- Lupa dentro del input --}}
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-[#2A4043] pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" height="22" viewBox="0 -960 960 960" width="22" fill="#2A4043">
                        <path d="M380-320q-109 0-184.5-75.5T120-580q0-109 75.5-184.5T380-840q109 0 184.5 75.5T640-580q0 44-14 83t-38 69l224 224q11 11 11 28t-11 28q-11 11-28 11t-28-11L532-372q-30 24-69 38t-83 14Zm0-80q75 0 127.5-52.5T560-580q0-75-52.5-127.5T380-760q-75 0-127.5 52.5T200-580q0 75 52.5 127.5T380-400Z"/>
                    </svg>
                </span>

                <input
                    id="q"
                    type="text"
                    name="q"
                    value="{{ request('q', $query ?? '') }}"
                    placeholder="Buscar productos, marcas o ingredientes"
                    class="w-full pl-11 pr-4 py-3 rounded-xl shadow-xl bg-white border border-[#CCE2E5] text-[#306067] placeholder-[#CCE2E5]
                           focus:outline-none focus:ring-2 focus:ring-[#37A0AF] focus:border-[#37A0AF]"
                    autocomplete="off"
                >
            </form>
        </div>

        {{-- Resultados container --}}
        <div class="pb-6 pt-7 px-5 rounded-t-3xl bg-white mt-6">
            {{-- Cabecera resultados --}}
            <div class="flex items-start justify-between gap-4">
                <div class="flex-1">
                    <h2 class="text-lg font-semibold text-[#306067] mb-1">
                        Resultados para: <span class="font-medium">"{{ $query ?? request('q') ?? '' }}"</span>
                    </h2>
                    <p class="text-sm text-[var(--kalm-text)]">
                        {{ $products->total() ?? $products->count() }} resultado{{ ($products->total() ?? $products->count()) > 1 ? 's' : '' }}
                    </p>
                </div>

                {{-- Botón/ícono de filtros (si los tenés) --}}
                <div>
                    <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 text-sm text-[#306067] hover:underline">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 -960 960 960" fill="#306067"><path d="M710-150q-63 0-106.5-43.5T560-300q0-63 43.5-106.5T710-450q63 0 106.5 43.5T860-300q0 63-43.5 106.5T710-150Zm0-80q29 0 49.5-20.5T780-300q0-29-20.5-49.5T710-370q-29 0-49.5 20.5T640-300q0 29 20.5 49.5T710-230ZM250-510q-63 0-106.5-43.5T100-660q0-63 43.5-106.5T250-810q63 0 106.5 43.5T400-660q0 63-43.5 106.5T250-510Z"/></svg>
                        Volver a productos
                    </a>
                </div>
            </div>

            <div class="mt-5">
                {{-- Empty state --}}
                @if($products->isEmpty())
                    <div class="text-center py-14">
                        <p class="text-sm text-[var(--kalm-text)] mb-4">No se encontraron productos que coincidan con tu búsqueda.</p>
                        <a href="{{ route('products.index') }}" class="inline-block bg-[var(--kalm-dark)] text-white px-4 py-2 rounded-lg">Ver todos los productos</a>
                    </div>
                @else
                    {{-- Lista de productos: cada fila es un enlace entero --}}
                    <div class="space-y-4">
                        @foreach($products as $product)
                            <a href="{{ route('products.show', $product) }}" class="group block">
                                <div class="flex items-center gap-4 p-3 rounded-lg border border-gray-100 hover:shadow-md transition-shadow bg-white">
                                    {{-- Imagen redonda --}}
                                    <div class="flex-shrink-0 w-20 h-20 rounded-full overflow-hidden bg-[var(--kalm-light)]">
                                        @php
                                            // Determinar URL de imagen: si es absolute URL la usamos tal cual, si no usamos Storage::url
                                            $img = $product->image ?? null;
                                            if($img && (Str::startsWith($img, ['http://','https://']) )) {
                                                $imgUrl = $img;
                                            } elseif($img) {
                                                $imgUrl = Storage::url($img);
                                            } else {
                                                $imgUrl = asset('images/default.jpg');
                                            }
                                        @endphp
                                        <img src="{{ $imgUrl }}" alt="{{ $product->name }}" class="w-full h-full object-cover" loading="lazy">
                                    </div>

                                    {{-- Info --}}
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between gap-3">
                                            <h3 class="text-sm font-medium text-[#306067] truncate">{{ $product->name }}</h3>

                                            {{-- Si tenés precio --}}
                                            @if(isset($product->price))
                                                <div class="text-sm font-semibold text-[var(--kalm-dark)] whitespace-nowrap">
                                                    ${{ number_format($product->price, 2, ',', '.') }}
                                                </div>
                                            @endif
                                        </div>

                                        <div class="mt-1 text-xs text-[var(--kalm-text)] flex flex-wrap gap-2">
                                            <span class="truncate"><strong>Marca:</strong> {{ $product->brand->name ?? '-' }}</span>
                                            <span class="truncate"><strong>Tipo:</strong> {{ $product->type->name ?? '-' }}</span>
                                            <span class="truncate"><strong>Categoría:</strong> {{ $product->category->name ?? '-' }}</span>
                                        </div>

                                        {{-- Tag si existe --}}
                                        @if(!empty($product->resolved_tag_text))
                                            <div class="mt-2">
                                                <span class="inline-block px-2 py-0.5 text-xs font-semibold rounded {{ $product->tag_class ?? 'bg-teal-100 text-teal-800' }}">
                                                    {{ $product->resolved_tag_text }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    {{-- Paginación centrada --}}
                    <div class="mt-6 flex justify-center">
                        {{ $products->appends(request()->except('page'))->links() }}
                    </div>
                @endif
            </div>
        </div>
    </section>
</x-layout>
