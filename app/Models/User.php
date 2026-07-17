<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use NotificationChannels\WebPush\HasPushSubscriptions;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasPushSubscriptions;

    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'bio',
        'role',
        'theme',
        'accepted_terms',
        'terms_accepted_at',
        'favoritos',
        'bookmarked_blogs',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'accepted_terms' => 'boolean',
        'terms_accepted_at' => 'datetime',
        'favoritos' => 'json',
        'bookmarked_blogs' => 'json',
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

    // Scope para admins
    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    public function isPremium()
    {
        return in_array($this->role, ['premium', 'admin']);
    }
    /**
     * Relación con las rutinas del usuario.
     */
    public function routines()
    {
        return $this->hasMany(Routine::class, 'user_id');
    }

    /**
     * Verifica si el usuario puede crear una nueva rutina.
     * Los usuarios free solo pueden tener hasta 2 rutinas.
     *
     * @return bool
     */
    public function canCreateRoutine(): bool
    {
        if ($this->role === 'premium') {
            return true;
        }

        // Si no es premium, cuenta las rutinas actuales y permite crear si tiene menos de 2
        return $this->routines()->count() < 2;
    }

    public function testResults()
    {
        return $this->hasMany(UserTestResult::class);
    }

    public function getFavoritosCountAttribute()
    {
        $favoritos = $this->favoritos ?? [];

        if (!is_array($favoritos)) {
            $favoritos = json_decode($favoritos, true) ?? [];
        }

        return count($favoritos);
    }

    public function getBookmarkedBlogsCountAttribute()
    {
        $bookmarks = $this->bookmarked_blogs ?? [];

        if (!is_array($bookmarks)) {
            $bookmarks = json_decode($bookmarks, true) ?? [];
        }

        return count($bookmarks);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
