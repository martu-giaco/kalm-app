<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Routine extends Model
{
    protected $table = 'routines';

    public $incrementing = true;

    protected $primaryKey = 'routine_id'; //


    // 🔹 Permitir asignación masiva
    protected $fillable = [
        'name',
        'user_id',
        'time_id',   // FK a routine_times
        'products',  // JSON de productos
    ];

    // 🔹 Cast de productos a array automáticamente
    protected $casts = [
        'products' => 'array',
        'steps' => 'array',
    ];

    /**
     * Usuario dueño de la rutina (uno a muchos inverso)
     */
    public function user() {
        return $this->belongsTo(User::class, 'user_id'); // si usas user_id
    }

    /**
     * Relación con RoutineTime (uno a uno inverso)
     */
    public function routineTime(): BelongsTo
    {
        return $this->belongsTo(RoutineTime::class, 'time_id', 'time_id');
    }

    /**
     * Relación con RoutineType (muchos a muchos)
     */
    public function types(): BelongsToMany
    {
        return $this->belongsToMany(
            RoutineType::class,
            'routines_have_types',
            'routine_fk', // FK en la tabla pivote a routines
            'type_fk'     // FK en la tabla pivote a routine_types
        );
    }

    /**
     * Accesor para obtener productos como array
     */
    public function getProductsAttribute($value): array
    {
        // Si ya es array, devolverlo directamente
        if (is_array($value)) {
            return $value;
        }

        // Si es null o string, decodificar JSON
        $decoded = json_decode($value ?? '[]', true);

        // Asegurarse que siempre devuelva array
        return is_array($decoded) ? $decoded : [];
    }

    public function times()
    {
        return $this->belongsTo(RoutineTime::class, 'time_id'); // 'time_id' es la clave foránea
    }


    /**
     * Mutador para guardar productos como JSON
     */
    public function setProductsAttribute($value)
    {
        // Guardar como JSON solo si es array, sino []
        $this->attributes['products'] = is_array($value) ? json_encode($value) : json_encode([]);
    }

    public function products()
{
    return $this->belongsToMany(Product::class, 'routine_product', 'routine_id', 'product_id');
}



}
