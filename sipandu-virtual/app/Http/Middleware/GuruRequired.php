<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuruRequired
{
    /**
     * Izinkan hanya akun Guru Binaan yang aktif untuk mengakses panel guru.
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if ($user->isPanelPengawas()) {
            return redirect()->route('admin.dashboard');
        }

        if (!$user->isGuru()) {
            abort(403, 'Akses ditolak. Halaman ini khusus Guru Binaan.');
        }

        if (!$user->is_approved) {
            return redirect()->route('guru.menunggu-approval');
        }

        if (!$user->canLogin()) {
            Auth::logout();
            return redirect()->route('login')->withErrors([
                'email' => 'Akun Anda sedang ditangguhkan. Hubungi Pengawas PAI.',
            ]);
        }

        return $next($request);
    }
}
