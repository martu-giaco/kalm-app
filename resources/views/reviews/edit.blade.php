<x-layout :title="'Editar reseña de ' . $review->product->name">
    <div class="max-w-3xl p-6 mx-auto mt-6 bg-white shadow-md rounded-3xl">
        <h1 class="text-2xl font-bold text-[#164d4f] mb-4">Editar reseña de {{ $review->product->name }}</h1>

        <!-- Información del producto -->
        <div class="flex gap-4 p-4 mb-6 bg-gray-50 rounded-lg border border-gray-200">
            <img src="{{ $review->product->image_url }}" 
                 alt="{{ $review->product->name }}" 
                 class="w-16 h-16 object-cover rounded-lg">
            <div>
                <p class="font-semibold text-gray-800">{{ $review->product->name }}</p>
                <p class="text-sm text-gray-600">{{ $review->product->brand->name ?? 'Sin marca' }}</p>
            </div>
        </div>

        <!-- Formulario -->
        <form action="{{ route('reviews.update', $review) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="rating" class="block font-semibold text-gray-700 mb-2">Calificación</label>
                <select name="rating" id="rating" required
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#37A0AF]">
                    <option value="">Selecciona una calificación</option>
                    @for($i=1; $i<=5; $i++)
                        <option value="{{ $i }}" {{ $review->rating == $i ? 'selected' : '' }}>
                            {{ $i }} estrella{{ $i > 1 ? 's' : '' }}
                        </option>
                    @endfor
                </select>
                @error('rating') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="comment" class="block font-semibold text-gray-700 mb-2">Reseña</label>
                <textarea name="comment" id="comment" rows="5" required
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#37A0AF] resize-none">{{ old('comment', $review->comment) }}</textarea>
                @error('comment') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="flex gap-3 pt-4">
                <button type="submit"
                    class="bg-[#306067] hover:bg-[#164d4f] text-white px-6 py-2 rounded-lg font-bold transition">
                    Guardar cambios
                </button>
                <a href="{{ route('reviews.show', $review->product) }}"
                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-2 rounded-lg font-bold transition">
                    Cancelar
                </a>
            </div>
        </form>

        <!-- Botón eliminar -->
        <div class="mt-8 pt-6 border-t border-gray-200">
            <p class="text-sm text-gray-600 mb-2">¿Deseas eliminar esta reseña?</p>
            <form action="{{ route('reviews.destroy', $review) }}" method="POST" class="inline" 
                  onsubmit="return confirm('¿Estás seguro? Esta acción no se puede deshacer.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg font-semibold">
                    Eliminar reseña
                </button>
            </form>
        </div>
    </div>
</x-layout>
