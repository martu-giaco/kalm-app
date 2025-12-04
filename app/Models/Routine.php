<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Routine extends Model
{
    protected $table = 'routines';
    protected $primaryKey = 'routine_id';
    public $incrementing = true;

    // 🔹 Asignación masiva
    protected $fillable = [
        'name',
        'user_id',
        'time_id',
        'products', // Mantener por compatibilidad histórica (JSON)
        'steps',    // Mantener por compatibilidad
    ];

    // 🔹 Casts
    protected $casts = [
        'products' => 'array',
        'steps' => 'array',
    ];

    // 🔹 Usuario dueño de la rutina
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // 🔹 Tiempo de la rutina
    public function routineTime(): BelongsTo
    {
        return $this->belongsTo(RoutineTime::class, 'time_id', 'time_id');
    }

    public function times()
    {
        return $this->belongsTo(RoutineTime::class, 'time_id');
    }

    // 🔹 Relación con tipos de rutina (muchos a muchos)
    public function types(): BelongsToMany
    {
        return $this->belongsToMany(
            RoutineType::class,
            'routines_have_types',
            'routine_fk', // FK de rutina en la tabla pivote
            'type_fk'     // FK del tipo en la tabla pivote
        );
    }

    // 🔹 Relación correcta con productos (tabla pivote)
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(
            Product::class,
            'routine_product',
            'routine_id', // FK en tabla pivote hacia rutina
            'product_id'  // FK en tabla pivote hacia producto
        );
    }
// Routine.php
public function assignedProducts()
{
    return $this->belongsToMany(Product::class, 'routine_product', 'routine_id', 'product_id');
}

}
