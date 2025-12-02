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
        'products',
    ];

    protected $casts = [
        'products' => 'array', // convierte JSON <-> array automáticamente
    ];

    // Solo permite 'dia' o 'noche'
    public function setTypeAttribute($value)
    {
        $allowed = ['dia', 'noche'];

        if (!in_array($value, $allowed)) {
            throw new \InvalidArgumentException("El tipo de rutina debe ser 'dia' o 'noche'.");
        }

        $this->attributes['type'] = $value;
    }

    // Relación con usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
