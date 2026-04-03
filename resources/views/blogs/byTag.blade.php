<x-layout :title="$tag->name">
    <section class="px-5 py-10 bg-white vh rounded-t-3xl">
        <h1 class="text-3xl font-bold text-[#2A4043] border-b pb-2 border-gray-100">
            {{ $tag->name }}
        </h1>
        <p class="mt-3 mb-6 text-[#37A0AF] text-sm">
            alguna desc???
        </p>

        {{-- Empty state o lista de blogs --}}
                @if ($blogs->isEmpty())
                    <div class="text-center py-14 min-h-[50vh] flex flex-col items-center justify-center">
                        <p class="text-sm text-[#2A4043] mb-4">
                            No se encontraron blogs que coincidan con su búsqueda.
                        </p>
                        <a href="{{ route('blog.index') }}" class="inline-block text-[#37A0AF]">
                            Ver todos los blogs
                        </a>
                    </div>
                @else
                    {{-- Lista de blogs: sin height fija, scroll natural del body --}}
                    <div class="mb-8">
                        @foreach ($blogs as $blog)
                            <x-blog-card-hor :blog="$blog" />
                        @endforeach
                    </div>
                @endif
            </div>
    </section>
</x-layout>
