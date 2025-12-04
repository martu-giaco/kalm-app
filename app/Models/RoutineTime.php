<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoutineTime extends Model
{
    protected $table = 'routine_times';
    protected $primaryKey = 'time_id';
    protected $fillable = ['name'];
}
