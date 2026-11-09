<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SekolahBinaan;
use App\Models\GuruBinaan;
use App\Models\User;
use App\Models\Submission;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if (!$user->is_profile_complete) {
            return redirect()->route('profile.edit')
                ->with('success', 'Silakan lengkapi data profil wajib Anda terlebih dahulu.');
        }

        return view('admin.dashboard', [
            'totalSekolah'           => SekolahBinaan::where('is_active', true)->count(),
            'totalGuru'              => GuruBinaan::forUser($user)->where('is_active', true)->count(),
            'totalPendingGuru'       => $user->isAdmin() ? User::where('is_approved', false)->count() : 0,
            'totalSubmissionPending' => Submission::forUser($user)->where('status_review', 'submitted')->count(),
        ]);
    }
}