<x-layout>
    <section class="px-5 py-10 bg-white h-vh rounded-t-3xl">
        <h1 class="text-2xl font-semibold text-[#306067] mb-3">Blog</h1>

        @foreach($blogs as $blog)
        <article class="mb-5 overflow-hidden bg-white shadow-lg rounded-2xl">

            @if($blog->image)
            <div class="w-full h-64 overflow-hidden">
                <img src="{{ $blog->image }}" alt="{{ $blog->title }}" class="object-contain w-full h-full">
            </div>
            @endif

            <div class="flex justify-between border-t-[1px] border-t-[#CCE2E5] items-start p-4">
                <div>
                    <h3 class="text-xl text-[#306067]">{{ $blog->title }}</h3>
                    <p class="text-sm text-gray-500">{{ $blog->author }} @if($blog->credentials) - {{ $blog->credentials }} @endif</p>
                </div>
                <label class="cursor-pointer swap">
                    <input type="checkbox" data-id="{{ $blog->id }}" class="like-toggle" />
                    <!-- swap-on -->
                    <svg class="swap-on fill-[#FFDE21]" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"><path d="..."/></svg>
                    <!-- swap-off -->
                    <svg class="swap-off fill-[#FFDE21]" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"><path d="..."/></svg>
                </label>
            </div>

            <div class="p-4">
                <p class="{{ $blog->blurred ? 'blur-sm' : '' }}">{{ Str::limit($blog->content, 200) }}</p>
                @if(!$blog->blurred)
                    <a href="{{ route('blog.show', $blog->id) }}" class="inline-block mt-2 text-blue-500 hover:underline">Leer más</a>
                @else
                    <p class="mt-2 text-red-500">Suscríbete para ver el contenido completo.</p>
                @endif
            </div>
        </article>
        @endforeach
    </section>

    <script>
        document.querySelectorAll('.like-toggle').forEach(el => {
            el.addEventListener('change', function() {
                const blogId = this.dataset.id;
                fetch(`/blogs/${blogId}/like`, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                }).then(res => res.json())
                  .then(data => console.log(data));
            });
        });
    </script>
</x-layout>
