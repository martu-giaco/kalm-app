<x-layout title="Resultado del Test">
    <div class="px-5 py-10 rounded-t-3xl bg-white">
        <article>

            {{-- Mostrar notificación de éxito si existe --}}
            @if (session('success'))
                <div class="mb-6 p-4 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 rounded-lg shadow-md animate-fadeIn">
                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-600" viewBox="0 -960 960 960" fill="currentColor">
                            <path d="M382-240 154-468l51-51 177 177 360-360 51 51-411 411Z"/>
                        </svg>
                        <span class="font-semibold text-green-700">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <div class="mb-7">
                @if ($testKey === 'cabello')
                    <h1 class="text-2xl font-semibold text-[#306067] text-center">Conocé tu cabello:</h1>
                @else
                    <h1 class="text-2xl font-semibold text-[#306067] text-center">Conocé tu piel:</h1>
                @endif
                <p class="text-center text-md text-[#37A0AF]">Según tus respuestas, tu tipo es <span
                        class="font-bold font-3xl text-center text-[#306067] mb-4">{{ ucfirst($resultLabel) }}</span>
                </p>

                <p class="mt-5 text-md text-[#306067]">{{ $resultDesc }}</p>
            </div>

            <div class="mb-7">
                <h2 class="text-2xl font-semibold text-[#306067] text-center">Tu rutina ideal</h2>

                @if ($recommendedRoutine)
                    <h3 class="mt-3 text-lg font-semibold text-[#306067] text-center">
                        {{ $recommendedRoutine->name }}
                    </h3>

                    <div class="flex justify-center items-center gap-2 text-[#37A0AF] text-sm mt-1">
                        <span>{{ $recommendedRoutine->routineTime?->name ?? 'Sin horario' }}</span>
                    </div>

                    <ul class="mt-4 list-disc pl-6 text-[#306067]">
                        @foreach ($recommendedRoutine->steps ?? [] as $step)
                            <li>{{ $step }}</li>
                        @endforeach
                    </ul>

                    @auth
                        <form action="{{ route('routines.fromRecommended', $recommendedRoutine->recommended_id) }}"
                            method="POST">
                            @csrf
                            <button class="mt-5 w-full bg-[#37A0AF] text-white rounded-lg py-3">
                                Guardar rutina en mi perfil
                            </button>
                        </form>
                    @endauth
                @else
                    <p class="text-gray-500 text-center mt-4">
                        No hay una rutina cargada para este resultado.
                    </p>
                @endif

                @auth
                    <a href="{{ route('tests.createRoutine') }}"
                        class="block px-4 py-3 bg-[#37A0AF] text-white rounded-lg w-full text-center mt-3">
                        Guardar Rutina
                    </a>
                @endauth

            </div>

            {{-- Productos recomendados --}}
            <h2 class="text-2xl font-semibold text-[#306067] mb-3">Productos recomendados</h2>

            @if ($recommendedProducts->count())
                <div class="flex pb-4 space-x-6 overflow-x-auto scrollbar-hide">
                    @foreach ($recommendedProducts as $product)
                        <a href="{{ route('products.show', $product->id) }}" class="flex-shrink-0 w-40 md:w-44 group">
                            <div
                                class="overflow-hidden transition duration-300 bg-white shadow-md rounded-xl hover:shadow-lg">

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
                                        <button
                                            class="text-[10px] mt-2 w-20 inline-block text-white truncate bg-[#37A0AF] px-2 py-1 rounded-xl">
                                            ✨{{ $product->type->name }}
                                        </button>
                                    @endif
                                </div>

                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <p class="text-gray-600">No se encontraron productos recomendados para este resultado.</p>
            @endif

        </article>

        {{-- Botones de acción --}}
        <div class="flex flex-wrap gap-3 mt-8 pb-10">
            @php $testKey = session('test_key'); @endphp

            @auth
                <form action="{{ route('tests.saveResult') }}" method="POST" class="w-full">
                    @csrf
                    <input type="hidden" name="test_key" value="{{ $testKey }}">
                    <input type="hidden" name="result_key" value="{{ $resultLabel }}">
                    <input type="hidden" name="answers" value='{{ json_encode(session('test_answers', [])) }}'>
                    <button type="submit" class="w-full px-4 py-3 bg-[#164d4f] text-white rounded-lg hover:bg-[#0d3537] transition">Guardar resultado en perfil</button>
                </form>
            @else
                <a href="{{ route('auth.login') }}" class="w-full px-4 py-3 bg-[#164d4f] text-white rounded-lg text-center hover:bg-[#0d3537] transition">
                    Iniciar sesión para guardar
                </a>
            @endauth

            <a href="{{ $testKey ? route('tests.show', $testKey) : route('tests.index') }}"
                class="w-full text-center px-4 py-3 text-[#37A0AF] border-2 border-[#37A0AF] rounded-lg hover:bg-[#37A0AF]/10 transition">
                {{ $testKey ? 'Rehacer test' : 'Volver a tests' }}
            </a>

            <a href="{{ route('home') }}"
                class="w-full text-center px-4 py-3 text-[#306067] border-2 border-[#306067] rounded-lg hover:bg-[#306067]/10 transition">
                Volver al inicio
            </a>
        </div>
    </div>

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-fadeIn {
            animation: fadeIn 0.5s ease-out forwards;
        }
    </style>
</x-layout>
