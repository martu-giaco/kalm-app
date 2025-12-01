<div class="flex-shrink-0 {{ $class ?? 'w-40 md:w-44' }} bg-white rounded-xl shadow-sm p-3 relative">

    {{-- Corazón de favorito --}}
    @php
        $favoritos = auth()->user()?->favoritos ? json_decode(auth()->user()->favoritos, true) : [];
        $isFavorito = is_array($favoritos) && in_array($product->id, $favoritos);
    @endphp

    <form action="{{ route('productos.toggleFavorito', $product->id) }}" method="POST"
        class="absolute top-2 right-2 fav-form">
        @csrf
        <button type="button" class="w-6 h-6 cursor-pointer">
            <span class="heart-icon">
                @if($isFavorito)
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#EF4444" stroke="none"
                        class="w-6 h-6">
                        <path
                            d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41 0.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                    </svg>
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#9CA3AF"
                        stroke-width="2" class="w-6 h-6">
                        <path
                            d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41 0.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                    </svg>
                @endif
            </span>
        </button>
    </form>

    {{-- Imagen --}}
    {{-- Imagen circular --}}
    <div class="w-28 h-28 mx-auto mb-2 overflow-hidden rounded-full bg-gray-100">
        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
    </div>


    {{-- Nombre --}}
    <p class="text-sm font-medium text-[var(--kalm-dark)] mb-1 truncate">{{ $product->name }}</p>

    {{-- Marca --}}
    <p class="text-xs text-[var(--kalm-main)] mb-1 truncate">{{ $product->brand->name ?? $product->brand }}</p>

    {{-- Tipo --}}
    @if(isset($product->type->name))
        <p class="text-xs text-[var(--kalm-text)] mb-1 truncate">Tipo: {{ $product->type->name }}</p>
    @endif

    {{-- Categoría --}}
    @if(isset($product->category->name))
        <p class="text-xs text-[var(--kalm-text)] mb-1 truncate">Categoría: {{ $product->category->name }}</p>
    @endif

    {{-- Dónde comprar --}}
    @if(isset($product->purchase_link))
        <a href="{{ $product->purchase_link }}" target="_blank"
            class="text-xs text-[var(--kalm-main)] underline mb-1 block truncate">
            Dónde comprar
        </a>
    @endif

    {{-- Etiqueta --}}
    @if ($product->resolved_tag_text)
        <span class="text-[0.65rem] px-2 py-0.5 rounded-full bg-[var(--kalm-main-light)] text-white">
            {{ $product->resolved_tag_text }}
        </span>
    @endif
</div>

@once
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.fav-form').forEach(form => {
                const button = form.querySelector('button');
                const icon = button.querySelector('.heart-icon');

                button.addEventListener('click', async (e) => {
                    e.preventDefault();

                    try {
                        const token = form.querySelector('input[name="_token"]').value;

                        const response = await fetch(form.action, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': token,
                                'Accept': 'application/json'
                            }
                        });

                        const data = await response.json();

                        // Actualiza solo el SVG
                        if (data.favorito) {
                            icon.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#EF4444" stroke="none" class="w-6 h-6"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41 0.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>';
                        } else {
                            icon.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#9CA3AF" stroke-width="2" class="w-6 h-6"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41 0.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>';
                        }

                    } catch (error) {
                        console.error('Error al actualizar favorito:', error);
                    }
                });
            });
        });
    </script>
@endonce
