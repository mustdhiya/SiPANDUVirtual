<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PeriodeTriwulan;
use App\Models\GuruBinaan;
use App\Models\Submission;
use App\Models\MatriksPrioritas;
use App\Models\UploadDokumen;
use App\Models\DokumenWajib;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MonitoringController extends Controller
{
    public function index()
    {
        $periodes = PeriodeTriwulan::with('tahunAjaran')
            ->orderBy('tahun_ajaran_id', 'desc')
            ->orderBy('nomor', 'desc')
            ->get();

        return view('admin.monitoring.index', compact('periodes'));
    }

    public function show($periodeId)
    {
        $periode = PeriodeTriwulan::with('tahunAjaran')->findOrFail($periodeId);

        $gurus = GuruBinaan::with(['sekolah', 'submissions' => function ($q) use ($periodeId) {
            $q->where('periode_id', $periodeId);
        }])
        ->orderBy('nama_lengkap')
        ->get();

        // Hitung skor & kategori prioritas untuk setiap guru
        $gurusWithSkor = $gurus->map(function ($guru) use ($periodeId, $periode) {
            $submission = $guru->submissions->firstWhere('periode_id', $periodeId);

            // Skor kelengkapan: % dokumen yang sudah diupload
            $dokumenWajibs = DokumenWajib::where('triwulan', $periode->nomor)
                ->where('is_active', true)
                ->where('is_wajib', true)
                ->count();

            $uploadedCount = 0;
            if ($submission) {
                $uploadedCount = UploadDokumen::where('submission_id', $submission->id)
                    ->whereIn('status', ['diterima', 'pending'])
                    ->count();
            }

            $skorKelengkapan = $dokumenWajibs > 0 ? ($uploadedCount / $dokumenWajibs) * 100 : 0;

            // Skor respons: berdasarkan status submission
            $skorRespons = 0;
            if ($submission) {
                $skorRespons = [
                    'draft' => 25,
                    'submitted' => 50,
                    'revisi' => 60,
                    'lengkap' => 100,
                ][$submission->status_review] ?? 0;
            }

            $skorTotal = ($skorKelengkapan + $skorRespons) / 2;

            // Kategori prioritas
            if ($skorTotal < 40) {
                $kategori = MatriksPrioritas::KATEGORI_PRIORITAS_UTAMA;
            } elseif ($skorTotal < 70) {
                $kategori = MatriksPrioritas::KATEGORI_PRIORITAS_MENENGAH;
            } else {
                $kategori = MatriksPrioritas::KATEGORI_PRIORITAS_AKHIR;
            }

            // Simpan atau update matriks prioritas
            MatriksPrioritas::updateOrCreate(
                [
                    'guru_id' => $guru->id,
                    'periode_id' => $periodeId,
                ],
                [
                    'kategori_prioritas' => $kategori,
                    'skor_kelengkapan' => round($skorKelengkapan, 2),
                    'skor_respons' => round($skorRespons, 2),
                    'skor_total' => round($skorTotal, 2),
                ]
            );

            return [
                'guru' => $guru,
                'submission' => $submission,
                'skor_kelengkapan' => round($skorKelengkapan, 2),
                'skor_respons' => round($skorRespons, 2),
                'skor_total' => round($skorTotal, 2),
                'kategori' => $kategori,
            ];
        });

        // Group by kategori
        $prioritasUtama = $gurusWithSkor->filter(fn($g) => $g['kategori'] === MatriksPrioritas::KATEGORI_PRIORITAS_UTAMA);
        $prioritasMenengah = $gurusWithSkor->filter(fn($g) => $g['kategori'] === MatriksPrioritas::KATEGORI_PRIORITAS_MENENGAH);
        $prioritasAkhir = $gurusWithSkor->filter(fn($g) => $g['kategori'] === MatriksPrioritas::KATEGORI_PRIORITAS_AKHIR);

        return view('admin.monitoring.show', compact('periode', 'gurusWithSkor', 'prioritasUtama', 'prioritasMenengah', 'prioritasAkhir'));
    }

    public function updateCatatan(Request $request, $guruId, $periodeId)
    {
        $validated = $request->validate([
            'catatan_admin' => 'nullable|string|max:500',
        ]);

        $matriks = MatriksPrioritas::where('guru_id', $guruId)
            ->where('periode_id', $periodeId)
            ->first();

        if ($matriks) {
            $matriks->update(['catatan_admin' => $validated['catatan_admin']]);
        }

        return back()->with('success', 'Catatan berhasil disimpan.');
    }
}