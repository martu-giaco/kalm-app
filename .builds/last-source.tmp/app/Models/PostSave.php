<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostSave extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',  // ID del post guardado
        'user_id',  // ID del usuario que guarda el post
    ];

    // Relación con Post
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    // Relación con User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
