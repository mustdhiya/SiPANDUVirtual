<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\GuruApprovedNotification;
use App\Notifications\GuruRejectedNotification;
use App\Services\WaNotificationService;


class ApproveGuruController extends Controller
{
    public function index()
    {
        $pendingGurus = User::where('role', User::ROLE_GURU)
            ->where('is_approved', false)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.approve-guru.index', compact('pendingGurus'));
    }
    public function approve(User $user)
    {
        if ($user->role !== User::ROLE_GURU) {
            return back()->with('error', 'User bukan guru.');
        }

        $user->update([
            'is_approved' => true,
            'status' => User::STATUS_ACTIVE,
        ]);

        // Kirim notifikasi email
        $user->notify(new GuruApprovedNotification());

        // TODO: Kirim notifikasi WA (opsional)
        // Kirim notifikasi WA
        if ($user->nomor_wa) {
            $waService = new WaNotificationService();
            $waService->sendGuruApproved($user->nomor_wa, $user->name);
        }

        return back()->with('success', 'Guru berhasil disetujui.');
    }

    public function reject(Request $request, User $user)
    {
        if ($user->role !== User::ROLE_GURU) {
            return back()->with('error', 'User bukan guru.');
        }

        $validated = $request->validate([
            'alasan' => 'required|string|max:500',
        ]);

        $user->update([
            'is_approved' => false,
            'status' => User::STATUS_SUSPENDED,
        ]);

        // Kirim notifikasi email
        $user->notify(new GuruRejectedNotification($validated['alasan']));

        // TODO: Kirim notifikasi WA (opsional)// Kirim notifikasi WA
        if ($user->nomor_wa) {
            $waService = new WaNotificationService();
            $waService->sendGuruRejected($user->nomor_wa, $user->name, $validated['alasan']);
        }

        return back()->with('success', 'Guru ditolak. Alasan: ' . $validated['alasan']);
    }

}