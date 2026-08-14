<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SekolahBinaan;
use Illuminate\Http\Request;

class SekolahController extends Controller
{
    public function index()
    {
        $sekolahs = SekolahBinaan::orderBy('nama_sekolah')->get();
        return view('admin.sekolah.index', compact('sekolahs'));
    }

    public function create()
    {
        return view('admin.sekolah.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_sekolah' => 'required|string|max:255',
            'jenjang' => 'required|in:SMA,SMK',
            'status' => 'required|in:N,S',
            'is_active' => 'boolean',
        ]);

        SekolahBinaan::create($validated);

        return redirect()->route('admin.sekolah.index')
            ->with('success', 'Sekolah binaan berhasil ditambahkan.');
    }

    public function edit(SekolahBinaan $sekolah)
    {
        return view('admin.sekolah.edit', compact('sekolah'));
    }

    public function update(Request $request, SekolahBinaan $sekolah)
    {
        $validated = $request->validate([
            'nama_sekolah' => 'required|string|max:255',
            'jenjang' => 'required|in:SMA,SMK',
            'status' => 'required|in:N,S',
            'is_active' => 'boolean',
        ]);

        $sekolah->update($validated);

        return redirect()->route('admin.sekolah.index')
            ->with('success', 'Sekolah binaan berhasil diupdate.');
    }

    public function destroy(SekolahBinaan $sekolah)
    {
        $sekolah->delete();
        return redirect()->route('admin.sekolah.index')
            ->with('success', 'Sekolah binaan berhasil dihapus.');
    }
}