<div class="p-4 mb-4 bg-white dark:bg-[#306067] rounded-lg shadow-md border-l-4 border-[#37A0AF]">
    <x-product-card-hor :product="$product"/>
    <div class="mt-4">
            <div class="flex justify-between items-center gap-2 mb-2">
                <div class="flex items-center gap-2 mb-2">
                    <img src="{{ $review->user->avatar ? asset('storage/' . $review->user->avatar) : asset('images/pfp.svg') }}"
                    alt="{{ $review->user->name }}" class="object-cover w-10 h-10 rounded-full">
                    <div>
                        <p class="font-bold dark:text-[#CCE2E5] text-[#306067]">{{ $review->user->name }}</p>
                        <div class="flex items-center gap-1 mb-2">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $review->rating)
                                    <span class="text-yellow-400">★</span>
                                @else
                                    <span class="text-gray-300">★</span>
                                @endif
                            @endfor
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <p class="text-xs text-[#CCE2E5]">{{ $review->created_at->diffForHumans() }}</p>
                    <button onclick="event.stopPropagation(); document.getElementById('menu_review_{{ $review->id }}').showModal()">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#306067"  class="fill-[#306067] dark:fill-[#CCE2E5]""><path d="M480.12-149q-34.55 0-59.13-24.55-24.58-24.56-24.58-59.04 0-34.58 24.56-59.2 24.55-24.62 59.03-24.62 34.67 0 59.13 24.59 24.46 24.6 24.46 59.13 0 34.54-24.46 59.11Q514.67-149 480.12-149Zm0-247.41q-34.55 0-59.13-24.56-24.58-24.55-24.58-59.03 0-34.67 24.56-59.13 24.55-24.46 59.03-24.46 34.67 0 59.13 24.46t24.46 59.01q0 34.55-24.46 59.13-24.46 24.58-59.01 24.58Zm0-247.18q-34.55 0-59.13-24.64-24.58-24.64-24.58-59.25t24.56-59.06Q445.52-811 480-811q34.67 0 59.13 24.46 24.46 24.45 24.46 59.06t-24.46 59.25q-24.46 24.64-59.01 24.64Z"/></svg>
                    </button>
                </div>
            </div>
            <p class="text-sm text-wrap overflow-hidden text-clip dark:text-[#E9E5E3] text-[#306067]">{{ $review->comment }}</p>
    </div>
</div>


@if (auth()->check() && (auth()->id() === $review->user_id || auth()->user()->role === 'admin'))
<dialog id="menu_review_{{ $review->id }}" class="modal modal-bottom">
                                        <div class="modal-box bg-white dark:bg-[#2A4043]">
                                            <a href="{{ route('reviews.edit', $review) }}" class=" btn w-full inline-flex border-0 bg-[#CCE2E5] px-6 py-3 rounded-xl font-semiboldbold transition-all duration-300 items-center justify-between gap-2 text-sm font-bold">
                                                <p class="text-[#306067]">Editar Reseña</p>
                                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#306067"><path d="M202.63-202.87h57.24l374.74-374.74-56.76-57-375.22 375.22v56.52Zm-45.26 91q-19.15 0-32.33-13.17-13.17-13.18-13.17-32.33v-102.26q0-18.15 6.84-34.69 6.83-16.53 19.51-29.2l501.17-500.41q12.48-11.72 27.7-17.96 15.21-6.24 31.93-6.24 16.48 0 32.2 6.24 15.71 6.24 27.67 18.72l65.28 65.56q12.48 11.72 18.34 27.56 5.86 15.83 5.86 31.79 0 16.72-5.86 32.05-5.86 15.34-18.34 27.82L324-138.22q-12.67 12.68-29.21 19.51-16.53 6.84-34.68 6.84H157.37Zm597.37-586.39-56.24-56.48 56.24 56.48Zm-148.89 92.41-28-28.76 56.76 57-28.76-28.24Z"/></svg>
                                            </a>
                                            <form action="{{ route('reviews.destroy', [$review->product->id, $review->id]) }}" method="POST" onsubmit="return confirm('¿Seguro que querés eliminar esta reseña? Esta acción no se puede deshacer.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="mt-3 btn w-full inline-flex border-0 bg-[#741919] px-6 py-3 rounded-xl font-semiboldbold transition-all duration-300 items-center justify-between gap-2 text-sm font-bold"">
                                                    <p class="font-semibold text-white">Eliminar Reseña</p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#CCE2E5"><path d="M277.37-111.87q-37.78 0-64.39-26.61t-26.61-64.39v-514.5q-19.15 0-32.33-13.17-13.17-13.18-13.17-32.33t13.17-32.33q13.18-13.17 32.33-13.17H354.5q0-19.15 13.17-32.33 13.18-13.17 32.33-13.17h159.52q19.15 0 32.33 13.17 13.17 13.18 13.17 32.33h168.61q19.15 0 32.33 13.17 13.17 13.18 13.17 32.33t-13.17 32.33q-13.18 13.17-32.33 13.17v514.5q0 37.78-26.61 64.39t-64.39 26.61H277.37Zm405.26-605.5H277.37v514.5h405.26v-514.5ZM398.57-280.24q17.95 0 30.29-12.34 12.34-12.33 12.34-30.29v-274.74q0-17.96-12.34-30.29-12.34-12.34-30.29-12.34-17.96 0-30.42 12.34-12.45 12.33-12.45 30.29v274.74q0 17.96 12.45 30.29 12.46 12.34 30.42 12.34Zm163.1 0q17.96 0 30.3-12.34 12.33-12.33 12.33-30.29v-274.74q0-17.96-12.33-30.29-12.34-12.34-30.3-12.34-17.95 0-30.41 12.34-12.46 12.33-12.46 30.29v274.74q0 17.96 12.46 30.29 12.46 12.34 30.41 12.34Zm-284.3-437.13v514.5-514.5Z"/></svg>
                                                </button>
                                            </form>
                                        </div>
                                        <form method="dialog" class="modal-backdrop">
                                            <button>close</button>
                                        </form>
                            </dialog>
@endif
