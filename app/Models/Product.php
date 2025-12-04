<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // 🔹 Para que el accesor image_url se agregue automáticamente
    protected $appends = ['image_url'];

    // 🔹 Columnas llenables
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
        'dondeComprar',
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

    // 🔹 Accesor legacy para URL de imagen
    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return asset('images/products/default.png');
        }
        return asset($this->image);
    }

    // 🔹 Relaciones existentes
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function type()
    {
        return $this->belongsTo(ProductType::class);
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class);
    }
}
