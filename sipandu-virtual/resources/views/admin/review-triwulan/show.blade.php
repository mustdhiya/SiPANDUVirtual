@extends('layouts.admin')

@section('title', 'Review TW ' . $submission->periode->nomor)

@section('content')
@php
    $dokumenTotal = $submission->uploadDokumen->count();
    $dokumenDiterima = $submission->uploadDokumen->where('status', 'diterima')->count();
    $dokumenRevisi = $submission->uploadDokumen->where('status', 'revisi')->count();
    $dokumenPending = $submission->uploadDokumen->where('status', 'pending')->count();

    $progressDokumen = $dokumenTotal > 0
        ? round(($dokumenDiterima / $dokumenTotal) * 100)
        : 0;

    $statusSubmission = [
        'draft' => [
            'label' => 'Draft',
            'class' => 'badge-ghost',
            'icon' => 'edit_note',
            'description' => 'Guru masih menyusun submission.',
        ],
        'submitted' => [
            'label' => 'Menunggu Review',
            'class' => 'badge-info',
            'icon' => 'pending_actions',
            'description' => 'Submission siap diperiksa oleh pengawas.',
        ],
        'revisi' => [
            'label' => 'Perlu Revisi',
            'class' => 'badge-warning',
            'icon' => 'edit',
            'description' => 'Guru perlu memperbaiki dokumen atau submission.',
        ],
        'lengkap' => [
            'label' => 'Lengkap',
            'class' => 'badge-success',
            'icon' => 'check_circle',
            'description' => 'Submission telah dinyatakan lengkap.',
        ],
    ][$submission->status_review] ?? [
        'label' => ucfirst($submission->status_review),
        'class' => 'badge-ghost',
        'icon' => 'help_outline',
        'description' => '',
    ];
@endphp

