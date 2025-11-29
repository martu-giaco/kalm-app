<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'post_id',
        'content',
        'category',
    ];

    // Relación con User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
