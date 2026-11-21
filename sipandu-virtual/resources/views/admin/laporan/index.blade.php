@extends('layouts.admin')

@section('title', 'Laporan Triwulan')

@section('content')
@php
    $isSuperAdmin = auth()->user()->isAdmin();
@endphp

<div class="mx-auto max-w-6xl space-y-7">

    {{-- Header --}}
    <section class="rounded-2xl border-2 border-base-300 bg-base-100 p-6 shadow-sm">
        <span class="badge {{ $isSuperAdmin ? 'badge-secondary' : 'badge-primary' }} mb-2">
            {{ $isSuperAdmin ? 'Super Admin - Rekap Semua Pengawas' : 'Rekap Binaan Pengawas' }}
        </span>
        <h1 class="text-2xl font-extrabold text-base-content sm:text-3xl">
            {{ $isSuperAdmin ? 'Laporan Seluruh Pengawas & Guru' : 'Laporan Triwulan Guru Binaan' }}
        </h1>
        <p class="mt-2 text-base text-base-content/80">
            @if($isSuperAdmin)
                Pilih periode triwulan di bawah ini untuk melihat laporan dari pengawas lain maupun binaan Anda sendiri, lalu unduh rekap Excel atau PDF.
            @else
                Pilih periode triwulan di bawah ini untuk melihat rekap kelengkapan guru binaan Anda dan mengunduh file Excel atau PDF.
            @endif
        </p>
    </section>

    {{-- Daftar Periode --}}
    <section class="grid grid-cols-1 gap-5 md:grid-cols-2">
        @forelse($periodes as $periode)
            @php
                $isOpen = (bool) $periode->is_open;
                $isPastDeadline = $periode->deadline && $periode->deadline->isPast();

                $periodeLabel = match($periode->nomor) {
                    1 => 'Januari – Maret',
                    2 => 'April – Juni',
                    3 => 'Juli – September',
                    4 => 'Oktober – Desember',
                    default => 'Periode Pendampingan',
                };
            @endphp

            <article class="flex flex-col justify-between rounded-2xl border-2 border-base-300 bg-base-100 p-6 shadow-sm transition hover:border-primary hover:shadow-md">
                <div class="space-y-4">
                    <div class="flex flex-wrap items-start justify-between gap-3">
                        <div>
                            <p class="text-xs font-extrabold uppercase tracking-wider text-secondary">
                                {{ $periode->tahunAjaran->label ?? 'Tahun Ajaran' }} &middot; {{ $periodeLabel }}
                            </p>
                            <h2 class="mt-1 text-2xl font-extrabold text-base-content">
                                Triwulan {{ $periode->nomor }}
                            </h2>
                        </div>

                        @if($isOpen)
                            <span class="badge badge-success badge-lg gap-1">
                                <span class="material-icons text-base">lock_open</span>
                                Sedang Dibuka
                            </span>
                        @elseif($isPastDeadline)
                            <span class="badge badge-ghost border border-base-300 badge-lg gap-1">
                                <span class="material-icons text-base">event_busy</span>
                                Selesai
                            </span>
                        @else
                            <span class="badge badge-warning badge-lg gap-1">
                                <span class="material-icons text-base">lock</span>
                                Belum Dibuka
                            </span>
                        @endif
                    </div>

                    <p class="text-base font-medium text-base-content/85">
                        {{ $periode->tema }}
                    </p>

                    <div class="flex items-center gap-2 rounded-xl bg-base-200 px-4 py-3 text-base">
                        <span class="material-icons text-secondary">event</span>
                        <span>
                            Batas Waktu:
                            <strong>{{ $periode->deadline?->translatedFormat('d F Y') ?? 'Belum diatur' }}</strong>
                        </span>
                    </div>
                </div>

                <div class="mt-6">
                    <a href="{{ route('admin.laporan.show', $periode->id) }}" class="btn btn-primary btn-lg w-full">
                        <span class="material-icons text-2xl">visibility</span>
                        Lihat Rekap &amp; Unduh Laporan
                    </a>
                </div>
            </article>
        @empty
            <div class="col-span-full rounded-2xl border-2 border-dashed border-base-300 bg-base-100 p-12 text-center">
                <span class="material-icons text-5xl text-base-content/40">event_busy</span>
                <h2 class="mt-3 text-xl font-extrabold text-base-content">Belum Ada Periode Triwulan</h2>
                <p class="mx-auto mt-2 max-w-md text-base text-base-content/80">
                    Periode triwulan belum tersedia saat ini.
                </p>

                @if($isSuperAdmin)
                    <a href="{{ route('admin.triwulan.create') }}" class="btn btn-primary btn-lg mt-5">
                        <span class="material-icons text-2xl">add</span>
                        Buat Jadwal Triwulan Baru
                    </a>
                @endif
            </div>
        @endforelse
    </section>

</div>
@endsection
