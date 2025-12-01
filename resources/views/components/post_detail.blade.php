<x-layout title="Post Detalle">

    <div class="bg-white p-4 rounded-xl border border-gray-300 shadow mb-4">
        <div class="flex items-start space-x-3">
            <div class="w-12 h-12 rounded-full overflow-hidden bg-gray-300">
                <img src="{{ $post->user->profile_photo_url ?? asset('images/default-avatar.png') }}"
                    alt="{{ $post->user->name }}" class="w-full h-full object-cover">
            </div>

            <div class="flex-1">
                <div class="flex justify-between items-center">
                    <h3 class="font-semibold text-[var(--kalm-dark)]">{{ $post->user->name }}</h3>
                    <span class="text-xs text-gray-400">{{ $post->created_at->diffForHumans() }}</span>
                </div>

                <p class="mt-2 text-gray-700">{{ $post->content }}</p>

                @if($post->image)
                    <img src="{{ asset('storage/' . $post->image) }}" alt="Imagen del post"
                        class="mt-2 rounded-lg w-full object-cover">
                @endif

                <div class="flex items-center mt-4 space-x-4 text-gray-500">

                    <!-- Like / Heart -->
                    <div class="flex items-center space-x-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path
                                d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" />
                        </svg>
                        <span>{{ $post->likes_count }}</span>
                    </div>

                    <!-- Save / Bookmark -->
                    <div class="flex items-center space-x-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M5 3a2 2 0 00-2 2v14l7-5 7 5V5a2 2 0 00-2-2H5z" />
                        </svg>
                        <span>{{ $post->saves_count }}</span>
                    </div>

                    <!-- Comment / Chat Bubble -->
                    <div class="flex items-center space-x-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path
                                d="M18 10c0 3.866-3.582 7-8 7a8.735 8.735 0 01-4.916-1.44L2 17l1.44-3.084A7.966 7.966 0 012 10c0-3.866 3.582-7 8-7s8 3.134 8 7z" />
                        </svg>
                        <span>{{ $post->comments_count }}</span>
                    </div>

                </div>

            </div>
        </div>
    </div>

    {{-- Comentarios --}}
    <div class="mt-6">
        <h4 class="font-semibold mb-2">Comentarios</h4>
        @forelse($post->comments as $comment)
            <div class="flex items-start space-x-3 mb-3">
                <div class="w-8 h-8 rounded-full overflow-hidden bg-gray-300">
                    <img src="{{ $comment->user->profile_photo_url ?? asset('images/default-avatar.png') }}"
                        alt="{{ $comment->user->name }}" class="w-full h-full object-cover">
                </div>
                <div>
                    <p class="font-semibold text-[var(--kalm-dark)]">{{ $comment->user->name }}</p>
                    <p class="text-gray-700">{{ $comment->content }}</p>
                    <span class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                </div>
            </div>
        @empty
            <p class="text-gray-500">No hay comentarios aún.</p>
        @endforelse
    </div>
</x-layout>
