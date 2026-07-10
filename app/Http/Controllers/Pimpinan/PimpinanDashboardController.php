<?php

namespace App\Http\Controllers\Pimpinan;

use App\Http\Controllers\Controller;
use App\Models\Donor;
use App\Models\Pendonor;
use App\Models\PermintaanDarah;
use App\Models\RumahSakit;
use App\Models\StokDarah;

class PimpinanDashboardController extends Controller
{
    public function index()
    {
        $totalPendonor   = Pendonor::where('status_aktif', 1)->count();
        $totalDonorTahun = Donor::where('status', 'selesai')->whereYear('tanggal_donor', now()->year)->count();
        $totalStok       = StokDarah::sum('jumlah_kantong');
        $totalRS         = RumahSakit::where('is_active', 1)->count();

        $donorPerBulan = Donor::selectRaw('MONTH(tanggal_donor) as bulan, COUNT(*) as total')
            ->where('status', 'selesai')
            ->whereYear('tanggal_donor', now()->year)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $stok = StokDarah::orderBy('golongan_darah')->get();

        return view('pimpinan.dashboard', compact(
            'totalPendonor', 'totalDonorTahun', 'totalStok',
            'totalRS', 'donorPerBulan', 'stok'
        ));
    }

    public function laporanDonor()
    {
        $donorPerBulan = Donor::selectRaw('MONTH(tanggal_donor) as bulan, COUNT(*) as total')
            ->where('status', 'selesai')
            ->whereYear('tanggal_donor', now()->year)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $donorPerGolongan = Donor::selectRaw('golongan_darah, rhesus, COUNT(*) as total')
            ->where('status', 'selesai')
            ->whereYear('tanggal_donor', now()->year)
            ->groupBy('golongan_darah', 'rhesus')
            ->get();

        $totalDonor = Donor::where('status', 'selesai')->whereYear('tanggal_donor', now()->year)->count();

        return view('pimpinan.laporan-donor', compact('donorPerBulan', 'donorPerGolongan', 'totalDonor'));
    }

    public function laporanStok()
    {
        $stok         = StokDarah::orderBy('golongan_darah')->orderBy('rhesus')->get();
        $totalKantong = $stok->sum('jumlah_kantong');

        return view('pimpinan.laporan-stok', compact('stok', 'totalKantong'));
    }

    public function monitoring()
    {
        $permintaan = PermintaanDarah::with('rumahSakit')
            ->orderBy('created_at', 'desc')
            ->take(20)
            ->get();

        $donorTerbaru = Donor::with('pendonor')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('pimpinan.monitoring', compact('permintaan', 'donorTerbaru'));
    }
}
