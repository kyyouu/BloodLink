<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return view('admin.user.index', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'       => 'required|string|max:100',
            'email'      => 'required|email|max:150|unique:users,email',
            'password'   => 'required|string|min:6',
            'role'       => 'required|in:admin,petugas_pmi,pimpinan_pmi',
            'no_telepon' => 'nullable|string|max:20',
        ]);

        User::create([
            'nama'       => $request->nama,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'role'       => $request->role,
            'no_telepon' => $request->no_telepon,
            'is_active'  => 1,
        ]);

        return redirect()->route('admin.user.index')
            ->with('success', 'Akun ' . ucfirst(str_replace('_',' ',$request->role)) . ' berhasil dibuat.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.user.index')
                ->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        $user->delete();
        return redirect()->route('admin.user.index')
            ->with('success', 'Akun berhasil dihapus.');
    }

    public function resetPassword(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user->update(['password' => Hash::make($request->password)]);

        return redirect()->route('admin.user.index')
            ->with('success', 'Password akun ' . $user->nama . ' berhasil direset.');
    }

    public function toggleActive(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.user.index')
                ->with('error', 'Tidak dapat menonaktifkan akun sendiri.');
        }

        $user->update(['is_active' => !$user->is_active]);
        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->route('admin.user.index')
            ->with('success', 'Akun ' . $user->nama . ' berhasil ' . $status . '.');
    }
}
