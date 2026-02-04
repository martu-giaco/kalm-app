<x-layout title="Mis favoritos">
    <section class="min-h-screen p-5 rounded-t-3xl bg-gradient-to-b from-white to-gray-50">

        {{-- Título --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-[#2A4043] border-b pb-3 border-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="inline-block w-8 h-8 mr-2 fill-[#430000]" viewBox="0 -960 960 960"><path d="M479.76-139.83q-16.15 0-32.44-5.83-16.3-5.84-28.97-18.27l-69.48-63.48Q243.35-323.7 157.61-420.03 71.87-516.37 71.87-634q0-97.59 65.15-162.98 65.15-65.39 162.74-65.39 52.52 0 99.28 21.42 46.76 21.43 80.72 59.47 33.96-38.04 80.72-59.47 46.76-21.42 99.28-21.42 97.59 0 163.1 65.39 65.51 65.39 65.51 162.98 0 117.63-85.6 214.47-85.6 96.83-193.12 193.36l-68.24 62.47q-12.67 12.44-29.08 18.16-16.42 5.71-32.57 5.71Z"/></svg>
                Mis Favoritos
            </h1>
        </div>

        @if ($favorites->count())
            {{-- Grid de productos --}}
            <div class="grid grid-cols-2 gap-4 pb-20 md:grid-cols-3 lg:grid-cols-4">
                @foreach ($favorites as $product)
                    <a href="{{ route('products.show', $product->id) }}" class="group">
                        <div class="overflow-hidden transition duration-300 bg-white shadow-md rounded-xl hover:shadow-lg relative">

                            {{-- Imagen --}}
                            <div class="w-full h-40 overflow-hidden bg-gray-100">
                                @if(!empty($product->image))
                                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                                         class="object-cover w-full h-full transition duration-300 group-hover:scale-105">
                                @else
                                    <div class="flex items-center justify-center w-full h-full text-gray-400">
                                        Sin imagen
                                    </div>
                                @endif
                            </div>

                            {{-- Botón quitar de favoritos --}}
                            <button type="button"
                                class="absolute p-2 transition bg-white rounded-full top-2 right-2 hover:scale-105"
                                title="Quitar de favoritos"
                                onclick="removeFavorite(event, {{ $product->id }})">
                                <svg class="fill-[#430000]" xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px">
                                    <path d="M479.76-139.83q-16.15 0-32.44-5.83-16.3-5.84-28.97-18.27l-69.48-63.48Q243.35-323.7 157.61-420.03 71.87-516.37 71.87-634q0-97.59 65.15-162.98 65.15-65.39 162.74-65.39 52.52 0 99.28 21.42 46.76 21.43 80.72 59.47 33.96-38.04 80.72-59.47 46.76-21.42 99.28-21.42 97.59 0 163.1 65.39 65.51 65.39 65.51 162.98 0 117.63-85.6 214.47-85.6 96.83-193.12 193.36l-68.24 62.47q-12.67 12.44-29.08 18.16-16.42 5.71-32.57 5.71Z"/>
                                </svg>
                            </button>

                            {{-- Información --}}
                            <div class="flex flex-col gap-2 p-3">
                                <h3 class="text-sm font-semibold text-[#2A4043] truncate">
                                    {{ $product->name }}
                                </h3>

                                @if(!empty($product->brand?->name))
                                    <p class="text-[10px] text-gray-500 truncate">{{ $product->brand->name }}</p>
                                @endif

                                @if(!empty($product->rating))
                                    <div class="flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="14px" viewBox="0 -960 960 960" width="14px" fill="#FFDE21">
                                            <path d="m682.11-375.7 152-130 27.91 2.24q19.39 2 30.33 15.68 10.93 13.67 10.93 29.82 0 9.2-3.59 18.16-3.6 8.95-12.32 15.91l-97.3 85.02 28.84 125.67q1 2.48 1.12 5.22.12 2.74.12 5.22 0 19.15-13.67 32.33-13.68 13.17-31.83 13.17-5.71 0-11.93-1.74t-11.94-5.22l-22.91-14.19-45.76-197.29Zm-99.5-308.26-40.33-94.17 9.48-22.72q5.72-13.67 17.65-20.89 11.94-7.22 24.37-7.22 12.68 0 24.49 6.72 11.82 6.72 17.53 20.63l53.81 127.37-107-9.72ZM185.15-208.41l44.24-189.72L81.67-525.85q-8.71-6.95-11.93-15.91-3.22-8.96-3.22-18.15 0-16.16 10.94-29.83 10.93-13.67 30.32-15.67l194.72-17 75.48-178.96q5.72-13.91 17.53-20.63 11.82-6.72 24.49-6.72 12.67 0 24.49 6.72 11.81 6.72 17.53 20.63l75.48 178.96 194.72 17q19.39 2 30.32 15.67 10.94 13.67 10.94 29.83 0 9.19-3.22 18.15-3.22 8.96-11.93 15.91L610.61-398.13l44.24 189.72q.76 2.28 1.24 10.43 0 19.15-13.68 32.33-13.67 13.17-31.82 13.17-3.96 0-23.87-6.95L420-259.91 253.28-159.43q-5.71 3.47-11.93 5.21-6.22 1.74-11.94 1.74-20.63 0-35.3-16.53-14.68-16.53-8.96-39.4Z"/>
                                        </svg>
                                        <span class="text-xs text-gray-600">{{ number_format($product->rating, 1) }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

        @else
            {{-- Estado vacío --}}
            <div class="flex flex-col items-center justify-center min-h-96">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-24 h-24 mb-4 text-gray-300" viewBox="0 -960 960 960">
                    <path fill="currentColor" d="M479.76-139.83q-16.15 0-32.44-5.83-16.3-5.84-28.97-18.27l-69.48-63.48Q243.35-323.7 157.61-420.03 71.87-516.37 71.87-634q0-97.59 65.15-162.98 65.15-65.39 162.74-65.39 52.52 0 99.28 21.42 46.76 21.43 80.72 59.47 33.96-38.04 80.72-59.47 46.76-21.42 99.28-21.42 97.59 0 163.1 65.39 65.51 65.39 65.51 162.98 0 117.63-85.6 214.47-85.6 96.83-193.12 193.36l-68.24 62.47q-12.67 12.44-29.08 18.16-16.42 5.71-32.57 5.71Z"/>
                </svg>
                <h2 class="text-2xl font-bold text-[#2A4043] mb-2">No tenés favoritos</h2>
                <p class="text-gray-500 mb-6 text-center max-w-sm">
                    Explora nuestros productos y marca los que te gusten como favoritos.
                </p>
                <a href="{{ route('home') }}" class="px-6 py-3 text-white bg-[#306067] rounded-lg hover:bg-[#2A4043] transition">
                    Explorar productos
                </a>
            </div>
        @endif

    </section>

    <script>
        function removeFavorite(event, productId) {
            event.preventDefault();
            event.stopPropagation();

            fetch(`/products/${productId}/favorito`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
                .then(res => {
                    if (!res.ok) {
                        throw new Error(`Error del servidor: ${res.status}`);
                    }
                    return res.json();
                })
                .then(data => {
                    // Verificar que se desfavoritizó correctamente
                    if (data.favorito === false) {
                        // Encontrar el contenedor del producto y removerlo
                        const button = event.target.closest('button');
                        const productCard = button.closest('a').closest('div').parentElement;

                        // Animar la desaparición
                        productCard.style.opacity = '0';
                        productCard.style.transform = 'scale(0.95)';
                        productCard.style.transition = 'all 0.3s ease-out';

                        setTimeout(() => {
                            productCard.remove();

                            // Verificar si no hay más productos
                            const remainingProducts = document.querySelectorAll('a[href*="/products/"]').length;
                            if (remainingProducts === 0) {
                                location.reload();
                            }
                        }, 300);
                    }
                })
                .catch(err => {
                    console.error('Error al quitar de favoritos:', err);
                    alert('Error al quitar de favoritos. Intenta de nuevo.');
                });
        }
    </script>
</x-layout>
