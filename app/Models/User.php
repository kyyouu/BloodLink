<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'nama',
        'email',
        'password',
        'role',
        'foto_profil',
        'no_telepon',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active'         => 'boolean',
    ];

    /** Accessor: alias 'name' → 'nama' for Breeze compatibility */
    public function getNameAttribute(): string
    {
        return $this->nama ?? '';
    }

    public function pendonor()
    {
        return $this->hasOne(Pendonor::class);
    }

    public function rumahSakit()
    {
        return $this->hasOne(RumahSakit::class);
    }

    public function notifikasi()
    {
        return $this->hasMany(Notifikasi::class);
    }
}
