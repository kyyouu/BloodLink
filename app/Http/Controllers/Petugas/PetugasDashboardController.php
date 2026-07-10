<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Donor;
use App\Models\JadwalDonor;
use App\Models\Pendonor;
use App\Models\PermintaanDarah;
use App\Models\StokDarah;

class PetugasDashboardController extends Controller
{
    public function index()
    {
        $donorHariIni    = Donor::where('status', 'selesai')->whereDate('tanggal_donor', now()->toDateString())->count();
        $donorBulanIni   = Donor::where('status', 'selesai')->whereMonth('tanggal_donor', now()->month)->count();
        $totalStok       = StokDarah::sum('jumlah_kantong');
        $permintaanAktif = PermintaanDarah::where('status', 'menunggu')->count();

        $jadwalAktif = JadwalDonor::where('tanggal', '>=', now()->toDateString())
            ->where('status', 'aktif')
            ->orderBy('tanggal')
            ->take(5)
            ->get();

        $donorTerbaru = Donor::with('pendonor')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        $stok = StokDarah::orderBy('golongan_darah')->get();

        return view('petugas.dashboard', compact(
            'donorHariIni', 'donorBulanIni', 'totalStok',
            'permintaanAktif', 'jadwalAktif', 'donorTerbaru', 'stok'
        ));
    }
}
