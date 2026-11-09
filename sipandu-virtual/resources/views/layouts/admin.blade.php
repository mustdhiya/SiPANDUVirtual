@extends('layouts.base')

@section('navbar')
    @php
        $currentUser = auth()->user();
        $isSuperAdmin = $currentUser->isAdmin();
        $isProfileActive = request()->routeIs('profile.*');
    @endphp

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
                                {{ $isSuperAdmin ? 'Panel Admin Utama & Pengawas PAI' : 'Panel Pengawas PAI' }}
                            </p>
                        </div>

                        <span class="badge {{ $isSuperAdmin ? 'badge-secondary' : 'badge-primary' }} badge-sm ml-1 hidden font-semibold xs:inline-flex">
                            {{ $isSuperAdmin ? 'ADMIN UTAMA' : 'PENGAWAS' }}
                        </span>
                    </a>
                </div>

                {{-- Akun (Klik untuk ke Profil Wajib) dan Logout --}}
                <div class="flex flex-none items-center gap-2 sm:gap-3">
                    <a
                        href="{{ route('profile.edit') }}"
                        title="Pengaturan Profil Wajib"
                        class="hidden items-center gap-3 rounded-2xl border {{ $isProfileActive ? 'border-primary bg-primary/10' : 'border-base-300 bg-base-200 hover:bg-base-300/70' }} px-3 py-1.5 transition md:flex"
                    >
                        @if($currentUser->foto_profil)
                            <img
                                src="{{ asset('storage/' . $currentUser->foto_profil) }}"
                                alt="{{ $currentUser->name }}"
                                class="h-8 w-8 rounded-full object-cover ring-1 ring-primary"
                            />
                        @else
                            <div class="avatar placeholder">
                                <div class="w-8 rounded-full bg-primary text-primary-content">
                                    <span class="text-xs font-bold">
                                        {{ strtoupper(substr($currentUser->name, 0, 1)) }}
                                    </span>
                                </div>
                            </div>
                        @endif

                        <div class="max-w-44 leading-tight">
                            <p class="truncate text-sm font-semibold text-base-content">
                                {{ $currentUser->name }}
                            </p>

                            <p class="truncate text-xs text-base-content/60">
                                {{ $isSuperAdmin ? 'Admin Utama & Pengawas' : ($currentUser->jabatan_pengawas ?? 'Pengawas PAI') }}
                            </p>
                        </div>
                    </a>

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
        $currentUser = auth()->user();
        $isSuperAdmin = $currentUser->isAdmin();

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

        $isBerkasPembinaan = request()->routeIs('admin.berkas-pembinaan.*');
        $isLaporan = request()->routeIs('admin.laporan.*');
        $isGudang = request()->routeIs('admin.gudang.*');
        $isProfile = request()->routeIs('profile.*');

        // Hitung badge notifikasi cepat (aman dari error jika tabel belum dimigrasi)
        $pendingAccountCount = 0;
        $pendingSubmissionCount = 0;
        try {
            if ($isSuperAdmin) {
                $pendingAccountCount = \App\Models\User::where('is_approved', false)->count();
            }
            $pendingSubmissionCount = \App\Models\Submission::forUser($currentUser)
                ->where('status_review', 'submitted')
                ->count();
        } catch (\Throwable $e) {
            // Abaikan jika tabel belum siap
        }
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
                        {{ $isSuperAdmin ? 'Admin Utama & Pengawas' : 'Panel Pengawas PAI' }}
                    </p>
                </div>
            </a>
        </div>

        {{-- User mobile --}}
        <div class="border-b border-base-300 px-4 py-4 md:hidden">
            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 rounded-2xl bg-base-100 p-3 shadow-sm">
                @if($currentUser->foto_profil)
                    <img
                        src="{{ asset('storage/' . $currentUser->foto_profil) }}"
                        alt="{{ $currentUser->name }}"
                        class="h-10 w-10 rounded-full object-cover ring-1 ring-primary"
                    />
                @else
                    <div class="avatar placeholder">
                        <div class="w-10 rounded-full bg-primary text-primary-content">
                            <span class="font-semibold">
                                {{ strtoupper(substr($currentUser->name, 0, 1)) }}
                            </span>
                        </div>
                    </div>
                @endif

                <div class="min-w-0 flex-1">
                    <p class="truncate text-sm font-bold text-base-content">
                        {{ $currentUser->name }}
                    </p>

                    <p class="text-xs text-base-content/60">
                        {{ $isSuperAdmin ? 'Admin Utama & Pengawas' : 'Pengawas PAI' }}
                    </p>
                </div>

                <span class="material-icons text-base text-base-content/50">settings</span>
            </a>
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

                @if($isSuperAdmin)
                    {{-- Tahun Ajaran & Pembukaan Triwulan khusus dikelola terpusat oleh Mama (Admin Utama) --}}
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
                @endif

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

                @if($isSuperAdmin)
                    <li>
                        <a href="{{ route('admin.approve-guru.index') }}" class="rounded-xl {{ $isApproveGuru ? 'active font-bold' : '' }}">
                            <span class="material-icons">how_to_reg</span>
                            <span class="flex-1">Persetujuan &amp; Akun</span>
                            @if($pendingAccountCount > 0)
                                <span class="badge badge-error badge-sm font-bold text-white">{{ $pendingAccountCount }}</span>
                            @endif
                        </a>
                    </li>
                @endif

                <li>
                    <a href="{{ route('admin.review-triwulan.index') }}" class="rounded-xl {{ $isReviewTriwulan ? 'active font-bold' : '' }}">
                        <span class="material-icons">fact_check</span>
                        <span class="flex-1">Review Triwulan</span>
                        @if($pendingSubmissionCount > 0)
                            <span class="badge badge-info badge-sm font-bold">{{ $pendingSubmissionCount }}</span>
                        @endif
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
                        Laporan dan Pemberkasan
                    </span>
                </li>

                {{-- Menu Baru: Generator Berkas Pembinaan Profesi Guru PAI --}}
                <li>
                    <a
                        href="{{ route('admin.berkas-pembinaan.index') }}"
                        class="rounded-xl {{ $isBerkasPembinaan ? 'active font-bold' : '' }}"
                    >
                        <span class="material-icons">auto_stories</span>
                        <span class="flex-1">Generator Berkas</span>
                        <span class="badge badge-secondary badge-sm font-bold">12 BLN</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.laporan.index') }}" class="rounded-xl {{ $isLaporan ? 'active font-bold' : '' }}">
                        <span class="material-icons">summarize</span>
                        Laporan Triwulan
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.gudang.index') }}" class="rounded-xl {{ $isGudang ? 'active font-bold' : '' }}">
                        <span class="material-icons">folder_open</span>
                        Gudang PAI-BMTS
                    </a>
                </li>

                <li class="menu-title mt-4 px-3">
                    <span class="text-[11px] font-bold uppercase tracking-[0.14em] text-base-content/45">
                        Pengaturan Akun
                    </span>
                </li>

                <li>
                    <a href="{{ route('profile.edit') }}" class="rounded-xl {{ $isProfile ? 'active font-bold' : '' }}">
                        <span class="material-icons">manage_accounts</span>
                        Profil Wajib &amp; Sandi
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