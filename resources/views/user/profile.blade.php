{{-- resources/views/user/profile.blade.php --}}

<x-layout :title="'Mi perfil'">
    <section class="px-5 pt-5 mx-auto bg-white rounded-t-3xl">
        {{-- Header: avatar + datos --}}
        <div class="flex flex-col items-center gap-3 mb-5 md:flex-row md:items-center md:gap-8">
            <div class="w-full max-w-3xl">
                <div class="flex items-center justify-end">
                    <span class="flex text-[#CCE2E5]">
                        ?
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                            fill="#FFDE21">
                            <path
                                d="M480-269 314-169q-11 7-23 6t-21-8q-9-7-14-17.5t-2-23.5l44-189-147-127q-10-9-12.5-20.5T140-571q4-11 12-18t22-9l194-17 75-178q5-12 15.5-18t21.5-6q11 0 21.5 6t15.5 18l75 178 194 17q14 2 22 9t12 18q4 11 1.5 22.5T809-528L662-401l44 189q3 13-2 23.5T690-171q-9 7-21 8t-23-6L480-269Z" />
                        </svg>
                    </span>
                </div>

                {{-- Avatar --}}
                <div class="flex items-center gap-4 mt-4">
                    <div class="overflow-hidden rounded-full h-28 w-28">
                        @if(isset($user) && $user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name ?? 'Avatar usuario' }}"
                                class="object-cover w-full h-full" loading="lazy" decoding="async" />
                        @else
                            <img src="{{ asset('images/pfp.svg') }}" alt="Avatar por defecto"
                                class="object-contain w-full h-full" loading="lazy" decoding="async" />
                        @endif
                    </div>

                    {{-- Stats --}}
                    <div class="flex gap-7">
                        <div class="flex flex-col items-center">
                            <strong class="text-[#306067] text-2xl">{{ $user->posts_count ?? 0 }}</strong>
                            <p class="text-xs">Publicaciones</p>
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
                </div>

                {{-- Bio --}}
                <div class="mt-4">
                    <h2 class="text-2xl text-[#306067]">{{ $user->name ?? 'Invitado' }}</h2>
                    <p>{{ $user->bio ?? 'Bio no disponible.' }}</p>
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
                        <a href="{{ route('routines.show', $rutina) }}">
                            <article class="flex flex-col w-full px-3 py-5 mb-3 transition-shadow bg-white rounded-lg shadow-md hover:shadow-lg">
                                <div>
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <h2 class="text-xl font-medium text-[#306067]">{{ $rutina->name }}</h2>
                                            @if($rutina->routineTime)
                                                    @if($rutina->routineTime?->name === 'Día')
                                                        <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960"
                                                            width="20px" fill="#37A0AF" class="ms-1">
                                                            <path
                                                                d="M480-760q-17 0-28.5-11.5T440-800v-80q0-17 11.5-28.5T480-920q17 0 28.5 11.5T520-880v80q0 17-11.5 28.5T480-760Zm198 82q-11-11-11-27.5t11-28.5l56-57q12-12 28.5-12t28.5 12q11 11 11 28t-11 28l-57 57q-11 11-28 11t-28-11Zm122 238q-17 0-28.5-11.5T760-480q0-17 11.5-28.5T800-520h80q17 0 28.5 11.5T920-480q0 17-11.5 28.5T880-440h-80ZM480-40q-17 0-28.5-11.5T440-80v-80q0-17 11.5-28.5T480-200q17 0 28.5 11.5T520-160v80q0 17-11.5 28.5T480-40ZM226-678l-57-56q-12-12-12-29t12-28q11-11 28-11t28 11l57 57q11 11 11 28t-11 28q-12 11-28 11t-28-11Zm508 509-56-57q-11-12-11-28.5t11-27.5q11-11 27.5-11t28.5 11l57 56q12 11 11.5 28T791-169q-12 12-29 12t-28-12ZM80-440q-17 0-28.5-11.5T40-480q0-17 11.5-28.5T80-520h80q17 0 28.5 11.5T200-480q0 17-11.5 28.5T160-440H80Zm89 271q-11-11-11-28t11-28l57-57q11-11 27.5-11t28.5 11q12 12 12 28.5T282-225l-56 56q-12 12-29 12t-28-12Zm311-71q-100 0-170-70t-70-170q0-100 70-170t170-70q100 0 170 70t70 170q0 100-70 170t-170 70Zm0-80q66 0 113-47t47-113q0-66-47-113t-113-47q-66 0-113 47t-47 113q0 66 47 113t113 47Zm0-160Z" />
                                                        </svg>
                                                    @elseif($rutina->routineTime?->name === 'Noche')
                                                        <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#37A0AF" class="ms-1"><path d="M480.24-116.41q-153.63 0-258.73-104.98Q116.41-326.37 116.41-480q0-133.93 84.74-235.43t223.31-123.05q15.39-3.43 27.54 1.35 12.15 4.78 19.95 14.02 7.79 9.24 9.6 22.2 1.82 12.95-4.75 26.11-13.89 25.04-21.31 51.65-7.42 26.61-7.42 55.5 0 91.69 64.32 155.88 64.33 64.18 156.22 64.18 28.37 0 56.48-7.44 28.11-7.45 50.91-20.58 12.91-5.8 25.13-4.11 12.22 1.7 21.1 8.13 9.88 6.44 14.66 18.23 4.78 11.8 1.59 27.95Q820.17-291 717.63-203.71q-102.54 87.3-237.39 87.3Zm0-91q81.78 0 147.84-43.72 66.05-43.72 98.29-114.78-17.61 4.04-35.1 6.32-17.49 2.29-34.86 1.81-122.04-4.07-207.94-89.37-85.9-85.31-90.45-209.26-.24-17.37 1.93-34.98 2.16-17.61 6.44-34.98-70.82 32.48-114.78 98.65-43.96 66.18-43.96 147.72 0 112.93 79.83 192.76 79.83 79.83 192.76 79.83Zm-13.11-259.48Z"/></svg>
                                                    @endif
                                            @endif
                                        </div>
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#306067"><path d="M480.12-149q-34.55 0-59.13-24.55-24.58-24.56-24.58-59.04 0-34.58 24.56-59.2 24.55-24.62 59.03-24.62 34.67 0 59.13 24.59 24.46 24.6 24.46 59.13 0 34.54-24.46 59.11Q514.67-149 480.12-149Zm0-247.41q-34.55 0-59.13-24.56-24.58-24.55-24.58-59.03 0-34.67 24.56-59.13 24.55-24.46 59.03-24.46 34.67 0 59.13 24.46t24.46 59.01q0 34.55-24.46 59.13-24.46 24.58-59.01 24.58Zm0-247.18q-34.55 0-59.13-24.64-24.58-24.64-24.58-59.25t24.56-59.06Q445.52-811 480-811q34.67 0 59.13 24.46 24.46 24.45 24.46 59.06t-24.46 59.25q-24.46 24.64-59.01 24.64Z"/></svg>
                                    </div>
                                    <span class="text-[#37A0AF] text-sm">{{ $rutina->types->pluck('name')->join(', ') ?: 'No definido' }} · {{ $rutina->routineTime?->name ?? 'No definido' }}</span>
                                </div>
                                <div class="flex items-center justify-between mt-3">

                                <div class="flex items-center gap-2">
                                        @php
                                            $products = $rutina->assignedProducts;
                                            $visible = $products->take(3);
                                            $remaining = $products->count() - 3;
                                        @endphp
                                        @forelse($visible as $product)
                                            <img
                                                src="{{ $product->image_url }}"
                                                alt="{{ $product->name }}"
                                                class="h-16 w-16 object-contain rounded-md"
                                            >
                                        @empty
                                            <p class="text-md text-[#CCE2E5]">
                                                No hay productos en esta rutina.
                                            </p>
                                        @endforelse
                                        @if($remaining > 0)
                                            <p class=" flex items-center justify-center text-[#2A4043] text-md font-black">
                                                +{{ $remaining }}
                                            </p>
                                        @endif
                                    </div>
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#306067">
                                        <path d="M496.35-480 344.17-632.17Q331.5-644.85 331.5-664t12.67-31.83Q356.85-708.5 376-708.5t31.83 12.67l183.76 183.76q6.71 6.72 9.81 14.92 3.1 8.19 3.1 17.15 0 8.96-3.1 17.15-3.1 8.2-9.81 14.92L407.83-264.17Q395.15-251.5 376-251.5t-31.83-12.67Q331.5-276.85 331.5-296t12.67-31.83L496.35-480Z"/>
                                    </svg>
                                </div>
                            </article>
                        </a>
                    @empty
                        <p class="text-[#CCE2E5]">¡Este usuario no tiene rutinas!</p>
                    @endforelse
                </div>
            </div>
        </section>

        {{-- Botón flotante para crear nueva rutina --}}
        <a class="flex bg-[#2A4043] h-16 w-16 rounded-full items-center justify-center shadow-xl absolute right-[4%] bottom-[15%]"
            href="{{ route('routines.create') }}">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#FFFF">
                <path
                    d="M440-440H240q-17 0-28.5-11.5T200-480q0-17 11.5-28.5T240-520h200v-200q0-17 11.5-28.5T480-760q17 0 28.5 11.5T520-720v200h200q17 0 28.5 11.5T760-480q0 17-11.5 28.5T720-440H520v200q0 17-11.5 28.5T480-200q-17 0-28.5-11.5T440-240v-200Z" />
            </svg>
        </a>
    </section>
</x-layout>
