@extends('layouts.guru')

@section('title', 'Dashboard')

@section('content')
@php
    $total = (int) ($totalTriwulan ?? 0);
    $submitted = (int) ($sudahSubmit ?? 0);
    $revisi = (int) ($perluRevisi ?? 0);
    $lengkapCount = (int) ($lengkap ?? 0);
    $progress = $total > 0 ? min(100, round((($submitted + $lengkapCount) / $total) * 100)) : 0;
@endphp

<div class="max-w-6xl mx-auto">
    <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between mb-6">
        <div>
            <div class="text-sm font-bold tracking-wide uppercase text-secondary">Dashboard Guru</div>
            <h1 class="font-display text-3xl font-semibold mt-1">Selamat datang, {{ auth()->user()->name }}</h1>
            <p class="text-neutral/60 mt-1">Pantau kelengkapan dokumen dan tindak lanjut triwulan Anda.</p>
        </div>
        <a href="{{ route('guru.triwulan.index') }}" class="btn btn-primary gap-2">
            <span class="material-icons">upload_file</span>
            Buka Triwulan
        </a>
    </div>

    <div class="card bg-base-200 border border-base-300 shadow-sm mb-6">
        <div class="card-body gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="font-display text-xl font-semibold">Progress Pendampingan</h2>
                <p class="text-sm text-neutral/60">{{ $total > 0 ? 'Selesaikan dokumen dan kirim submission sebelum deadline.' : 'Belum ada triwulan yang tersedia saat ini.' }}</p>
            </div>
            <div class="w-full md:w-80">
                <div class="flex justify-between text-sm font-semibold mb-2"><span>Progress</span><span>{{ $progress }}%</span></div>
                <progress class="progress progress-primary w-full" value="{{ $progress }}" max="100"></progress>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-7">
        <div class="stat bg-base-100 border border-base-300 rounded-2xl p-4">
            <div class="stat-figure text-primary"><span class="material-icons">date_range</span></div>
            <div class="stat-title">Total Triwulan</div><div class="stat-value text-primary text-2xl">{{ $total }}</div>
        </div>
        <div class="stat bg-base-100 border border-base-300 rounded-2xl p-4">
            <div class="stat-figure text-info"><span class="material-icons">send</span></div>
            <div class="stat-title">Sudah Submit</div><div class="stat-value text-info text-2xl">{{ $submitted }}</div>
        </div>
        <div class="stat bg-base-100 border border-base-300 rounded-2xl p-4">
            <div class="stat-figure text-warning"><span class="material-icons">edit_note</span></div>
            <div class="stat-title">Perlu Revisi</div><div class="stat-value text-warning text-2xl">{{ $revisi }}</div>
        </div>
        <div class="stat bg-base-100 border border-base-300 rounded-2xl p-4">
            <div class="stat-figure text-success"><span class="material-icons">verified</span></div>
            <div class="stat-title">Lengkap</div><div class="stat-value text-success text-2xl">{{ $lengkapCount }}</div>
        </div>
    </div>

    @if($revisi > 0)
        <div class="alert alert-warning mb-6">
            <span class="material-icons">priority_high</span>
            <div><strong>Ada {{ $revisi }} submission yang perlu revisi.</strong><br><span class="text-sm">Buka menu Triwulan untuk melihat catatan dari pengawas dan memperbaiki dokumen.</span></div>
            <a href="{{ route('guru.triwulan.index') }}" class="btn btn-sm btn-warning">Lihat Revisi</a>
        </div>
    @endif

    <div class="mb-3">
        <h2 class="font-display text-2xl font-semibold">Akses Cepat</h2>
        <p class="text-neutral/60 text-sm">Pilih layanan yang ingin Anda buka.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <a href="{{ route('guru.triwulan.index') }}" class="card bg-base-100 border border-base-300 hover:shadow-lg hover:-translate-y-0.5 transition-all">
            <div class="card-body">
                <div class="w-12 h-12 rounded-xl bg-base-200 flex items-center justify-center"><span class="material-icons text-primary">upload_file</span></div>
                <h3 class="card-title font-display mt-2">Triwulan Saya</h3>
                <p class="text-sm text-neutral/60">Isi instrumen, unggah dokumen, dan kirim submission.</p>
                <div class="card-actions justify-end mt-2"><span class="btn btn-sm btn-primary">Buka <span class="material-icons text-base">arrow_forward</span></span></div>
            </div>
        </a>
        <a href="{{ route('guru.diskusi.index') }}" class="card bg-base-100 border border-base-300 hover:shadow-lg hover:-translate-y-0.5 transition-all">
            <div class="card-body">
                <div class="w-12 h-12 rounded-xl bg-base-200 flex items-center justify-center"><span class="material-icons text-primary">forum</span></div>
                <h3 class="card-title font-display mt-2">Ruang Diskusi</h3>
                <p class="text-sm text-neutral/60">Ajukan pertanyaan dan baca tanggapan dari pengawas.</p>
                <div class="card-actions justify-end mt-2"><span class="btn btn-sm btn-primary">Buka <span class="material-icons text-base">arrow_forward</span></span></div>
            </div>
        </a>
        <a href="{{ route('guru.gudang.index') }}" class="card bg-base-100 border border-base-300 hover:shadow-lg hover:-translate-y-0.5 transition-all">
            <div class="card-body">
                <div class="w-12 h-12 rounded-xl bg-base-200 flex items-center justify-center"><span class="material-icons text-primary">folder</span></div>
                <h3 class="card-title font-display mt-2">Gudang PAI-BMTS</h3>
                <p class="text-sm text-neutral/60">Unduh materi, instrumen, dan contoh perangkat dari pengawas.</p>
                <div class="card-actions justify-end mt-2"><span class="btn btn-sm btn-primary">Buka <span class="material-icons text-base">arrow_forward</span></span></div>
            </div>
        </a>
    </div>
</div>
@endsection