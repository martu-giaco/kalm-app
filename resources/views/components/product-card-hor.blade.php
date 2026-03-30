<a href="{{ route('products.show', $product) }}" class="group block">
                                <div
                                    class="flex px-5 items-center gap-4 py-2 transition-shadow bg-white">
                                    {{-- Imagen redonda --}}
                                    <div class="flex-shrink-0 rounded-md w-20 h-20 overflow-hidden bg-[var(--kalm-light)]">
                                        @php
                                            $img = $product->image ?? null;

                                            if ($img && Str::startsWith($img, ['http://', 'https://'])) {
                                                $imgUrl = $img; // URL absoluta
                                            } elseif ($img) {
                                                $imgUrl = asset($img);
                                            } else {
                                                $imgUrl = asset('images/default.jpg'); // fallback
                                            }
                                        @endphp

                                        <img src="{{ $imgUrl }}" alt="{{ $product->name }}" class="w-full h-full object-cover"
                                            loading="lazy">
                                    </div>

                                    {{-- Info --}}
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between gap-3">

                                            <div class="flex w-full justify-between items-end">
                                                <h2 class="text-md font-semibold text-[#2A4043] truncate">{{ $product->name }}</h2>
                                                <button type="button"
                                                    class="p-2 transition bg-white rounded-full hover:scale-105"
                                                    title="Marcar favorito" onclick="toggleFavorito({{ $product->id }}, this)">
                                                    <label class="swap">
                                                        <!-- this hidden checkbox controls the state -->
                                                        <input type="checkbox" />
                                                        <!-- guardado icon -->
                                                        <svg class="swap-on fill-[#430000]" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#430000"><path d="M479.76-139.83q-16.15 0-32.44-5.83-16.3-5.84-28.97-18.27l-69.48-63.48Q243.35-323.7 157.61-420.03 71.87-516.37 71.87-634q0-97.59 65.15-162.98 65.15-65.39 162.74-65.39 52.52 0 99.28 21.42 46.76 21.43 80.72 59.47 33.96-38.04 80.72-59.47 46.76-21.42 99.28-21.42 97.59 0 163.1 65.39 65.51 65.39 65.51 162.98 0 117.63-85.6 214.47-85.6 96.83-193.12 193.36l-68.24 62.47q-12.67 12.44-29.08 18.16-16.42 5.71-32.57 5.71Z"/></svg>
                                                        <!-- guardar icon -->
                                                        <svg class="swap-off fill-[#430000]" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#430000"><path d="M479.76-139.83q-16.15 0-32.44-5.83-16.3-5.84-28.97-18.27l-69.48-63.48Q243.35-323.7 157.61-420.03 71.87-516.37 71.87-634q0-97.58 65.15-162.97 65.15-65.4 162.74-65.4 52.52 0 99.28 21.42 46.76 21.43 80.72 59.47 33.96-38.04 80.72-59.47 46.76-21.42 99.28-21.42 97.68 0 163.14 65.4 65.47 65.39 65.47 162.97 0 117.63-85.6 214.47-85.6 96.83-193.12 193.36l-68.24 62.47q-12.67 12.44-29.08 18.16-16.42 5.71-32.57 5.71ZM440.09-688.8q-27.57-39.57-60.93-61.07t-79.33-21.5q-58.7 0-97.83 39.16-39.13 39.17-39.13 98.21 0 51.54 36.64 109.52 36.64 57.99 87.64 112.5 51 54.52 104.97 102.09 53.97 47.58 87.64 78.3 33.76-31 87.83-78.55 54.07-47.56 105.16-102.04 51.1-54.49 87.86-112.28 36.76-57.78 36.76-109.54 0-59.04-39.28-98.21-39.29-39.16-98.21-39.16-46.16 0-79.4 21.5-33.24 21.5-60.81 61.07-7.31 10.71-17.75 16.07-10.44 5.36-22.16 5.36t-22.07-5.36q-10.36-5.36-17.6-16.07ZM480-501.48Z"/></svg>
                                                    </label>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="text-xs text-[#2A4043] gap-2">
                                            <h3 class="text-[13px] text-[#37A0AF] truncate">
                                                {{ $product->brand->name ?? '-' }}
                                            </h3>
                                            <div class="flex flex-wrap gap-2 my-3">
                                                <button class="text-[10px] inline-block text-white truncate bg-[#37A0AF] px-2 py-1 rounded-xl">
                                                    ✨{{ $product->type->name ?? '-' }}
                                                </button>
                                                <button class="text-[10px] inline-block text-white truncate bg-[#37A0AF] px-2 py-1 rounded-xl">
                                                    {{ $product->category->name ?? '-' }}
                                                </button>
                                            </div>
                                        </div>

                                        @if(!empty($product->resolved_tag_text))
                                            <div class="mt-2">
                                                <span
                                                    class="inline-block px-2 py-0.5 text-xs font-semibold rounded {{ $product->tag_class ?? 'bg-teal-100 text-teal-800' }}">
                                                    {{ $product->resolved_tag_text }}
                                                </span>
                                            </div>
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
