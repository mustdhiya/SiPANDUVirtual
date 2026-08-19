@extends('layouts.base')

@section('navbar')
    <header class="sticky top-0 z-30 border-b border-base-300 bg-base-100/95 backdrop-blur">
        <div class="page-shell">
            <div class="navbar min-h-16 px-4 sm:px-6 lg:px-8">

                {{-- Tombol menu mobile --}}
                <div class="flex-none lg:hidden">
                    <label
                        for="app-drawer"
                        class="btn btn-square btn-ghost rounded-xl"
                        aria-label="Buka menu utama"
                    >
                        <span class="material-icons">menu</span>
                    </label>
                </div>

                {{-- Brand Header --}}
                <div class="min-w-0 flex-1">
                    <a
                        href="{{ route('admin.dashboard') }}"
                        class="flex items-center gap-3 rounded-xl outline-none focus-visible:ring-2 focus-visible:ring-primary"
                        aria-label="Kembali ke dashboard admin"
                    >
                        <div class="sipandu-logo-header hidden shrink-0 sm:block">
                            <img
                                src="{{ asset('images/logo.png') }}"
                                alt="Logo SiPANDU VIRTUAL"
                                class="sipandu-logo-image"
                            >
                        </div>

                        <div class="min-w-0">
                            <p class="font-display truncate text-lg font-semibold leading-tight text-primary">
                                SiPANDU VIRTUAL
                            </p>

                            <p class="hidden text-xs text-base-content/60 sm:block">
                                Panel Pengawas PAI
                            </p>
                        </div>

                        <span class="badge badge-secondary badge-sm ml-1 hidden font-semibold xs:inline-flex">
                            ADMIN
                        </span>
                    </a>
                </div>

                {{-- Akun dan Logout --}}
                <div class="flex flex-none items-center gap-2 sm:gap-3">
                    <div class="hidden items-center gap-3 rounded-2xl border border-base-300 bg-base-200 px-3 py-2 md:flex">
                        <div class="avatar placeholder">
                            <div class="w-8 rounded-full bg-primary text-primary-content">
                                <span class="text-xs font-bold">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </span>
                            </div>
                        </div>

                        <div class="max-w-40 leading-tight">
                            <p class="truncate text-sm font-semibold text-base-content">
                                {{ auth()->user()->name }}
                            </p>

                            <p class="text-xs text-base-content/60">
                                Pengawas PAI
                            </p>
                        </div>
                    </div>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf

                        <button
                            type="submit"
                            class="btn btn-sm btn-ghost rounded-xl text-error hover:bg-error/15 hover:text-error"
                            title="Keluar dari sistem"
                            aria-label="Keluar dari sistem"
                        >
                            <span class="material-icons">logout</span>
                            <span class="hidden sm:inline">Keluar</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>
@endsection

