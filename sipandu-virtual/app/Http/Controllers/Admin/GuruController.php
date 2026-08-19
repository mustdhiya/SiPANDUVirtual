<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GuruBinaan;
use App\Models\SekolahBinaan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GuruController extends Controller
{
    public function index()
    {
        $gurus = GuruBinaan::with('sekolah', 'userAccount')->orderBy('nama_lengkap')->get();
        return view('admin.guru.index', compact('gurus'));
    }

    public function create()
    {
        $sekolahs = SekolahBinaan::where('is_active', true)->orderBy('nama_sekolah')->get();
        return view('admin.guru.create', compact('sekolahs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'sekolah_id' => 'nullable|exists:sekolah_binaans,id',
            'nip_siaga' => 'nullable|string|max:50|unique:guru_binaans,nip_siaga',
            'status_jabatan' => 'required|in:GURU,GURU_KEPSEK',
            'is_active' => 'boolean',
        ]);

        GuruBinaan::create($validated);

        return redirect()->route('admin.guru.index')
            ->with('success', 'Guru binaan berhasil ditambahkan.');
    }

    public function edit(GuruBinaan $guru)
    {
        $sekolahs = SekolahBinaan::where('is_active', true)->orderBy('nama_sekolah')->get();
        return view('admin.guru.edit', compact('guru', 'sekolahs'));
    }

    public function update(Request $request, GuruBinaan $guru)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'sekolah_id' => 'nullable|exists:sekolah_binaans,id',
            'nip_siaga' => 'nullable|string|max:50|unique:guru_binaans,nip_siaga,' . $guru->id,
            'status_jabatan' => 'required|in:GURU,GURU_KEPSEK',
            'is_active' => 'boolean',
        ]);

        $guru->update($validated);

        return redirect()->route('admin.guru.index')
            ->with('success', 'Guru binaan berhasil diupdate.');
    }

    public function destroy(GuruBinaan $guru)
    {
        $guru->delete();
        return redirect()->route('admin.guru.index')
            ->with('success', 'Guru binaan berhasil dihapus.');
    }
    public function linkAccount()
    {
        $users = User::where('role', User::ROLE_GURU)
            ->whereNotExists(function ($query) {
                $query->selectRaw(1)
                    ->from('guru_binaans')
                    ->whereColumn('guru_binaans.user_account_id', 'users.id')
                    ->whereNull('guru_binaans.deleted_at');
            })
            ->orderBy('name')
            ->get();

        $sekolahs = SekolahBinaan::where('is_active', true)
            ->orderBy('nama_sekolah')
            ->get();

        return view('admin.guru.link-account', compact('users', 'sekolahs'));
    }

    public function storeLinkedAccount(Request $request)
    {
        $validated = $request->validate([
            'user_id' => [
                'required',
                'exists:users,id',
                Rule::unique('guru_binaans', 'user_account_id'),
            ],
            'sekolah_id' => 'nullable|exists:sekolah_binaans,id',
            'nip_siaga' => 'nullable|string|max:50|unique:guru_binaans,nip_siaga',
            'status_jabatan' => 'required|in:GURU,GURU_KEPSEK',
            'is_active' => 'boolean',
        ]);

        $user = User::where('id', $validated['user_id'])
            ->where('role', User::ROLE_GURU)
            ->firstOrFail();

        GuruBinaan::create([
            'nama_lengkap' => $user->name,
            'sekolah_id' => $validated['sekolah_id'] ?? null,
            'nip_siaga' => $validated['nip_siaga'] ?? null,
            'status_jabatan' => $validated['status_jabatan'],
            'is_active' => $validated['is_active'] ?? true,
            'user_account_id' => $user->id,
        ]);

        return redirect()
            ->route('admin.guru.index')
            ->with('success', 'Akun guru ' . $user->name . ' berhasil dihubungkan sebagai guru binaan.');
    }
}