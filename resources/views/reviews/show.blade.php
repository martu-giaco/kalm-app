<x-layout :title="'Reseñas de ' . $product->name">
    <div class="max-w-4xl p-6 mx-auto mt-6">
        <!-- Encabezado del producto -->
        <div class="flex gap-6 p-6 mb-8 bg-white rounded-lg shadow-md">
            <div class="flex-shrink-0 w-24 h-24">
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="object-cover w-full h-full rounded-lg">
            </div>
            <div class="flex-1">
                <h1 class="text-3xl font-bold text-[#164d4f] mb-2">{{ $product->name }}</h1>
                <p class="mb-3 text-gray-600">{{ $product->description }}</p>
                
                <div class="flex items-center gap-3">
                    <div class="flex items-center gap-1">
                        @php
                            $avgRating = $reviews->avg('rating') ?? 0;
                            $reviewCount = $reviews->count();
                        @endphp
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $avgRating)
                                <span class="text-lg text-yellow-400">★</span>
                            @else
                                <span class="text-lg text-gray-300">★</span>
                            @endif
                        @endfor
                    </div>
                    <span class="font-bold text-gray-800">{{ number_format($avgRating, 1) }}/5</span>
                    <span class="text-gray-600">({{ $reviewCount }} {{ $reviewCount === 1 ? 'reseña' : 'reseñas' }})</span>
                </div>
            </div>
        </div>

        <!-- Lista de reseñas -->
        <div class="p-6 bg-white rounded-lg shadow-md">
            @if($reviews->count() > 0)
                <h2 class="text-xl font-bold text-[#164d4f] mb-4">Reseñas de usuarios</h2>
                <div class="space-y-4">
                    @foreach($reviews as $review)
                        @include('reviews.review', ['review' => $review])
                    @endforeach
                </div>
            @else
                <p class="py-8 text-center text-gray-500">
                    <span class="block mb-2 text-4xl">📝</span>
                    No hay reseñas aún. ¡Sé el primero en escribir una!
                </p>
            @endif
        </div>
    </div>
</x-layout>