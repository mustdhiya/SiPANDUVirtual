<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\GuruBinaan;
use App\Models\SekolahBinaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Notifications\GuruApprovedNotification;
use App\Notifications\GuruRejectedNotification;
use App\Services\WaNotificationService;

class ApproveGuruController extends Controller
{
    public function index()
    {
        $currentUser = auth()->user();

        // Daftar pendaftar yang belum disetujui
        $pendingGurus = User::where('is_approved', false)
            ->orderBy('created_at', 'desc')
            ->get();

        // Daftar Pengawas (Mama + Rekan Pengawas) untuk dropdown plotting
        $daftarPengawas = User::whereIn('role', [User::ROLE_ADMIN, User::ROLE_PENGAWAS])
            ->where('is_approved', true)
            ->orderBy('name')
            ->get();

        // Daftar seluruh user & guru binaan (Khusus Mama bisa lihat semua user & password)
        $allUsers = $currentUser->isAdmin()
            ? User::with('profilGuru.pengawas', 'profilGuru.sekolah')
                ->where('is_approved', true)
                ->orderBy('role')
                ->orderBy('name')
                ->get()
            : collect();

        // Daftar guru binaan untuk checklist manual
        $daftarGuruBinaan = $currentUser->isAdmin()
            ? GuruBinaan::with(['sekolah', 'pengawas', 'userAccount'])->orderBy('nama_lengkap')->get()
            : GuruBinaan::with(['sekolah', 'userAccount'])->where('pengawas_id', $currentUser->id)->orderBy('nama_lengkap')->get();

        return view('admin.approve-guru.index', compact(
            'pendingGurus',
            'daftarPengawas',
            'allUsers',
            'daftarGuruBinaan'
        ));
    }

    public function approve(Request $request, User $user)
    {
        $currentUser = auth()->user();

        // Validasi pilihan role (Guru atau Pengawas) & pengawas pembimbing
        $validated = $request->validate([
            'role'        => 'nullable|in:guru,pengawas',
            'pengawas_id' => 'nullable|exists:users,id',
        ]);

        // Hanya Admin Utama (Mama) yang boleh mengangkat menjadi Pengawas
        $selectedRole = ($currentUser->isAdmin() && !empty($validated['role']))
            ? $validated['role']
            : User::ROLE_GURU;

        $user->update([
            'role'        => $selectedRole,
            'is_approved' => true,
            'status'      => User::STATUS_ACTIVE,
        ]);

        // Jika disetujui sebagai Guru, otomatis buat/hubungkan ke tabel guru_binaans
        if ($selectedRole === User::ROLE_GURU) {
            $pengawasId = $currentUser->isAdmin()
                ? ($validated['pengawas_id'] ?? $currentUser->id)
                : $currentUser->id;

            GuruBinaan::updateOrCreate(
                ['user_account_id' => $user->id],
                [
                    'nama_lengkap'   => $user->name,
                    'pengawas_id'    => $pengawasId,
                    'status_jabatan' => 'GURU',
                    'is_active'      => true,
                ]
            );
        }

        // Bungkus notifikasi email & WA dengan try-catch agar TIDAK ERROR jika SMTP belum disetting
        try {
            $user->notify(new GuruApprovedNotification());
        } catch (\Throwable $e) {
            Log::warning('Gagal mengirim email approval: ' . $e->getMessage());
        }

        try {
            if ($user->nomor_wa && class_exists(WaNotificationService::class)) {
                $waService = new WaNotificationService();
                $waService->sendGuruApproved($user->nomor_wa, $user->name);
            }
        } catch (\Throwable $e) {
            Log::warning('Gagal mengirim WA approval: ' . $e->getMessage());
        }

        $labelRole = $selectedRole === User::ROLE_PENGAWAS ? 'Pengawas PAI' : 'Guru Binaan';

        return back()->with('success', "Akun {$user->name} berhasil disetujui sebagai {$labelRole}.");
    }

    public function reject(Request $request, User $user)
    {
        $validated = $request->validate([
            'alasan' => 'required|string|max:500',
        ]);

        $user->update([
            'is_approved' => false,
            'status'      => User::STATUS_SUSPENDED,
        ]);

        try {
            $user->notify(new GuruRejectedNotification($validated['alasan']));
        } catch (\Throwable $e) {
            Log::warning('Gagal mengirim email penolakan: ' . $e->getMessage());
        }

        try {
            if ($user->nomor_wa && class_exists(WaNotificationService::class)) {
                $waService = new WaNotificationService();
                $waService->sendGuruRejected($user->nomor_wa, $user->name, $validated['alasan']);
            }
        } catch (\Throwable $e) {
            Log::warning('Gagal mengirim WA penolakan: ' . $e->getMessage());
        }

        return back()->with('success', 'Pendaftaran ditolak. Alasan: ' . $validated['alasan']);
    }

    /**
     * Fitur Checklist Manual: Hubungkan banyak Guru Binaan sekaligus ke Pengawas yang dipilih
     */
    public function checklistAssign(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Hanya Admin Utama yang dapat mem-plotting pengawas.');
        }

        $validated = $request->validate([
            'pengawas_id' => 'required|exists:users,id',
            'guru_ids'    => 'required|array',
            'guru_ids.*'  => 'exists:guru_binaans,id',
        ]);

        GuruBinaan::whereIn('id', $validated['guru_ids'])
            ->update(['pengawas_id' => $validated['pengawas_id']]);

        $pengawas = User::find($validated['pengawas_id']);

        return back()->with('success', count($validated['guru_ids']) . " Guru Binaan berhasil dihubungkan ke Pengawas {$pengawas->name}.");
    }

    /**
     * Fitur Ubah Role / Reset Password oleh Admin Utama
     */
    public function updateUserByAdmin(Request $request, User $user)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'role'          => 'required|in:admin,pengawas,guru',
            'new_password'  => 'nullable|string|min:6',
        ]);

        $data = ['role' => $validated['role']];

        if (!empty($validated['new_password'])) {
            $data['password']       = Hash::make($validated['new_password']);
            $data['password_plain'] = $validated['new_password'];
        }

        $user->update($data);

        // Jika diubah menjadi guru dan belum punya record GuruBinaan, buatkan otomatis
        if ($validated['role'] === User::ROLE_GURU && !$user->profilGuru) {
            GuruBinaan::create([
                'nama_lengkap'    => $user->name,
                'user_account_id' => $user->id,
                'pengawas_id'     => auth()->id(),
                'status_jabatan'  => 'GURU',
                'is_active'       => true,
            ]);
        }

        return back()->with('success', "Data akun {$user->name} berhasil diperbarui.");
    }
}