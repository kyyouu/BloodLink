<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermintaanDarah extends Model
{
    protected $table = 'permintaan_darah';

    // status: menunggu | diproses | dipenuhi | ditolak
    protected $fillable = [
        'rumah_sakit_id',
        'golongan_darah',
        'rhesus',
        'jumlah_kantong',
        'keperluan',
        'nama_pasien',
        'tanggal_dibutuhkan',
        'status',
        'catatan_rs',
        'catatan_pmi',
        'diproses_oleh',
        'tanggal_proses',
    ];

    protected $casts = [
        'tanggal_dibutuhkan' => 'date',
        'tanggal_proses'     => 'datetime',
    ];

    public function rumahSakit()
    {
        return $this->belongsTo(RumahSakit::class);
    }

    public function diprosesByPetugas()
    {
        return $this->belongsTo(User::class, 'diproses_oleh');
    }
}
