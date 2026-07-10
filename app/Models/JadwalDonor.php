<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalDonor extends Model
{
    protected $table = 'jadwal_donor';

    protected $fillable = [
        'judul',
        'lokasi',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'kuota',
        'keterangan',
        'status',
        'dibuat_oleh',
    ];

    protected $casts = [
        'tanggal'    => 'date',
        'jam_mulai'  => 'string',
        'jam_selesai'=> 'string',
    ];

    public function pembuatJadwal()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }

    public function donor()
    {
        return $this->hasMany(Donor::class);
    }
}
