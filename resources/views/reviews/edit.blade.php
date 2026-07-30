<x-layout :title="'Editar reseña de ' . $product->name">
    <div class="max-w-3xl p-6 mx-auto mt-6 bg-white dark:bg-[#2A4043] shadow-md rounded-3xl">

        <h1 class="text-2xl font-bold text-[#164d4f] dark:text-[#CCE2E5] mb-4">Editar Reseña</h1>

        <!-- Información del producto -->
        <x-product-card-hor :product="$product"/>

        @auth
            <form action="{{ route('reviews.update', $userReview) }}" method="POST" enctype="multipart/form-data" class="space-y-4 mt-4">
                @csrf
                @method('PATCH')

                <!-- Calificación con DaisyUI Mask Star -->
                <div>
                    <p class="text-[#164d4f] dark:text-[#CCE2E5] font-medium">Calificación</p>
                    <div class="flex flex-row justify-center gap-2 mt-2 rating">
                        @for($i = 1; $i <= 5; $i++)
                            <input type="radio" name="rating" value="{{ $i }}"
                                   class="w-12 h-12 bg-yellow-400 mask mask-star"
                                   {{ ($userReview->rating == $i || old('rating') == $i) ? 'checked' : '' }} />
                        @endfor
                    </div>
                    @error('rating') <span class="text-sm text-red-500 block mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Comentario -->
                <div>
                    <p class="text-[#164d4f] dark:text-[#CCE2E5] mb-2 font-medium">Reseña</p>
                    <textarea name="comment" id="comment" rows="5"
                        class="w-full border border-gray-300 dark:border-gray-600 dark:bg-[#203235] dark:text-white rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#37A0AF] resize-none">{{ old('comment', $userReview->comment) }}</textarea>
                    @error('comment') <span class="text-sm text-red-500 block mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Imagen (Exclusivo Premium) -->
                @if (auth()->user()->isPremium())
                    <div>
                        <label for="image" class="block text-[#164d4f] dark:text-[#CCE2E5] mb-2 font-medium">
                            Imagen de la reseña
                        </label>

                        @if ($userReview->image)
                            <div class="mb-3">
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Imagen actual:</p>
                                <img src="{{ asset(ltrim($userReview->image, '/')) }}" 
                                     alt="Imagen actual de la reseña" 
                                     class="w-28 h-28 object-cover rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
                            </div>
                        @endif

                        <input type="file" name="image" id="image" accept="image/*"
                            class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-[#306067] file:text-white hover:file:bg-[#254b50] cursor-pointer">
                        @error('image') <span class="text-sm text-red-500 block mt-1">{{ $message }}</span> @enderror
                    </div>
                @else
                    <div class="p-4 border border-yellow-200 rounded-lg bg-yellow-50 flex items-center justify-between">
                        <p class="text-sm text-gray-700">
                            <strong>¿Modificar o agregar imágenes?</strong> Hazte Premium para habilitar esta función.
                        </p>
                        <a href="{{ route('premium') }}" class="text-xs bg-[#FFDE21] hover:bg-[#E6C917] text-[#164d4f] px-3 py-1.5 rounded-lg font-bold transition">
                            Hazte Premium
                        </a>
                    </div>
                @endif

                <div class="flex flex-col gap-2 pt-2">
                    <button type="submit" class="border-none btn w-full inline-flex bg-[#306067] text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 items-center justify-center gap-2 text-sm font-bold hover:bg-[#254b50]">
                        Actualizar Reseña
                    </button>
                    <a href="{{ route('reviews.show', $product) }}" class="btn w-full inline-flex border-2 border-[#306067] text-[#306067] dark:border-[#CCE2E5] dark:text-[#CCE2E5] bg-transparent px-6 py-3 rounded-xl font-semibold transition-all duration-300 items-center justify-center gap-2 text-sm font-bold hover:bg-gray-100 dark:hover:bg-[#203235]">
                        Cancelar
                    </a>
                </div>
            </form>
        @else
            <div class="p-6 border border-gray-200 rounded-lg bg-gray-50 text-center mt-4">
                <p class="mb-4 text-gray-600">Debes iniciar sesión para realizar esta acción.</p>
                <a href="{{ route('login') }}" class="bg-[#306067] text-white px-6 py-2 rounded-lg font-bold">
                    Iniciar sesión
                </a>
            </div>
        @endauth

    </div>
</x-layout>