<?php

namespace App\Http\Controllers\Pendonor;

use App\Http\Controllers\Controller;
use App\Models\JadwalDonor;
use App\Models\Pendonor;
use App\Models\RiwayatDonor;
use Illuminate\Http\Request;

class PendonorDashboardController extends Controller
{
    private function getPendonor()
    {
        return Pendonor::where('user_id', auth()->id())->first();
    }

    public function index()
    {
        $pendonor      = $this->getPendonor();
        $totalDonor    = $pendonor ? RiwayatDonor::where('pendonor_id', $pendonor->id)->count() : 0;
        $donorTerakhir = $pendonor ? RiwayatDonor::where('pendonor_id', $pendonor->id)->latest('tanggal_donor')->first() : null;
        $jadwalTerdekat = JadwalDonor::where('tanggal', '>=', now()->toDateString())
            ->where('status', 'aktif')
            ->orderBy('tanggal')
            ->take(3)
            ->get();

        $jadwalSaya = collect();
        if ($pendonor) {
            $jadwalSaya = \App\Models\Donor::with('jadwalDonor')
                ->where('pendonor_id', $pendonor->id)
                ->whereIn('status', ['terdaftar', 'lolos_skrining'])
                ->get();
        }

        // Hitung bulan tunggu sejak donor terakhir (minimal 3 bulan)
        $bolehDonor = true;
        $sisaHari   = 0;
        if ($donorTerakhir) {
            $nextDonor = $donorTerakhir->tanggal_donor->addMonths(3);
            if (now()->lt($nextDonor)) {
                $bolehDonor = false;
                $sisaHari   = now()->diffInDays($nextDonor);
            }
        }

        return view('pendonor.dashboard', compact(
            'pendonor', 'totalDonor', 'donorTerakhir',
            'jadwalTerdekat', 'bolehDonor', 'sisaHari', 'jadwalSaya'
        ));
    }

    public function daftarDonor()
    {
        $jadwal = JadwalDonor::where('tanggal', '>=', now()->toDateString())
            ->where('status', 'aktif')
            ->orderBy('tanggal')
            ->get();

        $pendonor = $this->getPendonor();
        $terdaftarJadwalIds = [];
        if ($pendonor) {
            $terdaftarJadwalIds = \App\Models\Donor::where('pendonor_id', $pendonor->id)
                ->pluck('jadwal_donor_id')
                ->toArray();
        }

        return view('pendonor.daftar', compact('jadwal', 'terdaftarJadwalIds'));
    }

    public function storeDaftar(Request $request)
    {
        $request->validate([
            'jadwal_donor_id' => 'required|exists:jadwal_donor,id',
            'keterangan'      => 'nullable|string|max:500',
        ]);

        $pendonor = $this->getPendonor();

        if (!$pendonor) {
            return back()->with('error', 'Profil pendonor tidak ditemukan.');
        }

        if (\App\Models\Donor::where('pendonor_id', $pendonor->id)->where('jadwal_donor_id', $request->jadwal_donor_id)->exists()) {
            return back()->with('error', 'Anda sudah terdaftar pada jadwal ini.');
        }

        \App\Models\Donor::create([
            'pendonor_id'     => $pendonor->id,
            'jadwal_donor_id' => $request->jadwal_donor_id,
            'tanggal_donor'   => JadwalDonor::find($request->jadwal_donor_id)->tanggal,
            'golongan_darah'  => $pendonor->golongan_darah,
            'rhesus'          => $pendonor->rhesus,
            'status'          => 'terdaftar',
            'keterangan'      => $request->keterangan,
        ]);

        return redirect()->route('pendonor.dashboard')
            ->with('success', 'Pendaftaran donor berhasil. Jadwal Anda dapat dilihat di dashboard.');
    }

    public function riwayat()
    {
        $pendonor = $this->getPendonor();
        $riwayat  = $pendonor
            ? RiwayatDonor::where('pendonor_id', $pendonor->id)->orderBy('tanggal_donor', 'desc')->get()
            : collect();

        return view('pendonor.riwayat', compact('riwayat'));
    }

    public function profil()
    {
        $pendonor = $this->getPendonor();
        return view('pendonor.profil', compact('pendonor'));
    }

    public function updateProfil(Request $request)
    {
        $pendonor = $this->getPendonor();

        $request->validate([
            'no_telepon' => 'required|string|max:15',
            'alamat'     => 'required|string',
            'pekerjaan'  => 'nullable|string|max:100',
            'berat_badan'  => 'nullable|numeric',
            'tinggi_badan' => 'nullable|numeric',
        ]);

        $pendonor->update($request->only([
            'no_telepon', 'alamat', 'kota', 'pekerjaan', 'berat_badan', 'tinggi_badan'
        ]));

        auth()->user()->update(['name' => $request->nama_lengkap ?? auth()->user()->name]);

        return redirect()->route('pendonor.profil')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}
