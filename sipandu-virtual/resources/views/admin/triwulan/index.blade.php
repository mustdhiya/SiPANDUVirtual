@extends('layouts.admin')

@section('title', 'Triwulan')

@section('content')
@php
    $totalTriwulan = $triwulans->count();
    $triwulanTerbuka = $triwulans->where('is_open', true)->count();
    $triwulanTertutup = $totalTriwulan - $triwulanTerbuka;

    $deadlineTerdekat = $triwulans
        ->filter(fn ($tw) => $tw->deadline && $tw->deadline->isFuture())
        ->sortBy('deadline')
        ->first();

    $detailTriwulan = [
        1 => [
            'nama' => 'Triwulan I',
            'periode' => 'Januari – Maret',
            'icon' => 'map',
            'iconClass' => 'bg-primary/15 text-primary',
        ],
        2 => [
            'nama' => 'Triwulan II',
            'periode' => 'April – Juni',
            'icon' => 'support_agent',
            'iconClass' => 'bg-secondary/15 text-secondary',
        ],
        3 => [
            'nama' => 'Triwulan III',
            'periode' => 'Juli – September',
            'icon' => 'visibility',
            'iconClass' => 'bg-warning/20 text-warning',
        ],
        4 => [
            'nama' => 'Triwulan IV',
            'periode' => 'Oktober – Desember',
            'icon' => 'summarize',
            'iconClass' => 'bg-success/15 text-success',
        ],
    ];
@endphp

