@extends('layouts.admin')

@section('title', 'Monitoring TW ' . $periode->nomor)

@section('content')
@php
    $totalGuru = $gurusWithSkor->count();
    $utamaCount = $prioritasUtama->count();
    $menengahCount = $prioritasMenengah->count();
    $akhirCount = $prioritasAkhir->count();

    $rataRataSkor = $totalGuru > 0
        ? round($gurusWithSkor->avg('skor_total'), 1)
        : 0;

    $rataKelengkapan = $totalGuru > 0
        ? round($gurusWithSkor->avg('skor_kelengkapan'), 1)
        : 0;

    $rataRespons = $totalGuru > 0
        ? round($gurusWithSkor->avg('skor_respons'), 1)
        : 0;

    $progressClass = match (true) {
        $rataRataSkor < 40 => 'progress-error',
        $rataRataSkor < 70 => 'progress-warning',
        default => 'progress-success',
    };

    $renderGuruRows = function ($collection, $tone) use ($periode) {
        return '';
    };
@endphp

<div class="space-y-8">

    {{-- Header --}}
    <section class="flex flex-col gap-4 border-b border-base-300 pb-6 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <a
                href="{{ route('admin.monitoring.index') }}"
                class="mb-4 inline-flex items-center gap-1 text-sm font-semibold text-primary hover:underline"
            >
                <span class="material-icons text-base">arrow_back</span>
                Kembali ke daftar periode
            </a>

            <p class="text-xs font-bold uppercase tracking-[0.14em] text-secondary">
                Monitoring SIAGA
            </p>

            <h1 class="font-display mt-1 text-3xl font-semibold text-neutral">
                Triwulan {{ $periode->nomor }} — {{ $periode->tahunAjaran->label }}
            </h1>

            <p class="mt-2 max-w-2xl text-sm leading-6 text-neutral/65">
                {{ $periode->tema }}. Gunakan data ini untuk menentukan guru yang perlu didampingi lebih dahulu.
            </p>
        </div>

        <div class="rounded-2xl border border-base-300 bg-base-200 px-4 py-3">
            <div class="flex items-center gap-2 text-sm text-neutral/65">
                <span class="material-icons text-secondary">event</span>
                <span>Deadline:</span>
                <strong class="font-semibold text-neutral">
                    {{ $periode->deadline?->translatedFormat('d F Y') ?? '-' }}
                </strong>
            </div>
        </div>
    </section>

    {{-- Ringkasan prioritas --}}
    <section class="grid gap-3 sm:grid-cols-2 xl:grid-cols-4">
        <article class="rounded-2xl border border-base-300 bg-base-100 p-4 shadow-sm">
            <div class="flex items-start justify-between">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-primary/10 text-primary">
                    <span class="material-icons">groups</span>
                </div>
                <span class="text-xs font-bold uppercase tracking-wide text-neutral/45">Total</span>
            </div>

            <p class="mt-5 text-sm text-neutral/60">Guru Terpantau</p>
            <p class="font-display mt-1 text-3xl font-semibold text-primary">{{ $totalGuru }}</p>
        </article>

        <article class="rounded-2xl border border-error/20 bg-error/5 p-4 shadow-sm">
            <div class="flex items-start justify-between">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-error/15 text-error">
                    <span class="material-icons">priority_high</span>
                </div>
                <span class="badge badge-error badge-sm">Segera</span>
            </div>

            <p class="mt-5 text-sm text-neutral/60">Prioritas Utama</p>
            <p class="font-display mt-1 text-3xl font-semibold text-error">{{ $utamaCount }}</p>
        </article>

        <article class="rounded-2xl border border-warning/25 bg-warning/10 p-4 shadow-sm">
            <div class="flex items-start justify-between">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-warning/20 text-warning">
                    <span class="material-icons">trending_up</span>
                </div>
                <span class="badge badge-warning badge-sm">Dampingi</span>
            </div>

            <p class="mt-5 text-sm text-neutral/60">Prioritas Menengah</p>
            <p class="font-display mt-1 text-3xl font-semibold text-warning">{{ $menengahCount }}</p>
        </article>

        <article class="rounded-2xl border border-success/25 bg-success/5 p-4 shadow-sm">
            <div class="flex items-start justify-between">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-success/15 text-success">
                    <span class="material-icons">verified</span>
                </div>
                <span class="badge badge-success badge-sm">Baik</span>
            </div>

            <p class="mt-5 text-sm text-neutral/60">Prioritas Akhir</p>
            <p class="font-display mt-1 text-3xl font-semibold text-success">{{ $akhirCount }}</p>
        </article>
    </section>

    {{-- Kinerja keseluruhan --}}
    <section class="card border border-base-300 bg-base-100 shadow-sm">
        <div class="card-body gap-5 p-5 sm:p-6">
            <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.14em] text-secondary">
                        Kinerja Keseluruhan
                    </p>
                    <h2 class="font-display mt-1 text-2xl font-semibold text-neutral">
                        Rata-rata Progres Guru
                    </h2>
                </div>

                <span class="badge badge-outline badge-lg">
                    Skor rata-rata: {{ $rataRataSkor }}%
                </span>
            </div>

            <div class="grid gap-5 md:grid-cols-3">
                <div>
                    <div class="mb-2 flex items-center justify-between text-sm">
                        <span class="text-neutral/65">Kelengkapan dokumen</span>
                        <strong class="text-neutral">{{ $rataKelengkapan }}%</strong>
                    </div>
                    <progress class="progress progress-primary w-full" value="{{ $rataKelengkapan }}" max="100"></progress>
                </div>

                <div>
                    <div class="mb-2 flex items-center justify-between text-sm">
                        <span class="text-neutral/65">Respons submission</span>
                        <strong class="text-neutral">{{ $rataRespons }}%</strong>
                    </div>
                    <progress class="progress progress-secondary w-full" value="{{ $rataRespons }}" max="100"></progress>
                </div>

                <div>
                    <div class="mb-2 flex items-center justify-between text-sm">
                        <span class="text-neutral/65">Skor SIAGA</span>
                        <strong class="text-neutral">{{ $rataRataSkor }}%</strong>
                    </div>
                    <progress class="progress {{ $progressClass }} w-full" value="{{ $rataRataSkor }}" max="100"></progress>
                </div>
            </div>

            <div class="rounded-xl bg-base-200 px-4 py-3 text-sm leading-6 text-neutral/65">
                <span class="font-semibold text-neutral">Cara baca skor:</span>
                kelengkapan dokumen dan respons submission dihitung masing-masing sebesar 50% dari skor total.
            </div>
        </div>
    </section>

    {{-- PRIORITAS UTAMA --}}
    <section class="collapse collapse-arrow border border-error/25 bg-base-100 shadow-sm" open>
        <input type="checkbox" checked>

        <div class="collapse-title px-5 py-5 sm:px-6">
            <div class="flex items-start gap-4 pr-7">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-error/15 text-error">
                    <span class="material-icons">priority_high</span>
                </div>

                <div class="min-w-0 flex-1">
                    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h2 class="font-display text-xl font-semibold text-error">
                                Prioritas Utama
                            </h2>
                            <p class="mt-1 text-sm text-neutral/65">
                                Skor di bawah 40. Perlu perhatian dan tindak lanjut segera.
                            </p>
                        </div>

                        <span class="badge badge-error self-start sm:self-auto">
                            {{ $utamaCount }} Guru
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="collapse-content px-5 pb-5 sm:px-6 sm:pb-6">
            @forelse($prioritasUtama as $data)
                @include('admin.monitoring.partials.guru-card', [
                    'data' => $data,
                    'periode' => $periode,
                    'tone' => 'error',
                    'label' => 'Perlu Perhatian',
                ])
            @empty
                <div class="rounded-2xl border border-dashed border-error/25 bg-error/5 px-5 py-8 text-center">
                    <span class="material-icons text-4xl text-success">check_circle</span>
                    <p class="font-display mt-2 text-lg font-semibold text-neutral">Tidak ada prioritas utama</p>
                    <p class="mt-1 text-sm text-neutral/60">Tidak ada guru dengan skor di bawah 40 pada periode ini.</p>
                </div>
            @endforelse
        </div>
    </section>

    {{-- PRIORITAS MENENGAH --}}
    <section class="collapse collapse-arrow border border-warning/30 bg-base-100 shadow-sm">
        <input type="checkbox">

        <div class="collapse-title px-5 py-5 sm:px-6">
            <div class="flex items-start gap-4 pr-7">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-warning/20 text-warning">
                    <span class="material-icons">trending_up</span>
                </div>

                <div class="min-w-0 flex-1">
                    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h2 class="font-display text-xl font-semibold text-warning">
                                Prioritas Menengah
                            </h2>
                            <p class="mt-1 text-sm text-neutral/65">
                                Skor 40 sampai kurang dari 70. Perlu pendampingan terarah.
                            </p>
                        </div>

                        <span class="badge badge-warning self-start sm:self-auto">
                            {{ $menengahCount }} Guru
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="collapse-content px-5 pb-5 sm:px-6 sm:pb-6">
            @forelse($prioritasMenengah as $data)
                @include('admin.monitoring.partials.guru-card', [
                    'data' => $data,
                    'periode' => $periode,
                    'tone' => 'warning',
                    'label' => 'Perlu Pendampingan',
                ])
            @empty
                <div class="rounded-2xl border border-dashed border-warning/30 bg-warning/5 px-5 py-8 text-center">
                    <span class="material-icons text-4xl text-success">check_circle</span>
                    <p class="font-display mt-2 text-lg font-semibold text-neutral">Tidak ada prioritas menengah</p>
                    <p class="mt-1 text-sm text-neutral/60">Tidak ada guru dengan skor pada rentang 40 sampai kurang dari 70.</p>
                </div>
            @endforelse
        </div>
    </section>

    {{-- PRIORITAS AKHIR --}}
    <section class="collapse collapse-arrow border border-success/25 bg-base-100 shadow-sm">
        <input type="checkbox">

        <div class="collapse-title px-5 py-5 sm:px-6">
            <div class="flex items-start gap-4 pr-7">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-success/15 text-success">
                    <span class="material-icons">verified</span>
                </div>

                <div class="min-w-0 flex-1">
                    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h2 class="font-display text-xl font-semibold text-success">
                                Prioritas Akhir
                            </h2>
                            <p class="mt-1 text-sm text-neutral/65">
                                Skor 70 atau lebih. Progres guru sudah baik dan dapat dipantau berkala.
                            </p>
                        </div>

                        <span class="badge badge-success self-start sm:self-auto">
                            {{ $akhirCount }} Guru
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="collapse-content px-5 pb-5 sm:px-6 sm:pb-6">
            @forelse($prioritasAkhir as $data)
                @include('admin.monitoring.partials.guru-card', [
                    'data' => $data,
                    'periode' => $periode,
                    'tone' => 'success',
                    'label' => 'Progres Baik',
                ])
            @empty
                <div class="rounded-2xl border border-dashed border-success/25 bg-success/5 px-5 py-8 text-center">
                    <span class="material-icons text-4xl text-neutral/35">groups</span>
                    <p class="font-display mt-2 text-lg font-semibold text-neutral">Belum ada guru pada kategori ini</p>
                    <p class="mt-1 text-sm text-neutral/60">Guru akan muncul setelah skor monitoring mencapai 70 atau lebih.</p>
                </div>
            @endforelse
        </div>
    </section>
</div>
@endsection