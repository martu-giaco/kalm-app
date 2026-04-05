{{-- resources/views/user/profile.blade.php --}}

<x-layout :title="'Mi perfil'">
    <section class="min-h-full pt-5 pb-20 mx-auto bg-white rounded-t-3xl">
        {{-- Header: avatar + datos --}}
        <div class="flex flex-col items-center gap-3 px-5 mb-5 md:flex-row md:items-center md:gap-8">
            <div class="w-full max-w-3xl">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <h2 class="text-3xl me-2 text-[#306067]">{{ $user->name ?? 'Invitado' }}</h2>
                        @if (auth()->user()?->role === 'free')
                            <a href="{{ route('subscription.show') }}"
                                class="py-1 px-3 rounded-xl bg-[#CCE2E5] text-[#306067]">
                                <p class="text-sm">Free</p>
                            </a>
                        @elseif(auth()->user()?->role === 'premium')
                            <div class="px-3 py-1 rounded-xl"
                                style="background-image: linear-gradient(45deg, #37A0AF , #CCE2E5 88%);">
                                <p class="text-sm">Premium</p>
                            </div>
                        @elseif(auth()->user()?->role === 'admin')
                            <div class="px-3 py-1 rounded-xl"
                                style="background-image: linear-gradient(45deg, #37A0AF , #CCE2E5 88%);">
                                <p class="text-sm">Admin</p>
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
                        <div class="rounded-full h-28 w-28">
                            @if (isset($user) && $user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}"
                                    alt="{{ $user->name ?? 'Avatar usuario' }}" class="object-cover w-full h-full"
                                    loading="lazy" decoding="async" />
                            @else
                                <img src="{{ asset('images/pfp.svg') }}" alt="Avatar por defecto"
                                    class="object-contain w-full h-full" loading="lazy" decoding="async" />
                            @endif
                        </div>
                    </div>

                    {{-- Stats  --}}
                    <div class="w-full">
                        <div class="flex justify-center gap-7">
                            <a href="{{ route('favorites') }}" class="flex flex-col items-center">
                                <strong class="text-[#306067] text-2xl">{{ $user->favoritos_count }}</strong>
                                <p class="text-xs">
                                    @if ($user->favoritos_count === 1)
                                        Favorito
                                    @else
                                        Favoritos
                                    @endif
                                </p>
                            </a>
                            <a href="{{ route('home') }}" class="flex flex-col items-center">
                                <strong class="text-[#306067] text-2xl">{{ $user->reviews_count ?? 0 }}</strong>
                                <p class="text-xs">
                                    @if ($user->reviews_count === 1)
                                        Review
                                    @else
                                        Reviews
                                    @endif
                                </p>
                            </a>
                            <a href="{{ route('routines.index') }}" class="flex flex-col items-center">
                                <strong class="text-[#306067] text-2xl">{{ $user->routines_count }}</strong>
                                <p class="text-xs">
                                    @if ($user->routines_count === 1)
                                        Rutina
                                    @else
                                        Rutinas
                                    @endif
                                </p>
                            </a>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Acciones --}}
            <div class="w-full gap-4">
                <div class="grid grid-cols-2 grid-rows-1 gap-2">
                    <a href="{{ route('profile.edit') }}"
                        class="text-sm text-center py-1 px-4 rounded-lg bg-[#37A0AF] text-white">
                        Editar perfil
                    </a>
                    <a href="{{ route('profile.results') }}"
                        class="text-sm text-center py-1 px-4 rounded-lg bg-[#37A0AF] text-white">
                        Mis resultados
                    </a>
                </div>
            </div>
        </div>

        {{-- Tabs: reviews, rutinas --}}
        <section class="mt-5 bg-white">
            <div class="w-full">
                <div class="mb-4 border-b border-[#CCE2E5]">
                    <ul class="flex w-full -mb-px space-x-6 overflow-auto text-sm font-medium text-center"
                        role="tablist">
                        <li role="presentation" class="flex-1">
                            <button type="button" aria-disabled="false"
                                class="group inline-flex items-center justify-center whitespace-nowrap align-middle text-sm leading-none disabled:cursor-not-allowed h-[38px] min-w-[38px] w-full gap-2 disabled:stroke-[#CCE2E5] disabled:text-[#CCE2E5] opacity-50 hover:opacity-100 box-content border-b-2 p-0 transition-all duration-100 ease-in-out rounded-none border-b-[#306067] stroke-[#306067] font-semibold text-[#2A4043]"
                                id="tab-1" role="tab" aria-controls="tab-panel-1" aria-selected="true"
                                tabindex="0">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                    width="24px" fill="#306067" class="p-0">
                                    <path
                                        d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h168q13-36 43.5-58t68.5-22q38 0 68.5 22t43.5 58h168q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm120-160h200q17 0 28.5-11.5T560-320q0-17-11.5-28.5T520-360H320q-17 0-28.5 11.5T280-320q0 17 11.5 28.5T320-280Zm0-160h320q17 0 28.5-11.5T680-480q0-17-11.5-28.5T640-520H320q-17 0-28.5 11.5T280-480q0 17 11.5 28.5T320-440Zm0-160h320q17 0 28.5-11.5T680-640q0-17-11.5-28.5T640-680H320q-17 0-28.5 11.5T280-640q0 17 11.5 28.5T320-600Zm160-190q13 0 21.5-8.5T510-820q0-13-8.5-21.5T480-850q-13 0-21.5 8.5T450-820q0 13 8.5 21.5T480-790Z" />
                                </svg>
                            </button>
                        </li>
                        <li role="presentation" class="flex-1">
                            <button type="button" aria-disabled="false"
                                class="group inline-flex items-center justify-center whitespace-nowrap align-middle text-sm leading-none disabled:cursor-not-allowed stroke-[#CCE2E5] text-black h-[38px] min-w-[38px] w-full gap-2 disabled:stroke-[#CCE2E5] disabled:text-[#CCE2E5] opacity-50 hover:opacity-100 box-content rounded-none border-b-2 border-b-transparent p-0 font-normal transition-all duration-100 ease-in-out"
                                id="tab-2" role="tab" aria-controls="tab-panel-2" aria-selected="false"
                                tabindex="0">

                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                    width="24px" fill="#306067">
                                    <path
                                        d="m682.11-375.7 152-130 27.91 2.24q19.39 2 30.33 15.68 10.93 13.67 10.93 29.82 0 9.2-3.59 18.16-3.6 8.95-12.32 15.91l-97.3 85.02 28.84 125.67q1 2.48 1.12 5.22.12 2.74.12 5.22 0 19.15-13.67 32.33-13.68 13.17-31.83 13.17-5.71 0-11.93-1.74t-11.94-5.22l-22.91-14.19-45.76-197.29Zm-99.5-308.26-40.33-94.17 9.48-22.72q5.72-13.67 17.65-20.89 11.94-7.22 24.37-7.22 12.68 0 24.49 6.72 11.82 6.72 17.53 20.63l53.81 127.37-107-9.72ZM185.15-208.41l44.24-189.72L81.67-525.85q-8.71-6.95-11.93-15.91-3.22-8.96-3.22-18.15 0-16.16 10.94-29.83 10.93-13.67 30.32-15.67l194.72-17 75.48-178.96q5.72-13.91 17.53-20.63 11.82-6.72 24.49-6.72 12.67 0 24.49 6.72 11.81 6.72 17.53 20.63l75.48 178.96 194.72 17q19.39 2 30.32 15.67 10.94 13.67 10.94 29.83 0 9.19-3.22 18.15-3.22 8.96-11.93 15.91L610.61-398.13l44.24 189.72q.76 2.28 1.24 10.43 0 19.15-13.68 32.33-13.67 13.17-31.82 13.17-3.96 0-23.87-6.95L420-259.91 253.28-159.43q-5.71 3.47-11.93 5.21-6.22 1.74-11.94 1.74-20.63 0-35.3-16.53-14.68-16.53-8.96-39.4Z" />
                                </svg>
                            </button>
                        </li>

                    </ul>
                </div>
                <div id="tab-panel-0" class="px-5 ">
                    @forelse ($routines ?? [] as $rutina)
                        <x-routine-card :rutina="$rutina" />
                    @empty
                        <p class="text-[#CCE2E5]">¡Este usuario no tiene rutinas!</p>
                    @endforelse
                </div>

                {{-- Reviews del usuario sobre productos --}}
                <div id="tab-panel-2" class="hidden px-5 ">
                    @forelse ($reviews ?? [] as $review)
                        @if ($review->product)
                            {{-- Solo mostrar si el producto existe --}}
                            <a href="{{ route('products.show', $review->product->id) }}"
                                class="block border border-[#CCE2E5] rounded-3xl p-4 mb-4 shadow-sm bg-white hover:shadow-md transition-all duration-200">

                                <div class="flex flex-col gap-4 md:flex-row">
                                    {{-- Imagen del producto --}}
                                    <div class="flex-shrink-0 w-full overflow-hidden bg-white rounded-2xl md:w-24">
                                        @if (!empty($review->product->image))
                                            <img src="{{ asset($review->product->image) }}"
                                                alt="{{ $review->product->name }}"
                                                class="object-contain w-full h-24 md:h-24">
                                        @else
                                            <div
                                                class="flex items-center justify-center w-full h-24 text-gray-400 md:h-24">
                                                Sin imagen 
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Contenido --}}
                                    <div class="flex flex-col justify-between flex-1">
                                        <div class="flex items-center justify-between mb-1">
                                            {{-- Nombre del producto --}}
                                            <h3 class="text-[#306067] font-semibold text-lg">
                                                {{ $review->product->name }}
                                            </h3>
                                            {{-- Rating --}}
                                            <span class="flex items-center text-yellow-400">
                                                {{ $review->rating ?? 0 }}
                                                <svg xmlns="http://www.w3.org/2000/svg" height="20px"
                                                    viewBox="0 -960 960 960" width="20px" fill="#FFDE21">
                                                    <path
                                                        d="M480-269 314-169q-11 7-23 6t-21-8q-9-7-14-17.5t-2-23.5l44-189-147-127q-10-9-12.5-20.5T140-571q4-11 12-18t22-9l194-17 75-178q5-12 15.5-18t21.5-6q11 0 21.5 6t15.5 18l75 178 194 17q14 2 22 9t12 18q4 11 1.5 22.5T809-528L662-401l44 189q3 13-2 23.5T690-171q-9 7-21 8t-23-6L480-269Z" />
                                                </svg>
                                            </span>
                                        </div>
                                        {{-- Comentario --}}
                                        <p class="text-[#2A4043] text-sm mb-2">{{ $review->comment }}</p>
                                        {{-- Fecha --}}
                                        <p class="text-xs text-gray-400">{{ $review->created_at->format('d/m/Y') }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        @endif
                    @empty
                        <p class="text-[#CCE2E5]">¡No existen reviews de productos todavía!</p>
                    @endforelse
                </div>
            </div>
        </section>

        <!-- Required JavaScript para las tabs -->
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const inactiveTabClassName = "border-b-transparent";
                const activeTabClassName =
                    "rounded-none border-b-[#306067] stroke-[#306067] font-semibold text-[#306067]";

                const tabs = document.querySelectorAll('[role="tab"]');
                const tabPanels = document.querySelectorAll('[id^="tab-panel-"]');

                tabs.forEach((tab, index) => {
                    tab.addEventListener("click", function() {
                        // Hide all tab panels
                        tabPanels.forEach((panel) => {
                            panel.classList.add("hidden");
                        });

                        // Remove active styles from all tabs
                        tabs.forEach((t) => {
                            t.setAttribute("aria-selected", "false");
                            t.classList.remove(...activeTabClassName.split(/\s+/));
                            t.classList.add(...inactiveTabClassName.split(/\s+/));
                        });

                        // Show the selected tab panel
                        tabPanels[index].classList.remove("hidden");

                        // Set the selected tab as active
                        tab.setAttribute("aria-selected", "true");
                        tab.classList.add(...activeTabClassName.split(/\s+/));
                        tab.classList.remove(...inactiveTabClassName.split(/\s+/));
                    });
                });
            });
        </script>

        {{-- Botón flotante para crear nueva rutina --}}
        <div class="fixed z-50 fab bottom-24 right-6">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                fill="#FFFF">
                <path
                    d="M440-440H240q-17 0-28.5-11.5T200-480q0-17 11.5-28.5T240-520h200v-200q0-17 11.5-28.5T480-760q17 0 28.5 11.5T520-720v200h200q17 0 28.5 11.5T760-480q0 17-11.5 28.5T720-440H520v200q0 17-11.5 28.5T480-200q-17 0-28.5-11.5T440-240v-200Z" />
            </svg>
            <a href="{{ route('routines.create') }}"
                class="bg-gradient-to-r from-[#258592] via-[#1d949c] to-[#258592] py-3 px-5 rounded-full flex items-center justify-center shadow-xl">
                <p class="text-white">
                    + Nueva Rutina
                </p>
            </a>
        </div>
    </section>
</x-layout>
