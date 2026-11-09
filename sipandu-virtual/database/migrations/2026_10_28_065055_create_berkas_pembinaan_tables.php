<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tambahkan kolom Identitas Pengawas pada tabel users
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'nama_tanpa_gelar')) {
                $table->string('nama_tanpa_gelar')->nullable();
            }
            if (!Schema::hasColumn('users', 'pangkat_golongan')) {
                $table->string('pangkat_golongan')->nullable()->default('Pembina / IV.a');
            }
            if (!Schema::hasColumn('users', 'jabatan_pengawas')) {
                $table->string('jabatan_pengawas')->nullable()->default('Pengawas Sekolah Bidang PAI');
            }
            if (!Schema::hasColumn('users', 'unit_kerja')) {
                $table->string('unit_kerja')->nullable()->default('Kantor Kementerian Agama Kota Samarinda');
            }
            if (!Schema::hasColumn('users', 'kabupaten_kota')) {
                $table->string('kabupaten_kota')->nullable()->default('Kota Samarinda');
            }
            if (!Schema::hasColumn('users', 'provinsi')) {
                $table->string('provinsi')->nullable()->default('Kalimantan Timur');
            }
            if (!Schema::hasColumn('users', 'wilayah_binaan')) {
                $table->string('wilayah_binaan')->nullable()->default('Kota Samarinda');
            }
            if (!Schema::hasColumn('users', 'alias_julukan')) {
                $table->string('alias_julukan')->nullable();
            }
            if (!Schema::hasColumn('users', 'riwayat_singkat')) {
                $table->text('riwayat_singkat')->nullable();
            }
            if (!Schema::hasColumn('users', 'ttd_image')) {
                $table->string('ttd_image')->nullable();
            }
        });

        // 2. Tambahkan status sertifikasi pada tabel guru_binaans
        Schema::table('guru_binaans', function (Blueprint $table) {
            if (!Schema::hasColumn('guru_binaans', 'sudah_sertifikasi')) {
                $table->boolean('sudah_sertifikasi')->default(true);
            }
        });

        // 3. Buat tabel berkas_pembinaans untuk menyimpan berkas bulanan (Januari - Desember) per Pengawas
        if (!Schema::hasTable('berkas_pembinaans')) {
            Schema::create('berkas_pembinaans', function (Blueprint $table) {
                $table->id();
                $table->foreignId('pengawas_id')->constrained('users')->cascadeOnDelete();
                $table->integer('tahun')->default(2026);
                $table->tinyInteger('bulan'); // 1 s.d. 12
                $table->string('tema', 500);
                $table->date('tanggal')->nullable();
                $table->string('hari_tanggal_label')->nullable();
                $table->string('waktu')->default('08.00 - 12.00 WITA');
                $table->string('jp')->default('4 JP');
                $table->string('tempat')->default('Aula KKG/MGMP PAI Kota Samarinda');
                $table->string('metode', 500)->default('Ceramah, workshop perangkat pembelajaran PAI, diskusi kelompok, dan praktik langsung');
                $table->text('catatan_khusus')->nullable();
                $table->json('dokumentasi_foto')->nullable(); // Array 6 slot foto + caption
                $table->json('presensi_guru')->nullable();    // Array [guru_id => 'Hadir'|'Izin'|'Sakit'|'Alpa']
                $table->timestamps();

                $table->unique(['pengawas_id', 'tahun', 'bulan']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('berkas_pembinaans');

        Schema::table('guru_binaans', function (Blueprint $table) {
            if (Schema::hasColumn('guru_binaans', 'sudah_sertifikasi')) {
                $table->dropColumn('sudah_sertifikasi');
            }
        });

        Schema::table('users', function (Blueprint $table) {
            $cols = [
                'nama_tanpa_gelar', 'pangkat_golongan', 'jabatan_pengawas',
                'unit_kerja', 'kabupaten_kota', 'provinsi', 'wilayah_binaan',
                'alias_julukan', 'riwayat_singkat', 'ttd_image',
            ];
            $existing = array_filter($cols, fn($c) => Schema::hasColumn('users', $c));
            if (!empty($existing)) {
                $table->dropColumn($existing);
            }
        });
    }
};