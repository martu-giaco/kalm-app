<x-layout :title="$brand->name">
    <section class="pt-10 bg-white vh rounded-t-3xl">
        <div class="px-5 flex items-center gap-2 mb-5">
            {{-- Imagen redonda --}}
            <div class="flex-shrink-0 rounded-full w-20 h-20 overflow-hidden bg-[var(--kalm-light)]">
                @php
                $img = $brand->logo ?? null;

                if ($img && (str_starts_with($img, 'http://') || str_starts_with($img, 'https://'))) {
                    $imgUrl = $img; // absolute URL
                } elseif ($img && str_starts_with($img, 'images/')) {
                    $imgUrl = asset($img); // seeded public images
                } elseif ($img) {
                    $imgUrl = asset('storage/' . $img); // uploaded to storage
                } else {
                    $imgUrl = asset('images/default.jpg'); // fallback
                }
                @endphp

                <img src="{{ $imgUrl }}" alt="{{ $brand->name }}" class="w-full h-full object-cover"loading="lazy">
            </div>

            {{-- Info --}}
            <div class="flex-1 min-w-0">
                <div class="flex items-center justify-between gap-3">
                    <div class="flex w-full justify-between items-end">
                        <h1 class="text-xl font-semibold text-[#2A4043] truncate">{{ $brand->name }}</h1>
                    </div>
                </div>

                <div class="text-xs text-[#2A4043] gap-2">
                    <p class="text-[13px] text-[#aad0d4] font-bold truncate">
                        {{ $brand->products_count }}
                        @if ($brand->products_count === 1)
                            producto
                        @else
                            productos
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <div>
            <div class="flex px-5 justify-between w-full">
                    @php
                        $total = method_exists($products, 'total')
                            ? $products->total()
                            : (is_countable($products)
                                ? count($products)
                                : $products->count() ?? 0);
                    @endphp
                        <h2 class="text-lg font-bold text-[#306067] mb-1">
                            Productos
                        </h2>
                    {{-- boton filtros --}}
                    <button onclick="filters_modal.showModal()" type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                            fill="#306067">
                            <path
                                d="M713.83-139.48q-64.68 0-109.49-44.81-44.82-44.82-44.82-109.49 0-64.68 44.82-109.49 44.81-44.82 109.49-44.82 64.67 0 109.49 44.82 44.81 44.81 44.81 109.49 0 64.67-44.81 109.49-44.82 44.81-109.49 44.81Zm0-88.61q27.21 0 46.45-19.24 19.24-19.24 19.24-46.45 0-27.22-19.24-46.46-19.24-19.24-46.45-19.24-27.22 0-46.46 19.24-19.24 19.24-19.24 46.46 0 27.21 19.24 46.45 19.24 19.24 46.46 19.24Zm-279.81-20.19H187.8q-19.15 0-32.32-13.18-13.18-13.17-13.18-32.32t13.18-32.33q13.17-13.17 32.32-13.17h246.22q19.15 0 32.33 13.17 13.17 13.18 13.17 32.33t-13.17 32.32q-13.18 13.18-32.33 13.18ZM246.17-511.91q-64.67 0-109.49-44.82-44.81-44.81-44.81-109.49 0-64.67 44.81-109.49 44.82-44.81 109.49-44.81 64.68 0 109.49 44.81 44.82 44.82 44.82 109.49 0 64.68-44.82 109.49-44.81 44.82-109.49 44.82Zm0-88.61q27.22 0 46.46-19.24 19.24-19.24 19.24-46.46 0-27.21-19.24-46.45-19.24-19.24-46.46-19.24-27.21 0-46.45 19.24-19.24 19.24-19.24 46.45 0 27.22 19.24 46.46 19.24 19.24 46.45 19.24Zm526.03-20.2H525.98q-19.15 0-32.33-13.17-13.17-13.18-13.17-32.33t13.17-32.32q13.18-13.18 32.33-13.18H772.2q19.15 0 32.32 13.18 13.18 13.17 13.18 32.32t-13.18 32.33q-13.17 13.17-32.32 13.17Zm-58.37 326.94ZM246.17-666.22Z" />
                        </svg>
                    </button>

                    <!-- Modal de filtros -->
                <dialog id="filters_modal" class="modal modal-bottom">
                    <div class="p-0 modal-box">
                        <div class="p-4 border-b-[1px] border-b-[#CCE2E5]">
                            <form method="dialog">
                                <button
                                    class="absolute btn btn-sm btn-circle btn-ghost focus-visible:outline-0 right-4 top-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 -960 960 960"
                                        fill="#306067" aria-hidden="true">
                                        <path
                                            d="M480-424 284-228q-11 11-28 11t-28-11q-11-11-11-28t11-28l196-196-196-196q-11-11-11-28t11-28q11-11 28-11t28 11l196 196 196-196q11-11 28-11t28 11q11 11 11 28t-11 28L536-480l196 196q11 11 11 28t-11 28q-11 11-28 11t-28-11L480-424Z" />
                                    </svg>
                                </button>
                            </form>
                            <h3 class="text-xl font-semibold text-center text-[#306067]">Filtros</h3>
                        </div>


                        <form action="{{ route('brands.show', $brand->id) }}" method="GET">
                            <input type="hidden" name="q" value="{{ request('q') }}">

                            <section class="max-h-[60vh] overflow-y-auto">
                                <div class="mb-6">
                                    <h3
                                        class="text-lg mb-5 w-full p-4 border-b-[1px] border-y-[#CCE2E5] text-[#2A4043] font-semibold">
                                        Tipo de piel</h3>
                                    <div class="grid grid-cols-2 gap-3 mx-4">
                                        @foreach ($skinTypes as $s)
                                            <label class="cursor-pointer">
                                                <input type="radio" name="skin_type_id" value="{{ $s->id }}"
                                                    class="hidden peer"
                                                    {{ request('skin_type_id') == $s->id ? 'checked' : '' }}>
                                                <div
                                                    class="py-2 text-center rounded-xl border border-[#CCE2E5]
                                                text-[#2A4043] transition
                                                peer-checked:bg-[#37A0AF]
                                                peer-checked:text-white
                                                peer-checked:border-[#37A0AF]">
                                                    {{ $s->name }}
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="mb-6">
                                    <h3
                                        class="text-lg mb-5 w-full mt-6 p-4 border-y-[1px] border-b-[#CCE2E5] text-[#2A4043] font-semibold">
                                        Tipo</h3>
                                    <div class="grid grid-cols-2 gap-3 mx-4">
                                        @foreach ($types as $t)
                                            <label class="cursor-pointer">
                                                <input type="radio" name="type_id" value="{{ $t->id }}"
                                                    class="hidden peer"
                                                    {{ request('type_id') == $t->id ? 'checked' : '' }}>

                                                <div
                                                    class="py-2 text-center rounded-xl border border-[#CCE2E5]
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
                                    <h3
                                        class="text-lg mb-5 w-full mt-6 p-4 border-y-[1px] border-y-[#CCE2E5] text-[#2A4043] font-semibold">
                                        Preocupaciones</h3>
                                    <div class="grid grid-cols-2 gap-3 mx-4">
                                        @foreach ($concerns as $concern)
                                            <label class="cursor-pointer">
                                                <input type="radio" name="concern_id" value="{{ $concern->id }}"
                                                    class="hidden peer"
                                                    {{ request('concern_id') == $concern->id ? 'checked' : '' }}>
                                                <div
                                                    class="py-2 text-center rounded-xl border border-[#CCE2E5]
                                                text-[#2A4043] transition
                                                peer-checked:bg-[#37A0AF]
                                                peer-checked:text-white
                                                peer-checked:border-[#37A0AF]">
                                                    {{ $concern->name }}
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="mb-6">
                                    <h3
                                        class="text-lg mb-5 w-full mt-6 p-4 border-y-[1px] border-y-[#CCE2E5] text-[#2A4043] font-semibold">
                                        Categoría</h3>
                                    <div class="grid grid-cols-2 gap-3 mx-4">
                                        @foreach ($categories as $c)
                                            <label class="cursor-pointer">
                                                <input type="radio" name="category_id" value="{{ $c->id }}"
                                                    class="hidden peer"
                                                    {{ request('category_id') == $c->id ? 'checked' : '' }}>
                                                <div
                                                    class="py-2 text-center rounded-xl border border-[#CCE2E5]
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
                            </section>

                            <div class="mt-6 p-4 border-t-[1px] border-t-[#CCE2E5]">
                                <button type="submit"
                                    class="btn text-md w-full px-5 mb-2 py-3 border-0 rounded-xl text-[#fff] font-semibold transition cursor-pointer hover:bg-[#306067] disabled:opacity-80 disabled:cursor-not-allowed bg-[#306067]">
                                    Filtrar
                                </button>
                            </div>
                        </form>
                    </div>
                </dialog>
                </div>
                @if(request()->hasAny(['q','type_id','category_id','skin_type_id','concern_id']))
            <div class="flex flex-wrap gap-2 mt-3 px-5">
                {{-- Tipo --}}
                @if(request('type_id'))
                    @php $type = $types->firstWhere('id', request('type_id')); @endphp
                    @if($type)
                        <a href="{{ route('brands.show', $brand->id) }}?{{ http_build_query(request()->except('type_id')) }}"
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
                        <a href="{{ route('brands.show', $brand->id) }}?{{ http_build_query(request()->except('category_id')) }}"
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
                        <a href="{{ route('brands.show', $brand->id) }}?{{ http_build_query(request()->except('skin_type_id')) }}"
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
                        <a href="{{ route('brands.show', $brand->id) }}?{{ http_build_query(request()->except('concern_id')) }}"
                        class="px-3 py-1 text-sm bg-[#CCE2E5] text-[#2A4043] rounded-full flex items-center">
                            {{ $concern->name }}
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#2A4043"><path d="M480-424 364-308q-11 11-28 11t-28-11q-11-11-11-28t11-28l116-116-116-115q-11-11-11-28t11-28q11-11 28-11t28 11l116 116 115-116q11-11 28-11t28 11q12 12 12 28.5T651-595L535-480l116 116q11 11 11 28t-11 28q-12 12-28.5 12T595-308L480-424Z"/></svg>
                        </a>
                    @endif
                @endif

            </div>
        @endif
            @forelse ($products ?? [] as $product)
                <x-product-card-hor :product="$product" />
            @empty
                <p class="text-[#CCE2E5]">¡Esta marca no tiene productos!</p>
            @endforelse
        </div>
    </section>


</x-layout>
