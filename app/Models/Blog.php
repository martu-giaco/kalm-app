<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Blog extends Model
{
    use HasFactory;

    protected $table = 'blogs';

    protected $fillable = [
        'title',
        'description',
        'image',
        'author',
        'credentials',
        'content',
        'is_premium',
        'type_id',
    ];

    protected $casts = [
        'is_premium' => 'boolean',
    ];

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    // Relación temporal de likes por usuario (no se guarda en DB)
    public function isLikedByUser($userId)
    {
        return in_array($userId, $this->tempLikes ?? []);
    }
}
