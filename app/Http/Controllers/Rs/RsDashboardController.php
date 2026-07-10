<?php

namespace App\Http\Controllers\Rs;

use App\Http\Controllers\Controller;
use App\Models\PermintaanDarah;
use App\Models\RumahSakit;
use App\Models\StokDarah;
use Illuminate\Http\Request;

class RsDashboardController extends Controller
{
    private function getRumahSakit()
    {
        return RumahSakit::where('user_id', auth()->id())->first();
    }

    public function index()
    {
        $rs              = $this->getRumahSakit();
        $permintaanSaya  = $rs ? PermintaanDarah::where('rumah_sakit_id', $rs->id)->count() : 0;
        $permintaanAktif = $rs ? PermintaanDarah::where('rumah_sakit_id', $rs->id)->where('status', 'menunggu')->count() : 0;
        $stok            = StokDarah::orderBy('golongan_darah')->get();
        $permintaanTerbaru = $rs
            ? PermintaanDarah::where('rumah_sakit_id', $rs->id)->latest()->take(5)->get()
            : collect();

        return view('rs.dashboard', compact('rs', 'permintaanSaya', 'permintaanAktif', 'stok', 'permintaanTerbaru'));
    }

    public function stokDarah()
    {
        $stok = StokDarah::orderBy('golongan_darah')->orderBy('rhesus')->get();
        return view('rs.stok', compact('stok'));
    }
}
