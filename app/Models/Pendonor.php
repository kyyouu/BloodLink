<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendonor extends Model
{
    protected $table = 'pendonor';

    protected $fillable = [
        'user_id',
        'nik',
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'golongan_darah',
        'rhesus',
        'alamat',
        'kota',
        'no_telepon',
        'pekerjaan',
        'berat_badan',
        'tinggi_badan',
        'riwayat_penyakit',
        'status_aktif',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'status_aktif'  => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function donor()
    {
        return $this->hasMany(Donor::class);
    }

    public function riwayatDonor()
    {
        return $this->hasMany(RiwayatDonor::class);
    }
}
