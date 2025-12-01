<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PostLike;


class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'content',
        'category',
        'image',
        'is_reported',
        'is_deleted',
        'admin_notes',
    ];

    protected $casts = [
        'is_reported' => 'boolean',
        'is_deleted' => 'boolean',
    ];

    // Relación con usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con comentarios
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Relación con likes
    public function post_likes()
    {
        return $this->hasMany(PostLike::class);
    }

    // Relación con saves
    public function post_saves()
    {
        return $this->hasMany(PostSave::class);
    }

    // Scope para posts activos
    public function scopeActive($query)
    {
        return $query->where('is_deleted', false);
    }
}
