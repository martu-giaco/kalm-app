<x-layout :title="$product->name ?? 'Producto'">
    <div class="max-w-3xl mx-auto">

        <article class="pb-6 pt-7 px-5 rounded-t-3xl bg-white">
            <div class="flex flex-col gap-6 md:flex-row">

                {{-- Imagen principal --}}
                <div class="relative md:flex-shrink-0 md:w-1/2">
                    <div class="overflow-hidden bg-white shadow-lg rounded-3xl">
                        @if(!empty($product->image))
                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                                class="object-contain w-full bg-white h-80">
                        @else
                            <div class="flex items-center justify-center w-full text-gray-400 h-80">
                                Sin imagen
                            </div>
                        @endif
                    </div>

                    {{-- Corazón favorito --}}
                    <button type="button"
                        class="absolute p-2 transition bg-white rounded-full top-3 right-3 hover:scale-105"
                        title="Marcar favorito" onclick="toggleFavorito({{ $product->id }}, this)">
                        <svg xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 -960 960 960" width="30px" fill="#430000"><path d="M479.76-139.83q-16.15 0-32.44-5.83-16.3-5.84-28.97-18.27l-69.48-63.48Q243.35-323.7 157.61-420.03 71.87-516.37 71.87-634q0-97.58 65.15-162.97 65.15-65.4 162.74-65.4 52.52 0 99.28 21.42 46.76 21.43 80.72 59.47 33.96-38.04 80.72-59.47 46.76-21.42 99.28-21.42 97.68 0 163.14 65.4 65.47 65.39 65.47 162.97 0 117.63-85.6 214.47-85.6 96.83-193.12 193.36l-68.24 62.47q-12.67 12.44-29.08 18.16-16.42 5.71-32.57 5.71ZM440.09-688.8q-27.57-39.57-60.93-61.07t-79.33-21.5q-58.7 0-97.83 39.16-39.13 39.17-39.13 98.21 0 51.54 36.64 109.52 36.64 57.99 87.64 112.5 51 54.52 104.97 102.09 53.97 47.58 87.64 78.3 33.76-31 87.83-78.55 54.07-47.56 105.16-102.04 51.1-54.49 87.86-112.28 36.76-57.78 36.76-109.54 0-59.04-39.28-98.21-39.29-39.16-98.21-39.16-46.16 0-79.4 21.5-33.24 21.5-60.81 61.07-7.31 10.71-17.75 16.07-10.44 5.36-22.16 5.36t-22.07-5.36q-10.36-5.36-17.6-16.07ZM480-501.48Z"/></svg>
                    </button>

                    {{-- Badge "Para vos!" --}}
                    @if(isset($product->tag) || session('personalized', false))
                        <span
                            class="absolute inline-block px-3 py-1 text-sm text-white bg-[#37A0AF] rounded-full shadow bottom-4 right-4">
                            Para vos!
                        </span>
                    @endif
                </div>

                {{-- Información lateral --}}
                <div class="flex flex-col justify-between md:w-1/2">
                    <div>
                        <h1 class="text-2xl md:text-2xl font-semibold text-[#164d4f] leading-tight">
                            {{ $product->name ?? 'Producto sin nombre' }}
                        </h1>

                        <div class="flex justify-between items-center">
                        @if(!empty($product->brand->name))
                            <h2 class="mt-1 text-lg text-[#37A0AF] truncate">{{ $product->brand->name }}</h2>
                        @endif

                        {{-- Rating --}}
                        @if(isset($product->rating))
                            <div class="flex items-center gap-2 mt-3">
                                <div class="text-md text-[#CCE2E5]">{{ number_format($product->rating, 1) }}</div>
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#FFDE21"><path d="m682.11-375.7 152-130 27.91 2.24q19.39 2 30.33 15.68 10.93 13.67 10.93 29.82 0 9.2-3.59 18.16-3.6 8.95-12.32 15.91l-97.3 85.02 28.84 125.67q1 2.48 1.12 5.22.12 2.74.12 5.22 0 19.15-13.67 32.33-13.68 13.17-31.83 13.17-5.71 0-11.93-1.74t-11.94-5.22l-22.91-14.19-45.76-197.29Zm-99.5-308.26-40.33-94.17 9.48-22.72q5.72-13.67 17.65-20.89 11.94-7.22 24.37-7.22 12.68 0 24.49 6.72 11.82 6.72 17.53 20.63l53.81 127.37-107-9.72ZM185.15-208.41l44.24-189.72L81.67-525.85q-8.71-6.95-11.93-15.91-3.22-8.96-3.22-18.15 0-16.16 10.94-29.83 10.93-13.67 30.32-15.67l194.72-17 75.48-178.96q5.72-13.91 17.53-20.63 11.82-6.72 24.49-6.72 12.67 0 24.49 6.72 11.81 6.72 17.53 20.63l75.48 178.96 194.72 17q19.39 2 30.32 15.67 10.94 13.67 10.94 29.83 0 9.19-3.22 18.15-3.22 8.96-11.93 15.91L610.61-398.13l44.24 189.72q.76 2.28 1.24 10.43 0 19.15-13.68 32.33-13.67 13.17-31.82 13.17-3.96 0-23.87-6.95L420-259.91 253.28-159.43q-5.71 3.47-11.93 5.21-6.22 1.74-11.94 1.74-20.63 0-35.3-16.53-14.68-16.53-8.96-39.4Z"/></svg>
                            </div>
                        @endif
                        </div>

                        {{-- Tags --}}
                        @if(!empty($product->tags) && $product->tags->count())
                            <div class="flex flex-wrap gap-2 mt-4">
                                @foreach($product->tags as $tag)
                                    <button
                                        class="text-white text-sm truncate bg-[#37A0AF] px-2 py-1 rounded-xl">{{ $tag->name }}</button>
                                @endforeach
                            </div>
                        @elseif(!empty($product->category->name))
                            <div class="flex flex-wrap gap-2 my-3">
                                                <button class="text-sm inline-block text-white truncate bg-[#37A0AF] px-3 py-1 rounded-2xl">
                                                    ✨{{ $product->type->name ?? '-' }}
                                                </button>
                                                <button class="text-sm inline-block text-white truncate bg-[#37A0AF] px-3 py-1 rounded-2xl">
                                                    {{ $product->category->name ?? '-' }}
                                                </button>
                                            </div>
                        @endif
                    </div>

                    {{-- Botón principal --}}
                    <div class="mt-6">
                            <label for="modal-routines" class="btn font-bold w-full bg-[#306067] text-white cursor-pointer">
                                Agregar a rutina
                            </label>
                    </div>
                </div>
            </div>

            {{-- Descripción --}}
            <div class="pt-6 mt-6 border-t">
                <h2 class="text-lg font-semibold text-[#164d4f] mb-2">Descripción</h2>
                <p class="leading-relaxed text-gray-700">
                    {{ $product->description ?? 'No hay descripción disponible.' }}
                </p>
            </div>

            {{-- Reviews --}}
            <div class="pt-6 mt-6 border-t">
                <h2 class="text-lg font-semibold text-[#164d4f] mb-2">Reseñas de usuarios</h2>
                <p>en proceso</p>
            </div>

            {{-- Detalles del producto --}}
            <div class="pt-6 mt-6 border-t">
                <h2 class="text-lg font-semibold text-[#164d4f] mb-2">Detalles del producto</h2>
                <div class="flex flex-wrap gap-4">

                    @if(!empty($product->ingredients))
                        <div class="p-3 bg-white shadow-md w-36 rounded-xl">
                            <h3 class="text-sm text-gray-500 mb-1">Ingredientes</h3>
                            <p class="text-sm font-bold">{{ Str::limit($product->ingredients, 50) }}</p>
                        </div>
                    @endif

                    @if(!empty($product->activos))
                        <div class="p-3 bg-white shadow-md w-36 rounded-xl">
                            <h3 class="text-sm text-gray-500 mb-1">Activos</h3>
                            <p class="text-sm font-bold">{{ Str::limit($product->activos, 50) }}</p>
                        </div>
                    @endif

                    @if(!empty($product->formato))
                        <div class="p-3 bg-white shadow-md w-36 rounded-xl">
                            <h3 class="text-sm text-gray-500 mb-1">Formato</h3>
                            <p class="text-sm font-bold">{{ $product->formato }}</p>
                        </div>
                    @endif

                    @if(!empty($product->dondeComprar))
                        <div class="p-3 bg-white shadow-md w-36 rounded-xl">
                            <h3 class="text-sm text-gray-500 mb-1">Dónde comprar</h3>
                            <p class="text-sm font-bold">{{ $product->dondeComprar }}</p>
                        </div>
                    @endif

                </div>
            </div>

            <div class="pt-6 mt-6 border-t">
                <h2 class="text-lg font-bold text-[#164d4f] mb-2">Ingredientes</h2>
                <p class="text-sm font-bold">{{ Str::limit($product->ingredients, 50) }}</p>
            </div>

        </article>
    </div>

    <input type="checkbox" id="modal-routines" class="modal-toggle" />
    <div id="modal-routines" class="modal">
        <div class="modal-box w-full max-w-2xl p-6">
            <label for="modal-routines" class="absolute btn btn-sm btn-circle right-2 top-2">✕</label>
            <h3 class="text-xl font-bold mb-4 text-[#306067]">Selecciona la rutina</h3>

            <div class="space-y-3">
                @foreach($routines as $routine)
                    <form action="{{ route('routines.addProduct', $routine) }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <x-routine-card
                            :rutina="$routine"
                            class="cursor-pointer"
                            onclick="this.closest('form').submit()"
                        />
                    </form>
                @endforeach
            </div>

        </div>
    </div>

    <script>
        function toggleFavorito(productId, btn) {
            fetch(`/products/${productId}/favorito`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
                .then(res => res.json())
                .then(data => {
                    if (data.favorito) btn.classList.add('text-red-600');
                    else btn.classList.remove('text-red-600');
                })
                .catch(err => console.error('Error al marcar favorito', err));
        }
    </script>
</x-layout>
