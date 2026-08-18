<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ThreadDiskusi;
use App\Models\PesanDiskusi;
use App\Models\PeriodeTriwulan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiskusiController extends Controller
{
    public function index()
    {
        $periodes = PeriodeTriwulan::with('tahunAjaran')
            ->orderBy('tahun_ajaran_id', 'desc')
            ->orderBy('nomor', 'desc')
            ->get();

        return view('admin.diskusi.index', compact('periodes'));
    }

    public function show($periodeId)
    {
        $periode = PeriodeTriwulan::with('tahunAjaran')->findOrFail($periodeId);

        $threads = ThreadDiskusi::where('periode_id', $periode->id)
            ->with(['guru.sekolah', 'pesanDiskusi.user'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.diskusi.show', compact('periode', 'threads'));
    }

    public function reply(Request $request, $threadId)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'isi_pesan' => 'required|string',
        ]);

        $thread = ThreadDiskusi::findOrFail($threadId);

        if ($thread->is_locked) {
            return back()->with('error', 'Thread ini sudah dikunci.');
        }

        PesanDiskusi::create([
            'thread_id' => $thread->id,
            'user_id' => $user->id,
            'isi_pesan' => $validated['isi_pesan'],
            'is_admin' => true,
        ]);

        return back()->with('success', 'Balasan berhasil dikirim.');
    }

    public function lock($threadId)
    {
        $thread = ThreadDiskusi::findOrFail($threadId);
        $thread->update(['is_locked' => true]);

        return back()->with('success', 'Thread berhasil dikunci.');
    }

    public function unlock($threadId)
    {
        $thread = ThreadDiskusi::findOrFail($threadId);
        $thread->update(['is_locked' => false]);

        return back()->with('success', 'Thread berhasil dibuka.');
    }
}