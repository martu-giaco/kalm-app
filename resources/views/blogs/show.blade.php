<x-layout>
    <section class="h-full px-5 pt-10 bg-white rounded-t-3xl">
        <h1 class="text-2xl font-semibold text-[#306067] mb-3">{{ $blog->title }}</h1>
        <p class="mb-2 text-gray-500">{{ $blog->author }} @if($blog->credentials) - {{ $blog->credentials }} @endif</p>
        
        <div class="w-full mb-4 overflow-hidden h-96 rounded-2xl">
            <img src="{{ $blog->image ?? 'https://via.placeholder.com/600x400' }}" alt="{{ $blog->title }}" class="object-cover w-full h-full">
        </div>

        <div class="{{ $blog->blurred ? 'blur-sm' : '' }}">
            {!! nl2br(e($blog->content)) !!}
        </div>

        @if($blog->blurred)
            <p class="mt-2 text-red-500">Suscribirse para ver el contenido completo.</p>
        @endif
    </section>
</x-layout>
