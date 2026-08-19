@extends('layouts.admin')

@section('title', 'Gudang PAI-BMTS')

@section('content')
@php
    $totalMateri = $materis->count();
    $materiAktif = $materis->where('is_active', true)->count();
    $materiNonaktif = $materis->where('is_active', false)->count();
    $instrumenRiset = $materis->where('kategori', 'instrumen_riset')->count();

    $kategoriMap = [
        'materi' => [
            'label' => 'Materi',
            'badgeClass' => 'badge-info',
            'icon' => 'menu_book',
            'iconClass' => 'bg-info/15 text-info',
        ],
        'instrumen_riset' => [
            'label' => 'Instrumen Riset',
            'badgeClass' => 'badge-warning',
            'icon' => 'assignment',
            'iconClass' => 'bg-warning/20 text-warning',
        ],
        'contoh_perangkat' => [
            'label' => 'Contoh Perangkat',
            'badgeClass' => 'badge-success',
            'icon' => 'description',
            'iconClass' => 'bg-success/15 text-success',
        ],
    ];
@endphp

<div class="mx-auto max-w-7xl space-y-8">

    {{-- Header Halaman --}}
    <section class="flex flex-col gap-4 border-b border-base-300 pb-6 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.14em] text-secondary">
                Laporan dan Arsip
            </p>

            <h1 class="font-display mt-2 text-3xl font-semibold leading-tight text-base-content md:text-4xl">
                Gudang PAI-BMTS
            </h1>

            <p class="mt-2 max-w-2xl text-sm leading-6 text-base-content/70">
                Kelola materi pendampingan, instrumen riset, dan contoh perangkat yang dapat diakses oleh guru binaan.
            </p>
        </div>

        <a
            href="{{ route('admin.gudang.create') }}"
            class="btn btn-primary rounded-xl"
        >
            <span class="material-icons">upload_file</span>
            Upload Materi
        </a>
    </section>

    {{-- Ringkasan --}}
    <section class="grid grid-cols-2 gap-3 sm:grid-cols-4 sm:gap-4">

        <article class="rounded-2xl border border-base-300 bg-base-100 p-4 shadow-sm sm:p-5">
            <div class="flex items-center justify-between">
                <span class="material-icons text-primary">folder_open</span>
                <span class="text-[11px] font-bold uppercase tracking-wide text-base-content/50">
                    Total
                </span>
            </div>

            <p class="mt-5 text-sm text-base-content/70">Semua Materi</p>

            <p class="font-display mt-1 text-3xl font-semibold text-primary">
                {{ $totalMateri }}
            </p>
        </article>

        <article class="rounded-2xl border border-base-300 bg-base-100 p-4 shadow-sm sm:p-5">
            <div class="flex items-center justify-between">
                <span class="material-icons text-success">check_circle</span>
                <span class="text-[11px] font-bold uppercase tracking-wide text-base-content/50">
                    Tampil
                </span>
            </div>

            <p class="mt-5 text-sm text-base-content/70">Materi Aktif</p>

            <p class="font-display mt-1 text-3xl font-semibold text-success">
                {{ $materiAktif }}
            </p>
        </article>

        <article class="rounded-2xl border border-base-300 bg-base-100 p-4 shadow-sm sm:p-5">
            <div class="flex items-center justify-between">
                <span class="material-icons text-warning">assignment</span>
                <span class="text-[11px] font-bold uppercase tracking-wide text-base-content/50">
                    Riset
                </span>
            </div>

            <p class="mt-5 text-sm text-base-content/70">Instrumen Riset</p>

            <p class="font-display mt-1 text-3xl font-semibold text-warning">
                {{ $instrumenRiset }}
            </p>
        </article>

        <article class="rounded-2xl border border-base-300 bg-base-100 p-4 shadow-sm sm:p-5">
            <div class="flex items-center justify-between">
                <span class="material-icons text-base-content/60">visibility_off</span>
                <span class="text-[11px] font-bold uppercase tracking-wide text-base-content/50">
                    Arsip
                </span>
            </div>

            <p class="mt-5 text-sm text-base-content/70">Materi Nonaktif</p>

            <p class="font-display mt-1 text-3xl font-semibold text-base-content">
                {{ $materiNonaktif }}
            </p>
        </article>
    </section>

    {{-- Tabel Materi --}}
    <section>
        <div class="mb-4 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.14em] text-secondary">
                    Daftar Arsip
                </p>

                <h2 class="font-display mt-1 text-2xl font-semibold text-base-content">
                    Materi yang Tersimpan
                </h2>
            </div>

            <p class="text-sm text-base-content/60">
                {{ $totalMateri }} materi tersedia di gudang.
            </p>
        </div>

        @if($materis->isNotEmpty())
            <div class="overflow-hidden rounded-2xl border border-base-300 bg-base-100 shadow-sm">

                <div class="overflow-x-auto">
                    <table class="table table-zebra w-full">
                        <thead class="bg-base-200 text-base-content/70">
                            <tr>
                                <th class="min-w-72">Materi</th>
                                <th>Kategori</th>
                                <th>Pengunggah</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th class="text-right">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($materis as $materi)
                                @php
                                    $kategori = $kategoriMap[$materi->kategori] ?? [
                                        'label' => 'Lainnya',
                                        'badgeClass' => 'badge-ghost',
                                        'icon' => 'folder',
                                        'iconClass' => 'bg-base-200 text-base-content/70',
                                    ];
                                @endphp

                                <tr class="hover:bg-base-200">
                                    <td>
                                        <div class="flex min-w-0 items-start gap-3">
                                            <div class="mt-0.5 flex h-10 w-10 shrink-0 items-center justify-center rounded-xl {{ $kategori['iconClass'] }}">
                                                <span class="material-icons">
                                                    {{ $kategori['icon'] }}
                                                </span>
                                            </div>

                                            <div class="min-w-0">
                                                <p class="max-w-md truncate font-semibold text-base-content">
                                                    {{ $materi->judul }}
                                                </p>

                                                <p class="mt-1 max-w-md text-sm leading-5 text-base-content/70">
                                                    {{ $materi->deskripsi ? Str::limit($materi->deskripsi, 100) : 'Tidak ada deskripsi materi.' }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <span class="badge {{ $kategori['badgeClass'] }} gap-1 whitespace-nowrap">
                                            <span class="material-icons text-sm">
                                                {{ $kategori['icon'] }}
                                            </span>
                                            {{ $kategori['label'] }}
                                        </span>
                                    </td>

                                    <td>
                                        <div class="flex items-center gap-2 whitespace-nowrap">
                                            <div class="avatar placeholder">
                                                <div class="w-8 rounded-full bg-base-300 text-base-content">
                                                    <span class="text-xs font-bold">
                                                        {{ strtoupper(substr($materi->uploader->name ?? 'A', 0, 1)) }}
                                                    </span>
                                                </div>
                                            </div>

                                            <span class="text-sm font-medium text-base-content">
                                                {{ $materi->uploader->name ?? 'Admin' }}
                                            </span>
                                        </div>
                                    </td>

                                    <td class="whitespace-nowrap text-sm text-base-content/70">
                                        {{ $materi->created_at->translatedFormat('d M Y') }}
                                    </td>

                                    <td>
                                        @if($materi->is_active)
                                            <span class="badge badge-success gap-1 whitespace-nowrap">
                                                <span class="material-icons text-sm">visibility</span>
                                                Aktif
                                            </span>
                                        @else
                                            <span class="badge badge-ghost gap-1 whitespace-nowrap">
                                                <span class="material-icons text-sm">visibility_off</span>
                                                Nonaktif
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="flex justify-end gap-1 whitespace-nowrap">

                                            <a
                                                href="{{ asset('storage/' . $materi->file) }}"
                                                target="_blank"
                                                rel="noopener"
                                                class="btn btn-square btn-sm btn-ghost rounded-xl text-primary hover:bg-primary/10"
                                                title="Lihat atau unduh file"
                                                aria-label="Lihat atau unduh {{ $materi->judul }}"
                                            >
                                                <span class="material-icons text-base">download</span>
                                            </a>

                                            <a
                                                href="{{ route('admin.gudang.edit', $materi->id) }}"
                                                class="btn btn-square btn-sm btn-ghost rounded-xl text-secondary hover:bg-secondary/10"
                                                title="Edit materi"
                                                aria-label="Edit {{ $materi->judul }}"
                                            >
                                                <span class="material-icons text-base">edit</span>
                                            </a>

                                            <button
                                                type="button"
                                                class="btn btn-square btn-sm btn-ghost rounded-xl text-error hover:bg-error/10"
                                                title="Hapus materi"
                                                aria-label="Hapus {{ $materi->judul }}"
                                                onclick="document.getElementById('delete-materi-{{ $materi->id }}').showModal()"
                                            >
                                                <span class="material-icons text-base">delete</span>
                                            </button>
                                        </div>

                                        {{-- Modal hapus --}}
                                        <dialog id="delete-materi-{{ $materi->id }}" class="modal">
                                            <div class="modal-box max-w-md rounded-3xl bg-base-100">
                                                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-error/15 text-error">
                                                    <span class="material-icons">delete_forever</span>
                                                </div>

                                                <h3 class="font-display mt-4 text-xl font-semibold text-base-content">
                                                    Hapus materi?
                                                </h3>

                                                <p class="mt-2 text-sm leading-6 text-base-content/70">
                                                    Materi <strong>{{ $materi->judul }}</strong> akan dihapus dari daftar gudang.
                                                    Tindakan ini tidak dapat dibatalkan dari halaman ini.
                                                </p>

                                                <div class="modal-action mt-6">
                                                    <form method="dialog">
                                                        <button type="submit" class="btn btn-ghost rounded-xl">
                                                            Batal
                                                        </button>
                                                    </form>

                                                    <form action="{{ route('admin.gudang.destroy', $materi->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit" class="btn btn-error rounded-xl">
                                                            <span class="material-icons">delete</span>
                                                            Hapus Materi
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>

                                            <form method="dialog" class="modal-backdrop">
                                                <button aria-label="Tutup dialog">Tutup</button>
                                            </form>
                                        </dialog>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="rounded-3xl border border-dashed border-base-300 bg-base-100 px-6 py-14 text-center shadow-sm">
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-primary/15 text-primary">
                    <span class="material-icons text-3xl">folder_open</span>
                </div>

                <h2 class="font-display mt-5 text-2xl font-semibold text-base-content">
                    Gudang masih kosong
                </h2>

                <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-base-content/70">
                    Upload materi, instrumen riset, atau contoh perangkat agar guru dapat mengaksesnya dari Gudang PAI-BMTS.
                </p>

                <a
                    href="{{ route('admin.gudang.create') }}"
                    class="btn btn-primary mt-6 rounded-xl"
                >
                    <span class="material-icons">upload_file</span>
                    Upload Materi Pertama
                </a>
            </div>
        @endif
    </section>
</div>
@endsection