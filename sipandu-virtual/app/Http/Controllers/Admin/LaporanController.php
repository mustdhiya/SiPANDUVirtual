<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PeriodeTriwulan;
use App\Models\Submission;
use App\Models\GuruBinaan;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index()
    {
        $periodes = PeriodeTriwulan::with('tahunAjaran')
            ->orderBy('tahun_ajaran_id', 'desc')
            ->orderBy('nomor', 'desc')
            ->get();

        return view('admin.laporan.index', compact('periodes'));
    }

    public function show(Request $request, $periodeId)
    {
        $user = auth()->user();
        $periode = PeriodeTriwulan::with('tahunAjaran')->findOrFail($periodeId);

        // Super Admin bisa memantau semua pengawas atau menyaring per pengawas;
        // Pengawas biasa HANYA boleh melihat guru binaan miliknya sendiri.
        $selectedPengawasId = ($user->isAdmin() && $request->filled('pengawas_id'))
            ? (int) $request->query('pengawas_id')
            : null;

        $daftarPengawas = $user->isAdmin()
            ? User::whereIn('role', [User::ROLE_ADMIN, User::ROLE_PENGAWAS])
                ->where('is_approved', true)
                ->orderBy('name')
                ->get()
            : collect();

        $guruQuery = GuruBinaan::forUser($user)
            ->with(['sekolah', 'pengawas', 'submissions' => function ($q) use ($periodeId) {
                $q->where('periode_id', $periodeId);
            }]);

        if ($selectedPengawasId) {
            $guruQuery->where('pengawas_id', $selectedPengawasId);
        }

        $gurus = $guruQuery->orderBy('nama_lengkap')->get();

        $guruIds = $gurus->pluck('id');

        $stats = [
            'total_guru' => $gurus->count(),
            'sudah_submit' => $gurus->filter(function ($guru) use ($periodeId) {
                return $guru->submissions->where('periode_id', $periodeId)->count() > 0;
            })->count(),
            'belum_submit' => $gurus->filter(function ($guru) use ($periodeId) {
                return $guru->submissions->where('periode_id', $periodeId)->count() === 0;
            })->count(),
            'lengkap' => Submission::whereIn('guru_id', $guruIds)
                ->where('periode_id', $periodeId)
                ->where('status_review', 'lengkap')
                ->count(),
            'revisi' => Submission::whereIn('guru_id', $guruIds)
                ->where('periode_id', $periodeId)
                ->where('status_review', 'revisi')
                ->count(),
        ];

        return view('admin.laporan.show', compact(
            'periode',
            'gurus',
            'stats',
            'daftarPengawas',
            'selectedPengawasId'
        ));
    }

    public function exportExcel(Request $request, $periodeId)
    {
        $user = auth()->user();
        $periode = PeriodeTriwulan::with('tahunAjaran')->findOrFail($periodeId);

        $guruQuery = GuruBinaan::forUser($user)
            ->with(['sekolah', 'pengawas', 'submissions' => function ($q) use ($periodeId) {
                $q->where('periode_id', $periodeId);
            }]);

        if ($user->isAdmin() && $request->filled('pengawas_id')) {
            $guruQuery->where('pengawas_id', (int) $request->query('pengawas_id'));
        }

        $gurus = $guruQuery->orderBy('nama_lengkap')->get();

        $data = [];

        foreach ($gurus as $guru) {
            $submission = $guru->submissions->firstWhere('periode_id', $periodeId);

            $data[] = [
                'Nama Guru' => $guru->nama_lengkap,
                'Sekolah' => $guru->sekolah->nama_sekolah ?? '-',
                'Pengawas' => $guru->pengawas->name ?? '-',
                'Status Jabatan' => $guru->status_jabatan,
                'Status Submission' => $submission ? ucfirst($submission->status_review) : 'Belum Submit',
                'Tanggal Submit' => $submission && $submission->submitted_at ? $submission->submitted_at->format('d M Y H:i') : '-',
                'Feedback Admin' => $submission ? ($submission->feedback_admin ?? '-') : '-',
            ];
        }

        return Excel::download(
            new \App\Exports\LaporanTriwulanExport($data, $periode),
            'Laporan_TW_' . $periode->nomor . '_' . str_replace('/', '-', $periode->tahunAjaran->label) . '.xlsx'
        );
    }

    public function exportPdf(Request $request, $periodeId)
    {
        $user = auth()->user();
        $periode = PeriodeTriwulan::with('tahunAjaran')->findOrFail($periodeId);

        $guruQuery = GuruBinaan::forUser($user)
            ->with(['sekolah', 'pengawas', 'submissions' => function ($q) use ($periodeId) {
                $q->where('periode_id', $periodeId);
            }]);

        if ($user->isAdmin() && $request->filled('pengawas_id')) {
            $guruQuery->where('pengawas_id', (int) $request->query('pengawas_id'));
        }

        $gurus = $guruQuery->orderBy('nama_lengkap')->get();
        $guruIds = $gurus->pluck('id');

        $stats = [
            'total_guru' => $gurus->count(),
            'sudah_submit' => $gurus->filter(function ($guru) use ($periodeId) {
                return $guru->submissions->where('periode_id', $periodeId)->count() > 0;
            })->count(),
            'lengkap' => Submission::whereIn('guru_id', $guruIds)
                ->where('periode_id', $periodeId)
                ->where('status_review', 'lengkap')
                ->count(),
            'revisi' => Submission::whereIn('guru_id', $guruIds)
                ->where('periode_id', $periodeId)
                ->where('status_review', 'revisi')
                ->count(),
        ];

        $pdf = Pdf::loadView('admin.laporan.pdf', compact('periode', 'gurus', 'stats'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('Laporan_TW_' . $periode->nomor . '_' . str_replace('/', '-', $periode->tahunAjaran->label) . '.pdf');
    }
}
