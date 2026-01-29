{{-- filepath: resources/views/products/search.blade.php --}}

<x-layout title="Kälm | Resultados de Búsqueda">

    <section class="px-5">
        {{-- Barra de búsqueda --}}
        <div class="mb-[-3vw] relative">
            <form id="search-form" action="{{ route('products.search') }}" method="GET" class="relative">
                <span class="absolute -translate-y-1/2 left-3 top-1/2">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#306067"><path d="M378.09-314.5q-111.16 0-188.33-77.17-77.17-77.18-77.17-188.33t77.17-188.33q77.17-77.17 188.33-77.17 111.15 0 188.32 77.17 77.18 77.18 77.18 188.33 0 44.48-13.52 83.12-13.53 38.64-36.57 68.16l222.09 222.33q12.67 12.91 12.67 31.94 0 19.04-12.91 31.71-12.68 12.67-31.83 12.67t-31.82-12.67L529.85-364.59q-29.76 23.05-68.64 36.57-38.88 13.52-83.12 13.52Zm0-91q72.84 0 123.67-50.83 50.83-50.82 50.83-123.67t-50.83-123.67q-50.83-50.83-123.67-50.83-72.85 0-123.68 50.83-50.82 50.82-50.82 123.67t50.82 123.67q50.83 50.83 123.68 50.83Z"/></svg>
                </span>

                <input id="search-input" type="text" name="q" placeholder="Buscar productos, marcas o categorías"
                    value="{{ request('q') }}"
                    class="w-full pl-10 p-3 rounded-xl shadow-md bg-white border border-[#CCE2E5] text-[#306067] placeholder-[#CCE2E5]
                        focus:outline-none focus:ring-0 focus:ring-[#37A0AF] focus:border-[#37A0AF]">

                <!-- Botón limpiar: visible solo si hay texto -->
                <button
                    id="search-clear"
                    type="button"
                    aria-label="Limpiar búsqueda"
                    class="absolute -translate-y-1/2 right-3 top-1/2 p-2 text-[#306067] {{ request('q') ? '' : 'hidden' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#2A4043"><path d="M480-416.11 374.52-310.87q-12.67 12.67-31.7 12.79-19.04.12-31.95-12.79-12.67-12.67-12.67-31.83 0-19.15 12.67-31.82L416.11-480 310.87-584.48q-12.67-12.67-12.79-31.7-.12-19.04 12.79-31.95 12.67-12.67 31.83-12.67 19.15 0 31.82 12.67L480-542.89l104.48-105.24q12.67-12.67 31.82-12.67 19.16 0 31.83 12.67 13.44 13.43 13.44 32.21 0 18.77-13.44 31.44L542.89-480l105.24 105.48q12.67 12.67 12.67 31.82 0 19.16-12.67 31.83-13.43 13.44-32.21 13.44-18.77 0-31.44-13.44L480-416.11Z"/></svg>
                </button>
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
                        $total = method_exists($products, 'total') ? $products->total() : (is_countable($products) ? count($products) : ($products->count() ?? 0));
                    @endphp
                    <p class="text-md font-bold text-[#306067] mb-1">
                        {{ $total }}
                        resultado{{ $total > 1 ? 's' : '' }} para <span class="font-medium">"{{ $query ?? request('q') ?? '' }}"</span>
                    </p>
                    {{-- boton filtros --}}
                    <button onclick="filters_modal.showModal()" type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#306067"><path d="M713.83-139.48q-64.68 0-109.49-44.81-44.82-44.82-44.82-109.49 0-64.68 44.82-109.49 44.81-44.82 109.49-44.82 64.67 0 109.49 44.82 44.81 44.81 44.81 109.49 0 64.67-44.81 109.49-44.82 44.81-109.49 44.81Zm0-88.61q27.21 0 46.45-19.24 19.24-19.24 19.24-46.45 0-27.22-19.24-46.46-19.24-19.24-46.45-19.24-27.22 0-46.46 19.24-19.24 19.24-19.24 46.46 0 27.21 19.24 46.45 19.24 19.24 46.46 19.24Zm-279.81-20.19H187.8q-19.15 0-32.32-13.18-13.18-13.17-13.18-32.32t13.18-32.33q13.17-13.17 32.32-13.17h246.22q19.15 0 32.33 13.17 13.17 13.18 13.17 32.33t-13.17 32.32q-13.18 13.18-32.33 13.18ZM246.17-511.91q-64.67 0-109.49-44.82-44.81-44.81-44.81-109.49 0-64.67 44.81-109.49 44.82-44.81 109.49-44.81 64.68 0 109.49 44.81 44.82 44.82 44.82 109.49 0 64.68-44.82 109.49-44.81 44.82-109.49 44.82Zm0-88.61q27.22 0 46.46-19.24 19.24-19.24 19.24-46.46 0-27.21-19.24-46.45-19.24-19.24-46.46-19.24-27.21 0-46.45 19.24-19.24 19.24-19.24 46.45 0 27.22 19.24 46.46 19.24 19.24 46.45 19.24Zm526.03-20.2H525.98q-19.15 0-32.33-13.17-13.17-13.18-13.17-32.33t13.17-32.32q13.18-13.18 32.33-13.18H772.2q19.15 0 32.32 13.18 13.18 13.17 13.18 32.32t-13.18 32.33q-13.17 13.17-32.32 13.17Zm-58.37 326.94ZM246.17-666.22Z"/></svg>
                    </button>
            </div>

                <!-- Modal de filtros -->
    <dialog id="filters_modal" class="modal modal-bottom">
        <div class="modal-box p-0">
            <div class="p-4 border-b-[1px] border-b-[#CCE2E5]">
                <form method="dialog">
                        <button class="btn btn-sm btn-circle btn-ghost absolute focus-visible:outline-0 right-4 top-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 -960 960 960" fill="#306067" aria-hidden="true">
                            <path d="M480-424 284-228q-11 11-28 11t-28-11q-11-11-11-28t11-28l196-196-196-196q-11-11-11-28t11-28q11-11 28-11t28 11l196 196 196-196q11-11 28-11t28 11q11 11 11 28t-11 28L536-480l196 196q11 11 11 28t-11 28q-11 11-28 11t-28-11L480-424Z" />
                        </svg>
                    </button>
                </form>
                <h3 class="text-xl font-semibold text-center text-[#306067]">Filtros</h3>
            </div>


            <form action="{{ route('products.search') }}" method="GET">
                <input type="hidden" name="q" value="{{ request('q') }}">

                <div class="mb-6">
                    <h3 class="text-lg mb-5 w-full p-4 border-b-[1px] border-b-[#CCE2E5] text-[#2A4043] font-semibold">Tipo</h3>
                    <div class="grid grid-cols-2 gap-3 mx-4">
                        @foreach($types as $t)
                            <label class="cursor-pointer">
                                <input
                                    type="radio"
                                    name="type_id"
                                    value="{{ $t->id }}"
                                    class="peer hidden"
                                    {{ request('type_id') == $t->id ? 'checked' : '' }}
                                >

                                <div class="py-2 text-center rounded-xl border border-[#CCE2E5]
                                            text-[#2A4043] transition
                                            peer-checked:bg-[#37A0AF]
                                            peer-checked:text-white
                                            peer-checked:border-[#37A0AF]">
                                    {{ $t->name }}
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>


                <div class="mb-6">
                    <h3 class="text-lg mb-5 w-full mt-6 p-4 border-y-[1px] border-y-[#CCE2E5] text-[#2A4043] font-semibold">Categoría</h3>
                    <div class="grid grid-cols-2 gap-3 mx-4">
                        @foreach($categories as $c)
                            <label class="cursor-pointer">
                                <input
                                    type="radio"
                                    name="category_id"
                                    value="{{ $c->id }}"
                                    class="peer hidden"
                                    {{ request('category_id') == $c->id ? 'checked' : '' }}
                                >
                                <div class="py-2 text-center rounded-xl border border-[#CCE2E5]
                                            text-[#2A4043] transition
                                            peer-checked:bg-[#37A0AF]
                                            peer-checked:text-white
                                            peer-checked:border-[#37A0AF]">
                                    {{ $c->name }}
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="mt-6 p-4 border-t-[1px] border-t-[#CCE2E5]">
                    <button type="submit" class="btn text-md w-full px-5 mb-2 py-3 border-0 rounded-xl text-[#fff] font-semibold transition cursor-pointer hover:bg-[#306067] disabled:opacity-80 disabled:cursor-not-allowed bg-[#306067]">
                        Filtrar
                    </button>
                </div>
            </form>
        </div>
    </dialog>


            </div>

            <div class="mt-5">
                {{-- Empty state --}}
                @if($products->isEmpty())
                    <div class="text-center py-14">
                        <p class="text-sm text-[var(--kalm-text)] mb-4">No se encontraron productos que coincidan con tu
                            búsqueda.</p>
                        <a href="{{ route('products.index') }}"
                            class="inline-block bg-[#2A4043] text-[#306067] px-4 py-2 rounded-lg">Ver todos los
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

                                            <div class="flex w-full justify-between items-end">
                                                <h2 class="text-md font-semibold text-[#2A4043] truncate">{{ $product->name }}</h2>
                                                <button type="button"
                                                    class="p-2 transition bg-white rounded-full hover:scale-105"
                                                    title="Marcar favorito" onclick="toggleFavorito({{ $product->id }}, this)">
                                                    <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#430000"><path d="M479.76-139.83q-16.15 0-32.44-5.83-16.3-5.84-28.97-18.27l-69.48-63.48Q243.35-323.7 157.61-420.03 71.87-516.37 71.87-634q0-97.58 65.15-162.97 65.15-65.4 162.74-65.4 52.52 0 99.28 21.42 46.76 21.43 80.72 59.47 33.96-38.04 80.72-59.47 46.76-21.42 99.28-21.42 97.68 0 163.14 65.4 65.47 65.39 65.47 162.97 0 117.63-85.6 214.47-85.6 96.83-193.12 193.36l-68.24 62.47q-12.67 12.44-29.08 18.16-16.42 5.71-32.57 5.71ZM440.09-688.8q-27.57-39.57-60.93-61.07t-79.33-21.5q-58.7 0-97.83 39.16-39.13 39.17-39.13 98.21 0 51.54 36.64 109.52 36.64 57.99 87.64 112.5 51 54.52 104.97 102.09 53.97 47.58 87.64 78.3 33.76-31 87.83-78.55 54.07-47.56 105.16-102.04 51.1-54.49 87.86-112.28 36.76-57.78 36.76-109.54 0-59.04-39.28-98.21-39.29-39.16-98.21-39.16-46.16 0-79.4 21.5-33.24 21.5-60.81 61.07-7.31 10.71-17.75 16.07-10.44 5.36-22.16 5.36t-22.07-5.36q-10.36-5.36-17.6-16.07ZM480-501.48Z"/></svg>
                                                </button>
                                            </div>
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
                @endif
            </div>
        </div>
    </section>

    {{-- Script para mostrar/ocultar y limpiar --}}
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var input = document.getElementById('search-input');
        var clear = document.getElementById('search-clear');
        var form = document.getElementById('search-form');
        if (!input || !clear || !form) return;

        function toggle() {
            if (input.value && input.value.trim() !== '') clear.classList.remove('hidden');
            else clear.classList.add('hidden');
        }
        input.addEventListener('input', toggle);
        clear.addEventListener('click', function() {
            input.value = '';
            // limpiar también filtros ocultos
            document.getElementById('hidden-type').value = '';
            document.getElementById('hidden-category').value = '';
            document.getElementById('hidden-brand').value = '';
            // enviar formulario para actualizar resultados sin q
            form.submit();
        });
        toggle();
    });
    </script>
</x-layout>
