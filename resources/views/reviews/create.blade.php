<x-layout :title="'Reseña de ' . $product->name">
    <div class="max-w-3xl p-6 mx-auto mt-6 bg-white shadow-md rounded-3xl">
        <h1 class="text-2xl font-bold text-[#164d4f] mb-4">Crear reseña para {{ $product->name }}</h1>

        @if(auth()->user()->isPremium())
            @if(!$userReview)
                <form action="{{ route('reviews.store', $product) }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="rating" class="block font-semibold text-gray-700">Calificación</label>
                        <select name="rating" id="rating" required
                            class="w-full mt-1 border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#37A0AF]">
                            <option value="">Selecciona una calificación</option>
                            @for($i=1; $i<=5; $i++)
                                <option value="{{ $i }}">{{ $i }} estrella{{ $i > 1 ? 's' : '' }}</option>
                            @endfor
                        </select>
                        @error('rating') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="comment" class="block font-semibold text-gray-700">Reseña</label>
                        <textarea name="comment" id="comment" rows="4" required
                            class="w-full mt-1 border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#37A0AF]">{{ old('comment') }}</textarea>
                        @error('comment') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit"
                        class="bg-[#306067] text-white px-5 py-2 rounded-lg font-bold hover:bg-[#164d4f]">
                        Enviar reseña
                    </button>
                </form>
            @else
                <p class="font-semibold text-green-600">Ya has creado tu reseña para este producto.</p>
            @endif
        @else
            <p class="mb-4 text-gray-700">Para crear reseñas debes ser usuario Kälm Premium.</p>
            <button onclick="document.getElementById('premium-modal').classList.remove('hidden')"
                class="bg-[#FFDE21] text-[#164d4f] px-5 py-2 rounded-lg font-bold hover:bg-[#E6C917]">
                Hazte Premium
            </button>

            {{-- Modal simple --}}
            <div id="premium-modal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
                <div class="relative p-6 bg-white rounded-2xl w-96">
                    <button onclick="document.getElementById('premium-modal').classList.add('hidden')"
                        class="absolute font-bold text-gray-500 top-3 right-3 hover:text-gray-800">&times;</button>
                    <h2 class="mb-4 text-xl font-bold">Kälm Premium</h2>
                    <p class="mb-4">Conviértete en usuario Premium para crear reseñas y disfrutar de beneficios exclusivos.</p>
                    <a href="{{ route('premium.upgrade') }}"
                        class="block text-center bg-[#306067] text-white px-4 py-2 rounded-lg font-bold hover:bg-[#164d4f]">
                        Hacerse Premium
                    </a>
                </div>
            </div>
        @endif
    </div>
</x-layout>
