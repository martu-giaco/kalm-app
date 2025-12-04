{{-- resources/views/routines/show.blade.php --}}
<x-layout :title="$routine->name">
    <div class="max-w-3xl mx-auto p-4 sm:p-6">
        <header class="mb-6">
            <h1 class="text-3xl font-semibold text-[var(--kalm-dark)]">{{ $routine->name }}</h1>

            {{-- Tipo y tiempo de rutina --}}
            <p class="text-sm text-slate-400 mt-1">
                Tipo: {{ $routine->types->pluck('name')->join(', ') ?: 'No definido' }} ·
                Tiempo: {{ $routine->routineTime?->name ?? 'No definido' }}
            </p>

            {{-- Conteo de productos reales --}}
            <p class="text-sm text-slate-400 mt-1">
                {{ $routine->assignedProducts->count() }} {{ Str::plural('producto', $routine->assignedProducts->count()) }}
            </p>
        </header>

        <main class="space-y-6">
            @forelse($routine->assignedProducts as $product)
                @php
                    $imgSrc = $product->image_url;
                    $brand = $product->brand?->name ?? null;
                    $skin = $product->skin_type ?? $product->skin ?? null;
                @endphp

                <section class="bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden">
                    <div class="px-4 py-3 flex items-center gap-4">
                        <a href="{{ route('products.show', $product->id) }}" class="flex-shrink-0">
                            <img src="{{ $imgSrc }}" alt="{{ $product->name }}" class="h-16 w-16 object-contain rounded-md">
                        </a>

                        <div class="flex-1 min-w-0">
                            <a href="{{ route('products.show', $product->id) }}" class="block">
                                <p class="text-sm font-semibold text-[var(--kalm-dark)] truncate">{{ \Illuminate\Support\Str::limit($product->name, 70) }}</p>
                            </a>
                            @if($brand)
                                <p class="text-xs text-slate-400 mt-0.5 truncate">{{ $brand }}</p>
                            @endif
                        </div>

                        <div class="flex flex-col items-end space-y-2 mr-2">
                            <span class="text-xs {{ $skin ? 'bg-[#E6FFFB] text-[#0f6b66] border border-[#CDECE9]' : 'bg-slate-100 text-slate-600' }} px-3 py-1 rounded-full whitespace-nowrap">
                                {{ $skin ?? 'Todo tipo' }}
                            </span>

                            {{-- Botón quitar producto --}}
                            <form action="{{ route('routines.product.remove', [$routine, $product]) }}" method="POST" onsubmit="return confirm('¿Eliminar este producto de la rutina?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-md shadow-sm">
                                    Quitar
                                </button>
                            </form>
                        </div>
                    </div>
                </section>
            @empty
                <div class="py-10 text-center text-slate-400">
                    <p class="text-lg">No hay productos en esta rutina.</p>
                </div>
            @endforelse
        </main>

        {{-- BOTONES FLOTANTES --}}
        <div class="fixed bottom-20 right-5 flex flex-row items-center gap-4 z-50">
            <form action="{{ route('routines.destroy', $routine) }}" method="POST" onsubmit="return confirm('¿Seguro que querés eliminar esta rutina? Esta acción no se puede deshacer.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white h-14 w-14 rounded-full flex items-center justify-center shadow-xl transition transform hover:-translate-y-0.5">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="white" viewBox="0 0 24 24" class="h-6 w-6">
                        <path d="M9 3v1H4v2h16V4h-5V3H9zm1 5v10h2V8h-2zm-4 0v10h2V8H6zm8 0v10h2V8h-2z"/>
                    </svg>
                </button>
            </form>

            <a href="{{ route('routines.edit', $routine) }}" class="bg-[#3FADB3FF] hover:bg-[#254a4c] text-white h-14 w-14 rounded-full flex items-center justify-center shadow-xl transition transform hover:-translate-y-0.5">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="#fff" viewBox="0 0 24 24">
                    <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a1.003 1.003 0 0 0 0-1.41l-2.34-2.34a1.003 1.003 0 0 0-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                </svg>
            </a>
        </div>
    </div>
</x-layout>
