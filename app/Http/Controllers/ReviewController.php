<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Product;

class ReviewController extends Controller
{
    // Crear o actualizar reseña de un producto
    public function store(Request $request, Product $product)
    {
        $user = auth()->user();

        // Validación
        $request->validate([
            'rating' => 'required|integer|min:0|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        // Verificar si ya existe review
        $review = Review::byUserAndProduct($user->id, $product->id)->first();

        if ($review) {
            // Actualizar review existente
            $review->update([
                'rating' => $request->rating,
                'comment' => $request->comment,
            ]);
        } else {
            // Crear nueva review
            Review::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'rating' => $request->rating,
                'comment' => $request->comment,
            ]);
        }

        return redirect()->back()->with('success', 'Reseña guardada correctamente.');
    }
}
