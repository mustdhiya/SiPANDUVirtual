<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            if (!$user->canLogin()) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Akun Anda belum diaktifkan atau sedang ditangguhkan.',
                ]);
            }

            // Super Admin (Mama) dan Pengawas sama-sama diarahkan ke dashboard panel admin/pengawas
            if ($user->isAdmin() || $user->isPengawas()) {
                return redirect()->intended(route('admin.dashboard'));
            }

            return redirect()->intended(route('guru.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
