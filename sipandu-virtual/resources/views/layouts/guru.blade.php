@extends('layouts.base')

@section('navbar')
    @php
        $currentUser = auth()->user();
        $isProfileActive = request()->routeIs('profile.*');
    @endphp

    <header class="sticky top-0 z-30 border-b-2 border-base-300 bg-base-100 shadow-sm">
        <div class="page-shell">
            <div class="flex min-h-[4.5rem] items-center justify-between gap-3 px-4 py-2 sm:px-6 lg:px-8">

                {{-- Kiri: Logo & Judul Halaman (di mobile navigasi pakai Bottom Bar) --}}
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
                            @yield('title', 'Beranda Guru')
                        </p>
                        <p class="hidden text-xs font-medium text-base-content/75 sm:block">
                            Panel Guru PAI Binaan
                        </p>
                    </div>
                </div>

                {{-- Kanan: Pengaturan Huruf + Profil + Keluar --}}
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
                        <div class="flex h-9 w-9 items-center justify-center rounded-full bg-primary text-sm font-bold text-primary-content">
                            {{ strtoupper(substr($currentUser->name, 0, 1)) }}
                        </div>

                        <div class="max-w-44 leading-tight">
                            <p class="truncate text-sm font-bold text-base-content">
                                {{ $currentUser->name }}
                            </p>
                            <p class="text-xs font-medium text-base-content/75">
                                Guru PAI
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
        $isDashboard = request()->routeIs('guru.dashboard');
        $isTriwulan = request()->routeIs('guru.triwulan.*');
        $isDiskusi = request()->routeIs('guru.diskusi.*');
        $isGudang = request()->routeIs('guru.gudang.*');
        $isProfile = request()->routeIs('profile.*');
    @endphp

    <aside class="flex min-h-full w-80 flex-col border-r-2 border-base-300 bg-base-100">

        {{-- Brand --}}
        <div class="border-b-2 border-base-300 bg-base-200 px-5 py-5">
            <a
                href="{{ route('guru.dashboard') }}"
                class="flex items-center gap-3.5 rounded-xl outline-none"
                aria-label="Kembali ke beranda guru"
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
                    <span class="mt-1 inline-flex items-center rounded-lg bg-primary px-2.5 py-0.5 text-xs font-bold text-primary-content">
                        GURU PAI BINAAN
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

        {{-- Menu Sederhana untuk Guru --}}
        <nav data-tour="sidebar-nav" aria-label="Menu guru" class="flex-1 overflow-y-auto px-3 py-5">
            <ul class="menu gap-2 p-0">

                <li>
                    <a href="{{ route('guru.dashboard') }}" class="{{ $isDashboard ? 'active' : '' }}">
                        <span class="material-icons text-2xl">home</span>
                        <span>Beranda</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('guru.triwulan.index') }}" class="{{ $isTriwulan ? 'active' : '' }}">
                        <span class="material-icons text-2xl">upload_file</span>
                        <span>Laporan Triwulan Saya</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('guru.diskusi.index') }}" class="{{ $isDiskusi ? 'active' : '' }}">
                        <span class="material-icons text-2xl">forum</span>
                        <span>Tanya Pengawas</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('guru.gudang.index') }}" class="{{ $isGudang ? 'active' : '' }}">
                        <span class="material-icons text-2xl">folder_open</span>
                        <span>Gudang Materi PAI</span>
                    </a>
                </li>

                <li class="mt-4 border-t border-base-300 pt-4">
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

        {{-- Bantuan --}}
        <div class="border-t-2 border-base-300 bg-base-200 p-4">
            <div class="rounded-xl border border-base-300 bg-base-100 p-3.5">
                <p class="flex items-center gap-2 text-sm font-bold text-primary">
                    <span class="material-icons text-xl">help_outline</span>
                    Butuh Bantuan?
                </p>
                <p class="mt-1 text-xs leading-relaxed text-base-content/80">
                    Jika kesulitan mengunggah dokumen, silakan hubungi Pengawas PAI atau kirim pesan lewat menu <strong>Tanya Pengawas</strong>.
                </p>
            </div>

            <p class="mt-3 text-center text-xs font-medium text-base-content/75">
                SiPANDU VIRTUAL &copy; {{ date('Y') }}
            </p>
            <p class="mt-1 text-center text-[11px] text-base-content/65">
                by <a href="https://mustdhiya.com" target="_blank" rel="noopener noreferrer" class="font-bold text-primary hover:underline">PT MUSTDHIYA TEKNOLOGI INDONESIA</a>
            </p>
        </div>
    </aside>
