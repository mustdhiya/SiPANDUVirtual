@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
@php
    $pendingGuru = (int) ($totalPendingGuru ?? 0);
    $pendingReview = (int) ($totalSubmissionPending ?? 0);
    $totalSekolahAktif = (int) ($totalSekolah ?? 0);
    $totalGuruAktif = (int) ($totalGuru ?? 0);
    $needAttention = $pendingGuru + $pendingReview;
@endphp

<div class="mx-auto max-w-7xl space-y-8">

    {{-- Header --}}
    <section class="flex flex-col gap-5 border-b border-base-300 pb-6 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-[0.14em] text-secondary">
                <span class="material-icons text-base">verified_user</span>
                Panel Pengawas PAI
            </div>

            <h1 class="font-display mt-2 text-3xl font-semibold leading-tight text-base-content md:text-4xl">
                Selamat datang, {{ auth()->user()->name }}
            </h1>

            <p class="mt-2 max-w-2xl text-sm leading-6 text-base-content/70">
                {{ now()->translatedFormat('l, d F Y') }} — pantau pendampingan guru, proses review, dan kebutuhan tindak lanjut dari satu halaman.
            </p>
        </div>

        <div class="flex max-w-md items-start gap-3 rounded-2xl border border-base-300 bg-base-200 p-4 text-sm text-base-content/75">
            <span class="material-icons mt-0.5 text-secondary">tips_and_updates</span>
            <span>
                Gunakan menu prioritas untuk menyelesaikan pekerjaan yang memerlukan tindak lanjut hari ini.
            </span>
        </div>
    </section>

    {{-- Fokus Hari Ini --}}
    <section>
        <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.14em] text-secondary">
                    Fokus Hari Ini
                </p>

                <h2 class="font-display mt-1 text-2xl font-semibold text-base-content">
                    Pekerjaan yang Perlu Ditangani
                </h2>
            </div>

            @if($needAttention > 0)
                <span class="badge badge-warning badge-lg gap-2 self-start sm:self-auto">
                    <span class="material-icons text-base">priority_high</span>
                    {{ $needAttention }} item perlu perhatian
                </span>
            @else
                <span class="badge badge-success badge-lg gap-2 self-start sm:self-auto">
                    <span class="material-icons text-base">check_circle</span>
                    Tidak ada pekerjaan mendesak
                </span>
            @endif
        </div>

        <div class="grid gap-4 lg:grid-cols-2">

            {{-- Persetujuan Guru --}}
            <article class="card border border-base-300 bg-base-100 shadow-sm">
                <div class="card-body gap-5 p-5 sm:p-6">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-secondary/15 text-secondary">
                            <span class="material-icons">how_to_reg</span>
                        </div>

                        @if($pendingGuru > 0)
                            <span class="badge badge-secondary font-semibold">
                                {{ $pendingGuru }} menunggu
                            </span>
                        @else
                            <span class="badge badge-success gap-1">
                                <span class="material-icons text-sm">check_circle</span>
                                Selesai
                            </span>
                        @endif
                    </div>

                    <div>
                        <h3 class="font-display text-xl font-semibold text-base-content">
                            Persetujuan Guru
                        </h3>

                        <p class="mt-2 text-sm leading-6 text-base-content/70">
                            Periksa registrasi guru baru agar mereka dapat masuk dan menggunakan layanan pendampingan.
                        </p>
                    </div>

                    <div class="card-actions mt-1">
                        <a
                            href="{{ route('admin.approve-guru.index') }}"
                            class="btn btn-primary w-full rounded-xl sm:w-auto"
                        >
                            <span class="material-icons text-base">arrow_forward</span>

                            @if($pendingGuru > 0)
                                Tinjau {{ $pendingGuru }} Guru
                            @else
                                Buka Persetujuan
                            @endif
                        </a>
                    </div>
                </div>
            </article>

            {{-- Review Triwulan --}}
            <article class="card border border-base-300 bg-base-100 shadow-sm">
                <div class="card-body gap-5 p-5 sm:p-6">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-warning/20 text-warning">
                            <span class="material-icons">fact_check</span>
                        </div>

                        @if($pendingReview > 0)
                            <span class="badge badge-warning font-semibold">
                                {{ $pendingReview }} perlu review
                            </span>
                        @else
                            <span class="badge badge-success gap-1">
                                <span class="material-icons text-sm">check_circle</span>
                                Selesai
                            </span>
                        @endif
                    </div>

                    <div>
                        <h3 class="font-display text-xl font-semibold text-base-content">
                            Review Triwulan
                        </h3>

                        <p class="mt-2 text-sm leading-6 text-base-content/70">
                            Periksa submission dan dokumen guru, lalu berikan keputusan atau catatan revisi.
                        </p>
                    </div>

                    <div class="card-actions mt-1">
                        <a
                            href="{{ route('admin.review-triwulan.index') }}"
                            class="btn btn-primary w-full rounded-xl sm:w-auto"
                        >
                            <span class="material-icons text-base">assignment_turned_in</span>

                            @if($pendingReview > 0)
                                Review {{ $pendingReview }} Submission
                            @else
                                Buka Review
                            @endif
                        </a>
                    </div>
                </div>
            </article>
        </div>
    </section>

    {{-- Ringkasan Sistem --}}
    <section>
        <div class="mb-4">
            <p class="text-xs font-bold uppercase tracking-[0.14em] text-secondary">
                Ringkasan Sistem
            </p>

            <h2 class="font-display mt-1 text-2xl font-semibold text-base-content">
                Kondisi Pendampingan
            </h2>
        </div>

        <div class="grid grid-cols-2 gap-3 sm:gap-4 lg:grid-cols-4">

            <article class="rounded-2xl border border-base-300 bg-base-100 p-4 shadow-sm sm:p-5">
                <div class="flex items-center justify-between">
                    <span class="material-icons text-primary">school</span>
                    <span class="text-[11px] font-bold uppercase tracking-wide text-base-content/50">Aktif</span>
                </div>

                <p class="mt-5 text-sm text-base-content/70">Sekolah Binaan</p>

                <p class="font-display mt-1 text-3xl font-semibold text-primary">
                    {{ $totalSekolahAktif }}
                </p>
            </article>

            <article class="rounded-2xl border border-base-300 bg-base-100 p-4 shadow-sm sm:p-5">
                <div class="flex items-center justify-between">
                    <span class="material-icons text-primary">groups</span>
                    <span class="text-[11px] font-bold uppercase tracking-wide text-base-content/50">Aktif</span>
                </div>

                <p class="mt-5 text-sm text-base-content/70">Guru Binaan</p>

                <p class="font-display mt-1 text-3xl font-semibold text-primary">
                    {{ $totalGuruAktif }}
                </p>
            </article>

            <a
                href="{{ route('admin.approve-guru.index') }}"
                class="group rounded-2xl border border-base-300 bg-base-100 p-4 shadow-sm transition hover:-translate-y-0.5 hover:border-secondary hover:shadow-md sm:p-5"
            >
                <div class="flex items-center justify-between">
                    <span class="material-icons text-secondary">person_add</span>
                    <span class="material-icons text-sm text-base-content/45 transition group-hover:translate-x-1 group-hover:text-secondary">
                        arrow_forward
                    </span>
                </div>

                <p class="mt-5 text-sm text-base-content/70">Menunggu Approval</p>

                <p class="font-display mt-1 text-3xl font-semibold text-secondary">
                    {{ $pendingGuru }}
                </p>
            </a>

            <a
                href="{{ route('admin.review-triwulan.index') }}"
                class="group rounded-2xl border border-base-300 bg-base-100 p-4 shadow-sm transition hover:-translate-y-0.5 hover:border-warning hover:shadow-md sm:p-5"
            >
                <div class="flex items-center justify-between">
                    <span class="material-icons text-warning">pending_actions</span>
                    <span class="material-icons text-sm text-base-content/45 transition group-hover:translate-x-1 group-hover:text-warning">
                        arrow_forward
                    </span>
                </div>

                <p class="mt-5 text-sm text-base-content/70">Menunggu Review</p>

                <p class="font-display mt-1 text-3xl font-semibold text-warning">
                    {{ $pendingReview }}
                </p>
            </a>
        </div>
    </section>

    {{-- Menu Cepat --}}
    <section>
        <div class="mb-4 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.14em] text-secondary">
                    Menu Cepat
                </p>

                <h2 class="font-display mt-1 text-2xl font-semibold text-base-content">
                    Kelola SiPANDU
                </h2>
            </div>

            <p class="text-sm text-base-content/60">
                Pilih layanan sesuai pekerjaan yang ingin dilakukan.
            </p>
        </div>

        <div class="grid gap-3 sm:grid-cols-2 xl:grid-cols-3">

            {{-- Tahun Ajaran --}}
            <a href="{{ route('admin.tahun-ajaran.index') }}" class="group flex items-center gap-4 rounded-2xl border border-base-300 bg-base-100 p-4 shadow-sm transition hover:-translate-y-0.5 hover:border-primary hover:shadow-md">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-primary/15 text-primary">
                    <span class="material-icons">calendar_today</span>
                </div>

                <div class="min-w-0 flex-1">
                    <h3 class="font-semibold text-base-content">Tahun Ajaran</h3>
                    <p class="mt-1 text-sm leading-5 text-base-content/70">Atur tahun ajaran yang sedang aktif.</p>
                </div>

                <span class="material-icons text-base-content/45 transition group-hover:translate-x-1 group-hover:text-primary">chevron_right</span>
            </a>

            {{-- Triwulan --}}
            <a href="{{ route('admin.triwulan.index') }}" class="group flex items-center gap-4 rounded-2xl border border-base-300 bg-base-100 p-4 shadow-sm transition hover:-translate-y-0.5 hover:border-primary hover:shadow-md">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-primary/15 text-primary">
                    <span class="material-icons">date_range</span>
                </div>

                <div class="min-w-0 flex-1">
                    <h3 class="font-semibold text-base-content">Triwulan</h3>
                    <p class="mt-1 text-sm leading-5 text-base-content/70">Atur periode, tema, dan deadline dokumen.</p>
                </div>

                <span class="material-icons text-base-content/45 transition group-hover:translate-x-1 group-hover:text-primary">chevron_right</span>
            </a>

            {{-- Sekolah --}}
            <a href="{{ route('admin.sekolah.index') }}" class="group flex items-center gap-4 rounded-2xl border border-base-300 bg-base-100 p-4 shadow-sm transition hover:-translate-y-0.5 hover:border-primary hover:shadow-md">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-primary/15 text-primary">
                    <span class="material-icons">school</span>
                </div>

                <div class="min-w-0 flex-1">
                    <h3 class="font-semibold text-base-content">Sekolah Binaan</h3>
                    <p class="mt-1 text-sm leading-5 text-base-content/70">Kelola daftar sekolah SMA dan SMK binaan.</p>
                </div>

                <span class="material-icons text-base-content/45 transition group-hover:translate-x-1 group-hover:text-primary">chevron_right</span>
            </a>

            {{-- Guru --}}
            <a href="{{ route('admin.guru.index') }}" class="group flex items-center gap-4 rounded-2xl border border-base-300 bg-base-100 p-4 shadow-sm transition hover:-translate-y-0.5 hover:border-primary hover:shadow-md">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-primary/15 text-primary">
                    <span class="material-icons">groups</span>
                </div>

                <div class="min-w-0 flex-1">
                    <h3 class="font-semibold text-base-content">Guru Binaan</h3>
                    <p class="mt-1 text-sm leading-5 text-base-content/70">Kelola profil, sekolah, dan jabatan guru.</p>
                </div>

                <span class="material-icons text-base-content/45 transition group-hover:translate-x-1 group-hover:text-primary">chevron_right</span>
            </a>

            {{-- Dokumen --}}
            <a href="{{ route('admin.dokumen.index') }}" class="group flex items-center gap-4 rounded-2xl border border-base-300 bg-base-100 p-4 shadow-sm transition hover:-translate-y-0.5 hover:border-primary hover:shadow-md">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-primary/15 text-primary">
                    <span class="material-icons">description</span>
                </div>

                <div class="min-w-0 flex-1">
                    <h3 class="font-semibold text-base-content">Dokumen Wajib</h3>
                    <p class="mt-1 text-sm leading-5 text-base-content/70">Atur dokumen wajib yang diunggah pada setiap triwulan.</p>
                </div>

                <span class="material-icons text-base-content/45 transition group-hover:translate-x-1 group-hover:text-primary">chevron_right</span>
            </a>

            {{-- Monitoring --}}
            <a
                href="{{ route('admin.monitoring.index') }}"
                class="group relative overflow-hidden rounded-2xl border border-secondary/40 bg-base-100 p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-secondary hover:shadow-md"
                aria-label="Buka Monitoring SIAGA"
            >
                <span class="material-icons absolute -right-5 -top-5 text-8xl text-secondary/10">
                    analytics
                </span>

                <div class="relative flex items-start gap-4">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-secondary text-secondary-content shadow-sm">
                        <span class="material-icons">analytics</span>
                    </div>

                    <div class="min-w-0 flex-1">
                        <div class="flex flex-wrap items-center gap-2">
                            <h3 class="font-display text-lg font-semibold text-base-content">
                                Monitoring SIAGA
                            </h3>

                            <span class="badge badge-secondary badge-sm">
                                Prioritas
                            </span>
                        </div>

                        <p class="mt-1 text-sm leading-6 text-base-content/70">
                            Pantau progres, kelengkapan dokumen, dan guru yang perlu didampingi lebih dulu.
                        </p>

                        <div class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-secondary">
                            Buka Monitoring
                            <span class="material-icons text-base transition group-hover:translate-x-1">arrow_forward</span>
                        </div>
                    </div>
                </div>
            </a>

            {{-- Diskusi --}}
            <a href="{{ route('admin.diskusi.index') }}" class="group flex items-center gap-4 rounded-2xl border border-base-300 bg-base-100 p-4 shadow-sm transition hover:-translate-y-0.5 hover:border-primary hover:shadow-md">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-primary/15 text-primary">
                    <span class="material-icons">forum</span>
                </div>

                <div class="min-w-0 flex-1">
                    <h3 class="font-semibold text-base-content">Ruang Diskusi</h3>
                    <p class="mt-1 text-sm leading-5 text-base-content/70">Baca dan tanggapi pertanyaan dari guru.</p>
                </div>

                <span class="material-icons text-base-content/45 transition group-hover:translate-x-1 group-hover:text-primary">chevron_right</span>
            </a>

            {{-- Laporan --}}
            <a href="{{ route('admin.laporan.index') }}" class="group flex items-center gap-4 rounded-2xl border border-base-300 bg-base-100 p-4 shadow-sm transition hover:-translate-y-0.5 hover:border-primary hover:shadow-md">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-primary/15 text-primary">
                    <span class="material-icons">summarize</span>
                </div>

                <div class="min-w-0 flex-1">
                    <h3 class="font-semibold text-base-content">Laporan</h3>
                    <p class="mt-1 text-sm leading-5 text-base-content/70">Lihat rekap dan ekspor laporan Excel atau PDF.</p>
                </div>

                <span class="material-icons text-base-content/45 transition group-hover:translate-x-1 group-hover:text-primary">chevron_right</span>
            </a>

            {{-- Gudang --}}
            <a href="{{ route('admin.gudang.index') }}" class="group flex items-center gap-4 rounded-2xl border border-base-300 bg-base-100 p-4 shadow-sm transition hover:-translate-y-0.5 hover:border-primary hover:shadow-md">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-primary/15 text-primary">
                    <span class="material-icons">folder_open</span>
                </div>

                <div class="min-w-0 flex-1">
                    <h3 class="font-semibold text-base-content">Gudang PAI-BMTS</h3>
                    <p class="mt-1 text-sm leading-5 text-base-content/70">Kelola materi, instrumen riset, dan contoh perangkat.</p>
                </div>

                <span class="material-icons text-base-content/45 transition group-hover:translate-x-1 group-hover:text-primary">chevron_right</span>
            </a>
        </div>
    </section>

    {{-- Bantuan --}}
    <section class="rounded-2xl border border-base-300 bg-base-200 p-5">
        <div class="flex flex-col gap-4 text-sm text-base-content/75 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-start gap-3">
                <span class="material-icons text-secondary">support_agent</span>
                <div>
                    <p class="font-semibold text-base-content">Butuh bantuan teknis?</p>
                    <p class="mt-1">Hubungi tim developer jika ada masalah pada sistem atau data.</p>
                </div>
            </div>

            <a
                href="{{ route('admin.review-triwulan.index') }}"
                class="btn btn-outline btn-primary btn-sm rounded-xl"
            >
                <span class="material-icons text-base">fact_check</span>
                Buka Review Triwulan
            </a>
        </div>
    </section>
</div>
@endsection