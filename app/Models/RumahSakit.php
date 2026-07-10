<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RumahSakit extends Model
{
    protected $table = 'rumah_sakit';

    protected $fillable = [
        'user_id',
        'nama_rs',
        'kode_rs',
        'alamat',
        'kota',
        'no_telepon',
        'email',
        'nama_kontak',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function permintaanDarah()
    {
        return $this->hasMany(PermintaanDarah::class);
    }
}
