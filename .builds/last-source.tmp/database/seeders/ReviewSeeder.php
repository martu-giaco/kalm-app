<?php 

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\User;
use App\Models\Product;

class ReviewSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();
        $products = Product::all();

        foreach ($products as $product) {
            foreach ($users->take(3) as $user) { // max 3 reviews por producto
                Review::create([
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                    'rating' => rand(3, 5),
                    'comment' => 'Reseña de ejemplo para ' . $product->name,
                ]);
            }
        }
    }
}
