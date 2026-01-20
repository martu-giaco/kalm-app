<x-layout :title="$product->name ?? 'Producto'">
    <div class="max-w-3xl px-4 mx-auto">

        <article class="p-6 bg-white shadow-lg rounded-2xl">
            <div class="flex flex-col gap-6 md:flex-row">

                {{-- Imagen principal --}}
                <div class="relative md:flex-shrink-0 md:w-1/2">
                    <div class="overflow-hidden bg-white shadow-inner rounded-xl">
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
                        class="absolute p-2 transition bg-white rounded-full shadow top-3 right-3 hover:scale-105"
                        title="Marcar favorito" onclick="toggleFavorito({{ $product->id }}, this)">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-600" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor">
                            <path
                                d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78L12 21.23l8.84-8.84a5.5 5.5 0 0 0 0-7.78z"
                                stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>

                    {{-- Badge "Para vos!" --}}
                    @if(isset($product->tag) || session('personalized', false))
                        <span
                            class="absolute inline-block px-3 py-1 text-sm text-white bg-teal-400 rounded-full shadow bottom-4 right-4">
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

                        @if(!empty($product->brand->name))
                            <div class="mt-1 text-sm text-teal-600">{{ $product->brand->name }}</div>
                        @endif

                        {{-- Rating --}}
                        @if(isset($product->rating))
                            <div class="flex items-center gap-2 mt-3">
                                <div class="text-sm text-gray-600">{{ number_format($product->rating, 1) }}</div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-yellow-400" viewBox="0 0 24 24"
                                    fill="currentColor">
                                    <path
                                        d="M12 .587l3.668 7.431L23.2 9.75l-5.6 5.46L19.336 24 12 19.897 4.664 24 6.4 15.21 0.8 9.75l7.532-1.732z" />
                                </svg>
                            </div>
                        @endif

                        {{-- Tags --}}
                        @if(!empty($product->tags) && $product->tags->count())
                            <div class="flex flex-wrap gap-2 mt-4">
                                @foreach($product->tags as $tag)
                                    <span
                                        class="px-3 py-1 text-xs text-teal-700 rounded-full shadow-sm bg-teal-50">{{ $tag->name }}</span>
                                @endforeach
                            </div>
                        @elseif(!empty($product->category->name))
                            <div class="mt-4">
                                <span
                                    class="px-3 py-1 text-xs text-teal-700 rounded-full shadow-sm bg-teal-50">{{ $product->category->name }}</span>
                            </div>
                        @endif
                    </div>

                    {{-- Botón principal --}}
                    <div class="mt-6">
                        @if(isset($routines) && $routines->count())
                            <label for="modal-routines" class="btn bg-[#306067] text-white cursor-pointer">
                                Agregar a rutina
                            </label>
                        @else
                            <button disabled class="text-black cursor-not-allowed btn btn-">
                                No tiene rutinas
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Descripción --}}
            <div class="pt-6 mt-6 border-t">
                <h2 class="text-lg font-semibold text-[#164d4f] mb-3">Descripción</h2>
                <p class="leading-relaxed text-gray-700">
                    {{ $product->description ?? 'No hay descripción disponible.' }}
                </p>
            </div>

            {{-- Detalles del producto --}}
            <div class="pt-6 mt-6 border-t">
                <h2 class="text-lg font-semibold text-[#164d4f] mb-4">Detalles del producto</h2>
                <div class="flex flex-wrap gap-4">

                    @if(!empty($product->brand_id))
                        <div class="p-3 bg-white shadow-md w-36 rounded-xl">
                            <p class="text-[10px] text-gray-500 mb-1">Marca</p>
                            <h3 class="text-sm font-semibold">{{ $product->brand->name ?? '-' }}</h3>
                        </div>
                    @endif

                    @if(!empty($product->type_id))
                        <div class="p-3 bg-white shadow-md w-36 rounded-xl">
                            <p class="text-[10px] text-gray-500 mb-1">Tipo</p>
                            <h3 class="text-sm font-semibold">{{ $product->type->name ?? '-' }}</h3>
                        </div>
                    @endif

                    @if(!empty($product->category_id))
                        <div class="p-3 bg-white shadow-md w-36 rounded-xl">
                            <p class="text-[10px] text-gray-500 mb-1">Categoría</p>
                            <h3 class="text-sm font-semibold">{{ $product->category->name ?? '-' }}</h3>
                        </div>
                    @endif

                    @if(!empty($product->ingredients))
                        <div class="p-3 bg-white shadow-md w-36 rounded-xl">
                            <p class="text-[10px] text-gray-500 mb-1">Ingredientes</p>
                            <h3 class="text-sm font-semibold">{{ Str::limit($product->ingredients, 50) }}</h3>
                        </div>
                    @endif

                    @if(!empty($product->activos))
                        <div class="p-3 bg-white shadow-md w-36 rounded-xl">
                            <p class="text-[10px] text-gray-500 mb-1">Activos</p>
                            <h3 class="text-sm font-semibold">{{ Str::limit($product->activos, 50) }}</h3>
                        </div>
                    @endif

                    @if(!empty($product->formato))
                        <div class="p-3 bg-white shadow-md w-36 rounded-xl">
                            <p class="text-[10px] text-gray-500 mb-1">Formato</p>
                            <h3 class="text-sm font-semibold">{{ $product->formato }}</h3>
                        </div>
                    @endif

                    @if(!empty($product->dondeComprar))
                        <div class="p-3 bg-white shadow-md w-36 rounded-xl">
                            <p class="text-[10px] text-gray-500 mb-1">Dónde comprar</p>
                            <h3 class="text-sm font-semibold">{{ $product->dondeComprar }}</h3>
                        </div>
                    @endif

                </div>
            </div>

        </article>
    </div>

    <input type="checkbox" id="modal-routines" class="modal-toggle" />
<div class="modal">
    <div class="relative w-full max-w-md p-6 modal-box">
        <label for="modal-routines" class="absolute btn btn-sm btn-circle right-2 top-2">✕</label>
        <h3 class="text-xl font-bold mb-4 text-[var(--kalm-dark)]">Selecciona la rutina</h3>

        @if(isset($routines) && $routines->count())
            <div class="space-y-3">
                @foreach($routines as $routine)
                    <form action="{{ route('routines.addProduct', $routine) }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <button type="submit"
                            class="w-full px-4 py-3 text-left transition-colors bg-white border border-gray-200 rounded-lg hover:bg-gray-50">
                            {{ $routine->name }}
                        </button>
                    </form>
                @endforeach
            </div>
        @else
            <p class="mt-2 text-sm text-slate-400">¡Este usuario no tiene rutinas!</p>
        @endif
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
