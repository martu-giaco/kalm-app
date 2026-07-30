<?php
/** \Illuminate\Support\ViewErrorBag $errors */
?>

<x-layout>
    <div class="container min-h-full px-5 pt-5 my-5 bg-white rounded-t-3xl">

        <h1 class="text-3xl font-bold text-[#306067] mb-4">Editar Reseña</h1>

        <form action="{{ route('admin.reviews.update', $review->id) }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="mb-3">
                <label for="rating" class="block mb-1 text-sm font-bold text-[#2A4043]">Calificación (1 a 5)</label>
                <select name="rating" id="rating" class="w-full p-3 mb-3 bg-transparent rounded-xl border-2 border-[#CCE2E5] placeholder-[#CCE2E5] focus:outline-[#37A0AF] text-md text-[#2A4043]">
                    @for($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}" {{ old('rating', $review->rating) == $i ? 'selected' : '' }}>
                            {{ $i }} ★
                        </option>
                    @endfor
                </select>
                @error('rating')
                    <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
                @enderror
            </div>

            <div class="mt-3 mb-5">
                <label for="comment" class="block mb-1 text-sm font-bold text-[#2A4043]">Comentario</label>
                <textarea name="comment" id="comment" rows="5" class="w-full p-3 mb-3 bg-transparent rounded-xl border-2 border-[#CCE2E5] placeholder-[#CCE2E5] focus:outline-[#37A0AF] text-md text-[#2A4043]">{{ old('comment', $review->comment) }}</textarea>
                @error('comment')
                    <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn w-full px-5 py-3 rounded-xl text-white font-bold transition cursor-pointer disabled:opacity-80 disabled:cursor-not-allowed hover:bg-[#306067] bg-[#306067]">Actualizar Reseña</button>
        </form>
    </div>
</x-layout>