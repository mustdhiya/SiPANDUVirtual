<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalSekolah' => \App\Models\SekolahBinaan::where('is_active', true)->count(),
            'totalGuru' => \App\Models\GuruBinaan::where('is_active', true)->count(),
            'totalPendingGuru' => \App\Models\User::where('role', 'guru')->where('is_approved', false)->count(),
            'totalSubmissionPending' => \App\Models\Submission::where('status_review', 'submitted')->count(),
        ]);
    }
}