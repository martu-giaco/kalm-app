{{-- resources/views/products/by_category.blade.php --}}
@extends('layouts.app')

@section('content')
<div >

    {{-- Nombre de la categoría --}}
    <h1 class="text-2xl font-bold text-[#306067] mb-6">
        {{ $category->name }}
    </h1>

    @forelse ($products as $product)
        <div class="flex items-center border-b border-gray-200 py-3">

            {{-- Imagen del producto --}}
            <div class="flex-shrink-0 w-20 h-20 rounded-lg overflow-hidden bg-[var(--kalm-light)]">
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">



            </div>

            {{-- Info del producto --}}
            <div class="ml-4 flex-1">
                {{-- Nombre del producto --}}
                <h3 class="text-sm font-medium text-[#306067]">{{ $product->name }}</h3>

                {{-- Marca --}}
                <p class="text-xs text-[var(--kalm-text)] mt-1">{{ $product->brand->name }}</p>

                {{-- Tipo de producto --}}
                @if($product->product_type)
                    <p class="text-xs text-[var(--kalm-text)] mt-0.5">{{ $product->product_type->name }}</p>
                @endif

                {{-- Tag personalizado --}}
                @if(isset($product->resolved_tag_text))
                    <span class="inline-block mt-2 px-2 py-0.5 text-xs font-semibold rounded {{ $product->tag_class ?? 'bg-teal-100 text-teal-800' }}">
                        {{ $product->resolved_tag_text }}
                    </span>
                @endif
            </div>
        </div>
    @empty
        <p class="text-[var(--kalm-text)]">No se encontraron productos en esta categoría.</p>
    @endforelse

</div>
@endsection
