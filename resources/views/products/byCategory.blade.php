<x-layout :title="$category->name">
    <section class="h-full px-5 pt-10 bg-white rounded-t-3xl">
        <h1 class="text-3xl font-bold text-[#2A4043] border-b pb-3 border-gray-100">
            {{ $category->name }}
        </h1>

        <div>

            @if($products->isEmpty())
            <p class="text-[#2A4043] text-lg py-10 text-center">
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
                @endforeach
            </div>
        @endif

        </div>
    </section>
</x-layout>
