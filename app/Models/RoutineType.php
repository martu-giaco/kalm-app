<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoutineType extends Model
{
    protected $table = 'routine_types';
    protected $primaryKey = 'type_id';
    protected $fillable = ['name'];
}
