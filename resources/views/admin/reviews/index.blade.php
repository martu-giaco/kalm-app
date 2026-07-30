<?php
/** @var \Illuminate\Database\Eloquent\Collection|\App\Models\Review[] $reviews */
?>

<x-layout :title="'Reseñas - Panel de Administración'">
    <div class="container min-h-full pt-5 my-5 bg-white rounded-t-3xl">
        <div class="flex items-center justify-between px-5 mb-4">
            <h1 class="text-3xl font-bold text-[#306067]">Reseñas</h1>
        </div>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Producto</th>
                    <th>Calificación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reviews as $review)
                    <tr>
                        <td>{{ $review->id }}</td>
                        <td>{{ $review->user->name ?? 'Usuario eliminado' }}</td>
                        <td>{{ $review->product->name ?? 'Producto eliminado' }}</td>
                        <td>★ {{ $review->rating }}</td>
                        <td>
                            <a href="{{ route('admin.reviews.view', $review) }}" class="btn font-bold text-white bg-[#37A0AF] border-[#37A0AF] btn-info btn-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#FFFFFF"><path d="M240-400q-33 0-56.5-23.5T160-480q0-33 23.5-56.5T240-560q33 0 56.5 23.5T320-480q0 33-23.5 56.5T240-400Zm240 0q-33 0-56.5-23.5T400-480q0-33 23.5-56.5T480-560q33 0 56.5 23.5T560-480q0 33-23.5 56.5T480-400Zm240 0q-33 0-56.5-23.5T640-480q0-33 23.5-56.5T720-560q33 0 56.5 23.5T800-480q0 33-23.5 56.5T720-400Z"/></svg>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-layout>