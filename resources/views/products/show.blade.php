<x-layout :title="$product->name ?? 'Producto'">
    <div class="max-w-3xl mx-auto">

        <article class="px-5 pb-20 bg-white pt-7 rounded-t-3xl">
            <div class="flex flex-col gap-6 md:flex-row">

                {{-- Imagen principal --}}
                <div class="relative md:flex-shrink-0 md:w-1/2">
                    <div class="overflow-hidden bg-white shadow-lg rounded-3xl">
                        @if (!empty($product->image))
                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                                class="object-contain w-full bg-white h-80">
                        @else
                            <div class="flex items-center justify-center w-full text-gray-400 h-80">
                                Sin imagen
                            </div>
                        @endif
                    </div>

                    {{-- Corazón favorito --}}
                    <button type="button"
                        class="absolute p-2 transition bg-white rounded-full top-3 right-3 hover:scale-105"
                        id="favoriteBtn" title="Marcar favorito"
                        onclick="event.preventDefault(); event.stopPropagation(); toggleFavorito({{ $product->id }}, this); return false;">
                        <label class="swap" id="swapLabel" style="--is-checked: {{ $isFavorito ? 1 : 0 }};">
                            <!-- this hidden checkbox controls the state -->
                            <input type="checkbox" {{ $isFavorito ? 'checked' : '' }} />
                            <!-- filled heart icon (favorito) -->
                            <svg class="swap-on fill-[#430000]" xmlns="http://www.w3.org/2000/svg" height="24px"
                                viewBox="0 -960 960 960" width="24px" fill="#430000">
                                <path
                                    d="M479.76-139.83q-16.15 0-32.44-5.83-16.3-5.84-28.97-18.27l-69.48-63.48Q243.35-323.7 157.61-420.03 71.87-516.37 71.87-634q0-97.59 65.15-162.98 65.15-65.39 162.74-65.39 52.52 0 99.28 21.42 46.76 21.43 80.72 59.47 33.96-38.04 80.72-59.47 46.76-21.42 99.28-21.42 97.59 0 163.1 65.39 65.51 65.39 65.51 162.98 0 117.63-85.6 214.47-85.6 96.83-193.12 193.36l-68.24 62.47q-12.67 12.44-29.08 18.16-16.42 5.71-32.57 5.71Z" />
                            </svg>
                            <!-- empty heart icon (no favorito) -->
                            <svg class="swap-off fill-[#430000]" xmlns="http://www.w3.org/2000/svg" height="24px"
                                viewBox="0 -960 960 960" width="24px" fill="#430000">
                                <path
                                    d="M479.76-139.83q-16.15 0-32.44-5.83-16.3-5.84-28.97-18.27l-69.48-63.48Q243.35-323.7 157.61-420.03 71.87-516.37 71.87-634q0-97.58 65.15-162.97 65.15-65.4 162.74-65.4 52.52 0 99.28 21.42 46.76 21.43 80.72 59.47 33.96-38.04 80.72-59.47 46.76-21.42 99.28-21.42 97.68 0 163.14 65.4 65.47 65.39 65.47 162.97 0 117.63-85.6 214.47-85.6 96.83-193.12 193.36l-68.24 62.47q-12.67 12.44-29.08 18.16-16.42 5.71-32.57 5.71ZM440.09-688.8q-27.57-39.57-60.93-61.07t-79.33-21.5q-58.7 0-97.83 39.16-39.13 39.17-39.13 98.21 0 51.54 36.64 109.52 36.64 57.99 87.64 112.5 51 54.52 104.97 102.09 53.97 47.58 87.64 78.3 33.76-31 87.83-78.55 54.07-47.56 105.16-102.04 51.1-54.49 87.86-112.28 36.76-57.78 36.76-109.54 0-59.04-39.28-98.21-39.29-39.16-98.21-39.16-46.16 0-79.4 21.5-33.24 21.5-60.81 61.07-7.31 10.71-17.75 16.07-10.44 5.36-22.16 5.36t-22.07-5.36q-10.36-5.36-17.6-16.07ZM480-501.48Z" />
                            </svg>
                        </label>
                    </button>

                    {{-- Badge "Para vos!" --}}
                    @if (isset($product->tag) || session('personalized', false))
                        <span
                            class="absolute inline-block px-3 py-1 text-sm text-white bg-[#37A0AF] rounded-full shadow bottom-4 right-4">
                            Para vos!
                        </span>
                    @endif
                </div>

                {{-- Información lateral --}}
                <div class="flex flex-col justify-between md:w-1/2">
                    <div>
                        <h1 class="text-2xl md:text-2xl font-semibold text-[#164d4f] leading-tight">
                            {{ $product->name ?? 'Producto sin nombre' }}
                        </h1>

                        <div class="flex items-center justify-between">
                            @if (!empty($product->brand->name))
                                <h2 class="mt-1 text-lg text-[#37A0AF] truncate">{{ $product->brand->name }}</h2>
                            @endif

                            {{-- Rating --}}
                            @if (isset($product->rating))
                                <div class="flex items-center gap-2 mt-3">
                                    <div class="text-md text-[#CCE2E5]">{{ number_format($product->rating, 1) }}</div>
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                        width="24px" fill="#FFDE21">
                                        <path
                                            d="m682.11-375.7 152-130 27.91 2.24q19.39 2 30.33 15.68 10.93 13.67 10.93 29.82 0 9.2-3.59 18.16-3.6 8.95-12.32 15.91l-97.3 85.02 28.84 125.67q1 2.48 1.12 5.22.12 2.74.12 5.22 0 19.15-13.67 32.33-13.68 13.17-31.83 13.17-5.71 0-11.93-1.74t-11.94-5.22l-22.91-14.19-45.76-197.29Zm-99.5-308.26-40.33-94.17 9.48-22.72q5.72-13.67 17.65-20.89 11.94-7.22 24.37-7.22 12.68 0 24.49 6.72 11.82 6.72 17.53 20.63l53.81 127.37-107-9.72ZM185.15-208.41l44.24-189.72L81.67-525.85q-8.71-6.95-11.93-15.91-3.22-8.96-3.22-18.15 0-16.16 10.94-29.83 10.93-13.67 30.32-15.67l194.72-17 75.48-178.96q5.72-13.91 17.53-20.63 11.82-6.72 24.49-6.72 12.67 0 24.49 6.72 11.81 6.72 17.53 20.63l75.48 178.96 194.72 17q19.39 2 30.32 15.67 10.94 13.67 10.94 29.83 0 9.19-3.22 18.15-3.22 8.96-11.93 15.91L610.61-398.13l44.24 189.72q.76 2.28 1.24 10.43 0 19.15-13.68 32.33-13.67 13.17-31.82 13.17-3.96 0-23.87-6.95L420-259.91 253.28-159.43q-5.71 3.47-11.93 5.21-6.22 1.74-11.94 1.74-20.63 0-35.3-16.53-14.68-16.53-8.96-39.4Z" />
                                    </svg>
                                </div>
                            @endif
                        </div>

                        {{-- Tags --}}
                        @if (!empty($product->tags) && $product->tags->count())
                            <div class="flex flex-wrap gap-2 mt-4">
                                @foreach ($product->tags as $tag)
                                    <a
                                        class="text-white text-sm truncate bg-[#37A0AF] px-2 py-1 rounded-xl">{{ $tag->name }}</a>
                                @endforeach
                            </div>
                        @elseif(!empty($product->category->name))
                            <div class="flex flex-wrap gap-2 my-3">
                                <a href="{{ route('products.search', ['q' => '', 'type_id' => $product->type->id]) }}" class="text-sm inline-block text-white truncate bg-[#37A0AF] px-3 py-1 rounded-2xl">
                                    ✨{{ $product->type->name ?? '-' }}
                                </a>
                                <a href="{{ route('products.byCategory', ['category' => $product->category->slug]) }}"
                                    class="text-sm inline-block text-white truncate bg-[#37A0AF] px-3 py-1 rounded-2xl">
                                    {{ $product->category->name ?? '-' }}
                                </a>
                            </div>
                        @endif
                    </div>

                    {{-- Botón principal --}}
                    <div class="mt-6">
                        <label for="modal-routines" class="btn font-bold w-full bg-[#306067] text-white cursor-pointer">
                            Agregar a rutina
                        </label>
                    </div>
                </div>
            </div>

            {{-- Descripción --}}
            <div class="pt-6 mt-6 border-t">
                <h2 class="text-lg font-semibold text-[#164d4f] mb-2">Descripción</h2>
                <p class="leading-relaxed text-gray-700">
                    {{ $product->description ?? 'No hay descripción disponible.' }}
                </p>
            </div>

            {{-- Concerns --}}
            <div class="pt-6 mt-6 border-t">
                <h2 class="text-lg font-semibold text-[#164d4f] mb-2">Preocupaciones</h2>
                @foreach ($product->concerns as $concern)
                    <span
                        class="inline-block px-3 py-1 mb-2 text-sm text-white bg-[#37A0AF] rounded-full">{{ $concern->name }}</span>
                @endforeach
            </div>

            {{-- Reviews --}}
            <div class="pt-6 mt-6 border-t">
                <h2 class="text-lg font-semibold text-[#164d4f] mb-2">Reseñas de usuarios</h2>
                @if ($product->reviews->count())
                    <div class="space-y-4">
                        @foreach ($product->reviews as $review)
                            <div class="p-4 border rounded-xl bg-gray-50">
                                <div class="flex items-center justify-between mb-2">
                                    <p class="font-semibold text-[#306067]">{{ $review->user->name }}</p>
                                    <div class="flex items-center gap-1 text-yellow-400">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <svg xmlns="http://www.w3.org/2000/svg" height="16px"
                                                viewBox="0 -960 960 960" width="16px"
                                                fill="{{ $i <= $review->rating ? '#FFDE21' : '#d1d5db' }}">
                                                <path
                                                    d="M480-501.48l60.82 123.57 136.44 19.81-98.61 96.05 23.27 135.92L480 744.1l-122.94 64.83 23.27-135.92-98.61-96.05 136.44-19.81L480-501.48Z" />
                                            </svg>
                                        @endfor
                                    </div>
                                </div>
                                <p>{{ $review->comment }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500">Este producto aún no tiene reseñas.</p>
                @endif

                {{-- Botón para crear reseña --}}
                @if (auth()->check())
                    @if (auth()->user()->premium)
                        @if (!auth()->user()->reviews->where('product_id', $product->id)->count())
                            <a href="{{ route('reviews.create', $product) }}"
                                class="mt-4 inline-block bg-[#306067] text-white px-5 py-2 rounded-lg font-bold hover:bg-[#164d4f]">
                                Escribir reseña
                            </a>
                        @endif
                    @else
                        <a href="{{ route('subscription.show') }}"
                            class="mt-4 inline-block bg-[#37A0AF] text-white px-5 py-2 rounded-lg font-bold hover:bg-[#2B7C87] transition">
                            Kälm Premium
                        </a>
                    @endif
                @endif
            </div>

            @foreach ($product_sections as $section)
                @php
                    $products_with_tag = $section['products'];
                @endphp

                <div class="pt-6 mt-6 border-t">
                    <h2 class="text-xl font-bold text-[#306067] mb-2">{{ $section['title'] }}</h2>
                        <div class="flex pb-4 space-x-6 overflow-x-auto scrollbar-hide">
                        @foreach ($products_with_tag as $sectionProduct)
                            <x-product-card :product="$sectionProduct" />
                        @endforeach
                    </div>
                </div>
            @endforeach

            {{-- Detalles del producto --}}
            <div class="pt-6 mt-6 border-t">
                <h2 class="text-lg font-semibold text-[#164d4f] mb-2">Detalles del producto</h2>
                <div class="flex flex-wrap gap-4">

                    @if (!empty($product->ingredients))
                        <div class="p-3 bg-white shadow-md w-36 rounded-xl">
                            <h3 class="mb-1 text-sm text-gray-500">Ingredientes</h3>
                            <p class="text-sm font-bold">{{ Str::limit($product->ingredients, 50) }}</p>
                        </div>
                    @endif

                    @if (!empty($product->activos))
                        <div class="p-3 bg-white shadow-md w-36 rounded-xl">
                            <h3 class="mb-1 text-sm text-gray-500">Activos</h3>
                            <p class="text-sm font-bold">{{ Str::limit($product->activos, 50) }}</p>
                        </div>
                    @endif

                    @if (!empty($product->formato))
                        <div class="p-3 bg-white shadow-md w-36 rounded-xl">
                            <h3 class="mb-1 text-sm text-gray-500">Formato</h3>
                            <p class="text-sm font-bold">{{ $product->formato }}</p>
                        </div>
                    @endif

                </div>
            </div>

            <div class="pt-6 mt-6 border-t">
                <h2 class="text-lg font-bold text-[#164d4f] mb-2">Ingredientes</h2>
                <p class="text-sm font-bold">{{ Str::limit($product->ingredients, 50) }}</p>
            </div>
        </article>
    </div>

    <input type="checkbox" id="modal-routines" class="modal-toggle" />
    <div id="modal-routines" class="modal">
        <div class="max-w-2xl p-6 modal-box w-90">
            <div class="flex items-center justify-between">
                <label for="modal-routines"
                    class="absolute btn btn-sm btn-circle btn-ghost focus-visible:outline-0 right-4 top-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" viewBox="0 -960 960 960" fill="#306067"
                        aria-hidden="true">
                        <path
                            d="M480-424 284-228q-11 11-28 11t-28-11q-11-11-11-28t11-28l196-196-196-196q-11-11-11-28t11-28q11-11 28-11t28 11l196 196 196-196q11-11 28-11t28 11q11 11 11 28t-11 28L536-480l196 196q11 11 11 28t-11 28q-11 11-28 11t-28-11L480-424Z" />
                    </svg>
                </label>
                <h3 class="text-xl font-bold mb-4 text-[#306067]">Selecciona la rutina</h3>
            </div>

            <div class="space-y-3">
                @if (isset($routines) && $routines->count())
                    <div class="space-y-2 rounded-lg">
                        <a href="{{ route('routines.create') }}"
                            class="rounded-lg p-3 bg-[#306067] flex items-center justify-between shadow-xl">
                            <p class="text-white">Nueva Rutina</p>
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                width="24px" fill="#FFFFFF">
                                <path
                                    d="M434.5-434.5H237.37q-19.15 0-32.33-13.17-13.17-13.18-13.17-32.33t13.17-32.33q13.18-13.17 32.33-13.17H434.5v-197.13q0-19.15 13.17-32.33 13.18-13.17 32.33-13.17t32.33 13.17q13.17 13.18 13.17 32.33v197.13h197.13q19.15 0 32.33 13.17 13.17 13.18 13.17 32.33t-13.17 32.33q-13.18 13.17-32.33 13.17H525.5v197.13q0 19.15-13.17 32.33-13.18 13.17-32.33 13.17t-32.33-13.17q-13.17-13.18-13.17-32.33V-434.5Z" />
                            </svg>
                        </a>
                        @foreach ($routines as $routine)
                            <form action="{{ route('routines.addProduct', $routine) }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <button type="submit"
                                    class="flex flex-col w-full px-3 py-5 mb-3 transition-shadow bg-white rounded-lg shadow-md cursor-pointer hover:shadow-lg">
                                    <div>
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                <h2 class="text-xl font-medium text-[#306067]">{{ $routine->name }}
                                                </h2>
                                                @if ($routine->routineTime)
                                                    @if ($routine->routineTime?->name === 'Día')
                                                        <svg xmlns="http://www.w3.org/2000/svg" height="20px"
                                                            viewBox="0 -960 960 960" width="20px" fill="#37A0AF"
                                                            class="ms-1">
                                                            <path
                                                                d="M480-760q-17 0-28.5-11.5T440-800v-80q0-17 11.5-28.5T480-920q17 0 28.5 11.5T520-880v80q0 17-11.5 28.5T480-760Zm198 82q-11-11-11-27.5t11-28.5l56-57q12-12 28.5-12t28.5 12q11 11 11 28t-11 28l-57 57q-11 11-28 11t-28-11Zm122 238q-17 0-28.5-11.5T760-480q0-17 11.5-28.5T800-520h80q17 0 28.5 11.5T920-480q0 17-11.5 28.5T880-440h-80ZM480-40q-17 0-28.5-11.5T440-80v-80q0-17 11.5-28.5T480-200q17 0 28.5 11.5T520-160v80q0 17-11.5 28.5T480-40ZM226-678l-57-56q-12-12-12-29t12-28q11-11 28-11t28 11l57 57q11 11 11 28t-11 28q-12 11-28 11t-28-11Zm508 509-56-57q-11-12-11-28.5t11-27.5q11-11 27.5-11t28.5 11l57 56q12 11 11.5 28T791-169q-12 12-29 12t-28-12ZM80-440q-17 0-28.5-11.5T40-480q0-17 11.5-28.5T80-520h80q17 0 28.5 11.5T200-480q0 17-11.5 28.5T160-440H80Zm89 271q-11-11-11-28t11-28l57-57q11-11 27.5-11t28.5 11q12 12 12 28.5T282-225l-56 56q-12 12-29 12t-28-12Zm311-71q-100 0-170-70t-70-170q0-100 70-170t170-70q100 0 170 70t70 170q0 100-70 170t-170 70Zm0-80q66 0 113-47t47-113q0-66-47-113t-113-47q-66 0-113 47t-47 113q0 66 47 113t113 47Zm0-160Z" />
                                                        </svg>
                                                    @elseif($routine->routineTime?->name === 'Noche')
                                                        <svg xmlns="http://www.w3.org/2000/svg" height="20px"
                                                            viewBox="0 -960 960 960" width="20px" fill="#37A0AF"
                                                            class="ms-1">
                                                            <path
                                                                d="M480.24-116.41q-153.63 0-258.73-104.98Q116.41-326.37 116.41-480q0-133.93 84.74-235.43t223.31-123.05q15.39-3.43 27.54 1.35 12.15 4.78 19.95 14.02 7.79 9.24 9.6 22.2 1.82 12.95-4.75 26.11-13.89 25.04-21.31 51.65-7.42 26.61-7.42 55.5 0 91.69 64.32 155.88 64.33 64.18 156.22 64.18 28.37 0 56.48-7.44 28.11-7.45 50.91-20.58 12.91-5.8 25.13-4.11 12.22 1.7 21.1 8.13 9.88 6.44 14.66 18.23 4.78 11.8 1.59 27.95Q820.17-291 717.63-203.71q-102.54 87.3-237.39 87.3Zm0-91q81.78 0 147.84-43.72 66.05-43.72 98.29-114.78-17.61 4.04-35.1 6.32-17.49 2.29-34.86 1.81-122.04-4.07-207.94-89.37-85.9-85.31-90.45-209.26-.24-17.37 1.93-34.98 2.16-17.61 6.44-34.98-70.82 32.48-114.78 98.65-43.96 66.18-43.96 147.72 0 112.93 79.83 192.76 79.83 79.83 192.76 79.83Zm-13.11-259.48Z" />
                                                        </svg>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                        <p class="text-[#37A0AF] text-sm text-start">
                                            {{ $routine->type?->name ?? 'No definido' }} ·
                                            {{ $routine->routineNeed?->name ?? 'No definido' }}</p>
                                    </div>
                                    <div class="flex items-center justify-between mt-3">

                                        <div class="flex items-center gap-2">
                                            @php
                                                $products = $routine->assignedProducts;
                                                $visible = $products->take(3);
                                                $remaining = $products->count() - 3;
                                            @endphp
                                            @forelse($visible as $assignedProduct)
                                                <img src="{{ $assignedProduct->image_url }}" alt="{{ $assignedProduct->name }}"
                                                    class="object-contain w-16 h-16 rounded-md">
                                            @empty
                                                <p class="text-md text-[#CCE2E5]">
                                                    No hay productos en esta rutina.
                                                </p>
                                            @endforelse
                                            @if ($remaining > 0)
                                                <p
                                                    class=" flex items-center justify-center text-[#2A4043] text-md font-black">
                                                    +{{ $remaining }}
                                                </p>
                                            @endif
                                        </div>
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px"
                                            viewBox="0 -960 960 960" width="24px" fill="#306067">
                                            <path
                                                d="M496.35-480 344.17-632.17Q331.5-644.85 331.5-664t12.67-31.83Q356.85-708.5 376-708.5t31.83 12.67l183.76 183.76q6.71 6.72 9.81 14.92 3.1 8.19 3.1 17.15 0 8.96-3.1 17.15-3.1 8.2-9.81 14.92L407.83-264.17Q395.15-251.5 376-251.5t-31.83-12.67Q331.5-276.85 331.5-296t12.67-31.83L496.35-480Z" />
                                        </svg>
                                    </div>
                                </button>
                            </form>
                        @endforeach
                    </div>
                @else
                    <p class="mt-2 text-sm text-slate-400">¡Todavía no tiene rutinas!</p>
                    {{-- Botón flotante para crear nueva rutina --}}
                    <div>
                        <a href="{{ route('routines.create') }}"
                            class="p-3 bg-[#2A4043] flex items-center justify-center rounded-lg shadow-xl">
                            Nueva Rutina
                        </a>
                    </div>
                @endif
            </div>

        </div>
    </div>

    <script>
        let isProcessing = false; // Prevenir múltiples requests simultáneos

        function toggleFavorito(productId, btn) {
            // Prevenir múltiples clicks mientras se procesa
            if (isProcessing) {
                console.log('Solicitud en progreso, esperando respuesta...');
                return false;
            }

            isProcessing = true;
            const checkbox = btn.querySelector('input[type="checkbox"]');
            const initialState = checkbox.checked;

            // Cambiar visualmente de inmediato (optimistic update)
            checkbox.checked = !checkbox.checked;
            console.log('Checkbox toggled to:', checkbox.checked);

            fetch(`/productos/${productId}/favorito`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(res => {
                    console.log('Status:', res.status);
                    if (!res.ok) {
                        throw new Error(`Error del servidor: ${res.status}`);
                    }
                    return res.json();
                })
                .then(data => {
                    console.log('Respuesta servidor:', data);
                    if (data.error) {
                        throw new Error(data.error);
                    }
                    // Confirmar el estado con la respuesta del servidor
                    checkbox.checked = data.favorito;
                    console.log('Estado confirmado:', data.favorito);
                })
                .catch(err => {
                    console.error('Error:', err);
                    checkbox.checked = initialState;
                    alert('Error al actualizar favoritos: ' + err.message);
                })
                .finally(() => {
                    isProcessing = false;
                    console.log('Solicitud completada, se pueden hacer nuevos clicks');
                });
        }
    </script>
</x-layout>
