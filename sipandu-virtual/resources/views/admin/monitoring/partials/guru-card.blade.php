@php
    $guru = $data['guru'];
    $submission = $data['submission'];
    $matriks = $data['matriks'] ?? null;

    $scoreTotal = (float) $data['skor_total'];
    $scoreKelengkapan = (float) $data['skor_kelengkapan'];
    $scoreRespons = (float) $data['skor_respons'];

    $toneClasses = [
        'error' => [
            'border' => 'border-error/30',
            'bg' => 'bg-error/10',
            'icon' => 'bg-error/20 text-error',
            'text' => 'text-error',
            'progress' => 'progress-error',
            'badge' => 'badge-error',
        ],
        'warning' => [
            'border' => 'border-warning/30',
            'bg' => 'bg-warning/10',
            'icon' => 'bg-warning/20 text-warning',
            'text' => 'text-warning',
            'progress' => 'progress-warning',
            'badge' => 'badge-warning',
        ],
        'success' => [
            'border' => 'border-success/30',
            'bg' => 'bg-success/10',
            'icon' => 'bg-success/20 text-success',
            'text' => 'text-success',
            'progress' => 'progress-success',
            'badge' => 'badge-success',
        ],
    ][$tone];

    $statusSubmission = $submission?->status_review ?? 'belum_submit';

    $statusLabel = [
        'draft' => 'Draft',
        'submitted' => 'Menunggu Review',
        'revisi' => 'Perlu Revisi',
        'lengkap' => 'Lengkap',
        'belum_submit' => 'Belum Submit',
    ][$statusSubmission] ?? 'Belum Submit';

    $statusBadge = [
        'draft' => 'badge-ghost',
        'submitted' => 'badge-info',
        'revisi' => 'badge-warning',
        'lengkap' => 'badge-success',
        'belum_submit' => 'badge-outline',
    ][$statusSubmission] ?? 'badge-outline';

    $catatanSaatIni = old('catatan_admin', $matriks?->catatan_admin ?? '');
@endphp

<article class="mb-4 rounded-2xl border {{ $toneClasses['border'] }} bg-base-100 p-4 shadow-sm last:mb-0 sm:p-5">
    <div class="flex flex-col gap-5 xl:flex-row xl:items-start">

        {{-- Data Guru --}}
        <div class="flex min-w-0 flex-1 items-start gap-3">
            <div class="avatar placeholder">
                <div class="w-11 rounded-2xl {{ $toneClasses['icon'] }}">
                    <span class="text-sm font-bold">
                        {{ strtoupper(substr($guru->nama_lengkap, 0, 1)) }}
                    </span>
                </div>
            </div>

            <div class="min-w-0">
                <h3 class="font-display truncate text-lg font-semibold text-base-content">
                    {{ $guru->nama_lengkap }}
                </h3>

                <p class="mt-1 flex items-center gap-1 text-sm text-base-content/70">
                    <span class="material-icons text-base">school</span>
                    <span class="truncate">
                        {{ $guru->sekolah->nama_sekolah ?? 'Sekolah belum ditentukan' }}
                    </span>
                </p>

                <div class="mt-2 flex flex-wrap gap-2">
                    <span class="badge badge-outline badge-sm">
                        {{ $guru->status_jabatan === 'GURU_KEPSEK' ? 'Guru PAI + Kepsek' : 'Guru PAI' }}
                    </span>

                    <span class="badge {{ $statusBadge }} badge-sm">
                        {{ $statusLabel }}
                    </span>

                    <span class="badge {{ $toneClasses['badge'] }} badge-sm">
                        {{ $label }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Nilai --}}
        <div class="grid grid-cols-3 gap-2 sm:gap-3 xl:w-[360px]">
            <div class="rounded-xl bg-base-200 p-3 text-center">
                <p class="text-[11px] font-semibold uppercase tracking-wide text-base-content/50">
                    Dokumen
                </p>

                <p class="mt-1 text-lg font-bold text-base-content">
                    {{ $scoreKelengkapan }}%
                </p>
            </div>

            <div class="rounded-xl bg-base-200 p-3 text-center">
                <p class="text-[11px] font-semibold uppercase tracking-wide text-base-content/50">
                    Respons
                </p>

                <p class="mt-1 text-lg font-bold text-base-content">
                    {{ $scoreRespons }}%
                </p>
            </div>

            <div class="rounded-xl {{ $toneClasses['bg'] }} p-3 text-center">
                <p class="text-[11px] font-semibold uppercase tracking-wide {{ $toneClasses['text'] }}">
                    Total
                </p>

                <p class="mt-1 text-lg font-bold {{ $toneClasses['text'] }}">
                    {{ $scoreTotal }}%
                </p>
            </div>
        </div>
    </div>

    {{-- Progress --}}
    <div class="mt-5">
        <div class="mb-2 flex items-center justify-between text-xs text-base-content/70">
            <span>Skor monitoring</span>
            <span class="font-semibold {{ $toneClasses['text'] }}">
                {{ $scoreTotal }}%
            </span>
        </div>

        <progress
            class="progress {{ $toneClasses['progress'] }} h-2 w-full"
            value="{{ min(100, max(0, $scoreTotal)) }}"
            max="100"
        ></progress>
    </div>

    {{-- Catatan --}}
    <form
        action="{{ route('admin.monitoring.update-catatan', [$guru->id, $periode->id]) }}"
        method="POST"
        class="mt-5 rounded-xl border border-base-300 bg-base-200 p-3"
    >
        @csrf

        <label class="mb-2 flex items-center gap-2 text-sm font-semibold text-base-content">
            <span class="material-icons text-base text-secondary">edit_note</span>
            Catatan Pendampingan
        </label>

        <div class="flex flex-col gap-2 sm:flex-row">
            <input
                type="text"
                name="catatan_admin"
                value="{{ $catatanSaatIni }}"
                maxlength="500"
                placeholder="Contoh: Hubungi guru untuk pendampingan dokumen..."
                class="input input-bordered w-full rounded-xl bg-base-100 text-base-content"
                aria-label="Catatan pendampingan untuk {{ $guru->nama_lengkap }}"
            >

            <button type="submit" class="btn btn-primary shrink-0 rounded-xl">
                <span class="material-icons text-base">save</span>
                Simpan
            </button>
        </div>

        <p class="mt-2 text-xs text-base-content/60">
            Catatan maksimal 500 karakter.
        </p>
    </form>
</article>