<a href="{{ route('brands.show', $brand) }}" class="group block px-2">
    <div class="flex p-5 items-center justify-between gap-4 transition-shadow shadow-lg rounded-xl w-full bg-white">
        <div class="flex items-center gap-2">
            {{-- Imagen redonda --}}
            <div class="flex-shrink-0 rounded-full w-20 h-20 overflow-hidden bg-[var(--kalm-light)]">
                @php
                $img = $brand->logo ?? null;

                if ($img && (str_starts_with($img, 'http://') || str_starts_with($img, 'https://'))) {
                    $imgUrl = $img; // absolute URL
                } elseif ($img && str_starts_with($img, 'images/')) {
                    $imgUrl = asset($img); // seeded public images
                } elseif ($img) {
                    $imgUrl = asset('storage/' . $img); // uploaded to storage
                } else {
                    $imgUrl = asset('images/default.jpg'); // fallback
                }
                @endphp

                <img src="{{ $imgUrl }}" alt="{{ $brand->name }}" class="w-full h-full object-cover"loading="lazy">
            </div>

            {{-- Info --}}
            <div class="flex-1 min-w-0">
                <div class="flex items-center justify-between gap-3">
                    <div class="flex w-full justify-between items-end">
                        <h2 class="text-lg font-semibold text-[#2A4043] truncate">{{ $brand->name }}</h2>
                    </div>
                </div>

                <div class="text-xs text-[#2A4043] gap-2">
                    <p class="text-[13px] text-[#aad0d4] font-bold truncate">{{ $brand->products_count }} productos</p>
                </div>
            </div>
        </div>

        <div>
            <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#2A4043"><path d="M579-480 285-774q-15-15-14.5-35.5T286-845q15-15 35.5-15t35.5 15l307 308q12 12 18 27t6 30q0 15-6 30t-18 27L356-115q-15 15-35 14.5T286-116q-15-15-15-35.5t15-35.5l293-293Z"/></svg>
        </div>
    </div>
</a>

