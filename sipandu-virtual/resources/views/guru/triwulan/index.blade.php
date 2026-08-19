@extends('layouts.guru')

@section('title', 'Triwulan Saya')

@section('content')
@php
    $totalPeriode = $periodes->count();

    $totalLengkap = $submissions->where('status_review', 'lengkap')->count();

    $totalRevisi = $submissions->where('status_review', 'revisi')->count();

    $totalMenunggu = $submissions->where('status_review', 'submitted')->count();

    $statusMap = [
        'draft' => [
            'label' => 'Belum Dikirim',
            'badge' => 'badge-ghost',
            'icon' => 'edit_note',
        ],
        'submitted' => [
            'label' => 'Menunggu Review',
            'badge' => 'badge-info',
            'icon' => 'hourglass_top',
        ],
        'revisi' => [
            'label' => 'Perlu Revisi',
            'badge' => 'badge-warning',
            'icon' => 'edit',
        ],
        'lengkap' => [
            'label' => 'Lengkap',
            'badge' => 'badge-success',
            'icon' => 'verified',
        ],
    ];
@endphp

<div class="max-w-6xl mx-auto">

    <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between mb-6">
        <div>
            <div class="text-sm font-bold tracking-wide uppercase text-secondary">
                Pendampingan
            </div>

            <h1 class="font-display text-3xl font-semibold mt-1">
                Triwulan Saya
            </h1>

            <p class="text-neutral/60 mt-1">
                Pilih triwulan untuk melihat dokumen wajib, mengunggah berkas, atau memperbaiki dokumen.
            </p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success shadow-sm mb-5">
            <span class="material-icons">check_circle</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error shadow-sm mb-5">
            <span class="material-icons">error</span>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-7">

        <div class="stat bg-base-100 border border-base-300 rounded-2xl p-4">
            <div class="stat-figure text-primary">
                <span class="material-icons">date_range</span>
            </div>
            <div class="stat-title">Total Triwulan</div>
            <div class="stat-value text-primary text-2xl">{{ $totalPeriode }}</div>
        </div>

        <div class="stat bg-base-100 border border-base-300 rounded-2xl p-4">
            <div class="stat-figure text-info">
                <span class="material-icons">hourglass_top</span>
            </div>
            <div class="stat-title">Menunggu Review</div>
            <div class="stat-value text-info text-2xl">{{ $totalMenunggu }}</div>
        </div>

        <div class="stat bg-base-100 border border-base-300 rounded-2xl p-4">
            <div class="stat-figure text-warning">
                <span class="material-icons">edit_note</span>
            </div>
            <div class="stat-title">Perlu Revisi</div>
            <div class="stat-value text-warning text-2xl">{{ $totalRevisi }}</div>
        </div>

        <div class="stat bg-base-100 border border-base-300 rounded-2xl p-4">
            <div class="stat-figure text-success">
                <span class="material-icons">verified</span>
            </div>
            <div class="stat-title">Lengkap</div>
            <div class="stat-value text-success text-2xl">{{ $totalLengkap }}</div>
        </div>
    </div>

    @if($totalRevisi > 0)
        <div class="alert alert-warning mb-6">
            <span class="material-icons">priority_high</span>
            <div>
                <strong>Ada {{ $totalRevisi }} triwulan yang perlu diperbaiki.</strong>
                <div class="text-sm">
                    Buka triwulan dengan status “Perlu Revisi” untuk melihat catatan dari pengawas.
                </div>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
        @forelse($periodes as $periode)
            @php
                $submission = $submissions->firstWhere('periode_id', $periode->id);

                $statusKey = $submission?->status_review ?? 'draft';

                $status = $statusMap[$statusKey] ?? $statusMap['draft'];

                $isAccessible = $periode->is_open && now()->startOfDay()->lte($periode->deadline);

                $isDeadlinePassed = now()->startOfDay()->gt($periode->deadline);

                $cardClass = $isAccessible
                    ? 'bg-base-100 border-base-300'
                    : 'bg-base-200 border-base-300 opacity-90';
            @endphp

            <article class="card {{ $cardClass }} border shadow-sm">
                <div class="card-body gap-4">

                    <div class="flex items-start justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-xl bg-base-300 flex items-center justify-center">
                                <span class="material-icons text-primary">calendar_month</span>
                            </div>

                            <div>
                                <p class="text-xs font-bold text-secondary uppercase tracking-wide">
                                    {{ $periode->tahunAjaran->label }}
                                </p>

                                <h2 class="font-display text-xl font-semibold">
                                    Triwulan {{ $periode->nomor }}
                                </h2>
                            </div>
                        </div>

                        <span class="badge {{ $status['badge'] }} gap-1">
                            <span class="material-icons text-xs">{{ $status['icon'] }}</span>
                            {{ $status['label'] }}
                        </span>
                    </div>

                    <div>
                        <p class="font-semibold">{{ $periode->tema }}</p>

                        <div class="mt-2 flex items-center gap-2 text-sm text-neutral/60">
                            <span class="material-icons text-base">event</span>
                            Deadline: {{ $periode->deadline->format('d M Y') }}
                        </div>
                    </div>

                    <div class="rounded-xl bg-base-200 p-3">
                        @if($isAccessible)
                            <div class="flex gap-2 items-start">
                                <span class="material-icons text-success">lock_open</span>
                                <div>
                                    <p class="text-sm font-semibold">Periode sedang dibuka</p>
                                    <p class="text-xs text-neutral/60">
                                        Anda dapat mengunggah dokumen dan mengirim submission.
                                    </p>
                                </div>
                            </div>
                        @elseif($isDeadlinePassed)
                            <div class="flex gap-2 items-start">
                                <span class="material-icons text-error">event_busy</span>
                                <div>
                                    <p class="text-sm font-semibold">Deadline telah lewat</p>
                                    <p class="text-xs text-neutral/60">
                                        Hubungi pengawas jika Anda memerlukan tindak lanjut.
                                    </p>
                                </div>
                            </div>
                        @else
                            <div class="flex gap-2 items-start">
                                <span class="material-icons text-warning">lock</span>
                                <div>
                                    <p class="text-sm font-semibold">Periode belum dibuka</p>
                                    <p class="text-xs text-neutral/60">
                                        Tunggu pengawas membuka triwulan ini.
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="card-actions justify-end">
                        <a href="{{ route('guru.triwulan.show', $periode->id) }}"
                            class="btn btn-primary btn-sm gap-1">
                            <span class="material-icons text-base">
                                {{ $statusKey === 'revisi' ? 'edit' : 'folder_open' }}
                            </span>

                            {{ $statusKey === 'revisi' ? 'Perbaiki' : 'Buka Triwulan' }}
                        </a>
                    </div>
                </div>
            </article>
        @empty
            <div class="col-span-full">
                <div class="card bg-base-100 border border-base-300">
                    <div class="card-body items-center text-center py-12">
                        <span class="material-icons text-5xl text-neutral/30">event_busy</span>
                        <h2 class="font-display text-2xl font-semibold mt-3">
                            Belum ada triwulan tersedia
                        </h2>
                        <p class="text-neutral/60 max-w-md">
                            Triwulan akan muncul setelah Pengawas PAI membuat periode pada tahun ajaran aktif.
                        </p>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection