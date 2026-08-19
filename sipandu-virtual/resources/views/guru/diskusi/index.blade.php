@extends('layouts.guru')

@section('title', 'Ruang Diskusi')

@section('content')
@php
    $totalPeriode = $periodes->count();
    $periodeTerbuka = $periodes->where('is_open', true)->count();
@endphp

<div class="max-w-6xl mx-auto">
    <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between mb-6">
        <div>
            <div class="text-sm font-bold tracking-wide uppercase text-secondary">
                Pendampingan & Komunikasi
            </div>
            <h1 class="font-display text-3xl font-semibold mt-1">
                Ruang Diskusi
            </h1>
            <p class="text-neutral/60 mt-1">
                Pilih triwulan untuk membaca diskusi atau mengajukan pertanyaan kepada pengawas.
            </p>
        </div>

        <a href="{{ route('guru.triwulan.index') }}" class="btn btn-outline btn-primary gap-2">
            <span class="material-icons">upload_file</span>
            Buka Triwulan
        </a>
    </div>

    <div class="alert alert-info mb-6">
        <span class="material-icons">forum</span>
        <div>
            <strong>Gunakan ruang diskusi untuk kebutuhan pendampingan.</strong>
            <div class="text-sm">
                Tulis pertanyaan dengan judul yang jelas agar pengawas dapat memberikan tanggapan yang tepat.
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-7">
        <div class="stat bg-base-100 border border-base-300 rounded-2xl p-4">
            <div class="stat-figure text-primary">
                <span class="material-icons">date_range</span>
            </div>
            <div class="stat-title">Total Triwulan</div>
            <div class="stat-value text-primary text-2xl">{{ $totalPeriode }}</div>
        </div>

        <div class="stat bg-base-100 border border-base-300 rounded-2xl p-4">
            <div class="stat-figure text-success">
                <span class="material-icons">lock_open</span>
            </div>
            <div class="stat-title">Triwulan Terbuka</div>
            <div class="stat-value text-success text-2xl">{{ $periodeTerbuka }}</div>
        </div>
    </div>

    <div class="mb-4">
        <h2 class="font-display text-2xl font-semibold">Pilih Triwulan</h2>
        <p class="text-sm text-neutral/60">
            Diskusi disimpan terpisah pada masing-masing periode triwulan.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($periodes as $periode)
            <article class="card bg-base-100 border border-base-300 hover:shadow-lg hover:-translate-y-0.5 transition-all">
                <div class="card-body">
                    <div class="flex items-start justify-between gap-3">
                        <div class="w-12 h-12 rounded-xl bg-base-200 flex items-center justify-center">
                            <span class="material-icons text-primary">forum</span>
                        </div>

                        @if($periode->is_open)
                            <span class="badge badge-success gap-1">
                                <span class="material-icons text-xs">lock_open</span>
                                Terbuka
                            </span>
                        @else
                            <span class="badge badge-ghost gap-1">
                                <span class="material-icons text-xs">lock</span>
                                Tertutup
                            </span>
                        @endif
                    </div>

                    <div class="mt-3">
                        <p class="text-sm text-secondary font-bold">
                            {{ $periode->tahunAjaran->label }}
                        </p>
                        <h3 class="card-title font-display text-xl">
                            Triwulan {{ $periode->nomor }}
                        </h3>
                        <p class="text-sm text-neutral/60 mt-2 min-h-[48px]">
                            {{ $periode->tema }}
                        </p>
                    </div>

                    <div class="flex items-center justify-between gap-3 pt-3 mt-2 border-t border-base-300">
                        <span class="text-xs text-neutral/50">
                            Deadline: {{ $periode->deadline->format('d M Y') }}
                        </span>

                        <a href="{{ route('guru.diskusi.show', $periode->id) }}" class="btn btn-primary btn-sm gap-1">
                            <span class="material-icons text-base">chat</span>
                            Buka
                        </a>
                    </div>
                </div>
            </article>
        @empty
            <div class="col-span-full">
                <div class="card bg-base-100 border border-base-300">
                    <div class="card-body items-center text-center py-14">
                        <span class="material-icons text-6xl text-neutral/25">forum</span>
                        <h2 class="font-display text-2xl font-semibold mt-3">
                            Belum ada triwulan
                        </h2>
                        <p class="text-neutral/60 max-w-md">
                            Ruang diskusi akan tersedia setelah admin membuat periode triwulan.
                        </p>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection