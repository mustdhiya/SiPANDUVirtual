@extends('layouts.admin')

@section('title', 'Review Triwulan')

@section('content')
@php
    $totalSubmission = $submissions->count();
    $menungguReview = $submissions->where('status_review', 'submitted')->count();
    $perluRevisi = $submissions->where('status_review', 'revisi')->count();
    $lengkap = $submissions->where('status_review', 'lengkap')->count();

    $statusConfig = [
        'draft' => [
            'label' => 'Draft',
            'class' => 'badge-ghost',
            'icon' => 'edit_note',
        ],
        'submitted' => [
            'label' => 'Menunggu Review',
            'class' => 'badge-info',
            'icon' => 'pending_actions',
        ],
        'revisi' => [
            'label' => 'Perlu Revisi',
            'class' => 'badge-warning',
            'icon' => 'edit',
        ],
        'lengkap' => [
            'label' => 'Lengkap',
            'class' => 'badge-success',
            'icon' => 'check_circle',
        ],
    ];
@endphp

<div class="mx-auto max-w-7xl space-y-8">

    {{-- Header --}}
    <section class="flex flex-col gap-4 border-b border-base-300 pb-6 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.14em] text-secondary">
                Pendampingan Guru
            </p>

            <h1 class="font-display mt-2 text-3xl font-semibold text-base-content md:text-4xl">
                Review Triwulan
            </h1>

            <p class="mt-2 max-w-2xl text-sm leading-6 text-base-content/70">
                Periksa submission dan dokumen guru, beri catatan jika perlu revisi,
                lalu tetapkan status akhir submission.
            </p>
        </div>

        <a
            href="{{ route('admin.monitoring.index') }}"
            class="btn btn-outline btn-primary rounded-xl"
        >
            <span class="material-icons">analytics</span>
            Buka Monitoring SIAGA
        </a>
    </section>

    {{-- Ringkasan --}}
    <section class="grid grid-cols-2 gap-3 sm:grid-cols-4 sm:gap-4">

        <article class="rounded-2xl border border-base-300 bg-base-100 p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="material-icons text-primary">assignment</span>
                <span class="text-[11px] font-bold uppercase tracking-wide text-base-content/50">
                    Total
                </span>
            </div>

            <p class="mt-5 text-sm text-base-content/70">
                Semua Submission
            </p>

            <p class="font-display mt-1 text-3xl font-semibold text-primary">
                {{ $totalSubmission }}
            </p>
        </article>

        <article class="rounded-2xl border border-info/30 bg-info/10 p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="material-icons text-info">pending_actions</span>
                <span class="text-[11px] font-bold uppercase tracking-wide text-info">
                    Prioritas
                </span>
            </div>

            <p class="mt-5 text-sm text-base-content/70">
                Menunggu Review
            </p>

            <p class="font-display mt-1 text-3xl font-semibold text-info">
                {{ $menungguReview }}
            </p>
        </article>

        <article class="rounded-2xl border border-warning/30 bg-warning/10 p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="material-icons text-warning">edit</span>
                <span class="text-[11px] font-bold uppercase tracking-wide text-warning">
                    Tindak Lanjut
                </span>
            </div>

            <p class="mt-5 text-sm text-base-content/70">
                Perlu Revisi
            </p>

            <p class="font-display mt-1 text-3xl font-semibold text-warning">
                {{ $perluRevisi }}
            </p>
        </article>

        <article class="rounded-2xl border border-success/30 bg-success/10 p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="material-icons text-success">check_circle</span>
                <span class="text-[11px] font-bold uppercase tracking-wide text-success">
                    Selesai
                </span>
            </div>

            <p class="mt-5 text-sm text-base-content/70">
                Submission Lengkap
            </p>

            <p class="font-display mt-1 text-3xl font-semibold text-success">
                {{ $lengkap }}
            </p>
        </article>
    </section>

    {{-- Informasi prioritas --}}
    @if($menungguReview > 0)
        <section class="alert rounded-2xl border border-info/30 bg-info/10 text-base-content shadow-sm">
            <span class="material-icons text-info">info</span>

            <div>
                <p class="font-semibold">
                    Ada {{ $menungguReview }} submission yang perlu diperiksa.
                </p>

                <p class="mt-1 text-sm text-base-content/75">
                    Buka detail submission, periksa dokumen guru satu per satu,
                    lalu pilih status “Lengkap” atau “Perlu Revisi”.
                </p>
            </div>
        </section>
    @endif

    {{-- Daftar Submission --}}
    <section class="overflow-hidden rounded-2xl border border-base-300 bg-base-100 shadow-sm">
        <div class="flex flex-col gap-3 border-b border-base-300 px-5 py-5 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="font-display text-xl font-semibold text-base-content">
                    Daftar Submission Guru
                </h2>

                <p class="mt-1 text-sm text-base-content/70">
                    Submission terbaru tampil lebih dulu.
                </p>
            </div>

            <span class="badge badge-outline gap-2 self-start sm:self-auto">
                <span class="material-icons text-sm">sort</span>
                Urut berdasarkan waktu submit
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="table w-full">
                <thead class="bg-base-200 text-base-content/70">
                    <tr>
                        <th class="w-12">No.</th>
                        <th>Guru dan Sekolah</th>
                        <th>Periode</th>
                        <th>Status</th>
                        <th>Waktu Submit</th>
                        <th class="text-right">Aksi</th>
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

                            $initials = collect(explode(' ', trim($submission->guru->nama_lengkap)))
                                ->filter()
                                ->take(2)
                                ->map(fn ($name) => strtoupper(substr($name, 0, 1)))
                                ->implode('');
                        @endphp

                        <tr class="{{ $isPriority ? 'bg-info/10' : '' }} hover:bg-base-200">
                            <td class="font-semibold text-base-content/60">
                                {{ $index + 1 }}
                            </td>

                            <td>
                                <div class="flex min-w-56 items-center gap-3">
                                    <div class="avatar placeholder">
                                        <div class="w-10 rounded-full bg-primary/15 text-primary">
                                            <span class="text-sm font-bold">
                                                {{ $initials ?: 'G' }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="min-w-0">
                                        <p class="font-semibold text-base-content">
                                            {{ $submission->guru->nama_lengkap }}
                                        </p>

                                        <p class="max-w-56 truncate text-xs text-base-content/60">
                                            {{ $submission->guru->sekolah->nama_sekolah ?? 'Sekolah belum diatur' }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <p class="font-semibold text-sm text-base-content">
                                    TW {{ $submission->periode->nomor }}
                                </p>

                                <p class="text-xs text-base-content/60">
                                    {{ $submission->periode->tahunAjaran->label ?? '-' }}
                                </p>
                            </td>

                            <td>
                                <span class="badge {{ $status['class'] }} gap-1 whitespace-nowrap">
                                    <span class="material-icons text-sm">
                                        {{ $status['icon'] }}
                                    </span>
                                    {{ $status['label'] }}
                                </span>
                            </td>

                            <td>
                                @if($submission->submitted_at)
                                    <p class="text-sm font-medium text-base-content">
                                        {{ $submission->submitted_at->translatedFormat('d M Y') }}
                                    </p>

                                    <p class="text-xs text-base-content/60">
                                        {{ $submission->submitted_at->format('H:i') }} WITA
                                    </p>
                                @else
                                    <span class="text-sm text-base-content/60">
                                        Belum dikirim
                                    </span>
                                @endif
                            </td>

                            <td class="text-right">
                                <a
                                    href="{{ route('admin.review-triwulan.show', $submission->id) }}"
                                    class="btn btn-sm {{ $isPriority ? 'btn-primary' : 'btn-outline btn-primary' }} rounded-xl"
                                >
                                    <span class="material-icons text-base">
                                        {{ $isPriority ? 'fact_check' : 'visibility' }}
                                    </span>

                                    <span class="hidden sm:inline">
                                        {{ $isPriority ? 'Review Sekarang' : 'Buka' }}
                                    </span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="flex flex-col items-center justify-center py-14 text-center">
                                    <div class="mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-base-200 text-primary">
                                        <span class="material-icons text-3xl">
                                            assignment_turned_in
                                        </span>
                                    </div>

                                    <h3 class="font-display text-xl font-semibold text-base-content">
                                        Belum ada submission
                                    </h3>

                                    <p class="mt-2 max-w-sm text-sm leading-6 text-base-content/70">
                                        Submission triwulan dari guru akan muncul di halaman ini setelah dikirim.
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection