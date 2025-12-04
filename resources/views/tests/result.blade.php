<x-layout title="Resultado del Test">
    <div class="max-w-3xl mx-auto px-4 py-8">
        <article class="bg-white rounded-2xl p-6 shadow-lg">

            <h1 class="text-2xl font-semibold text-[#164d4f] mb-4">Resultado del Test</h1>

            <p class="text-gray-700 mb-4">Según tus respuestas, tu tipo es:</p>

            @php
                // Obtener resultado
                $resultLabel = $resultKey ?? session('result_key');

                // Descripciones
                $descriptions = [
                    'normal' => 'Piel/cabello equilibrado.',
                    'seco' => 'Tiendes a la sequedad.',
                    'graso' => 'Tiendes a la producción de sebo elevada.',
                    'mixto' => 'Zona T grasa y mejillas secas.',
                    'sensible' => 'Tendencia a rojeces e irritaciones.',
                ];

                $resultDesc = $descriptions[$resultLabel] ?? 'Descripción no disponible para este resultado.';
            @endphp

            <div class="p-4 bg-[#164d4f] text-white rounded-xl mb-6">
                <h2 class="text-xl font-semibold">{{ ucfirst($resultLabel) }}</h2>
                <p class="text-sm mt-1 opacity-90 text-white">{{ $resultDesc }}</p>
            </div>

            {{-- Mostrar rutina recomendada --}}
            @if(isset($routine))
                <h2 class="text-xl font-semibold text-[#164d4f] mb-3">Rutina recomendada</h2>

                {{-- Pasos de la rutina --}}
                @if($routine->products && $routine->products->count())
                    <ul class="space-y-3 mb-6">
                        @foreach($routine->products as $step)
                            <li class="border border-gray-300 rounded-xl p-4">
                                <h3 class="font-semibold text-[#164d4f]">{{ $step->title }}</h3>
                                <p class="text-gray-700 text-sm mt-1">{{ $step->description }}</p>

                                {{-- Productos asociados a este paso (si existen) --}}
                                @if($step->products && $step->products->count())
                                    <ul class="mt-2 space-y-1 pl-4">
                                        @foreach($step->products as $product)
                                            <li class="text-gray-600 text-sm">
                                                {{ $product->name }}
                                                @if(isset($product->brand))
                                                    ({{ $product->brand->name }})
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-600 mb-6">...</p>
                @endif
            @endif

            {{-- Botones de acción --}}
            <div class="flex flex-wrap gap-3">
                @php $testKey = $testKey ?? session('test_key'); @endphp

                {{-- Rehacer test --}}
                @if($testKey)
                    <a href="{{ route('tests.show', $testKey) }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg">Rehacer test</a>
                @else
                    <a href="{{ route('tests.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg">Volver a tests</a>
                @endif

                {{-- Guardar resultado --}}
                @auth
                    <form action="{{ route('tests.saveResult', $routine->routine_id ?? 0) }}" method="POST" class="inline">
                        @csrf
                        <input type="hidden" name="test_key" value="{{ $testKey }}">
                        <input type="hidden" name="result_key" value="{{ $resultLabel }}">
                        @php $answersToSend = $answers ?? session('test_answers', []); @endphp
                        @if(is_array($answersToSend))
                            <input type="hidden" name="answers" value='{{ json_encode($answersToSend) }}'>
                        @endif
                        <button class="px-4 py-2 bg-[#164d4f] text-white rounded-lg">Guardar resultado</button>
                    </form>
                @else
                    <a href="{{ route('auth.login') }}" class="px-4 py-2 bg-[#164d4f] text-white rounded-lg">Iniciar sesión para guardar</a>
                @endauth

                {{-- Crear rutina --}}
                @if(isset($routine) && isset($routine->routine_id))
                    <a href="{{ route('tests.createRoutine', $routine->routine_id) }}" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg">Crear rutina desde este resultado</a>
                @else
                    <a href="{{ route('tests.createRoutine', session('intended_routine', 0)) }}" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg">Crear rutina</a>
                @endif
            </div>

        </article>
    </div>
</x-layout>
