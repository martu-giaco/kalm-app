<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserTestResult extends Model
{
    protected $table = 'user_test_results';

    protected $primaryKey = 'id'; // por defecto, pero es bueno explicitarlo

    protected $fillable = [
        'user_id',
        'routine_id',
        'test_key',     
        'result_key',
        'answers',
    ];

    protected $casts = [
        'answers'     => 'array',
        'created_at'  => 'datetime',
        'updated_at'  => 'datetime',
    ];

    // Relaciones
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function routine(): BelongsTo
    {
        return $this->belongsTo(Routine::class, 'routine_id', 'routine_id');
    }
}