{{-- resources/views/products/index.blade.php --}}
<x-layout :title="$category->name ?? 'Productos'">
    <div class="max-w-6xl mx-auto px-4 py-8">
        <header class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold">
                    {{ $category->name ?? 'Productos' }}
                </h1>
                @if(isset($category->description) && $category->description)
                    <p class="text-sm text-gray-600 mt-1">{{ $category->description }}</p>
                @endif
            </div>

            <div>
                <span class="text-sm text-gray-500">
                    {{ $products->total() ?? 0 }} resultado(s)
                </span>
            </div>
        </header>

        @if($products->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($products as $product)
                    <article class="bg-white rounded-lg shadow p-4">
                        <a href="{{ route('products.show', $product->id ?? $product->slug) ?? '#' }}">
                            <div class="w-full h-44 mb-3 overflow-hidden rounded">
                                @if(!empty($product->image))
                                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                @else
                                    <img src="{{ asset('images/product-placeholder.png') }}" alt="placeholder" class="w-full h-full object-cover">
                                @endif
                            </div>

                            <h2 class="text-lg font-medium mb-1">{{ $product->name }}</h2>
                        </a>

                        @if(isset($product->short_description))
                            <p class="text-sm text-gray-600 mb-3">{{ \Illuminate\Support\Str::limit($product->short_description, 100) }}</p>
                        @endif

                        <div class="flex items-center justify-between mt-3">
                            @if(isset($product->price))
                                <div class="text-lg font-semibold">${{ number_format($product->price, 2, ',', '.') }}</div>
                            @endif

                            <a href="{{ route('products.show', $product->id ?? $product->slug) ?? '#' }}" class="text-sm btn-primary px-3 py-1 rounded">Ver</a>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $products->links() }}
            </div>
        @else
            <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 p-4 rounded">
                No se encontraron productos en esta categoría.
            </div>
        @endif
    </div>
</x-layout>
