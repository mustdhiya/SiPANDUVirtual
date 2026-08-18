@extends('layouts.admin')

@section('title', 'Laporan')

@section('content')
<div class="space-y-7">

    {{-- Header --}}
    <section class="flex flex-col gap-3 border-b border-base-300 pb-5 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.14em] text-secondary">
                Laporan dan Arsip
            </p>

            <h1 class="font-display mt-1 text-3xl font-semibold text-neutral">
                Laporan Triwulan
            </h1>

            <p class="mt-2 max-w-2xl text-sm leading-6 text-neutral/60">
                Pilih periode triwulan untuk melihat rekap submission guru dan mengunduh laporan Excel atau PDF.
            </p>
        </div>

        <div class="flex items-center gap-2 self-start rounded-2xl border border-base-300 bg-base-200 px-4 py-3 text-sm text-neutral/65 sm:self-auto">
            <span class="material-icons text-secondary">summarize</span>
            <span>{{ $periodes->count() }} periode tersedia</span>
        </div>
    </section>

    {{-- Informasi singkat --}}
    <section class="rounded-2xl border border-base-300 bg-base-200/70 p-4 sm:p-5">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-start">
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-secondary/15 text-secondary">
                <span class="material-icons">info</span>
            </div>

            <div>
                <h2 class="font-semibold text-neutral">
                    Cara menggunakan laporan
                </h2>
                <p class="mt-1 text-sm leading-6 text-neutral/65">
                    Buka periode yang dibutuhkan, periksa status submission guru, lalu gunakan tombol Export Excel atau Export PDF pada halaman detail laporan.
                </p>
            </div>
        </div>
    </section>

    {{-- Daftar triwulan --}}
    <section>
        <div class="mb-4">
            <p class="text-xs font-bold uppercase tracking-[0.14em] text-secondary">
                Pilih Periode
            </p>

            <h2 class="font-display mt-1 text-2xl font-semibold text-neutral">
                Rekap per Triwulan
            </h2>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
            @forelse($periodes as $periode)
                @php
                    $isOpen = (bool) $periode->is_open;
                    $isPastDeadline = $periode->deadline && $periode->deadline->isPast();
                @endphp

                <article class="group card border border-base-300 bg-base-100 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:border-primary/35 hover:shadow-md">
                    <div class="card-body gap-4 p-5">

                        <div class="flex items-start justify-between gap-3">
                            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-primary/10 text-primary">
                                <span class="material-icons">date_range</span>
                            </div>

                            @if($isOpen)
                                <span class="badge badge-success gap-1">
                                    <span class="material-icons text-[14px]">lock_open</span>
                                    Dibuka
                                </span>
                            @elseif($isPastDeadline)
                                <span class="badge badge-ghost gap-1">
                                    <span class="material-icons text-[14px]">event_busy</span>
                                    Selesai
                                </span>
                            @else
                                <span class="badge badge-warning gap-1">
                                    <span class="material-icons text-[14px]">lock</span>
                                    Belum Dibuka
                                </span>
                            @endif
                        </div>

                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.12em] text-secondary">
                                {{ $periode->tahunAjaran->label }}
                            </p>

                            <h3 class="font-display mt-1 text-xl font-semibold text-neutral">
                                Triwulan {{ $periode->nomor }}
                            </h3>

                            <p class="mt-2 line-clamp-2 text-sm leading-6 text-neutral/60">
                                {{ $periode->tema }}
                            </p>
                        </div>

                        <div class="flex items-center gap-2 border-t border-base-300 pt-4 text-sm text-neutral/60">
                            <span class="material-icons text-base text-secondary">event</span>
                            <span>
                                Deadline:
                                <strong class="font-semibold text-neutral">
                                    {{ $periode->deadline?->translatedFormat('d F Y') ?? '-' }}
                                </strong>
                            </span>
                        </div>

                        <div class="card-actions mt-1">
                            <a
                                href="{{ route('admin.laporan.show', $periode->id) }}"
                                class="btn btn-primary w-full rounded-xl"
                            >
                                <span class="material-icons text-base">visibility</span>
                                Lihat Rekap Laporan
                            </a>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-full rounded-2xl border border-dashed border-base-300 bg-base-200/60 px-6 py-12 text-center">
                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-base-100 text-neutral/45">
                        <span class="material-icons text-3xl">event_busy</span>
                    </div>

                    <h2 class="font-display mt-4 text-xl font-semibold text-neutral">
                        Belum Ada Periode Triwulan
                    </h2>

                    <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-neutral/60">
                        Buat periode triwulan terlebih dahulu agar sistem dapat menampilkan laporan dan rekap submission guru.
                    </p>

                    <a href="{{ route('admin.triwulan.create') }}" class="btn btn-primary mt-5 rounded-xl">
                        <span class="material-icons text-base">add</span>
                        Tambah Triwulan
                    </a>
                </div>
            @endforelse
        </div>
    </section>
</div>
@endsection