{{-- resources/views/user/profile.blade.php --}}

<x-layout :title="'Mi perfil'">
    <section class="px-5 pt-5 mx-auto bg-white rounded-t-3xl">
        {{-- Header: avatar + datos --}}
        <div class="flex flex-col items-center gap-3 mb-5 md:flex-row md:items-center md:gap-8">
            <div class="w-full max-w-3xl">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <h2 class="text-3xl me-2 text-[#306067]">{{ $user->name ?? 'Invitado' }}</h2>
                        @if(auth()->user()->role === 'free')
                            <div onclick="premium_modal.showModal()" class="py-1 px-3 rounded-xl bg-[#CCE2E5] text-[#306067] cursor-pointer">
                                <p class="text-sm">Free</p>
                            </div>
                        @elseif(auth()->user()->role === 'premium')
                            <div  class="py-1 px-3 rounded-xl" style="background-image: linear-gradient(45deg, #37A0AF , #CCE2E5 88%);">
                                <p class="text-sm">Premium</p>
                            </div>
                        @elseif(auth()->user()->role === 'admin')
                            <div  class="py-1 px-3 rounded-xl" style="background-image: linear-gradient(45deg, #37A0AF , #CCE2E5 88%);">
                                <p class="text-sm">Administrador</p>
                            </div>
                        @endif
                    </div>
                    <span class="flex text-[#CCE2E5]">
                        {{ $user->review_promedio ?? 0 }}
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                            fill="#FFDE21">
                            <path
                                d="M480-269 314-169q-11 7-23 6t-21-8q-9-7-14-17.5t-2-23.5l44-189-147-127q-10-9-12.5-20.5T140-571q4-11 12-18t22-9l194-17 75-178q5-12 15.5-18t21.5-6q11 0 21.5 6t15.5 18l75 178 194 17q14 2 22 9t12 18q4 11 1.5 22.5T809-528L662-401l44 189q3 13-2 23.5T690-171q-9 7-21 8t-23-6L480-269Z" />
                        </svg>
                    </span>
                </div>

                {{-- Avatar --}}
                <div class="flex items-center w-full gap-4 mt-4">
                    <div class="avatar">
                        <div class=" rounded-full h-28 w-28">
                            @if(isset($user) && $user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name ?? 'Avatar usuario' }}"
                                    class="object-cover w-full h-full" loading="lazy" decoding="async" />
                            @else
                                <img src="{{ asset('images/pfp.svg') }}" alt="Avatar por defecto"
                                    class="object-contain w-full h-full" loading="lazy" decoding="async" />
                            @endif
                        </div>
                    </div>

                    {{-- Stats --}}
                    <div class="w-full">
                        <div class="flex justify-center gap-7">
                            <div class="flex flex-col items-center">
                                <strong class="text-[#306067] text-2xl">{{ $user->faves_count ?? 0 }}</strong>
                                <p class="text-xs">Favoritos</p>
                            </div>
                            <div class="flex flex-col items-center">
                                <strong class="text-[#306067] text-2xl">{{ $user->reviews_count ?? 0 }}</strong>
                                <p class="text-xs">Reviews</p>
                            </div>
                            <div class="flex flex-col items-center">
                                <strong class="text-[#306067] text-2xl">{{ $user->routines_count ?? 0 }}</strong>
                                <p class="text-xs">Rutinas</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Acciones --}}
            <div class="flex flex-row w-full gap-4 ml-10 md:mt-0 md:shrink-0">
                <a href="{{ route('profile.edit') }}"
                    class="text-sm text-center py-1 px-4 rounded-lg bg-[#37A0AF] text-white">Editar perfil</a>
                <a href="{{ route('profile.results') }}"
                    class="text-sm text-center py-1 px-4 rounded-lg bg-[#37A0AF] text-white">Mis resultados</a>
            </div>
        </div>

        {{-- Tabs: publicaciones, reviews, rutinas --}}
        <section class="mt-5 bg-white">
            <div class="tabs tabs-border">

                <input type="radio" name="tabs" id="tab-reviews" class="tab" aria-label="Reviews" checked/>
                <div class="p-5 tab-content border-base-300 bg-base-100">
                    Proximamente
                </div>

                <input type="radio" name="tabs" id="tab-routines" class="tab" aria-label="Rutinas" />
                <div class="p-5 tab-content border-base-300 bg-base-100">
                    @forelse ($routines ?? [] as $rutina)
                        <x-routine-card :rutina="$rutina" />
                    @empty
                        <p class="text-[#CCE2E5]">¡Este usuario no tiene rutinas!</p>
                    @endforelse
                </div>
            </div>
        </section>

        {{-- Botón flotante para crear nueva rutina --}}
        <div class="fab fixed bottom-24 right-6 z-50">
            <a href="{{ route('routines.create') }}" class=" bg-[#2A4043] h-16 w-16 rounded-full flex items-center justify-center shadow-xl">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#FFFF">
                <path d="M440-440H240q-17 0-28.5-11.5T200-480q0-17 11.5-28.5T240-520h200v-200q0-17 11.5-28.5T480-760q17 0 28.5 11.5T520-720v200h200q17 0 28.5 11.5T760-480q0 17-11.5 28.5T720-440H520v200q0 17-11.5 28.5T480-200q-17 0-28.5-11.5T440-240v-200Z"/>
            </svg>
            </a>
        </div>
    </section>
</x-layout>
