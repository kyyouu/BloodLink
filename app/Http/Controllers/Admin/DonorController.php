<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donor;
use App\Models\JadwalDonor;
use App\Models\Pendonor;
use Illuminate\Http\Request;

class DonorController extends Controller
{
    public function index()
    {
        $donor = Donor::with(['pendonor', 'jadwalDonor'])->orderBy('created_at', 'desc')->get();
        return view('admin.donor.index', compact('donor'));
    }

    public function create()
    {
        $pendonor = Pendonor::where('status_aktif', 1)->orderBy('nama_lengkap')->get();
        $jadwal   = JadwalDonor::where('status', 'aktif')->orderBy('tanggal')->get();
        return view('admin.donor.create', compact('pendonor', 'jadwal'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pendonor_id'    => 'required|exists:pendonor,id',
            'tanggal_donor'  => 'required|date',
            'golongan_darah' => 'required|in:A,B,AB,O',
            'rhesus'         => 'required|in:+,-',
            'tekanan_darah'  => 'nullable|string|max:20',
            'berat_badan'    => 'nullable|numeric',
            'hemoglobin'     => 'nullable|numeric',
            'volume_ml'      => 'nullable|integer',
            'status'         => 'required|in:terdaftar,lolos_skrining,selesai,ditolak',
            'catatan'        => 'nullable|string',
        ]);

        Donor::create(array_merge(
            $request->only([
                'pendonor_id','jadwal_donor_id','tanggal_donor',
                'golongan_darah','rhesus','tekanan_darah',
                'berat_badan','hemoglobin','volume_ml','status','catatan',
            ]),
            ['petugas_id' => auth()->id()]
        ));

        return redirect()->route('admin.donor.index')
            ->with('success', 'Data donor berhasil ditambahkan.');
    }

    public function edit(Donor $donor)
    {
        $pendonor = Pendonor::where('status_aktif', 1)->orderBy('nama_lengkap')->get();
        $jadwal   = JadwalDonor::where('status', 'aktif')->orderBy('tanggal')->get();
        return view('admin.donor.edit', compact('donor', 'pendonor', 'jadwal'));
    }

    public function update(Request $request, Donor $donor)
    {
        $request->validate([
            'pendonor_id'    => 'required|exists:pendonor,id',
            'tanggal_donor'  => 'required|date',
            'golongan_darah' => 'required|in:A,B,AB,O',
            'rhesus'         => 'required|in:+,-',
            'status'         => 'required|in:terdaftar,lolos_skrining,selesai,ditolak',
        ]);

        $donor->update($request->only([
            'pendonor_id','jadwal_donor_id','tanggal_donor',
            'golongan_darah','rhesus','tekanan_darah',
            'berat_badan','hemoglobin','volume_ml','status','catatan',
        ]));

        return redirect()->route('admin.donor.index')
            ->with('success', 'Data donor berhasil diperbarui.');
    }

    public function destroy(Donor $donor)
    {
        $donor->delete();
        return redirect()->route('admin.donor.index')
            ->with('success', 'Data donor berhasil dihapus.');
    }

    public function show(Donor $donor)
    {
        $donor->load('pendonor', 'jadwalDonor');
        return view('admin.donor.show', compact('donor'));
    }
}
