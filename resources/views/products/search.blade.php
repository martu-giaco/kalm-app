{{-- filepath: resources/views/products/search.blade.php --}}

<x-layout title="Kälm | Resultados de Búsqueda">

    {{-- Resultados de búsqueda --}}
    <div class="pb-6 px-5">

        {{-- Barra de búsqueda --}}
        <div class="mb-6 relative">
            <form action="{{ route('products.search') }}" method="GET">
                {{-- Lupa dentro del input --}}
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1110.5 3a7.5 7.5 0 016.15 13.65z" />
                    </svg>
                </span>

                <input type="text" name="q" placeholder="Buscar productos, marcas o ingredientes"
                    value="{{ request('q') }}" class="w-full pl-10 p-3 rounded-xl border border-gray-400 bg-white text-gray-700 shadow-sm
                      focus:outline-none focus:ring-2 focus:ring-[var(--kalm-main)] focus:border-[var(--kalm-main)]">
            </form>
        </div>

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

</x-layout>
