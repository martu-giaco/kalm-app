{{-- resources/views/routines/show.blade.php --}}
<x-layout :title="$routine->name">
    <section class="pt-10 pb-20 bg-white dark:bg-[#1B2E30] rounded-t-3xl">
        @php
            // --- Momento del día ---
            $timeName = $routine->routineTime?->name; // 'Día' | 'Noche'

            // --- Tipo de rutina (Skincare / Haircare) ---
            $typeName = $routine->type?->name;
            $typeSlug = Str::of($typeName ?? '')->lower()->value();
            $isHaircare = str_contains($typeSlug, 'hair') || str_contains($typeSlug, 'cabello');
            $isSkincare = str_contains($typeSlug, 'skin') || str_contains($typeSlug, 'piel');

            // --- Recordatorio ---
            $reminderOn = (bool) ($routine->is_reminder_enabled ?? false);
            $reminderTime = $routine->reminder_time ? \Illuminate\Support\Carbon::parse($routine->reminder_time)->format('H:i') : null;
            $reminderFrequency = $routine->reminder_frequency ?? 'none';

            $dayLabels = [
                'mon' => 'Lun', 'tue' => 'Mar', 'wed' => 'Mié', 'thu' => 'Jue', 'fri' => 'Vie', 'sat' => 'Sáb', 'sun' => 'Dom',
                '0' => 'Dom', '1' => 'Lun', '2' => 'Mar', '3' => 'Mié', '4' => 'Jue', '5' => 'Vie', '6' => 'Sáb',
                'monday' => 'Lun', 'tuesday' => 'Mar', 'wednesday' => 'Mié', 'thursday' => 'Jue', 'friday' => 'Vie', 'saturday' => 'Sáb', 'sunday' => 'Dom',
            ];

            $frequencyLabel = null;
            if ($reminderOn) {
                if ($reminderFrequency === 'daily') {
                    $frequencyLabel = 'Diario';
                } elseif ($reminderFrequency === 'specific_days' && !empty($routine->reminder_days)) {
                    $days = is_array($routine->reminder_days) ? $routine->reminder_days : (json_decode($routine->reminder_days, true) ?? []);
                    $labels = collect($days)->map(fn($d) => $dayLabels[strtolower((string) $d)] ?? $d)->values();
                    $frequencyLabel = $labels->implode(' · ');
                } elseif ($reminderFrequency === 'every_x_days' && $routine->reminder_interval) {
                    $frequencyLabel = 'Cada ' . $routine->reminder_interval . ' días';
                } else {
                    $frequencyLabel = 'Activo';
                }
            }
        @endphp

        <section class="px-5 mb-6">
            {{-- Estado (completada / pendiente) --}}
            @if ($routine->is_reminder_enabled)
                @if ($routine->is_completed_today)
                    <span
                        class="inline-flex items-center gap-1 px-3 py-1 mb-2 text-xs font-semibold text-green-700 bg-green-100 rounded-full dark:bg-green-900/40 dark:text-green-300">
                        <svg xmlns="http://www.w3.org/2000/svg" height="12px" viewBox="0 -960 960 960" width="12px" class="fill-current"><path d="M382-240 154-468l57-57 171 171 367-367 57 57-424 424Z"/></svg>
                        Completada por hoy
                    </span>
                @else
                    <span
                        class="inline-flex items-center gap-1 px-3 py-1 mb-2 text-xs font-semibold rounded-full text-amber-700 bg-amber-100 dark:bg-amber-900/40 dark:text-amber-300">
                        <svg xmlns="http://www.w3.org/2000/svg" height="12px" viewBox="0 -960 960 960" width="12px" class="fill-current"><path d="M440-280h80v-240h-80v240Zm40-320q17 0 28.5-11.5T520-640q0-17-11.5-28.5T480-680q-17 0-28.5 11.5T440-640q0 17 11.5 28.5T480-600Zm0 520q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Z"/></svg>
                        Pendiente
                    </span>
                @endif
            @endif

            <div class="flex items-center justify-between">
                <div class="flex items-center min-w-0">
                    <h2 class="text-3xl font-medium text-[#306067] dark:text-[#CCE2E5] truncate">{{ $routine->name }}</h2>

                    @if ($timeName)
                        <span class="inline-flex items-center justify-center shrink-0 w-8 h-8 rounded-full ms-2
                            {{ $timeName === 'Noche' ? 'bg-[#2A4043]' : 'bg-[#FFF3D6]' }}"
                            title="{{ $timeName }}">
                            @if ($timeName === 'Día')
                                <svg xmlns="http://www.w3.org/2000/svg" height="18px" viewBox="0 -960 960 960" width="18px" class="fill-[#C07A00]">
                                    <path d="M480-760q-17 0-28.5-11.5T440-800v-80q0-17 11.5-28.5T480-920q17 0 28.5 11.5T520-880v80q0 17-11.5 28.5T480-760Zm198 82q-11-11-11-27.5t11-28.5l56-57q12-12 28.5-12t28.5 12q11 11 11 28t-11 28l-57 57q-11 11-28 11t-28-11Zm122 238q-17 0-28.5-11.5T760-480q0-17 11.5-28.5T800-520h80q17 0 28.5 11.5T920-480q0 17-11.5 28.5T880-440h-80ZM480-40q-17 0-28.5-11.5T440-80v-80q0-17 11.5-28.5T480-200q17 0 28.5 11.5T520-160v80q0 17-11.5 28.5T480-40ZM226-678l-57-56q-12-12-12-29t12-28q11-11 28-11t28 11l57 57q11 11 11 28t-11 28q-12 11-28 11t-28-11Zm508 509-56-57q-11-12-11-28.5t11-27.5q11-11 27.5-11t28.5 11l57 56q12 11 11.5 28T791-169q-12 12-29 12t-28-12ZM80-440q-17 0-28.5-11.5T40-480q0-17 11.5-28.5T80-520h80q17 0 28.5 11.5T200-480q0 17-11.5 28.5T160-440H80Zm89 271q-11-11-11-28t11-28l57-57q11-11 27.5-11t28.5 11q12 12 12 28.5T282-225l-56 56q-12 12-29 12t-28-12Zm311-71q-100 0-170-70t-70-170q0-100 70-170t170-70q100 0 170 70t70 170q0 100-70 170t-170 70Zm0-80q66 0 113-47t47-113q0-66-47-113t-113-47q-66 0-113 47t-47 113q0 66 47 113t113 47Zm0-160Z"/>
                                </svg>
                            @elseif ($timeName === 'Noche')
                                <svg xmlns="http://www.w3.org/2000/svg" height="18px" viewBox="0 -960 960 960" width="18px" class="fill-[#CCE2E5]">
                                    <path d="M480.24-116.41q-153.63 0-258.73-104.98Q116.41-326.37 116.41-480q0-133.93 84.74-235.43t223.31-123.05q15.39-3.43 27.54 1.35 12.15 4.78 19.95 14.02 7.79 9.24 9.6 22.2 1.82 12.95-4.75 26.11-13.89 25.04-21.31 51.65-7.42 26.61-7.42 55.5 0 91.69 64.32 155.88 64.33 64.18 156.22 64.18 28.37 0 56.48-7.44 28.11-7.45 50.91-20.58 12.91-5.8 25.13-4.11 12.22 1.7 21.1 8.13 9.88 6.44 14.66 18.23 4.78 11.8 1.59 27.95Q820.17-291 717.63-203.71q-102.54 87.3-237.39 87.3Zm0-91q81.78 0 147.84-43.72 66.05-43.72 98.29-114.78-17.61 4.04-35.1 6.32-17.49 2.29-34.86 1.81-122.04-4.07-207.94-89.37-85.9-85.31-90.45-209.26-.24-17.37 1.93-34.98 2.16-17.61 6.44-34.98-70.82 32.48-114.78 98.65-43.96 66.18-43.96 147.72 0 112.93 79.83 192.76 79.83 79.83 192.76 79.83Zm-13.11-259.48Z"/>
                                </svg>
                            @endif
                        </span>
                    @endif
                </div>

                <button
                    onclick="event.stopPropagation(); document.getElementById('menu_rutina_{{ $routine->getKey() }}').showModal()"
                    class="shrink-0 p-1 rounded-full hover:bg-[#F1F6F6] dark:hover:bg-[#2A4043] transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" class="fill-[#306067] dark:fill-[#CCE2E5]">
                        <path
                            d="M480.12-149q-34.55 0-59.13-24.55-24.58-24.56-24.58-59.04 0-34.58 24.56-59.2 24.55-24.62 59.03-24.62 34.67 0 59.13 24.59 24.46 24.6 24.46 59.13 0 34.54-24.46 59.11Q514.67-149 480.12-149Zm0-247.41q-34.55 0-59.13-24.56-24.58-24.55-24.58-59.03 0-34.67 24.56-59.13 24.55-24.46 59.03-24.46 34.67 0 59.13 24.46t24.46 59.01q0 34.55-24.46 59.13-24.46 24.58-59.01 24.58Zm0-247.18q-34.55 0-59.13-24.64-24.58-24.64-24.58-59.25t24.56-59.06Q445.52-811 480-811q34.67 0 59.13 24.46 24.46 24.45 24.46 59.06t-24.46 59.25q-24.46 24.64-59.01 24.64Z" />
                    </svg>
                </button>
            </div>

            {{-- Chips: tipo, necesidad, recordatorio, frecuencia --}}
            <div class="flex flex-wrap items-center gap-1.5 mt-3">
                @if($typeName)
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-[#E5F4F0] dark:bg-[#2E4A46] text-[#2E7D6B] dark:text-[#9FD8C6]">
                        @if($isHaircare)
                            <svg xmlns="http://www.w3.org/2000/svg" height="12px" viewBox="0 -960 960 960" width="12px" class="fill-current">
                                <path d="M200-80v-460h-80v-100h80v-100q0-33 23.5-56.5T280-820h160v100H280v100h160v100H280v380h-80Zm280 0v-460h-80v-100h80v-100q0-33 23.5-56.5T560-820h160v100H560v100h160v100H560v380h-80Zm200 0v-380h80v380h-80Z"/>
                            </svg>
                        @elseif($isSkincare)
                            <svg xmlns="http://www.w3.org/2000/svg" height="12px" viewBox="0 -960 960 960" width="12px" class="fill-current">
                                <path d="M480-120q-134 0-227-93t-93-227q0-63 24-121t68-104l228-238 228 238q44 46 68 104t24 121q0 134-93 227t-227 93Zm0-80q100 0 170-70t70-170q0-46-16.5-88T658-602L480-789 302-602q-29 32-45.5 74T240-440q0 100 70 170t170 70Z"/>
                            </svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" height="12px" viewBox="0 -960 960 960" width="12px" class="fill-current">
                                <path d="M480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Z"/>
                            </svg>
                        @endif
                        {{ $typeName }}
                    </span>
                @endif

                @if($routine->routineNeed?->name)
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-[#EEF3F4] dark:bg-[#2A4043] text-[#37A0AF] dark:text-[#37A0AF]">
                        {{ $routine->routineNeed->name }}
                    </span>
                @endif

                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-[#EEF3F4] dark:bg-[#2A4043] text-[#37A0AF] dark:text-[#37A0AF]">
                    {{ $routine->assignedProducts->count() }}
                    {{ Str::plural('producto', $routine->assignedProducts->count()) }}
                </span>

                @if($reminderOn)
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-[#FFF3D6] dark:bg-[#4A3F20] text-[#8A6300] dark:text-[#F5D67D]">
                        <svg xmlns="http://www.w3.org/2000/svg" height="12px" viewBox="0 -960 960 960" width="12px" class="fill-current">
                            <path d="M160-200v-80h80v-280q0-83 50-147.5T420-792v-18q0-25 17.5-42.5T480-870q25 0 42.5 17.5T540-810v18q80 20 130 84.5T720-560v280h80v80H160Zm320-300Zm0 420q-33 0-56.5-23.5T400-160h160q0 33-23.5 56.5T480-80ZM320-280h320v-280q0-66-47-113t-113-47q-66 0-113 47t-47 113v280Z"/>
                        </svg>
                        {{ $reminderTime ?? 'Activo' }}
                    </span>
                @endif

                @if($frequencyLabel)
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-[#EAF7FB] dark:bg-[#213C40] text-[#1E7E96] dark:text-[#7FD3E8]">
                        <svg xmlns="http://www.w3.org/2000/svg" height="12px" viewBox="0 -960 960 960" width="12px" class="fill-current">
                            <path d="M280-80 120-240l160-160 56 58-62 62h406v-160h80v240H274l62 62-56 58Zm-80-440v-240h486l-62-62 56-58 160 160-160 160-56-58 62-62H280v160h-80Z"/>
                        </svg>
                        {{ $frequencyLabel }}
                    </span>
                @endif
            </div>
        </section>

        <div class="space-y-3">
            @if ($routine->is_reminder_enabled && !$routine->is_completed_today)
                <div class="flex gap-2 px-5 mt-4">
                    <form action="{{ route('routines.complete', $routine->routine_id) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-4 py-2 text-sm font-bold text-white bg-green-600 rounded-xl">
                            Marcar como completada
                        </button>
                    </form>
                    <form action="{{ route('routines.postpone', $routine->routine_id) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-4 py-2 text-sm font-bold text-white rounded-xl bg-amber-500">
                            Posponer 15 min
                        </button>
                    </form>
                </div>
            @endif
            @forelse($steps as $step)

                <div>
                    <div class="flex justify-between items-center px-3 py-1 border-b-2 border-[#CCE2E5] dark:border-[#3A5559]">
                        <h3 class="text-lg font-bold text-[#306067] dark:text-[#CCE2E5]">
                            Paso {{ $step['number'] }}: {{ $step['title'] }}
                        </h3>
                        <button
                            onclick="event.stopPropagation(); document.getElementById('desc_paso_{{ $step['number'] }}').showModal()">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                width="24px" class="fill-[#306067] dark:fill-[#CCE2E5]">
                                <path
                                    d="M513.5-254.5Q528-269 528-290t-14.5-35.5Q499-340 478-340t-35.5 14.5Q428-311 428-290t14.5 35.5Q457-240 478-240t35.5-14.5ZM480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Zm4-172q25 0 43.5 16t18.5 40q0 22-13.5 39T502-525q-23 20-40.5 44T444-427q0 14 10.5 23.5T479-394q15 0 25.5-10t13.5-25q4-21 18-37.5t30-31.5q23-22 39.5-48t16.5-58q0-51-41.5-83.5T484-720q-38 0-72.5 16T359-655q-7 12-4.5 25.5T368-609q14 8 29 5t25-17q11-15 27.5-23t34.5-8Z" />
                            </svg>
                        </button>
                    </div>

                    <div class="flex flex-col gap-3">
                        @foreach ($step['products'] as $product)
                            <x-product-card-hor :product="$product" />
                        @endforeach
                    </div>
                </div>

            @empty
                <div class="py-10 text-center">
                    <p class="text-lg text-[#CCE2E5]">No hay productos en esta rutina.</p>
                    <a href="{{ route('products.search') }}" class="inline-block text-[#37A0AF] text-sm mt-2">
                        Ver todos los productos
                    </a>
                </div>
            @endforelse
        </div>

        @foreach ($product_sections as $section)
            @php
                $products_with_tag = $section['products'];
            @endphp

            <div class="pt-6 mt-6 ps-5">
                <h2 class="text-xl font-bold text-[#306067] dark:text-[#CCE2E5] mb-2">{{ $section['title'] }}</h2>
                <div class="flex pb-4 space-x-6 overflow-x-auto scrollbar-hide">
                    @foreach ($products_with_tag as $product)
                        <x-product-card :product="$product" />
                    @endforeach
                </div>
            </div>
        @endforeach
    </section>


    <dialog id="menu_rutina_{{ $routine->id }}" class="modal modal-bottom">
        <div class="modal-box bg-white dark:bg-[#2A4043]">
            <a href="{{ route('routines.edit', $routine) }}"
                class="btn w-full inline-flex border-0 bg-[#CCE2E5] px-6 py-3 rounded-xl font-semibold transition-all duration-300 items-center justify-between gap-2 text-sm">
                <p class="text-[#306067]">Editar Rutina</p>
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                    fill="#306067">
                    <path
                        d="M202.63-202.87h57.24l374.74-374.74-56.76-57-375.22 375.22v56.52Zm-45.26 91q-19.15 0-32.33-13.17-13.17-13.18-13.17-32.33v-102.26q0-18.15 6.84-34.69 6.83-16.53 19.51-29.2l501.17-500.41q12.48-11.72 27.7-17.96 15.21-6.24 31.93-6.24 16.48 0 32.2 6.24 15.71 6.24 27.67 18.72l65.28 65.56q12.48 11.72 18.34 27.56 5.86 15.83 5.86 31.79 0 16.72-5.86 32.05-5.86 15.34-18.34 27.82L324-138.22q-12.67 12.68-29.21 19.51-16.53 6.84-34.68 6.84H157.37Zm597.37-586.39-56.24-56.48 56.24 56.48Zm-148.89 92.41-28-28.76 56.76 57-28.76-28.24Z" />
                </svg>
            </a>
            <form action="{{ route('routines.destroy', $routine) }}" method="POST"
                onsubmit="return confirm('¿Seguro que querés eliminar esta rutina? Esta acción no se puede deshacer.')">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="mt-3 btn w-full inline-flex border-0 bg-[#741919] px-6 py-3 rounded-xl font-semibold transition-all duration-300 items-center justify-between gap-2 text-sm">
                    <p class="font-semibold text-white">Eliminar rutina</p>
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                        fill="#CCE2E5">
                        <path
                            d="M277.37-111.87q-37.78 0-64.39-26.61t-26.61-64.39v-514.5q-19.15 0-32.33-13.17-13.17-13.18-13.17-32.33t13.17-32.33q13.18-13.17 32.33-13.17H354.5q0-19.15 13.17-32.33 13.18-13.17 32.33-13.17h159.52q19.15 0 32.33 13.17 13.17 13.18 13.17 32.33h168.61q19.15 0 32.33 13.17 13.17 13.18 13.17 32.33t-13.17 32.33q-13.18 13.17-32.33 13.17v514.5q0 37.78-26.61 64.39t-64.39 26.61H277.37Zm405.26-605.5H277.37v514.5h405.26v-514.5ZM398.57-280.24q17.95 0 30.29-12.34 12.34-12.33 12.34-30.29v-274.74q0-17.96-12.34-30.29-12.34-12.34-30.29-12.34-17.96 0-30.42 12.34-12.45 12.33-12.45 30.29v274.74q0 17.96 12.45 30.29 12.46 12.34 30.42 12.34Zm163.1 0q17.96 0 30.3-12.34 12.33-12.33 12.33-30.29v-274.74q0-17.96-12.33-30.29-12.34-12.34-30.3-12.34-17.95 0-30.41 12.34-12.46 12.33-12.46 30.29v274.74q0 17.96 12.46 30.29 12.46 12.34 30.41 12.34Zm-284.3-437.13v514.5-514.5Z" />
                    </svg>
                </button>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>


</x-layout>