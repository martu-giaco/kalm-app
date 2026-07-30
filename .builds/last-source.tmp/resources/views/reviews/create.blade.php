<x-layout :title="'Crear reseña de ' . $product->name">
    <div class="max-w-3xl p-6 mx-auto mt-6 bg-white shadow-md rounded-3xl">

        <h1 class="text-2xl font-bold text-[#164d4f] mb-4">Crear reseña para {{ $product->name }}</h1>

        <!-- Información del producto -->
        <div class="flex gap-4 p-4 mb-6 border border-gray-200 rounded-lg bg-gray-50">
            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="object-cover w-20 h-20 rounded-lg">
            <div>
                <p class="text-lg font-semibold text-gray-800">{{ $product->name }}</p>
                <p class="text-sm text-gray-600">{{ $product->brand->name ?? 'Sin marca' }}</p>
                <p class="mt-1 text-xs text-gray-500">{{ Str::limit($product->description, 100) }}</p>
            </div>
        </div>

        @if (auth()->user() && auth()->user()->isPremium())
            <form action="{{ route('reviews.store', $product) }}" method="POST" class="space-y-4">
                @csrf

                <!-- Calificación con DaisyUI Mask Star -->
                <div>
                    <label class="block mb-2 font-semibold text-gray-700">Calificación</label>
                    <div class="flex flex-row-reverse justify-center gap-2 mt-2 rating">
                        @for ($i = 5; $i >= 1; $i--)
                            <input type="radio" name="rating" value="{{ $i }}"
                                class="w-12 h-12 bg-gray-300 mask mask-star-2 checked:bg-yellow-400"
                                {{ old('rating') == $i ? 'checked' : '' }} />
                        @endfor
                    </div>
                    @error('rating')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Comentario -->
                <div>
                    <label for="comment" class="block mb-2 font-semibold text-gray-700">Tu reseña</label>
                    <textarea name="comment" id="comment" rows="5" placeholder="Cuéntanos tu experiencia con este producto..."
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#37A0AF] resize-none">{{ old('comment') }}</textarea>
                    @error('comment')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit"
                    class="bg-[#306067] hover:bg-[#164d4f] text-white px-6 py-2 rounded-lg font-bold transition w-full">
                    Enviar reseña
                </button>
            </form>
        @else
            <div class="p-6 border border-yellow-200 rounded-lg bg-yellow-50">
                <p class="mb-2 font-semibold text-gray-700">🔒 Acceso exclusivo Kälm Premium</p>
                <p class="mb-4 text-gray-600">Para crear reseñas y compartir tu experiencia, necesitas ser usuario Kälm
                    Premium.</p>
                <a href="{{ route('premium') }}"
                    class="bg-[#FFDE21] hover:bg-[#E6C917] text-[#164d4f] px-6 py-2 rounded-lg font-bold transition">
                    Hazte Premium
                </a>
            </div>
        @endif
    </div>
</x-layout>