@section('sidebar')
    @php
        $isDashboard = request()->routeIs('admin.dashboard');

        $isTahunAjaran = request()->routeIs('admin.tahun-ajaran.*');
        $isTriwulan = request()->routeIs('admin.triwulan.*');
        $isSekolah = request()->routeIs('admin.sekolah.*');
        $isGuru = request()->routeIs('admin.guru.*');
        $isDokumen = request()->routeIs('admin.dokumen.*');

        $isApproveGuru = request()->routeIs('admin.approve-guru.*');
        $isReviewTriwulan = request()->routeIs('admin.review-triwulan.*');
        $isDiskusi = request()->routeIs('admin.diskusi.*');
        $isMonitoring = request()->routeIs('admin.monitoring.*');

        $isLaporan = request()->routeIs('admin.laporan.*');
        $isGudang = request()->routeIs('admin.gudang.*');
    @endphp

    <aside class="flex min-h-full w-72 flex-col border-r border-base-300 bg-base-200">

        {{-- Logo Sidebar --}}
        <div class="border-b border-base-300 px-5 py-5">
            <a
                href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-3 rounded-2xl outline-none focus-visible:ring-2 focus-visible:ring-primary"
                aria-label="Kembali ke dashboard admin"
            >
                <div class="sipandu-logo-sidebar shrink-0">
                    <img
                        src="{{ asset('images/logo.png') }}"
                        alt="Logo SiPANDU VIRTUAL"
                        class="sipandu-logo-image"
                    >
                </div>

                <div class="min-w-0">
                    <p class="font-display text-lg font-semibold leading-tight text-primary">
                        SiPANDU
                    </p>

                    <p class="truncate text-xs font-medium tracking-wide text-base-content/60">
                        Panel Pengawas PAI
                    </p>
                </div>
            </a>
        </div>

        {{-- User mobile --}}
        <div class="border-b border-base-300 px-4 py-4 md:hidden">
            <div class="flex items-center gap-3 rounded-2xl bg-base-100 p-3">
                <div class="avatar placeholder">
                    <div class="w-10 rounded-full bg-primary text-primary-content">
                        <span class="font-semibold">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </span>
                    </div>
                </div>

                <div class="min-w-0">
                    <p class="truncate text-sm font-bold text-base-content">
                        {{ auth()->user()->name }}
                    </p>

                    <p class="text-xs text-base-content/60">
                        Pengawas PAI
                    </p>
                </div>
            </div>
        </div>

        {{-- Navigasi --}}
        <nav aria-label="Menu admin" class="flex-1 overflow-y-auto px-3 py-4">
            <ul class="menu gap-1 p-0 text-[15px]">

                <li>
                    <a
                        href="{{ route('admin.dashboard') }}"
                        class="rounded-xl {{ $isDashboard ? 'active font-bold' : '' }}"
                    >
                        <span class="material-icons">dashboard</span>
                        Dashboard
                    </a>
                </li>

                <li class="menu-title mt-4 px-3">
                    <span class="text-[11px] font-bold uppercase tracking-[0.14em] text-base-content/45">
                        Data Utama
                    </span>
                </li>

                <li>
                    <a href="{{ route('admin.tahun-ajaran.index') }}" class="rounded-xl {{ $isTahunAjaran ? 'active font-bold' : '' }}">
                        <span class="material-icons">calendar_today</span>
                        Tahun Ajaran
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.triwulan.index') }}" class="rounded-xl {{ $isTriwulan ? 'active font-bold' : '' }}">
                        <span class="material-icons">date_range</span>
                        Triwulan
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.sekolah.index') }}" class="rounded-xl {{ $isSekolah ? 'active font-bold' : '' }}">
                        <span class="material-icons">school</span>
                        Sekolah Binaan
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.guru.index') }}" class="rounded-xl {{ $isGuru ? 'active font-bold' : '' }}">
                        <span class="material-icons">groups</span>
                        Guru Binaan
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.dokumen.index') }}" class="rounded-xl {{ $isDokumen ? 'active font-bold' : '' }}">
                        <span class="material-icons">description</span>
                        Dokumen Wajib
                    </a>
                </li>

                <li class="menu-title mt-4 px-3">
                    <span class="text-[11px] font-bold uppercase tracking-[0.14em] text-base-content/45">
                        Pendampingan
                    </span>
                </li>

                <li>
                    <a href="{{ route('admin.approve-guru.index') }}" class="rounded-xl {{ $isApproveGuru ? 'active font-bold' : '' }}">
                        <span class="material-icons">how_to_reg</span>
                        Persetujuan Guru
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.review-triwulan.index') }}" class="rounded-xl {{ $isReviewTriwulan ? 'active font-bold' : '' }}">
                        <span class="material-icons">fact_check</span>
                        Review Triwulan
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.diskusi.index') }}" class="rounded-xl {{ $isDiskusi ? 'active font-bold' : '' }}">
                        <span class="material-icons">forum</span>
                        Ruang Diskusi
                    </a>
                </li>

                <li>
                    <a
                        href="{{ route('admin.monitoring.index') }}"
                        class="rounded-xl {{ $isMonitoring ? 'active font-bold' : '' }}"
                    >
                        <span class="material-icons">analytics</span>
                        <span class="flex-1">Monitoring SIAGA</span>
                        <span class="badge badge-warning badge-sm font-bold">SIAGA</span>
                    </a>
                </li>

                <li class="menu-title mt-4 px-3">
                    <span class="text-[11px] font-bold uppercase tracking-[0.14em] text-base-content/45">
                        Laporan dan Arsip
                    </span>
                </li>

                <li>
                    <a href="{{ route('admin.laporan.index') }}" class="rounded-xl {{ $isLaporan ? 'active font-bold' : '' }}">
                        <span class="material-icons">summarize</span>
                        Laporan
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.gudang.index') }}" class="rounded-xl {{ $isGudang ? 'active font-bold' : '' }}">
                        <span class="material-icons">folder_open</span>
                        Gudang PAI-BMTS
                    </a>
                </li>
            </ul>
        </nav>

        {{-- Bantuan --}}
        <div class="border-t border-base-300 p-4">
            <div class="rounded-2xl border border-base-300 bg-base-100 p-3">
                <div class="flex items-center gap-2 text-xs text-base-content/60">
                    <span class="material-icons text-base text-secondary">support_agent</span>
                    Butuh bantuan teknis?
                </div>

                <p class="mt-1 text-xs font-semibold text-primary">
                    Hubungi tim developer
                </p>
            </div>

            <p class="mt-3 text-center text-[11px] text-base-content/45">
                SiPANDU VIRTUAL &copy; {{ date('Y') }}
            </p>
        </div>
    </aside>
@endsection