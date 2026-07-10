<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StokDarah extends Model
{
    protected $table = 'stok_darah';

    protected $fillable = [
        'golongan_darah',
        'rhesus',
        'jumlah_kantong',
        'satuan',
        'keterangan',
        'diperbarui_oleh',
    ];

    protected $casts = [
        'jumlah_kantong' => 'integer',
    ];

    // Override updated_at only — no created_at auto for updated_at
    public $timestamps = true;

    public function diperbarui()
    {
        return $this->belongsTo(User::class, 'diperbarui_oleh');
    }
}
