<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Brand extends Model
{
    protected $fillable = [
        'name',
        'logo',
    ];

    public function products(){
        return $this->belongsToMany(Product::class);
    }
}
