@extends(auth()->user()->isPanelPengawas() ? 'layouts.admin' : 'layouts.guru')

@section('title', 'Panduan Penggunaan')

@section('content')
@php
    $isSuperAdmin = $user->isAdmin();
    $isPengawas = $user->isPengawas();
    $isGuru = $user->isGuru();
    $dashboardUrl = $user->isPanelPengawas()
        ? route('admin.dashboard', ['start_tour' => 1])
        : route('guru.dashboard', ['start_tour' => 1]);
@endphp

<div class="mx-auto max-w-5xl space-y-7">

    {{-- Header --}}
    <section class="rounded-2xl border-2 border-base-300 bg-base-100 p-6 shadow-sm sm:p-7">
        <div class="flex flex-col gap-5 md:flex-row md:items-center md:justify-between">
            <div>
                <span class="badge badge-primary mb-2">Buku Panduan SiPANDU VIRTUAL</span>
                <h1 class="text-2xl font-extrabold text-base-content sm:text-3xl">
                    Panduan Penggunaan Aplikasi
                </h1>
                <p class="mt-2 text-base text-base-content/80">
                    Ikuti langkah sederhana di bawah ini, atau jalankan <strong>Tur Interaktif</strong> agar layar menuntun Anda langkah demi langkah.
                </p>
            </div>

            <a href="{{ $dashboardUrl }}" class="btn btn-primary btn-lg shrink-0">
                <span class="material-icons text-2xl">play_circle</span>
                Mulai Tur Interaktif
            </a>
        </div>
    </section>

    {{-- Panduan Khusus Sesuai Peran --}}
    <section class="rounded-2xl border-2 border-base-300 bg-base-100 p-6 shadow-sm space-y-5">
        <h2 class="text-xl font-extrabold text-base-content">
            @if($isSuperAdmin)
                Langkah Kerja Super Admin (Atasan Tertinggi &amp; Pengawas)
            @elseif($isPengawas)
                Langkah Kerja Pengawas PAI
            @else
                Langkah Kerja Guru PAI Binaan
            @endif
        </h2>

        <div class="space-y-4">
            @if($isSuperAdmin)
                <div class="flex items-start gap-4 rounded-xl border-2 border-base-300 bg-base-200 p-4">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-primary text-lg font-extrabold text-primary-content">1</span>
                    <div>
                        <h3 class="text-lg font-extrabold text-base-content">Setujui Akun Baru &amp; Atur Peran</h3>
                        <p class="mt-1 text-base text-base-content/85">
                            Buka menu <strong>Khusus Super Admin &rarr; Persetujuan Akun Baru</strong> untuk menyetujui pendaftar. Untuk mengangkat user menjadi Pengawas atau mengubah kata sandi user yang lupa, buka <strong>Akun &amp; Kata Sandi</strong>.
                        </p>
                    </div>
                </div>

                <div class="flex items-start gap-4 rounded-xl border-2 border-base-300 bg-base-200 p-4">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-primary text-lg font-extrabold text-primary-content">2</span>
                    <div>
                        <h3 class="text-lg font-extrabold text-base-content">Kelola Sekolah Binaan, Tahun Ajaran &amp; Jadwal Triwulan</h3>
                        <p class="mt-1 text-base text-base-content/85">
                            Tambahkan daftar <strong>Sekolah Binaan</strong> lengkap dengan <strong>Nama Kepala Sekolah</strong>, lalu buka periode <strong>Jadwal Triwulan</strong> agar guru bisa mulai mengunggah berkas.
                        </p>
                    </div>
                </div>

                <div class="flex items-start gap-4 rounded-xl border-2 border-base-300 bg-base-200 p-4">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-primary text-lg font-extrabold text-primary-content">3</span>
                    <div>
                        <h3 class="text-lg font-extrabold text-base-content">Pantau Laporan Seluruh Pengawas &amp; Guru</h3>
                        <p class="mt-1 text-base text-base-content/85">
                            Buka menu <strong>Laporan Semua Pengawas</strong> untuk melihat progres binaan Anda maupun pengawas lain (bisa disaring per nama pengawas), lalu unduh rekap Excel atau PDF.
                        </p>
                    </div>
                </div>
            @elseif($isPengawas)
                <div class="flex items-start gap-4 rounded-xl border-2 border-base-300 bg-base-200 p-4">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-primary text-lg font-extrabold text-primary-content">1</span>
                    <div>
                        <h3 class="text-lg font-extrabold text-base-content">Periksa Laporan Triwulan Guru Binaan</h3>
                        <p class="mt-1 text-base text-base-content/85">
                            Buka menu <strong>Periksa Laporan Guru</strong>. Pilih laporan bertanda <strong>Perlu Diperiksa</strong>, cek berkasnya, lalu tentukan status <strong>Sudah Lengkap</strong> atau <strong>Perlu Perbaikan</strong> beserta catatannya.
                        </p>
                    </div>
                </div>

                <div class="flex items-start gap-4 rounded-xl border-2 border-base-300 bg-base-200 p-4">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-primary text-lg font-extrabold text-primary-content">2</span>
                    <div>
                        <h3 class="text-lg font-extrabold text-base-content">Pantau Kelengkapan di Monitoring SIAGA</h3>
                        <p class="mt-1 text-base text-base-content/85">
                            Gunakan menu <strong>Monitoring SIAGA</strong> untuk melihat guru binaan Anda yang belum melengkapi dokumen agar bisa segera dibantu.
                        </p>
                    </div>
                </div>

                <div class="flex items-start gap-4 rounded-xl border-2 border-base-300 bg-base-200 p-4">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-primary text-lg font-extrabold text-primary-content">3</span>
                    <div>
                        <h3 class="text-lg font-extrabold text-base-content">Unduh Rekap Laporan &amp; Susun Berkas Bulanan</h3>
                        <p class="mt-1 text-base text-base-content/85">
                            Buka <strong>Laporan Triwulan Saya</strong> untuk mengunduh rekap Excel/PDF guru binaan Anda, atau buka <strong>Berkas Pembinaan (12 Bln)</strong> untuk laporan bulanan.
                        </p>
                    </div>
                </div>
            @else
                <div class="flex items-start gap-4 rounded-xl border-2 border-base-300 bg-base-200 p-4">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-primary text-lg font-extrabold text-primary-content">1</span>
                    <div>
                        <h3 class="text-lg font-extrabold text-base-content">Lengkapi Profil &amp; Pilih Pengawas</h3>
                        <p class="mt-1 text-base text-base-content/85">
                            Buka menu <strong>Profil &amp; Kata Sandi</strong>, isi nama lengkap, NIP/SIAGA, pilih sekolah tempat mengajar, serta pilih <strong>Pengawas Pembimbing</strong> Anda, lalu tekan <strong>Simpan Data Profil</strong>.
                        </p>
                    </div>
                </div>

                <div class="flex items-start gap-4 rounded-xl border-2 border-base-300 bg-base-200 p-4">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-primary text-lg font-extrabold text-primary-content">2</span>
                    <div>
                        <h3 class="text-lg font-extrabold text-base-content">Unggah Dokumen &amp; Kirim Laporan Triwulan</h3>
                        <p class="mt-1 text-base text-base-content/85">
                            Buka menu <strong>Laporan Triwulan Saya</strong>, pilih triwulan yang sedang dibuka, unggah dokumen wajib satu per satu, lalu tekan tombol <strong>Kirim Laporan</strong> agar diperiksa Pengawas.
                        </p>
                    </div>
                </div>

                <div class="flex items-start gap-4 rounded-xl border-2 border-base-300 bg-base-200 p-4">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-primary text-lg font-extrabold text-primary-content">3</span>
                    <div>
                        <h3 class="text-lg font-extrabold text-base-content">Periksa Catatan Revisi &amp; Gunakan Ruang Diskusi</h3>
                        <p class="mt-1 text-base text-base-content/85">
                            Jika ada status <strong>Perlu Perbaikan</strong>, baca catatan Pengawas lalu unggah ulang berkasnya. Jika bingung, silakan bertanya di menu <strong>Tanya Pengawas</strong> atau unduh contoh di <strong>Gudang Materi PAI</strong>.
                        </p>
                    </div>
                </div>
            @endif
        </div>
    </section>

    {{-- Tips Kenyamanan Layar & Install Aplikasi HP --}}
    <section class="grid grid-cols-1 gap-5 md:grid-cols-2">
        <div class="rounded-2xl border-2 border-base-300 bg-base-100 p-6 shadow-sm space-y-3">
            <div class="flex items-center gap-3">
                <span class="material-icons text-3xl text-secondary">text_fields</span>
                <h2 class="text-lg font-extrabold text-base-content">Memperbesar Huruf &amp; Kontras</h2>
            </div>
            <p class="text-base text-base-content/85">
                Jika tulisan terasa terlalu kecil, tekan tombol <strong>A+</strong> di bagian atas layar untuk memperbesar huruf, atau tekan ikon <strong>Kontras</strong> agar warna lebih tajam dan nyaman dibaca.
            </p>
        </div>

        <div class="rounded-2xl border-2 border-base-300 bg-base-100 p-6 shadow-sm space-y-3">
            <div class="flex items-center gap-3">
                <span class="material-icons text-3xl text-primary">install_mobile</span>
                <h2 class="text-lg font-extrabold text-base-content">Memasang SiPANDU di HP</h2>
            </div>
            <ul class="list-disc list-inside space-y-1.5 text-base text-base-content/85">
                <li><strong>HP Android (Chrome):</strong> Tekan tombol <strong>Pasang Sekarang</strong> di atas layar, atau tekan titik tiga (&vellip;) &rarr; <em>Tambahkan ke layar utama</em>.</li>
                <li><strong>iPhone (Safari):</strong> Tekan ikon <strong>Bagikan (Share)</strong> di bawah layar &rarr; pilih <em>Tambah ke Layar Utama</em>.</li>
            </ul>
        </div>
    </section>

</div>
@endsection
