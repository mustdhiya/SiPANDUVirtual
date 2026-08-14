@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-4">Dashboard Admin</h1>

    <div class="alert alert-info shadow-lg mb-6">
        <span class="material-icons align-middle mr-2">info</span>
        <span>Selamat datang, {{ auth()->user()->name }}! Ini adalah dashboard admin SiPANDU VIRTUAL.</span>
    </div>

    {{-- Grid Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        {{-- Tahun Ajaran --}}
        <div class="card bg-base-200 shadow-md">
            <div class="card-body">
                <h2 class="card-title">
                    <span class="material-icons align-middle text-primary">calendar_today</span>
                    Tahun Ajaran
                </h2>
                <p>Kelola tahun ajaran</p>
                <div class="card-actions justify-end">
                    <a href="{{ route('admin.tahun-ajaran.index') }}" class="btn btn-primary btn-sm">Kelola</a>
                </div>
            </div>
        </div>

        {{-- Triwulan --}}
        <div class="card bg-base-200 shadow-md">
            <div class="card-body">
                <h2 class="card-title">
                    <span class="material-icons align-middle text-primary">date_range</span>
                    Triwulan
                </h2>
                <p>Kelola periode triwulan</p>
                <div class="card-actions justify-end">
                    <a href="{{ route('admin.triwulan.index') }}" class="btn btn-primary btn-sm">Kelola</a>
                </div>
            </div>
        </div>

        {{-- Sekolah Binaan --}}
        <div class="card bg-base-200 shadow-md">
            <div class="card-body">
                <h2 class="card-title">
                    <span class="material-icons align-middle text-primary">school</span>
                    Sekolah Binaan
                </h2>
                <p>Kelola sekolah binaan</p>
                <div class="card-actions justify-end">
                    <a href="{{ route('admin.sekolah.index') }}" class="btn btn-primary btn-sm">Kelola</a>
                </div>
            </div>
        </div>

        {{-- Guru Binaan --}}
        <div class="card bg-base-200 shadow-md">
            <div class="card-body">
                <h2 class="card-title">
                    <span class="material-icons align-middle text-primary">people</span>
                    Guru Binaan
                </h2>
                <p>Kelola guru binaan</p>
                <div class="card-actions justify-end">
                    <a href="{{ route('admin.guru.index') }}" class="btn btn-primary btn-sm">Kelola</a>
                </div>
            </div>
        </div>

        {{-- Dokumen Wajib --}}
        <div class="card bg-base-200 shadow-md">
            <div class="card-body">
                <h2 class="card-title">
                    <span class="material-icons align-middle text-primary">description</span>
                    Dokumen Wajib
                </h2>
                <p>Konfigurasi dokumen wajib</p>
                <div class="card-actions justify-end">
                    <a href="{{ route('admin.dokumen.index') }}" class="btn btn-primary btn-sm">Kelola</a>
                </div>
            </div>
        </div>

        {{-- Approve Guru --}}
        <div class="card bg-base-200 shadow-md">
            <div class="card-body">
                <h2 class="card-title">
                    <span class="material-icons align-middle text-primary">person_add</span>
                    Approve Guru
                </h2>
                <p>Setujui registrasi guru</p>
                <div class="card-actions justify-end">
                    <a href="{{ route('admin.approve-guru.index') }}" class="btn btn-primary btn-sm">Kelola</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection