<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donor;
use App\Models\JadwalDonor;
use App\Models\Pendonor;
use App\Models\PermintaanDarah;
use App\Models\RumahSakit;
use App\Models\StokDarah;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalPendonor   = Pendonor::where('status_aktif', 1)->count();
        $donorBulanIni   = Donor::where('status', 'selesai')->whereMonth('tanggal_donor', now()->month)->count();
        $totalStok       = StokDarah::sum('jumlah_kantong');
        $permintaanAktif = PermintaanDarah::where('status', 'menunggu')->count();
        $totalRS         = RumahSakit::where('is_active', 1)->count();

        $donorPerBulan = Donor::selectRaw('MONTH(tanggal_donor) as bulan, COUNT(*) as total')
            ->where('status', 'selesai')
            ->whereYear('tanggal_donor', now()->year)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $stokPerGolongan    = StokDarah::orderBy('golongan_darah')->orderBy('rhesus')->get();
        $permintaanTerbaru  = PermintaanDarah::with('rumahSakit')->latest()->take(5)->get();
        $jadwalTerdekat     = JadwalDonor::where('tanggal', '>=', now()->toDateString())
            ->where('status', 'aktif')
            ->orderBy('tanggal')
            ->take(3)
            ->get();

        return view('admin.dashboard', compact(
            'totalPendonor',
            'donorBulanIni',
            'totalStok',
            'permintaanAktif',
            'totalRS',
            'donorPerBulan',
            'stokPerGolongan',
            'permintaanTerbaru',
            'jadwalTerdekat'
        ));
    }
}
