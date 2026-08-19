@extends('layouts.guru')

@section('title', 'Triwulan ' . $periode->nomor)

@section('content')
@php
    $isAccessible = $periode->is_open && now()->startOfDay()->lte($periode->deadline);

    $isDeadlinePassed = now()->startOfDay()->gt($periode->deadline);

    $totalDokumen = $dokumenWajibs->count();

    $totalSudahUpload = $uploadedDocs->count();

    $totalWajib = $dokumenWajibs->where('is_wajib', true)->count();

    $totalWajibUpload = $dokumenWajibs
        ->where('is_wajib', true)
        ->filter(fn ($dokumen) => $uploadedDocs->has($dokumen->id))
        ->count();

    $progress = $totalDokumen > 0
        ? round(($totalSudahUpload / $totalDokumen) * 100)
        : 0;

    $submissionStatus = $submission->status_review ?? 'draft';

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

    $currentStatus = $statusMap[$submissionStatus] ?? $statusMap['draft'];
@endphp

<div class="max-w-5xl mx-auto">

    <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between mb-6">
        <div class="flex gap-3">
            <a href="{{ route('guru.triwulan.index') }}"
                class="btn btn-circle btn-ghost mt-1"
                aria-label="Kembali ke daftar triwulan">
                <span class="material-icons">arrow_back</span>
            </a>

            <div>
                <div class="text-sm font-bold uppercase tracking-wide text-secondary">
                    {{ $periode->tahunAjaran->label }}
                </div>

                <h1 class="font-display text-3xl font-semibold mt-1">
                    Triwulan {{ $periode->nomor }}
                </h1>

                <p class="text-neutral/60 mt-1">{{ $periode->tema }}</p>
            </div>
        </div>

        <span class="badge {{ $currentStatus['badge'] }} badge-lg gap-2 py-4">
            <span class="material-icons text-base">{{ $currentStatus['icon'] }}</span>
            {{ $currentStatus['label'] }}
        </span>
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

    @if($submissionStatus === 'revisi')
        <div class="alert alert-warning mb-5">
            <span class="material-icons">priority_high</span>
            <div>
                <strong>Submission perlu diperbaiki.</strong>
                @if($submission->feedback_admin)
                    <div class="text-sm mt-1">
                        Catatan Pengawas: {{ $submission->feedback_admin }}
                    </div>
                @endif
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6">

        <div class="lg:col-span-2 card bg-base-200 border border-base-300 shadow-sm">
            <div class="card-body">
                <div class="flex items-start gap-3">
                    <div class="w-11 h-11 rounded-xl bg-base-100 flex items-center justify-center">
                        <span class="material-icons text-primary">event</span>
                    </div>

                    <div>
                        <h2 class="font-display text-xl font-semibold">Informasi Periode</h2>

                        <p class="text-sm text-neutral/60 mt-1">
                            Deadline pengumpulan: <strong>{{ $periode->deadline->format('d M Y') }}</strong>
                        </p>

                        @if($isAccessible)
                            <div class="flex gap-2 mt-3 text-success">
                                <span class="material-icons">lock_open</span>
                                <div>
                                    <p class="font-semibold text-sm">Triwulan sedang dibuka</p>
                                    <p class="text-xs text-neutral/60">
                                        Anda dapat mengunggah atau memperbarui dokumen.
                                    </p>
                                </div>
                            </div>
                        @elseif($isDeadlinePassed)
                            <div class="flex gap-2 mt-3 text-error">
                                <span class="material-icons">event_busy</span>
                                <div>
                                    <p class="font-semibold text-sm">Deadline telah lewat</p>
                                    <p class="text-xs text-neutral/60">
                                        Hubungi pengawas untuk tindak lanjut.
                                    </p>
                                </div>
                            </div>
                        @else
                            <div class="flex gap-2 mt-3 text-warning">
                                <span class="material-icons">lock</span>
                                <div>
                                    <p class="font-semibold text-sm">Triwulan belum dibuka</p>
                                    <p class="text-xs text-neutral/60">
                                        Dokumen belum dapat diunggah saat ini.
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="card bg-base-100 border border-base-300 shadow-sm">
            <div class="card-body">
                <div class="flex justify-between items-center">
                    <h2 class="font-display text-lg font-semibold">Kelengkapan</h2>
                    <span class="text-primary font-bold">{{ $progress }}%</span>
                </div>

                <progress class="progress progress-primary w-full" value="{{ $progress }}" max="100"></progress>

                <div class="flex justify-between text-xs text-neutral/60">
                    <span>{{ $totalSudahUpload }} dari {{ $totalDokumen }} dokumen</span>
                    <span>{{ $totalWajibUpload }}/{{ $totalWajib }} wajib</span>
                </div>
            </div>
        </div>
    </div>

    <div class="card bg-base-100 border border-base-300 shadow-sm">
        <div class="card-body">
            <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between mb-3">
                <div>
                    <h2 class="font-display text-2xl font-semibold">Dokumen Triwulan</h2>
                    <p class="text-sm text-neutral/60">
                        Unggah dokumen sesuai instruksi. Dokumen wajib harus lengkap sebelum submission dikirim.
                    </p>
                </div>

                <span class="badge badge-outline gap-1">
                    <span class="material-icons text-xs">folder</span>
                    {{ $totalSudahUpload }}/{{ $totalDokumen }} diunggah
                </span>
            </div>

            <div class="space-y-4">
                @forelse($dokumenWajibs as $index => $dokumen)
                    @php
                        $uploaded = $uploadedDocs->get($dokumen->id);

                        $uploadStatusMap = [
                            'pending' => [
                                'label' => 'Menunggu Review',
                                'badge' => 'badge-info',
                                'icon' => 'hourglass_top',
                            ],
                            'diterima' => [
                                'label' => 'Diterima',
                                'badge' => 'badge-success',
                                'icon' => 'check_circle',
                            ],
                            'revisi' => [
                                'label' => 'Perlu Revisi',
                                'badge' => 'badge-warning',
                                'icon' => 'edit',
                            ],
                        ];

                        $uploadStatus = $uploaded
                            ? ($uploadStatusMap[$uploaded->status] ?? $uploadStatusMap['pending'])
                            : null;
                    @endphp

                    <article class="rounded-2xl border border-base-300 overflow-hidden">
                        <div class="p-4 md:p-5 bg-base-200">
                            <div class="flex flex-col gap-3 md:flex-row md:items-start md:justify-between">
                                <div class="flex gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-base-100 flex items-center justify-center flex-shrink-0">
                                        <span class="material-icons text-primary">description</span>
                                    </div>

                                    <div>
                                        <div class="flex flex-wrap items-center gap-2">
                                            <h3 class="font-semibold text-lg">
                                                {{ $index + 1 }}. {{ $dokumen->nama_dokumen }}
                                            </h3>

                                            @if($dokumen->is_wajib)
                                                <span class="badge badge-error">Wajib</span>
                                            @else
                                                <span class="badge badge-outline">Opsional</span>
                                            @endif
                                        </div>

                                        <p class="text-sm text-neutral/60 mt-1">
                                            {{ $dokumen->instruksi }}
                                        </p>
                                    </div>
                                </div>

                                @if($uploaded)
                                    <span class="badge {{ $uploadStatus['badge'] }} gap-1">
                                        <span class="material-icons text-xs">{{ $uploadStatus['icon'] }}</span>
                                        {{ $uploadStatus['label'] }}
                                    </span>
                                @else
                                    <span class="badge badge-ghost">Belum Diunggah</span>
                                @endif
                            </div>
                        </div>

                        <div class="p-4 md:p-5">
                            @if($uploaded)
                                <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                                    <div>
                                        <p class="text-sm font-semibold">
                                            Dokumen telah diunggah
                                        </p>

                                        @if($uploaded->catatan)
                                            <p class="text-sm text-neutral/60 mt-1">
                                                Catatan Anda: {{ $uploaded->catatan }}
                                            </p>
                                        @endif

                                        @if($uploaded->feedback_admin)
                                            <div class="alert alert-warning mt-3 py-3">
                                                <span class="material-icons">feedback</span>
                                                <div>
                                                    <strong class="text-sm">Catatan Pengawas</strong>
                                                    <div class="text-sm">{{ $uploaded->feedback_admin }}</div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <a href="{{ asset('storage/' . $uploaded->file) }}"
                                        class="btn btn-outline btn-primary btn-sm gap-2"
                                        target="_blank"
                                        rel="noopener">
                                        <span class="material-icons">visibility</span>
                                        Lihat Dokumen
                                    </a>
                                </div>

                                @if(
                                    $isAccessible &&
                                    $submissionStatus !== 'submitted' &&
                                    $submissionStatus !== 'lengkap'
                                )
                                    <details class="collapse collapse-arrow border border-base-300 bg-base-200 mt-4">
                                        <summary class="collapse-title font-semibold">
                                            Ganti atau unggah ulang dokumen
                                        </summary>

                                        <div class="collapse-content">
                                            <form action="{{ route('guru.triwulan.upload', $periode->id) }}"
                                                method="POST"
                                                enctype="multipart/form-data"
                                                class="pt-2">
                                                @csrf

                                                <input type="hidden" name="dokumen_wajib_id" value="{{ $dokumen->id }}">

                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                    <div class="form-control">
                                                        <label class="label">
                                                            <span class="label-text font-semibold">Pilih File Baru</span>
                                                        </label>

                                                        <input type="file"
                                                            name="file"
                                                            class="file-input file-input-bordered w-full"
                                                            required>
                                                    </div>

                                                    <div class="form-control">
                                                        <label class="label">
                                                            <span class="label-text font-semibold">Catatan</span>
                                                        </label>

                                                        <input type="text"
                                                            name="catatan"
                                                            value="{{ old('catatan', $uploaded->catatan) }}"
                                                            class="input input-bordered w-full"
                                                            placeholder="Catatan opsional">
                                                    </div>
                                                </div>

                                                <button type="submit" class="btn btn-primary btn-sm mt-4 gap-2">
                                                    <span class="material-icons">upload_file</span>
                                                    Unggah Ulang
                                                </button>
                                            </form>
                                        </div>
                                    </details>
                                @endif
                            @else
                                @if(
                                    $isAccessible &&
                                    $submissionStatus !== 'submitted' &&
                                    $submissionStatus !== 'lengkap'
                                )
                                    <form action="{{ route('guru.triwulan.upload', $periode->id) }}"
                                        method="POST"
                                        enctype="multipart/form-data">
                                        @csrf

                                        <input type="hidden" name="dokumen_wajib_id" value="{{ $dokumen->id }}">

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div class="form-control">
                                                <label class="label">
                                                    <span class="label-text font-semibold">
                                                        File Dokumen
                                                    </span>
                                                </label>

                                                <input type="file"
                                                    name="file"
                                                    class="file-input file-input-bordered w-full"
                                                    required>

                                                <label class="label">
                                                    <span class="label-text-alt text-neutral/60">
                                                        Maksimal ukuran file: 10 MB.
                                                    </span>
                                                </label>
                                            </div>

                                            <div class="form-control">
                                                <label class="label">
                                                    <span class="label-text font-semibold">
                                                        Catatan
                                                    </span>
                                                </label>

                                                <textarea name="catatan"
                                                    class="textarea textarea-bordered h-28"
                                                    placeholder="Tambahkan catatan jika diperlukan">{{ old('catatan') }}</textarea>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-sm mt-4 gap-2">
                                            <span class="material-icons">upload_file</span>
                                            Unggah Dokumen
                                        </button>
                                    </form>
                                @else
                                    <div class="alert alert-ghost bg-base-200">
                                        <span class="material-icons">
                                            {{ $isDeadlinePassed ? 'event_busy' : 'lock' }}
                                        </span>

                                        <span>
                                            @if($isDeadlinePassed)
                                                Dokumen belum dapat diunggah karena deadline sudah lewat.
                                            @elseif($submissionStatus === 'submitted')
                                                Submission sedang direview. Dokumen tidak dapat diubah sementara.
                                            @elseif($submissionStatus === 'lengkap')
                                                Submission telah disetujui dan dokumen telah dikunci.
                                            @else
                                                Dokumen dapat diunggah setelah triwulan dibuka oleh pengawas.
                                            @endif
                                        </span>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </article>
                @empty
                    <div class="py-12 text-center">
                        <span class="material-icons text-5xl text-neutral/30">folder_off</span>
                        <h3 class="font-display text-xl font-semibold mt-3">
                            Belum ada dokumen wajib
                        </h3>
                        <p class="text-neutral/60 text-sm mt-1">
                            Pengawas belum menambahkan daftar dokumen untuk triwulan ini.
                        </p>
                    </div>
                @endforelse
            </div>

            @if(
                $submissionStatus === 'draft' ||
                $submissionStatus === 'revisi'
            )
                <div class="mt-7 pt-5 border-t border-base-300">
                    @if($totalWajib > 0 && $totalWajibUpload >= $totalWajib && $isAccessible)
                        <form action="{{ route('guru.triwulan.submit', $periode->id) }}" method="POST">
                            @csrf

                            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between rounded-2xl bg-base-200 p-4">
                                <div class="flex gap-3">
                                    <span class="material-icons text-success text-3xl">task_alt</span>

                                    <div>
                                        <h3 class="font-semibold">Dokumen wajib sudah lengkap</h3>
                                        <p class="text-sm text-neutral/60">
                                            Kirim submission agar dapat diperiksa oleh pengawas.
                                        </p>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-success gap-2">
                                    <span class="material-icons">send</span>
                                    Kirim untuk Review
                                </button>
                            </div>
                        </form>
                    @elseif($isAccessible && $totalWajib > 0)
                        <div class="alert alert-warning">
                            <span class="material-icons">info</span>

                            <div>
                                <strong>Dokumen wajib belum lengkap.</strong>
                                <div class="text-sm">
                                    Unggah {{ $totalWajib - $totalWajibUpload }} dokumen wajib lagi sebelum mengirim submission.
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @elseif($submissionStatus === 'submitted')
                <div class="alert alert-info mt-7">
                    <span class="material-icons">hourglass_top</span>

                    <div>
                        <strong>Submission sudah dikirim.</strong>
                        <div class="text-sm">
                            Pengawas sedang atau akan melakukan review dokumen Anda.
                        </div>
                    </div>
                </div>
            @elseif($submissionStatus === 'lengkap')
                <div class="alert alert-success mt-7">
                    <span class="material-icons">verified</span>

                    <div>
                        <strong>Submission telah lengkap dan disetujui.</strong>
                        <div class="text-sm">
                            Semua dokumen pada triwulan ini telah selesai diproses.
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection