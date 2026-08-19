@extends('layouts.base')

@section('navbar')
    <header class="sticky top-0 z-30 border-b border-base-300 bg-base-100/95 backdrop-blur">
        <div class="page-shell">
            <div class="navbar min-h-16 px-4 sm:px-6 lg:px-8">

                {{-- Tombol sidebar mobile --}}
                <div class="flex-none lg:hidden">
                    <label
                        for="app-drawer"
                        aria-label="Buka menu guru"
                        class="btn btn-square btn-ghost rounded-xl"
                    >
                        <span class="material-icons">menu</span>
                    </label>
                </div>

                {{-- Brand Header --}}
                <div class="min-w-0 flex-1">
                    <a
                        href="{{ route('guru.dashboard') }}"
                        class="flex items-center gap-3 rounded-xl outline-none focus-visible:ring-2 focus-visible:ring-primary"
                        aria-label="Kembali ke dashboard guru"
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
                                Panel Guru PAI
                            </p>
                        </div>

                        <span class="badge badge-secondary badge-sm ml-1 hidden font-semibold xs:inline-flex">
                            GURU PAI
                        </span>
                    </a>
                </div>

                {{-- User dan Logout --}}
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
                                Akun Guru PAI
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
        $isDashboard = request()->routeIs('guru.dashboard');
        $isTriwulan = request()->routeIs('guru.triwulan.*');
        $isDiskusi = request()->routeIs('guru.diskusi.*');
        $isGudang = request()->routeIs('guru.gudang.*');
    @endphp

    <aside class="flex min-h-full w-72 flex-col border-r border-base-300 bg-base-200">

        {{-- Logo Sidebar --}}
        <div class="border-b border-base-300 px-5 py-5">
            <a
                href="{{ route('guru.dashboard') }}"
                class="flex items-center gap-3 rounded-2xl outline-none focus-visible:ring-2 focus-visible:ring-primary"
                aria-label="Kembali ke dashboard guru"
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
                        Panel Guru PAI
                    </p>
                </div>
            </a>
        </div>

        {{-- User di mobile --}}
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
                        Akun Guru PAI
                    </p>
                </div>
            </div>
        </div>

        {{-- Navigasi --}}
        <nav aria-label="Menu guru" class="flex-1 overflow-y-auto px-3 py-4">
            <ul class="menu gap-1 p-0 text-[15px]">

                <li>
                    <a
                        href="{{ route('guru.dashboard') }}"
                        class="rounded-xl {{ $isDashboard ? 'active font-bold' : '' }}"
                    >
                        <span class="material-icons">dashboard</span>
                        Dashboard
                    </a>
                </li>

                <li class="menu-title mt-4 px-3">
                    <span class="text-[11px] font-bold uppercase tracking-[0.14em] text-base-content/45">
                        Pendampingan
                    </span>
                </li>

                <li>
                    <a
                        href="{{ route('guru.triwulan.index') }}"
                        class="rounded-xl {{ $isTriwulan ? 'active font-bold' : '' }}"
                    >
                        <span class="material-icons">date_range</span>
                        Triwulan Saya
                    </a>
                </li>

                <li>
                    <a
                        href="{{ route('guru.diskusi.index') }}"
                        class="rounded-xl {{ $isDiskusi ? 'active font-bold' : '' }}"
                    >
                        <span class="material-icons">forum</span>
                        Ruang Diskusi
                    </a>
                </li>

                <li class="menu-title mt-4 px-3">
                    <span class="text-[11px] font-bold uppercase tracking-[0.14em] text-base-content/45">
                        Materi dan Bantuan
                    </span>
                </li>

                <li>
                    <a
                        href="{{ route('guru.gudang.index') }}"
                        class="rounded-xl {{ $isGudang ? 'active font-bold' : '' }}"
                    >
                        <span class="material-icons">folder_open</span>
                        Gudang PAI-BMTS
                    </a>
                </li>
            </ul>
        </nav>

        {{-- Bantuan --}}
        <div class="border-t border-base-300 p-4">
            <div class="rounded-2xl border border-base-300 bg-base-100 p-3">
                <div class="flex items-start gap-2">
                    <span class="material-icons text-secondary">help_outline</span>

                    <div>
                        <p class="text-xs font-semibold text-base-content">
                            Butuh bantuan?
                        </p>

                        <p class="mt-1 text-xs leading-5 text-base-content/60">
                            Hubungi Pengawas PAI jika ada kendala pengisian dokumen.
                        </p>
                    </div>
                </div>
            </div>

            <p class="mt-3 text-center text-[11px] text-base-content/45">
                SiPANDU VIRTUAL &copy; {{ date('Y') }}
            </p>
        </div>
    </aside>
@endsection