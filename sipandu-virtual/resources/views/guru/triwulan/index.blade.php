@extends('layouts.guru')

@section('title', 'Laporan Triwulan Saya')

@section('content')
@php
    $totalPeriode = $periodes->count();
    $totalLengkap = $submissions->where('status_review', 'lengkap')->count();
    $totalRevisi = $submissions->where('status_review', 'revisi')->count();
    $totalMenunggu = $submissions->where('status_review', 'submitted')->count();

    $statusMap = [
        'draft' => [
            'label' => 'Belum Dikirim',
            'badge' => 'badge-ghost border border-base-300',
            'icon' => 'edit_note',
        ],
        'submitted' => [
            'label' => 'Menunggu Diperiksa',
            'badge' => 'badge-info',
            'icon' => 'hourglass_top',
        ],
        'revisi' => [
            'label' => 'Perlu Perbaikan',
            'badge' => 'badge-warning',
            'icon' => 'edit',
        ],
        'lengkap' => [
            'label' => 'Sudah Lengkap',
            'badge' => 'badge-success',
            'icon' => 'verified',
        ],
    ];
@endphp

<div class="mx-auto max-w-6xl space-y-7">

    {{-- Header --}}
    <section class="rounded-2xl border-2 border-base-300 bg-base-100 p-6 shadow-sm">
        <span class="badge badge-primary mb-2">Pelaporan Per Triwulan</span>
        <h1 class="text-2xl font-extrabold text-base-content sm:text-3xl">
            Laporan Triwulan Saya
        </h1>
        <p class="mt-2 text-base text-base-content/80">
            Pilih periode triwulan di bawah ini untuk melihat daftar dokumen wajib, mengunggah berkas, dan mengirim laporan ke Pengawas.
        </p>
    </section>

    {{-- Ringkasan Status --}}
    <section class="grid grid-cols-2 gap-4 lg:grid-cols-4">
        <div class="rounded-2xl border-2 border-base-300 bg-base-100 p-5 shadow-sm">
            <p class="text-sm font-bold text-base-content/80">Total Triwulan</p>
            <p class="mt-2 text-3xl font-extrabold text-primary">{{ $totalPeriode }}</p>
        </div>
        <div class="rounded-2xl border-2 border-base-300 bg-base-100 p-5 shadow-sm">
            <p class="text-sm font-bold text-base-content/80">Menunggu Diperiksa</p>
            <p class="mt-2 text-3xl font-extrabold text-info">{{ $totalMenunggu }}</p>
        </div>
        <div class="rounded-2xl border-2 border-base-300 bg-base-100 p-5 shadow-sm">
            <p class="text-sm font-bold text-base-content/80">Perlu Perbaikan</p>
            <p class="mt-2 text-3xl font-extrabold text-warning">{{ $totalRevisi }}</p>
        </div>
        <div class="rounded-2xl border-2 border-base-300 bg-base-100 p-5 shadow-sm">
            <p class="text-sm font-bold text-base-content/80">Sudah Lengkap</p>
            <p class="mt-2 text-3xl font-extrabold text-success">{{ $totalLengkap }}</p>
        </div>
    </section>

    @if($totalRevisi > 0)
        <section class="rounded-2xl border-2 border-warning bg-warning/10 p-5">
            <div class="flex items-start gap-3">
                <span class="material-icons text-3xl text-warning">priority_high</span>
                <div>
                    <p class="text-lg font-extrabold text-warning">Ada {{ $totalRevisi }} triwulan yang perlu diperbaiki.</p>
                    <p class="mt-1 text-base text-base-content">
                        Tekan tombol <strong>Perbaiki Laporan</strong> pada kartu bertanda <strong>Perlu Perbaikan</strong> di bawah ini.
                    </p>
                </div>
            </div>
        </section>
    @endif

    {{-- Daftar Kartu Triwulan --}}
    <section class="grid grid-cols-1 gap-5 md:grid-cols-2">
        @forelse($periodes as $periode)
            @php
                $submission = $submissions->firstWhere('periode_id', $periode->id);
                $statusKey = $submission?->status_review ?? 'draft';
                $status = $statusMap[$statusKey] ?? $statusMap['draft'];
                $isAccessible = $periode->is_open && now()->startOfDay()->lte($periode->deadline);
                $isDeadlinePassed = now()->startOfDay()->gt($periode->deadline);
            @endphp

            <article class="flex flex-col justify-between rounded-2xl border-2 {{ $statusKey === 'revisi' ? 'border-warning' : 'border-base-300' }} bg-base-100 p-6 shadow-sm">
                <div class="space-y-4">
                    <div class="flex flex-wrap items-start justify-between gap-3">
                        <div>
                            <p class="text-xs font-extrabold uppercase tracking-wider text-secondary">
                                {{ $periode->tahunAjaran->label }}
                            </p>
                            <h2 class="mt-1 text-2xl font-extrabold text-base-content">
                                Triwulan {{ $periode->nomor }}
                            </h2>
                        </div>

                        <span class="badge {{ $status['badge'] }} badge-lg gap-1.5">
                            <span class="material-icons text-base">{{ $status['icon'] }}</span>
                            {{ $status['label'] }}
                        </span>
                    </div>

                    <p class="text-base font-semibold text-base-content">
                        {{ $periode->tema }}
                    </p>

                    <div class="flex items-center gap-2 text-base text-base-content/85">
                        <span class="material-icons text-secondary">event</span>
                        <span>Batas Akhir: <strong>{{ $periode->deadline->translatedFormat('d F Y') }}</strong></span>
                    </div>

                    <div class="rounded-xl border border-base-300 bg-base-200 p-4">
                        @if($isAccessible)
                            <div class="flex items-start gap-2.5">
                                <span class="material-icons text-2xl text-success">lock_open</span>
                                <div>
                                    <p class="font-bold text-success">Periode Sedang Dibuka</p>
                                    <p class="text-sm text-base-content/80">Anda dapat mengunggah dokumen dan mengirim laporan sekarang.</p>
                                </div>
                            </div>
                        @elseif($isDeadlinePassed)
                            <div class="flex items-start gap-2.5">
                                <span class="material-icons text-2xl text-error">event_busy</span>
                                <div>
                                    <p class="font-bold text-error">Batas Waktu Sudah Lewat</p>
                                    <p class="text-sm text-base-content/80">Hubungi Pengawas PAI jika Anda masih perlu melengkapi berkas.</p>
                                </div>
                            </div>
                        @else
                            <div class="flex items-start gap-2.5">
                                <span class="material-icons text-2xl text-warning">lock</span>
                                <div>
                                    <p class="font-bold text-warning">Periode Belum Dibuka</p>
                                    <p class="text-sm text-base-content/80">Mohon tunggu sampai Pengawas membuka periode triwulan ini.</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="mt-6">
                    <a href="{{ route('guru.triwulan.show', $periode->id) }}"
                       class="btn {{ $statusKey === 'revisi' ? 'btn-warning' : 'btn-primary' }} btn-lg w-full">
                        <span class="material-icons text-2xl">
                            {{ $statusKey === 'revisi' ? 'edit' : 'folder_open' }}
                        </span>
                        {{ $statusKey === 'revisi' ? 'Perbaiki Laporan' : 'Buka & Unggah Dokumen' }}
                    </a>
                </div>
            </article>
        @empty
            <div class="col-span-full rounded-2xl border-2 border-dashed border-base-300 bg-base-100 p-12 text-center">
                <span class="material-icons text-5xl text-base-content/40">event_busy</span>
                <h2 class="mt-3 text-xl font-extrabold text-base-content">Belum Ada Jadwal Triwulan</h2>
                <p class="mx-auto mt-2 max-w-md text-base text-base-content/80">
                    Jadwal triwulan akan tampil di sini setelah dibuka oleh Admin Utama / Pengawas PAI.
                </p>
            </div>
        @endforelse
    </section>
</div>
@endsection
