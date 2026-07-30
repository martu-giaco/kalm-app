<div class="p-4 mb-4 bg-white dark:bg-[#203235] rounded-xl shadow-md border-l-4 border-[#37A0AF]">
    <div class="flex items-start justify-between gap-4">
        <div class="flex-1">
            {{-- Usuario y fecha --}}
            <div class="flex items-center gap-2 mb-2">
                <img src="{{ $review->user->avatar_url ?? asset('images/default-avatar.png') }}"
                     alt="{{ $review->user->name }}" 
                     class="object-cover w-10 h-10 rounded-full">
                    
                <div>
                    <p class="font-bold text-gray-800 dark:text-[#CCE2E5]">{{ $review->user->name }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $review->created_at->diffForHumans() }}</p>
                </div>
            </div>

            {{-- Estrellas --}}
            <div class="flex items-center gap-1 mb-2">
                @for ($i = 1; $i <= 5; $i++)
                    @if ($i <= $review->rating)
                        <span class="text-yellow-400">★</span>
                    @else
                        <span class="text-gray-300 dark:text-gray-600">★</span>
                    @endif
                @endfor
                <span class="ml-2 text-sm font-semibold text-gray-600 dark:text-[#CCE2E5]">{{ $review->rating }}/5</span>
            </div>

            {{-- Comentario --}}
            <p class="text-sm leading-relaxed text-gray-700 dark:text-[#E9E5E3]">{{ $review->comment }}</p>

            {{-- Imagen de la Reseña --}}
            @if (!empty($review->image))
                <div class="mt-3 overflow-hidden rounded-xl">
                    <img src="{{ asset(ltrim($review->image, '/')) }}" 
                         alt="Imagen de la reseña" 
                         class="object-cover max-w-full h-40 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm">
                </div>
            @endif
        </div>

        {{-- Acciones independientes para Mobile --}}
        @if (auth()->check() && (auth()->id() === $review->user_id || auth()->user()->role === 'admin'))
            <div class="flex items-center gap-3">
                {{-- Botón Editar --}}
                <a href="{{ route('reviews.edit', $review) }}"
                   class="p-2.5 bg-blue-50 dark:bg-blue-950/40 border border-blue-200 dark:border-blue-800/50 text-blue-600 dark:text-blue-400 rounded-lg active:bg-blue-100 dark:active:bg-blue-900/60 transition-colors"
                   aria-label="Editar reseña">
                    <svg class="w-4 h-4 fill-current" viewBox="0 -960 960 960">
                        <path d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z"/>
                    </svg>
                </a>

                {{-- Botón Eliminar --}}
                <form action="{{ route('reviews.destroy', [$review->product->id, $review->id]) }}"
                      method="POST" 
                      class="inline-flex" 
                      onsubmit="return confirm('¿Estás seguro de eliminar esta reseña?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="p-2.5 bg-red-50 dark:bg-red-950/40 border border-red-200 dark:border-red-800/50 text-red-600 dark:text-red-400 rounded-lg active:bg-red-100 dark:active:bg-red-900/60 transition-colors"
                            aria-label="Eliminar reseña">
                        <svg class="w-4 h-4 fill-current" viewBox="0 -960 960 960">
                            <path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/>
                        </svg>
                    </button>
                </form>
            </div>
        @endif
    </div>
</div>