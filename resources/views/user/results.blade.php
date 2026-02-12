<x-layout>
    <div class="max-w-4xl mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-[#164d4f] mb-6">Mis Resultados de Tests</h1>

        @if($results->isEmpty())
            <div class="bg-white p-8 rounded-lg shadow text-center">
                <p class="text-gray-600 mb-4">Aún no has completado ningún test</p>
                <a href="{{ route('tests.index') }}" class="inline-block px-6 py-2 bg-[#164d4f] text-white rounded-lg hover:bg-[#0d3537] transition">
                    Realizar un test
                </a>
            </div>
        @else
            <div class="space-y-4">
                @foreach($results as $result)
                    <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <h3 class="text-xl font-semibold text-[#164d4f]">
                                    Test: <span class="text-[#37A0AF]">{{ ucfirst($result->test_key) }}</span>
                                </h3>
                                <p class="text-lg mt-2">
                                    <strong>Resultado:</strong>
                                    <span class="px-3 py-1 bg-[#e8f4f5] text-[#164d4f] rounded-full font-semibold">
                                        {{ ucfirst($result->result_key) }}
                                    </span>
                                </p>

                                @if($result->answers)
                                    <details class="mt-3">
                                        <summary class="cursor-pointer text-sm text-[#37A0AF] hover:text-[#164d4f]">
                                            Ver respuestas ({{ count(json_decode($result->answers, true)) }} preguntas)
                                        </summary>
                                        <div class="mt-2 pl-4 border-l-2 border-[#37A0AF] space-y-1 text-sm text-gray-700">
                                            @foreach(json_decode($result->answers, true) ?? [] as $key => $answer)
                                                <p><strong>{{ $key }}:</strong> {{ ucfirst($answer) }}</p>
                                            @endforeach
                                        </div>
                                    </details>
                                @endif
                            </div>

                            <p class="text-sm text-gray-500 ml-4">
                                {{ $result->created_at->format('d/m/Y H:i') }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-layout>
