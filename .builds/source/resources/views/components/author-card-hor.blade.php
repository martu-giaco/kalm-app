<div class="group block px-2">
    <div class="flex p-5 items-center justify-start gap-4 transition-shadow shadow-lg rounded-xl w-full bg-white">
        <div class="flex items-center gap-2">
            {{-- Imagen redonda --}}
            <div class="flex-shrink-0 rounded-full w-20 h-20 overflow-hidden bg-[var(--kalm-light)]">
                <img src="{{ asset('images/default.jpg') }}" alt="{{ $blog->author }}" class="w-full h-full object-cover"loading="lazy">
            </div>

            {{-- Info --}}
            <div class="flex-1 min-w-0">
                <div class="flex items-center justify-between gap-3">
                    <div class="flex w-full justify-between items-end">
                        <h2 class="text-lg font-semibold text-[#2A4043] truncate">{{ $blog->author }}</h2>
                    </div>
                </div>

                <div class="text-xs text-[#2A4043] gap-2">
                    <p class="text-[13px] text-[#aad0d4] font-bold truncate">{{ $blog->credentials }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

