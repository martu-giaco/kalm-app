<div class="flex items-stretch justify-between" id="product_container_{{ $product->id }}">
    <a href="{{ route('products.show', $product) }}" class="group block">
                                <div
                                    class="flex px-2 items-center gap-4 py-3 transition-shadow border-b-[1px] border-gray-200 bg-transparent">
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
                                        <div class="flex items-center w-full justify-between gap-3">
                                                <h2 class="text-md font-semibold text-[#2A4043] dark:text-[#CCE2E5]">{{ $product->name }}</h2>
                                        </div>

                                        <div class="text-xs text-[#2A4043] dark:text-[#CCE2E5] gap-2">
                                            <h3 class="text-[13px] text-[#37A0AF] truncate">
                                                {{ $product->brand->name ?? '-' }}
                                            </h3>
                                            <div class="flex flex-wrap gap-2 my-3">
                                                <button class="text-[10px] text-center inline-block text-white truncate bg-[#37A0AF] dark:bg-[#CCE2E5] dark:text-[#37A0AF] px-2 py-1 rounded-xl">
                                                    ✨{{ $product->type->name ?? '-' }}
                                                </button>
                                                <button class="text-[10px] text-center inline-block text-white truncate bg-[#37A0AF] dark:bg-[#CCE2E5] dark:text-[#37A0AF] px-2 py-1 rounded-xl">
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
    <div class="bg-[#430000] flex items-center text-white px-3 py-1 transition cursor-pointer">
        <button type="button" onclick="removeProduct({{ $product->id }}); return false;">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#fff">
                <path d="M280-120q-33 0-56.5-23.5T200-200v-520q-17 0-28.5-11.5T160-760q0-17 11.5-28.5T200-800h160q0-17 11.5-28.5T400-840h160q17 0 28.5 11.5T600-800h160q17 0 28.5 11.5T800-760q0 17-11.5 28.5T760-720v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM428.5-291.5Q440-303 440-320v-280q0-17-11.5-28.5T400-640q-17 0-28.5 11.5T360-600v280q0 17 11.5 28.5T400-280q17 0 28.5-11.5Zm160 0Q600-303 600-320v-280q0-17-11.5-28.5T560-640q-17 0-28.5 11.5T520-600v280q0 17 11.5 28.5T560-280q17 0 28.5-11.5ZM280-720v520-520Z"/>
            </svg>
        </button>
        <input type="hidden" name="products[]" value="{{ $product->id }}" id="product_{{ $product->id }}">
    </div>
</div>

<script>
    // Función para eliminar productos
        function removeProduct(productId) {
            const container = document.getElementById('product_container_' + productId);
            const input = document.getElementById('product_' + productId);

            if (container && input) {
                container.remove();
                input.remove();
            }
        }
</script>
