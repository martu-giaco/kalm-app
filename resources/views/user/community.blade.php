<x-layout title="Comunidad">

    <div class="mx-auto">

        <h1 class="text-2xl font-bold text-[#306067] mb-4">Feed de la comunidad</h1>

        @forelse($posts as $post)
            <x-community_post :post="$post" />
        @empty
            <p class="text-gray-500">No hay posts para mostrar.</p>
        @endforelse

        {{-- Paginación --}}
        <div class="mt-4">
            {{ $posts->links() }}
        </div>

    </div>

</x-layout>
