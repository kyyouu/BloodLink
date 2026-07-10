<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RumahSakit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RumahSakitController extends Controller
{
    public function index()
    {
        $rumahSakit = RumahSakit::orderBy('created_at', 'desc')->get();
        return view('admin.rumah-sakit.index', compact('rumahSakit'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_rs'     => 'required|string|max:150',
            'alamat'      => 'required|string',
            'kota'        => 'required|string|max:100',
            'no_telepon'  => 'required|string|max:20',
            'email'       => 'nullable|email|max:150',
            'kode_rs'     => 'nullable|string|max:30|unique:rumah_sakit,kode_rs',
            'nama_kontak' => 'nullable|string|max:100',
            'password'    => 'required|string|min:6',
        ]);

        // Create user account for rumah sakit
        $email = $request->email
            ?? strtolower(str_replace(' ', '', $request->nama_rs)) . '@rs.bloodlink.app';

        $user = User::create([
            'nama'       => $request->nama_rs,
            'email'      => $email,
            'password'   => Hash::make($request->password),
            'role'       => 'rumah_sakit',
            'no_telepon' => $request->no_telepon,
        ]);

        RumahSakit::create(array_merge(
            $request->only([
                'nama_rs','kode_rs','alamat','kota',
                'no_telepon','email','nama_kontak',
            ]),
            ['user_id' => $user->id, 'is_active' => 1]
        ));

        return redirect()->route('admin.rumah-sakit.index')
            ->with('success', 'Rumah sakit berhasil ditambahkan. Login: ' . $email . ' / (password yang anda masukkan)');
    }

    public function edit(RumahSakit $rumahSakit)
    {
        return view('admin.rumah-sakit.edit', compact('rumahSakit'));
    }

    public function update(Request $request, RumahSakit $rumahSakit)
    {
        $request->validate([
            'nama_rs'     => 'required|string|max:150',
            'alamat'      => 'required|string',
            'kota'        => 'required|string|max:100',
            'no_telepon'  => 'required|string|max:20',
            'nama_kontak' => 'nullable|string|max:100',
            'is_active'   => 'nullable|boolean',
        ]);

        $rumahSakit->update($request->only([
            'nama_rs','kode_rs','alamat','kota',
            'no_telepon','email','nama_kontak','is_active',
        ]));

        if ($rumahSakit->user) {
            $rumahSakit->user->update(['no_telepon' => $request->no_telepon]);
        }

        return redirect()->route('admin.rumah-sakit.index')
            ->with('success', 'Data rumah sakit berhasil diperbarui.');
    }

    public function destroy(RumahSakit $rumahSakit)
    {
        $rumahSakit->delete();
        return redirect()->route('admin.rumah-sakit.index')
            ->with('success', 'Data rumah sakit berhasil dihapus.');
    }

    public function show(RumahSakit $rumahSakit)
    {
        return view('admin.rumah-sakit.show', compact('rumahSakit'));
    }
}
