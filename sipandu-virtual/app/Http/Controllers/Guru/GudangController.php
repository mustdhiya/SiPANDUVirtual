<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\MateriGudang;

class GudangController extends Controller
{
    public function index()
    {
        $materis = MateriGudang::with('uploader')
            ->where('is_active', true)
            ->orderBy('kategori')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('guru.gudang.index', compact('materis'));
    }

    public function download($materiId)
    {
        $materi = MateriGudang::findOrFail($materiId);

        return response()->download(storage_path('app/public/' . $materi->file));
    }
}