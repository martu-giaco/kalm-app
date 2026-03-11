<x-layout :title="'Reseña de ' . $product->name">
    <div class="max-w-3xl p-6 mx-auto mt-6 bg-white shadow-md rounded-3xl">
        <h1 class="text-2xl font-bold text-[#164d4f] mb-4">Crear reseña para {{ $product->name }}</h1>

        <!-- Información del producto -->
        <div class="flex gap-4 p-4 mb-6 bg-gray-50 rounded-lg border border-gray-200">
            <img src="{{ $product->image_url }}" 
                 alt="{{ $product->name }}" 
                 class="w-20 h-20 object-cover rounded-lg">
            <div>
                <p class="font-semibold text-gray-800 text-lg">{{ $product->name }}</p>
                <p class="text-sm text-gray-600">{{ $product->brand->name ?? 'Sin marca' }}</p>
                <p class="text-xs text-gray-500 mt-1">{{ Str::limit($product->description, 100) }}</p>
            </div>
        </div>

        @if(auth()->user() && auth()->user()->isPremium())
            @if(!$userReview)
                <form action="{{ route('reviews.store', $product) }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <div>
                        <label for="rating" class="block font-semibold text-gray-700 mb-2">Calificación</label>
                        <select name="rating" id="rating" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#37A0AF]">
                            <option value="">Selecciona una calificación</option>
                            @for($i=1; $i<=5; $i++)
                                <option value="{{ $i }}">{{ $i }} estrella{{ $i > 1 ? 's' : '' }}</option>
                            @endfor
                        </select>
                        @error('rating') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="comment" class="block font-semibold text-gray-700 mb-2">Tu reseña</label>
                        <textarea name="comment" id="comment" rows="5" required 
                            placeholder="Cuéntanos tu experiencia con este producto..."
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#37A0AF] resize-none">{{ old('comment') }}</textarea>
                        @error('comment') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit"
                        class="bg-[#306067] hover:bg-[#164d4f] text-white px-6 py-2 rounded-lg font-bold transition w-full">
                        Enviar reseña
                    </button>
                </form>
            @else
                <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                    <p class="font-semibold text-green-700 flex items-center gap-2">
                        <span class="text-2xl">✓</span>
                        Ya has creado tu reseña para este producto
                    </p>
                    <p class="text-sm text-green-600 mt-2">Calificación: {{ $userReview->rating }}/5</p>
                    <a href="{{ route('reviews.edit', $userReview) }}" 
                       class="mt-3 inline-block text-blue-600 hover:text-blue-800 font-semibold">
                        Editar tu reseña →
                    </a>
                </div>
            @endif
        @else
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
                <p class="font-semibold text-gray-700 mb-2">🔒 Acceso exclusivo Kälm Premium</p>
                <p class="text-gray-600 mb-4">Para crear reseñas y compartir tu experiencia, necesitas ser usuario Kälm Premium.</p>
                <button onclick="document.getElementById('premium-modal').classList.remove('hidden')"
                    class="bg-[#FFDE21] hover:bg-[#E6C917] text-[#164d4f] px-6 py-2 rounded-lg font-bold transition">
                    Hazte Premium
                </button>

                <!-- Modal Premium -->
                <div id="premium-modal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
                    <div class="relative p-8 bg-white rounded-2xl w-96 shadow-lg">
                        <button onclick="document.getElementById('premium-modal').classList.add('hidden')"
                            class="absolute font-bold text-gray-400 top-4 right-4 hover:text-gray-600 text-2xl">&times;</button>
                        
                        <h2 class="text-2xl font-bold text-[#164d4f] mb-2">Kälm Premium</h2>
                        <p class="text-gray-600 mb-4">Acceso a:</p>
                        <ul class="space-y-2 text-gray-700 mb-6 text-sm">
                            <li class="flex items-center gap-2">
                                <span class="text-green-500">✓</span> Crear y compartir reseñas
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="text-green-500">✓</span> Recomendaciones personalizadas
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="text-green-500">✓</span> Rutinas exclusivas
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="text-green-500">✓</span> Acceso prioritario a nuevos productos
                            </li>
                        </ul>
                        <a href="{{ route('premium') }}"
                            class="block text-center bg-[#306067] hover:bg-[#164d4f] text-white px-6 py-2 rounded-lg font-bold transition">
                            Hacerse Premium
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-layout>
