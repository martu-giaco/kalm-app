{{-- resources/views/products/index.blade.php --}}
<x-layout :title="$category->name ?? 'Productos'">
    <div class="max-w-6xl px-4 py-8 mx-auto">
        <header class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-semibold">
                    {{ $category->name ?? 'Productos' }}
                </h1>
                @if(isset($category->description) && $category->description)
                    <p class="mt-1 text-sm text-gray-600">{{ $category->description }}</p>
                @endif
            </div>

            <div>
                <span class="text-sm text-gray-500">
                    {{ $products->total() ?? 0 }} resultado(s)
                </span>
            </div>
        </header>

        @if($products->count())
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($products as $product)
                    <article class="p-4 bg-white rounded-lg shadow">
                        <a href="{{ route('products.show', $product->id ?? $product->slug) ?? '#' }}">
                            <div class="w-full mb-3 overflow-hidden rounded h-44">
                                @if(!empty($product->image))
                                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="object-cover w-full h-full">
                                @else
                                    <img src="{{ asset('images/product-placeholder.png') }}" alt="placeholder" class="object-cover w-full h-full">
                                @endif
                            </div>

                            <h2 class="mb-1 text-lg font-medium">{{ $product->name }}</h2>
                        </a>

                        @if(isset($product->short_description))
                            <p class="mb-3 text-sm text-gray-600">{{ \Illuminate\Support\Str::limit($product->short_description, 100) }}</p>
                        @endif

                        <div class="flex items-center justify-between mt-3">
                            @if(isset($product->price))
                                <div class="text-lg font-semibold">${{ number_format($product->price, 2, ',', '.') }}</div>
                            @endif

                            <a href="{{ route('products.show', $product->id ?? $product->slug) ?? '#' }}" class="px-3 py-1 text-sm rounded btn-primary">Ver</a>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $products->links() }}
            </div>
        @else
            <div class="p-4 text-yellow-800 border border-yellow-200 rounded bg-yellow-50">
                No se encontraron productos en esta categoría.
            </div>
        @endif
    </div>
</x-layout>
