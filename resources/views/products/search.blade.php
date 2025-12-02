{{-- filepath: resources/views/products/search.blade.php --}}

<x-layout title="Kälm | Resultados de Búsqueda">
    <section>
    {{-- Barra de búsqueda --}}
    <div class="mb-[-3vw] relative">
        <form action="{{ route('products.search') }}" method="GET" class="px-5">
            {{-- Lupa dentro del input --}}
            <span class="absolute left-3 top-1/2 -translate-y-1/2 pl-5">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#2A4043"><path d="M380-320q-109 0-184.5-75.5T120-580q0-109 75.5-184.5T380-840q109 0 184.5 75.5T640-580q0 44-14 83t-38 69l224 224q11 11 11 28t-11 28q-11 11-28 11t-28-11L532-372q-30 24-69 38t-83 14Zm0-80q75 0 127.5-52.5T560-580q0-75-52.5-127.5T380-760q-75 0-127.5 52.5T200-580q0 75 52.5 127.5T380-400Z"/></svg>
            </span>

            <input type="text" name="q" placeholder="Buscar productos, marcas o ingredientes" value="{{ request('q') }}"
                class="w-full pl-10 p-3 rounded-lg shadow-xl bg-white border border-[#CCE2E5] text-[#306067] placeholder-[#CCE2E5]
                    focus:outline-none focus:ring-2 focus:ring-[#37A0AF] focus:border-[#37A0AF]">
        </form>
    </div>
    {{-- Resultados de búsqueda --}}
    <div class="pb-6 pt-7 px-5 rounded-t-3xl bg-white min-h-screen">

        {{-- Título de resultados --}}
        <div class="flex justify-between">
            <h2 class="text-lg font-semibold text-[#306067] mb-4">
            Resultados para: "{{ $query ?? request('q') }}"
        </h2>
        <a href="">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#306067"><path d="M710-150q-63 0-106.5-43.5T560-300q0-63 43.5-106.5T710-450q63 0 106.5 43.5T860-300q0 63-43.5 106.5T710-150Zm0-80q29 0 49.5-20.5T780-300q0-29-20.5-49.5T710-370q-29 0-49.5 20.5T640-300q0 29 20.5 49.5T710-230Zm-270-30H200q-17 0-28.5-11.5T160-300q0-17 11.5-28.5T200-340h240q17 0 28.5 11.5T480-300q0 17-11.5 28.5T440-260ZM250-510q-63 0-106.5-43.5T100-660q0-63 43.5-106.5T250-810q63 0 106.5 43.5T400-660q0 63-43.5 106.5T250-510Zm0-80q29 0 49.5-20.5T320-660q0-29-20.5-49.5T250-730q-29 0-49.5 20.5T180-660q0 29 20.5 49.5T250-590Zm510-30H520q-17 0-28.5-11.5T480-660q0-17 11.5-28.5T520-700h240q17 0 28.5 11.5T800-660q0 17-11.5 28.5T760-620Zm-50 320ZM250-660Z"/></svg>
        </a>
        </div>

        {{-- Mostrar mensaje si no hay productos --}}
        @if($products->isEmpty())
            <p class="text-sm text-[var(--kalm-text)]">No se encontraron productos que coincidan con tu búsqueda.</p>
        @else
            {{-- Lista de productos --}}
            <div class="space-y-4">
                @foreach($products as $product)
                    <div class="flex items-center border-b border-gray-200 py-3">

                        {{-- Imagen del producto --}}
                        <div class="flex-shrink-0 w-20 h-20 rounded-full overflow-hidden bg-[var(--kalm-light)]">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">

                        </div>

                        {{-- Info del producto --}}
                        <div class="ml-4 flex-1">
                            <h3 class="text-sm font-medium text-[#306067]">{{ $product->name }}</h3>
                            <p class="text-xs text-[var(--kalm-text)] mt-1">
                                <strong>Marca:</strong> {{ $product->brand->name ?? '-' }}
                            </p>
                            <p class="text-xs text-[var(--kalm-text)] mt-1">
                                <strong>Tipo:</strong> {{ $product->type->name ?? '-' }}
                            </p>
                            <p class="text-xs text-[var(--kalm-text)] mt-1">
                                <strong>Categoría:</strong> {{ $product->category->name ?? '-' }}
                            </p>



                            {{-- Tag si existe --}}
                            @if(isset($product->resolved_tag_text))
                                <span
                                    class="inline-block mt-2 px-2 py-0.5 text-xs font-semibold rounded {{ $product->tag_class ?? 'bg-teal-100 text-teal-800' }}">
                                    {{ $product->resolved_tag_text }}
                                </span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Paginación --}}
            <div class="mt-4">
                {{ $products->links() }}
            </div>
        @endif

    </div>
    </section>
</x-layout>
