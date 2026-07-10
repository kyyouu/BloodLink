<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatDonor extends Model
{
    protected $table    = 'riwayat_donor';
    public    $timestamps = false; // only created_at

    protected $fillable = [
        'pendonor_id',
        'donor_id',
        'tanggal_donor',
        'lokasi',
        'golongan_darah',
        'rhesus',
        'volume_ml',
        'status',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_donor' => 'date',
        'created_at'    => 'datetime',
    ];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = null;

    public function pendonor()
    {
        return $this->belongsTo(Pendonor::class);
    }

    public function donor()
    {
        return $this->belongsTo(Donor::class);
    }
}
