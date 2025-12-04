{{-- views\products\byCategory.blade.php --}}
<x-layout :title="$category->name">
    <section class="px-5 rounded-t-3xl bg-white min-h-screen">

        {{-- Título de la Categoría --}}
        <h1 class="text-3xl font-bold text-[var(--kalm-dark)] mb-6 border-b pb-3 border-gray-100">
            {{ $category->name }}
        </h1>

        @if($products->isEmpty())
            <p class="text-[var(--kalm-text)] text-lg py-10 text-center">
                No hemos encontrado productos en esta categoría.
            </p>
        @else
            {{-- Contenedor de productos en dos columnas --}}
            <div class="grid grid-cols-2 md:grid-cols-2 gap-4 pb-20">
                @foreach($products as $product)
                    <a href="{{ route('products.show', $product->id) }}" class="group">
                        <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition duration-300">

                            {{-- Imagen del producto --}}
                            <div class="w-full h-40 overflow-hidden">
                                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                                     class="w-full h-full object-cover transition duration-300 group-hover:scale-105">
                            </div>

                            {{-- Información simplificada --}}
                            <div class="p-3 flex flex-col gap-1">
                                <h3 class="text-sm font-semibold text-[var(--kalm-dark)] mb-1 truncate">
                                    {{ $product->name }}
                                </h3>

                                @if(!empty($product->brand?->name))
                                    <p class="text-[10px] text-gray-500 truncate">Marca: {{ $product->brand->name }}</p>
                                @endif
                                @if(!empty($product->type?->name))
                                    <p class="text-[10px] text-gray-500 truncate">Tipo: {{ $product->type->name }}</p>
                                @endif
                                @if(!empty($product->category?->name))
                                    <p class="text-[10px] text-gray-500 truncate">Categoría: {{ $product->category->name }}</p>
                                @endif
                            </div>

                        </div>
                    </a>
                @endforeach
            </div>
        @endif

    </section>
</x-layout>
