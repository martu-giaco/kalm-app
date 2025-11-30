<x-layout>
    <div class="container my-5 bg-white rounded-t-3xl min-h-[87%]">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">{{ $user->name ?? 'Nombre Desconocido' }}</h3>
            </div>
            <div class="card-body">
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Rol:</strong> {{ $user->role }}</p>
                </p>
            </div>
            <div class="card-footer">
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Volver a Reseñas</a>
            </div>
        </div>
    </div>
</x-layout>
