<x-layout :title="'Resultado de ' . ucfirst($test->key)">
    <div class="max-w-3xl mx-auto px-4 py-8">
        <article class="bg-white rounded-2xl p-6 shadow-lg">
            <h1 class="text-2xl font-semibold text-[#164d4f] mb-4">Resultado del Test: {{ $test->title }}</h1>

            <p class="text-gray-700 mb-4">Tu puntuación: <span class="font-bold">{{ $result->score }}</span></p>

            <h2 class="text-xl font-semibold text-[#164d4f] mb-2">Tus respuestas:</h2>
            <ul class="list-disc list-inside text-gray-700">
                @foreach($result->answers as $key => $answer)
                    <li>{{ $key }}: {{ $answer }}</li>
                @endforeach
            </ul>
        </article>
    </div>
</x-layout>
