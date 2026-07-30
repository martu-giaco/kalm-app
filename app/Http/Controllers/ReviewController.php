<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Product;

class ReviewController extends Controller
{
    public function create(Product $product)
    {
        // 1. Verificación opcional de rol si el middleware no lo detiene
        if (auth()->user()->role === 'free') {
            return redirect()->route('subscription.show')
                ->with('info', 'Debes ser usuario Premium para dejar una reseña.');
        }

        // 2. Retornar la vista pasando el producto
        return view('reviews.create', compact('product'));
    }

    public function store(Request $request, Product $product)
    {
        $user = auth()->user();

        $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
            'image'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = [
            'rating'  => $request->rating,
            'comment' => $request->comment,
        ];

        // Procesamiento de la imagen hacia public_html/images/reviews
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            
            $destinationPath = $this->getPublicPath('images/reviews');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            // Si ya existe una reseña previa con imagen, la borramos antes de reemplazarla
            $existingReview = $product->reviews()->where('user_id', $user->id)->first();
            if ($existingReview && $existingReview->image) {
                $oldImagePath = $this->getPublicPath($existingReview->image);
                if (file_exists($oldImagePath)) {
                    @unlink($oldImagePath);
                }
            }

            $file->move($destinationPath, $fileName);
            $data['image'] = 'images/reviews/' . $fileName;
        }

        Review::updateOrCreate(
            [
                'user_id'    => $user->id,
                'product_id' => $product->id,
            ],
            $data
        );

        return redirect()->route('reviews.show', $product)
            ->with('feedback', ['message' => 'Reseña guardada correctamente.', 'type' => 'success']);
    }

    public function show(Product $product)
    {
        $reviews = $product->reviews()->latest()->get();
        $avgRating = $reviews->avg('rating') ?: 0;

        return view('reviews.show', compact('product', 'reviews', 'avgRating'));
    }

    public function edit(Review $review)
    {
        $this->authorizeReview($review);

        return view('reviews.edit', [
            'product'    => $review->product,
            'userReview' => $review
        ]);
    }

    public function update(Request $request, Review $review)
    {
        $this->authorizeReview($review);

        $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
            'image'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = [
            'rating'  => $request->rating,
            'comment' => $request->comment,
        ];

        if ($request->hasFile('image')) {
            $destinationPath = $this->getPublicPath('images/reviews');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            // Eliminar imagen anterior si existía
            if ($review->image) {
                $oldImagePath = $this->getPublicPath($review->image);
                if (file_exists($oldImagePath)) {
                    @unlink($oldImagePath);
                }
            }

            // Subir nueva imagen
            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $filename);

            $data['image'] = 'images/reviews/' . $filename;
        }

        $review->update($data);

        return redirect()->route('reviews.show', $review->product_id)
            ->with('feedback', ['message' => 'Reseña actualizada correctamente.', 'type' => 'success']);
    }

    public function destroy(Product $product, Review $review)
    {
        $this->authorizeReview($review);

        // Eliminar archivo de la carpeta pública
        if ($review->image) {
            $imagePath = $this->getPublicPath($review->image);
            if (file_exists($imagePath)) {
                @unlink($imagePath);
            }
        }

        $review->delete();

        return redirect()->route('reviews.show', $product)
            ->with('feedback', ['message' => 'Reseña eliminada correctamente.', 'type' => 'success']);
    }

    private function authorizeReview(Review $review)
    {
        $user = auth()->user();

        if (!$user || ($user->id != $review->user_id && $user->role !== 'admin')) {
            abort(403, 'No tenés permiso para realizar esta acción.');
        }
    }

    /**
     * Devuelve la ruta absoluta al directorio público (public_html o public)
     */
    private function getPublicPath(string $subpath = ''): string
    {
        $basePublicDir = file_exists(base_path('public_html')) 
            ? base_path('public_html') 
            : public_path();

        $subpath = ltrim($subpath, '/');

        return $subpath ? $basePublicDir . '/' . $subpath : $basePublicDir;
    }
    
    public function adminIndex()
    {
        $reviews = Review::with(['user', 'product'])->paginate(15);

        return view('admin.reviews.index', compact('reviews'));
    }

    /**
     * Muestra una reseña específica.
     */
    public function adminView(Review $review)
    {
        return view('admin.reviews.show', compact('review'));
    }

    /**
     * Muestra el formulario para editar una reseña.
     */
    public function adminEdit(Review $review)
    {
        return view('admin.reviews.edit', compact('review'));
    }

    /**
     * Actualiza la reseña especificada.
     */
    public function adminUpdate(Request $request, Review $review)
    {
        $validated = $request->validate([
            'comment' => 'required|string',
            'rating'  => 'required|integer|min:1|max:5',
        ]);

        $review->update($validated);

        return redirect()->route('admin.reviews.index')->with('success', 'Reseña actualizada correctamente.');
    }

    /**
     * Elimina una reseña desde el panel de administración.
     */
    public function adminDestroy(Review $review)
    {
        $review->delete();

        return redirect()->route('admin.reviews.index')->with('success', 'Reseña eliminada correctamente.');
    }
}