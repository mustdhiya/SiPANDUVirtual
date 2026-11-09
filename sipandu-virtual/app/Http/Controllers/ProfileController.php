<?php

namespace App\Http\Controllers;

use App\Models\GuruBinaan;
use App\Models\SekolahBinaan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        $profilGuru = $user->profilGuru;
        $sekolahs = SekolahBinaan::where('is_active', true)->orderBy('nama_sekolah')->get();
        $daftarPengawas = User::whereIn('role', [User::ROLE_ADMIN, User::ROLE_PENGAWAS])
            ->where('is_approved', true)
            ->orderBy('name')
            ->get();

        return view('profile.edit', compact('user', 'profilGuru', 'sekolahs', 'daftarPengawas'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'nomor_wa' => 'required|string|max:20',
            'nip'      => 'required|string|max:50',
            'password' => 'nullable|string|min:6|confirmed',
        ];

        // Jika role adalah Guru, wajib mengisi Sekolah Binaan dan Status Jabatan
        if ($user->isGuru()) {
            $rules['sekolah_id']     = 'required|exists:sekolah_binaans,id';
            $rules['status_jabatan'] = 'required|in:GURU,GURU_KEPSEK';
        }

        $validated = $request->validate($rules);

        $userData = [
            'name'                => $validated['name'],
            'email'               => $validated['email'],
            'nomor_wa'            => $validated['nomor_wa'],
            'nip'                 => $validated['nip'],
            'is_profile_complete' => true,
        ];

        if (!empty($validated['password'])) {
            $userData['password']       = Hash::make($validated['password']);
            $userData['password_plain'] = $validated['password'];
        }

        $user->update($userData);

        // Jika user adalah Guru, otomatis simpan/perbarui tabel guru_binaans
        if ($user->isGuru()) {
            GuruBinaan::updateOrCreate(
                ['user_account_id' => $user->id],
                [
                    'nama_lengkap'   => $validated['name'],
                    'sekolah_id'     => $validated['sekolah_id'],
                    'nip_siaga'      => $validated['nip'],
                    'status_jabatan' => $validated['status_jabatan'],
                    'is_active'      => true,
                ]
            );
        }

        $redirectRoute = $user->isPanelPengawas() ? 'admin.dashboard' : 'guru.dashboard';

        return redirect()->route($redirectRoute)
            ->with('success', 'Data profil wajib Anda berhasil disimpan. Selamat bekerja!');
    }
}