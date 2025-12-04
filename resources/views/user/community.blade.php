<x-layout title="Kälm | Comunidad">

    <section class="mx-auto px-5 rounded-t-3xl bg-white min-h-screen">

        <h1 class="text-2xl font-bold text-[#306067] mb-4">Comunidad Kälm</h1>

        @forelse($posts as $post)
            <x-community_post :post="$post" />
        @empty
            <p class="text-[#CCE2E5]">No hay posts para mostrar.</p>
        @endforelse

        {{-- Paginación --}}
        <div class="mt-4">
            {{ $posts->links() }}
        </div>

    </section>

</x-layout>
