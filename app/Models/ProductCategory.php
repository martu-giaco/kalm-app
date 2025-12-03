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
        // si tenés slug u otros campos agrégalos aquí
        'slug',
        'type_id',
    ];

    /**
     * Devuelve la relación hasMany hacia Product.
     *
     * Este método intenta adivinar la foreign key más común en la tabla `products`:
     * - product_category_id
     * - category_id
     * - product_categories_id (menos probable)
     *
     * Si ninguna existe usa por defecto 'category_id' (común).
     */
    public function products()
    {
        // Lista de nombres de FK candidatos (ordenados por preferencia)
        $candidates = [
            'product_category_id',
            'category_id',
            'product_categories_id',
            // agregá aquí otros nombres si sabés que tu esquema usa otro
        ];

        // Detectar columna existente en la tabla products
        $chosenFk = null;
        foreach ($candidates as $fk) {
            if (Schema::hasColumn('products', $fk)) {
                $chosenFk = $fk;
                break;
            }
        }

        // Si no encontramos ninguno, usamos 'category_id' por defecto
        if (! $chosenFk) {
            $chosenFk = 'category_id';
        }

        // Retornamos la relación hasMany indicando el foreign key detectado
        return $this->hasMany(\App\Models\Product::class, $chosenFk, 'id');
        // signature: hasMany(Target::class, foreignKeyOnTarget, localKeyOnThisModel)
    }

    /**
     * Opcional: helper para obtener el slug (si usás slug)
     */
    public function getRouteKeyName()
    {
        // Si tenés slug en la tabla, puedes descomentar:
        // return Schema::hasColumn($this->getTable(), 'slug') ? 'slug' : 'id';

        // Por defecto usamos id
        return 'id';
    }
}
