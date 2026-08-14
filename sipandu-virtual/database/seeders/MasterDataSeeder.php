<?php

namespace Database\Seeders;

use App\Models\TahunAjaran;
use App\Models\PeriodeTriwulan;
use App\Models\SekolahBinaan;
use App\Models\GuruBinaan;
use App\Models\DokumenWajib;
use Illuminate\Database\Seeder;

class MasterDataSeeder extends Seeder
{
    public function run(): void
    {
        // Tahun Ajaran
        $ta = TahunAjaran::create([
            'label'     => '2025/2026',
            'is_active' => true,
        ]);

        // Periode Triwulan
        PeriodeTriwulan::create([
            'tahun_ajaran_id' => $ta->id,
            'nomor'           => 1,
            'tema'            => 'Perencanaan & Pemetaan',
            'deadline'        => '2025-03-31',
            'is_open'         => false,
        ]);

        PeriodeTriwulan::create([
            'tahun_ajaran_id' => $ta->id,
            'nomor'           => 2,
            'tema'            => 'Pendampingan Tahap Awal',
            'deadline'        => '2025-06-30',
            'is_open'         => false,
        ]);

        PeriodeTriwulan::create([
            'tahun_ajaran_id' => $ta->id,
            'nomor'           => 3,
            'tema'            => 'Observasi & Umpan Balik',
            'deadline'        => '2025-09-30',
            'is_open'         => false,
        ]);

        PeriodeTriwulan::create([
            'tahun_ajaran_id' => $ta->id,
            'nomor'           => 4,
            'tema'            => 'Evaluasi & Pelaporan',
            'deadline'        => '2025-12-31',
            'is_open'         => false,
        ]);

        // Sekolah Binaan (contoh)
        $sekolah1 = SekolahBinaan::create([
            'nama_sekolah' => 'SMA Negeri 1 Samarinda',
            'jenjang'      => 'SMA',
            'status'       => 'N',
            'is_active'    => true,
        ]);

        $sekolah2 = SekolahBinaan::create([
            'nama_sekolah' => 'SMK Negeri 1 Samarinda',
            'jenjang'      => 'SMK',
            'status'       => 'N',
            'is_active'    => true,
        ]);

        // Guru Binaan (contoh)
        GuruBinaan::create([
            'nama_lengkap'   => 'Ahmad Fauzan',
            'sekolah_id'     => $sekolah1->id,
            'nip_siaga'      => '199001012020011001',
            'status_jabatan' => 'GURU',
            'is_active'      => true,
        ]);

        // Dokumen Wajib (contoh untuk TW I)
        DokumenWajib::create([
            'triwulan'      => 1,
            'nama_dokumen'  => 'Prota & Promes',
            'instruksi'     => 'Upload Program Tahunan dan Program Semester',
            'is_wajib'      => true,
            'berlaku_untuk' => 'SEMUA',
            'is_active'     => true,
            'urutan'        => 1,
        ]);

        DokumenWajib::create([
            'triwulan'      => 1,
            'nama_dokumen'  => 'Silabus',
            'instruksi'     => 'Upload Silabus sesuai mata pelajaran',
            'is_wajib'      => true,
            'berlaku_untuk' => 'SEMUA',
            'is_active'     => true,
            'urutan'        => 2,
        ]);

        DokumenWajib::create([
            'triwulan'      => 1,
            'nama_dokumen'  => 'RPP',
            'instruksi'     => 'Upload Rencana Pelaksanaan Pembelajaran',
            'is_wajib'      => true,
            'berlaku_untuk' => 'SEMUA',
            'is_active'     => true,
            'urutan'        => 3,
        ]);
    }
}