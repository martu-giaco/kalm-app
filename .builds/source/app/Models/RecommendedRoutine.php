<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\RoutineTime;

class RecommendedRoutine extends Model
{
    use HasFactory;

    protected $table = 'routines_recommended';

    protected $fillable = [
        'test_key',
        'result_key',
        'name',
        'description',
        'frequency',
        'time_of_day',
        'products', // IDs de productos en JSON
        'user_test_result_id',
    ];

    /**
     * Relación opcional con RoutineTime
     */
    public function routineTime()
    {
        return $this->belongsTo(RoutineTime::class, 'time_of_day', 'name');
    }

    /**
     * Devuelve los productos como colección de Eloquent
     * Accesible vía: $routine->products_collection
     */
    public function getProductsCollectionAttribute()
    {
        $ids = $this->getAttributeValue('products');
        $ids = is_string($ids) ? json_decode($ids, true) : $ids;
        return Product::whereIn('id', $ids ?? [])->get();
    }
}
