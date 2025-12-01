
<div class="flex items-center border-b border-gray-200 py-3">
    {{-- Imagen del producto --}}
    <div class="flex-shrink-0 w-20 h-20 rounded-lg overflow-hidden bg-[var(--kalm-light)]">
        <img src="{{ asset('images/products/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
    </div>

    {{-- Info del producto --}}
    <div class="ml-4 flex-1">
        <h3 class="text-sm font-medium text-[var(--kalm-dark)]">{{ $product->name }}</h3>
        <p class="text-xs text-[var(--kalm-text)] mt-1">{{ $product->brand->name }}</p>
        @if(isset($product->resolved_tag_text))
            <span class="inline-block mt-2 px-2 py-0.5 text-xs font-semibold rounded {{ $product->tag_class ?? 'bg-teal-100 text-teal-800' }}">
                {{ $product->resolved_tag_text }}
            </span>
        @endif
    </div>
</div>
