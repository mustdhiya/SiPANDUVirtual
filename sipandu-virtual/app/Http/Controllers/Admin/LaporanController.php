<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PeriodeTriwulan;
use App\Models\Submission;
use App\Models\GuruBinaan;
use App\Models\UploadDokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

    public function show($periodeId)
    {
        $periode = PeriodeTriwulan::with('tahunAjaran')->findOrFail($periodeId);

        // Rekap submission per guru
        $gurus = GuruBinaan::with(['sekolah', 'submissions' => function ($q) use ($periodeId) {
            $q->where('periode_id', $periodeId);
        }])
        ->orderBy('nama_lengkap')
        ->get();

        $stats = [
            'total_guru' => $gurus->count(),
            'sudah_submit' => $gurus->filter(function ($guru) use ($periodeId) {
                return $guru->submissions->where('periode_id', $periodeId)->count() > 0;
            })->count(),
            'belum_submit' => $gurus->filter(function ($guru) use ($periodeId) {
                return $guru->submissions->where('periode_id', $periodeId)->count() === 0;
            })->count(),
            'lengkap' => Submission::where('periode_id', $periodeId)
                ->where('status_review', 'lengkap')
                ->count(),
            'revisi' => Submission::where('periode_id', $periodeId)
                ->where('status_review', 'revisi')
                ->count(),
        ];

        return view('admin.laporan.show', compact('periode', 'gurus', 'stats'));
    }

    public function exportExcel($periodeId)
    {
        $periode = PeriodeTriwulan::with('tahunAjaran')->findOrFail($periodeId);

        $gurus = GuruBinaan::with(['sekolah', 'submissions' => function ($q) use ($periodeId) {
            $q->where('periode_id', $periodeId);
        }])
        ->orderBy('nama_lengkap')
        ->get();

        $data = [];

        foreach ($gurus as $guru) {
            $submission = $guru->submissions->firstWhere('periode_id', $periodeId);

            $data[] = [
                'Nama Guru' => $guru->nama_lengkap,
                'Sekolah' => $guru->sekolah->nama_sekolah ?? '-',
                'Status Jabatan' => $guru->status_jabatan,
                'Status Submission' => $submission ? ucfirst($submission->status_review) : 'Belum Submit',
                'Tanggal Submit' => $submission ? $submission->submitted_at->format('d M Y H:i') : '-',
                'Feedback Admin' => $submission ? ($submission->feedback_admin ?? '-') : '-',
            ];
        }

        return Excel::download(new \App\Exports\LaporanTriwulanExport($data, $periode), 'Laporan_TW_' . $periode->nomor . '_' . $periode->tahunAjaran->label . '.xlsx');
    }

    public function exportPdf($periodeId)
    {
        $periode = PeriodeTriwulan::with('tahunAjaran')->findOrFail($periodeId);

        $gurus = GuruBinaan::with(['sekolah', 'submissions' => function ($q) use ($periodeId) {
            $q->where('periode_id', $periodeId);
        }])
        ->orderBy('nama_lengkap')
        ->get();

        $stats = [
            'total_guru' => $gurus->count(),
            'sudah_submit' => $gurus->filter(function ($guru) use ($periodeId) {
                return $guru->submissions->where('periode_id', $periodeId)->count() > 0;
            })->count(),
            'lengkap' => Submission::where('periode_id', $periodeId)
                ->where('status_review', 'lengkap')
                ->count(),
        ];

        $pdf = Pdf::loadView('admin.laporan.pdf', compact('periode', 'gurus', 'stats'));
        return $pdf->download('Laporan_TW_' . $periode->nomor . '_' . $periode->tahunAjaran->label . '.pdf');
    }
}