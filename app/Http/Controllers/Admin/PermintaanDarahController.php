<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PermintaanDarah;
use App\Models\RumahSakit;
use Illuminate\Http\Request;

class PermintaanDarahController extends Controller
{
    public function index()
    {
        $permintaan = PermintaanDarah::with('rumahSakit')->orderBy('created_at', 'desc')->get();
        return view('admin.permintaan-darah.index', compact('permintaan'));
    }

    public function create()
    {
        $rumahSakit = RumahSakit::where('is_active', 1)->orderBy('nama_rs')->get();
        return view('admin.permintaan-darah.create', compact('rumahSakit'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'rumah_sakit_id'     => 'required|exists:rumah_sakit,id',
            'golongan_darah'     => 'required|in:A,B,AB,O',
            'rhesus'             => 'required|in:+,-',
            'jumlah_kantong'     => 'required|integer|min:1',
            'tanggal_dibutuhkan' => 'nullable|date',
            'keperluan'          => 'nullable|string|max:255',
            'nama_pasien'        => 'nullable|string|max:100',
            'catatan_rs'         => 'nullable|string',
        ]);

        PermintaanDarah::create(array_merge(
            $request->only([
                'rumah_sakit_id','golongan_darah','rhesus',
                'jumlah_kantong','tanggal_dibutuhkan',
                'keperluan','nama_pasien','catatan_rs',
            ]),
            ['status' => 'menunggu']
        ));

        return redirect()->route('admin.permintaan-darah.index')
            ->with('success', 'Permintaan darah berhasil ditambahkan.');
    }

    public function edit(PermintaanDarah $permintaanDarah)
    {
        return view('admin.permintaan-darah.edit', compact('permintaanDarah'));
    }

    public function update(Request $request, PermintaanDarah $permintaanDarah)
    {
        $request->validate([
            'status'      => 'required|in:menunggu,diproses,dipenuhi,ditolak',
            'catatan_pmi' => 'nullable|string',
        ]);

        $permintaanDarah->update(array_merge(
            $request->only(['status', 'catatan_pmi']),
            [
                'diproses_oleh'  => auth()->id(),
                'tanggal_proses' => now(),
            ]
        ));

        return redirect()->route('admin.permintaan-darah.index')
            ->with('success', 'Status permintaan berhasil diperbarui.');
    }

    public function destroy(PermintaanDarah $permintaanDarah)
    {
        $permintaanDarah->delete();
        return redirect()->route('admin.permintaan-darah.index')
            ->with('success', 'Permintaan darah berhasil dihapus.');
    }

    public function show(PermintaanDarah $permintaanDarah)
    {
        $permintaanDarah->load('rumahSakit');
        return view('admin.permintaan-darah.show', compact('permintaanDarah'));
    }
}
