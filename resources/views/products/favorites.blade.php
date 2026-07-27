<x-layout title="Mis favoritos">
    <section class="min-h-screen p-5 rounded-t-3xl bg-white dark:bg-[#2A4043]">

        {{-- Título --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-[#2A4043] dark:text-[#CCE2E5] border-b pb-3 border-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="inline-block w-8 h-8 mr-2 fill-[#430000]" viewBox="0 -960 960 960"><path d="M479.76-139.83q-16.15 0-32.44-5.83-16.3-5.84-28.97-18.27l-69.48-63.48Q243.35-323.7 157.61-420.03 71.87-516.37 71.87-634q0-97.59 65.15-162.98 65.15-65.39 162.74-65.39 52.52 0 99.28 21.42 46.76 21.43 80.72 59.47 33.96-38.04 80.72-59.47 46.76-21.42 99.28-21.42 97.59 0 163.1 65.39 65.51 65.39 65.51 162.98 0 117.63-85.6 214.47-85.6 96.83-193.12 193.36l-68.24 62.47q-12.67 12.44-29.08 18.16-16.42 5.71-32.57 5.71Z"/></svg>
                Mis Favoritos
            </h1>
        </div>

        @if ($favorites->count())
            {{-- Grid de productos --}}
            <div class="grid grid-cols-2 gap-4 pb-20 md:grid-cols-3 lg:grid-cols-4">
                @foreach ($favorites as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>

        @else
            {{-- Estado vacío --}}
            <div class="flex flex-col items-center justify-center min-h-96">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-24 h-24 mb-4 text-gray-300" viewBox="0 -960 960 960">
                    <path fill="currentColor" d="M479.76-139.83q-16.15 0-32.44-5.83-16.3-5.84-28.97-18.27l-69.48-63.48Q243.35-323.7 157.61-420.03 71.87-516.37 71.87-634q0-97.59 65.15-162.98 65.15-65.39 162.74-65.39 52.52 0 99.28 21.42 46.76 21.43 80.72 59.47 33.96-38.04 80.72-59.47 46.76-21.42 99.28-21.42 97.59 0 163.1 65.39 65.51 65.39 65.51 162.98 0 117.63-85.6 214.47-85.6 96.83-193.12 193.36l-68.24 62.47q-12.67 12.44-29.08 18.16-16.42 5.71-32.57 5.71Z"/>
                </svg>
                <h2 class="text-2xl font-bold text-[#2A4043] dark:text-[#CCE2E5] mb-2">No tenés favoritos</h2>
                <p class="text-[#2A4043] dark:text-[#E9E5E3] mb-6 text-center text-sm max-w-sm">
                    Explora nuestros productos y marcá los que te gusten como favoritos.
                </p>
                <a href="{{ route('home') }}" class="px-6 py-3 text-white bg-[#306067] rounded-lg hover:bg-[#2A4043] transition">
                    Explorar productos
                </a>
            </div>
        @endif

    </section>
</x-layout>
