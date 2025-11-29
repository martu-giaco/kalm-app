<x-layout>

    <div class="container my-5">
        <x-slot:title>Iniciar Sesion</x-slot:title>

        <h1 class="mb-3">Ingresar a tu cuenta</h1>

        <form action="{{ route('auth.authenticate') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" name="password" id="password" class="form-control">
            </div>
            <input type="submit" value="Ingresar" class="btn btn-primary">
        </form>
    </div>

</x-layout>
