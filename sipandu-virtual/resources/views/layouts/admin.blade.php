@extends('layouts.base')

@section('navbar')
    <header class="sticky top-0 z-30 border-b border-base-300/70 bg-base-100/95 backdrop-blur">
        <div class="page-shell">
            <div class="navbar min-h-16 px-4 sm:px-6 lg:px-8">

                <div class="flex-none lg:hidden">
                    <label
                        for="app-drawer"
                        class="btn btn-square btn-ghost rounded-xl"
                        aria-label="Buka menu utama"
                    >
                        <span class="material-icons">menu</span>
                    </label>
                </div>

                <div class="flex-1 min-w-0">
                    <a
                        href="{{ route('admin.dashboard') }}"
                        class="flex items-center gap-3 rounded-xl outline-none focus-visible:ring-2 focus-visible:ring-primary"
                    >
                        <div class="hidden h-9 w-9 items-center justify-center rounded-xl bg-primary text-primary-content shadow-sm sm:flex">
                            <span class="material-icons text-lg">verified_user</span>
                        </div>

                        <div class="min-w-0">
                            <p class="font-display truncate text-lg font-semibold leading-tight text-primary">
                                SiPANDU VIRTUAL
                            </p>
                            <p class="hidden text-xs text-neutral/60 sm:block">
                                Panel Pengawas PAI
                            </p>
                        </div>

                        <span class="badge badge-secondary badge-sm ml-1 font-semibold">
                            ADMIN
                        </span>
                    </a>
                </div>

                <div class="flex-none flex items-center gap-2 sm:gap-3">
                    <div class="hidden items-center gap-3 rounded-2xl border border-base-300 bg-base-200/55 px-3 py-2 md:flex">
                        <div class="avatar placeholder">
                            <div class="w-8 rounded-full bg-primary text-primary-content">
                                <span class="text-xs font-bold">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </span>
                            </div>
                        </div>

                        <div class="max-w-40 leading-tight">
                            <p class="truncate text-sm font-semibold">
                                {{ auth()->user()->name }}
                            </p>
                            <p class="text-xs text-neutral/60">
                                Pengawas PAI
                            </p>
                        </div>
                    </div>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf

                        <button
                            type="submit"
                            class="btn btn-sm btn-ghost rounded-xl text-error hover:bg-error/10 hover:text-error"
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
    <aside class="flex min-h-full w-72 flex-col border-r border-base-300 bg-base-200">

        <div class="border-b border-base-300 px-5 py-5">
            <a
                href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-3 rounded-2xl outline-none focus-visible:ring-2 focus-visible:ring-primary"
            >
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-primary text-primary-content shadow-md">
                    <span class="material-icons">verified_user</span>
                </div>

                <div class="min-w-0">
                    <p class="font-display text-lg font-semibold leading-tight text-primary">
                        SiPANDU
                    </p>
                    <p class="truncate text-xs font-medium tracking-wide text-neutral/60">
                        Panel Pengawas PAI
                    </p>
                </div>
            </a>
        </div>

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
                    <p class="truncate text-sm font-bold">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-neutral/60">Pengawas PAI</p>
                </div>
            </div>
        </div>

        <nav aria-label="Menu admin" class="flex-1 overflow-y-auto px-3 py-4">
            <ul class="menu gap-1 p-0 text-[15px]">

                <li>
                    <a
                        href="{{ route('admin.dashboard') }}"
                        class="rounded-xl {{ request()->routeIs('admin.dashboard') ? 'active font-bold' : '' }}"
                    >
                        <span class="material-icons">dashboard</span>
                        Dashboard
                    </a>
                </li>

                <li class="menu-title mt-4 px-3">
                    <span class="text-[11px] font-bold uppercase tracking-[0.14em] text-neutral/45">
                        Data Utama
                    </span>
                </li>

                <li>
                    <a
                        href="{{ route('admin.tahun-ajaran.index') }}"
                        class="rounded-xl {{ request()->routeIs('admin.tahun-ajaran.*') ? 'active font-bold' : '' }}"
                    >
                        <span class="material-icons">calendar_today</span>
                        Tahun Ajaran
                    </a>
                </li>

                <li>
                    <a
                        href="{{ route('admin.triwulan.index') }}"
                        class="rounded-xl {{ request()->routeIs('admin.triwulan.*') ? 'active font-bold' : '' }}"
                    >
                        <span class="material-icons">date_range</span>
                        Triwulan
                    </a>
                </li>

                <li>
                    <a
                        href="{{ route('admin.sekolah.index') }}"
                        class="rounded-xl {{ request()->routeIs('admin.sekolah.*') ? 'active font-bold' : '' }}"
                    >
                        <span class="material-icons">school</span>
                        Sekolah Binaan
                    </a>
                </li>

                <li>
                    <a
                        href="{{ route('admin.guru.index') }}"
                        class="rounded-xl {{ request()->routeIs('admin.guru.*') ? 'active font-bold' : '' }}"
                    >
                        <span class="material-icons">groups</span>
                        Guru Binaan
                    </a>
                </li>

                <li>
                    <a
                        href="{{ route('admin.dokumen.index') }}"
                        class="rounded-xl {{ request()->routeIs('admin.dokumen.*') ? 'active font-bold' : '' }}"
                    >
                        <span class="material-icons">description</span>
                        Dokumen Wajib
                    </a>
                </li>

                <li class="menu-title mt-4 px-3">
                    <span class="text-[11px] font-bold uppercase tracking-[0.14em] text-neutral/45">
                        Pendampingan
                    </span>
                </li>

                <li>
                    <a
                        href="{{ route('admin.approve-guru.index') }}"
                        class="rounded-xl {{ request()->routeIs('admin.approve-guru.*') ? 'active font-bold' : '' }}"
                    >
                        <span class="material-icons">how_to_reg</span>
                        Persetujuan Guru
                    </a>
                </li>

                <li>
                    <a
                        href="{{ route('admin.review-triwulan.index') }}"
                        class="rounded-xl {{ request()->routeIs('admin.review-triwulan.*') ? 'active font-bold' : '' }}"
                    >
                        <span class="material-icons">fact_check</span>
                        Review Triwulan
                    </a>
                </li>

                <li>
                    <a
                        href="{{ route('admin.diskusi.index') }}"
                        class="rounded-xl {{ request()->routeIs('admin.diskusi.*') ? 'active font-bold' : '' }}"
                    >
                        <span class="material-icons">forum</span>
                        Ruang Diskusi
                    </a>
                </li>

                <li>
                    <a
                        href="{{ route('admin.monitoring.index') }}"
                        class="rounded-xl {{ request()->routeIs('admin.monitoring.*') ? 'active font-bold' : '' }}"
                    >
                        <span class="material-icons">monitoring</span>
                        Monitoring SIAGA
                    </a>
                </li>

                <li class="menu-title mt-4 px-3">
                    <span class="text-[11px] font-bold uppercase tracking-[0.14em] text-neutral/45">
                        Laporan dan Arsip
                    </span>
                </li>

                <li>
                    <a
                        href="{{ route('admin.laporan.index') }}"
                        class="rounded-xl {{ request()->routeIs('admin.laporan.*') ? 'active font-bold' : '' }}"
                    >
                        <span class="material-icons">summarize</span>
                        Laporan
                    </a>
                </li>

                <li>
                    <a
                        href="{{ route('admin.gudang.index') }}"
                        class="rounded-xl {{ request()->routeIs('admin.gudang.*') ? 'active font-bold' : '' }}"
                    >
                        <span class="material-icons">folder_open</span>
                        Gudang PAI-BMTS
                    </a>
                </li>
            </ul>
        </nav>

        <div class="border-t border-base-300 p-4">
            <div class="rounded-2xl border border-base-300 bg-base-100 p-3">
                <div class="flex items-center gap-2 text-xs text-neutral/60">
                    <span class="material-icons text-base text-secondary">support_agent</span>
                    Butuh bantuan teknis?
                </div>
                <p class="mt-1 text-xs font-semibold text-primary">
                    Hubungi tim developer
                </p>
            </div>

            <p class="mt-3 text-center text-[11px] text-neutral/45">
                SiPANDU VIRTUAL &copy; {{ date('Y') }}
            </p>
        </div>
    </aside>
@endsection