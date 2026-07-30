<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Review extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'rating',
        'comment',
        'image',
    ];

    // Relación con Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relación con User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scope para verificar si un usuario ya revisó un producto
    public function scopeByUserAndProduct($query, $userId, $productId)
    {
        return $query->where('user_id', $userId)
                    ->where('product_id', $productId);
    }
}
