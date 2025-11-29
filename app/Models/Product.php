<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'product_id',
        'name',
        'brand_id',
        'image',
        'description',
        'ingredients',
        'activos',
        'paso',
        'formato',
        'tipo',
        'rating',
        'dondeComprar'
    ];

    // Relación con Brand
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
