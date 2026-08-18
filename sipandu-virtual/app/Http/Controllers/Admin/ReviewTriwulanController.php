<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use App\Models\UploadDokumen;
use Illuminate\Http\Request;
use App\Notifications\SubmissionReviewedNotification;


class ReviewTriwulanController extends Controller
{
    public function index()
    {
        $submissions = Submission::with(['guru.sekolah', 'periode'])
            ->orderBy('submitted_at', 'desc')
            ->get();
        return view('admin.review-triwulan.index', compact('submissions'));
    }

    public function show($submissionId)
    {
        $submission = Submission::with(['guru.sekolah', 'periode', 'uploadDokumen.dokumenWajib'])
            ->findOrFail($submissionId);
        return view('admin.review-triwulan.show', compact('submission'));
    }

    public function reviewDokumen(Request $request, $uploadId)
    {
        $validated = $request->validate([
            'status' => 'required|in:diterima,revisi',
            'feedback_admin' => 'nullable|string|max:500',
        ]);

        $upload = UploadDokumen::findOrFail($uploadId);
        $upload->update($validated);

        return back()->with('success', 'Review dokumen berhasil disimpan.');
    }

    public function reviewSubmission(Request $request, $submissionId)
    {
        $validated = $request->validate([
            'status_review' => 'required|in:revisi,lengkap',
            'feedback_admin' => 'nullable|string',
        ]);

        $submission = Submission::findOrFail($submissionId);
        $submission->update([
            'status_review' => $validated['status_review'],
            'feedback_admin' => $validated['feedback_admin'],
        ]);

        // Kirim notifikasi email ke guru
        if ($submission->guru->userAccount) {
            $submission->guru->userAccount->notify(new SubmissionReviewedNotification($submission));
        }

        return back()->with('success', 'Review submission berhasil disimpan.');
    }

}