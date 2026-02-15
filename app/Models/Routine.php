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

    protected $fillable = [
        'name',
        'user_id',
        'time_id',
        'type_id',
        'need_id',
        'products',
        'steps',
    ];

    protected $casts = [
        'products' => 'array',
        'steps' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function routineTime(): BelongsTo
    {
        return $this->belongsTo(RoutineTime::class, 'time_id', 'time_id');
    }

    public function routineType(): BelongsTo
    {
        return $this->belongsTo(RoutineType::class, 'type_id', 'type_id');
    }

    public function routineNeed(): BelongsTo
    {
        return $this->belongsTo(RoutineNeed::class, 'need_id', 'need_id');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(
            Product::class,
            'routine_product',
            'routine_id',
            'product_id'
        );
    }

    public function assignedProducts()
    {
        return $this->products();
    }
}
