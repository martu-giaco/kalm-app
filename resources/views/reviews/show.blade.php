<x-layout :title="'Reseñas de ' . $product->name">
    <div class="max-w-4xl p-6 mx-auto mt-6">
        <!-- Encabezado del producto -->
        <div class="flex gap-6 mb-8 bg-white rounded-lg shadow-md p-6">
            <div class="w-24 h-24 flex-shrink-0">
                <img src="{{ $product->image_url }}" 
                     alt="{{ $product->name }}" 
                     class="w-full h-full object-cover rounded-lg">
            </div>
            <div class="flex-1">
                <h1 class="text-3xl font-bold text-[#164d4f] mb-2">{{ $product->name }}</h1>
                <p class="text-gray-600 mb-3">{{ $product->description }}</p>
                
                <div class="flex items-center gap-3">
                    <div class="flex items-center gap-1">
                        @php
                            $avgRating = $reviews->avg('rating') ?? 0;
                            $reviewCount = $reviews->count();
                        @endphp
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $avgRating)
                                <span class="text-yellow-400 text-lg">★</span>
                            @else
                                <span class="text-gray-300 text-lg">★</span>
                            @endif
                        @endfor
                    </div>
                    <span class="font-bold text-gray-800">{{ number_format($avgRating, 1) }}/5</span>
                    <span class="text-gray-600">({{ $reviewCount }} {{ $reviewCount === 1 ? 'reseña' : 'reseñas' }})</span>
                </div>
            </div>
            
            @if(auth()->check())
                <a href="{{ route('reviews.create', $product) }}" 
                   class="bg-[#306067] hover:bg-[#164d4f] text-white font-bold py-2 px-4 rounded-lg h-fit">
                    Escribir reseña
                </a>
            @endif
        </div>

        <!-- Filtro de calificaciones -->
        @if($reviewCount > 0)
            <div class="mb-6 bg-white rounded-lg shadow-md p-4">
                <p class="text-sm font-semibold text-gray-700 mb-3">Filtrar por calificación:</p>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('reviews.show', $product) }}" 
                       class="px-4 py-2 rounded-lg {{ !request('rating') ? 'bg-[#37A0AF] text-white' : 'bg-gray-200 text-gray-700' }}">
                        Todas
                    </a>
                    @for($rating = 5; $rating >= 1; $rating--)
                        @php
                            $count = $reviews->where('rating', $rating)->count();
                        @endphp
                        @if($count > 0)
                            <a href="{{ route('reviews.show', ['product' => $product, 'rating' => $rating]) }}" 
                               class="px-4 py-2 rounded-lg {{ request('rating') == $rating ? 'bg-[#37A0AF] text-white' : 'bg-gray-200 text-gray-700' }}">
                                {{ $rating }}★ ({{ $count }})
                            </a>
                        @endif
                    @endfor
                </div>
            </div>
        @endif

        <!-- Lista de reseñas -->
        <div class="bg-white rounded-lg shadow-md p-6">
            @if($reviews->count() > 0)
                <h2 class="text-xl font-bold text-[#164d4f] mb-4">Reseñas de clientes</h2>
                <div class="space-y-4">
                    @foreach($reviews as $review)
                        @include('reviews.review', ['review' => $review])
                    @endforeach
                </div>

                <!-- Paginación -->
                @if($reviews instanceof \Illuminate\Pagination\Paginator)
                    <div class="mt-6">
                        {{ $reviews->links() }}
                    </div>
                @endif
            @else
                <p class="text-center text-gray-500 py-8">
                    <span class="text-4xl mb-2 block">📝</span>
                    No hay reseñas aún. ¡Sé el primero en escribir una!
                </p>
            @endif
        </div>
    </div>
</x-layout>
