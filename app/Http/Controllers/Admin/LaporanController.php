<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donor;
use App\Models\StokDarah;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function donor(Request $request)
    {
        $dari   = $request->dari_tanggal   ?? now()->startOfYear()->toDateString();
        $sampai = $request->sampai_tanggal ?? now()->toDateString();

        $donorPerBulan = Donor::selectRaw('MONTH(tanggal_donor) as bulan, COUNT(*) as total')
            ->where('status', 'selesai')
            ->whereBetween('tanggal_donor', [$dari, $sampai])
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $donorPerGolongan = Donor::selectRaw('golongan_darah, rhesus, COUNT(*) as total')
            ->where('status', 'selesai')
            ->whereBetween('tanggal_donor', [$dari, $sampai])
            ->groupBy('golongan_darah', 'rhesus')
            ->get();

        $totalDonor = Donor::where('status', 'selesai')->whereBetween('tanggal_donor', [$dari, $sampai])->count();

        return view('admin.laporan.donor', compact(
            'donorPerBulan', 'donorPerGolongan', 'totalDonor', 'dari', 'sampai'
        ));
    }

    public function exportPdf(Request $request)
    {
        $dari   = $request->dari   ?? now()->startOfYear()->toDateString();
        $sampai = $request->sampai ?? now()->toDateString();

        $data = Donor::with('pendonor')
            ->where('status', 'selesai')
            ->whereBetween('tanggal_donor', [$dari, $sampai])
            ->orderBy('tanggal_donor', 'desc')
            ->get();

        $pdf = Pdf::loadView('admin.laporan.donor-pdf', compact('data', 'dari', 'sampai'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-donor-' . now()->format('Ymd') . '.pdf');
    }

    public function stok(Request $request)
    {
        $stok = StokDarah::orderBy('golongan_darah')->orderBy('rhesus')->get();
        $totalKantong = $stok->sum('jumlah_kantong');

        return view('admin.laporan.stok', compact('stok', 'totalKantong'));
    }
}
