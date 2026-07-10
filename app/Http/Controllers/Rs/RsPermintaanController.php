<?php

namespace App\Http\Controllers\Rs;

use App\Http\Controllers\Controller;
use App\Models\PermintaanDarah;
use App\Models\RumahSakit;
use App\Models\StokDarah;
use Illuminate\Http\Request;

class RsPermintaanController extends Controller
{
    private function getRumahSakit()
    {
        return RumahSakit::where('user_id', auth()->id())->first();
    }

    public function index()
    {
        $rs         = $this->getRumahSakit();
        $permintaan = $rs
            ? PermintaanDarah::where('rumah_sakit_id', $rs->id)->orderBy('created_at', 'desc')->get()
            : collect();

        return view('rs.permintaan.index', compact('permintaan'));
    }

    public function create()
    {
        $stok = StokDarah::where('jumlah_kantong', '>', 0)->orderBy('golongan_darah')->get();
        return view('rs.permintaan.create', compact('stok'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'golongan_darah'     => 'required|in:A,B,AB,O',
            'rhesus'             => 'required|in:+,-',
            'jumlah_kantong'     => 'required|integer|min:1',
            'tanggal_dibutuhkan' => 'nullable|date',
            'keperluan'          => 'nullable|string|max:255',
            'nama_pasien'        => 'nullable|string|max:100',
            'catatan_rs'         => 'nullable|string|max:500',
        ]);

        $rs = $this->getRumahSakit();

        if (!$rs) {
            return back()->with('error', 'Profil rumah sakit tidak ditemukan.');
        }

        PermintaanDarah::create([
            'rumah_sakit_id'     => $rs->id,
            'golongan_darah'     => $request->golongan_darah,
            'rhesus'             => $request->rhesus,
            'jumlah_kantong'     => $request->jumlah_kantong,
            'tanggal_dibutuhkan' => $request->tanggal_dibutuhkan,
            'keperluan'          => $request->keperluan,
            'nama_pasien'        => $request->nama_pasien,
            'catatan_rs'         => $request->catatan_rs,
            'status'             => 'menunggu',
        ]);

        return redirect()->route('rs.permintaan-darah.index')
            ->with('success', 'Permintaan darah berhasil dikirim.');
    }

    public function show(PermintaanDarah $permintaanDarah)
    {
        return view('rs.permintaan.show', compact('permintaanDarah'));
    }
}
