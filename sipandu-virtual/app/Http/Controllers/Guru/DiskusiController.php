<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\ThreadDiskusi;
use App\Models\PesanDiskusi;
use App\Models\PeriodeTriwulan;
use App\Models\GuruBinaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiskusiController extends Controller
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

        return view('guru.diskusi.index', compact('periodes'));
    }

    public function show($periodeId)
    {
        $user = Auth::user();
        $guru = GuruBinaan::where('user_account_id', $user->id)->first();

        if (!$guru) {
            abort(404, 'Profil guru tidak ditemukan.');
        }

        $periode = PeriodeTriwulan::with('tahunAjaran')->findOrFail($periodeId);

        $threads = ThreadDiskusi::where('periode_id', $periode->id)
            ->with(['guru.sekolah', 'pesanDiskusi.user'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('guru.diskusi.show', compact('periode', 'threads'));
    }

    public function create($periodeId)
    {
        $user = Auth::user();
        $guru = GuruBinaan::where('user_account_id', $user->id)->first();

        if (!$guru) {
            abort(404, 'Profil guru tidak ditemukan.');
        }

        $periode = PeriodeTriwulan::findOrFail($periodeId);

        return view('guru.diskusi.create', compact('periode'));
    }

    public function store(Request $request, $periodeId)
    {
        $user = Auth::user();
        $guru = GuruBinaan::where('user_account_id', $user->id)->first();

        if (!$guru) {
            abort(404, 'Profil guru tidak ditemukan.');
        }

        $periode = PeriodeTriwulan::findOrFail($periodeId);

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
        ]);

        $thread = ThreadDiskusi::create([
            'guru_id' => $guru->id,
            'periode_id' => $periode->id,
            'judul' => $validated['judul'],
            'isi' => $validated['isi'],
            'is_locked' => false,
        ]);

        // Buat pesan pertama (dari guru)
        PesanDiskusi::create([
            'thread_id' => $thread->id,
            'user_id' => $user->id,
            'isi_pesan' => $validated['isi'],
            'is_admin' => false,
        ]);

        return redirect()->route('guru.diskusi.show', $periode->id)
            ->with('success', 'Thread diskusi berhasil dibuat.');
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
            'is_admin' => false,
        ]);

        return back()->with('success', 'Balasan berhasil dikirim.');
    }
}