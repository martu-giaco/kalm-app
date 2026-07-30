<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoutineNeed extends Model
{
    protected $table = 'routine_needs';
    protected $primaryKey = 'need_id';
    protected $fillable = ['name'];
}
