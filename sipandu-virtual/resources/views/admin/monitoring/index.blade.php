@extends('layouts.admin')

@section('title', 'Monitoring SIAGA')

@section('content')
@php
    $periodeAktif = $periodes->firstWhere('is_open', true);
@endphp

<div class="space-y-8">

    {{-- Header --}}
    <section class="flex flex-col gap-4 border-b border-base-300 pb-6 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.14em] text-secondary">
                Pendampingan
            </p>

            <h1 class="font-display mt-1 text-3xl font-semibold text-neutral">
                Monitoring SIAGA
            </h1>

            <p class="mt-2 max-w-2xl text-sm leading-6 text-neutral/65">
                Pantau kelengkapan dokumen, respons submission, dan prioritas pendampingan guru untuk setiap periode triwulan.
            </p>
        </div>

        <div class="rounded-2xl border border-base-300 bg-base-200 px-4 py-3 text-sm">
            <div class="flex items-center gap-2 text-neutral/60">
                <span class="material-icons text-secondary">info</span>
                <span>Skor diperbarui saat halaman monitoring dibuka.</span>
            </div>
        </div>
    </section>

    {{-- Info penilaian --}}
    <section class="grid gap-3 md:grid-cols-3">
        <article class="rounded-2xl border border-error/20 bg-error/5 p-4">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-error/15 text-error">
                    <span class="material-icons">priority_high</span>
                </div>
                <div>
                    <p class="font-semibold text-error">Prioritas Utama</p>
                    <p class="mt-0.5 text-sm text-neutral/65">Skor di bawah 40. Perlu perhatian segera.</p>
                </div>
            </div>
        </article>

        <article class="rounded-2xl border border-warning/25 bg-warning/10 p-4">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-warning/20 text-warning">
                    <span class="material-icons">trending_up</span>
                </div>
                <div>
                    <p class="font-semibold text-warning">Prioritas Menengah</p>
                    <p class="mt-0.5 text-sm text-neutral/65">Skor 40 sampai kurang dari 70. Perlu pendampingan.</p>
                </div>
            </div>
        </article>

        <article class="rounded-2xl border border-success/25 bg-success/5 p-4">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-success/15 text-success">
                    <span class="material-icons">verified</span>
                </div>
                <div>
                    <p class="font-semibold text-success">Prioritas Akhir</p>
                    <p class="mt-0.5 text-sm text-neutral/65">Skor 70 atau lebih. Progres sudah baik.</p>
                </div>
            </div>
        </article>
    </section>

    {{-- Periode --}}
    <section>
        <div class="mb-4 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.14em] text-secondary">
                    Pilih Periode
                </p>

                <h2 class="font-display mt-1 text-2xl font-semibold text-neutral">
                    Monitoring Per Triwulan
                </h2>
            </div>

            <p class="text-sm text-neutral/55">
                {{ $periodes->count() }} periode tersedia
            </p>
        </div>

        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            @forelse($periodes as $periode)
                @php
                    $isActive = $periodeAktif && $periodeAktif->id === $periode->id;
                    $isExpired = $periode->deadline && $periode->deadline->isPast();
                @endphp

                <article class="card border border-base-300 bg-base-100 shadow-sm transition hover:-translate-y-0.5 hover:border-primary/40 hover:shadow-md">
                    <div class="card-body gap-5 p-5">

                        <div class="flex items-start justify-between gap-3">
                            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-primary/10 text-primary">
                                <span class="material-icons">analytics</span>
                            </div>

                            <div class="flex flex-col items-end gap-2">
                                @if($isActive)
                                    <span class="badge badge-success gap-1">
                                        <span class="material-icons text-xs">lock_open</span>
                                        Sedang Dibuka
                                    </span>
                                @elseif($isExpired)
                                    <span class="badge badge-ghost">Periode Berakhir</span>
                                @else
                                    <span class="badge badge-outline">Belum Dibuka</span>
                                @endif

                                <span class="badge badge-secondary font-semibold">
                                    TW {{ $periode->nomor }}
                                </span>
                            </div>
                        </div>

                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.12em] text-neutral/45">
                                {{ $periode->tahunAjaran->label }}
                            </p>

                            <h3 class="font-display mt-1 text-xl font-semibold leading-snug text-neutral">
                                {{ $periode->tema }}
                            </h3>
                        </div>

                        <div class="rounded-xl bg-base-200 px-3 py-3">
                            <div class="flex items-center gap-2 text-sm text-neutral/65">
                                <span class="material-icons text-base text-secondary">event</span>
                                <span>
                                    Deadline:
                                    <strong class="font-semibold text-neutral">
                                        {{ $periode->deadline?->translatedFormat('d F Y') ?? '-' }}
                                    </strong>
                                </span>
                            </div>
                        </div>

                        <div class="card-actions">
                            <a
                                href="{{ route('admin.monitoring.show', $periode->id) }}"
                                class="btn btn-primary w-full rounded-xl"
                            >
                                <span class="material-icons text-base">visibility</span>
                                Buka Monitoring TW {{ $periode->nomor }}
                            </a>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-full">
                    <div class="rounded-2xl border border-dashed border-base-300 bg-base-100 px-6 py-12 text-center">
                        <span class="material-icons text-4xl text-neutral/35">date_range</span>
                        <h2 class="font-display mt-3 text-xl font-semibold text-neutral">
                            Belum ada periode triwulan
                        </h2>
                        <p class="mx-auto mt-2 max-w-md text-sm text-neutral/60">
                            Buat tahun ajaran dan periode triwulan terlebih dahulu sebelum membuka monitoring SIAGA.
                        </p>
                        <a href="{{ route('admin.triwulan.index') }}" class="btn btn-primary mt-5 rounded-xl">
                            <span class="material-icons text-base">add</span>
                            Kelola Triwulan
                        </a>
                    </div>
                </div>
            @endforelse
        </div>
    </section>
</div>
@endsection