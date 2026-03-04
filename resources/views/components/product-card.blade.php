<a href="{{ route('products.show', $product->id) }}" class="flex-shrink-0 w-40 md:w-44 group">
                            <div class="relative overflow-hidden transition duration-300 bg-white shadow-md rounded-xl hover:shadow-lg">

                                {{-- Imagen del producto --}}
                                <div class="w-full h-40 overflow-hidden">
                                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                                        class="object-cover w-full h-full transition duration-300 group-hover:scale-105">
                                </div>

                                {{-- Botón quitar de favoritos --}}
                                <button type="button"
                                    class="absolute p-2 transition bg-white rounded-full top-2 right-2 hover:scale-105"
                                    id="favoriteBtn" title="Marcar favorito"
                        onclick="event.preventDefault(); event.stopPropagation(); toggleFavorito({{ $product->id }}, this); return false;">
                                    <label class="swap" id="swapLabel" style="--is-checked: {{ $product->isFavorito ? 1 : 0 }};">
<input type="checkbox" {{ $product->isFavorito ? 'checked' : '' }} />
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
                                        <button class="text-[10px] mt-2 w-20 inline-block text-white truncate bg-[#37A0AF] px-2 py-1 rounded-xl">
                                            ✨{{ $product->type->name }}
                                        </button>
                                    @endif
                                </div>

                            </div>
                        </a>

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

    @once
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.fav-form').forEach(form => {
                const button = form.querySelector('button');
                const icon = button.querySelector('.heart-icon');

                button.addEventListener('click', async (e) => {
                    e.preventDefault();

                    try {
                        const token = form.querySelector('input[name="_token"]').value;

                        const response = await fetch(form.action, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': token,
                                'Accept': 'application/json'
                            }
                        });

                        const data = await response.json();

                        // Actualiza solo el SVG
                        if (data.favorito) {
                            icon.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#EF4444" stroke="none" class="w-6 h-6"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41 0.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>';
                        } else {
                            icon.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#9CA3AF" stroke-width="2" class="w-6 h-6"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41 0.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>';
                        }

                    } catch (error) {
                        console.error('Error al actualizar favorito:', error);
                    }
                });
            });
        });
    </script>
@endonce
