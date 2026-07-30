<x-layout title="Mis bookmarks">
    <div class="container my-5 pb-10 px-5 bg-white dark:bg-[#2A4043] rounded-t-3xl min-h-full pt-5">
        <div class="flex items-center justify-between mb-6">
             {{-- Título --}}
                <h1 class="w-full text-3xl font-bold text-[#2A4043] dark:text-[#CCE2E5] border-b pb-3 border-gray-100">
                   Bookmarks
                </h1>
        </div>

        @if($blogs->isEmpty())
            {{-- Estado vacío --}}
            <div class="flex flex-col items-center justify-center min-h-96">
                <svg xmlns="http://www.w3.org/2000/svg"  class="w-24 h-24 mb-4 text-gray-300" viewBox="0 -960 960 960"><path fill="currentColor" d="m480-240-168 72q-40 17-76-6.5T200-241v-519q0-33 23.5-56.5T280-840h400q33 0 56.5 23.5T760-760v519q0 43-36 66.5t-76 6.5l-168-72Z"/></svg>
                <h2 class="text-2xl font-bold text-[#2A4043] dark:text-[#CCE2E5] mb-2">No tenés bookmarks</h2>
                <p class="text-[#2A4043] dark:text-[#E9E5E3] mb-6 text-center text-sm max-w-sm">
                    Explorá nuestros blogs y guardá los que te gusten para leer más tarde.
                </p>
                <a href="{{ route('blog.index') }}" class="px-6 py-3 text-white bg-[#306067] rounded-lg hover:bg-[#2A4043] transition">
                    Explorar blogs
                </a>
            </div>
        @else
            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                @foreach($blogs as $blog)
                    <x-blog-card-hor :blog="$blog" />
                @endforeach
            </div>
        @endif
    </div>

    <script>
        document.querySelectorAll('.like-toggle').forEach(el => {
            el.addEventListener('change', function() {
                const blogId = this.dataset.id;
                fetch(`/blogs/${blogId}/bookmark`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
            });
        });
    </script>
</x-layout>
