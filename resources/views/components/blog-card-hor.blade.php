@php
    $user = auth()->user();
    $isPremiumUser = $user && ($user->role === 'premium' || $user->role === 'admin');
@endphp
<a
    @if(auth()->user()?->role === 'free' && $blog->is_premium === true)
        href="#" onclick="premium_modal.showModal()"
    @else
        href="{{ route('blog.show', $blog->id) }}"
    @endif
                    class="relative flex-shrink-0 mb-4 flex overflow-hidden transition-transform transform bg-white shadow-lg w-full rounded-2xl hover:shadow-2xl">
                    <div>
                        {{-- icono de bookmark --}}
                        <div class="flex justify-end mt-2 absolute top-2 right-2 z-10">
                                <label class="cursor-pointer swap" onclick="event.stopPropagation()">
                                    <input type="checkbox" data-id="{{ $blog->id }}" class="like-toggle" {{ (auth()->user()?->bookmarked_blogs ?? []) && in_array($blog->id, array_map('intval', auth()->user()->bookmarked_blogs ?? [])) ? 'checked' : '' }} />
                                    <svg class="swap-off fill-[#facc15]" xmlns="http://www.w3.org/2000/svg" height="30px"
                                        viewBox="0 -960 960 960" width="30px">
                                        <path d="m480-240-168 72q-40 17-76-6.5T200-241v-519q0-33 23.5-56.5T280-840h400q33 0 56.5 23.5T760-760v519q0 43-36 66.5t-76 6.5l-168-72Zm0-88 200 86v-518H280v518l200-86Zm0-432H280h400-200Z" />
                                    </svg>
                                    <svg class="swap-on fill-[#facc15]" xmlns="http://www.w3.org/2000/svg" height="30px"
                                        viewBox="0 -960 960 960" width="30px">
                                        <path d="m480-240-168 72q-40 17-76-6.5T200-241v-519q0-33 23.5-56.5T280-840h400q33 0 56.5 23.5T760-760v519q0 43-36 66.5t-76 6.5l-168-72Z" />
                                    </svg>
                                </label>
                        </div>
                        {{-- Imagen --}}
                        @php
                            $img = $blog->image ?? null;
                            if ($img && (str_starts_with($img, 'http://') || str_starts_with($img, 'https://'))) {
                                $imgUrl = $img;
                            } elseif ($img && str_starts_with($img, 'images/')) {
                                $imgUrl = asset($img);
                            } elseif ($img) {
                                $imgUrl = asset('storage/' . $img);
                            } else {
                                $imgUrl = asset('images/default.jpg');
                            }
                        @endphp
                        <div class="w-40 h-full overflow-hidden">
                            <img src="{{ $imgUrl }}" alt="{{ $blog->title }}"
                                class="object-cover w-full h-full">
                        </div>
                    </div>
                    {{-- Info --}}
                    <div class="flex flex-col p-4 relative">
                        <h3 class="text-xl text-[#306067] mb-1">
                            {{ $blog->title }}
                        </h3>

                        @if(!empty($blog->type))
                            <p class="text-[10px] mt-1 text-center w-20 truncate inline-block text-white bg-[#37A0AF] px-2 py-1 rounded-xl">
                                ✨{{ $blog->type->name }}
                            </p>
                        @endif

                        <p class="mt-2 text-sm text-gray-700 line-clamp-3 {{ ($blog->canView ?? true) ? '' : 'blur-sm' }}">
                            {{ $blog->description }}
                        </p>

                        {{-- Botón Premium debajo del contenido --}}
                        @if(auth()->user()?->role === 'free' && $blog->is_premium === true)
                            @if (file_exists(public_path('images/plan-premium.png')))
                                <div class="absolute bottom-3 left-0 right-0 justify-center mt-2">
                                    <img src="{{ asset('images/plan-premium.png') }}" alt="Premium"
                                        class="px-4 py-2 font-bold transition cursor-pointer hover:scale-105">
                                </div>
                            @endif
                        @endif
                    </div>
</a>
