{{-- resources/views/user/profile.blade.php --}}

<x-layout :title="'Mi perfil'">
    <div class="max-w-6xl mx-auto px-4">
            {{-- Header: avatar + datos --}}
            <section class="flex flex-col md:flex-row items-center md:items-start gap-6 md:gap-8 mb-6">
                {{-- Avatar (circular, responsivo, recorte seguro) --}}
                <div class="flex-shrink-0">
                    <div
                        class="h-20 w-20 md:h-28 md:w-28 rounded-full overflow-hidden flex items-center justify-center bg-[var(--kälm-lighter)] border-2 border-[var(--kalm-dark)]">
                        @if(isset($user) && $user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name ?? 'Avatar usuario' }}"
                                class="w-full h-full object-cover" loading="lazy" decoding="async" />
                        @else
                            <img src="{{ asset('images/pfp.svg') }}" alt="{{ $user->name ?? 'Avatar por defecto' }}"
                                class="w-full h-full object-contain" loading="lazy" decoding="async" />
                        @endif
                    </div>
                </div>

                {{-- Nombre y meta --}}
                <div class="flex-1 min-w-0">
                    <h1 class="text-2xl sm:text-3xl font-semibold text-[var(--kalm-dark)] leading-tight">
                        {{ $user->name ?? 'Sin nombre' }}
                    </h1>

                    <div
                        class="mt-1 flex flex-col sm:flex-row sm:items-center sm:gap-4 text-sm text-[var(--kalm-text)]">
                        <span class="truncate">{{ $user->email ?? 'Sin email' }}</span>
                        <span class="hidden sm:inline text-[var(--kalm-light)]">&middot;</span>
                        <span class="text-[var(--kalm-light)]">
                            Miembro desde: {{ optional($user->created_at)->format('d M Y') }}
                        </span>

                    </div>

                    {{-- Stats pequeños --}}
                    <div class="mt-4 flex items-center gap-4 text-sm text-[var(--kalm-text)]">
                        <div class="flex items-center gap-2">
                            <strong class="text-[var(--kalm-dark)]">{{ $user->followers_count ?? 0 }}</strong>
                            <span class="text-xs">seguidores</span>
                        </div>

                        {{-- placeholder para otras estadísticas --}}
                        <div class="flex items-center gap-2">
                            <strong class="text-[var(--kalm-dark)]">{{ $user->posts_count ?? 0 }}</strong>
                            <span class="text-xs">publicaciones</span>
                        </div>
                    </div>
                </div>

                {{-- Acciones (mobile stacked debajo en md aparece a la derecha) --}}
                <div class="mt-4 md:mt-0 md:flex-shrink-0">
                    <div class="flex gap-3">
                        <a href="{{ route('profile.edit') }}" class="btn btn-primary">Editar perfil</a>

                        <form action="{{ route('auth.logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="btn btn-ghost">Cerrar sesión</button>
                        </form>
                    </div>
                </div>
            </section>

            {{-- Contenido principal: bio, datos y tarjetas --}}
            <section class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Columna principal --}}
                <div class="md:col-span-2 space-y-4">
                    {{-- Card: Acerca de / bio --}}
                    <div class="p-4 rounded-lg shadow-sm bg-[var(--kalm-lighter)]">
                        <h2 class="text-lg font-semibold text-[var(--kalm-dark)]">Acerca de</h2>
                        <p class="text-sm mt-2 text-[var(--kalm-text)]">
                            {{ $user->bio ?? 'No hay información adicional.' }}
                        </p>
                        {{-- Ejemplo de campos adicionales (si existen) --}}
                        <div class="mt-3 text-sm text-[var(--kalm-text)]">
                            @if(!empty($user->location))
                                <p><strong class="text-[var(--kalm-dark)]">Ubicación:</strong> {{ $user->location }}</p>
                            @endif
                            @if(!empty($user->website))
                                <p>
                                    <strong class="text-[var(--kalm-dark)]">Sitio:</strong>
                                    <a href="{{ $user->website }}" target="_blank" rel="noopener noreferrer"
                                        class="link link-primary">
                                        {{ $user->website }}
                                    </a>
                                </p>
                            @endif
                        </div>
                    </div>


                </div>

                {{-- Columna lateral: datos rápidos / contactos --}}
                <aside class="space-y-4">
                    <div class="p-4 rounded-lg shadow-sm bg-white border">
                        <h3 class="text-md font-semibold text-[var(--kalm-dark)] mb-2">Información</h3>
                        <ul class="text-sm text-[var(--kalm-text)] space-y-1">
                            <li><strong class="text-[var(--kalm-dark)]">Email:</strong> {{ $user->email ?? '—' }}</li>
                            <li><strong class="text-[var(--kalm-dark)]">Usuario:</strong> {{ $user->username ??
                                \Illuminate\Support\Str::slug($user->name ?? 'usuario', '') }}</li>
                            <li><strong class="text-[var(--kalm-dark)]">Miembro desde:</strong>
                                {{ optional($user->created_at)->format('d M, Y') ?? '—' }}</li>
                        </ul>
                    </div>

                    <div class="p-4 rounded-lg shadow-sm bg-white border">
                        <h3 class="text-md font-semibold text-[var(--kalm-dark)] mb-2">Opciones</h3>
                        <div class="flex flex-col gap-2">
                            <a href="{{ route('profile.edit') }}" class="btn btn-outline btn-sm">Editar perfil</a>
                            <a href="{{ route('home') }}" class="btn btn-ghost btn-sm">Volver al inicio</a>
                        </div>
                    </div>
                </aside>
            </section>
        </div>
</x-layout>
