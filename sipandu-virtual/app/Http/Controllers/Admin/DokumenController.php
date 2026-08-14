<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DokumenWajib;
use Illuminate\Http\Request;

class DokumenController extends Controller
{
    public function index()
    {
        $dokumens = DokumenWajib::orderBy('triwulan')->orderBy('urutan')->get();
        return view('admin.dokumen.index', compact('dokumens'));
    }

    public function create()
    {
        return view('admin.dokumen.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'triwulan' => 'required|in:1,2,3,4',
            'nama_dokumen' => 'required|string|max:255',
            'instruksi' => 'required|string',
            'is_wajib' => 'boolean',
            'berlaku_untuk' => 'required|in:SEMUA,KEPSEK',
            'is_active' => 'boolean',
            'urutan' => 'integer',
        ]);

        DokumenWajib::create($validated);

        return redirect()->route('admin.dokumen.index')
            ->with('success', 'Dokumen wajib berhasil ditambahkan.');
    }

    public function edit(DokumenWajib $dokumen)
    {
        return view('admin.dokumen.edit', compact('dokumen'));
    }

    public function update(Request $request, DokumenWajib $dokumen)
    {
        $validated = $request->validate([
            'triwulan' => 'required|in:1,2,3,4',
            'nama_dokumen' => 'required|string|max:255',
            'instruksi' => 'required|string',
            'is_wajib' => 'boolean',
            'berlaku_untuk' => 'required|in:SEMUA,KEPSEK',
            'is_active' => 'boolean',
            'urutan' => 'integer',
        ]);

        $dokumen->update($validated);

        return redirect()->route('admin.dokumen.index')
            ->with('success', 'Dokumen wajib berhasil diupdate.');
    }

    public function destroy(DokumenWajib $dokumen)
    {
        $dokumen->delete();
        return redirect()->route('admin.dokumen.index')
            ->with('success', 'Dokumen wajib berhasil dihapus.');
    }
}