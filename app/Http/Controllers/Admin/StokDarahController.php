<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StokDarah;
use Illuminate\Http\Request;

class StokDarahController extends Controller
{
    public function index()
    {
        $stok = StokDarah::orderBy('golongan_darah')->orderBy('rhesus')->get();
        return view('admin.stok-darah.index', compact('stok'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'golongan_darah' => 'required|in:A,B,AB,O',
            'rhesus'         => 'required|in:+,-',
            'jumlah_kantong' => 'required|integer|min:0',
        ]);

        $existing = StokDarah::where('golongan_darah', $request->golongan_darah)
            ->where('rhesus', $request->rhesus)->first();

        if ($existing) {
            return redirect()->route('admin.stok-darah.index')
                ->with('error', 'Stok untuk golongan ' . $request->golongan_darah . $request->rhesus . ' sudah ada.');
        }

        StokDarah::create([
            'golongan_darah'  => $request->golongan_darah,
            'rhesus'          => $request->rhesus,
            'jumlah_kantong'  => $request->jumlah_kantong,
            'diperbarui_oleh' => auth()->id(),
        ]);

        return redirect()->route('admin.stok-darah.index')
            ->with('success', 'Data stok darah berhasil ditambahkan.');
    }

    public function edit(StokDarah $stokDarah)
    {
        return view('admin.stok-darah.edit', compact('stokDarah'));
    }

    public function update(Request $request, StokDarah $stokDarah)
    {
        $request->validate([
            'jumlah_kantong' => 'required|integer|min:0',
            'keterangan'     => 'nullable|string',
        ]);

        $stokDarah->update([
            'jumlah_kantong'  => $request->jumlah_kantong,
            'keterangan'      => $request->keterangan,
            'diperbarui_oleh' => auth()->id(),
        ]);

        return redirect()->route('admin.stok-darah.index')
            ->with('success', 'Data stok darah berhasil diperbarui.');
    }

    public function destroy(StokDarah $stokDarah)
    {
        $stokDarah->delete();
        return redirect()->route('admin.stok-darah.index')
            ->with('success', 'Stok darah berhasil dihapus.');
    }

    public function show(StokDarah $stokDarah)
    {
        return view('admin.stok-darah.show', compact('stokDarah'));
    }
}
