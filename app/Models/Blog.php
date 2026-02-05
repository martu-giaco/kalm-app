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
        'image',
        'author',
        'credentials',
        'content',
        'is_premium',
    ];

    protected $casts = [
        'is_premium' => 'boolean', 
    ];

    // Relación temporal de likes por usuario (no se guarda en DB)
    public function isLikedByUser($userId)
    {
        return in_array($userId, $this->tempLikes ?? []);
    }
}
