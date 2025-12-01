<a href="{{ route('posts.show', ['post' => $post->id]) }}" class="block hover:bg-gray-50 transition rounded-xl">
    <div class="bg-white p-4 rounded-xl shadow mb-4">
        <!-- Contenido del post -->
        <div class="flex items-start space-x-3">
            <div class="w-10 h-10 rounded-full overflow-hidden bg-gray-300">
                <img src="{{ $post->user->profile_photo_url ?? asset('images/default-avatar.png') }}"
                     alt="{{ $post->user->name }}" class="w-full h-full object-cover">
            </div>

            <div class="flex-1">
                <div class="flex justify-between items-center">
                    <h3 class="font-semibold text-[var(--kalm-dark)]">{{ $post->user->name }}</h3>
                    <span class="text-xs text-gray-400">{{ $post->created_at->diffForHumans() }}</span>
                </div>

                <p class="mt-1 text-gray-700">{{ $post->content }}</p>

                @if($post->image)
                    <img src="{{ asset('storage/' . $post->image) }}" alt="Imagen del post"
                         class="mt-2 rounded-lg w-full object-cover">
                @endif
            </div>
        </div>
    </div>
</a>
