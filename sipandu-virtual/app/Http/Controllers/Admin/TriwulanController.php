<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PeriodeTriwulan;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class TriwulanController extends Controller
{
    public function index()
    {
        $triwulans = PeriodeTriwulan::with('tahunAjaran')
            ->orderBy('tahun_ajaran_id')
            ->orderBy('nomor')
            ->get();
        return view('admin.triwulan.index', compact('triwulans'));
    }

    public function create()
    {
        $tahunAjarans = TahunAjaran::where('is_active', true)->get();
        return view('admin.triwulan.create', compact('tahunAjarans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun_ajaran_id' => 'required|exists:tahun_ajarans,id',
            'nomor' => 'required|in:1,2,3,4',
            'tema' => 'required|string|max:255',
            'deadline' => 'required|date',
            'is_open' => 'boolean',
        ]);

        PeriodeTriwulan::create($validated);

        return redirect()->route('admin.triwulan.index')
            ->with('success', 'Triwulan berhasil ditambahkan.');
    }

    public function edit(PeriodeTriwulan $triwulan)
    {
        $tahunAjarans = TahunAjaran::all();
        return view('admin.triwulan.edit', compact('triwulan', 'tahunAjarans'));
    }

    public function update(Request $request, PeriodeTriwulan $triwulan)
    {
        $validated = $request->validate([
            'tahun_ajaran_id' => 'required|exists:tahun_ajarans,id',
            'nomor' => 'required|in:1,2,3,4',
            'tema' => 'required|string|max:255',
            'deadline' => 'required|date',
            'is_open' => 'boolean',
        ]);

        $triwulan->update($validated);

        return redirect()->route('admin.triwulan.index')
            ->with('success', 'Triwulan berhasil diupdate.');
    }

    public function destroy(PeriodeTriwulan $triwulan)
    {
        $triwulan->delete();
        return redirect()->route('admin.triwulan.index')
            ->with('success', 'Triwulan berhasil dihapus.');
    }
}