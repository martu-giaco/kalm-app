<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'avatar',
        'bio',
        'role',
        'theme',
        'accepted_terms',
        'terms_accepted_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'accepted_terms' => 'boolean',
        'terms_accepted_at' => 'datetime',
    ];

    // Si usás Laravel 10+ y querés hashing automático, podés mantenerlo;
    // si no, asegurate de hashear al crear el usuario (lo hacemos en el controller).

    // Accessor para url de avatar
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            // si guardaste en storage
            return asset('storage/' . $this->avatar);
        }

        // fallback
        return asset('images/pfp.svg');
    }

    // Mutator (opcional) para username limpio
    public function setUsernameAttribute($value)
    {
        $this->attributes['username'] = $value ? Str::slug($value) : null;
    }

    // Scope para admins
    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }
}
