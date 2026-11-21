<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminRequired
{
    /**
     * Izinkan Super Admin (admin) dan Pengawas PAI (pengawas) masuk ke panel admin/pengawas.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if (!$user->canLogin()) {
            Auth::logout();
            return redirect()->route('login')->withErrors([
                'email' => 'Akun Anda belum diaktifkan atau sedang ditangguhkan.',
            ]);
        }

        if (!$user->isPanelPengawas()) {
            return redirect()->route('guru.dashboard')
                ->with('error', 'Halaman tersebut khusus untuk Pengawas / Super Admin.');
        }

        return $next($request);
    }
}
