<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Routine extends Model
{
    protected $table = 'routines';
    protected $primaryKey = 'routine_id';
    public $incrementing = true;

    protected $fillable = [
    'name', 'user_id', 'time_id', 'type_id', 'need_id',
    'steps', 'reminder_time', 'is_reminder_enabled',
    'reminder_frequency', 'reminder_days', 'reminder_interval', // <-- Agregar estos campos
];

protected $casts = [
    'steps' => 'array',
    'is_reminder_enabled' => 'boolean',
    'reminder_time' => 'datetime:H:i',
    'reminder_days' => 'array', // <-- Cambiar o agregar para que Laravel maneje el JSON automáticamente
];

    public function user(): BelongsTo { return $this->belongsTo(User::class, 'user_id'); }
    public function routineTime(): BelongsTo { return $this->belongsTo(RoutineTime::class, 'time_id', 'time_id'); }
    public function type() { return $this->belongsTo(Type::class); }
    public function routineNeed(): BelongsTo { return $this->belongsTo(RoutineNeed::class, 'need_id', 'need_id'); }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'routine_product', 'routine_id', 'product_id');
    }

    public function assignedProducts() { return $this->products(); }

    protected $appends = ['formatted_time'];

protected function formattedTime(): Attribute
{
    return Attribute::get(fn () => $this->reminder_time 
        ? \Illuminate\Support\Carbon::parse($this->reminder_time)->format('H:i') 
        : null
    );
}
}
