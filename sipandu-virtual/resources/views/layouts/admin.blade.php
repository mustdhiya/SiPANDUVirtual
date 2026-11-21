@extends('layouts.base')

@section('navbar')
    @php
        $currentUser = auth()->user();
        $isSuperAdmin = $currentUser->isAdmin();
        $isProfileActive = request()->routeIs('profile.*');
    @endphp

    <header class="sticky top-0 z-30 border-b-2 border-base-300 bg-base-100 shadow-sm">
        <div class="page-shell">
            <div class="flex min-h-[4.5rem] items-center justify-between gap-3 px-4 py-2 sm:px-6 lg:px-8">

                {{-- Kiri: Logo Mobile + Judul Halaman (di mobile navigasi pakai Bottom Bar) --}}
                <div class="flex min-w-0 items-center gap-3">
                    <div class="sipandu-logo-header shrink-0 lg:hidden">
                        <img
                            src="{{ asset('images/logo.png') }}"
                            alt="Logo SiPANDU VIRTUAL"
                            class="sipandu-logo-image"
                        >
                    </div>

                    <div class="min-w-0">
                        <p class="truncate text-lg font-bold leading-tight text-primary lg:hidden">
                            SiPANDU VIRTUAL
                        </p>
                        <p class="hidden truncate text-lg font-bold leading-tight text-base-content lg:block">
                            @yield('title', 'Beranda')
                        </p>
                        <p class="hidden text-xs font-medium text-base-content/75 sm:block">
                            {{ $isSuperAdmin ? 'Mode Super Admin & Pengawas PAI' : 'Mode Pengawas PAI' }}
                        </p>
                    </div>
                </div>

                {{-- Kanan: Pengaturan Huruf (Ramah Lansia) + Profil + Keluar --}}
                <div class="flex shrink-0 items-center gap-2 sm:gap-3">

                    {{-- Tombol Mulai Tur Halaman Ini (Berlaku di SEMUA Halaman) --}}
                    <button
                        type="button"
                        onclick="window.triggerPageTour && window.triggerPageTour()"
                        data-tour="tour-btn"
                        class="btn btn-secondary btn-sm sm:btn-md font-bold"
                        title="Mulai tur interaktif di halaman ini"
                    >
                        <span class="material-icons text-xl">play_circle</span>
                        <span class="hidden sm:inline">Tur</span>
                    </button>

                    {{-- Tombol Panduan Penggunaan --}}
                    <a
                        href="{{ route('panduan.index') }}"
                        data-tour="panduan-btn"
                        class="btn btn-outline btn-primary btn-sm sm:btn-md border-2 font-bold {{ request()->routeIs('panduan.*') ? 'btn-active' : '' }}"
                        title="Buka Buku Panduan Penggunaan"
                    >
                        <span class="material-icons text-xl">help_outline</span>
                        <span class="hidden md:inline">Panduan</span>
                    </a>

                    {{-- Kontrol Ukuran Huruf & Kontras --}}
                    <div data-tour="font-controls" class="hidden items-center gap-1 rounded-xl border-2 border-base-300 bg-base-200 px-1.5 py-1 md:flex" role="group" aria-label="Pengaturan tampilan huruf">
                        <button
                            type="button"
                            onclick="window.sipanduUI.stepSize(-1)"
                            class="btn btn-ghost btn-sm min-h-0 h-9 px-2.5 text-sm font-bold"
                            title="Perkecil huruf"
                            aria-label="Perkecil ukuran huruf"
                        >
                            A-
                        </button>
                        <span class="px-1 text-xs font-bold text-base-content" data-font-label>Nyaman</span>
                        <button
                            type="button"
                            onclick="window.sipanduUI.stepSize(1)"
                            class="btn btn-ghost btn-sm min-h-0 h-9 px-2.5 text-base font-extrabold"
                            title="Perbesar huruf"
                            aria-label="Perbesar ukuran huruf"
                        >
                            A+
                        </button>
                        <button
                            type="button"
                            data-contrast-btn
                            onclick="window.sipanduUI.toggleContrast()"
                            class="btn btn-ghost btn-sm min-h-0 h-9 px-2"
                            title="Aktifkan mode kontras tinggi"
                            aria-label="Ubah kontras tampilan"
                        >
                            <span class="material-icons text-lg">contrast</span>
                        </button>
                    </div>

                    {{-- Profil --}}
                    <a
                        href="{{ route('profile.edit') }}"
                        title="Buka Profil & Kata Sandi"
                        class="hidden items-center gap-2.5 rounded-xl border-2 {{ $isProfileActive ? 'border-primary bg-primary/10' : 'border-base-300 bg-base-100 hover:border-primary' }} px-3 py-1.5 transition xl:flex"
                    >
                        @if($currentUser->foto_profil)
                            <img
                                src="{{ asset('storage/' . $currentUser->foto_profil) }}"
                                alt="{{ $currentUser->name }}"
                                class="h-9 w-9 rounded-full object-cover ring-2 ring-primary"
                            />
                        @else
                            <div class="flex h-9 w-9 items-center justify-center rounded-full bg-primary text-sm font-bold text-primary-content">
                                {{ strtoupper(substr($currentUser->name, 0, 1)) }}
                            </div>
                        @endif

                        <div class="max-w-44 leading-tight">
                            <p class="truncate text-sm font-bold text-base-content">
                                {{ $currentUser->name }}
                            </p>
                            <p class="truncate text-xs font-medium text-base-content/75">
                                {{ $isSuperAdmin ? 'Super Admin' : 'Pengawas PAI' }}
                            </p>
                        </div>
                    </a>

                    {{-- Keluar --}}
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button
                            type="submit"
                            class="btn btn-outline btn-error btn-sm sm:btn-md border-2 font-bold"
                            title="Keluar dari aplikasi"
                            aria-label="Keluar dari aplikasi"
                        >
                            <span class="material-icons text-xl">logout</span>
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
        $isUsers = request()->routeIs('admin.users.*');
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

    <aside class="flex min-h-full w-80 flex-col border-r-2 border-base-300 bg-base-100">

        {{-- Brand & Identitas Peran --}}
        <div class="border-b-2 border-base-300 bg-base-200 px-5 py-5">
            <a
                href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-3.5 rounded-xl outline-none"
                aria-label="Kembali ke beranda"
            >
                <div class="sipandu-logo-sidebar shrink-0">
                    <img
                        src="{{ asset('images/logo.png') }}"
                        alt="Logo SiPANDU VIRTUAL"
                        class="sipandu-logo-image"
                    >
                </div>

                <div class="min-w-0">
                    <p class="text-xl font-extrabold leading-tight text-primary">
                        SiPANDU
                    </p>
                    <span class="mt-1 inline-flex items-center rounded-lg px-2.5 py-0.5 text-xs font-bold {{ $isSuperAdmin ? 'bg-secondary text-secondary-content' : 'bg-primary text-primary-content' }}">
                        {{ $isSuperAdmin ? 'SUPER ADMIN & PENGAWAS' : 'PENGAWAS PAI' }}
                    </span>
                </div>
            </a>

            {{-- Kontrol Huruf khusus Mobile --}}
            <div class="mt-4 flex items-center justify-between rounded-xl border border-base-300 bg-base-100 px-3 py-2 md:hidden">
                <span class="text-xs font-bold text-base-content">Ukuran Huruf:</span>
                <div class="flex items-center gap-1">
                    <button type="button" onclick="window.sipanduUI.stepSize(-1)" class="btn btn-ghost btn-sm min-h-0 h-8 px-2 font-bold">A-</button>
                    <button type="button" onclick="window.sipanduUI.stepSize(1)" class="btn btn-ghost btn-sm min-h-0 h-8 px-2 font-extrabold">A+</button>
                    <button type="button" data-contrast-btn onclick="window.sipanduUI.toggleContrast()" class="btn btn-ghost btn-sm min-h-0 h-8 px-2" title="Kontras">
                        <span class="material-icons text-base">contrast</span>
                    </button>
                </div>
            </div>
        </div>

        {{-- Menu Navigasi --}}
        <nav data-tour="sidebar-nav" aria-label="Menu utama" class="flex-1 overflow-y-auto px-3 py-4">
            <ul class="menu gap-1.5 p-0">

                {{-- BERANDA --}}
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="{{ $isDashboard ? 'active' : '' }}">
                        <span class="material-icons text-2xl">home</span>
                        <span>Beranda</span>
                    </a>
                </li>

                {{-- TUGAS HARIAN --}}
                <li class="menu-title mt-4 px-3 pb-1">
                    <span class="text-xs font-extrabold uppercase tracking-wider text-secondary">
                        Tugas Utama
                    </span>
                </li>

                <li>
                    <a href="{{ route('admin.review-triwulan.index') }}" class="{{ $isReviewTriwulan ? 'active' : '' }}">
                        <span class="material-icons text-2xl">fact_check</span>
                        <span class="flex-1">Periksa Laporan Guru</span>
                        @if($pendingSubmissionCount > 0)
                            <span class="badge badge-info">{{ $pendingSubmissionCount }}</span>
                        @endif
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.monitoring.index') }}" class="{{ $isMonitoring ? 'active' : '' }}">
                        <span class="material-icons text-2xl">analytics</span>
                        <span>Monitoring SIAGA</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.diskusi.index') }}" class="{{ $isDiskusi ? 'active' : '' }}">
                        <span class="material-icons text-2xl">forum</span>
                        <span>Ruang Diskusi</span>
                    </a>
                </li>

                {{-- LAPORAN & BERKAS --}}
                <li class="menu-title mt-4 px-3 pb-1">
                    <span class="text-xs font-extrabold uppercase tracking-wider text-secondary">
                        Laporan &amp; Berkas
                    </span>
                </li>

                <li>
                    <a href="{{ route('admin.laporan.index') }}" class="{{ $isLaporan ? 'active' : '' }}">
                        <span class="material-icons text-2xl">summarize</span>
                        <span>{{ $isSuperAdmin ? 'Laporan Semua Pengawas' : 'Laporan Triwulan Saya' }}</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.berkas-pembinaan.index') }}" class="{{ $isBerkasPembinaan ? 'active' : '' }}">
                        <span class="material-icons text-2xl">auto_stories</span>
                        <span>Berkas Pembinaan (12 Bln)</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.gudang.index') }}" class="{{ $isGudang ? 'active' : '' }}">
                        <span class="material-icons text-2xl">folder_open</span>
                        <span>Gudang Materi PAI</span>
                    </a>
                </li>

                {{-- DATA & AKUN --}}
                <li class="menu-title mt-4 px-3 pb-1">
                    <span class="text-xs font-extrabold uppercase tracking-wider text-secondary">
                        Data Binaan
                    </span>
                </li>

                <li>
                    <a href="{{ route('admin.guru.index') }}" class="{{ $isGuru ? 'active' : '' }}">
                        <span class="material-icons text-2xl">groups</span>
                        <span>Daftar Guru Binaan</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.sekolah.index') }}" class="{{ $isSekolah ? 'active' : '' }}">
                        <span class="material-icons text-2xl">school</span>
                        <span>Sekolah Binaan</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.dokumen.index') }}" class="{{ $isDokumen ? 'active' : '' }}">
                        <span class="material-icons text-2xl">description</span>
                        <span>Daftar Dokumen Wajib</span>
                    </a>
                </li>

                @if($isSuperAdmin)
                    <li class="menu-title mt-4 px-3 pb-1">
                        <span class="text-xs font-extrabold uppercase tracking-wider text-secondary">
                            Khusus Super Admin
                        </span>
                    </li>

                    <li>
                        <a href="{{ route('admin.approve-guru.index') }}" class="{{ $isApproveGuru ? 'active' : '' }}">
                            <span class="material-icons text-2xl">how_to_reg</span>
                            <span class="flex-1">Persetujuan Akun Baru</span>
                            @if($pendingAccountCount > 0)
                                <span class="badge badge-error">{{ $pendingAccountCount }}</span>
                            @endif
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.users.index') }}" class="{{ $isUsers ? 'active' : '' }}">
                            <span class="material-icons text-2xl">key</span>
                            <span>Akun &amp; Kata Sandi</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.tahun-ajaran.index') }}" class="{{ $isTahunAjaran ? 'active' : '' }}">
                            <span class="material-icons text-2xl">calendar_today</span>
                            <span>Tahun Ajaran</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.triwulan.index') }}" class="{{ $isTriwulan ? 'active' : '' }}">
                            <span class="material-icons text-2xl">date_range</span>
                            <span>Jadwal Triwulan</span>
                        </a>
                    </li>
                @endif

                {{-- PROFIL --}}
                <li class="menu-title mt-4 px-3 pb-1">
                    <span class="text-xs font-extrabold uppercase tracking-wider text-secondary">
                        Akun Saya
                    </span>
                </li>

                <li>
                    <a href="{{ route('profile.edit') }}" class="{{ $isProfile ? 'active' : '' }}">
                        <span class="material-icons text-2xl">manage_accounts</span>
                        <span>Profil &amp; Kata Sandi</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('panduan.index') }}" class="{{ request()->routeIs('panduan.*') ? 'active' : '' }}">
                        <span class="material-icons text-2xl">help_outline</span>
                        <span>Panduan Penggunaan</span>
                    </a>
                </li>
            </ul>
        </nav>

        {{-- Footer Sidebar --}}
        <div class="border-t-2 border-base-300 bg-base-200 px-4 py-3 text-center">
            <p class="text-xs font-semibold text-base-content/75">
                SiPANDU VIRTUAL &copy; {{ date('Y') }}
            </p>
            <p class="mt-1 text-[11px] text-base-content/65">
                by <a href="https://mustdhiya.com" target="_blank" rel="noopener noreferrer" class="font-bold text-primary hover:underline">PT MUSTDHIYA TEKNOLOGI INDONESIA</a>
            </p>
        </div>
    </aside>
