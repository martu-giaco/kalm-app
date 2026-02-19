<x-layout>
    <section class="min-h-screen px-5 py-10 bg-white rounded-t-3xl">

        <h1 class="mb-6 text-2xl font-semibold text-[#306067]">Sección de Blogs Kälm</h1>

        {{-- ================= FREE ================= --}}
        <h2 class="flex items-center gap-2 mb-4 text-xl text-[#306067]">
            Blog Free
        </h2>

        <div class="flex gap-5 pb-5 overflow-x-auto scroll-smooth scrollbar-hide">
            @foreach ($blogs->where('is_premium', false) as $blog)
                <a href="{{ route('blog.show', $blog->id) }}"
                    class="flex-shrink-0 overflow-hidden transition-transform transform bg-white shadow-lg w-60 h-96 rounded-2xl hover:shadow-2xl">

                    {{-- Imagen --}}
                    @if ($blog->image)
                        <div class="w-full h-48 overflow-hidden">
                            <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}"
                                class="object-cover w-full h-full">
                        </div>
                    @endif

                    {{-- Info --}}
                    <div class="flex flex-col justify-between h-48 p-4">
                        <div>
                            <h3 class="text-xl text-[#306067] mb-1">{{ $blog->title }}</h3>
                            <p class="text-sm text-gray-500">
                                {{ $blog->author }} @if ($blog->credentials)
                                    - {{ $blog->credentials }}
                                @endif
                            </p>
                        </div>

                        <div class="mt-2 text-sm text-gray-700">
                            {{ Str::limit($blog->content, 120) }}
                        </div>

                        <div class="flex justify-end mt-2">
                            <label class="cursor-pointer swap" onclick="event.stopPropagation()">
                                <input type="checkbox" data-id="{{ $blog->id }}" class="like-toggle" />
                                <svg class="swap-on fill-[#FFDE21]" xmlns="http://www.w3.org/2000/svg" height="24"
                                    viewBox="0 -960 960 960" width="24">
                                    <path d="..." />
                                </svg>
                                <svg class="swap-off fill-[#FFDE21]" xmlns="http://www.w3.org/2000/svg" height="24"
                                    viewBox="0 -960 960 960" width="24">
                                    <path d="..." />
                                </svg>
                            </label>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        {{-- ================= PREMIUM ================= --}}
        <h2
            class="inline-flex items-center gap-2 mb-4 mt-10 px-6 py-3 text-xl font-semibold text-white bg-gradient-to-r from-[#1e9bb1] via-[#047488] to-[#1a91c0] rounded-full shadow-lg">
            Blog Premium
        </h2>

        @php
            $user = auth()->user();
            $isPremiumUser = $user && ($user->role === 'premium' || $user->role === 'admin');
        @endphp

        <div class="flex gap-5 pb-5 overflow-x-auto scroll-smooth scrollbar-hide">
            @foreach ($blogs->where('is_premium', true) as $blog)
                @if ($isPremiumUser)
                    <a href="{{ route('blog.show', $blog->id) }}"
                        class="relative flex flex-col flex-shrink-0 overflow-hidden transition-transform transform shadow-lg w-60 h-96 rounded-2xl hover:-translate-y-1 hover:shadow-2xl group">
                    @else
                        <a href="#" onclick="premium_modal.showModal()"
                            class="relative flex flex-col flex-shrink-0 overflow-hidden transition-transform transform shadow-lg w-60 h-96 rounded-2xl hover:-translate-y-1 hover:shadow-2xl group">
                @endif

                {{-- Imagen grande del blog --}}
                @if ($blog->image)
                    <div class="flex-shrink-0 w-full h-48 overflow-hidden">
                        <img src="{{ $blog->image }}" alt="{{ $blog->title }}"
                            class="object-contain w-full h-full transition-transform group-hover:scale-105">
                    </div>
                @endif

                {{-- Info y contenido --}}
                <div class="flex flex-col justify-between flex-1 p-4">
                    <div>
                        <h3 class="text-xl text-[#306067] mb-1">{{ $blog->title }}</h3>
                        <p class="text-sm text-gray-500">
                            {{ $blog->author }} @if ($blog->credentials)
                                - {{ $blog->credentials }}
                            @endif
                        </p>
                    </div>

                    {{-- Contenido blurreado solo si no puede ver --}}
                    <div
                        class="h-full mt-2 overflow-hidden text-sm text-gray-700 {{ $blog->canView ? '' : 'blur-sm' }}">
                        {{ Str::limit($blog->content, 180) }}
                    </div>

                    {{-- Botón Premium debajo del contenido --}}
                    @if (file_exists(public_path('images/plan-premium.png')))
                        <div class="absolute bottom-0 left-0 right-0 justify-center mt-2">
                            <img src="/images/plan-premium.png" alt="Premium"
                                class="px-4 py-2 font-bold transition rounded-full shadow-md cursor-pointer hover:scale-105">
                        </div>
                    @endif

                    {{-- Like button --}}
                    <div class="flex justify-end mt-2">
                        <label class="cursor-pointer swap" onclick="event.stopPropagation()">
                            <input type="checkbox" data-id="{{ $blog->id }}" class="like-toggle" />
                            <svg class="swap-on fill-[#FFDE21]" xmlns="http://www.w3.org/2000/svg" height="24"
                                viewBox="0 -960 960 960" width="24">
                                <path d="..." />
                            </svg>
                            <svg class="swap-off fill-[#FFDE21]" xmlns="http://www.w3.org/2000/svg" height="24"
                                viewBox="0 -960 960 960" width="24">
                                <path d="..." />
                            </svg>
                        </label>
                    </div>
                </div>

                {{-- Efecto brillante --}}
                <div class="absolute inset-0 pointer-events-none">
                    <div
                        class="w-full h-full transition-opacity duration-500 opacity-0 bg-gradient-to-r from-white/10 via-white/20 to-white/10 group-hover:opacity-100 animate-shine">
                    </div>
                </div>
                </a>
            @endforeach
        </div>

    </section>

    <script>
        document.querySelectorAll('.like-toggle').forEach(el => {
            el.addEventListener('change', function() {
                const blogId = this.dataset.id;
                fetch(`/blogs/${blogId}/like`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
            });
        });
    </script>

</x-layout>
