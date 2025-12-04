<x-layout :title="'Tests disponibles'">
    <div class="max-w-6xl mx-auto px-5 pt-5 rounded-t-3xl bg-white">
        <h1 class="text-2xl font-semibold text-[#306067]">Tests</h1>
        <p class="text-[#2A4043]">Completá todos los tests para obtener tu rutina personalizada.</p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
            @foreach($tests as $test)
                <a href="{{ route('tests.show', $test->key) }}">
                    <article class="bg-white rounded-2xl p-6 shadow-lg flex items-center justify-between hover:shadow-xl transition">
                        <div>
                            <h2 class="text-xl font-semibold text-[#306067]">{{ $test->title }}</h2>
                            <p class="mt-2 text-[#CCE2E5] text-sm">{{ $test->description }}</p>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#306067"><path d="M579-480 285-774q-15-15-14.5-35.5T286-845q15-15 35.5-15t35.5 15l307 308q12 12 18 27t6 30q0 15-6 30t-18 27L356-115q-15 15-35 14.5T286-116q-15-15-15-35.5t15-35.5l293-293Z"/></svg>
                    </article>
                </a>
            @endforeach
        </div>
    </div>
</x-layout>
