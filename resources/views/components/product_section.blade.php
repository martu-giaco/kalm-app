<div class="text-start w-full mb-8">
    {{-- Título de la sección --}}
    <h2 class="text-xl font-semibold text-[var(--kälm-dark)] mb-3">{{ $title }}</h2>

    {{-- Contenedor del carrusel horizontal --}}
    <div class="flex space-x-4 overflow-x-scroll pb-4 scrollbar-hide">

        @forelse ($products as $product)
            {{-- Tarjeta de Producto Vertical (W-40 coincide con el carrusel) --}}
            <div class="flex-shrink-0 w-40">

                {{-- Imagen y corazón de Favorito --}}
                <div class="relative">
                    <figure class="h-40 w-full overflow-hidden rounded-xl border border-gray-100 mb-2">
                        <img
                            src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/placeholder_product.svg') }}"
                            alt="{{ $product->name }}"
                            class="w-full h-full object-cover"
                        />
                    </figure>
                    {{-- Corazón de Favorito (Icono de corazón con sombra) --}}
                    <button class="absolute top-2 right-2 p-1 bg-white rounded-full shadow-lg">
                        <svg class="w-5 h-5 text-gray-400 hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    </button>
                </div>

                {{-- Nombre --}}
                <a href="{{ route('products.show', $product->id) }}">
                    <h4 class="text-sm text-[var(--kälm-dark)] leading-tight truncate">
                        {{ $product->name }}
                    </h4>
                </a>

                {{-- Marca --}}
                <p class="text-xs text-[#CCE2E5] mt-0.5">
                    {{ $product->brand->name ?? 'Marca Desconocida' }}
                </p>

                {{-- Tag (Novedades o Rating) --}}
                <span class="inline-flex items-center text-xs font-medium px-2.5 py-0.5 rounded-full mt-1 {{ $tag_class }}">
                    {{ $tag_text }}
                </span>
            </div>
        @empty
            <p class="text-sm text-[var(--kälm-text)]">Aún no hay productos para esta sección.</p>
        @endforelse

    </div>
</div>
