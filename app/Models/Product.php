<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Para que el accesor image_url se agregue automáticamente al convertir a array o JSON
    protected $appends = ['image_url'];

    // Columnas que se pueden llenar masivamente
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

public function routines()
{
    return $this->belongsToMany(
        Routine::class,   // Modelo relacionado
        'routine_product', // Nombre exacto de la tabla pivote
        'product_id',      // FK del producto en la tabla pivote
        'routine_id'       // FK de la rutina en la tabla pivote
    );
}



    /**
     * Accessor para obtener la URL completa de la imagen.
     * Usa la columna 'image' directamente.
     */
    public function getImageUrlAttribute()
    {
        // Si no hay imagen, usar default
        if (!$this->image) {
            return asset('images/products/default.png');
        }

        // Si ya viene con subcarpeta 'images/products/', no concatenamos
        return asset($this->image);
    }

    // Relaciones

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
