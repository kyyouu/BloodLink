<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donor extends Model
{
    protected $table = 'donor';

    // status: terdaftar | lolos_skrining | selesai | ditolak
    protected $fillable = [
        'pendonor_id',
        'jadwal_donor_id',
        'petugas_id',
        'tanggal_donor',
        'golongan_darah',
        'rhesus',
        'volume_ml',
        'tekanan_darah',
        'hemoglobin',
        'berat_badan',
        'status',
        'catatan',
    ];

    protected $casts = [
        'tanggal_donor' => 'date',
    ];

    public function pendonor()
    {
        return $this->belongsTo(Pendonor::class);
    }

    public function jadwalDonor()
    {
        return $this->belongsTo(JadwalDonor::class);
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    public function riwayatDonor()
    {
        return $this->hasOne(RiwayatDonor::class);
    }
}
