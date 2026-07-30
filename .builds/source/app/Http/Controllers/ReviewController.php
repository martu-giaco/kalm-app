<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Product;

class ReviewController extends Controller
{
    /**
     * Mostrar el formulario para crear o editar la reseña del usuario
     */
    public function create(Product $product)
    {
        $user = auth()->user();

        // Revisar si el usuario ya tiene reseña para este producto
        $userReview = $product->reviews()->where('user_id', $user->id)->first();

        return view('reviews.create', compact('product', 'userReview'));
    }

    /**
     * Guardar una nueva reseña o actualizar la existente
     */
    public function store(Request $request, Product $product)
    {
        $user = auth()->user();

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        // Update or create reseña
        Review::updateOrCreate(
            [
                'user_id' => $user->id,
                'product_id' => $product->id,
            ],
            [
                'rating' => $request->rating,
                'comment' => $request->comment,
            ]
        );

        return redirect()->route('reviews.show', $product)
            ->with('feedback', ['message' => 'Reseña guardada correctamente.', 'type' => 'success']);
    }

    /**
     * Mostrar todas las reseñas de un producto
     */
    public function show(Product $product)
    {
        $reviews = $product->reviews()->latest()->get();

        // Calcular rating promedio basado en todas las reseñas
        $avgRating = $reviews->avg('rating') ?: 0;

        return view('reviews.show', compact('product', 'reviews', 'avgRating'));
    }

    /**
     * Mostrar formulario de edición de reseña
     */
    public function edit(Review $review)
    {
        $this->authorizeReview($review);

        return view('reviews.edit', [
            'product' => $review->product,
            'userReview' => $review
        ]);
    }

    /**
     * Actualizar reseña existente
     */
    public function update(Request $request, Review $review)
    {
        $this->authorizeReview($review);

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        $review->update($request->only('rating', 'comment'));

        return redirect()->route('reviews.show', $review->product)
            ->with('feedback', ['message' => 'Reseña actualizada correctamente.', 'type' => 'success']);
    }

    /**
     * Eliminar reseña
     */
    public function destroy(Product $product, Review $review)
    {
        $this->authorizeReview($review);

        $review->delete();

        return redirect()->route('reviews.show', $product)
            ->with('feedback', ['message' => 'Reseña eliminada correctamente.', 'type' => 'success']);
    }

    /**
     * Autoriza solo al dueño de la reseña o a un admin.
     */
    private function authorizeReview(Review $review)
    {
        $user = auth()->user();

        if (!$user || ($user->id != $review->user_id && $user->role !== 'admin')) {
            abort(403, 'No tenés permiso para realizar esta acción.');
        }
    }
}
