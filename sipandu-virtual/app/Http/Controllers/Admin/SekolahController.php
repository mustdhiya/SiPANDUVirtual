<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SekolahBinaan;
use Illuminate\Http\Request;

class SekolahController extends Controller
{
    private function ensureSuperAdmin(): void
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Hanya Super Admin yang dapat menambah, mengubah, atau menghapus Sekolah Binaan.');
        }
    }

    public function index(Request $request)
    {
        $search = $request->query('search');

        $totalSekolah = SekolahBinaan::count();
        $totalAktif = SekolahBinaan::where('is_active', true)->count();
        $totalSma = SekolahBinaan::where('jenjang', 'SMA')->count();
        $totalSmk = SekolahBinaan::where('jenjang', 'SMK')->count();

        $sekolahs = SekolahBinaan::query()
            ->when($search, function ($q) use ($search) {
                $q->where('nama_sekolah', 'like', "%{$search}%")
                  ->orWhere('nama_kepsek', 'like', "%{$search}%");
            })
            ->orderBy('nama_sekolah')
            ->paginate(15)
            ->withQueryString();

        return view('admin.sekolah.index', compact(
            'sekolahs',
            'search',
            'totalSekolah',
            'totalAktif',
            'totalSma',
            'totalSmk'
        ));
    }

    public function create()
    {
        $this->ensureSuperAdmin();
        return view('admin.sekolah.create');
    }

    public function store(Request $request)
    {
        $this->ensureSuperAdmin();

        $validated = $request->validate([
            'nama_sekolah' => 'required|string|max:255',
            'nama_kepsek'  => 'required|string|max:255',
            'jenjang'      => 'required|in:SMA,SMK',
            'status'       => 'required|in:N,S',
            'is_active'    => 'boolean',
        ]);

        SekolahBinaan::create($validated);

        return redirect()->route('admin.sekolah.index')
            ->with('success', 'Sekolah binaan beserta nama Kepala Sekolah berhasil ditambahkan.');
    }

    public function edit(SekolahBinaan $sekolah)
    {
        $this->ensureSuperAdmin();
        return view('admin.sekolah.edit', compact('sekolah'));
    }

    public function update(Request $request, SekolahBinaan $sekolah)
    {
        $this->ensureSuperAdmin();

        $validated = $request->validate([
            'nama_sekolah' => 'required|string|max:255',
            'nama_kepsek'  => 'required|string|max:255',
            'jenjang'      => 'required|in:SMA,SMK',
            'status'       => 'required|in:N,S',
            'is_active'    => 'boolean',
        ]);

        $sekolah->update($validated);

        return redirect()->route('admin.sekolah.index')
            ->with('success', 'Sekolah binaan berhasil diperbarui.');
    }

    public function destroy(SekolahBinaan $sekolah)
    {
        $this->ensureSuperAdmin();

        $sekolah->delete();
        return redirect()->route('admin.sekolah.index')
            ->with('success', 'Sekolah binaan berhasil dihapus.');
    }
}
