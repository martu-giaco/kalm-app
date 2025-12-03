<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Routine extends Model
{
    protected $fillable = [
        'user_id',
        'routine_id',
        'name',
        'type',
        'time',
        'products',
    ];

    protected $casts = [
        'products' => 'array', // convierte JSON <-> array automáticamente
    ];

    // Relación con usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function types()
{
    return $this->belongsToMany(
        RoutineType::class,
        'routines_have_types',
        'routine_fk',
        'type_fk'
    );
}

    public function times()
{
    return $this->belongsToMany(
        RoutineTime::class,
        'routine_fk',
        'time_fk'
    );
}
}
