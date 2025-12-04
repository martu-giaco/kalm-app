<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class ProductCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'type_id',
        'icon_svg',
    ];

    /**
     * Relación hasMany hacia Product.
     */
    public function products()
    {
        $candidates = [
            'product_category_id',
            'category_id',
            'product_categories_id',
        ];

        $chosenFk = null;
        foreach ($candidates as $fk) {
            if (Schema::hasColumn('products', $fk)) {
                $chosenFk = $fk;
                break;
            }
        }

        if (!$chosenFk) {
            $chosenFk = 'category_id';
        }

        return $this->hasMany(\App\Models\Product::class, $chosenFk, 'id');
    }

    /**
     * Usar slug para rutas automáticamente si existe
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Generar slug automáticamente al crear o actualizar
     */
    protected static function booted()
    {
        static::creating(function ($category) {
            if (empty($category->slug) && !empty($category->name)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

}

