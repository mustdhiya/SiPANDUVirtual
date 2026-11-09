@extends('layouts.admin')

@section('title', 'Berkas Pembinaan Bulan ' . $berkas->nama_bulan . ' ' . $tahun)

@section('content')
@php
    $jumlahHadir = collect($presensi)->filter(fn($st) => $st === 'Hadir')->count();
    $jumlahIzin  = collect($presensi)->filter(fn($st) => $st === 'Izin')->count();
    $jumlahSakit = collect($presensi)->filter(fn($st) => $st === 'Sakit')->count();
    $jumlahAlpa  = collect($presensi)->filter(fn($st) => $st === 'Alpa')->count();
@endphp

<style>
    @media print {
        body * { visibility: hidden; }
        #area-cetak-berkas, #area-cetak-berkas * { visibility: visible; }
        #area-cetak-berkas {
            position: absolute; left: 0; top: 0; width: 100%;
            box-shadow: none !important; border: none !important;
        }
        .no-print { display: none !important; }
    }
</style>

<div class="mx-auto max-w-5xl space-y-8">

    {{-- Navigasi Atas (Tidak ikut tercetak saat print) --}}
    <div class="no-print flex flex-col justify-between gap-4 border-b border-base-300 pb-4 sm:flex-row sm:items-center">
        <div>
            <div class="text-xs font-bold uppercase tracking-widest text-secondary">
                TRIWULAN / BULAN {{ $berkas->romawi_bulan }} &middot; {{ $tahun }}
            </div>
            <h1 class="font-display text-3xl font-semibold text-base-content">{{ $berkas->nama_bulan }}</h1>
            <p class="text-xs text-base-content/70">Sesuaikan detail kegiatan, unggah dokumentasi, atur presensi, lalu cetak berkas.</p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('admin.berkas-pembinaan.index', ['tahun' => $tahun, 'pengawas_id' => $pengawas->id]) }}" class="btn btn-ghost btn-sm rounded-xl">
                &larr; Map Tahunan
            </a>

            <select
                class="select select-bordered select-sm rounded-xl"
                onchange="window.location.href=this.value"
            >
                @foreach(\App\Models\BerkasPembinaan::NAMA_BULAN as $bNum => $bNama)
                    <option
                        value="{{ route('admin.berkas-pembinaan.show', ['tahun' => $tahun, 'bulan' => $bNum, 'pengawas_id' => $pengawas->id]) }}"
                        {{ $bNum === $bulan ? 'selected' : '' }}
                    >
                        {{ $bNama }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    @if(session('success'))
        <div class="no-print alert alert-success rounded-2xl shadow-sm">
            <span class="material-icons">check_circle</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- FORM UTAMA: MIMBAR KEGIATAN + 6 FOTO + PRESENSI GURU BINAAN --}}
    <form
        action="{{ route('admin.berkas-pembinaan.update', ['tahun' => $tahun, 'bulan' => $bulan, 'pengawas_id' => $pengawas->id]) }}"
        method="POST"
        enctype="multipart/form-data"
        class="no-print space-y-6"
    >
        @csrf
        @method('PUT')

        {{-- 1. Mimbar Kegiatan --}}
        <section class="card border border-base-300 bg-base-100 shadow-sm">
            <div class="card-body space-y-4">
                <h2 class="font-display text-lg font-semibold">Mimbar kegiatan</h2>

                <div class="form-control">
                    <label class="label"><span class="label-text text-xs font-semibold">Tema pembinaan</span></label>
                    <textarea name="tema" rows="2" class="textarea textarea-bordered rounded-xl" required>{{ old('tema', $berkas->tema) }}</textarea>
                </div>

                <div class="grid gap-4 sm:grid-cols-3">
                    <div class="form-control">
                        <label class="label"><span class="label-text text-xs font-semibold">Tanggal</span></label>
                        <input type="date" name="tanggal" value="{{ old('tanggal', optional($berkas->tanggal)->format('Y-m-d')) }}" class="input input-bordered rounded-xl" />
                    </div>

                    <div class="form-control">
                        <label class="label"><span class="label-text text-xs font-semibold">Hari &amp; Tanggal (Teks Laporan)</span></label>
                        <input type="text" name="hari_tanggal_label" value="{{ old('hari_tanggal_label', $berkas->hari_tanggal_label) }}" class="input input-bordered rounded-xl" required />
                    </div>

                    <div class="form-control">
                        <label class="label"><span class="label-text text-xs font-semibold">Jam Pelajaran (JP)</span></label>
                        <input type="text" name="jp" value="{{ old('jp', $berkas->jp) }}" class="input input-bordered rounded-xl" required />
                    </div>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div class="form-control">
                        <label class="label"><span class="label-text text-xs font-semibold">Waktu kegiatan</span></label>
                        <input type="text" name="waktu" value="{{ old('waktu', $berkas->waktu) }}" class="input input-bordered rounded-xl" required />
                    </div>

                    <div class="form-control">
                        <label class="label"><span class="label-text text-xs font-semibold">Tempat</span></label>
                        <input type="text" name="tempat" value="{{ old('tempat', $berkas->tempat) }}" class="input input-bordered rounded-xl" required />
                    </div>
                </div>

                <div class="form-control">
                    <label class="label"><span class="label-text text-xs font-semibold">Metode</span></label>
                    <input type="text" name="metode" value="{{ old('metode', $berkas->metode) }}" class="input input-bordered rounded-xl" required />
                </div>

                <div class="form-control">
                    <label class="label"><span class="label-text text-xs font-semibold">Catatan khusus / temuan lapangan (opsional)</span></label>
                    <textarea name="catatan_khusus" rows="2" class="textarea textarea-bordered rounded-xl" placeholder="Tambahkan catatan khusus atau temuan selama pembinaan berlangsung...">{{ old('catatan_khusus', $berkas->catatan_khusus) }}</textarea>
                </div>
            </div>
        </section>

        {{-- 2. Dokumentasi Foto (Maks. 6) --}}
        <section class="card border border-base-300 bg-base-100 shadow-sm">
            <div class="card-body space-y-4">
                <div class="flex items-center justify-between">
                    <h2 class="font-display text-lg font-semibold">Dokumentasi foto (maks. 6)</h2>
                    <span class="text-xs text-base-content/60">Format JPG/PNG, otomatis tampil di lampiran laporan</span>
                </div>

                <div class="grid gap-4 sm:grid-cols-3">
                    @for($i = 1; $i <= 6; $i++)
                        <div class="rounded-2xl border border-base-300 bg-base-200/50 p-3 space-y-2">
                            @if(!empty($slotFoto[$i]['path']))
                                <img src="{{ asset('storage/' . $slotFoto[$i]['path']) }}" alt="Foto {{ $i }}" class="h-32 w-full rounded-xl object-cover" />
                            @else
                                <div class="flex h-32 w-full items-center justify-center rounded-xl bg-base-200 text-xs text-base-content/50">
                                    Foto {{ $i }} belum diunggah
                                </div>
                            @endif

                            <input type="file" name="file_foto[{{ $i }}]" accept="image/*" class="file-input file-input-bordered file-input-xs w-full rounded-lg" />

                            <input
                                type="text"
                                name="caption_foto[{{ $i }}]"
                                value="{{ $slotFoto[$i]['caption'] ?? '' }}"
                                class="input input-bordered input-xs w-full rounded-lg"
                                placeholder="Keterangan foto {{ $i }}"
                            />
                        </div>
                    @endfor
                </div>
            </div>
        </section>

        {{-- 3. Kehadiran Guru Binaan --}}
        <section class="card border border-base-300 bg-base-100 shadow-sm">
            <div class="card-body space-y-4">
                <div class="flex flex-wrap items-center justify-between gap-2">
                    <div>
                        <h2 class="font-display text-lg font-semibold">Kehadiran guru binaan ({{ $guruBinaans->count() }} Guru)</h2>
                        <p class="text-xs text-base-content/60">Otomatis menarik daftar Guru Binaan yang terhubung dengan Anda.</p>
                    </div>
                    <button
                        type="button"
                        class="btn btn-outline btn-xs rounded-lg"
                        onclick="document.querySelectorAll('.select-presensi').forEach(el => el.value = 'Hadir')"
                    >
                        Hadir semua
                    </button>
                </div>

                <div class="max-h-72 overflow-y-auto rounded-2xl border border-base-300">
                    <table class="table table-sm w-full">
                        <thead class="sticky top-0 bg-base-200">
                            <tr>
                                <th>Nama Guru PAI</th>
                                <th>Sekolah</th>
                                <th class="w-40">Status Kehadiran</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($guruBinaans as $g)
                                <tr>
                                    <td class="font-medium">{{ $g->nama_lengkap }}</td>
                                    <td>{{ $g->sekolah->nama_sekolah ?? '-' }}</td>
                                    <td>
                                        <select name="presensi[{{ $g->id }}]" class="select select-bordered select-xs w-full rounded-lg select-presensi">
                                            @foreach(['Hadir', 'Izin', 'Sakit', 'Alpa'] as $st)
                                                <option value="{{ $st }}" {{ ($presensi[$g->id] ?? 'Hadir') === $st ? 'selected' : '' }}>
                                                    {{ $st }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-xs text-base-content/60">
                                        Belum ada Guru Binaan yang terhubung ke akun Anda.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="flex justify-end pt-2">
                    <button type="submit" class="btn btn-primary rounded-xl">
                        <span class="material-icons text-base">save</span>
                        Simpan Perubahan Bulan {{ $berkas->nama_bulan }}
                    </button>
                </div>
            </div>
        </section>
    </form>

    {{-- TOMBOL CETAK & TAB PREVIEW TIGA BERKAS UTAMA --}}
    <section class="space-y-4">
        <div class="no-print flex flex-wrap items-center justify-between gap-3">
            <h2 class="font-display text-xl font-semibold">Tiga berkas utama</h2>

            <div class="flex flex-wrap gap-2">
                <a
                    href="{{ route('admin.berkas-pembinaan.show', ['tahun' => $tahun, 'bulan' => $bulan, 'pengawas_id' => $pengawas->id, 'tab' => 'laporan']) }}"
                    class="btn btn-sm rounded-xl {{ $tabAktif === 'laporan' ? 'btn-primary' : 'btn-outline' }}"
                >
                    1. Laporan + Foto
                </a>
                <a
                    href="{{ route('admin.berkas-pembinaan.show', ['tahun' => $tahun, 'bulan' => $bulan, 'pengawas_id' => $pengawas->id, 'tab' => 'materi']) }}"
                    class="btn btn-sm rounded-xl {{ $tabAktif === 'materi' ? 'btn-primary' : 'btn-outline' }}"
                >
                    2. Materi Presentasi
                </a>
                <a
                    href="{{ route('admin.berkas-pembinaan.show', ['tahun' => $tahun, 'bulan' => $bulan, 'pengawas_id' => $pengawas->id, 'tab' => 'presensi']) }}"
                    class="btn btn-sm rounded-xl {{ $tabAktif === 'presensi' ? 'btn-primary' : 'btn-outline' }}"
                >
                    3. Bukti Presensi
                </a>

                <button type="button" onclick="window.print()" class="btn btn-sm btn-secondary rounded-xl">
                    <span class="material-icons text-sm">print</span>
                    Cetak / Simpan PDF Berkas Ini
                </button>
            </div>
        </div>

        {{-- AREA KERTAS RESMI A4 (SIAP CETAK / SAVE AS PDF) --}}
        <div id="area-cetak-berkas" class="rounded-2xl border border-base-300 bg-white p-8 text-black shadow-md sm:p-12" style="font-family: 'Times New Roman', Times, serif; line-height: 1.6;">

            {{-- KOP SURAT RESMI KEMENAG --}}
            <div class="border-b-4 border-double border-black pb-3 text-center">
                <div class="text-sm font-bold uppercase tracking-wide">KEMENTERIAN AGAMA REPUBLIK INDONESIA</div>
                <div class="text-base font-bold uppercase tracking-wide">{{ strtoupper($pengawas->unit_kerja ?? 'KANTOR KEMENTERIAN AGAMA KOTA SAMARINDA') }}</div>
                <div class="text-xs">Kelompok Kerja Pengawas Pendidikan Agama Islam (POKJAWAS PAI) {{ $pengawas->kabupaten_kota ?? 'Kota Samarinda' }}</div>
                <div class="text-xs italic">Wilayah Binaan: {{ $pengawas->wilayah_binaan ?? 'Kota Samarinda' }} &middot; Provinsi {{ $pengawas->provinsi ?? 'Kalimantan Timur' }}</div>
            </div>

            @if($tabAktif === 'laporan')
                {{-- ISI BERKAS 1: LAPORAN KEGIATAN + DOKUMENTASI FOTO --}}
                <div class="mt-6 text-center">
                    <h3 class="text-base font-bold uppercase underline">LAPORAN KEGIATAN PEMBINAAN PROFESI GURU PAI</h3>
                    <div class="text-xs font-semibold uppercase">BULAN {{ strtoupper($berkas->nama_bulan) }} TAHUN {{ $tahun }}</div>
                </div>

                <table class="mt-6 w-full text-sm">
                    <tr><td class="w-40 font-semibold">Bulan</td><td class="w-4">:</td><td>{{ $berkas->nama_bulan }} {{ $tahun }} ({{ $berkas->romawi_bulan }}/{{ $tahun }})</td></tr>
                    <tr><td class="font-semibold">Tema Pembinaan</td><td>:</td><td>{{ $berkas->tema }}</td></tr>
                    <tr><td class="font-semibold">Hari / Tanggal</td><td>:</td><td>{{ $berkas->hari_tanggal_label }}</td></tr>
                    <tr><td class="font-semibold">Waktu</td><td>:</td><td>{{ $berkas->waktu }}</td></tr>
                    <tr><td class="font-semibold">Tempat</td><td>:</td><td>{{ $berkas->tempat }}</td></tr>
                    <tr><td class="font-semibold">Metode / JP</td><td>:</td><td>{{ $berkas->metode }} ({{ $berkas->jp }})</td></tr>
                    <tr><td class="font-semibold">Narasumber</td><td>:</td><td>{{ $pengawas->name }}</td></tr>
                </table>

                <div class="mt-6 space-y-4 text-sm text-justify">
                    <div>
                        <h4 class="font-bold">I. PENDAHULUAN</h4>
                        <p class="mt-1">
                            Kegiatan pembinaan profesi Guru Pendidikan Agama Islam (PAI) pada wilayah dampingan {{ $pengawas->wilayah_binaan ?? 'Kota Samarinda' }}
                            dilaksanakan secara terprogram setiap bulan sebagai bagian dari pelaksanaan tugas kepengawasan akademik dan manajerial Pengawas Sekolah Bidang PAI
                            pada {{ $pengawas->unit_kerja ?? 'Kantor Kementerian Agama Kota Samarinda' }}.
                            Pada bulan {{ $berkas->nama_bulan }} {{ $tahun }}, kegiatan difokuskan pada tema
                            <em>"{{ $berkas->tema }}"</em> guna meningkatkan kompetensi pedagogik dan profesional Guru PAI binaan.
                        </p>
                    </div>

                    <div>
                        <h4 class="font-bold">II. DASAR HUKUM</h4>
                        <ol class="mt-1 list-decimal list-inside space-y-0.5">
                            <li>Undang-Undang Nomor 20 Tahun 2003 tentang Sistem Pendidikan Nasional.</li>
                            <li>Undang-Undang Nomor 14 Tahun 2005 tentang Guru dan Dosen.</li>
                            <li>Peraturan Pemerintah Nomor 55 Tahun 2007 tentang Pendidikan Agama dan Pendidikan Keagamaan.</li>
                            <li>Peraturan Menteri Agama Nomor 2 Tahun 2012 tentang Pengawas Madrasah dan Pengawas PAI pada Sekolah (beserta perubahannya).</li>
                            <li>Program Kerja Tahunan Pengawas PAI {{ $pengawas->kabupaten_kota ?? 'Kota Samarinda' }} Tahun {{ $tahun }}.</li>
                        </ol>
                    </div>

                    <div>
                        <h4 class="font-bold">III. TUJUAN PEMBINAAN</h4>
                        <ol class="mt-1 list-decimal list-inside space-y-0.5">
                            <li>Meningkatkan pemahaman dan keterampilan Guru PAI binaan terkait {{ strtolower($berkas->tema) }}.</li>
                            <li>Memastikan kesesuaian perangkat dan pelaksanaan pembelajaran PAI di sekolah binaan dengan standar nasional pendidikan.</li>
                            <li>Membangun budaya refleksi, kolaborasi, dan perbaikan berkelanjutan melalui forum KKG/MGMP PAI.</li>
                        </ol>
                    </div>

                    <div>
                        <h4 class="font-bold">IV. PELAKSANAAN KEGIATAN</h4>
                        <p class="mt-1">
                            Kegiatan dilaksanakan pada {{ $berkas->hari_tanggal_label }} pukul {{ $berkas->waktu }} bertempat di {{ $berkas->tempat }},
                            dengan metode {{ $berkas->metode }}. Kegiatan ini diikuti oleh Guru PAI wilayah binaan dengan rincian kehadiran:
                            <strong>{{ $jumlahHadir }} orang Hadir</strong>, {{ $jumlahIzin }} orang Izin, {{ $jumlahSakit }} orang Sakit, dari total {{ $guruBinaans->count() }} Guru Binaan.
                        </p>
                        @if($berkas->catatan_khusus)
                            <p class="mt-2"><strong>Catatan / Temuan Lapangan:</strong> {{ $berkas->catatan_khusus }}</p>
                        @endif
                    </div>

                    <div>
                        <h4 class="font-bold">V. HASIL DAN TINDAK LANJUT</h4>
                        <p class="mt-1">
                            Seluruh peserta yang hadir telah mengikuti pendampingan secara aktif dan menyusun tindak lanjut implementasi di sekolah masing-masing.
                            Pengawas PAI melakukan pemantauan pasca-kegiatan melalui aplikasi <strong>SiPANDU VIRTUAL</strong> untuk memastikan ketercapaian target pembinaan.
                        </p>
                    </div>

                    <div>
                        <h4 class="font-bold">VI. PENUTUP</h4>
                        <p class="mt-1">
                            Demikian laporan kegiatan pembinaan profesi Guru PAI bulan {{ $berkas->nama_bulan }} {{ $tahun }} ini disusun sebagai bukti fisik pelaksanaan tugas
                            kepengawasan dan pertanggungjawaban profesional.
                        </p>
                    </div>
                </div>

                {{-- Blok Tanda Tangan Pengawas --}}
                <div class="mt-8 flex justify-end text-sm">
                    <div class="w-72 text-center">
                        <div>{{ $pengawas->kabupaten_kota ?? 'Samarinda' }}, {{ $berkas->hari_tanggal_label }}</div>
                        <div class="font-semibold">{{ $pengawas->jabatan_pengawas ?? 'Pengawas Sekolah Bidang PAI' }}</div>

                        <div class="my-3 flex justify-center">
                            @if($pengawas->ttd_image)
                                <img src="{{ asset('storage/' . $pengawas->ttd_image) }}" alt="TTD" class="h-20 object-contain" />
                            @elseif($pengawas->foto_profil)
                                <img src="{{ asset('storage/' . $pengawas->foto_profil) }}" alt="Foto Pengawas" class="h-20 w-16 rounded object-cover border border-black" />
                            @else
                                <div class="h-16"></div>
                            @endif
                        </div>

                        <div class="font-bold underline">{{ $pengawas->name }}</div>
                        <div>NIP. {{ $pengawas->nip ?: '-' }}</div>
                    </div>
                </div>

                {{-- Lampiran 6 Foto Dokumentasi --}}
                <div class="mt-10 border-t border-black pt-6">
                    <h4 class="text-sm font-bold uppercase">LAMPIRAN DOKUMENTASI FOTO KEGIATAN ({{ strtoupper($berkas->nama_bulan) }} {{ $tahun }})</h4>
                    <div class="mt-4 grid grid-cols-2 gap-4">
                        @for($i = 1; $i <= 6; $i++)
                            <div class="border border-gray-400 p-2 text-center">
                                @if(!empty($slotFoto[$i]['path']))
                                    <img src="{{ asset('storage/' . $slotFoto[$i]['path']) }}" alt="Foto {{ $i }}" class="mx-auto h-44 w-full object-cover" />
                                @else
                                    <div class="flex h-44 w-full items-center justify-center bg-gray-100 text-xs text-gray-500">
                                        [Slot Dokumentasi Foto {{ $i }}]
                                    </div>
                                @endif
                                <div class="mt-1 text-xs italic">Gambar {{ $i }}: {{ $slotFoto[$i]['caption'] ?? '' }}</div>
                            </div>
                        @endfor
                    </div>
                </div>

            @elseif($tabAktif === 'materi')
                {{-- ISI BERKAS 2: MATERI PRESENTASI & HANDOUT PEMBINAAN --}}
                <div class="mt-6 text-center">
                    <h3 class="text-base font-bold uppercase underline">MATERI POKOK PEMBINAAN PROFESI GURU PAI</h3>
                    <div class="text-xs font-semibold uppercase">BULAN {{ strtoupper($berkas->nama_bulan) }} {{ $tahun }} &middot; {{ $berkas->jp }}</div>
                </div>

                <div class="mt-6 rounded-xl border border-black p-4 text-sm">
                    <div><strong>Topik / Tema Utama:</strong> {{ $berkas->tema }}</div>
                    <div><strong>Narasumber:</strong> {{ $pengawas->name }} ({{ $pengawas->jabatan_pengawas ?? 'Pengawas Sekolah Bidang PAI' }})</div>
                    <div><strong>Sasaran:</strong> {{ $guruBinaans->count() }} Guru PAI Wilayah Binaan ({{ $pengawas->wilayah_binaan ?? 'Kota Samarinda' }})</div>
                </div>

                <div class="mt-6 space-y-4 text-sm">
                    <div>
                        <h4 class="font-bold">1. Fokus &amp; Urgensi Materi</h4>
                        <p class="mt-1">
                            Materi <strong>"{{ $berkas->tema }}"</strong> dirancang untuk membekali Guru PAI dalam merancang, melaksanakan, dan mengevaluasi pembelajaran
                            yang relevan dengan kebutuhan peserta didik serta kebijakan terbaru Kementerian Agama dan Kementerian Pendidikan.
                        </p>
                    </div>

                    <div>
                        <h4 class="font-bold">2. Struktur Sesi Pendampingan ({{ $berkas->jp }})</h4>
                        <ul class="mt-1 list-disc list-inside space-y-1">
                            <li><strong>Sesi 1 (1 JP) — Orientasi Kebijakan &amp; Konsep Dasar:</strong> Pemetaan regulasi dan indikator ketercapaian terkait tema bulanan.</li>
                            <li><strong>Sesi 2 (2 JP) — Workshop &amp; Bedah Perangkat:</strong> Praktik langsung penyusunan/penyesuaian dokumen perangkat pembelajaran PAI oleh guru binaan.</li>
                            <li><strong>Sesi 3 (1 JP) — Presentasi, Umpan Balik, &amp; Rencana Tindak Lanjut:</strong> Reviu silang antar-guru PAI dan penguatan oleh Pengawas PAI.</li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="font-bold">3. Tagihan &amp; Bukti Karya Guru Binaan</h4>
                        <p class="mt-1">
                            Setiap Guru PAI binaan mengunggah hasil tindak lanjut pembinaan bulan {{ $berkas->nama_bulan }} {{ $tahun }} ke dalam platform
                            <strong>SiPANDU VIRTUAL</strong> untuk direviu dan diverifikasi oleh Pengawas Pembimbing.
                        </p>
                    </div>
                </div>

                <div class="mt-10 flex justify-end text-sm">
                    <div class="w-72 text-center">
                        <div>{{ $pengawas->kabupaten_kota ?? 'Samarinda' }}, {{ $berkas->hari_tanggal_label }}</div>
                        <div class="font-semibold">Penyusun Materi / Pengawas PAI,</div>
                        <div class="h-16"></div>
                        <div class="font-bold underline">{{ $pengawas->name }}</div>
                        <div>NIP. {{ $pengawas->nip ?: '-' }}</div>
                    </div>
                </div>

            @else
                {{-- ISI BERKAS 3: BUKTI PRESENSI / DAFTAR HADIR GURU BINAAN --}}
                <div class="mt-6 text-center">
                    <h3 class="text-base font-bold uppercase underline">DAFTAR HADIR KEGIATAN PEMBINAAN PROFESI GURU PAI</h3>
                    <div class="text-xs font-semibold uppercase">BULAN {{ strtoupper($berkas->nama_bulan) }} TAHUN {{ $tahun }}</div>
                </div>

                <div class="mt-4 text-xs space-y-1">
                    <div><strong>Tema Kegiatan:</strong> {{ $berkas->tema }}</div>
                    <div><strong>Hari / Tanggal:</strong> {{ $berkas->hari_tanggal_label }} ({{ $berkas->waktu }}) &middot; <strong>Tempat:</strong> {{ $berkas->tempat }}</div>
                </div>

                <table class="mt-4 w-full border-collapse border border-black text-xs">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border border-black px-2 py-1.5 text-center w-10">No</th>
                            <th class="border border-black px-2 py-1.5 text-left">Nama Lengkap Guru PAI</th>
                            <th class="border border-black px-2 py-1.5 text-left">NIP / SIAGA</th>
                            <th class="border border-black px-2 py-1.5 text-left">Unit Kerja / Sekolah</th>
                            <th class="border border-black px-2 py-1.5 text-center w-24">Kehadiran</th>
                            <th class="border border-black px-2 py-1.5 text-center w-28">Ket. / Paraf</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($guruBinaans as $idx => $g)
                            @php $statusHadir = $presensi[$g->id] ?? 'Hadir'; @endphp
                            <tr>
                                <td class="border border-black px-2 py-1.5 text-center">{{ $idx + 1 }}</td>
                                <td class="border border-black px-2 py-1.5 font-medium">{{ $g->nama_lengkap }}</td>
                                <td class="border border-black px-2 py-1.5">{{ $g->nip_siaga ?: '-' }}</td>
                                <td class="border border-black px-2 py-1.5">{{ $g->sekolah->nama_sekolah ?? '-' }}</td>
                                <td class="border border-black px-2 py-1.5 text-center font-semibold">{{ $statusHadir }}</td>
                                <td class="border border-black px-2 py-1.5 text-center">
                                    {{ $statusHadir === 'Hadir' ? '✓ Hadir' : $statusHadir }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="border border-black p-4 text-center">Belum ada data Guru Binaan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-3 text-xs">
                    <strong>Rekapitulasi Kehadiran:</strong>
                    Total Guru Binaan: {{ $guruBinaans->count() }} orang &middot;
                    Hadir: {{ $jumlahHadir }} orang &middot;
                    Izin: {{ $jumlahIzin }} orang &middot;
                    Sakit: {{ $jumlahSakit }} orang &middot;
                    Tanpa Keterangan: {{ $jumlahAlpa }} orang.
                </div>

                <div class="mt-8 flex justify-end text-sm">
                    <div class="w-72 text-center">
                        <div>{{ $pengawas->kabupaten_kota ?? 'Samarinda' }}, {{ $berkas->hari_tanggal_label }}</div>
                        <div class="font-semibold">{{ $pengawas->jabatan_pengawas ?? 'Pengawas Sekolah Bidang PAI' }}</div>
                        <div class="h-16"></div>
                        <div class="font-bold underline">{{ $pengawas->name }}</div>
                        <div>NIP. {{ $pengawas->nip ?: '-' }}</div>
                    </div>
                </div>
            @endif

        </div>
    </section>

</div>
@endsection