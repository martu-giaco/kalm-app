{{-- resources/views/products/show.blade.php --}}
<x-layout :title="$product->name ?? 'Producto'">
    <div class="max-w-3xl mx-auto px-4 py-8">
        <a href="{{ url()->previous() }}" class="text-sm text-gray-600 mb-4 inline-block">&larr; Volver</a>

        <article class="bg-white rounded-2xl p-6 shadow-lg">
            <div class="flex flex-col md:flex-row gap-6">
                {{-- Imagen principal --}}
                <div class="relative md:flex-shrink-0 md:w-1/2">
                    <div class="rounded-xl overflow-hidden bg-white shadow-inner">
                        @if(!empty($product->image))
                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="w-full h-80 object-contain bg-white">
                        @else
                            <div class="w-full h-80 flex items-center justify-center text-gray-400">
                                Sin imagen
                            </div>
                        @endif
                    </div>

                    {{-- Corazón favorito (arriba derecha) --}}
                    <button
                        type="button"
                        class="absolute top-3 right-3 bg-white rounded-full p-2 shadow hover:scale-105 transition"
                        title="Marcar favorito"
                        aria-label="Marcar favorito">
                        {{-- Usá svg inline --}}
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-600" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78L12 21.23l8.84-8.84a5.5 5.5 0 0 0 0-7.78z" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>

                    {{-- Badge "Para vos!" --}}
                    @if(isset($product->tag) || session('personalized', false))
                        <span class="absolute bottom-4 right-4 inline-block bg-teal-400 text-white text-sm px-3 py-1 rounded-full shadow">
                            Para vos!
                        </span>
                    @endif
                </div>

                {{-- Información lateral --}}
                <div class="md:w-1/2 flex flex-col justify-between">
                    <div>
                        {{-- Título y subtítulo (marca) --}}
                        <h1 class="text-2xl md:text-2xl font-semibold text-[#164d4f] leading-tight">
                            {{ $product->name }}
                        </h1>

                        @if(!empty($product->brand->name))
                            <div class="text-sm text-teal-600 mt-1">{{ $product->brand->name }}</div>
                        @endif

                        {{-- Rating --}}
                        @if(isset($product->rating))
                            <div class="mt-3 flex items-center gap-2">
                                <div class="text-sm text-gray-600">{{ number_format($product->rating, 1) }}</div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-yellow-400" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 .587l3.668 7.431L23.2 9.75l-5.6 5.46L19.336 24 12 19.897 4.664 24 6.4 15.21 0.8 9.75l7.532-1.732z"/>
                                </svg>
                            </div>
                        @endif

                        {{-- Tags/Chips --}}
                        @if($product->tags && $product->tags->count())
                            <div class="mt-4 flex flex-wrap gap-2">
                                @foreach($product->tags as $tag)
                                    <span class="text-xs bg-teal-50 text-teal-700 px-3 py-1 rounded-full shadow-sm">{{ $tag->name }}</span>
                                @endforeach
                            </div>
                        @elseif(!empty($product->category->name))
                            <div class="mt-4">
                                <span class="text-xs bg-teal-50 text-teal-700 px-3 py-1 rounded-full shadow-sm">{{ $product->category->name }}</span>
                            </div>
                        @endif

                        {{-- Precio (opcional) --}}
                        @if(isset($product->price))
                            <div class="mt-5 text-lg md:text-xl font-semibold text-[#134d4d]">
                                ${{ number_format($product->price, 2, ',', '.') }}
                            </div>
                        @endif
                    </div>

                    {{-- Botón principal --}}
                    <div class="mt-6">
                        <form action="{{ route('routines.add', ['product' => $product->id]) ?? url('#') }}" method="POST" class="flex items-center gap-3">
                            @csrf
                            <button type="submit" class="w-full bg-[#164d4f] text-white px-4 py-3 rounded-lg text-center font-medium hover:opacity-95">
                                Agregar a rutina
                            </button>

                            {{-- Opcional: botón pequeño para favorito --}}
                            <button type="button" class="ml-2 inline-flex items-center justify-center p-2 rounded-lg border border-gray-200 hover:bg-gray-50" title="Favorito">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-600" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78L12 21.23l8.84-8.84a5.5 5.5 0 0 0 0-7.78z" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Descripción --}}
            <div class="mt-6 border-t pt-6">
                <h2 class="text-lg font-semibold text-[#164d4f] mb-3">Descripción</h2>
                @if(!empty($product->description))
                    <p class="text-gray-700 leading-relaxed">{{ $product->description }}</p>
                @else
                    <p class="text-gray-500">No hay descripción disponible.</p>
                @endif
            </div>
        </article>
    </div>
</x-layout>
