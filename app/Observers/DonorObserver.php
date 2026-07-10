<?php

namespace App\Observers;

use App\Models\Donor;
use App\Models\Notifikasi;
use App\Models\RiwayatDonor;
use App\Models\StokDarah;

class DonorObserver
{
    /**
     * Saat status donor berubah menjadi 'selesai':
     * 1. Tambah ke riwayat_donor
     * 2. Update stok_darah (+1 kantong)
     * 3. Kirim notifikasi ke pendonor
     */
    public function updated(Donor $donor): void
    {
        if ($donor->isDirty('status') && $donor->status === 'selesai') {
            // 1. Catat ke riwayat
            RiwayatDonor::updateOrCreate(
                ['donor_id' => $donor->id],
                [
                    'pendonor_id'   => $donor->pendonor_id,
                    'tanggal_donor' => $donor->tanggal_donor,
                    'lokasi'        => $donor->jadwalDonor?->lokasi,
                    'golongan_darah'=> $donor->golongan_darah,
                    'rhesus'        => $donor->rhesus,
                    'volume_ml'     => $donor->volume_ml,
                    'status'        => 'selesai',
                    'keterangan'    => $donor->catatan,
                ]
            );

            // 2. Tambah stok darah
            StokDarah::where('golongan_darah', $donor->golongan_darah)
                ->where('rhesus', $donor->rhesus)
                ->increment('jumlah_kantong');

            // 3. Notifikasi ke pendonor
            if ($pendonor = $donor->pendonor) {
                Notifikasi::create([
                    'user_id'    => $pendonor->user_id,
                    'judul'      => 'Donor Berhasil!',
                    'pesan'      => 'Terima kasih telah mendonorkan darah pada ' .
                                   $donor->tanggal_donor->format('d/m/Y') .
                                   '. Darah Anda akan menyelamatkan nyawa!',
                    'tipe'       => 'sukses',
                    'url_target' => '/pendonor/riwayat',
                ]);
            }
        }

        // Jika status 'ditolak' — notifikasi alasan
        if ($donor->isDirty('status') && $donor->status === 'ditolak') {
            if ($pendonor = $donor->pendonor) {
                Notifikasi::create([
                    'user_id'    => $pendonor->user_id,
                    'judul'      => 'Donor Tidak Dapat Dilanjutkan',
                    'pesan'      => 'Maaf, proses donor darah Anda pada ' .
                                   $donor->tanggal_donor->format('d/m/Y') .
                                   ' tidak dapat dilanjutkan. ' . ($donor->catatan ?? ''),
                    'tipe'       => 'peringatan',
                    'url_target' => '/pendonor/riwayat',
                ]);
            }
        }
    }
}