<div class="mx-auto max-w-7xl space-y-8">

    {{-- Header --}}
    <section class="flex flex-col gap-4 border-b border-base-300 pb-6 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.14em] text-secondary">
                Pengaturan Pendampingan
            </p>

            <h1 class="font-display mt-2 text-3xl font-semibold text-base-content md:text-4xl">
                Periode Triwulan
            </h1>

            <p class="mt-2 max-w-2xl text-sm leading-6 text-base-content/70">
                Atur periode, tema, batas waktu pengisian, dan status akses setiap triwulan untuk guru.
            </p>
        </div>

        <a href="{{ route('admin.triwulan.create') }}" class="btn btn-primary rounded-xl">
            <span class="material-icons">add</span>
            Tambah Triwulan
        </a>
    </section>

    {{-- Ringkasan --}}
    <section class="grid grid-cols-2 gap-3 sm:grid-cols-4 sm:gap-4">

        <article class="rounded-2xl border border-base-300 bg-base-100 p-4 shadow-sm sm:p-5">
            <div class="flex items-center justify-between">
                <span class="material-icons text-primary">date_range</span>
                <span class="text-[11px] font-bold uppercase tracking-wide text-base-content/50">
                    Total
                </span>
            </div>

            <p class="mt-5 text-sm text-base-content/70">Periode Triwulan</p>

            <p class="font-display mt-1 text-3xl font-semibold text-primary">
                {{ $totalTriwulan }}
            </p>
        </article>

        <article class="rounded-2xl border border-base-300 bg-base-100 p-4 shadow-sm sm:p-5">
            <div class="flex items-center justify-between">
                <span class="material-icons text-success">lock_open</span>
                <span class="text-[11px] font-bold uppercase tracking-wide text-base-content/50">
                    Akses
                </span>
            </div>

            <p class="mt-5 text-sm text-base-content/70">Triwulan Terbuka</p>

            <p class="font-display mt-1 text-3xl font-semibold text-success">
                {{ $triwulanTerbuka }}
            </p>
        </article>

        <article class="rounded-2xl border border-base-300 bg-base-100 p-4 shadow-sm sm:p-5">
            <div class="flex items-center justify-between">
                <span class="material-icons text-base-content/60">lock</span>
                <span class="text-[11px] font-bold uppercase tracking-wide text-base-content/50">
                    Akses
                </span>
            </div>

            <p class="mt-5 text-sm text-base-content/70">Triwulan Tertutup</p>

            <p class="font-display mt-1 text-3xl font-semibold text-base-content">
                {{ $triwulanTertutup }}
            </p>
        </article>

        <article class="rounded-2xl border border-base-300 bg-base-100 p-4 shadow-sm sm:p-5">
            <div class="flex items-center justify-between">
                <span class="material-icons text-secondary">event</span>
                <span class="text-[11px] font-bold uppercase tracking-wide text-base-content/50">
                    Terdekat
                </span>
            </div>

            <p class="mt-5 text-sm text-base-content/70">Deadline Berikutnya</p>

            @if($deadlineTerdekat)
                <p class="font-display mt-1 text-lg font-semibold text-secondary">
                    {{ $deadlineTerdekat->deadline->translatedFormat('d M Y') }}
                </p>

                <p class="mt-1 text-xs text-base-content/60">
                    {{ $deadlineTerdekat->deadline->diffForHumans() }}
                </p>
            @else
                <p class="font-display mt-1 text-lg font-semibold text-base-content/60">
                    Belum ada
                </p>
            @endif
        </article>
    </section>

    {{-- Petunjuk --}}
    <section class="rounded-2xl border border-secondary/30 bg-secondary/10 px-5 py-4">
        <div class="flex items-start gap-3">
            <span class="material-icons mt-0.5 text-secondary">info</span>

            <div>
                <h2 class="font-semibold text-base-content">Petunjuk singkat</h2>

                <p class="mt-1 text-sm leading-6 text-base-content/75">
                    Triwulan berstatus <strong>Terbuka</strong> dapat diakses guru. Pastikan tema,
                    dokumen wajib, dan deadline sudah benar sebelum membuka periode untuk guru.
                </p>
            </div>
        </div>
    </section>

    {{-- Tabel --}}
    <section class="overflow-hidden rounded-2xl border border-base-300 bg-base-100 shadow-sm">
        <div class="flex flex-col gap-3 border-b border-base-300 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="font-display text-xl font-semibold text-base-content">
                    Daftar Triwulan
                </h2>

                <p class="mt-1 text-sm text-base-content/70">
                    Semua periode triwulan yang telah dibuat dalam sistem.
                </p>
            </div>

            <span class="badge badge-outline gap-2 self-start sm:self-auto">
                <span class="material-icons text-sm">format_list_bulleted</span>
                {{ $totalTriwulan }} periode
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="table w-full">
                <thead class="bg-base-200 text-base-content/70">
                    <tr>
                        <th class="pl-5">Triwulan</th>
                        <th>Tahun Ajaran</th>
                        <th>Tema Pendampingan</th>
                        <th>Deadline</th>
                        <th>Status Akses</th>
                        <th class="pr-5 text-right">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($triwulans as $tw)
                        @php
                            $detail = $detailTriwulan[$tw->nomor] ?? [
                                'nama' => 'Triwulan ' . $tw->nomor,
                                'periode' => '-',
                                'icon' => 'date_range',
                                'iconClass' => 'bg-primary/15 text-primary',
                            ];

                            $deadlineLewat = $tw->deadline && $tw->deadline->isPast();
                            $hariTersisa = $tw->deadline
                                ? now()->startOfDay()->diffInDays($tw->deadline->copy()->startOfDay(), false)
                                : null;
                        @endphp

                        <tr class="hover:bg-base-200">
                            <td class="pl-5">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl {{ $detail['iconClass'] }}">
                                        <span class="material-icons">{{ $detail['icon'] }}</span>
                                    </div>

                                    <div>
                                        <p class="font-semibold text-base-content">
                                            {{ $detail['nama'] }}
                                        </p>

                                        <p class="text-xs text-base-content/60">
                                            {{ $detail['periode'] }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <span class="font-medium text-base-content">
                                    {{ $tw->tahunAjaran->label ?? '-' }}
                                </span>
                            </td>

                            <td>
                                <div class="max-w-sm">
                                    <p class="font-medium text-base-content">
                                        {{ $tw->tema }}
                                    </p>
                                </div>
                            </td>

                            <td>
                                @if($tw->deadline)
                                    <p class="font-medium text-base-content">
                                        {{ $tw->deadline->translatedFormat('d M Y') }}
                                    </p>

                                    @if($deadlineLewat)
                                        <p class="mt-1 text-xs font-semibold text-error">
                                            Deadline telah berakhir
                                        </p>
                                    @elseif($hariTersisa === 0)
                                        <p class="mt-1 text-xs font-semibold text-warning">
                                            Batas akhir hari ini
                                        </p>
                                    @elseif($hariTersisa !== null && $hariTersisa <= 7)
                                        <p class="mt-1 text-xs font-semibold text-warning">
                                            {{ $hariTersisa }} hari lagi
                                        </p>
                                    @else
                                        <p class="mt-1 text-xs text-base-content/60">
                                            {{ $tw->deadline->diffForHumans() }}
                                        </p>
                                    @endif
                                @else
                                    <span class="text-base-content/60">
                                        Belum diatur
                                    </span>
                                @endif
                            </td>

                            <td>
                                @if($tw->is_open)
                                    <span class="badge badge-success gap-1">
                                        <span class="material-icons text-sm">lock_open</span>
                                        Terbuka
                                    </span>
                                @else
                                    <span class="badge badge-ghost gap-1">
                                        <span class="material-icons text-sm">lock</span>
                                        Tertutup
                                    </span>
                                @endif
                            </td>

                            <td class="pr-5">
                                <div class="flex justify-end gap-2">
                                    <a
                                        href="{{ route('admin.triwulan.edit', $tw->id) }}"
                                        class="btn btn-sm btn-outline btn-primary rounded-xl"
                                        title="Edit {{ $detail['nama'] }}"
                                        aria-label="Edit {{ $detail['nama'] }}"
                                    >
                                        <span class="material-icons text-base">edit</span>
                                        <span class="hidden lg:inline">Edit</span>
                                    </a>

                                    <button
                                        type="button"
                                        class="btn btn-square btn-sm btn-ghost rounded-xl text-error hover:bg-error/10"
                                        title="Hapus {{ $detail['nama'] }}"
                                        aria-label="Hapus {{ $detail['nama'] }}"
                                        onclick="document.getElementById('delete-triwulan-{{ $tw->id }}').showModal()"
                                    >
                                        <span class="material-icons text-base">delete</span>
                                    </button>
                                </div>

                                <dialog id="delete-triwulan-{{ $tw->id }}" class="modal">
                                    <div class="modal-box rounded-2xl">
                                        <div class="flex items-start gap-3">
                                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-error/15 text-error">
                                                <span class="material-icons">warning</span>
                                            </div>

                                            <div>
                                                <h3 class="font-display text-xl font-semibold text-base-content">
                                                    Hapus {{ $detail['nama'] }}?
                                                </h3>

                                                <p class="mt-2 text-sm leading-6 text-base-content/70">
                                                    Triwulan untuk tahun ajaran
                                                    <strong>{{ $tw->tahunAjaran->label ?? '-' }}</strong>
                                                    akan dihapus. Data submission dan dokumen yang terkait dapat ikut terpengaruh.
                                                </p>
                                            </div>
                                        </div>

                                        <div class="modal-action">
                                            <form method="dialog">
                                                <button type="submit" class="btn btn-ghost rounded-xl">
                                                    Batal
                                                </button>
                                            </form>

                                            <form action="{{ route('admin.triwulan.destroy', $tw->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-error rounded-xl">
                                                    <span class="material-icons text-base">delete</span>
                                                    Ya, Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    <form method="dialog" class="modal-backdrop">
                                        <button aria-label="Tutup modal">Tutup</button>
                                    </form>
                                </dialog>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-14 text-center">
                                <div class="mx-auto flex max-w-sm flex-col items-center">
                                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-base-200 text-primary">
                                        <span class="material-icons text-3xl">date_range</span>
                                    </div>

                                    <h3 class="font-display mt-4 text-xl font-semibold text-base-content">
                                        Belum ada triwulan
                                    </h3>

                                    <p class="mt-2 text-sm leading-6 text-base-content/70">
                                        Buat periode triwulan untuk mulai mengatur jadwal dan dokumen pendampingan guru.
                                    </p>

                                    <a href="{{ route('admin.triwulan.create') }}" class="btn btn-primary mt-5 rounded-xl">
                                        <span class="material-icons">add</span>
                                        Tambah Triwulan Pertama
                                    </a>
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