@endsection

@section('bottom_nav')
    @php
        $currentUser = auth()->user();
        $isSuperAdmin = $currentUser->isAdmin();

        $isDashboard = request()->routeIs('admin.dashboard');
        $isReview = request()->routeIs('admin.review-triwulan.*');
        $isLaporan = request()->routeIs('admin.laporan.*');
        $isFourth = $isSuperAdmin
            ? request()->routeIs('admin.users.*')
            : request()->routeIs('admin.monitoring.*');
    @endphp

    {{-- Bottom Navigation Bar Mobile (Style 05: Pill Highlight) --}}
    <nav
        data-tour="bottom-nav"
        aria-label="Navigasi bawah mobile"
        class="mobile-bottom-nav fixed bottom-0 left-0 right-0 z-40 border-t-2 border-base-300 bg-base-100/95 px-2 pt-2 shadow-[0_-4px_20px_rgba(0,0,0,0.08)] backdrop-blur lg:hidden"
    >
        <div class="mx-auto grid max-w-lg grid-cols-5 items-center gap-1">
            {{-- 1. Beranda --}}
            <a
                href="{{ route('admin.dashboard') }}"
                class="flex min-h-[54px] flex-col items-center justify-center rounded-2xl px-1 py-1.5 text-center transition {{ $isDashboard ? 'bg-primary/15 text-primary font-extrabold' : 'text-base-content/75 font-semibold hover:bg-base-200' }}"
            >
                <span class="material-icons text-[24px]">home</span>
                <span class="mt-0.5 text-[11px] leading-tight">Beranda</span>
            </a>

            {{-- 2. Periksa --}}
            <a
                href="{{ route('admin.review-triwulan.index') }}"
                class="flex min-h-[54px] flex-col items-center justify-center rounded-2xl px-1 py-1.5 text-center transition {{ $isReview ? 'bg-primary/15 text-primary font-extrabold' : 'text-base-content/75 font-semibold hover:bg-base-200' }}"
            >
                <span class="material-icons text-[24px]">fact_check</span>
                <span class="mt-0.5 text-[11px] leading-tight">Periksa</span>
            </a>

            {{-- 3. Laporan --}}
            <a
                href="{{ route('admin.laporan.index') }}"
                class="flex min-h-[54px] flex-col items-center justify-center rounded-2xl px-1 py-1.5 text-center transition {{ $isLaporan ? 'bg-primary/15 text-primary font-extrabold' : 'text-base-content/75 font-semibold hover:bg-base-200' }}"
            >
                <span class="material-icons text-[24px]">summarize</span>
                <span class="mt-0.5 text-[11px] leading-tight">Laporan</span>
            </a>

            {{-- 4. Akun & Sandi (Super Admin) / Monitoring (Pengawas) --}}
            @if($isSuperAdmin)
                <a
                    href="{{ route('admin.users.index') }}"
                    class="flex min-h-[54px] flex-col items-center justify-center rounded-2xl px-1 py-1.5 text-center transition {{ $isFourth ? 'bg-primary/15 text-primary font-extrabold' : 'text-base-content/75 font-semibold hover:bg-base-200' }}"
                >
                    <span class="material-icons text-[24px]">key</span>
                    <span class="mt-0.5 text-[11px] leading-tight">Akun</span>
                </a>
            @else
                <a
                    href="{{ route('admin.monitoring.index') }}"
                    class="flex min-h-[54px] flex-col items-center justify-center rounded-2xl px-1 py-1.5 text-center transition {{ $isFourth ? 'bg-primary/15 text-primary font-extrabold' : 'text-base-content/75 font-semibold hover:bg-base-200' }}"
                >
                    <span class="material-icons text-[24px]">analytics</span>
                    <span class="mt-0.5 text-[11px] leading-tight">SIAGA</span>
                </a>
            @endif

            {{-- 5. Menu Lainnya (buka drawer lengkap) --}}
            <label
                for="app-drawer"
                class="flex min-h-[54px] cursor-pointer flex-col items-center justify-center rounded-2xl px-1 py-1.5 text-center font-semibold text-base-content/75 transition hover:bg-base-200"
                aria-label="Buka menu lainnya"
            >
                <span class="material-icons text-[24px]">grid_view</span>
                <span class="mt-0.5 text-[11px] leading-tight">Lainnya</span>
            </label>
        </div>
    </nav>
@endsection
