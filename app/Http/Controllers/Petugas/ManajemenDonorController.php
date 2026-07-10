<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Donor;
use App\Models\StokDarah;
use Illuminate\Http\Request;

class ManajemenDonorController extends Controller
{
    public function index()
    {
        $donor = Donor::with(['pendonor', 'jadwalDonor'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('petugas.donor.index', compact('donor'));
    }

    public function update(Request $request, Donor $donor)
    {
        $request->validate([
            'status'        => 'required|in:terdaftar,lolos_skrining,selesai,ditolak',
            'tekanan_darah' => 'nullable|string|max:20',
            'hemoglobin'    => 'nullable|numeric',
            'berat_badan'   => 'nullable|numeric',
            'volume_ml'     => 'nullable|integer',
            'catatan'       => 'nullable|string|max:500',
        ]);

        $statusLama = $donor->status;
        $statusBaru = $request->status;

        // Update data donor
        $donor->update([
            'status'        => $statusBaru,
            'tekanan_darah' => $request->tekanan_darah,
            'hemoglobin'    => $request->hemoglobin,
            'berat_badan'   => $request->berat_badan,
            'volume_ml'     => $request->volume_ml ?? 450,
            'catatan'       => $request->catatan,
            'petugas_id'    => auth()->id(),
        ]);

        return redirect()->route('petugas.donor.index')
            ->with('success', 'Status donor berhasil diperbarui.');
    }
}
