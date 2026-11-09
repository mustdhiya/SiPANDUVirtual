<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BerkasPembinaan;
use App\Models\GuruBinaan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class BerkasPembinaanController extends Controller
{
    /**
     * Halaman Utama Generator Berkas (Map Tahunan 12 Bulan)
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $tahun = (int) $request->input('tahun', date('Y'));

        // Jika Super Admin ingin memantau pengawas tertentu, bisa lewat ?pengawas_id=...
        $targetPengawasId = ($user->isAdmin() && $request->filled('pengawas_id'))
            ? (int) $request->input('pengawas_id')
            : $user->id;

        $pengawas = User::findOrFail($targetPengawasId);

        // Pastikan ke-12 bulan untuk tahun tersebut sudah ter-inisialisasi
        for ($b = 1; $b <= 12; $b++) {
            BerkasPembinaan::firstOrCreate(
                [
                    'pengawas_id' => $pengawas->id,
                    'tahun'       => $tahun,
                    'bulan'       => $b,
                ],
                [
                    'tema'               => BerkasPembinaan::DEFAULT_TEMA_BULANAN[$b],
                    'tanggal'            => Carbon::create($tahun, $b, 12)->format('Y-m-d'),
                    'hari_tanggal_label' => Carbon::create($tahun, $b, 12)->translatedFormat('l, d F Y'),
                    'waktu'              => '08.00 - 12.00 WITA',
                    'jp'                 => '4 JP',
                    'tempat'             => 'Aula KKG/MGMP PAI ' . ($pengawas->kabupaten_kota ?? 'Kota Samarinda'),
                    'metode'             => 'Ceramah, workshop perangkat PAI, diskusi kelompok, dan praktik langsung (4 JP)',
                    'dokumentasi_foto'   => BerkasPembinaan::DEFAULT_SLOT_FOTO,
                ]
            );
        }

        $berkasBulanan = BerkasPembinaan::where('pengawas_id', $pengawas->id)
            ->where('tahun', $tahun)
            ->orderBy('bulan')
            ->get()
            ->keyBy('bulan');

        $guruBinaans = GuruBinaan::where('pengawas_id', $pengawas->id)
            ->where('is_active', true)
            ->with('sekolah')
            ->orderBy('nama_lengkap')
            ->get();

        $totalGuru = $guruBinaans->count();
        $totalSertifikasi = $guruBinaans->where('sudah_sertifikasi', true)->count();

        $daftarPengawas = $user->isAdmin()
            ? User::whereIn('role', [User::ROLE_ADMIN, User::ROLE_PENGAWAS])->where('is_approved', true)->orderBy('name')->get()
            : collect();

        return view('admin.berkas-pembinaan.index', compact(
            'pengawas',
            'tahun',
            'berkasBulanan',
            'totalGuru',
            'totalSertifikasi',
            'daftarPengawas'
        ));
    }

    /**
     * Halaman Detail Bulanan: Mimbar Kegiatan, 6 Foto, Presensi Guru Binaan, & Preview 3 Berkas
     */
    public function show(Request $request, int $tahun, int $bulan)
    {
        abort_if($bulan < 1 || $bulan > 12, 404);

        $user = Auth::user();
        $targetPengawasId = ($user->isAdmin() && $request->filled('pengawas_id'))
            ? (int) $request->input('pengawas_id')
            : $user->id;

        $pengawas = User::findOrFail($targetPengawasId);

        $berkas = BerkasPembinaan::firstOrCreate(
            [
                'pengawas_id' => $pengawas->id,
                'tahun'       => $tahun,
                'bulan'       => $bulan,
            ],
            [
                'tema'               => BerkasPembinaan::DEFAULT_TEMA_BULANAN[$bulan],
                'tanggal'            => Carbon::create($tahun, $bulan, 12)->format('Y-m-d'),
                'hari_tanggal_label' => Carbon::create($tahun, $bulan, 12)->translatedFormat('l, d F Y'),
                'waktu'              => '08.00 - 12.00 WITA',
                'jp'                 => '4 JP',
                'tempat'             => 'Aula KKG/MGMP PAI ' . ($pengawas->kabupaten_kota ?? 'Kota Samarinda'),
                'metode'             => 'Ceramah, workshop perangkat PAI, diskusi kelompok, dan praktik langsung (4 JP)',
                'dokumentasi_foto'   => BerkasPembinaan::DEFAULT_SLOT_FOTO,
            ]
        );

        $guruBinaans = GuruBinaan::where('pengawas_id', $pengawas->id)
            ->where('is_active', true)
            ->with('sekolah')
            ->orderBy('nama_lengkap')
            ->get();

        // Inisialisasi presensi default 'Hadir' untuk semua guru binaan jika belum diatur
        $presensi = $berkas->presensi_guru ?? [];
        foreach ($guruBinaans as $g) {
            if (!isset($presensi[$g->id])) {
                $presensi[$g->id] = 'Hadir';
            }
        }

        $slotFoto = $berkas->dokumentasi_foto ?? BerkasPembinaan::DEFAULT_SLOT_FOTO;
        for ($i = 1; $i <= 6; $i++) {
            if (!isset($slotFoto[$i])) {
                $slotFoto[$i] = BerkasPembinaan::DEFAULT_SLOT_FOTO[$i];
            }
        }

        $tabAktif = $request->input('tab', 'laporan');

        return view('admin.berkas-pembinaan.show', compact(
            'pengawas',
            'tahun',
            'bulan',
            'berkas',
            'guruBinaans',
            'presensi',
            'slotFoto',
            'tabAktif'
        ));
    }

    /**
     * Simpan perubahan Mimbar Kegiatan, 6 Dokumentasi Foto, & Kehadiran Guru Binaan
     */
    public function updateBulan(Request $request, int $tahun, int $bulan)
    {
        $user = Auth::user();
        $targetPengawasId = ($user->isAdmin() && $request->filled('pengawas_id'))
            ? (int) $request->input('pengawas_id')
            : $user->id;

        $berkas = BerkasPembinaan::where('pengawas_id', $targetPengawasId)
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->firstOrFail();

        $validated = $request->validate([
            'tema'               => 'required|string|max:500',
            'tanggal'            => 'nullable|date',
            'hari_tanggal_label' => 'required|string|max:150',
            'waktu'              => 'required|string|max:100',
            'jp'                 => 'required|string|max:50',
            'tempat'             => 'required|string|max:255',
            'metode'             => 'required|string|max:500',
            'catatan_khusus'     => 'nullable|string',
            'presensi'           => 'nullable|array',
            'caption_foto'       => 'nullable|array',
            'file_foto.*'        => 'nullable|image|max:5120', // Maks 5MB per foto
        ]);

        $slotFoto = $berkas->dokumentasi_foto ?? BerkasPembinaan::DEFAULT_SLOT_FOTO;

        for ($i = 1; $i <= 6; $i++) {
            if (isset($validated['caption_foto'][$i])) {
                $slotFoto[$i]['caption'] = $validated['caption_foto'][$i];
            }

            if ($request->hasFile("file_foto.$i")) {
                $path = $request->file("file_foto.$i")->store("berkas-pembinaan/{$targetPengawasId}/{$tahun}_{$bulan}", 'public');
                $slotFoto[$i]['path'] = $path;
            }
        }

        $berkas->update([
            'tema'               => $validated['tema'],
            'tanggal'            => $validated['tanggal'] ?? $berkas->tanggal,
            'hari_tanggal_label' => $validated['hari_tanggal_label'],
            'waktu'              => $validated['waktu'],
            'jp'                 => $validated['jp'],
            'tempat'             => $validated['tempat'],
            'metode'             => $validated['metode'],
            'catatan_khusus'     => $validated['catatan_khusus'] ?? null,
            'dokumentasi_foto'   => $slotFoto,
            'presensi_guru'      => $validated['presensi'] ?? $berkas->presensi_guru,
        ]);

        return back()->with('success', 'Data kegiatan, dokumentasi foto, dan daftar hadir bulan ' . $berkas->nama_bulan . ' berhasil diperbarui.');
    }

    /**
     * Halaman Form Identitas Pengawas (Kop Surat, Pas Foto, TTD, Wilayah Binaan)
     */
    public function identitas()
    {
        $pengawas = Auth::user();
        return view('admin.berkas-pembinaan.identitas', compact('pengawas'));
    }

    /**
     * Simpan Identitas Pengawas
     */
    public function updateIdentitas(Request $request)
    {
        $pengawas = Auth::user();

        $validated = $request->validate([
            'name'             => 'required|string|max:255',
            'nama_tanpa_gelar' => 'nullable|string|max:255',
            'nip'              => 'nullable|string|max:50',
            'pangkat_golongan' => 'required|string|max:100',
            'jabatan_pengawas' => 'required|string|max:150',
            'unit_kerja'       => 'required|string|max:255',
            'kabupaten_kota'   => 'required|string|max:150',
            'provinsi'         => 'required|string|max:150',
            'wilayah_binaan'   => 'required|string|max:255',
            'nomor_wa'         => 'nullable|string|max:30',
            'email'            => 'required|email|unique:users,email,' . $pengawas->id,
            'alias_julukan'    => 'nullable|string|max:255',
            'riwayat_singkat'  => 'nullable|string',
            'foto_profil'      => 'nullable|image|max:4096',
            'ttd_image'        => 'nullable|image|max:4096',
        ]);

        if ($request->hasFile('foto_profil')) {
            $validated['foto_profil'] = $request->file('foto_profil')->store('profil-pengawas', 'public');
        } else {
            unset($validated['foto_profil']);
        }

        if ($request->hasFile('ttd_image')) {
            $validated['ttd_image'] = $request->file('ttd_image')->store('ttd-pengawas', 'public');
        } else {
            unset($validated['ttd_image']);
        }

        $validated['is_profile_complete'] = true;

        $pengawas->update($validated);

        return redirect()
            ->route('admin.berkas-pembinaan.index')
            ->with('success', 'Identitas Pengawas berhasil disimpan dan siap digunakan pada Kop Surat & Tanda Tangan.');
    }
}