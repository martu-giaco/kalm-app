<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $table = 'tests';

    // Permitir asignación masiva
    protected $fillable = [
        'key',
        'title',
        'description',
        'questions',
    ];

    // Opcional: decirle a Laravel que questions es un array (JSON)
    protected $casts = [
        'questions' => 'array',
    ];
}
