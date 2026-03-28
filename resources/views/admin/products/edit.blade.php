<?php
/** \Illuminate\Support\ViewErrorBag $errors */
?>

<x-layout>
    <div class="container my-5 px-5 bg-white rounded-t-3xl min-h-full pt-5">

        <h1 class="text-3xl font-bold text-[#306067] mb-4">Editar Producto</h1>

        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="mb-3">
                <label for="name" class="block mb-1 text-sm">Nombre del producto</label>
                <input type="text" name="name" id="name" class="w-full p-3 mb-3 bg-transparent rounded-xl border-2 border-[#CCE2E5] placeholder-[#CCE2E5] focus:outline-[#37A0AF] text-md text-[#2A4043]" value="{{ old('name', $product->name) }}">
            </div>

            <div class="mb-3">
                <label for="brand" class="block mb-1 text-sm">Marca</label>
                <select name="brand_id" id="brand" class="w-full p-3 mb-3 bg-transparent rounded-xl border-2 border-[#CCE2E5] placeholder-[#CCE2E5] focus:outline-[#37A0AF] text-md text-[#2A4043]">
                    <option value="">Seleccionar marca</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>
                            {{ $brand->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="category" class="block mb-1 text-sm">Categoría</label>
                <select name="category_id" id="category" class="w-full p-3 mb-3 bg-transparent rounded-xl border-2 border-[#CCE2E5] placeholder-[#CCE2E5] focus:outline-[#37A0AF] text-md text-[#2A4043]">
                    <option value="">Seleccionar categoría</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="type" class="block mb-1 text-sm">Tipo de producto</label>
                <select name="type_id" id="type" class="w-full p-3 mb-3 bg-transparent rounded-xl border-2 border-[#CCE2E5] placeholder-[#CCE2E5] focus:outline-[#37A0AF] text-md text-[#2A4043]">
                    <option value="">Seleccionar tipo de producto</option>
                    @foreach($types as $type)
                        <option value="{{ $type->id }}" {{ old('type_id', $product->type_id) == $type->id ? 'selected' : '' }}>
                            {{ $type->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-5">
                <p for="skin_type" class="block mb-3 text-sm font-bold text-[#2A4043]">Tipo de piel</p>
                @php
                        $selectedSkinTypes = old('skinTypes', $product->skinTypes->pluck('id')->toArray());
                        $selectedSkinTypes = is_array($selectedSkinTypes) ? $selectedSkinTypes : [$selectedSkinTypes];
                    @endphp
                <div class="flex flex-wrap gap-x-1 gap-y-4 align-middle">
                    @foreach($skinTypes as $skinType)
                        <label class="cursor-pointer">
                            <input
                                type="checkbox"
                                name="skin_types[]"
                                value="{{ $skinType->id }}"
                                class="hidden peer"
                                {{ in_array($skinType->id, $selectedSkinTypes) ? 'checked' : '' }}
                            >

                            <span class="px-4 py-2 text-sm text-center rounded-full border border-[#CCE2E5] bg-white text-[#2A4043]
                                peer-checked:bg-[#37A0AF]
                                peer-checked:text-white
                                peer-checked:border-[#37A0AF]
                                transition-all duration-200">
                                {{ $skinType->name }}
                            </span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="mb-5">
                <p for="concern" class="block mb-3 text-sm font-bold text-[#2A4043]">Preocupaciones</p>
                    @php
                        $selectedConcerns = old('concerns', $product->concerns->pluck('id')->toArray());
                        $selectedConcerns = is_array($selectedConcerns) ? $selectedConcerns : [$selectedConcerns];
                    @endphp
                <div class="flex flex-wrap gap-x-1 gap-y-4 align-middle">
                    @foreach($concerns as $concern)
                        <label class="cursor-pointer">
                            <input
                                type="checkbox"
                                name="concerns[]"
                                value="{{ $concern->id }}"
                                class="hidden peer"
                                {{ in_array($concern->id, $selectedConcerns) ? 'checked' : '' }}
                            >

                            <span class="px-4 py-2 text-sm text-center rounded-full border border-[#CCE2E5] bg-white text-[#2A4043]
                                peer-checked:bg-[#37A0AF]
                                peer-checked:text-white
                                peer-checked:border-[#37A0AF]
                                transition-all duration-200">
                                {{ $concern->name }}
                            </span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="mb-3">
                <p class="mb-1 text-sm">Imagen</p>
                @if($product->image)
                    <div class="relative md:flex-shrink-0 md:w-1/2">
                    <div class="mb-6 overflow-hidden bg-white shadow-lg rounded-3xl">
                        @if (!empty($product->image))
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                class="object-cover w-full bg-white h-80">
                        @else
                            <div class="flex items-center justify-center w-full text-gray-400 h-80">
                                Sin imagen
                            </div>
                        @endif
                    </div>
                @endif
                <label for="image"
                                class="flex justify-between mb-1 text-md p-3 bg-transparent rounded-xl border-2 border-[#2A4043] placeholder-[#CCE2E5] focus:outline-[#2A4043] text-[#2A4043]">
                                <p>Subir una foto</p>
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                    width="24px" fill="#2A4043">
                                    <path
                                        d="M480-480ZM202.87-111.87q-37.78 0-64.39-26.61t-26.61-64.39v-554.26q0-37.78 26.61-64.39t64.39-26.61h270.91q19.15 0 32.33 13.17 13.17 13.18 13.17 32.33t-13.17 32.33q-13.18 13.17-32.33 13.17H202.87v554.26h554.26v-270.91q0-19.15 13.17-32.33 13.18-13.17 32.33-13.17t32.33 13.17q13.17 13.18 13.17 32.33v270.91q0 37.78-26.61 64.39t-64.39 26.61H202.87ZM240-280h480L570-480 450-320l-90-120-120 160Zm441.91-401.91h-40.95q-17.71 0-29.7-12.05-11.98-12.05-11.98-29.87 0-17.71 12.05-29.69t29.87-11.98h40.71v-40.96q0-17.71 12.05-29.69t29.87-11.98q17.71 0 29.69 11.98t11.98 29.69v40.96h40.96q17.71 0 29.69 11.98t11.98 29.7q0 17.71-11.98 29.81-11.98 12.1-29.69 12.1H765.5v40.95q0 17.71-11.98 29.7-11.98 11.98-29.7 11.98-17.71 0-29.81-12.05-12.1-12.05-12.1-29.87v-40.71Z" />
                                </svg>
                            </label>
                <input style="display: none;" type="file" id="image" name="image" class="w-full p-3 mb-3 bg-transparent rounded-xl border-2 border-[#CCE2E5] placeholder-[#CCE2E5] focus:outline-[#37A0AF] text-md text-[#2A4043] @error('image') is-invalid @enderror" accept="image/*">
                @error('image')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mt-3 mb-3">
                <label for="description" class="block mb-1 text-sm">Descripción</label>
                <textarea name="description" id="description" class="w-full p-3 mb-3 bg-transparent rounded-xl border-2 border-[#CCE2E5] placeholder-[#CCE2E5] focus:outline-[#37A0AF] text-md text-[#2A4043]">{{ old('description', $product->description) }}</textarea>
            </div>

            <div class="mt-3 mb-3">
                <label for="ingredients" class="block mb-1 text-sm">Ingredientes</label>
                <textarea name="ingredients" id="ingredients" class="w-full p-3 mb-3 bg-transparent rounded-xl border-2 border-[#CCE2E5] placeholder-[#CCE2E5] focus:outline-[#37A0AF] text-md text-[#2A4043]">{{ old('ingredients', $product->ingredients) }}</textarea>
            </div>

            <div class="mt-3 mb-3">
                <label for="activos" class="block mb-1 text-sm">Activos</label>
                <textarea name="activos" id="activos" class="w-full p-3 mb-3 bg-transparent rounded-xl border-2 border-[#CCE2E5] placeholder-[#CCE2E5] focus:outline-[#37A0AF] text-md text-[#2A4043]">{{ old('activos', $product->activos) }}</textarea>
            </div>

            <div class="mt-3 mb-3">
                <label for="formato" class="block mb-1 text-sm">Formato</label>
                <input name="formato" id="formato" class="w-full p-3 mb-3 bg-transparent rounded-xl border-2 border-[#CCE2E5] placeholder-[#CCE2E5] focus:outline-[#37A0AF] text-md text-[#2A4043]" value="{{ old('formato', $product->formato) }}">
            </div>

            <button type="submit" class="btn w-full px-5 py-3 rounded-xl text-white font-bold transition cursor-pointer disabled:opacity-80 disabled:cursor-not-allowed hover:bg-[#306067] bg-[#306067]">Editar Producto</button>
        </form>
    </div>
</x-layout>
