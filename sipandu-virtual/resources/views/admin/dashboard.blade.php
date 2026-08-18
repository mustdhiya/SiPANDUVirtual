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

<div class="space-y-8">

    {{-- Page title --}}
    <section class="flex flex-col gap-3 border-b border-base-300 pb-5 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.14em] text-secondary">
                Panel Pengawas PAI
            </p>

            <h1 class="font-display mt-1 text-3xl font-semibold leading-tight text-neutral">
                Selamat datang, {{ auth()->user()->name }}
            </h1>

            <p class="mt-2 text-sm leading-6 text-neutral/60">
                {{ now()->translatedFormat('l, d F Y') }} — pantau dan tindak lanjuti pendampingan guru dari satu halaman.
            </p>
        </div>

        <div class="flex items-center gap-2 self-start rounded-2xl border border-base-300 bg-base-200 px-4 py-3 text-sm text-neutral/70 sm:self-auto">
            <span class="material-icons text-secondary">info</span>
            <span>Gunakan menu prioritas untuk pekerjaan hari ini.</span>
        </div>
    </section>

    {{-- Prioritas kerja --}}
    <section>
        <div class="mb-4 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.14em] text-secondary">
                    Fokus Hari Ini
                </p>
                <h2 class="font-display mt-1 text-2xl font-semibold text-neutral">
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
            <article class="card border border-base-300 bg-base-100 shadow-sm">
                <div class="card-body gap-4 p-5 sm:p-6">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-secondary/15 text-secondary">
                            <span class="material-icons">how_to_reg</span>
                        </div>

                        @if($pendingGuru > 0)
                            <span class="badge badge-secondary font-semibold">
                                {{ $pendingGuru }} menunggu
                            </span>
                        @else
                            <span class="badge badge-success">Selesai</span>
                        @endif
                    </div>

                    <div>
                        <h3 class="font-display text-xl font-semibold text-neutral">
                            Persetujuan Guru
                        </h3>

                        <p class="mt-1 text-sm leading-6 text-neutral/65">
                            Periksa akun guru baru agar mereka dapat mengakses fitur pendampingan.
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

            <article class="card border border-base-300 bg-base-100 shadow-sm">
                <div class="card-body gap-4 p-5 sm:p-6">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-warning/20 text-warning">
                            <span class="material-icons">fact_check</span>
                        </div>

                        @if($pendingReview > 0)
                            <span class="badge badge-warning font-semibold">
                                {{ $pendingReview }} perlu review
                            </span>
                        @else
                            <span class="badge badge-success">Selesai</span>
                        @endif
                    </div>

                    <div>
                        <h3 class="font-display text-xl font-semibold text-neutral">
                            Review Triwulan
                        </h3>

                        <p class="mt-1 text-sm leading-6 text-neutral/65">
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

    {{-- Ringkasan data --}}
    <section>
        <div class="mb-4">
            <p class="text-xs font-bold uppercase tracking-[0.14em] text-secondary">
                Ringkasan Sistem
            </p>

            <h2 class="font-display mt-1 text-2xl font-semibold text-neutral">
                Kondisi Pendampingan
            </h2>
        </div>

        <div class="grid grid-cols-2 gap-3 sm:gap-4 lg:grid-cols-4">
            <article class="rounded-2xl border border-base-300 bg-base-100 p-4 shadow-sm sm:p-5">
                <div class="flex items-center justify-between">
                    <span class="material-icons text-primary">school</span>
                    <span class="text-[11px] font-bold uppercase tracking-wide text-neutral/45">Aktif</span>
                </div>

                <p class="mt-5 text-sm text-neutral/60">Sekolah Binaan</p>

                <p class="font-display mt-1 text-3xl font-semibold text-primary">
                    {{ $totalSekolahAktif }}
                </p>
            </article>

            <article class="rounded-2xl border border-base-300 bg-base-100 p-4 shadow-sm sm:p-5">
                <div class="flex items-center justify-between">
                    <span class="material-icons text-primary">groups</span>
                    <span class="text-[11px] font-bold uppercase tracking-wide text-neutral/45">Aktif</span>
                </div>

                <p class="mt-5 text-sm text-neutral/60">Guru Binaan</p>

                <p class="font-display mt-1 text-3xl font-semibold text-primary">
                    {{ $totalGuruAktif }}
                </p>
            </article>

            <a
                href="{{ route('admin.approve-guru.index') }}"
                class="group rounded-2xl border border-base-300 bg-base-100 p-4 shadow-sm transition hover:border-secondary/50 hover:shadow-md sm:p-5"
            >
                <div class="flex items-center justify-between">
                    <span class="material-icons text-secondary">person_add</span>
                    <span class="material-icons text-sm text-neutral/35 transition group-hover:translate-x-1 group-hover:text-secondary">
                        arrow_forward
                    </span>
                </div>

                <p class="mt-5 text-sm text-neutral/60">Menunggu Approval</p>

                <p class="font-display mt-1 text-3xl font-semibold text-secondary">
                    {{ $pendingGuru }}
                </p>
            </a>

            <a
                href="{{ route('admin.review-triwulan.index') }}"
                class="group rounded-2xl border border-base-300 bg-base-100 p-4 shadow-sm transition hover:border-warning/60 hover:shadow-md sm:p-5"
            >
                <div class="flex items-center justify-between">
                    <span class="material-icons text-warning">pending_actions</span>
                    <span class="material-icons text-sm text-neutral/35 transition group-hover:translate-x-1 group-hover:text-warning">
                        arrow_forward
                    </span>
                </div>

                <p class="mt-5 text-sm text-neutral/60">Menunggu Review</p>

                <p class="font-display mt-1 text-3xl font-semibold text-warning">
                    {{ $pendingReview }}
                </p>
            </a>
        </div>
    </section>

    {{-- Navigasi kerja --}}
    <section>
        <div class="mb-4 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.14em] text-secondary">
                    Menu Cepat
                </p>

                <h2 class="font-display mt-1 text-2xl font-semibold text-neutral">
                    Kelola SiPANDU
                </h2>
            </div>

            <p class="text-sm text-neutral/55">
                Pilih sesuai pekerjaan yang ingin dilakukan.
            </p>
        </div>

        <div class="grid gap-3 sm:grid-cols-2 xl:grid-cols-3">

            <a href="{{ route('admin.tahun-ajaran.index') }}" class="group flex items-center gap-4 rounded-2xl border border-base-300 bg-base-100 p-4 shadow-sm transition hover:border-primary/40 hover:shadow-md">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-primary/10 text-primary">
                    <span class="material-icons">calendar_today</span>
                </div>
                <div class="min-w-0 flex-1">
                    <h3 class="font-semibold">Tahun Ajaran</h3>
                    <p class="truncate text-sm text-neutral/60">Atur tahun ajaran aktif</p>
                </div>
                <span class="material-icons text-neutral/35 transition group-hover:translate-x-1 group-hover:text-primary">chevron_right</span>
            </a>

            <a href="{{ route('admin.triwulan.index') }}" class="group flex items-center gap-4 rounded-2xl border border-base-300 bg-base-100 p-4 shadow-sm transition hover:border-primary/40 hover:shadow-md">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-primary/10 text-primary">
                    <span class="material-icons">date_range</span>
                </div>
                <div class="min-w-0 flex-1">
                    <h3 class="font-semibold">Triwulan</h3>
                    <p class="truncate text-sm text-neutral/60">Atur periode dan deadline</p>
                </div>
                <span class="material-icons text-neutral/35 transition group-hover:translate-x-1 group-hover:text-primary">chevron_right</span>
            </a>

            <a href="{{ route('admin.sekolah.index') }}" class="group flex items-center gap-4 rounded-2xl border border-base-300 bg-base-100 p-4 shadow-sm transition hover:border-primary/40 hover:shadow-md">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-primary/10 text-primary">
                    <span class="material-icons">school</span>
                </div>
                <div class="min-w-0 flex-1">
                    <h3 class="font-semibold">Sekolah Binaan</h3>
                    <p class="truncate text-sm text-neutral/60">Kelola sekolah terdaftar</p>
                </div>
                <span class="material-icons text-neutral/35 transition group-hover:translate-x-1 group-hover:text-primary">chevron_right</span>
            </a>

            <a href="{{ route('admin.guru.index') }}" class="group flex items-center gap-4 rounded-2xl border border-base-300 bg-base-100 p-4 shadow-sm transition hover:border-primary/40 hover:shadow-md">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-primary/10 text-primary">
                    <span class="material-icons">groups</span>
                </div>
                <div class="min-w-0 flex-1">
                    <h3 class="font-semibold">Guru Binaan</h3>
                    <p class="truncate text-sm text-neutral/60">Kelola profil dan jabatan guru</p>
                </div>
                <span class="material-icons text-neutral/35 transition group-hover:translate-x-1 group-hover:text-primary">chevron_right</span>
            </a>

            <a href="{{ route('admin.dokumen.index') }}" class="group flex items-center gap-4 rounded-2xl border border-base-300 bg-base-100 p-4 shadow-sm transition hover:border-primary/40 hover:shadow-md">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-primary/10 text-primary">
                    <span class="material-icons">description</span>
                </div>
                <div class="min-w-0 flex-1">
                    <h3 class="font-semibold">Dokumen Wajib</h3>
                    <p class="truncate text-sm text-neutral/60">Atur persyaratan tiap triwulan</p>
                </div>
                <span class="material-icons text-neutral/35 transition group-hover:translate-x-1 group-hover:text-primary">chevron_right</span>
            </a>

            <a href="{{ route('admin.monitoring.index') }}" class="group flex items-center gap-4 rounded-2xl border border-base-300 bg-base-100 p-4 shadow-sm transition hover:border-primary/40 hover:shadow-md">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-primary/10 text-primary">
                    <span class="material-icons">monitoring</span>
                </div>
                <div class="min-w-0 flex-1">
                    <h3 class="font-semibold">Monitoring SIAGA</h3>
                    <p class="truncate text-sm text-neutral/60">Pantau progres dan prioritas guru</p>
                </div>
                <span class="material-icons text-neutral/35 transition group-hover:translate-x-1 group-hover:text-primary">chevron_right</span>
            </a>

            <a href="{{ route('admin.diskusi.index') }}" class="group flex items-center gap-4 rounded-2xl border border-base-300 bg-base-100 p-4 shadow-sm transition hover:border-primary/40 hover:shadow-md">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-primary/10 text-primary">
                    <span class="material-icons">forum</span>
                </div>
                <div class="min-w-0 flex-1">
                    <h3 class="font-semibold">Ruang Diskusi</h3>
                    <p class="truncate text-sm text-neutral/60">Tanggapi pertanyaan dari guru</p>
                </div>
                <span class="material-icons text-neutral/35 transition group-hover:translate-x-1 group-hover:text-primary">chevron_right</span>
            </a>

            <a href="{{ route('admin.laporan.index') }}" class="group flex items-center gap-4 rounded-2xl border border-base-300 bg-base-100 p-4 shadow-sm transition hover:border-primary/40 hover:shadow-md">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-primary/10 text-primary">
                    <span class="material-icons">summarize</span>
                </div>
                <div class="min-w-0 flex-1">
                    <h3 class="font-semibold">Laporan</h3>
                    <p class="truncate text-sm text-neutral/60">Lihat rekap dan export laporan</p>
                </div>
                <span class="material-icons text-neutral/35 transition group-hover:translate-x-1 group-hover:text-primary">chevron_right</span>
            </a>

            <a href="{{ route('admin.gudang.index') }}" class="group flex items-center gap-4 rounded-2xl border border-base-300 bg-base-100 p-4 shadow-sm transition hover:border-primary/40 hover:shadow-md">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-primary/10 text-primary">
                    <span class="material-icons">folder_open</span>
                </div>
                <div class="min-w-0 flex-1">
                    <h3 class="font-semibold">Gudang PAI-BMTS</h3>
                    <p class="truncate text-sm text-neutral/60">Kelola materi dan instrumen riset</p>
                </div>
                <span class="material-icons text-neutral/35 transition group-hover:translate-x-1 group-hover:text-primary">chevron_right</span>
            </a>
        </div>
    </section>

    <section class="rounded-2xl border border-base-300 bg-base-200/75 px-5 py-4">
        <div class="flex flex-col gap-3 text-sm text-neutral/65 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-2">
                <span class="material-icons text-secondary">support_agent</span>
                <span>Butuh bantuan? Hubungi tim developer untuk bantuan teknis.</span>
            </div>

            <a
                href="{{ route('admin.review-triwulan.index') }}"
                class="font-semibold text-primary hover:underline"
            >
                Buka Review Triwulan
            </a>
        </div>
    </section>
</div>
@endsection