<!-- resources/views/users/index.blade.php -->

<x-layout>
    <div class="container my-5 bg-white rounded-t-3xl min-h-full pt-5">
        <h1 class="mb-4 ps-5 text-3xl font-bold text-[#306067]">Usuarios</h1>

        @if(session('feedback.message'))
            <div class="alert alert-success">{{ session('feedback.message') }}</div>
        @endif

        @if($users->isEmpty())
            <p class="text-muted">No hay usuarios todavía.</p>
        @else
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->role }}</td>
                                <td>
                                    <a href="{{ route('admin.users.view', $user) }}" class="btn btn-sm btn-info">Ver</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-layout>
