<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BerkasPembinaan extends Model
{
    use HasFactory;

    protected $fillable = [
        'pengawas_id',
        'tahun',
        'bulan',
        'tema',
        'tanggal',
        'hari_tanggal_label',
        'waktu',
        'jp',
        'tempat',
        'metode',
        'catatan_khusus',
        'dokumentasi_foto',
        'presensi_guru',
    ];

    protected $casts = [
        'tanggal'          => 'date',
        'dokumentasi_foto' => 'array',
        'presensi_guru'    => 'array',
    ];

    const NAMA_BULAN = [
        1  => 'Januari',
        2  => 'Februari',
        3  => 'Maret',
        4  => 'April',
        5  => 'Mei',
        6  => 'Juni',
        7  => 'Juli',
        8  => 'Agustus',
        9  => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember',
    ];

    const ROMAWI_BULAN = [
        1  => 'I',
        2  => 'II',
        3  => 'III',
        4  => 'IV',
        5  => 'V',
        6  => 'VI',
        7  => 'VII',
        8  => 'VIII',
        9  => 'IX',
        10 => 'X',
        11 => 'XI',
        12 => 'XII',
    ];

    const DEFAULT_TEMA_BULANAN = [
        1  => 'Penguatan Moderasi Beragama dalam Pembelajaran PAI dan Budi Pekerti',
        2  => 'Penyusunan ATP PAI Berbasis Pembelajaran Mendalam (Deep Learning) sesuai PPA 2025',
        3  => 'Asesmen Autentik PAI sesuai Panduan Pembelajaran dan Asesmen Edisi Revisi 2025',
        4  => 'Integrasi Lima Elemen PAI (Al-Qur\'an Hadis, Akidah, Akhlak, Fikih, SPI) dalam PPM',
        5  => 'Pembiasaan Ibadah dan Adab di Sekolah: Gerakan 5S plus Doa, Tilawah, dan PHBS Islami',
        6  => 'Evaluasi Tengah Tahun dan Berbagi Praktik Baik Guru PAI Wilayah Binaan',
        7  => 'Pemanfaatan Koding dan Kecerdasan Artifisial untuk Penyusunan Perangkat Pembelajaran Mendalam (Deep Learning) Mata Pelajaran PAI',
        8  => 'Penguatan Karakter Profil Lulusan melalui Keteladanan Guru PAI',
        9  => 'Pendampingan Implementasi Capaian Pembelajaran PAI sesuai BKPDM No. 020 Tahun 2026',
        10 => 'Supervisi Akademik Berbasis Coaching bagi Guru PAI',
        11 => 'Pengelolaan KKG/MGMP PAI sebagai Komunitas Belajar Profesional',
        12 => 'Refleksi Tahunan Pembinaan Profesi dan Rencana Tindak Lanjut Tahun 2027',
    ];

    const DEFAULT_SLOT_FOTO = [
        1 => ['path' => null, 'caption' => 'Sambutan dan pembukaan kegiatan pembinaan'],
        2 => ['path' => null, 'caption' => 'Penyampaian materi pembinaan oleh Pengawas PAI'],
        3 => ['path' => null, 'caption' => 'Diskusi kelompok dan bedah perangkat pembelajaran'],
        4 => ['path' => null, 'caption' => 'Pendampingan individu / praktik penyusunan perangkat'],
        5 => ['path' => null, 'caption' => 'Sesi tanya jawab dan umpan balik peserta'],
        6 => ['path' => null, 'caption' => 'Foto bersama Guru PAI wilayah binaan'],
    ];

    public function pengawas(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pengawas_id');
    }

    public function getNamaBulanAttribute(): string
    {
        return self::NAMA_BULAN[$this->bulan] ?? '';
    }

    public function getRomawiBulanAttribute(): string
    {
        return self::ROMAWI_BULAN[$this->bulan] ?? '';
    }
}