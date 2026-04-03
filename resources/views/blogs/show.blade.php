<x-layout :title="$blog->title . ' - Blog'">
    <div class="container my-5 pb-10 px-5 bg-white rounded-t-3xl min-h-full pt-5">
        <div class="flex gap-2 flex-wrap justify-between items-center mb-4">
            <a href="{{ route('blog.index') }}" class="bg-transparent border-transparent shadow-none">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#2A4043"><path d="m142-480 294 294q15 15 14.5 35T435-116q-15 15-35 15t-35-15L57-423q-12-12-18-27t-6-30q0-15 6-30t18-27l308-308q15-15 35.5-14.5T436-844q15 15 15 35t-15 35L142-480Z"/></svg>
            </a>

            <div class="flex gap-3">
                @auth
                    {{-- icono de bookmark --}}
                    <div class="flex justify-end">
                            <label class="cursor-pointer swap" onclick="event.stopPropagation()">
                                <input type="checkbox" data-id="{{ $blog->id }}" class="like-toggle" />
                                <svg class="swap-off fill-[#facc15]" xmlns="http://www.w3.org/2000/svg" height="37px"
                                    viewBox="0 -960 960 960" width="37px">
                                    <path d="m480-240-168 72q-40 17-76-6.5T200-241v-519q0-33 23.5-56.5T280-840h400q33 0 56.5 23.5T760-760v519q0 43-36 66.5t-76 6.5l-168-72Zm0-88 200 86v-518H280v518l200-86Zm0-432H280h400-200Z" />
                                </svg>
                                <svg class="swap-on fill-[#facc15]" xmlns="http://www.w3.org/2000/svg" height="37px"
                                    viewBox="0 -960 960 960" width="37px">
                                    <path d="m480-240-168 72q-40 17-76-6.5T200-241v-519q0-33 23.5-56.5T280-840h400q33 0 56.5 23.5T760-760v519q0 43-36 66.5t-76 6.5l-168-72Z" />
                                </svg>
                            </label>
                    </div>
                @endauth
            </div>
        </div>

        <h1 class="text-3xl font-bold text-[#306067]">{{ $blog->title }}</h1>

        {{-- Imagen principal / placeholder --}}
        <div class="mb-4 d-flex justify-content-center">
            @if($blog->image)
                <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}" class="img-fluid rounded-xl" style="max-width: 100%; max-height: 480px; object-fit: cover;">
            @else
                <div class="border border-[#CCE2E5] rounded bg-light d-flex align-items-center text-center justify-content-center w-full py-4">
                    <p class="text-center text-[#CCE2E5]">Sin imagen disponible</p>
                </div>
            @endif
        </div>

        @if(!empty($blog->type))
            <a href="{{ route('blog.search', ['q' => '', 'type_id' => $blog->type->id]) }}" class="text-sm inline-block text-white truncate bg-[#37A0AF] px-3 py-1 rounded-2xl">
                ✨{{ $blog->type->name }}
            </a>
        @endif

        @if(!empty($blog->tags))
            @foreach($blog->tags as $tag)
                <a href="{{ route('blog.search', ['q' => '', 'tag_id' => $tag->id]) }}"
                    class="text-sm inline-block text-white truncate bg-[#37A0AF] px-3 py-1 rounded-2xl">
                    {{ $tag->name }}
                </a>
            @endforeach
        @endif

        <p class="mb-4 flex justify-between items-center">
            {{ $blog->author ?? 'Anónimo' }}
            @if($blog->created_at)
                <small class="text-[#37A0AF]">{{ $blog->created_at->format('d/m/Y') }}</small>
            @endif
        </p>

        <p class="font-bold">{{ $blog->description }}</p>

        <div class="mb-4 fs-5" style="white-space:pre-wrap; line-height:1.6;">
            {!! nl2br(e($blog->content)) !!}
        </div>

        <x-author-card-hor :blog="$blog" />
    </div>
</x-layout>
