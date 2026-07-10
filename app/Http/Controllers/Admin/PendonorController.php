<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendonor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PendonorController extends Controller
{
    public function index()
    {
        $pendonor = Pendonor::orderBy('created_at', 'desc')->get();
        return view('admin.pendonor.index', compact('pendonor'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik'            => 'required|string|size:16|unique:pendonor,nik',
            'nama_lengkap'   => 'required|string|max:100',
            'tempat_lahir'   => 'nullable|string|max:100',
            'tanggal_lahir'  => 'required|date',
            'jenis_kelamin'  => 'required|in:L,P',
            'golongan_darah' => 'required|in:A,B,AB,O',
            'rhesus'         => 'required|in:+,-',
            'no_telepon'     => 'required|string|max:20',
            'alamat'         => 'required|string',
            'kota'           => 'required|string|max:100',
            'password'       => 'required|string|min:6',
        ]);

        // Create user account for pendonor
        $email = strtolower(str_replace(' ', '.', $request->nama_lengkap))
               . '.' . $request->nik . '@bloodlink.app';

        $user = User::create([
            'nama'       => $request->nama_lengkap,
            'email'      => $email,
            'password'   => Hash::make($request->password),
            'role'       => 'pendonor',
            'no_telepon' => $request->no_telepon,
        ]);

        Pendonor::create(array_merge(
            $request->only([
                'nik','nama_lengkap','tempat_lahir','tanggal_lahir',
                'jenis_kelamin','golongan_darah','rhesus',
                'alamat','kota','no_telepon','pekerjaan',
                'berat_badan','tinggi_badan','riwayat_penyakit',
            ]),
            ['user_id' => $user->id, 'status_aktif' => 1]
        ));

        return redirect()->route('admin.pendonor.index')
            ->with('success', 'Pendonor ditambahkan. Login: ' . $email . ' / (password yang anda masukkan)');
    }

    public function edit(Pendonor $pendonor)
    {
        return view('admin.pendonor.edit', compact('pendonor'));
    }

    public function update(Request $request, Pendonor $pendonor)
    {
        $request->validate([
            'nik'            => 'required|string|size:16|unique:pendonor,nik,' . $pendonor->id,
            'nama_lengkap'   => 'required|string|max:100',
            'tanggal_lahir'  => 'required|date',
            'jenis_kelamin'  => 'required|in:L,P',
            'golongan_darah' => 'required|in:A,B,AB,O',
            'rhesus'         => 'required|in:+,-',
            'no_telepon'     => 'required|string|max:20',
            'alamat'         => 'required|string',
        ]);

        $pendonor->update($request->only([
            'nik','nama_lengkap','tempat_lahir','tanggal_lahir',
            'jenis_kelamin','golongan_darah','rhesus',
            'alamat','kota','no_telepon','pekerjaan',
            'berat_badan','tinggi_badan','riwayat_penyakit','status_aktif',
        ]));

        if ($pendonor->user) {
            $pendonor->user->update(['no_telepon' => $request->no_telepon]);
        }

        return redirect()->route('admin.pendonor.index')
            ->with('success', 'Data pendonor berhasil diperbarui.');
    }

    public function destroy(Pendonor $pendonor)
    {
        $pendonor->delete();
        return redirect()->route('admin.pendonor.index')
            ->with('success', 'Data pendonor berhasil dihapus.');
    }

    public function show(Pendonor $pendonor)
    {
        $pendonor->load('riwayatDonor');
        return view('admin.pendonor.show', compact('pendonor'));
    }
}
