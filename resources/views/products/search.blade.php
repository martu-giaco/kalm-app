{{-- filepath: resources/views/products/search.blade.php --}}

<x-layout title="Kälm | Resultados de Búsqueda">

    <section class="px-5">
        {{-- Barra de búsqueda --}}
        <div class="mb-[-3vw] relative">
            <form id="search-form" action="{{ route('products.search') }}" method="GET" class="relative">
                <span class="absolute -translate-y-1/2 left-3 top-1/2">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                        class="fill-[#306067] dark:fill-[#CCE2E5]">
                        <path
                            d="M378.09-314.5q-111.16 0-188.33-77.17-77.17-77.18-77.17-188.33t77.17-188.33q77.17-77.17 188.33-77.17 111.15 0 188.32 77.17 77.18 77.18 77.18 188.33 0 44.48-13.52 83.12-13.53 38.64-36.57 68.16l222.09 222.33q12.67 12.91 12.67 31.94 0 19.04-12.91 31.71-12.68 12.67-31.83 12.67t-31.82-12.67L529.85-364.59q-29.76 23.05-68.64 36.57-38.88 13.52-83.12 13.52Zm0-91q72.84 0 123.67-50.83 50.83-50.82 50.83-123.67t-50.83-123.67q-50.83-50.83-123.67-50.83-72.85 0-123.68 50.83-50.82 50.82-50.82 123.67t50.82 123.67q50.83 50.83 123.68 50.83Z" />
                    </svg>
                </span>

                <input id="search-input" type="text" name="q"
                    placeholder="Buscar productos, marcas o categorías" value="{{ request('q') }}"
                    class="w-full pl-10 p-3 rounded-xl shadow-md bg-white border border-[#CCE2E5] text-[#306067] placeholder-[#CCE2E5]
                        focus:outline-none focus:ring-0 focus:ring-[#37A0AF] focus:border-[#37A0AF] dark:bg-[#306067] dark:border-[#CCE2E5] dark:text-[#E9E5E3] dark:placeholder:text-[#CCE2E5]">

                <!-- Botón limpiar: visible solo si hay texto -->
                <button id="search-clear" type="button" aria-label="Limpiar búsqueda"
                    class="absolute -translate-y-1/2 right-3 top-1/2 p-2 text-[#306067] {{ request('q') ? '' : 'hidden' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                        class="fill-[#306067] dark:fill-[#CCE2E5]">
                        <path
                            d="M480-416.11 374.52-310.87q-12.67 12.67-31.7 12.79-19.04.12-31.95-12.79-12.67-12.67-12.67-31.83 0-19.15 12.67-31.82L416.11-480 310.87-584.48q-12.67-12.67-12.79-31.7-.12-19.04 12.79-31.95 12.67-12.67 31.83-12.67 19.15 0 31.82 12.67L480-542.89l104.48-105.24q12.67-12.67 31.82-12.67 19.16 0 31.83 12.67 13.44 13.43 13.44 32.21 0 18.77-13.44 31.44L542.89-480l105.24 105.48q12.67 12.67 12.67 31.82 0 19.16-12.67 31.83-13.43 13.44-32.21 13.44-18.77 0-31.44-13.44L480-416.11Z" />
                    </svg>
                </button>
            </form>
        </div>
    </section>



    <section>
        {{-- Resultados container --}}
        <div class="min-h-full pb-20 bg-white pt-7 rounded-t-3xl dark:bg-[#2A4043]">
            {{-- Cabecera resultados --}}
            <div class="flex items-start justify-between w-full gap-4 px-5">
                <div class="flex justify-between w-full">
                    @php
                        $total = method_exists($products, 'total')
                            ? $products->total()
                            : (is_countable($products)
                                ? count($products)
                                : $products->count() ?? 0);
                    @endphp
                    @php
                        $searchTerm = $query ?? request('q');
                    @endphp
                    @if (!empty($searchTerm))
                        <p class="text-md font-bold text-[#306067] dark:text-[#CCE2E5] mb-1">
                            {{ $total }}
                            resultado{{ $total > 1 ? 's' : '' }}
                            para <span class="font-medium">"{{ $searchTerm }}"</span>
                        </p>
                    @else
                        <p class="text-md font-bold text-[#306067] dark:text-[#CCE2E5] mb-1">
                            Explorá todos nuestros productos
                        </p>
                    @endif
                    {{-- boton filtros --}}
                    <button onclick="filters_modal.showModal()" type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                            class="fill-[#306067] dark:fill-[#CCE2E5]">
                            <path
                                d="M713.83-139.48q-64.68 0-109.49-44.81-44.82-44.82-44.82-109.49 0-64.68 44.82-109.49 44.81-44.82 109.49-44.82 64.67 0 109.49 44.82 44.81 44.81 44.81 109.49 0 64.67-44.81 109.49-44.82 44.81-109.49 44.81Zm0-88.61q27.21 0 46.45-19.24 19.24-19.24 19.24-46.45 0-27.22-19.24-46.46-19.24-19.24-46.45-19.24-27.22 0-46.46 19.24-19.24 19.24-19.24 46.46 0 27.21 19.24 46.45 19.24 19.24 46.46 19.24Zm-279.81-20.19H187.8q-19.15 0-32.32-13.18-13.18-13.17-13.18-32.32t13.18-32.33q13.17-13.17 32.32-13.17h246.22q19.15 0 32.33 13.17 13.17 13.18 13.17 32.33t-13.17 32.32q-13.18 13.18-32.33 13.18ZM246.17-511.91q-64.67 0-109.49-44.82-44.81-44.81-44.81-109.49 0-64.67 44.81-109.49 44.82-44.81 109.49-44.81 64.68 0 109.49 44.81 44.82 44.82 44.82 109.49 0 64.68-44.82 109.49-44.81 44.82-109.49 44.82Zm0-88.61q27.22 0 46.46-19.24 19.24-19.24 19.24-46.46 0-27.21-19.24-46.45-19.24-19.24-46.46-19.24-27.21 0-46.45 19.24-19.24 19.24-19.24 46.45 0 27.22 19.24 46.46 19.24 19.24 46.45 19.24Zm526.03-20.2H525.98q-19.15 0-32.33-13.17-13.17-13.18-13.17-32.33t13.17-32.32q13.18-13.18 32.33-13.18H772.2q19.15 0 32.32 13.18 13.18 13.17 13.18 32.32t-13.18 32.33q-13.17 13.17-32.32 13.17Zm-58.37 326.94ZM246.17-666.22Z" />
                        </svg>
                    </button>
                </div>


                <!-- Modal de filtros -->
                <dialog id="filters_modal" class="modal modal-bottom">
                    <div class="p-0 modal-box bg-white dark:bg-[#2A4043]">
                        <div class="p-4 border-b-[1px] border-b-[#CCE2E5]">
                            <form method="dialog">
                                <button
                                    class="absolute btn btn-sm btn-circle btn-ghost focus-visible:outline-0 right-4 top-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 -960 960 960"
                                        class="fill-[#306067] dark:fill-[#CCE2E5]" aria-hidden="true">
                                        <path
                                            d="M480-424 284-228q-11 11-28 11t-28-11q-11-11-11-28t11-28l196-196-196-196q-11-11-11-28t11-28q11-11 28-11t28 11l196 196 196-196q11-11 28-11t28 11q11 11 11 28t-11 28L536-480l196 196q11 11 11 28t-11 28q-11 11-28 11t-28-11L480-424Z" />
                                    </svg>
                                </button>
                            </form>
                            <h3 class="text-xl font-semibold text-center text-[#306067] dark:text-[#CCE2E5]">Filtros</h3>
                        </div>


                        <form action="{{ route('products.search') }}" method="GET">
                            <input type="hidden" name="q" value="{{ request('q') }}">

                            <section class="max-h-[60vh] overflow-y-auto">
                                <div class="mb-6">
                                    <h3
                                        class="text-lg mb-5 w-full p-4 border-b-[1px] border-y-[#CCE2E5] text-[#2A4043] dark:text-[#CCE2E5] font-semibold">
                                        Tipo de piel</h3>
                                    <div class="grid grid-cols-2 gap-3 mx-4">
                                        @foreach ($skinTypes as $s)
                                            <label class="cursor-pointer">
                                                <input type="radio" name="skin_type_id" value="{{ $s->id }}"
                                                    class="hidden peer"
                                                    {{ request('skin_type_id') == $s->id ? 'checked' : '' }}>
                                                <div
                                                    class="py-2 text-center rounded-xl border border-[#CCE2E5]
                                                text-[#2A4043] dark:text-[#CCE2E5] transition
                                                peer-checked:bg-[#37A0AF] dark:peer-checked:bg-[#CCE2E5]
                                                peer-checked:text-white dark:peer-checked:text-[#306067]
                                                peer-checked:border-[#37A0AF] dark:peer-checked:border-[#CCE2E5]">
                                                    {{ $s->name }}
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="mb-6">
                                    <h3
                                        class="text-lg mb-5 w-full mt-6 p-4 border-y-[1px] border-b-[#CCE2E5] text-[#2A4043] dark:text-[#CCE2E5] font-semibold">
                                        Tipo</h3>
                                    <div class="grid grid-cols-2 gap-3 mx-4">
                                        @foreach ($types as $t)
                                            <label class="cursor-pointer">
                                                <input type="radio" name="type_id" value="{{ $t->id }}"
                                                    class="hidden peer"
                                                    {{ request('type_id') == $t->id ? 'checked' : '' }}>

                                                <div
                                                    class="py-2 text-center rounded-xl border border-[#CCE2E5]
                                                text-[#2A4043] dark:text-[#CCE2E5] transition
                                                peer-checked:bg-[#37A0AF] dark:peer-checked:bg-[#CCE2E5]
                                                peer-checked:text-white dark:peer-checked:text-[#306067]
                                                peer-checked:border-[#37A0AF] dark:peer-checked:border-[#CCE2E5]">
                                                    {{ $t->name }}
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="mb-6">
                                    <h3
                                        class="text-lg mb-5 w-full mt-6 p-4 border-y-[1px] border-y-[#CCE2E5] text-[#2A4043] dark:text-[#CCE2E5] font-semibold">
                                        Preocupaciones</h3>
                                    <div class="grid grid-cols-2 gap-3 mx-4">
                                        @foreach ($concerns as $concern)
                                            <label class="cursor-pointer">
                                                <input type="radio" name="concern_id" value="{{ $concern->id }}"
                                                    class="hidden peer"
                                                    {{ request('concern_id') == $concern->id ? 'checked' : '' }}>
                                                <div
                                                    class="py-2 text-center rounded-xl border border-[#CCE2E5]
                                                text-[#2A4043] dark:text-[#CCE2E5] transition
                                                peer-checked:bg-[#37A0AF] dark:peer-checked:bg-[#CCE2E5]
                                                peer-checked:text-white dark:peer-checked:text-[#306067]
                                                peer-checked:border-[#37A0AF] dark:peer-checked:border-[#CCE2E5]">
                                                    {{ $concern->name }}
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="mb-6">
                                    <h3
                                        class="text-lg mb-5 w-full mt-6 p-4 border-y-[1px] border-y-[#CCE2E5] text-[#2A4043] dark:text-[#CCE2E5] font-semibold">
                                        Categoría</h3>
                                    <div class="grid grid-cols-2 gap-3 mx-4">
                                        @foreach ($categories as $c)
                                            <label class="cursor-pointer">
                                                <input type="radio" name="category_id" value="{{ $c->id }}"
                                                    class="hidden peer"
                                                    {{ request('category_id') == $c->id ? 'checked' : '' }}>
                                                <div
                                                    class="py-2 text-center rounded-xl border border-[#CCE2E5]
                                                text-[#2A4043] dark:text-[#CCE2E5] transition
                                                peer-checked:bg-[#37A0AF] dark:peer-checked:bg-[#CCE2E5]
                                                peer-checked:text-white dark:peer-checked:text-[#306067]
                                                peer-checked:border-[#37A0AF] dark:peer-checked:border-[#CCE2E5]">
                                                    {{ $c->name }}
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </section>

                            <div class="mt-6 p-4 border-t-[1px] border-t-[#CCE2E5]">
                                <button type="submit"
                                    class="btn text-md w-full px-5 mb-2 py-3 border-0 rounded-xl text-[#fff] font-semibold transition cursor-pointer hover:bg-[#306067] disabled:opacity-80 disabled:cursor-not-allowed bg-[#306067] dark:bg-[#CCE2E5] dark:text-[#2A4043]">
                                    Filtrar
                                </button>
                            </div>
                        </form>
                    </div>
                </dialog>
            </div>

            @if(request()->hasAny(['q','type_id','category_id','skin_type_id','concern_id']))
            <div class="flex flex-wrap gap-2 px-5 mt-3">
                {{-- Tipo --}}
                @if(request('type_id'))
                    @php $type = $types->firstWhere('id', request('type_id')); @endphp
                    @if($type)
                        <a href="{{ route('products.search', request()->except('type_id')) }}"
                        class="px-3 py-1 text-sm text-center bg-[#CCE2E5] text-[#2A4043] rounded-full flex items-center">
                            {{ $type->name }}
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#2A4043"><path d="M480-424 364-308q-11 11-28 11t-28-11q-11-11-11-28t11-28l116-116-116-115q-11-11-11-28t11-28q11-11 28-11t28 11l116 116 115-116q11-11 28-11t28 11q12 12 12 28.5T651-595L535-480l116 116q11 11 11 28t-11 28q-12 12-28.5 12T595-308L480-424Z"/></svg>
                        </a>
                    @endif
                @endif

                {{-- Categoría --}}
                @if(request('category_id'))
                    @php $cat = $categories->firstWhere('id', request('category_id')); @endphp
                    @if($cat)
                        <a href="{{ route('products.search', request()->except('category_id')) }}"
                        class="px-3 py-1 text-sm bg-[#CCE2E5] text-[#2A4043] rounded-full flex items-center">
                            {{ $cat->name }}
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#2A4043"><path d="M480-424 364-308q-11 11-28 11t-28-11q-11-11-11-28t11-28l116-116-116-115q-11-11-11-28t11-28q11-11 28-11t28 11l116 116 115-116q11-11 28-11t28 11q12 12 12 28.5T651-595L535-480l116 116q11 11 11 28t-11 28q-12 12-28.5 12T595-308L480-424Z"/></svg>
                        </a>
                    @endif
                @endif

                {{-- Tipo de piel --}}
                @if(request('skin_type_id'))
                    @php $skin = $skinTypes->firstWhere('id', request('skin_type_id')); @endphp
                    @if($skin)
                        <a href="{{ route('products.search', request()->except('skin_type_id')) }}"
                        class="px-3 py-1 text-sm bg-[#CCE2E5] text-[#2A4043] rounded-full flex items-center">
                            {{ $skin->name }}
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#2A4043"><path d="M480-424 364-308q-11 11-28 11t-28-11q-11-11-11-28t11-28l116-116-116-115q-11-11-11-28t11-28q11-11 28-11t28 11l116 116 115-116q11-11 28-11t28 11q12 12 12 28.5T651-595L535-480l116 116q11 11 11 28t-11 28q-12 12-28.5 12T595-308L480-424Z"/></svg>
                        </a>
                    @endif
                @endif

                {{-- Concern --}}
                @if(request('concern_id'))
                    @php $concern = $concerns->firstWhere('id', request('concern_id')); @endphp
                    @if($concern)
                        <a href="{{ route('products.search', request()->except('concern_id')) }}"
                        class="px-3 py-1 text-sm bg-[#CCE2E5] text-[#2A4043] rounded-full flex items-center">
                            {{ $concern->name }}
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#2A4043"><path d="M480-424 364-308q-11 11-28 11t-28-11q-11-11-11-28t11-28l116-116-116-115q-11-11-11-28t11-28q11-11 28-11t28 11l116 116 115-116q11-11 28-11t28 11q12 12 12 28.5T651-595L535-480l116 116q11 11 11 28t-11 28q-12 12-28.5 12T595-308L480-424Z"/></svg>
                        </a>
                    @endif
                @endif

            </div>
        @endif

            <div class="mt-5">
                {{-- Empty state o lista de productos --}}
                @if ($products->isEmpty())
                    <div class="text-center py-14 min-h-[50vh] flex flex-col items-center justify-center">
                        <p class="text-sm text-[#2A4043] dark:text-[#CCE2E5] mb-4 mx-4">
                            No se encontraron productos que coincidan con su búsqueda.
                        </p>
                        <a href="{{ route('products.search') }}" class="inline-block text-[#37A0AF]">
                            Ver todos los productos
                        </a>
                    </div>
                @else
                    {{-- Lista de productos: sin height fija, scroll natural del body --}}
                    <div class="pb-8 space-y-4">
                        @if(!empty($query) && $brands->isNotEmpty())
                                    @foreach ($brands as $brand)
                                        <x-brand-card :brand="$brand"/>
                                    @endforeach
                        @endif
                        @foreach ($products as $product)
                            <x-product-card-hor :product="$product" />
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </section>

    {{-- Script para mostrar/ocultar y limpiar --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const input = document.getElementById('search-input');
            const clear = document.getElementById('search-clear');

            if (!input || !clear) return;

            function toggle() {
                if (input.value.trim() !== '') {
                    clear.classList.remove('hidden');
                } else {
                    clear.classList.add('hidden');
                }
            }

            input.addEventListener('input', toggle);

            clear.addEventListener('click', function(e) {
                e.preventDefault();

                const url = new URL(window.location.href);
                url.searchParams.delete('q');

                window.location.href = "{{ route('products.search') }}";
            });

            toggle();
        });
    </script>


</x-layout>
