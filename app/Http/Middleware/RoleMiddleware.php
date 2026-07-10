<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): mixed
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        $user = auth()->user();

        // Cek role — jika tidak sesuai, redirect ke dashboard sendiri (bukan error 403)
        if (!in_array($user->role, $roles)) {
            $roleRoutes = [
                'admin'        => 'admin.dashboard',
                'petugas_pmi'  => 'petugas.dashboard',
                'pendonor'     => 'pendonor.dashboard',
                'rumah_sakit'  => 'rs.dashboard',
                'pimpinan_pmi' => 'pimpinan.dashboard',
            ];
            $redirectRoute = $roleRoutes[$user->role] ?? null;

            return $redirectRoute
                ? redirect()->route($redirectRoute)->with('warning', 'Halaman tersebut tidak dapat diakses dengan akun Anda.')
                : redirect('/login');
        }

        // Cek akun aktif
        if (!$user->is_active) {
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/login')->with('error', 'Akun Anda telah dinonaktifkan. Hubungi Administrator.');
        }

        return $next($request);
    }
}
