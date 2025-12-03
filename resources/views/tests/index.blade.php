<x-layout :title="'Tests disponibles'">
    <div class="max-w-3xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-semibold text-[#164d4f] mb-6">Elegir un test</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($tests as $test)
                <a href="{{ route('tests.show', $test->key) }}">
                    <article class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition">
                        <h2 class="text-xl font-semibold text-[#164d4f]">{{ $test->title }}</h2>
                        <p class="mt-2 text-gray-600 text-sm">{{ $test->description }}</p>
                    </article>
                </a>
            @endforeach
        </div>
    </div>
</x-layout>
