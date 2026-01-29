<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class blog extends Model
{
    protected $table = 'blogs';

    protected $fillable = [
        'blog_id',
        'title',
        'imagen',
        'author',
        'credentials',
        'content',
    ];

}
