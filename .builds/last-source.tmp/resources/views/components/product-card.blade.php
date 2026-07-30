<a href="{{ route('products.show', $product->id) }}" class="flex-shrink-0 w-40 md:w-44 group">
                            <div class="relative overflow-hidden transition duration-300 bg-white shadow-md rounded-xl hover:shadow-lg">

                                {{-- Imagen del producto --}}
                                <div class="w-full h-40 overflow-hidden">
                                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                                        class="object-cover w-full h-full transition duration-300 group-hover:scale-105">
                                </div>



                                <button type="button"
                                    class="absolute p-2 transition rounded-full top-2 right-2 hover:scale-105"
                                    title="Marcar favorito"
                        onclick="event.preventDefault(); event.stopPropagation(); toggleFavorito({{ $product->id }}, this); return false;">
                                    <label class="swap" style="--is-checked: {{ $product->isFavorito ? 1 : 0 }};">
                                        <input type="checkbox" {{ $product->isFavorito ? 'checked' : '' }} />
                                        <!-- Corazón lleno -->
                                        <svg class="swap-on fill-[#430000]" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 -960 960 960" width="24px">
                                            <path d="M479.76-139.83q-16.15 0-32.44-5.83-16.3-5.84-28.97-18.27l-69.48-63.48Q243.35-323.7 157.61-420.03 71.87-516.37 71.87-634q0-97.59 65.15-162.98 65.15-65.39 162.74-65.39 52.52 0 99.28 21.42 46.76 21.43 80.72 59.47 33.96-38.04 80.72-59.47 46.76-21.42 99.28-21.42 97.59 0 163.1 65.39 65.51 65.39 65.51 162.98 0 117.63-85.6 214.47-85.6 96.83-193.12 193.36l-68.24 62.47q-12.67 12.44-29.08 18.16-16.42 5.71-32.57 5.71Z"/>
                                        </svg>
                                        <!-- Corazón vacío -->
                                        <svg class="swap-off fill-[#430000]" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 -960 960 960" width="24px">
                                            <path d="M451.5-152q-14.5-5-25.5-16l-69-63q-106-97-191.5-192.5T80-634q0-94 63-157t157-63q53 0 100 22.5t80 61.5q33-39 80-61.5T660-854q94 0 157 63t63 157q0 115-85 211T602-230l-68 62q-11 11-25.5 16t-28.5 5q-14 0-28.5-5ZM442-690q-29-41-62-62.5T300-774q-60 0-100 40t-40 100q0 52 37 110.5T285.5-410q51.5 55 106 103t88.5 79q34-31 88.5-79t106-103Q726-465 763-523.5T800-634q0-60-40-100t-100-40q-47 0-80 21.5T518-690q-7 10-17 15t-21 5q-11 0-21-5t-17-15Zm38 189Z"/>
                                        </svg>
                                    </label>
                                </button>

                                {{-- Info simplificada --}}
                                <div class="flex flex-col p-3">
                                    <h3 class="text-sm font-semibold text-[#2A4043] truncate">
                                        {{ $product->name }}
                                    </h3>

                                    @if (!empty($product->brand?->name))
                                        <h3 class="text-[13px] text-[#37A0AF] truncate">
                                            {{ $product->brand->name }}</h3>
                                    @endif
                                    @if (!empty($product->type?->name))
                                        <button class="text-[10px] mt-2 w-20 text-center inline-block text-white truncate bg-[#37A0AF] px-2 py-1 rounded-xl">
                                            ✨{{ $product->type->name }}
                                        </button>
                                    @endif
                                </div>

                            </div>
                        </a>

    <script>
        let isProcessing = false;

        function toggleFavorito(productId, btn) {

            if (isProcessing) return;
            isProcessing = true;

            const checkbox = btn.querySelector('input[type="checkbox"]');
            const initialState = checkbox.checked;

            // Optimistic UI
            checkbox.checked = !initialState;

            fetch(`/productos/${productId}/favorito`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(res => {
                if (!res.ok) throw new Error('Error del servidor');
                return res.json();
            })
            .then(data => {

                checkbox.checked = data.favorito;

                // 👉 Si estamos en la vista de favoritos y se quitó
                if (!data.favorito && window.location.pathname.includes('favoritos')) {

                    const card = btn.closest('a');
                    card.style.transition = 'all 0.3s ease';
                    card.style.opacity = '0';
                    card.style.transform = 'scale(0.95)';

                    setTimeout(() => {
                        card.remove();
                    }, 300);
                }
            })
            .catch(err => {
                checkbox.checked = initialState;
                alert('Error al actualizar favorito');
            })
            .finally(() => {
                isProcessing = false;
            });
        }
    </script>
