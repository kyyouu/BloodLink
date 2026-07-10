<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalDonor;
use Illuminate\Http\Request;

class JadwalDonorController extends Controller
{
    public function index()
    {
        $jadwal = JadwalDonor::orderBy('tanggal', 'desc')->get();
        return view('admin.jadwal-donor.index', compact('jadwal'));
    }

    public function create()
    {
        return view('admin.jadwal-donor.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'       => 'required|string|max:200',
            'tanggal'     => 'required|date|after_or_equal:today',
            'jam_mulai'   => 'required',
            'jam_selesai' => 'required',
            'lokasi'      => 'required|string|max:255',
            'kuota'       => 'required|integer|min:1',
            'keterangan'  => 'nullable|string',
        ]);

        JadwalDonor::create(array_merge($request->only([
            'judul','tanggal','jam_mulai','jam_selesai','lokasi','kuota','keterangan'
        ]), [
            'status'      => 'aktif',
            'dibuat_oleh' => auth()->id(),
        ]));

        return redirect()->route('admin.jadwal-donor.index')
            ->with('success', 'Jadwal donor berhasil ditambahkan.');
    }

    public function edit(JadwalDonor $jadwalDonor)
    {
        return view('admin.jadwal-donor.edit', compact('jadwalDonor'));
    }

    public function update(Request $request, JadwalDonor $jadwalDonor)
    {
        $request->validate([
            'judul'       => 'required|string|max:200',
            'tanggal'     => 'required|date',
            'jam_mulai'   => 'required',
            'jam_selesai' => 'required',
            'lokasi'      => 'required|string|max:255',
            'kuota'       => 'required|integer|min:1',
            'status'      => 'required|in:aktif,selesai,dibatalkan',
        ]);

        $jadwalDonor->update($request->only([
            'judul','tanggal','jam_mulai','jam_selesai',
            'lokasi','kuota','status','keterangan'
        ]));

        return redirect()->route('admin.jadwal-donor.index')
            ->with('success', 'Jadwal donor berhasil diperbarui.');
    }

    public function destroy(JadwalDonor $jadwalDonor)
    {
        $jadwalDonor->delete();
        return redirect()->route('admin.jadwal-donor.index')
            ->with('success', 'Jadwal donor berhasil dihapus.');
    }

    public function show(JadwalDonor $jadwalDonor)
    {
        return view('admin.jadwal-donor.show', compact('jadwalDonor'));
    }
}
