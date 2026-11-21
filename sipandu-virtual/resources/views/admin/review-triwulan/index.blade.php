@extends('layouts.admin')

@section('title', 'Periksa Laporan Guru')

@section('content')
@php
    $totalSubmission = $totalSubmission ?? $submissions->total();
    $menungguReview = $menungguReview ?? 0;
    $perluRevisi = $perluRevisi ?? 0;
    $lengkap = $lengkap ?? 0;

    $statusConfig = [
        'draft' => [
            'label' => 'Belum Dikirim',
            'class' => 'badge-ghost border border-base-300',
            'icon' => 'edit_note',
        ],
        'submitted' => [
            'label' => 'Perlu Diperiksa',
            'class' => 'badge-info',
            'icon' => 'pending_actions',
        ],
        'revisi' => [
            'label' => 'Perlu Perbaikan',
            'class' => 'badge-warning',
            'icon' => 'edit',
        ],
        'lengkap' => [
            'label' => 'Sudah Lengkap',
            'class' => 'badge-success',
            'icon' => 'check_circle',
        ],
    ];
@endphp

<div class="mx-auto max-w-6xl space-y-6">

    {{-- Header --}}
    <section class="rounded-2xl border-2 border-base-300 bg-base-100 p-6 shadow-sm">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <span class="badge badge-primary mb-2">Pemeriksaan Triwulan</span>
                <h1 class="text-2xl font-extrabold text-base-content sm:text-3xl">
                    Periksa Laporan Guru Binaan
                </h1>
                <p class="mt-2 text-base text-base-content/80">
                    Buka berkas yang dikirim guru, beri catatan jika ada yang kurang, lalu pilih status <strong>Sudah Lengkap</strong> atau <strong>Perlu Perbaikan</strong>.
                </p>
            </div>

            <a href="{{ route('admin.monitoring.index') }}" class="btn btn-outline btn-primary border-2 shrink-0">
                <span class="material-icons text-xl">analytics</span>
                Buka Monitoring SIAGA
            </a>
        </div>
    </section>

    {{-- Ringkasan Status --}}
    <section class="grid grid-cols-2 gap-4 lg:grid-cols-4">
        <div class="rounded-2xl border-2 border-base-300 bg-base-100 p-5 shadow-sm">
            <p class="text-sm font-bold text-base-content/80">Semua Laporan</p>
            <p class="mt-2 text-3xl font-extrabold text-primary">{{ $totalSubmission }}</p>
        </div>

        <div class="rounded-2xl border-2 border-info bg-info/10 p-5 shadow-sm">
            <p class="text-sm font-bold text-info">Perlu Diperiksa</p>
            <p class="mt-2 text-3xl font-extrabold text-info">{{ $menungguReview }}</p>
        </div>

        <div class="rounded-2xl border-2 border-warning bg-warning/10 p-5 shadow-sm">
            <p class="text-sm font-bold text-warning">Perlu Perbaikan</p>
            <p class="mt-2 text-3xl font-extrabold text-warning">{{ $perluRevisi }}</p>
        </div>

        <div class="rounded-2xl border-2 border-success bg-success/10 p-5 shadow-sm">
            <p class="text-sm font-bold text-success">Sudah Lengkap</p>
            <p class="mt-2 text-3xl font-extrabold text-success">{{ $lengkap }}</p>
        </div>
    </section>

    {{-- Daftar Desktop --}}
    <section class="hidden overflow-hidden rounded-2xl border-2 border-base-300 bg-base-100 shadow-sm lg:block">
        <div class="border-b-2 border-base-300 bg-base-200 px-6 py-4">
            <h2 class="text-lg font-extrabold text-base-content">Daftar Laporan Masuk</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="table w-full">
                <thead>
                    <tr>
                        <th class="w-12">No.</th>
                        <th>Nama Guru &amp; Sekolah</th>
                        <th>Triwulan</th>
                        <th>Status</th>
                        <th>Tanggal Kirim</th>
                        <th class="text-right">Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($submissions as $index => $submission)
                        @php
                            $status = $statusConfig[$submission->status_review] ?? [
                                'label' => ucfirst($submission->status_review),
                                'class' => 'badge-ghost',
                                'icon' => 'help_outline',
                            ];
                            $isPriority = $submission->status_review === 'submitted';
                        @endphp

                        <tr class="{{ $isPriority ? 'bg-info/10' : '' }} hover:bg-base-200/70">
                            <td class="font-bold">{{ $submissions->firstItem() + $index }}</td>

                            <td>
                                <p class="text-base font-bold text-base-content">
                                    {{ $submission->guru->nama_lengkap }}
                                </p>
                                <p class="text-sm text-base-content/75">
                                    {{ $submission->guru->sekolah->nama_sekolah ?? 'Sekolah belum diatur' }}
                                </p>
                            </td>

                            <td>
                                <p class="font-bold text-base-content">Triwulan {{ $submission->periode->nomor }}</p>
                                <p class="text-xs font-medium text-base-content/75">
                                    {{ $submission->periode->tahunAjaran->label ?? '-' }}
                                </p>
                            </td>

                            <td>
                                <span class="badge {{ $status['class'] }} gap-1.5 whitespace-nowrap">
                                    <span class="material-icons text-sm">{{ $status['icon'] }}</span>
                                    {{ $status['label'] }}
                                </span>
                            </td>

                            <td>
                                @if($submission->submitted_at)
                                    <p class="font-semibold text-base-content">
                                        {{ $submission->submitted_at->translatedFormat('d M Y') }}
                                    </p>
                                    <p class="text-xs text-base-content/75">
                                        Pukul {{ $submission->submitted_at->format('H:i') }} WITA
                                    </p>
                                @else
                                    <span class="text-sm text-base-content/75">Belum dikirim</span>
                                @endif
                            </td>

                            <td class="text-right">
                                <a
                                    href="{{ route('admin.review-triwulan.show', $submission->id) }}"
                                    class="btn {{ $isPriority ? 'btn-primary' : 'btn-outline btn-primary border-2' }}"
                                >
                                    <span class="material-icons text-xl">{{ $isPriority ? 'fact_check' : 'visibility' }}</span>
                                    {{ $isPriority ? 'Periksa Sekarang' : 'Lihat Berkas' }}
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-14 text-center text-base font-semibold text-base-content/75">
                                Belum ada laporan triwulan yang masuk.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    {{-- Tampilan Kartu Mobile / Tablet --}}
    <section class="space-y-4 lg:hidden">
        @forelse($submissions as $submission)
            @php
                $status = $statusConfig[$submission->status_review] ?? [
                    'label' => ucfirst($submission->status_review),
                    'class' => 'badge-ghost',
                    'icon' => 'help_outline',
                ];
                $isPriority = $submission->status_review === 'submitted';
            @endphp

            <article class="rounded-2xl border-2 {{ $isPriority ? 'border-info bg-info/5' : 'border-base-300 bg-base-100' }} p-5 shadow-sm space-y-3">
                <div class="flex flex-wrap items-start justify-between gap-2">
                    <div>
                        <h3 class="text-lg font-extrabold text-base-content">{{ $submission->guru->nama_lengkap }}</h3>
                        <p class="text-sm text-base-content/80">{{ $submission->guru->sekolah->nama_sekolah ?? 'Sekolah belum diatur' }}</p>
                    </div>
                    <span class="badge {{ $status['class'] }} gap-1">
                        <span class="material-icons text-sm">{{ $status['icon'] }}</span>
                        {{ $status['label'] }}
                    </span>
                </div>

                <div class="rounded-xl bg-base-200 p-3 text-sm">
                    <p><strong>Periode:</strong> Triwulan {{ $submission->periode->nomor }} ({{ $submission->periode->tahunAjaran->label ?? '-' }})</p>
                    <p class="mt-1"><strong>Dikirim:</strong> {{ $submission->submitted_at ? $submission->submitted_at->translatedFormat('d M Y, H:i') . ' WITA' : 'Belum dikirim' }}</p>
                </div>

                <a href="{{ route('admin.review-triwulan.show', $submission->id) }}"
                   class="btn {{ $isPriority ? 'btn-primary' : 'btn-outline btn-primary border-2' }} w-full">
                    <span class="material-icons text-xl">{{ $isPriority ? 'fact_check' : 'visibility' }}</span>
                    {{ $isPriority ? 'Periksa Sekarang' : 'Lihat Berkas' }}
                </a>
            </article>
        @empty
            <div class="rounded-2xl border-2 border-base-300 bg-base-100 p-10 text-center text-base font-semibold">
                Belum ada laporan triwulan yang masuk.
            </div>
        @endforelse
    </section>

    <div class="flex justify-center pt-2">
        {{ $submissions->links() }}
    </div>

</div>
@endsection
