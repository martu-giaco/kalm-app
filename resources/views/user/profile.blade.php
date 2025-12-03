{{-- resources/views/user/profile.blade.php --}}

<x-layout :title="'Mi perfil'">
    <section class="max-w-6xl mx-auto px-5 pt-5 rounded-t-3xl bg-white">
        <div class="max-w-6xl rounded-t-3xl bg-white">
            {{-- Header: avatar + datos --}}
            <section class=" flex flex-col md:flex-row items-center md:items-start gap-3 md:gap-8 mb-5">
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
                    <div></div>
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
                <div class="w-full flex justify-between  md:mt-0 md:shrink-0">
                    <div class="flex w-full gap-2">
                        <a href="{{ route('profile.edit') }}" class="text-sm text-center py-1 px-4 w-60 rounded-lg bg-[#37A0AF] text-white">Editar perfil</a>
                        <a href="{{ route('profile.edit') }}" class="text-sm text-center py-1 px-4 w-60 rounded-lg bg-[#37A0AF] text-white">Mis resultados</a>
                    </div>
                </div>
            </section>

            <section class="bg-white">
                {{-- tabs con posts, reviews y rutinas --}}
                <div class="tabs tabs-border">
    <input type="radio" name="my_tabs_2" id="tab-1" class="tab" aria-label="Posteos" checked />
                <div class="tab-content border-base-300 bg-base-100 p-5">
                    Posteos del usuario
                </div>

                <input type="radio" name="my_tabs_2" class="tab" aria-label="Reviews" />
                <div class="tab-content border-base-300 bg-base-100 p-5">Proximamente</div>

                <input type="radio" name="rutinas" class="tab" aria-label="Rutinas" />
                <div class="tab-content border-base-300 bg-base-100 p-5">
                        <div >
                            {{-- no funcó esto :((, es para el iconito al lado del nombre según el time de la rutina --}}
                @forelse ($routines as $rutina)
                        {{-- Info de la rutina --}}
                        <div class="flex-1 bg-white px-3 py-5 rounded-lg shadow-md">
                            {{-- Nombre de la rutina --}}
                            <h2 class="text-lg font-medium text-[#306067]">{{ $rutina->name }}</h2>
                            {{-- simbolito time de routina --}}
                            @if($rutina->time)
                                <span class="text-[#2A4043]">
                                    @if($rutina->time === 'Día')
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#37A0AF"><path d="M480-760q-17 0-28.5-11.5T440-800v-80q0-17 11.5-28.5T480-920q17 0 28.5 11.5T520-880v80q0 17-11.5 28.5T480-760Zm198 82q-11-11-11-27.5t11-28.5l56-57q12-12 28.5-12t28.5 12q11 11 11 28t-11 28l-57 57q-11 11-28 11t-28-11Zm122 238q-17 0-28.5-11.5T760-480q0-17 11.5-28.5T800-520h80q17 0 28.5 11.5T920-480q0 17-11.5 28.5T880-440h-80ZM480-40q-17 0-28.5-11.5T440-80v-80q0-17 11.5-28.5T480-200q17 0 28.5 11.5T520-160v80q0 17-11.5 28.5T480-40ZM226-678l-57-56q-12-12-12-29t12-28q11-11 28-11t28 11l57 57q11 11 11 28t-11 28q-12 11-28 11t-28-11Zm508 509-56-57q-11-12-11-28.5t11-27.5q11-11 27.5-11t28.5 11l57 56q12 11 11.5 28T791-169q-12 12-29 12t-28-12ZM80-440q-17 0-28.5-11.5T40-480q0-17 11.5-28.5T80-520h80q17 0 28.5 11.5T200-480q0 17-11.5 28.5T160-440H80Zm89 271q-11-11-11-28t11-28l57-57q11-11 27.5-11t28.5 11q12 12 12 28.5T282-225l-56 56q-12 12-29 12t-28-12Zm311-71q-100 0-170-70t-70-170q0-100 70-170t170-70q100 0 170 70t70 170q0 100-70 170t-170 70Zm0-80q66 0 113-47t47-113q0-66-47-113t-113-47q-66 0-113 47t-47 113q0 66 47 113t113 47Zm0-160Z"/></svg>
                                        </span>
                                        @elseif($rutina->time === 'Noche')
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#37A0AF"><path d="M484-80q-84 0-157.5-32t-128-86.5Q144-253 112-326.5T80-484q0-128 72-232t193-146q22-8 41 5.5t18 36.5q-3 85 27 162t90 137q60 60 137 90t162 27q26-1 38.5 17.5T863-345q-44 120-147.5 192.5T484-80Zm0-80q88 0 163-44t118-121q-86-8-163-43.5T464-465q-61-61-97-138t-43-163q-77 43-120.5 118.5T160-484q0 135 94.5 229.5T484-160Zm-20-305Z"/></svg>
                                        </span>
                                    @endif
                                </span>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-[#CCE2E5]">¡Este usuario no tiene rutinas!</p>
                @endforelse

            </div>
                        </div>
                        </div>
                    </section>
        </div>

        <a class="flex bg-[#2A4043] h-16 w-16 rounded-full items-center justify-center shadow-xl absolute right-[4%] bottom-[10%]" href="{{ route('routines.create') }}">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#FFFF"><path d="M440-440H240q-17 0-28.5-11.5T200-480q0-17 11.5-28.5T240-520h200v-200q0-17 11.5-28.5T480-760q17 0 28.5 11.5T520-720v200h200q17 0 28.5 11.5T760-480q0 17-11.5 28.5T720-440H520v200q0 17-11.5 28.5T480-200q-17 0-28.5-11.5T440-240v-200Z"/></svg>
        </a>
        </div>
    </section>
</x-layout>
