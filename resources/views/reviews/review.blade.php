<div class="p-4 mb-4 bg-white rounded-lg shadow-md border-l-4 border-[#37A0AF]">
    <div class="flex items-start justify-between">
        <div class="flex-1">
            <div class="flex items-center gap-2 mb-2">
                <img src="{{ $review->user->profile_image ?? 'https://via.placeholder.com/40' }}" 
                     alt="{{ $review->user->name }}" 
                     class="w-10 h-10 rounded-full object-cover">
                <div>
                    <p class="font-bold text-gray-800">{{ $review->user->name }}</p>
                    <p class="text-xs text-gray-500">{{ $review->created_at->diffForHumans() }}</p>
                </div>
            </div>

            <div class="flex items-center gap-1 mb-2">
                @for($i = 1; $i <= 5; $i++)
                    @if($i <= $review->rating)
                        <span class="text-yellow-400">★</span>
                    @else
                        <span class="text-gray-300">★</span>
                    @endif
                @endfor
                <span class="text-sm font-semibold text-gray-600 ml-2">{{ $review->rating }}/5</span>
            </div>

            <p class="text-gray-700 text-sm leading-relaxed">{{ $review->comment }}</p>
        </div>

        @if(auth()->check() && (auth()->id() === $review->user_id || auth()->user()->role === 'admin'))
            <div class="flex gap-2 ml-4">
                <a href="{{ route('reviews.edit', $review) }}" 
                   class="text-blue-500 hover:text-blue-700 font-semibold text-sm">
                    Editar
                </a>
                <form action="{{ route('reviews.destroy', $review) }}" method="POST" class="inline" 
                      onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta reseña?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500 hover:text-red-700 font-semibold text-sm">
                        Eliminar
                    </button>
                </form>
            </div>
        @endif
    </div>
</div>
