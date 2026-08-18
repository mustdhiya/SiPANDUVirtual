<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MateriGudang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GudangController extends Controller
{
    public function index()
    {
        $materis = MateriGudang::with('uploader')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.gudang.index', compact('materis'));
    }

    public function create()
    {
        return view('admin.gudang.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kategori' => 'required|in:materi,instrumen_riset,contoh_perangkat',
            'file' => 'required|file|max:102400', // max 100MB
            'is_active' => 'boolean',
        ]);

        // Upload file
        $file = $validated['file'];
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->store('gudang', 'public');

        MateriGudang::create([
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'],
            'kategori' => $validated['kategori'],
            'file' => $filePath,
            'uploaded_by' => Auth::id(),
            'is_active' => $validated['is_active'] ?? true,
        ]);

        return redirect()->route('admin.gudang.index')
            ->with('success', 'Materi berhasil diupload.');
    }

    public function edit(MateriGudang $materi)
    {
        return view('admin.gudang.edit', compact('materi'));
    }

    public function update(Request $request, MateriGudang $materi)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kategori' => 'required|in:materi,instrumen_riset,contoh_perangkat',
            'is_active' => 'boolean',
        ]);

        $materi->update($validated);

        return redirect()->route('admin.gudang.index')
            ->with('success', 'Materi berhasil diupdate.');
    }

    public function destroy(MateriGudang $materi)
    {
        $materi->delete();
        return redirect()->route('admin.gudang.index')
            ->with('success', 'Materi berhasil dihapus.');
    }
}