<div class="space-y-8">

    {{-- Navigasi dan judul --}}
    <section class="flex flex-col gap-4 border-b border-base-300 pb-5 lg:flex-row lg:items-start lg:justify-between">
        <div class="flex items-start gap-3">
            <a
                href="{{ route('admin.review-triwulan.index') }}"
                class="btn btn-square btn-ghost mt-1 rounded-xl"
                title="Kembali ke daftar review"
                aria-label="Kembali ke daftar review"
            >
                <span class="material-icons">arrow_back</span>
            </a>

            <div>
                <p class="text-xs font-bold uppercase tracking-[0.14em] text-secondary">
                    Review Submission
                </p>

                <h1 class="font-display mt-1 text-2xl font-semibold leading-tight text-neutral sm:text-3xl">
                    TW {{ $submission->periode->nomor }} — {{ $submission->guru->nama_lengkap }}
                </h1>

                <p class="mt-2 text-sm text-neutral/60">
                    {{ $submission->guru->sekolah->nama_sekolah ?? 'Sekolah belum diatur' }}
                    <span class="mx-1">•</span>
                    {{ $submission->periode->tahunAjaran->label }}
                </p>
            </div>
        </div>

        <span class="badge {{ $statusSubmission['class'] }} badge-lg gap-2 self-start">
            <span class="material-icons text-base">{{ $statusSubmission['icon'] }}</span>
            {{ $statusSubmission['label'] }}
        </span>
    </section>

    {{-- Status dan profil ringkas --}}
    <section class="grid gap-4 xl:grid-cols-3">

        <article class="rounded-2xl border border-base-300 bg-base-100 p-5 shadow-sm xl:col-span-2">
            <div class="flex flex-col gap-5 sm:flex-row sm:items-center">
                <div class="avatar placeholder">
                    <div class="w-16 rounded-2xl bg-primary text-primary-content">
                        <span class="font-display text-2xl font-semibold">
                            {{ strtoupper(substr($submission->guru->nama_lengkap, 0, 1)) }}
                        </span>
                    </div>
                </div>

                <div class="flex-1">
                    <p class="text-xs font-bold uppercase tracking-[0.13em] text-secondary">
                        Profil Guru
                    </p>

                    <h2 class="font-display mt-1 text-2xl font-semibold text-neutral">
                        {{ $submission->guru->nama_lengkap }}
                    </h2>

                    <div class="mt-3 grid gap-2 text-sm text-neutral/65 sm:grid-cols-2">
                        <p class="flex items-center gap-2">
                            <span class="material-icons text-base text-primary">school</span>
                            {{ $submission->guru->sekolah->nama_sekolah ?? 'Sekolah belum diatur' }}
                        </p>

                        <p class="flex items-center gap-2">
                            <span class="material-icons text-base text-primary">badge</span>
                            {{ $submission->guru->status_jabatan }}
                        </p>
                    </div>
                </div>
            </div>
        </article>

        <article class="rounded-2xl border border-base-300 bg-base-200 p-5 shadow-sm">
            <p class="text-xs font-bold uppercase tracking-[0.13em] text-secondary">
                Status Submission
            </p>

            <p class="mt-3 flex items-center gap-2 font-semibold text-neutral">
                <span class="material-icons text-primary">{{ $statusSubmission['icon'] }}</span>
                {{ $statusSubmission['label'] }}
            </p>

            <p class="mt-2 text-sm leading-6 text-neutral/65">
                {{ $statusSubmission['description'] }}
            </p>

            @if($submission->submitted_at)
                <div class="mt-4 border-t border-base-300 pt-4">
                    <p class="text-xs text-neutral/55">Dikirim oleh guru</p>
                    <p class="mt-1 text-sm font-semibold">
                        {{ $submission->submitted_at->translatedFormat('d F Y, H:i') }} WITA
                    </p>
                </div>
            @endif
        </article>
    </section>

    {{-- Ringkasan dokumen --}}
    <section class="rounded-2xl border border-base-300 bg-base-100 p-5 shadow-sm sm:p-6">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.14em] text-secondary">
                    Kelengkapan Dokumen
                </p>

                <h2 class="font-display mt-1 text-2xl font-semibold text-neutral">
                    {{ $dokumenDiterima }} dari {{ $dokumenTotal }} dokumen diterima
                </h2>

                <p class="mt-1 text-sm text-neutral/60">
                    Periksa setiap dokumen sebelum menetapkan status submission akhir.
                </p>
            </div>

            <div class="w-full max-w-sm">
                <div class="mb-2 flex justify-between text-sm">
                    <span class="font-semibold text-neutral">Progress Verifikasi</span>
                    <span class="font-bold text-primary">{{ $progressDokumen }}%</span>
                </div>

                <progress
                    class="progress progress-primary h-3 w-full"
                    value="{{ $progressDokumen }}"
                    max="100"
                ></progress>

                <div class="mt-3 flex flex-wrap gap-2 text-xs">
                    <span class="badge badge-success gap-1">
                        <span class="material-icons text-xs">check</span>
                        {{ $dokumenDiterima }} diterima
                    </span>

                    @if($dokumenRevisi > 0)
                        <span class="badge badge-warning gap-1">
                            <span class="material-icons text-xs">edit</span>
                            {{ $dokumenRevisi }} revisi
                        </span>
                    @endif

                    @if($dokumenPending > 0)
                        <span class="badge badge-info gap-1">
                            <span class="material-icons text-xs">schedule</span>
                            {{ $dokumenPending }} belum diperiksa
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- Dokumen yang diupload --}}
    <section>
        <div class="mb-4">
            <p class="text-xs font-bold uppercase tracking-[0.14em] text-secondary">
                Langkah 1 dari 2
            </p>

            <h2 class="font-display mt-1 text-2xl font-semibold text-neutral">
                Periksa Dokumen Guru
            </h2>

            <p class="mt-1 text-sm text-neutral/60">
                Buka dokumen, tentukan statusnya, lalu tuliskan catatan yang jelas bila perlu revisi.
            </p>
        </div>

        <div class="space-y-4">
            @forelse($submission->uploadDokumen as $index => $upload)
                @php
                    $statusDokumen = [
                        'pending' => [
                            'label' => 'Belum Diperiksa',
                            'class' => 'badge-info',
                            'icon' => 'schedule',
                        ],
                        'diterima' => [
                            'label' => 'Diterima',
                            'class' => 'badge-success',
                            'icon' => 'check_circle',
                        ],
                        'revisi' => [
                            'label' => 'Perlu Revisi',
                            'class' => 'badge-warning',
                            'icon' => 'edit',
                        ],
                    ][$upload->status] ?? [
                        'label' => ucfirst($upload->status),
                        'class' => 'badge-ghost',
                        'icon' => 'help_outline',
                    ];
                @endphp

                <article class="overflow-hidden rounded-2xl border border-base-300 bg-base-100 shadow-sm">
                    <div class="flex flex-col gap-4 border-b border-base-300 bg-base-200/45 p-5 lg:flex-row lg:items-start lg:justify-between">
                        <div class="flex gap-3">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-primary/10 text-primary">
                                <span class="font-display font-semibold">{{ $index + 1 }}</span>
                            </div>

                            <div>
                                <div class="flex flex-wrap items-center gap-2">
                                    <h3 class="font-display text-xl font-semibold text-neutral">
                                        {{ $upload->dokumenWajib->nama_dokumen }}
                                    </h3>

                                    @if($upload->dokumenWajib->is_wajib)
                                        <span class="badge badge-error badge-sm">
                                            Wajib
                                        </span>
                                    @else
                                        <span class="badge badge-ghost badge-sm">
                                            Opsional
                                        </span>
                                    @endif
                                </div>

                                <p class="mt-2 max-w-3xl text-sm leading-6 text-neutral/65">
                                    {{ $upload->dokumenWajib->instruksi }}
                                </p>

                                @if($upload->catatan)
                                    <div class="mt-3 rounded-xl border border-base-300 bg-base-100 px-3 py-2 text-sm text-neutral/65">
                                        <span class="font-semibold text-neutral">Catatan Guru:</span>
                                        {{ $upload->catatan }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center gap-2">
                            <span class="badge {{ $statusDokumen['class'] }} gap-1">
                                <span class="material-icons text-sm">{{ $statusDokumen['icon'] }}</span>
                                {{ $statusDokumen['label'] }}
                            </span>

                            <a
                                href="{{ asset('storage/' . $upload->file) }}"
                                class="btn btn-outline btn-primary btn-sm rounded-xl"
                                target="_blank"
                                rel="noopener noreferrer"
                            >
                                <span class="material-icons text-base">open_in_new</span>
                                Buka Dokumen
                            </a>
                        </div>
                    </div>

                    <div class="p-5">
                        <form
                            action="{{ route('admin.review-triwulan.review-dokumen', $upload->id) }}"
                            method="POST"
                            class="grid gap-4 lg:grid-cols-[220px_1fr_auto] lg:items-end"
                        >
                            @csrf

                            <div class="form-control">
                                <label class="label pt-0">
                                    <span class="label-text font-semibold">Keputusan Dokumen</span>
                                </label>

                                <select
                                    name="status"
                                    class="select select-bordered w-full rounded-xl"
                                    required
                                >
                                    <option value="diterima" {{ $upload->status === 'diterima' ? 'selected' : '' }}>
                                        Diterima
                                    </option>

                                    <option value="revisi" {{ $upload->status === 'revisi' ? 'selected' : '' }}>
                                        Perlu Revisi
                                    </option>
                                </select>
                            </div>

                            <div class="form-control">
                                <label class="label pt-0">
                                    <span class="label-text font-semibold">
                                        Catatan untuk Guru
                                    </span>

                                    <span class="label-text-alt text-neutral/50">
                                        Maks. 500 karakter
                                    </span>
                                </label>

                                <textarea
                                    name="feedback_admin"
                                    class="textarea textarea-bordered min-h-24 w-full rounded-xl"
                                    rows="3"
                                    maxlength="500"
                                    placeholder="Contoh: Mohon lengkapi tanda tangan kepala sekolah pada halaman terakhir."
                                >{{ old('feedback_admin', $upload->feedback_admin) }}</textarea>
                            </div>

                            <button type="submit" class="btn btn-primary rounded-xl">
                                <span class="material-icons text-base">save</span>
                                Simpan
                            </button>
                        </form>
                    </div>
                </article>
            @empty
                <div class="rounded-2xl border border-dashed border-base-300 bg-base-100 px-6 py-12 text-center">
                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-base-200 text-primary">
                        <span class="material-icons text-3xl">folder_off</span>
                    </div>

                    <h3 class="font-display mt-4 text-xl font-semibold text-neutral">
                        Belum ada dokumen yang diupload
                    </h3>

                    <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-neutral/60">
                        Guru belum mengunggah dokumen untuk submission triwulan ini.
                    </p>
                </div>
            @endforelse
        </div>
    </section>

    {{-- Keputusan akhir --}}
    <section class="rounded-2xl border border-primary/15 bg-base-200/70 p-5 shadow-sm sm:p-6">
        <div class="mb-5">
            <p class="text-xs font-bold uppercase tracking-[0.14em] text-secondary">
                Langkah 2 dari 2
            </p>

            <h2 class="font-display mt-1 text-2xl font-semibold text-neutral">
                Tetapkan Status Submission
            </h2>

            <p class="mt-1 text-sm leading-6 text-neutral/60">
                Pilih “Lengkap” jika semua persyaratan telah sesuai. Pilih “Perlu Revisi” jika guru masih harus memperbaiki submission.
            </p>
        </div>

        <form
            action="{{ route('admin.review-triwulan.review-submission', $submission->id) }}"
            method="POST"
            class="grid gap-5 lg:grid-cols-[260px_1fr]"
        >
            @csrf

            <div class="form-control">
                <label class="label pt-0">
                    <span class="label-text font-semibold">Keputusan Akhir</span>
                </label>

                <select
                    name="status_review"
                    class="select select-bordered w-full rounded-xl"
                    required
                >
                    <option value="revisi" {{ $submission->status_review === 'revisi' ? 'selected' : '' }}>
                        Perlu Revisi
                    </option>

                    <option value="lengkap" {{ $submission->status_review === 'lengkap' ? 'selected' : '' }}>
                        Lengkap
                    </option>
                </select>

                <label class="label">
                    <span class="label-text-alt text-neutral/55">
                        Guru akan menerima notifikasi email setelah disimpan.
                    </span>
                </label>
            </div>

            <div class="form-control">
                <label class="label pt-0">
                    <span class="label-text font-semibold">Feedback Keseluruhan</span>
                </label>

                <textarea
                    name="feedback_admin"
                    class="textarea textarea-bordered min-h-28 w-full rounded-xl"
                    rows="4"
                    placeholder="Tuliskan ringkasan hasil review atau arahan tindak lanjut untuk guru."
                >{{ old('feedback_admin', $submission->feedback_admin) }}</textarea>
            </div>

            <div class="lg:col-span-2 flex flex-col-reverse gap-3 border-t border-base-300 pt-5 sm:flex-row sm:items-center sm:justify-between">
                <a
                    href="{{ route('admin.review-triwulan.index') }}"
                    class="btn btn-ghost rounded-xl"
                >
                    <span class="material-icons">arrow_back</span>
                    Kembali ke Daftar
                </a>

                <button type="submit" class="btn btn-primary rounded-xl">
                    <span class="material-icons">save</span>
                    Simpan Keputusan dan Kirim Notifikasi
                </button>
            </div>
        </form>
    </section>
</div>
@endsection