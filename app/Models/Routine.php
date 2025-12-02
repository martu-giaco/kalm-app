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
        'products'
    ];


    // Relación con usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}

