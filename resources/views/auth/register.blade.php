<!-- filepath: resources/views/auth/register.blade.php -->
<x-layout>
    <div class="container my-5">
        <x-slot:title>Registrate</x-slot:title>

        <h1 class="mb-3">Crear una cuenta</h1>

        <form action="{{ route('auth.register.store') }}" method="POST" novalidate>
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Nombre y apellido</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                @error('name')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
                @error('email')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" name="password" id="password" class="form-control" required>
                @error('password')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Repetir contraseña</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                    required>
            </div>

            <input type="submit" value="Registrarme" class="btn btn-primary">

            <p class="mt-3 small">
                ¿Ya tenés una cuenta? <a href="{{ route('auth.login') }}">Ingresar</a>
            </p>
        </form>
    </div>
</x-layout>
