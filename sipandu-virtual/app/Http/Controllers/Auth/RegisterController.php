<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            'role'     => 'required|in:admin,guru',
            'nomor_wa' => 'nullable|string|max:20',
        ]);

        $user = User::create([
            'name'       => $validated['name'],
            'email'      => $validated['email'],
            'password'   => Hash::make($validated['password']),
            'role'       => $validated['role'],
            'is_approved'=> $validated['role'] === 'admin', // admin langsung approve
            'status'     => $validated['role'] === 'admin' ? User::STATUS_ACTIVE : User::STATUS_PENDING,
            'nomor_wa'   => $validated['nomor_wa'] ?? null,
        ]);

        if ($user->role === User::ROLE_ADMIN) {
            Auth::login($user);
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('login')->with('success', 'Registrasi berhasil. Akun Anda menunggu persetujuan admin.');
    }
}