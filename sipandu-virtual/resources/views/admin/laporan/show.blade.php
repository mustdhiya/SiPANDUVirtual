@extends('layouts.admin')

@section('title', 'Laporan Triwulan ' . $periode->nomor)

@section('content')
@php
    $totalGuru = (int) ($stats['total_guru'] ?? 0);
    $sudahSubmit = (int) ($stats['sudah_submit'] ?? 0);
    $belumSubmit = (int) ($stats['belum_submit'] ?? 0);
    $lengkap = (int) ($stats['lengkap'] ?? 0);
    $revisi = (int) ($stats['revisi'] ?? 0);

    $progressSubmit = $totalGuru > 0
        ? min(100, round(($sudahSubmit / $totalGuru) * 100))
        : 0;

    $progressLengkap = $totalGuru > 0
        ? min(100, round(($lengkap / $totalGuru) * 100))
        : 0;
@endphp

<div class="space-y-7">

    {{-- Header --}}
    <section class="flex flex-col gap-4 border-b border-base-300 pb-5 xl:flex-row xl:items-end xl:justify-between">
        <div>
            <div class="flex flex-wrap items-center gap-2">
                <a
                    href="{{ route('admin.laporan.index') }}"
                    class="btn btn-sm btn-ghost rounded-xl"
                >
                    <span class="material-icons text-base">arrow_back</span>
                    Kembali
                </a>

                @if($periode->is_open)
                    <span class="badge badge-success">Triwulan Dibuka</span>
                @else
                    <span class="badge badge-ghost">Triwulan Ditutup</span>
                @endif
            </div>

            <p class="mt-4 text-xs font-bold uppercase tracking-[0.14em] text-secondary">
                Rekap Pendampingan
            </p>

            <h1 class="font-display mt-1 text-3xl font-semibold text-neutral">
                Laporan Triwulan {{ $periode->nomor }}
            </h1>

            <p class="mt-2 text-sm leading-6 text-neutral/60">
                Tahun Ajaran <strong class="font-semibold text-neutral">{{ $periode->tahunAjaran->label }}</strong>
                <span class="mx-1">•</span>
                {{ $periode->tema }}
            </p>
        </div>

        <div class="flex flex-col gap-2 sm:flex-row">
            <a
                href="{{ route('admin.laporan.export-excel', $periode->id) }}"
                class="btn btn-success rounded-xl"
            >
                <span class="material-icons text-base">table_view</span>
                Export Excel
            </a>

            <a
                href="{{ route('admin.laporan.export-pdf', $periode->id) }}"
                class="btn btn-error rounded-xl"
            >
                <span class="material-icons text-base">picture_as_pdf</span>
                Export PDF
            </a>
        </div>
    </section>

    {{-- Status dan progress --}}
    <section class="grid gap-4 lg:grid-cols-[1.25fr_0.75fr]">

        <article class="rounded-3xl border border-primary/10 bg-primary p-5 text-primary-content shadow-sm sm:p-6">
            <div class="flex flex-col gap-5 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <p class="flex items-center gap-2 text-xs font-bold uppercase tracking-[0.14em] text-primary-content/70">
                        <span class="material-icons text-base">insights</span>
                        Tingkat Penyelesaian
                    </p>

                    <h2 class="font-display mt-2 text-2xl font-semibold">
                        {{ $progressSubmit }}% guru sudah mengirim submission
                    </h2>

                    <p class="mt-2 max-w-xl text-sm leading-6 text-primary-content/80">
                        Dari {{ $totalGuru }} guru binaan, terdapat {{ $sudahSubmit }} guru yang telah mengirim dokumen pada Triwulan {{ $periode->nomor }}.
                    </p>
                </div>

                <div class="rounded-2xl border border-white/15 bg-white/10 px-4 py-3 text-center">
                    <p class="text-xs font-semibold text-primary-content/70">Deadline</p>
                    <p class="font-display mt-1 text-lg font-semibold">
                        {{ $periode->deadline?->translatedFormat('d M Y') ?? '-' }}
                    </p>
                </div>
            </div>

            <div class="mt-5">
                <div class="mb-2 flex items-center justify-between text-xs font-semibold text-primary-content/75">
                    <span>Submission diterima</span>
                    <span>{{ $sudahSubmit }} dari {{ $totalGuru }} guru</span>
                </div>

                <progress
                    class="progress progress-secondary h-3 w-full"
                    value="{{ $progressSubmit }}"
                    max="100"
                ></progress>
            </div>
        </article>

        <article class="rounded-3xl border border-base-300 bg-base-200 p-5 shadow-sm sm:p-6">
            <div class="flex items-center gap-3">
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-secondary/15 text-secondary">
                    <span class="material-icons">task_alt</span>
                </div>

                <div>
                    <p class="text-sm font-semibold text-neutral">Submission Lengkap</p>
                    <p class="text-xs text-neutral/60">Sudah selesai direview admin</p>
                </div>
            </div>

            <p class="font-display mt-5 text-4xl font-semibold text-primary">
                {{ $lengkap }}
                <span class="text-xl text-neutral/55">guru</span>
            </p>

            <div class="mt-4">
                <div class="mb-2 flex items-center justify-between text-xs font-semibold text-neutral/60">
                    <span>Progress lengkap</span>
                    <span>{{ $progressLengkap }}%</span>
                </div>

                <progress
                    class="progress progress-primary h-3 w-full"
                    value="{{ $progressLengkap }}"
                    max="100"
                ></progress>
            </div>
        </article>
    </section>

    {{-- Statistik --}}
    <section>
        <div class="mb-4">
            <p class="text-xs font-bold uppercase tracking-[0.14em] text-secondary">
                Statistik Ringkas
            </p>

            <h2 class="font-display mt-1 text-2xl font-semibold text-neutral">
                Status Submission Guru
            </h2>
        </div>

        <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-5 sm:gap-4">

            <article class="rounded-2xl border border-base-300 bg-base-100 p-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="material-icons text-primary">groups</span>
                    <span class="text-[11px] font-bold uppercase tracking-wide text-neutral/45">Total</span>
                </div>

                <p class="mt-5 text-sm text-neutral/60">Guru Binaan</p>

                <p class="font-display mt-1 text-3xl font-semibold text-primary">
                    {{ $totalGuru }}
                </p>
            </article>

            <article class="rounded-2xl border border-base-300 bg-base-100 p-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="material-icons text-info">upload_file</span>
                    <span class="text-[11px] font-bold uppercase tracking-wide text-neutral/45">Masuk</span>
                </div>

                <p class="mt-5 text-sm text-neutral/60">Sudah Submit</p>

                <p class="font-display mt-1 text-3xl font-semibold text-info">
                    {{ $sudahSubmit }}
                </p>
            </article>

            <article class="rounded-2xl border border-base-300 bg-base-100 p-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="material-icons text-error">person_off</span>
                    <span class="text-[11px] font-bold uppercase tracking-wide text-neutral/45">Belum</span>
                </div>

                <p class="mt-5 text-sm text-neutral/60">Belum Submit</p>

                <p class="font-display mt-1 text-3xl font-semibold text-error">
                    {{ $belumSubmit }}
                </p>
            </article>

            <article class="rounded-2xl border border-base-300 bg-base-100 p-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="material-icons text-success">verified</span>
                    <span class="text-[11px] font-bold uppercase tracking-wide text-neutral/45">Final</span>
                </div>

                <p class="mt-5 text-sm text-neutral/60">Lengkap</p>

                <p class="font-display mt-1 text-3xl font-semibold text-success">
                    {{ $lengkap }}
                </p>
            </article>

            <article class="rounded-2xl border border-base-300 bg-base-100 p-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="material-icons text-warning">rate_review</span>
                    <span class="text-[11px] font-bold uppercase tracking-wide text-neutral/45">Tindak Lanjut</span>
                </div>

                <p class="mt-5 text-sm text-neutral/60">Perlu Revisi</p>

                <p class="font-display mt-1 text-3xl font-semibold text-warning">
                    {{ $revisi }}
                </p>
            </article>
        </div>
    </section>

    {{-- Tabel --}}
    <section>
        <div class="mb-4 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.14em] text-secondary">
                    Rekap Guru
                </p>

                <h2 class="font-display mt-1 text-2xl font-semibold text-neutral">
                    Detail Submission
                </h2>
            </div>

            <p class="text-sm text-neutral/55">
                {{ $totalGuru }} guru tercatat pada laporan ini.
            </p>
        </div>

        <div class="overflow-hidden rounded-2xl border border-base-300 bg-base-100 shadow-sm">
            <div class="overflow-x-auto">
                <table class="table table-zebra w-full">
                    <thead class="bg-base-200 text-neutral">
                        <tr>
                            <th class="w-14 text-center">No</th>
                            <th>Guru dan Sekolah</th>
                            <th>Jabatan</th>
                            <th>Status Submission</th>
                            <th>Tanggal Submit</th>
                            <th>Feedback Admin</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($gurus as $index => $guru)
                            @php
                                $submission = $guru->submissions->firstWhere('periode_id', $periode->id);

                                $statusClass = match($submission?->status_review) {
                                    'lengkap' => 'badge-success',
                                    'revisi' => 'badge-warning',
                                    'submitted' => 'badge-info',
                                    'draft' => 'badge-ghost',
                                    default => 'badge-error',
                                };

                                $statusLabel = match($submission?->status_review) {
                                    'lengkap' => 'Lengkap',
                                    'revisi' => 'Perlu Revisi',
                                    'submitted' => 'Menunggu Review',
                                    'draft' => 'Draft',
                                    default => 'Belum Submit',
                                };

                                $statusIcon = match($submission?->status_review) {
                                    'lengkap' => 'verified',
                                    'revisi' => 'edit_note',
                                    'submitted' => 'pending_actions',
                                    'draft' => 'edit',
                                    default => 'person_off',
                                };

                                $jabatan = $guru->status_jabatan === 'GURU_KEPSEK'
                                    ? 'Guru PAI + Kepala Sekolah'
                                    : 'Guru PAI';
                            @endphp

                            <tr>
                                <td class="text-center font-semibold text-neutral/55">
                                    {{ $index + 1 }}
                                </td>

                                <td>
                                    <div class="flex min-w-56 items-center gap-3">
                                        <div class="avatar placeholder">
                                            <div class="w-9 rounded-full bg-primary/10 text-primary">
                                                <span class="text-xs font-bold">
                                                    {{ strtoupper(substr($guru->nama_lengkap, 0, 1)) }}
                                                </span>
                                            </div>
                                        </div>

                                        <div>
                                            <p class="font-semibold text-neutral">
                                                {{ $guru->nama_lengkap }}
                                            </p>
                                            <p class="mt-0.5 text-xs text-neutral/60">
                                                {{ $guru->sekolah->nama_sekolah ?? 'Sekolah belum diatur' }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <span class="text-sm text-neutral/70">
                                        {{ $jabatan }}
                                    </span>
                                </td>

                                <td>
                                    <span class="badge {{ $statusClass }} gap-1 whitespace-nowrap">
                                        <span class="material-icons text-[14px]">{{ $statusIcon }}</span>
                                        {{ $statusLabel }}
                                    </span>
                                </td>

                                <td class="whitespace-nowrap text-sm text-neutral/65">
                                    {{ $submission?->submitted_at?->translatedFormat('d M Y, H:i') ?? '-' }}
                                </td>

                                <td>
                                    @if($submission?->feedback_admin)
                                        <p class="max-w-xs whitespace-normal text-sm leading-5 text-neutral/65">
                                            {{ $submission->feedback_admin }}
                                        </p>
                                    @else
                                        <span class="text-sm text-neutral/45">Belum ada feedback</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="py-10 text-center">
                                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-base-200 text-neutral/45">
                                            <span class="material-icons text-2xl">groups</span>
                                        </div>

                                        <p class="font-display mt-3 text-lg font-semibold text-neutral">
                                            Belum Ada Data Guru
                                        </p>

                                        <p class="mt-1 text-sm text-neutral/60">
                                            Tambahkan data guru binaan untuk memulai laporan triwulan.
                                        </p>

                                        <a href="{{ route('admin.guru.create') }}" class="btn btn-primary btn-sm mt-4 rounded-xl">
                                            <span class="material-icons text-base">person_add</span>
                                            Tambah Guru Binaan
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
@endsection