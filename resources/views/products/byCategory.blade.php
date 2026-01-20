{{-- views\products\byCategory.blade.php --}}
<x-layout :title="$category->name">
    <section class="min-h-screen p-5 rounded-t-3xl">

        {{-- Título de la Categoría --}}
        <h1 class="text-3xl font-bold text-[var(--kalm-dark)] mb-4 border-b pb-3 border-gray-100">
            {{ $category->name }}
        </h1>

        @if($products->isEmpty())
            <p class="text-[var(--kalm-text)] text-lg py-10 text-center">
                No hemos encontrado productos en esta categoría.
            </p>
        @else
            {{-- Contenedor de productos en dos columnas --}}
            <div class="grid grid-cols-2 gap-4 pb-20 md:grid-cols-2">
                @foreach($products as $product)
                    <a href="{{ route('products.show', $product->id) }}" class="group">
                        <div class="overflow-hidden transition duration-300 bg-white shadow-md rounded-xl hover:shadow-lg">

                            {{-- Imagen del producto --}}
                            <div class="w-full h-40 overflow-hidden">
                                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                                     class="object-cover w-full h-full transition duration-300 group-hover:scale-105">
                            </div>

                            {{-- Información simplificada --}}
                            <div class="flex flex-col gap-1 p-3">
                                <h3 class="text-sm font-semibold text-[var(--kalm-dark)] mb-1 truncate">
                                    {{ $product->name }}
                                </h3>

                                @if(!empty($product->brand?->name))
                                    <p class="text-[10px] text-gray-500 truncate">{{ $product->brand->name }}</p>
                                @endif
                                @if(!empty($product->type?->name))
                                    <p class="text-[10px] text-gray-500 truncate">{{ $product->type->name }}</p>
                                @endif
                                @if(!empty($product->category?->name))
                                    <p class="text-[10px] text-gray-500 truncate">{{ $product->category->name }}</p>
                                @endif
                            </div>

                        </div>
                    </a>
                @endforeach
            </div>
        @endif

    </section>
</x-layout>
