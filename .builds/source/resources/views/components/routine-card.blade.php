
                        <article  onclick="window.location='{{ route('routines.show', $rutina) }}'" class="flex flex-col w-full px-3 py-5 mb-3 transition-shadow bg-white dark:bg-[#306067] rounded-lg shadow-md cursor-pointer hover:shadow-lg">
                                <div>
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <h2 class="text-xl font-medium text-[#306067] dark:text-[#CCE2E5]">{{ $rutina->name }}</h2>
                                            @if($rutina->routineTime)
                                                    @if($rutina->routineTime?->name === 'Día')
                                                        <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960"
                                                            width="20px" class="fill-[#306067] dark:fill-[#E9E5E3]" class="ms-1">
                                                            <path
                                                                d="M480-760q-17 0-28.5-11.5T440-800v-80q0-17 11.5-28.5T480-920q17 0 28.5 11.5T520-880v80q0 17-11.5 28.5T480-760Zm198 82q-11-11-11-27.5t11-28.5l56-57q12-12 28.5-12t28.5 12q11 11 11 28t-11 28l-57 57q-11 11-28 11t-28-11Zm122 238q-17 0-28.5-11.5T760-480q0-17 11.5-28.5T800-520h80q17 0 28.5 11.5T920-480q0 17-11.5 28.5T880-440h-80ZM480-40q-17 0-28.5-11.5T440-80v-80q0-17 11.5-28.5T480-200q17 0 28.5 11.5T520-160v80q0 17-11.5 28.5T480-40ZM226-678l-57-56q-12-12-12-29t12-28q11-11 28-11t28 11l57 57q11 11 11 28t-11 28q-12 11-28 11t-28-11Zm508 509-56-57q-11-12-11-28.5t11-27.5q11-11 27.5-11t28.5 11l57 56q12 11 11.5 28T791-169q-12 12-29 12t-28-12ZM80-440q-17 0-28.5-11.5T40-480q0-17 11.5-28.5T80-520h80q17 0 28.5 11.5T200-480q0 17-11.5 28.5T160-440H80Zm89 271q-11-11-11-28t11-28l57-57q11-11 27.5-11t28.5 11q12 12 12 28.5T282-225l-56 56q-12 12-29 12t-28-12Zm311-71q-100 0-170-70t-70-170q0-100 70-170t170-70q100 0 170 70t70 170q0 100-70 170t-170 70Zm0-80q66 0 113-47t47-113q0-66-47-113t-113-47q-66 0-113 47t-47 113q0 66 47 113t113 47Zm0-160Z" />
                                                        </svg>
                                                    @elseif($rutina->routineTime?->name === 'Noche')
                                                        <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" class="fill-[#306067] dark:fill-[#E9E5E3]" class="ms-1"><path d="M480.24-116.41q-153.63 0-258.73-104.98Q116.41-326.37 116.41-480q0-133.93 84.74-235.43t223.31-123.05q15.39-3.43 27.54 1.35 12.15 4.78 19.95 14.02 7.79 9.24 9.6 22.2 1.82 12.95-4.75 26.11-13.89 25.04-21.31 51.65-7.42 26.61-7.42 55.5 0 91.69 64.32 155.88 64.33 64.18 156.22 64.18 28.37 0 56.48-7.44 28.11-7.45 50.91-20.58 12.91-5.8 25.13-4.11 12.22 1.7 21.1 8.13 9.88 6.44 14.66 18.23 4.78 11.8 1.59 27.95Q820.17-291 717.63-203.71q-102.54 87.3-237.39 87.3Zm0-91q81.78 0 147.84-43.72 66.05-43.72 98.29-114.78-17.61 4.04-35.1 6.32-17.49 2.29-34.86 1.81-122.04-4.07-207.94-89.37-85.9-85.31-90.45-209.26-.24-17.37 1.93-34.98 2.16-17.61 6.44-34.98-70.82 32.48-114.78 98.65-43.96 66.18-43.96 147.72 0 112.93 79.83 192.76 79.83 79.83 192.76 79.83Zm-13.11-259.48Z"/></svg>
                                                    @endif
                                            @endif
                                        </div>

                                        <button onclick="event.stopPropagation(); document.getElementById('menu_rutina_{{ $rutina->id }}').showModal()">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" class="fill-[#306067] dark:fill-[#CCE2E5]"><path d="M480.12-149q-34.55 0-59.13-24.55-24.58-24.56-24.58-59.04 0-34.58 24.56-59.2 24.55-24.62 59.03-24.62 34.67 0 59.13 24.59 24.46 24.6 24.46 59.13 0 34.54-24.46 59.11Q514.67-149 480.12-149Zm0-247.41q-34.55 0-59.13-24.56-24.58-24.55-24.58-59.03 0-34.67 24.56-59.13 24.55-24.46 59.03-24.46 34.67 0 59.13 24.46t24.46 59.01q0 34.55-24.46 59.13-24.46 24.58-59.01 24.58Zm0-247.18q-34.55 0-59.13-24.64-24.58-24.64-24.58-59.25t24.56-59.06Q445.52-811 480-811q34.67 0 59.13 24.46 24.46 24.45 24.46 59.06t-24.46 59.25q-24.46 24.64-59.01 24.64Z"/></svg>
                                        </button>
                                    </div>
                                    <span class="text-[#37A0AF] dark:text-[#37A0AF] text-sm">{{ $rutina->type?->name ?? 'No definido' }} · {{ $rutina->routineNeed?->name ?? 'No definido' }}</span>
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
                                                class="object-contain w-16 h-16 rounded-md"
                                            >
                                        @empty
                                            <p class="text-md text-[#CCE2E5]">
                                                No hay productos en esta rutina.
                                            </p>
                                        @endforelse
                                        @if($remaining > 0)
                                            <p class=" flex items-center justify-center text-[#2A4043] dark:text-[#E9E5E3] text-md font-black">
                                                +{{ $remaining }}
                                            </p>
                                        @endif
                                    </div>
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#306067">
                                        <path d="M496.35-480 344.17-632.17Q331.5-644.85 331.5-664t12.67-31.83Q356.85-708.5 376-708.5t31.83 12.67l183.76 183.76q6.71 6.72 9.81 14.92 3.1 8.19 3.1 17.15 0 8.96-3.1 17.15-3.1 8.2-9.81 14.92L407.83-264.17Q395.15-251.5 376-251.5t-31.83-12.67Q331.5-276.85 331.5-296t12.67-31.83L496.35-480Z"/>
                                    </svg>
                                </div>
                            </article>

                        <dialog id="menu_rutina_{{ $rutina->id }}" class="modal modal-bottom">
                                        <div class="modal-box bg-white dark:bg-[#2A4043]">
                                            <a href="" class=" btn w-full inline-flex border-0 bg-[#CCE2E5] px-6 py-3 rounded-xl font-semiboldbold transition-all duration-300 items-center justify-between gap-2 text-sm font-bold">
                                                <p class="text-[#306067]">Compartir Rutina</p>
                                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#306067">
                                                    <path d="M680.94-71.87q-53.09 0-90.24-37.09-37.16-37.09-37.16-90.08 0-5.76 2.76-25.85L283.43-383.87q-16.71 14.76-38.17 23.14t-45.98 8.38q-53.09 0-90.25-37.21-37.16-37.22-37.16-90.38 0-53.17 37.16-90.44 37.16-37.27 90.25-37.27 24.48 0 46.2 8.5 21.72 8.5 38.67 23.5l271.92-158.5q-1.77-6.52-2.15-12.9-.38-6.38-.38-13.67 0-53.09 37.17-90.25t90.26-37.16q53.1 0 90.25 37.17 37.15 37.16 37.15 90.26 0 53.09-37.16 90.24-37.16 37.16-90.25 37.16-25.05 0-46.96-8.74t-38.87-24.22L324.17-508.72q2 7.25 2.5 13.99.5 6.73.5 14.85t-.62 15.1q-.62 6.98-2.62 14.21l270.72 157.55q16.96-15.72 39.02-24.7 22.07-8.98 47.29-8.98 53.09 0 90.25 37.22t37.16 90.38q0 53.17-37.17 90.2-37.16 37.03-90.26 37.03Zm-.13-88.61q16.43 0 27.69-11.16 11.26-11.16 11.26-27.66t-11.22-27.65q-11.23-11.14-27.82-11.14-16.39 0-27.48 11.26t-11.09 27.55q0 16.28 11.12 27.54 11.11 11.26 27.54 11.26ZM199.3-440.96q16.5 0 27.88-11.21 11.39-11.21 11.39-27.78t-11.39-27.83q-11.38-11.26-27.88-11.26t-27.66 11.21q-11.16 11.21-11.16 27.78t11.16 27.83q11.16 11.26 27.66 11.26Zm481.66-280.95q16.28 0 27.42-11.12 11.14-11.11 11.14-27.54t-11.11-27.69q-11.12-11.26-27.55-11.26t-27.69 11.22q-11.26 11.23-11.26 27.82 0 16.39 11.38 27.48t27.67 11.09Zm.24 522.63ZM199.52-480Zm481.44-280.72Z"/>
                                                </svg>
                                            </a>
                                            <a href="{{ route('routines.edit', $rutina) }}" class="mt-3 btn w-full inline-flex border-0 bg-[#CCE2E5] px-6 py-3 rounded-xl font-semiboldbold transition-all duration-300 items-center justify-between gap-2 text-sm font-bold">
                                                <p class="text-[#306067] ">Editar Rutina</p>
                                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#306067"><path d="M202.63-202.87h57.24l374.74-374.74-56.76-57-375.22 375.22v56.52Zm-45.26 91q-19.15 0-32.33-13.17-13.17-13.18-13.17-32.33v-102.26q0-18.15 6.84-34.69 6.83-16.53 19.51-29.2l501.17-500.41q12.48-11.72 27.7-17.96 15.21-6.24 31.93-6.24 16.48 0 32.2 6.24 15.71 6.24 27.67 18.72l65.28 65.56q12.48 11.72 18.34 27.56 5.86 15.83 5.86 31.79 0 16.72-5.86 32.05-5.86 15.34-18.34 27.82L324-138.22q-12.67 12.68-29.21 19.51-16.53 6.84-34.68 6.84H157.37Zm597.37-586.39-56.24-56.48 56.24 56.48Zm-148.89 92.41-28-28.76 56.76 57-28.76-28.24Z"/></svg>
                                            </a>
                                            <form action="{{ route('routines.destroy', $rutina) }}" method="POST" onsubmit="return confirm('¿Seguro que querés eliminar esta rutina? Esta acción no se puede deshacer.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="mt-3 btn w-full inline-flex border-0 bg-[#741919] px-6 py-3 rounded-xl font-semiboldbold transition-all duration-300 items-center justify-between gap-2 text-sm font-bold"">
                                                    <p class="font-semibold text-white">Eliminar Rutina</p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#CCE2E5"><path d="M277.37-111.87q-37.78 0-64.39-26.61t-26.61-64.39v-514.5q-19.15 0-32.33-13.17-13.17-13.18-13.17-32.33t13.17-32.33q13.18-13.17 32.33-13.17H354.5q0-19.15 13.17-32.33 13.18-13.17 32.33-13.17h159.52q19.15 0 32.33 13.17 13.17 13.18 13.17 32.33h168.61q19.15 0 32.33 13.17 13.17 13.18 13.17 32.33t-13.17 32.33q-13.18 13.17-32.33 13.17v514.5q0 37.78-26.61 64.39t-64.39 26.61H277.37Zm405.26-605.5H277.37v514.5h405.26v-514.5ZM398.57-280.24q17.95 0 30.29-12.34 12.34-12.33 12.34-30.29v-274.74q0-17.96-12.34-30.29-12.34-12.34-30.29-12.34-17.96 0-30.42 12.34-12.45 12.33-12.45 30.29v274.74q0 17.96 12.45 30.29 12.46 12.34 30.42 12.34Zm163.1 0q17.96 0 30.3-12.34 12.33-12.33 12.33-30.29v-274.74q0-17.96-12.33-30.29-12.34-12.34-30.3-12.34-17.95 0-30.41 12.34-12.46 12.33-12.46 30.29v274.74q0 17.96 12.46 30.29 12.46 12.34 30.41 12.34Zm-284.3-437.13v514.5-514.5Z"/></svg>
                                                </button>
                                            </form>
                                        </div>
                                        <form method="dialog" class="modal-backdrop">
                                            <button>close</button>
                                        </form>
                            </dialog>
