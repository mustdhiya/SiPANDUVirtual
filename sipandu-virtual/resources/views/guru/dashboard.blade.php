@extends('layouts.guru')

@section('title', 'Beranda Guru')

@section('content')
@php
    $total = (int) ($totalTriwulan ?? 0);
    $submitted = (int) ($sudahSubmit ?? 0);
    $revisi = (int) ($perluRevisi ?? 0);
    $lengkapCount = (int) ($lengkap ?? 0);
    $progress = $total > 0 ? min(100, round((($submitted + $lengkapCount) / $total) * 100)) : 0;
@endphp

<div class="mx-auto max-w-5xl space-y-7">

    {{-- Sapaan & Tombol Utama --}}
    <section data-tour="welcome-card" class="rounded-2xl border-2 border-base-300 bg-base-100 p-6 shadow-sm sm:p-7">
        <div class="flex flex-col gap-5 md:flex-row md:items-center md:justify-between">
            <div>
                <span class="badge badge-primary mb-2">Panel Guru PAI Binaan</span>
                <h1 class="text-2xl font-extrabold leading-snug text-base-content sm:text-3xl">
                    Assalamu'alaikum, {{ auth()->user()->name }}
                </h1>
                <p class="mt-2 text-base text-base-content/80">
                    Kirim laporan dokumen per triwulan sesuai jadwal, lalu pantau hasil pemeriksaan dari Pengawas PAI di sini.
                </p>
            </div>

            <a href="{{ route('guru.triwulan.index') }}" class="btn btn-primary btn-lg shrink-0">
                <span class="material-icons text-2xl">upload_file</span>
                Buka Laporan Triwulan
            </a>
        </div>
    </section>

    {{-- Peringatan Penting jika Ada Revisi --}}
    @if($revisi > 0)
        <section class="rounded-2xl border-2 border-warning bg-warning/10 p-5 shadow-sm">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex items-start gap-3">
                    <span class="material-icons text-3xl text-warning">priority_high</span>
                    <div>
                        <h2 class="text-lg font-extrabold text-warning">
                            Ada {{ $revisi }} Laporan yang Perlu Diperbaiki
                        </h2>
                        <p class="mt-1 text-base text-base-content">
                            Silakan buka menu Laporan Triwulan untuk membaca catatan dari Pengawas dan mengganti berkas yang kurang.
                        </p>
                    </div>
                </div>
                <a href="{{ route('guru.triwulan.index') }}" class="btn btn-warning btn-lg shrink-0">
                    Perbaiki Sekarang
                </a>
            </div>
        </section>
    @endif

    {{-- Progres Pelaporan --}}
    <section data-tour="stats-section" class="rounded-2xl border-2 border-base-300 bg-base-100 p-6 shadow-sm">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-xl font-extrabold text-base-content">Perkembangan Laporan Anda</h2>
                <p class="mt-1 text-base text-base-content/80">
                    {{ $total > 0 ? 'Pastikan semua dokumen wajib diunggah sebelum batas waktu berakhir.' : 'Belum ada jadwal triwulan yang dibuka saat ini.' }}
                </p>
            </div>
            <div class="w-full md:w-80">
                <div class="mb-2 flex justify-between text-base font-bold text-base-content">
                    <span>Selesai</span>
                    <span class="text-primary">{{ $progress }}%</span>
                </div>
                <progress class="progress progress-primary h-4 w-full" value="{{ $progress }}" max="100"></progress>
            </div>
        </div>

        <div class="mt-6 grid grid-cols-2 gap-4 lg:grid-cols-4">
            <div class="rounded-xl border-2 border-base-300 bg-base-200 p-4">
                <p class="text-sm font-bold text-base-content/80">Total Triwulan</p>
                <p class="mt-1 text-3xl font-extrabold text-primary">{{ $total }}</p>
            </div>
            <div class="rounded-xl border-2 border-base-300 bg-base-200 p-4">
                <p class="text-sm font-bold text-base-content/80">Sudah Dikirim</p>
                <p class="mt-1 text-3xl font-extrabold text-info">{{ $submitted }}</p>
            </div>
            <div class="rounded-xl border-2 border-base-300 bg-base-200 p-4">
                <p class="text-sm font-bold text-base-content/80">Perlu Perbaikan</p>
                <p class="mt-1 text-3xl font-extrabold text-warning">{{ $revisi }}</p>
            </div>
            <div class="rounded-xl border-2 border-base-300 bg-base-200 p-4">
                <p class="text-sm font-bold text-base-content/80">Sudah Lengkap</p>
                <p class="mt-1 text-3xl font-extrabold text-success">{{ $lengkapCount }}</p>
            </div>
        </div>
    </section>

    {{-- 3 Menu Utama Guru (Besar & Mudah Dipahami) --}}
    <section data-tour="primary-actions">
        <h2 class="mb-4 text-xl font-extrabold text-base-content sm:text-2xl">
            Pilih Layanan yang Diperlukan
        </h2>

        <div class="grid grid-cols-1 gap-5 md:grid-cols-3">
            <a href="{{ route('guru.triwulan.index') }}" class="flex flex-col justify-between rounded-2xl border-2 border-base-300 bg-base-100 p-6 shadow-sm transition hover:border-primary hover:shadow-md">
                <div>
                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-primary/15 text-primary">
                        <span class="material-icons text-3xl">upload_file</span>
                    </div>
                    <h3 class="mt-4 text-xl font-extrabold text-base-content">1. Laporan Triwulan</h3>
                    <p class="mt-2 text-base text-base-content/80">
                        Unggah berkas dokumen wajib dan kirim laporan setiap triwulan ke Pengawas.
                    </p>
                </div>
                <div class="mt-5">
                    <span class="btn btn-primary w-full">
                        Buka Laporan
                        <span class="material-icons text-xl">arrow_forward</span>
                    </span>
                </div>
            </a>

            <a href="{{ route('guru.diskusi.index') }}" class="flex flex-col justify-between rounded-2xl border-2 border-base-300 bg-base-100 p-6 shadow-sm transition hover:border-primary hover:shadow-md">
                <div>
                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-info/15 text-info">
                        <span class="material-icons text-3xl">forum</span>
                    </div>
                    <h3 class="mt-4 text-xl font-extrabold text-base-content">2. Tanya Pengawas</h3>
                    <p class="mt-2 text-base text-base-content/80">
                        Kirim pertanyaan jika ada kendala dan baca jawaban langsung dari Pengawas PAI.
                    </p>
                </div>
                <div class="mt-5">
                    <span class="btn btn-outline btn-primary border-2 w-full">
                        Buka Diskusi
                        <span class="material-icons text-xl">arrow_forward</span>
                    </span>
                </div>
            </a>

            <a href="{{ route('guru.gudang.index') }}" class="flex flex-col justify-between rounded-2xl border-2 border-base-300 bg-base-100 p-6 shadow-sm transition hover:border-primary hover:shadow-md">
                <div>
                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-secondary/15 text-secondary">
                        <span class="material-icons text-3xl">folder_open</span>
                    </div>
                    <h3 class="mt-4 text-xl font-extrabold text-base-content">3. Gudang Materi</h3>
                    <p class="mt-2 text-base text-base-content/80">
                        Unduh contoh perangkat pembelajaran, format dokumen, dan materi pembinaan.
                    </p>
                </div>
                <div class="mt-5">
                    <span class="btn btn-outline btn-primary border-2 w-full">
                        Buka Gudang
                        <span class="material-icons text-xl">arrow_forward</span>
                    </span>
                </div>
            </a>
        </div>
    </section>

</div>
@endsection
