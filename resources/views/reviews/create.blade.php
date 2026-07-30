<x-layout :title="'Crear reseña de ' . $product->name">
    <div class="max-w-3xl p-6 mx-auto mt-6 bg-white dark:bg-[#2A4043] shadow-md rounded-t-3xl">

        <h1 class="text-2xl font-bold text-[#164d4f] dark:text-[#CCE2E5] mb-4">Crear Reseña</h1>

        <!-- Información del producto -->
        <x-product-card-hor :product="$product"/>

        @if (auth()->user() && auth()->user()->isPremium())
            <form action="{{ route('reviews.store', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <!-- Calificación -->
<div>
    <p class="text-[#164d4f] dark:text-[#CCE2E5] font-medium mb-1">
        Calificación
    </p>

    <div class="flex flex-row-reverse justify-center gap-2 mt-2 rating-stars">

        <!-- Sin calificación -->
        <input
            type="radio"
            name="rating"
            value="0"
            class="hidden"
            {{ old('rating') ? '' : 'checked' }}
        />

        @for ($i = 1; $i <= 5; $i++)
            <label class="cursor-pointer">
                <input
                    type="radio"
                    name="rating"
                    value="{{ $i }}"
                    class="hidden"
                    {{ old('rating') == $i ? 'checked' : '' }}
                />

                <span class="star mask mask-star-2 block w-10 h-10 bg-yellow-400/30 transition-colors duration-200"></span>
            </label>
        @endfor

    </div>

    @error('rating')
        <p class="mt-1 text-xs text-center text-red-500">
            {{ $message }}
        </p>
    @enderror
</div>

<style>
    /*
     * Estrella seleccionada
     */
    .rating-stars label:has(input:checked) .star {
        background-color: #facc15;
    }

    /*
     * Rellena todas las estrellas anteriores
     * gracias al orden inverso del contenedor.
     */
    .rating-stars label:has(input:checked) ~ label .star {
        background-color: #facc15;
    }
</style>

                <!-- Comentario -->
                <div>
                    <p class="text-[#164d4f] dark:text-[#CCE2E5] mb-2 font-medium">Reseña</p>
                    <textarea name="comment" id="comment" rows="4" placeholder="Tu experiencia con este producto..."
                        class="w-full border border-gray-300 dark:border-gray-600 bg-transparent text-[#2A4043] dark:text-[#E9E5E3] rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#37A0AF] resize-none">{{ old('comment') }}</textarea>
                    @error('comment')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Subir imagen de reseña -->
                <div>
                    <label for="image" class="block text-[#164d4f] dark:text-[#CCE2E5] mb-2 font-medium">
                        Añadir foto (Opcional)
                    </label>
                    <input type="file" name="image" id="image" accept="image/*"
                        class="w-full text-sm text-[#2A4043] dark:text-[#CCE2E5] file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-[#306067] file:text-white hover:file:bg-[#254b51] cursor-pointer" />
                    @error('image')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                    class="border-none mt-2 btn w-full inline-flex bg-[#306067] hover:bg-[#254b51] text-white px-6 py-3 rounded-xl font-bold transition-all duration-300 items-center justify-center gap-2 text-sm">
                    Publicar Reseña
                </button>
                <a href="{{ route('products.show', $product->id) }}"
                    class="btn w-full inline-flex border-2 border-[#306067] text-[#306067] dark:border-[#CCE2E5] dark:text-[#CCE2E5] bg-transparent px-6 py-3 rounded-xl font-bold transition-all duration-300 items-center justify-center gap-2 text-sm">
                    Cancelar
                </a>
            </form>
        @else
            <div class="p-6 border border-yellow-200 rounded-lg bg-yellow-50">
                <p class="mb-2 font-semibold text-gray-700">🔒 Acceso exclusivo Kälm Premium</p>
                <p class="mb-4 text-gray-600">Para crear reseñas y compartir tu experiencia, necesitas ser usuario Kälm Premium.</p>
                <a href="{{ route('premium') }}"
                    class="bg-[#FFDE21] hover:bg-[#E6C917] text-[#164d4f] px-6 py-2 rounded-lg font-bold transition">
                    Hazte Premium
                </a>
            </div>
        @endif
    </div>
</x-layout>