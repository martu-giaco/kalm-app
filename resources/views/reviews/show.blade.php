<x-layout :title="'Reseñas de ' . $product->name">
    <div class="max-w-4xl mx-auto mt-6 px-5 pt-10 pb-20 bg-white rounded-t-3xl">
        <div class="flex items-center mb-4">
            <a href="{{ route('products.show', $product->id) }}" class="bg-transparent border-transparent shadow-none">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#2A4043"><path d="m142-480 294 294q15 15 14.5 35T435-116q-15 15-35 15t-35-15L57-423q-12-12-18-27t-6-30q0-15 6-30t18-27l308-308q15-15 35.5-14.5T436-844q15 15 15 35t-15 35L142-480Z"></path></svg>
            </a>
            <h1 class="text-2xl font-bold text-[#164d4f]">Reseñas de usuarios ({{ $reviews->count() }})</h1>
        </div>

            @if($reviews->count() > 0)
                <div class="space-y-4">
                    @foreach($reviews as $review)
                        @include('components.review', ['review' => $review])
                    @endforeach
                </div>
            @else
                <p class="py-8 text-center text-gray-500">
                    <span class="block mb-2 text-4xl">

                    </span>
                    Todavía no hay reseñas... ¡escribí la primera!
                </p>
            @endif
        </div>
</x-layout>
