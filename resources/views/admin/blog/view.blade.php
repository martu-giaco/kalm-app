<?php
/** @var \App\Models\Post $blog */
use Illuminate\Support\Facades\Storage;
?>

<x-layout>
    <div class="container my-5">
        <x-slot:title>Detalle de Post — {{ $blog->title ?? 'Detalle' }}</x-slot:title>

        @php
            $imagePath = $blog->image ?? null;
            $storageExists = $imagePath ? Storage::disk('public')->exists($imagePath) : false;
            $publicExists = $imagePath ? file_exists(public_path($imagePath)) : false;

            if ($storageExists) {
                $imageUrl = asset('storage/' . $imagePath);
            } elseif ($publicExists) {
                $imageUrl = asset($imagePath);
            } else {
                $imageUrl = null;
            }
        @endphp

        {{-- Imagen principal / placeholder --}}
        <div class="mb-4 d-flex justify-content-center">
            @if($imageUrl)
                <img src="{{ $imageUrl }}"
                     alt="{{ $blog->title }}"
                     class="img-fluid rounded"
                     style="max-width: 100%; max-height: 480px; object-fit: cover;">
            @else
                <div class="border rounded bg-light d-flex align-items-center justify-content-center"
                     style="width:100%;max-width:800px;height:240px;">
                    <span class="text-muted">Sin imagen disponible</span>
                </div>
            @endif
        </div>

        <h1 class="mb-2">{{ $blog->title }}</h1>

        <p class="text-muted mb-4">
            <strong>Autor:</strong> {{ $blog->author ?? 'Anónimo' }}
            @if(!empty($blog->category))
                | <strong>Categoría:</strong> {{ $blog->category }}
            @endif
            @if($blog->created_at)
                | <small>Publicado: {{ $blog->created_at->format('d/m/Y') }}</small>
            @endif
        </p>

        <div class="mb-4 fs-5" style="white-space:pre-wrap; line-height:1.6;">
            {!! nl2br(e($blog->content)) !!}
        </div>

        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('blogs.index') }}" class="btn btn-secondary">Volver a Posts</a>

            @auth
                <a href="{{ route('blogs.edit', ['blog' => $blog->id]) }}" class="btn btn-outline-primary">
                    <i class="bi bi-pencil"></i> Editar
                </a>

                <form action="{{ route('blogs.destroy', ['blog' => $blog->id]) }}" method="POST" onsubmit="return confirm('¿Confirma que desea eliminar este blog?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash"></i> Eliminar Blog
                    </button>
                </form>
            @endauth
        </div>
    </div>
</x-layout>
