<x-layout title="Resultado del Test">
    <div class="max-w-3xl px-4 py-8 mx-auto">
        <article class="p-6 bg-white shadow-lg rounded-2xl">

            <h1 class="text-2xl font-semibold text-[#164d4f] mb-4">Resultado del Test</h1>
            <p class="mb-4 text-gray-700">Según tus respuestas, tu tipo es:</p>

            <div class="p-4 bg-[#164d4f] text-white rounded-xl mb-6">
                <h2 class="text-xl font-semibold">{{ ucfirst($resultLabel) }}</h2>
                <p class="mt-1 text-sm text-white opacity-90">{{ $resultDesc }}</p>
            </div>

            {{-- Productos recomendados --}}
            <h2 class="text-xl font-semibold text-[#164d4f] mb-3">Productos recomendados</h2>

            @if($recommendedProducts->count())
                <div class="flex pb-4 space-x-6 overflow-x-auto scrollbar-hide">
                    @foreach($recommendedProducts as $product)
                        <a href="{{ route('products.show', $product->id) }}" class="flex-shrink-0 w-40 md:w-44 group">
                            <div class="overflow-hidden transition duration-300 bg-white shadow-md rounded-xl hover:shadow-lg">

                                {{-- Imagen del producto --}}
                                <div class="w-full h-40 overflow-hidden">
                                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                                        class="object-cover w-full h-full transition duration-300 group-hover:scale-105">
                                </div>

                                {{-- Info simplificada --}}
                                <div class="flex flex-col gap-1 p-3">
                                    <h3 class="text-sm font-semibold text-[#2A4043] mb-1 truncate">
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
            @else
                <p class="text-gray-600">No se encontraron productos recomendados para este resultado.</p>
            @endif

            {{-- Botones de acción --}}
            <div class="flex flex-wrap gap-3 mt-6">
                @php $testKey = session('test_key'); @endphp
                <a href="{{ $testKey ? route('tests.show', $testKey) : route('tests.index') }}"
                   class="px-4 py-2 text-gray-800 bg-gray-200 rounded-lg">
                   {{ $testKey ? 'Rehacer test' : 'Volver a tests' }}
                </a>

                @auth
                    <form action="{{ route('tests.saveResult', $routine->routine_id ?? 0) }}" method="POST" class="inline">
                        @csrf
                        <input type="hidden" name="test_key" value="{{ $testKey }}">
                        <input type="hidden" name="result_key" value="{{ $resultLabel }}">
                        <input type="hidden" name="answers" value='{{ json_encode(session('test_answers', [])) }}'>
                        <button class="px-4 py-2 bg-[#164d4f] text-white rounded-lg">Guardar resultado</button>
                    </form>
                @else
                    <a href="{{ route('auth.login') }}" class="px-4 py-2 bg-[#164d4f] text-white rounded-lg">
                        Iniciar sesión para guardar
                    </a>
                @endauth

                <a href="{{ route('tests.createRoutine', $routine->routine_id ?? session('intended_routine', 0)) }}"
                   class="px-4 py-2 text-gray-800 bg-gray-300 rounded-lg">
                   Crear Rutina
                </a>
            </div>

        </article>
    </div>
</x-layout>
