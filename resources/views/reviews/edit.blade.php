<x-layout :title="'Editar reseña de ' . $product->name">
    <div class="max-w-3xl p-6 mx-auto mt-6 bg-white dark:bg-[#2A4043] shadow-md rounded-3xl">

        <h1 class="text-2xl font-bold text-[#164d4f] dark:text-[#CCE2E5] mb-4">Editar reseña</h1>

        <!-- Información del producto -->
        <x-product-card-hor :product="$product"/>

        @if(auth()->user() && auth()->user()->isPremium())
            <form action="{{ route('reviews.update', $userReview) }}" method="POST" class="space-y-4">
                @csrf
                @method('PATCH')

                <!-- Calificación con DaisyUI Mask Star -->
                <div>
                    <p class="text-[#164d4f] dark:text-[#CCE2E5]">Calificación</p>
                    <div class="flex flex-row justify-center gap-2 mt-2 rating">
                        @for($i = 1; $i <= 5; $i++)
                            <input type="radio" name="rating" value="{{ $i }}"
                                   class="w-12 h-12 bg-yellow-400 mask mask-star"
                                   {{ ($userReview->rating == $i || old('rating') == $i) ? 'checked' : '' }} />
                        @endfor
                    </div>
                    @error('rating') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                </div>

                <!-- Comentario -->
                <div>
                    <p class="text-[#164d4f] dark:text-[#CCE2E5] mb-2">Reseña</p>
                    <textarea name="comment" id="comment" rows="5"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#37A0AF] resize-none">{{ old('comment', $userReview->comment) }}</textarea>
                    @error('comment') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                </div>

                    <button type="submit" class="border-none mt-1 btn w-full inline-flex border-2 bg-[#306067] text-white px-6 py-3 rounded-xl font-semiboldbold transition-all duration-300 items-center justify-center gap-2 text-sm font-bold">
                        Actualizar reseña
                    </button>
                    <a href="{{ route('reviews.show', $product) }}" class=" btn w-full inline-flex border-2 border-[#306067] text-[#306067] dark:border-[#CCE2E5] dark:text-[#CCE2E5] bg-transparent px-6 py-3 rounded-xl font-semiboldbold transition-all duration-300 items-center justify-center gap-2 text-sm font-bold">
                        Cancelar
                    </a>
            </form>
        @else
            <div class="p-6 border border-yellow-200 rounded-lg bg-yellow-50">
                <p class="mb-2 font-semibold text-gray-700">🔒 Acceso exclusivo Kälm Premium</p>
                <p class="mb-4 text-gray-600">Para editar reseñas y compartir tu experiencia, necesitas ser usuario Kälm Premium.</p>
                <a href="{{ route('premium') }}" class="bg-[#FFDE21] hover:bg-[#E6C917] text-[#164d4f] px-6 py-2 rounded-lg font-bold transition">
                    Hazte Premium
                </a>
            </div>
        @endif
    </div>
</x-layout>
