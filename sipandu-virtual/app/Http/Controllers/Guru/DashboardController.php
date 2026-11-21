<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\GuruBinaan;
use App\Models\PeriodeTriwulan;
use App\Models\Submission;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $guru = GuruBinaan::where('user_account_id', $user->id)->first();

        if (!$user->is_profile_complete || !$guru || !$guru->pengawas_id) {
            return redirect()
                ->route('profile.edit')
                ->with('success', 'Silakan lengkapi profil Anda dan pilih Pengawas pembimbing terlebih dahulu.');
        }

        $totalTriwulan = PeriodeTriwulan::count();
        $submissions = Submission::where('guru_id', $guru->id)->get();

        return view('guru.dashboard', [
            'totalTriwulan' => $totalTriwulan,
            'sudahSubmit'   => $submissions->where('status_review', 'submitted')->count(),
            'perluRevisi'   => $submissions->where('status_review', 'revisi')->count(),
            'lengkap'       => $submissions->where('status_review', 'lengkap')->count(),
        ]);
    }
}
