@extends('layouts.admin')

@section('title', 'Beranda')

@section('content')
@php
    $currentUser = auth()->user();
    $isSuperAdmin = $currentUser->isAdmin();

    $pendingGuru = (int) ($totalPendingGuru ?? 0);
    $pendingReview = (int) ($totalSubmissionPending ?? 0);
    $totalSekolahAktif = (int) ($totalSekolah ?? 0);
    $totalGuruAktif = (int) ($totalGuru ?? 0);
    $needAttention = $isSuperAdmin ? ($pendingGuru + $pendingReview) : $pendingReview;
@endphp

<div class="mx-auto max-w-6xl space-y-8">

    {{-- Sapaan Utama --}}
    <section data-tour="welcome-card" class="rounded-2xl border-2 border-base-300 bg-base-100 p-6 shadow-sm sm:p-7">
        <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <span class="inline-flex items-center gap-1.5 rounded-lg px-3 py-1 text-xs font-extrabold uppercase tracking-wider {{ $isSuperAdmin ? 'bg-secondary text-secondary-content' : 'bg-primary text-primary-content' }}">
                    <span class="material-icons text-base">verified_user</span>
                    {{ $isSuperAdmin ? 'Super Admin & Pengawas PAI' : 'Pengawas PAI' }}
                </span>

                <h1 class="mt-3 text-2xl font-extrabold leading-snug text-base-content sm:text-3xl">
                    Assalamu'alaikum, {{ $currentUser->name }}
                </h1>

                <p class="mt-2 text-base text-base-content/80">
                    {{ now()->translatedFormat('l, d F Y') }} &mdash;
                    @if($isSuperAdmin)
                        Anda dapat memantau seluruh akun pengguna, memeriksa laporan guru binaan, serta melihat rekap dari seluruh pengawas.
                    @else
                        Pantau guru binaan Anda, periksa laporan triwulan yang masuk, dan unduh rekap laporan.
                    @endif
                </p>
            </div>

            <div class="shrink-0">
                @if($needAttention > 0)
                    <div class="flex items-center gap-3 rounded-2xl border-2 border-warning bg-warning/10 px-5 py-4">
                        <span class="material-icons text-3xl text-warning">notifications_active</span>
                        <div>
                            <p class="text-lg font-extrabold text-warning">{{ $needAttention }} Tugas Menunggu</p>
                            <p class="text-sm font-medium text-base-content">Perlu diperiksa hari ini</p>
                        </div>
                    </div>
                @else
                    <div class="flex items-center gap-3 rounded-2xl border-2 border-success bg-success/10 px-5 py-4">
                        <span class="material-icons text-3xl text-success">check_circle</span>
                        <div>
                            <p class="text-lg font-extrabold text-success">Semua Terkendali</p>
                            <p class="text-sm font-medium text-base-content">Tidak ada antrean mendesak</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    {{-- Ringkasan Angka (Jelas & Besar) --}}
    <section data-tour="stats-section" aria-label="Ringkasan data">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 {{ $isSuperAdmin ? 'lg:grid-cols-4' : 'lg:grid-cols-3' }}">
            <div class="rounded-2xl border-2 border-base-300 bg-base-100 p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="text-sm font-bold text-base-content/80">Guru Binaan Aktif</span>
                    <span class="material-icons text-3xl text-primary">groups</span>
                </div>
                <p class="mt-3 text-4xl font-extrabold text-primary">{{ $totalGuruAktif }}</p>
                <p class="mt-1 text-xs font-medium text-base-content/75">Guru terdaftar &amp; disetujui</p>
            </div>

            <div class="rounded-2xl border-2 border-base-300 bg-base-100 p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="text-sm font-bold text-base-content/80">Sekolah Binaan</span>
                    <span class="material-icons text-3xl text-primary">school</span>
                </div>
                <p class="mt-3 text-4xl font-extrabold text-primary">{{ $totalSekolahAktif }}</p>
                <p class="mt-1 text-xs font-medium text-base-content/75">SMA / SMK aktif</p>
            </div>

            <a href="{{ route('admin.review-triwulan.index') }}" class="rounded-2xl border-2 {{ $pendingReview > 0 ? 'border-info bg-info/5' : 'border-base-300 bg-base-100' }} p-5 shadow-sm transition hover:border-primary hover:shadow-md">
                <div class="flex items-center justify-between">
                    <span class="text-sm font-bold text-base-content/80">Laporan Perlu Diperiksa</span>
                    <span class="material-icons text-3xl text-info">fact_check</span>
                </div>
                <p class="mt-3 text-4xl font-extrabold text-info">{{ $pendingReview }}</p>
                <p class="mt-1 text-xs font-bold text-info">Klik untuk memeriksa &rarr;</p>
            </a>

            @if($isSuperAdmin)
                <a href="{{ route('admin.approve-guru.index') }}" class="rounded-2xl border-2 {{ $pendingGuru > 0 ? 'border-warning bg-warning/5' : 'border-base-300 bg-base-100' }} p-5 shadow-sm transition hover:border-primary hover:shadow-md">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-bold text-base-content/80">Akun Menunggu Izin</span>
                        <span class="material-icons text-3xl text-warning">how_to_reg</span>
                    </div>
                    <p class="mt-3 text-4xl font-extrabold text-warning">{{ $pendingGuru }}</p>
                    <p class="mt-1 text-xs font-bold text-warning">Klik untuk menyetujui &rarr;</p>
                </a>
            @endif
        </div>
    </section>

    {{-- Menu Tindakan Utama (Kartu Besar & Mudah Ditekan) --}}
    <section data-tour="primary-actions">
        <div class="mb-4">
            <h2 class="text-xl font-extrabold text-base-content sm:text-2xl">
                Pilih Pekerjaan Utama
            </h2>
            <p class="mt-1 text-base text-base-content/80">
                Tekan salah satu tombol di bawah untuk langsung memulai.
            </p>
        </div>

        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

            {{-- 1. Periksa Laporan Triwulan Guru --}}
            <article class="flex flex-col justify-between rounded-2xl border-2 border-base-300 bg-base-100 p-6 shadow-sm">
                <div>
                    <div class="flex items-center justify-between gap-3">
                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-info/15 text-info">
                            <span class="material-icons text-3xl">fact_check</span>
                        </div>
                        @if($pendingReview > 0)
                            <span class="badge badge-info badge-lg">{{ $pendingReview }} Perlu Diperiksa</span>
                        @else
                            <span class="badge badge-success badge-lg">Sudah Diperiksa</span>
                        @endif
                    </div>

                    <h3 class="mt-4 text-xl font-extrabold text-base-content">
                        Periksa Laporan Triwulan Guru
                    </h3>
                    <p class="mt-2 text-base text-base-content/80">
                        Buka berkas yang dikirim guru binaan, lalu tentukan status <strong>Lengkap</strong> atau <strong>Perlu Perbaikan</strong>.
                    </p>
                </div>

                <div class="mt-6">
                    <a href="{{ route('admin.review-triwulan.index') }}" class="btn btn-primary btn-lg w-full">
                        <span class="material-icons text-2xl">assignment_turned_in</span>
                        {{ $pendingReview > 0 ? "Periksa {$pendingReview} Laporan Sekarang" : 'Buka Daftar Laporan Guru' }}
                    </a>
                </div>
            </article>

            {{-- 2. Rekap Laporan (Super Admin: Semua Pengawas | Pengawas: Binaan Sendiri) --}}
            <article class="flex flex-col justify-between rounded-2xl border-2 border-base-300 bg-base-100 p-6 shadow-sm">
                <div>
                    <div class="flex items-center justify-between gap-3">
                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-primary/15 text-primary">
                            <span class="material-icons text-3xl">summarize</span>
                        </div>
                        <span class="badge badge-primary badge-lg">
                            {{ $isSuperAdmin ? 'Semua Pengawas' : 'Binaan Saya' }}
                        </span>
                    </div>

                    <h3 class="mt-4 text-xl font-extrabold text-base-content">
                        {{ $isSuperAdmin ? 'Laporan Seluruh Pengawas' : 'Rekap Laporan Triwulan' }}
                    </h3>
                    <p class="mt-2 text-base text-base-content/80">
                        @if($isSuperAdmin)
                            Lihat rekap pelaporan dari pengawas lain maupun binaan Anda sendiri, serta unduh file Excel / PDF.
                        @else
                            Lihat rekap kelengkapan seluruh guru binaan Anda per triwulan dan unduh file Excel / PDF.
                        @endif
                    </p>
                </div>

                <div class="mt-6">
                    <a href="{{ route('admin.laporan.index') }}" class="btn btn-primary btn-lg w-full">
                        <span class="material-icons text-2xl">visibility</span>
                        Buka Rekap Laporan
                    </a>
                </div>
            </article>

            @if($isSuperAdmin)
                {{-- 3. Khusus Super Admin: Persetujuan Akun Baru --}}
                <article class="flex flex-col justify-between rounded-2xl border-2 border-base-300 bg-base-100 p-6 shadow-sm">
                    <div>
                        <div class="flex items-center justify-between gap-3">
                            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-warning/15 text-warning">
                                <span class="material-icons text-3xl">how_to_reg</span>
                            </div>
                            @if($pendingGuru > 0)
                                <span class="badge badge-warning badge-lg">{{ $pendingGuru }} Menunggu</span>
                            @else
                                <span class="badge badge-success badge-lg">Tidak Ada Antrean</span>
                            @endif
                        </div>

                        <h3 class="mt-4 text-xl font-extrabold text-base-content">
                            Persetujuan Akun Baru
                        </h3>
                        <p class="mt-2 text-base text-base-content/80">
                            Setujui pendaftaran guru baru atau atur peran akun menjadi Pengawas PAI.
                        </p>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('admin.approve-guru.index') }}" class="btn btn-secondary btn-lg w-full">
                            <span class="material-icons text-2xl">verified_user</span>
                            {{ $pendingGuru > 0 ? "Setujui {$pendingGuru} Akun Baru" : 'Buka Persetujuan Akun' }}
                        </a>
                    </div>
                </article>

                {{-- 4. Khusus Super Admin: Lihat Username & Kata Sandi --}}
                <article class="flex flex-col justify-between rounded-2xl border-2 border-secondary/50 bg-base-100 p-6 shadow-sm">
                    <div>
                        <div class="flex items-center justify-between gap-3">
                            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-secondary/15 text-secondary">
                                <span class="material-icons text-3xl">key</span>
                            </div>
                            <span class="badge badge-secondary badge-lg">Khusus Super Admin</span>
                        </div>

                        <h3 class="mt-4 text-xl font-extrabold text-base-content">
                            Daftar Akun &amp; Kata Sandi
                        </h3>
                        <p class="mt-2 text-base text-base-content/80">
                            Lihat email (username) dan kata sandi seluruh pengguna jika ada pengawas atau guru yang lupa akunnya.
                        </p>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline btn-secondary btn-lg border-2 w-full">
                            <span class="material-icons text-2xl">manage_search</span>
                            Lihat Daftar Akun &amp; Sandi
                        </a>
                    </div>
                </article>
            @else
                {{-- 3. Untuk Pengawas: Monitoring SIAGA --}}
                <article class="flex flex-col justify-between rounded-2xl border-2 border-base-300 bg-base-100 p-6 shadow-sm">
                    <div>
                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-secondary/15 text-secondary">
                            <span class="material-icons text-3xl">analytics</span>
                        </div>

                        <h3 class="mt-4 text-xl font-extrabold text-base-content">
                            Monitoring SIAGA
                        </h3>
                        <p class="mt-2 text-base text-base-content/80">
                            Lihat guru binaan mana saja yang belum melengkapi dokumen agar bisa segera didampingi.
                        </p>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('admin.monitoring.index') }}" class="btn btn-secondary btn-lg w-full">
                            <span class="material-icons text-2xl">analytics</span>
                            Buka Monitoring SIAGA
                        </a>
                    </div>
                </article>

                {{-- 4. Untuk Pengawas: Berkas Pembinaan Bulanan --}}
                <article class="flex flex-col justify-between rounded-2xl border-2 border-base-300 bg-base-100 p-6 shadow-sm">
                    <div>
                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-primary/15 text-primary">
                            <span class="material-icons text-3xl">auto_stories</span>
                        </div>

                        <h3 class="mt-4 text-xl font-extrabold text-base-content">
                            Berkas Pembinaan (12 Bulan)
                        </h3>
                        <p class="mt-2 text-base text-base-content/80">
                            Susun dan cetak berkas pembinaan profesi guru PAI bulanan dari Januari hingga Desember.
                        </p>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('admin.berkas-pembinaan.index') }}" class="btn btn-outline btn-primary btn-lg border-2 w-full">
                            <span class="material-icons text-2xl">auto_stories</span>
                            Buka Berkas Pembinaan
                        </a>
                    </div>
                </article>
            @endif
        </div>
    </section>

    {{-- Pintasan Lainnya (Ringkas & Rapi) --}}
    <section class="rounded-2xl border-2 border-base-300 bg-base-100 p-6 shadow-sm">
        <h2 class="text-lg font-extrabold text-base-content">Layanan Lainnya</h2>
        <div class="mt-4 grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-3">
            <a href="{{ route('admin.guru.index') }}" class="btn btn-outline border-2 border-base-300 justify-start hover:border-primary hover:bg-base-200 hover:text-base-content">
                <span class="material-icons text-primary">groups</span>
                Daftar Guru Binaan
            </a>
            <a href="{{ route('admin.diskusi.index') }}" class="btn btn-outline border-2 border-base-300 justify-start hover:border-primary hover:bg-base-200 hover:text-base-content">
                <span class="material-icons text-primary">forum</span>
                Ruang Diskusi Guru
            </a>
            <a href="{{ route('admin.gudang.index') }}" class="btn btn-outline border-2 border-base-300 justify-start hover:border-primary hover:bg-base-200 hover:text-base-content">
                <span class="material-icons text-primary">folder_open</span>
                Gudang Materi PAI
            </a>
            @if($isSuperAdmin)
                <a href="{{ route('admin.monitoring.index') }}" class="btn btn-outline border-2 border-base-300 justify-start hover:border-primary hover:bg-base-200 hover:text-base-content">
                    <span class="material-icons text-secondary">analytics</span>
                    Monitoring SIAGA
                </a>
                <a href="{{ route('admin.berkas-pembinaan.index') }}" class="btn btn-outline border-2 border-base-300 justify-start hover:border-primary hover:bg-base-200 hover:text-base-content">
                    <span class="material-icons text-secondary">auto_stories</span>
                    Berkas Pembinaan (12 Bln)
                </a>
                <a href="{{ route('admin.triwulan.index') }}" class="btn btn-outline border-2 border-base-300 justify-start hover:border-primary hover:bg-base-200 hover:text-base-content">
                    <span class="material-icons text-secondary">date_range</span>
                    Atur Jadwal Triwulan
                </a>
            @endif
        </div>
    </section>

</div>
@endsection
