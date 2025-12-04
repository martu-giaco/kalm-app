<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Routine extends Model
{
    // Indicar la clave primaria real
    protected $primaryKey = 'routine_id';

    // Si la PK es autoincremental
    public $incrementing = true;

    // Tipo de la PK
    protected $keyType = 'int';

    // Si la tabla no tiene timestamps
    public $timestamps = true;

    // Columnas asignables masivamente
    protected $fillable = [
        'user_id',
        'name',
        'type',
        'time',
        'products', // si lo almacenas como JSON
    ];

    // Cast para JSON <-> array
    protected $casts = [
        'products' => 'array',
    ];

    /**
     * Relación con el usuario dueño de la rutina
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relación con tipos de rutina (muchos a muchos)
     */
    public function types()
    {
        return $this->belongsToMany(
            RoutineType::class,        // Modelo relacionado
            'routines_have_types',     // Tabla pivote
            'routine_fk',              // FK en la tabla pivote hacia Routine
            'type_fk'                  // FK en la tabla pivote hacia RoutineType
        );
    }

    /**
     * Relación con tiempos de rutina
     * Si una rutina tiene un solo tiempo asociado
     */
    public function times()
    {
        return $this->belongsTo(
            RoutineTime::class, // Modelo relacionado
            'time',             // FK en esta tabla (routines.time)
            'time_fk'           // PK en la tabla RoutineTime
        );
    }



    /**
     * Relación con productos (muchos a muchos)
     */
    public function products()
    {
        return $this->belongsToMany(
            Product::class,     // Modelo relacionado
            'routine_product',  // Tabla pivote
            'routine_id',       // FK en pivote hacia Routine
            'product_id'        // FK en pivote hacia Product
        );
    }
}