@endsection

@section('bottom_nav')
    @php
        $isDashboard = request()->routeIs('guru.dashboard');
        $isTriwulan = request()->routeIs('guru.triwulan.*');
        $isDiskusi = request()->routeIs('guru.diskusi.*');
        $isGudang = request()->routeIs('guru.gudang.*');
        $isProfile = request()->routeIs('profile.*');
    @endphp

    {{-- Bottom Navigation Bar Mobile untuk Guru (Style 05: Pill Highlight) --}}
    <nav
        data-tour="bottom-nav"
        aria-label="Navigasi bawah guru"
        class="mobile-bottom-nav fixed bottom-0 left-0 right-0 z-40 border-t-2 border-base-300 bg-base-100/95 px-2 pt-2 shadow-[0_-4px_20px_rgba(0,0,0,0.08)] backdrop-blur lg:hidden"
    >
        <div class="mx-auto grid max-w-lg grid-cols-5 items-center gap-1">
            {{-- 1. Beranda --}}
            <a
                href="{{ route('guru.dashboard') }}"
                class="flex min-h-[54px] flex-col items-center justify-center rounded-2xl px-1 py-1.5 text-center transition {{ $isDashboard ? 'bg-primary/15 text-primary font-extrabold' : 'text-base-content/75 font-semibold hover:bg-base-200' }}"
            >
                <span class="material-icons text-[24px]">home</span>
                <span class="mt-0.5 text-[11px] leading-tight">Beranda</span>
            </a>

            {{-- 2. Triwulan --}}
            <a
                href="{{ route('guru.triwulan.index') }}"
                class="flex min-h-[54px] flex-col items-center justify-center rounded-2xl px-1 py-1.5 text-center transition {{ $isTriwulan ? 'bg-primary/15 text-primary font-extrabold' : 'text-base-content/75 font-semibold hover:bg-base-200' }}"
            >
                <span class="material-icons text-[24px]">upload_file</span>
                <span class="mt-0.5 text-[11px] leading-tight">Triwulan</span>
            </a>

            {{-- 3. Diskusi --}}
            <a
                href="{{ route('guru.diskusi.index') }}"
                class="flex min-h-[54px] flex-col items-center justify-center rounded-2xl px-1 py-1.5 text-center transition {{ $isDiskusi ? 'bg-primary/15 text-primary font-extrabold' : 'text-base-content/75 font-semibold hover:bg-base-200' }}"
            >
                <span class="material-icons text-[24px]">forum</span>
                <span class="mt-0.5 text-[11px] leading-tight">Diskusi</span>
            </a>

            {{-- 4. Materi --}}
            <a
                href="{{ route('guru.gudang.index') }}"
                class="flex min-h-[54px] flex-col items-center justify-center rounded-2xl px-1 py-1.5 text-center transition {{ $isGudang ? 'bg-primary/15 text-primary font-extrabold' : 'text-base-content/75 font-semibold hover:bg-base-200' }}"
            >
                <span class="material-icons text-[24px]">folder_open</span>
                <span class="mt-0.5 text-[11px] leading-tight">Materi</span>
            </a>

            {{-- 5. Profil --}}
            <a
                href="{{ route('profile.edit') }}"
                class="flex min-h-[54px] flex-col items-center justify-center rounded-2xl px-1 py-1.5 text-center transition {{ $isProfile ? 'bg-primary/15 text-primary font-extrabold' : 'text-base-content/75 font-semibold hover:bg-base-200' }}"
            >
                <span class="material-icons text-[24px]">person</span>
                <span class="mt-0.5 text-[11px] leading-tight">Profil</span>
            </a>
        </div>
    </nav>
@endsection
