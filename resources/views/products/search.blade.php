<x-layout title="Kälm | Resultados de Búsqueda">

    {{-- Resultados de búsqueda --}}
    <div class="mb-6">
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

        <h2 class="text-lg font-semibold text-[var(--kalm-dark)] mb-4">Resultados para: "{{ $query }}"</h2>

        @if($products->isEmpty())
            <p class="text-sm text-[var(--kalm-text)]">No se encontraron productos.</p>
        @else
            <div class="space-y-4">
                @foreach($products as $product)
                    @include('components.product_search', ['product' => $product])
                @endforeach
            </div>

            {{-- Paginación --}}
            <div class="mt-4">
                {{ $products->links() }}
            </div>
        @endif
    </div>

</x-layout>
