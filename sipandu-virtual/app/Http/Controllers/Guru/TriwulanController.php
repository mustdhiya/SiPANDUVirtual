<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\PeriodeTriwulan;
use App\Models\Submission;
use App\Models\UploadDokumen;
use App\Models\DokumenWajib;
use App\Models\GuruBinaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TriwulanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $guru = GuruBinaan::where('user_account_id', $user->id)->first();

        if (!$guru) {
            return redirect()->route('guru.dashboard')
                ->with('error', 'Profil guru Anda belum lengkap. Hubungi admin.');
        }

        $periodes = PeriodeTriwulan::with('tahunAjaran')
            ->orderBy('tahun_ajaran_id', 'desc')
            ->orderBy('nomor', 'desc')
            ->get();

        $submissions = Submission::where('guru_id', $guru->id)
            ->with('periode')
            ->get();

        return view('guru.triwulan.index', compact('periodes', 'submissions'));
    }

    public function show($periodeId)
    {
        $user = Auth::user();
        $guru = GuruBinaan::where('user_account_id', $user->id)->first();

        if (!$guru) {
            abort(404, 'Profil guru tidak ditemukan.');
        }

        $periode = PeriodeTriwulan::with('tahunAjaran')->findOrFail($periodeId);

        // Cek apakah submission sudah ada
        $submission = Submission::where('guru_id', $guru->id)
            ->where('periode_id', $periode->id)
            ->first();

        if (!$submission) {
            // Buat submission baru
            $submission = Submission::create([
                'guru_id' => $guru->id,
                'periode_id' => $periode->id,
                'status_review' => Submission::STATUS_DRAFT,
            ]);
        }

        // Ambil dokumen wajib untuk triwulan ini
        $dokumenWajibs = DokumenWajib::where('triwulan', $periode->nomor)
            ->where('is_active', true)
            ->orderBy('urutan')
            ->get();

        // Filter berdasarkan tipe guru
        if ($guru->status_jabatan === 'GURU') {
            $dokumenWajibs = $dokumenWajibs->filter(function ($dw) {
                return $dw->berlaku_untuk === 'SEMUA' || $dw->berlaku_untuk === 'KEPSEK';
            });
        }

        // Ambil upload dokumen yang sudah ada
        $uploadedDocs = UploadDokumen::where('submission_id', $submission->id)
            ->with('dokumenWajib')
            ->get()
            ->keyBy('dokumen_wajib_id');

        return view('guru.triwulan.show', compact('periode', 'submission', 'dokumenWajibs', 'uploadedDocs'));
    }

    public function upload(Request $request, $periodeId)
    {
        $user = Auth::user();
        $guru = GuruBinaan::where('user_account_id', $user->id)->first();

        if (!$guru) {
            abort(404, 'Profil guru tidak ditemukan.');
        }

        $periode = PeriodeTriwulan::findOrFail($periodeId);

        $submission = Submission::where('guru_id', $guru->id)
            ->where('periode_id', $periode->id)
            ->first();

        if (!$submission) {
            abort(404, 'Submission tidak ditemukan.');
        }

        $validated = $request->validate([
            'dokumen_wajib_id' => 'required|exists:dokumen_wajibs,id',
            'file' => 'required|file|max:10240', // max 10MB
            'catatan' => 'nullable|string|max:500',
        ]);

        // Upload file
        $file = $validated['file'];
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->store('dokumen/' . $guru->id . '/' . $periode->nomor, 'public');

        // Update atau create upload dokumen
        UploadDokumen::updateOrCreate(
            [
                'submission_id' => $submission->id,
                'dokumen_wajib_id' => $validated['dokumen_wajib_id'],
            ],
            [
                'file' => $filePath,
                'catatan' => $validated['catatan'],
                'status' => UploadDokumen::STATUS_PENDING,
            ]
        );

        return back()->with('success', 'Dokumen berhasil diupload.');
    }

    public function submit($periodeId)
    {
        $user = Auth::user();
        $guru = GuruBinaan::where('user_account_id', $user->id)->first();

        if (!$guru) {
            abort(404, 'Profil guru tidak ditemukan.');
        }

        $periode = PeriodeTriwulan::findOrFail($periodeId);

        $submission = Submission::where('guru_id', $guru->id)
            ->where('periode_id', $periode->id)
            ->first();

        if (!$submission) {
            abort(404, 'Submission tidak ditemukan.');
        }

        // Cek apakah semua dokumen wajib sudah diupload
        $dokumenWajibs = DokumenWajib::where('triwulan', $periode->nomor)
            ->where('is_active', true)
            ->where('is_wajib', true)
            ->get();

        $uploadedCount = UploadDokumen::where('submission_id', $submission->id)
            ->whereIn('dokumen_wajib_id', $dokumenWajibs->pluck('id'))
            ->count();

        if ($uploadedCount < $dokumenWajibs->count()) {
            return back()->with('error', 'Semua dokumen wajib harus diupload sebelum submit.');
        }

        $submission->update([
            'status_review' => Submission::STATUS_SUBMITTED,
            'submitted_at' => now(),
        ]);

        return back()->with('success', 'Submission berhasil dikirim untuk direview admin.');
    }
}