@extends('layouts.guru')

@section('title', 'Dashboard')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-4">Dashboard Guru</h1>

    <div class="alert alert-info shadow-lg mb-6">
        <span class="material-icons align-middle mr-2">info</span>
        <span>Selamat datang, {{ auth()->user()->name }}! Pantau progress triwulan Anda di sini.</span>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="stat bg-base-200 rounded p-3">
            <div class="stat-title">Total Triwulan</div>
            <div class="stat-value text-primary">{{ $totalTriwulan ?? 0 }}</div>
        </div>
        <div class="stat bg-base-200 rounded p-3">
            <div class="stat-title">Sudah Submit</div>
            <div class="stat-value text-success">{{ $sudahSubmit ?? 0 }}</div>
        </div>
        <div class="stat bg-base-200 rounded p-3">
            <div class="stat-title">Perlu Revisi</div>
            <div class="stat-value text-warning">{{ $perluRevisi ?? 0 }}</div>
        </div>
        <div class="stat bg-base-200 rounded p-3">
            <div class="stat-title">Lengkap</div>
            <div class="stat-value text-info">{{ $lengkap ?? 0 }}</div>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <div class="card bg-base-200 shadow-md">
            <div class="card-body">
                <h2 class="card-title">
                    <span class="material-icons align-middle text-primary">date_range</span>
                    Triwulan
                </h2>
                <p>Isi instrumen & upload dokumen</p>
                <div class="card-actions justify-end">
                    <a href="{{ route('guru.triwulan.index') }}" class="btn btn-primary btn-sm">Buka</a>
                </div>
            </div>
        </div>

        <div class="card bg-base-200 shadow-md">
            <div class="card-body">
                <h2 class="card-title">
                    <span class="material-icons align-middle text-primary">forum</span>
                    Diskusi
                </h2>
                <p>Bertanya di ruang diskusi</p>
                <div class="card-actions justify-end">
                    <a href="{{ route('guru.diskusi.index') }}" class="btn btn-primary btn-sm">Buka</a>
                </div>
            </div>
        </div>

        <div class="card bg-base-200 shadow-md">
            <div class="card-body">
                <h2 class="card-title">
                    <span class="material-icons align-middle text-primary">description</span>
                    Dokumen Saya
                </h2>
                <p>Lihat semua dokumen yang diupload</p>
                <div class="card-actions justify-end">
                    <a href="#" class="btn btn-primary btn-sm">Buka</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection