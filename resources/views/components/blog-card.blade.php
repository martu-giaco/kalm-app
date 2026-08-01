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
                    class="relative flex-shrink-0 overflow-hidden transition-transform transform bg-white dark:bg-[#306067] shadow-lg w-60 min-h-96 rounded-2xl hover:shadow-2xl">
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
                    @if ($blog->image)
                        @php
                            $img = $blog->image;
                            if ($img && (str_starts_with($img, 'http://') || str_starts_with($img, 'https://'))) {
                                $imgUrl = $img;
                            } elseif ($img && str_starts_with($img, 'images/')) {
                                $imgUrl = asset($img);
                            } else {
                                $imgUrl = asset('storage/' . $img);
                            }
                        @endphp
                        <div class="w-full h-48 overflow-hidden">
                            <img src="{{ $imgUrl }}" alt="{{ $blog->title }}"
                                class="object-cover w-full h-full">
                        </div>
                    @endif
                    {{-- Info --}}
                    <div class="flex flex-col p-4">
                        <h3 class="text-xl text-[#306067] dark:text-[#CCE2E5] mb-1">
                            {{ $blog->title }}
                        </h3>

                        @if(!empty($blog->type))
                            <p class="text-[10px] mt-1 text-center w-20 truncate inline-block text-white bg-[#37A0AF] dark:bg-[#CCE2E5] dark:text-[#37A0AF] px-2 py-1 rounded-xl">
                                ✨{{ $blog->type->name }}
                            </p>
                        @endif

                        {{-- Contenedor de la descripción con el candado superpuesto --}}
                        <div class="relative mt-2">
                            <p class="text-sm text-[#306067] dark:text-[#CCE2E5] line-clamp-3 {{ ($blog->canView ?? true) ? '' : 'blur-sm' }}">
                                {{ $blog->description }}
                            </p>

                            @if(auth()->user()?->role === 'free' && $blog->is_premium === true)
                                <div class="absolute inset-0 flex items-center justify-center z-10">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="drop-shadow-lg transition-transform transform hover:scale-110 fill-[#306067] dark:fill-[#CCE2E5]" height="32px" viewBox="0 -960 960 960" width="32px">
                                        <path d="M246.78-62.48q-43.72 0-74.86-31.14-31.14-31.13-31.14-74.86v-386.43q0-43.73 31.14-74.87 31.14-31.13 74.86-31.13h24.74v-63.61q0-87.52 60.76-148.85T480-934.7q86.96 0 147.72 61.33 60.76 61.33 60.76 148.85v63.61h24.74q43.72 0 74.86 31.13 31.14 31.14 31.14 74.87v386.43q0 43.73-31.14 74.86-31.14 31.14-74.86 31.14H246.78ZM536.5-305.2q23.5-23.5 23.5-56.5t-23.5-56.5Q513-441.7 480-441.7t-56.5 23.5Q400-394.7 400-361.7t23.5 56.5q23.5 23.5 56.5 23.5t56.5-23.5ZM377.52-660.91h204.96v-63.61q0-43.41-29.63-73.79Q523.22-828.7 480-828.7t-72.85 30.39q-29.63 30.38-29.63 73.79v63.61Z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                    </div>
</a>
