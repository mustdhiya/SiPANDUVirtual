<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        // Hanya Super Admin yang boleh melihat seluruh user, sandi, dan mengangkat peran.
        if (!$user->isAdmin()) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        $search = $request->query('search');
        $roleFilter = $request->query('role');

        $users = User::query()
            ->when($roleFilter, function ($query) use ($roleFilter) {
                $query->where('role', $roleFilter);
            })
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('nip', 'like', "%{$search}%");
                });
            })
            ->orderByRaw("CASE role WHEN 'admin' THEN 1 WHEN 'pengawas' THEN 2 ELSE 3 END")
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('admin.users.index', compact('users', 'search', 'roleFilter'));
    }

    public function updateRole(Request $request, User $targetUser)
    {
        $currentUser = auth()->user();

        if (!$currentUser->isAdmin()) {
            abort(403, 'Hanya Super Admin yang berwenang mengubah peran akun.');
        }

        if ($targetUser->id === $currentUser->id) {
            return back()->with('error', 'Anda tidak dapat mengubah peran akun Super Admin Anda sendiri.');
        }

        $validated = $request->validate([
            'role' => 'required|in:pengawas,guru',
        ]);

        $targetUser->update([
            'role'        => $validated['role'],
            'is_approved' => true,
            'status'      => User::STATUS_ACTIVE,
        ]);

        $label = $validated['role'] === User::ROLE_PENGAWAS ? 'Pengawas PAI' : 'Guru Binaan';

        return back()->with('success', "Akun {$targetUser->name} berhasil diubah perannya menjadi {$label}.");
    }

    public function updatePassword(Request $request, User $targetUser)
    {
        $currentUser = auth()->user();

        if (!$currentUser->isAdmin()) {
            abort(403, 'Hanya Super Admin yang berwenang mengubah kata sandi akun lain.');
        }

        $validated = $request->validate([
            'password' => 'required|string|min:6|max:100',
        ]);

        $targetUser->update([
            'password'       => Hash::make($validated['password']),
            'password_plain' => $validated['password'],
        ]);

        return back()->with('success', "Kata sandi untuk {$targetUser->name} berhasil diubah menjadi: {$validated['password']}");
    }
}
