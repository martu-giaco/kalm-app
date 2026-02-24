<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Para que el geter image_url se agregue automáticamente
    protected $appends = ['image_url'];

    // Columnas llenables
    protected $fillable = [
        'name',
        'brand_id',
        'type_id',
        'category_id',
        'image',
        'description',
        'ingredients',
        'activos',
        'formato',
        'rating',
        'donde_comprar',
    ];

    // 🔹 Relación con rutinas (tabla pivote)
    public function routines(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(
            Routine::class,
            'routine_product',
            'product_id',  // FK en pivote hacia producto
            'routine_id'   // FK en pivote hacia rutina
        );
    }

    public function getImageUrlAttribute()
            {
                if (!$this->image) return null;

                if (str_starts_with($this->image, 'images/')) {
                    return asset($this->image);
                }

                return asset('storage/' . $this->image);
            }

    // 🔹 Relaciones existentes
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function skinTypes()
        {
            return $this->belongsToMany(SkinType::class);
        }

    public function type()
    {
        return $this->belongsTo(ProductType::class);
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function concerns()
    {
        return $this->belongsToMany(Concern::class);
    }
}
