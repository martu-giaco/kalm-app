{{-- resources/views/user/profile.blade.php --}}

<x-layout :title="'Mi perfil'">
    <div class="max-w-6xl mx-auto">
            {{-- Header: avatar + datos --}}
            <section class=" px-5 flex flex-col md:flex-row items-center md:items-start gap-3 md:gap-8 mb-5">
                <div class="w-full flex justify-between items-center">
                    <h1 class="text-3xl font-semibold text-[#306067] leading-tight">{{ $user->name ?? 'Invitado' }}</h1>
                    <span class="flex text-[#CCE2E5]">
                        ?
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#FFDE21"><path d="M480-269 314-169q-11 7-23 6t-21-8q-9-7-14-17.5t-2-23.5l44-189-147-127q-10-9-12.5-20.5T140-571q4-11 12-18t22-9l194-17 75-178q5-12 15.5-18t21.5-6q11 0 21.5 6t15.5 18l75 178 194 17q14 2 22 9t12 18q4 11 1.5 22.5T809-528L662-401l44 189q3 13-2 23.5T690-171q-9 7-21 8t-23-6L480-269Z"/></svg>
                    </span>
                </div>
                {{-- Avatar (circular, responsivo, recorte seguro) --}}
                <div class="flex items-center w-full justify-start">
                    <div
                        class="h-full w-full md:h-28 md:w-28 rounded-full me-6 overflow-hidden justify-center">
                        @if(isset($user) && $user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name ?? 'Avatar usuario' }}"
                                class="w-full h-full object-cover" loading="lazy" decoding="async" />
                        @else
                            <img src="{{ asset('images/pfp.svg') }}" alt="{{ $user->name ?? 'Avatar por defecto' }}"
                                class="w-full h-full object-contain" loading="lazy" decoding="async" />
                        @endif
                    </div>
                    <div>
                        {{--stats--}}
                        <div>
                            <div class="flex items-center gap-7">
                                <div class="flex flex-col items-center">
                                    <strong class="text-[#306067] text-2xl">{{ $user->posts_count ?? 0 }}</strong>
                                    <p class="text-xs">publicaciones</p>
                                </div>
                                <div class="flex flex-col items-center">
                                    <strong class="text-[#306067] text-2xl">{{ $user->following_count ?? 0 }}</strong>
                                    <p class="text-xs">Seguidos</p>
                                </div>
                                <div class="flex flex-col items-center">
                                    <strong class="text-[#306067] text-2xl">{{ $user->followers_count ?? 0 }}</strong>
                                    <p class="text-xs">Seguidores</p>
                                </div>
                            </div>
                        {{--user info--}}
                        <div>
                            <h2 class="text-2xl text-[#306067]">{{ $user->name ?? 'Invitado' }}</h2>
                            <p>{{ $user->bio ?? 'bio' }}</p>
                        </div>
                    </div>
                </div>
                </div>


                {{-- Acciones (mobile stacked debajo en md aparece a la derecha) --}}
                <div class="w-full flex justify-between mt-2 md:mt-0 md:shrink-0">
                    <div class="flex w-full gap-2">
                        <a href="{{ route('profile.edit') }}" class="text-sm text-center py-1 px-4 w-60 rounded-lg bg-[#37A0AF] text-white">Editar perfil</a>
                        <a href="{{ route('profile.edit') }}" class="text-sm text-center py-1 px-4 w-60 rounded-lg bg-[#37A0AF] text-white">Mis resultados</a>
                    </div>
                </div>
            </section>

            <section>
                {{-- tabs con posts, reviews y rutinas --}}
                <div class="tabs tabs-border">
    <input type="radio" name="my_tabs_2" id="tab-1" class="tab" aria-label="Posteos" checked />
                <div class="tab-content border-base-300 bg-base-100 p-10">
                    posteoooos
                </div>

                <input type="radio" name="my_tabs_2" class="tab" aria-label="Reviews" />
                <div class="tab-content border-base-300 bg-base-100 p-10">Tab content 2</div>

                <input type="radio" name="my_tabs_2" class="tab" aria-label="Rutinas" />
                <div class="tab-content border-base-300 bg-base-100 p-10">Tab content 3</div>
                </div>
            </section>
        </div>
</x-layout>
