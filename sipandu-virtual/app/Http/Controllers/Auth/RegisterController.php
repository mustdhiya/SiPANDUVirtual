<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'nomor_wa' => 'nullable|string|max:20',
        ]);

        User::create([
            'name'                => $validated['name'],
            'email'               => $validated['email'],
            'password'            => Hash::make($validated['password']),
            'password_plain'      => $validated['password'], // Disimpan agar Admin Utama bisa melihat
            'role'                => User::ROLE_GURU,
            'is_approved'         => false,
            'status'              => User::STATUS_PENDING,
            'is_profile_complete' => false,
            'nomor_wa'            => $validated['nomor_wa'] ?? null,
        ]);

        return redirect()
            ->route('login')
            ->with('success', 'Registrasi berhasil. Akun Anda menunggu persetujuan Admin Utama.');
    }
}
