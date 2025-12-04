{{-- resources/views/routines/show.blade.php --}}
<x-layout :title="$routine->name">
    <div class="max-w-3xl mx-auto p-4 sm:p-6">
        <header class="mb-6">
            <h1 class="text-3xl font-semibold text-[var(--kalm-dark)]">{{ $routine->name }}</h1>

            {{-- Tipo y tiempo de rutina --}}
            <p class="text-sm text-slate-400 mt-1">
                Tipo: {{ $routine->routineType?->name ?? 'No definido' }} ·
                Tiempo: {{ $routine->routineTime?->name ?? 'No definido' }}
            </p>

            @php
                $productsData = $routine->products;
                if (is_array($productsData)) $productsData = collect($productsData);

                $stepsCount = $productsData instanceof \Illuminate\Support\Collection ? $productsData->count() : 0;
                $productsCount = 0;
                if ($productsData instanceof \Illuminate\Support\Collection) {
                    foreach ($productsData as $step) {
                        if ($step instanceof \Illuminate\Database\Eloquent\Model && $step->products) {
                            $productsCount += $step->products->count();
                        } elseif (is_array($step)) {
                            $productsCount += count($step);
                        } else {
                            $productsCount += 1;
                        }
                    }
                }
            @endphp

            <p class="text-sm text-slate-400 mt-1">
                {{ $stepsCount ?: ($productsCount ? 'Ver productos' : 'Sin pasos') }} · {{ $productsCount }} productos
            </p>
        </header>

        <main class="space-y-6">
            @if($productsData && $productsData->count())
                @foreach($productsData as $index => $step)
                    @php
                        if ($step instanceof \Illuminate\Database\Eloquent\Model) {
                            $stepProducts = $step->products ?? collect();
                            $stepName = $step->name ?? "Paso " . ($index + 1);
                            $stepDescription = $step->description ?? null;
                        } elseif (is_array($step)) {
                            $stepProducts = collect($step);
                            $stepName = "Paso " . ($index + 1);
                            $stepDescription = null;
                        } else {
                            $stepProducts = collect([$step]);
                            $stepName = "Paso " . ($index + 1);
                            $stepDescription = null;
                        }
                    @endphp

                    <section class="bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden">
                        <div class="px-4 py-3">
                            <h2 class="text-lg font-semibold text-[var(--kalm-dark)]">{{ $stepName }}</h2>
                            @if($stepDescription)
                                <p class="text-xs text-slate-500 mt-1">{{ $stepDescription }}</p>
                            @endif
                        </div>
                        <div class="border-t border-slate-100"></div>

                        <div class="px-4 py-3 space-y-3">
                            @forelse($stepProducts as $product)
                                @php
                                    if (is_numeric($product)) {
                                        $product = \App\Models\Product::find($product);
                                        if(!$product) continue;
                                    }

                                    $img = $product->image_url ?? $product->img_src ?? $product->image ?? null;
                                    $imgSrc = $img ? (\Illuminate\Support\Str::startsWith($img, ['http://','https://']) ? $img : asset($img)) : asset('img/placeholder.png');
                                    $brand = $product->brand?->name ?? null;
                                    $skin = $product->skin_type ?? $product->skin ?? null;

                                    $useRelationRoute = \Illuminate\Support\Facades\Route::has('routines.products.destroy');
                                    $relationRouteName = 'routines.products.destroy';
                                    $fallbackRouteName = 'routines.product.remove';
                                @endphp

                                <div class="flex items-center gap-4 bg-white rounded-lg p-2 border border-slate-100 shadow-sm">
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

                                        @if($useRelationRoute)
                                            <form action="{{ route($relationRouteName, [$routine, $product]) }}" method="POST" onsubmit="return confirm('¿Eliminar este producto de la rutina?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-sm bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-md shadow-sm">
                                                    Quitar
                                                </button>
                                            </form>
                                        @elseif(\Illuminate\Support\Facades\Route::has($fallbackRouteName))
                                            <form action="{{ route($fallbackRouteName, $routine) }}" method="POST" onsubmit="return confirm('¿Eliminar este producto de la rutina?')">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <button type="submit" class="text-sm bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-md shadow-sm">
                                                    Quitar
                                                </button>
                                            </form>
                                        @else
                                            <button class="text-sm bg-gray-300 text-gray-700 px-3 py-1 rounded-md shadow-sm cursor-not-allowed" disabled title="Define la ruta routines.products.destroy o routines.product.remove">Quitar</button>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="text-sm text-slate-400 italic">No hay productos en este paso.</div>
                            @endforelse
                        </div>
                    </section>
                @endforeach
            @else
                <div class="py-10 text-center text-slate-400">
                    <p class="text-lg">No hay productos en esta rutina.</p>
                </div>
            @endif
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
