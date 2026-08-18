@extends('layouts.admin')

@section('title', 'Dokumen Wajib')

@section('content')
@php
    $totalDokumen = $dokumens->count();
    $totalWajib = $dokumens->where('is_wajib', true)->count();
    $totalOpsional = $dokumens->where('is_wajib', false)->count();
    $totalKepsek = $dokumens->where('berlaku_untuk', 'KEPSEK')->count();
@endphp

<div class="space-y-7">

    {{-- Header halaman --}}
    <section class="flex flex-col gap-4 border-b border-base-300 pb-5 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.14em] text-secondary">
                Konfigurasi Triwulan
            </p>

            <h1 class="font-display mt-1 text-3xl font-semibold text-neutral">
                Dokumen Wajib
            </h1>

            <p class="mt-2 max-w-2xl text-sm leading-6 text-neutral/60">
                Atur daftar dokumen yang harus diunggah guru pada setiap periode triwulan.
                Dokumen dapat dibedakan untuk semua guru atau khusus guru yang merangkap kepala sekolah.
            </p>
        </div>

        <a
            href="{{ route('admin.dokumen.create') }}"
            class="btn btn-primary rounded-xl"
        >
            <span class="material-icons">add</span>
            Tambah Dokumen
        </a>
    </section>

    {{-- Ringkasan --}}
    <section class="grid grid-cols-2 gap-3 sm:grid-cols-4 sm:gap-4">
        <article class="rounded-2xl border border-base-300 bg-base-100 p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="material-icons text-primary">description</span>
                <span class="text-[11px] font-bold uppercase tracking-wide text-neutral/45">Total</span>
            </div>

            <p class="mt-4 text-sm text-neutral/60">Seluruh Dokumen</p>

            <p class="font-display mt-1 text-3xl font-semibold text-primary">
                {{ $totalDokumen }}
            </p>
        </article>

        <article class="rounded-2xl border border-base-300 bg-base-100 p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="material-icons text-success">check_circle</span>
                <span class="text-[11px] font-bold uppercase tracking-wide text-neutral/45">Utama</span>
            </div>

            <p class="mt-4 text-sm text-neutral/60">Dokumen Wajib</p>

            <p class="font-display mt-1 text-3xl font-semibold text-success">
                {{ $totalWajib }}
            </p>
        </article>

        <article class="rounded-2xl border border-base-300 bg-base-100 p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="material-icons text-neutral/60">playlist_add</span>
                <span class="text-[11px] font-bold uppercase tracking-wide text-neutral/45">Tambahan</span>
            </div>

            <p class="mt-4 text-sm text-neutral/60">Dokumen Opsional</p>

            <p class="font-display mt-1 text-3xl font-semibold text-neutral">
                {{ $totalOpsional }}
            </p>
        </article>

        <article class="rounded-2xl border border-base-300 bg-base-100 p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="material-icons text-secondary">account_balance</span>
                <span class="text-[11px] font-bold uppercase tracking-wide text-neutral/45">Khusus</span>
            </div>

            <p class="mt-4 text-sm text-neutral/60">Untuk Guru Kepsek</p>

            <p class="font-display mt-1 text-3xl font-semibold text-secondary">
                {{ $totalKepsek }}
            </p>
        </article>
    </section>

    {{-- Informasi bantuan --}}
    <section class="rounded-2xl border border-secondary/20 bg-secondary/10 px-4 py-4 sm:px-5">
        <div class="flex gap-3">
            <span class="material-icons mt-0.5 shrink-0 text-secondary">info</span>

            <div>
                <p class="font-semibold text-neutral">
                    Atur urutan dokumen dengan angka kecil terlebih dahulu.
                </p>

                <p class="mt-1 text-sm leading-6 text-neutral/65">
                    Contoh: isi urutan <strong>1</strong> untuk dokumen yang ingin tampil paling atas,
                    lalu lanjutkan dengan 2, 3, dan seterusnya.
                </p>
            </div>
        </div>
    </section>

    {{-- Tabel data --}}
    <section class="overflow-hidden rounded-2xl border border-base-300 bg-base-100 shadow-sm">
        <div class="flex flex-col gap-2 border-b border-base-300 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="font-display text-xl font-semibold text-neutral">
                    Daftar Dokumen
                </h2>

                <p class="mt-1 text-sm text-neutral/60">
                    {{ $totalDokumen }} dokumen telah dikonfigurasi.
                </p>
            </div>

            <span class="badge badge-outline gap-2 self-start sm:self-auto">
                <span class="material-icons text-sm">list_alt</span>
                Urut berdasarkan triwulan
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="table table-zebra w-full min-w-[920px]">
                <thead>
                    <tr class="border-b border-base-300 bg-base-200/65 text-neutral/70">
                        <th class="w-16">Urutan</th>
                        <th>Triwulan</th>
                        <th>Dokumen dan Instruksi</th>
                        <th>Ketentuan</th>
                        <th>Status</th>
                        <th class="w-28 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($dokumens as $dokumen)
                        <tr class="hover">
                            <td>
                                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-base-200 font-semibold text-primary">
                                    {{ $dokumen->urutan }}
                                </div>
                            </td>

                            <td>
                                <div class="flex items-center gap-2">
                                    <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-primary/10 text-primary">
                                        <span class="font-bold">TW{{ $dokumen->triwulan }}</span>
                                    </span>

                                    <div>
                                        <p class="font-semibold text-neutral">
                                            Triwulan {{ $dokumen->triwulan }}
                                        </p>
                                        <p class="text-xs text-neutral/55">
                                            Periode pendampingan
                                        </p>
                                    </div>
                                </div>
                            </td>

                            <td class="max-w-md">
                                <p class="font-semibold text-neutral">
                                    {{ $dokumen->nama_dokumen }}
                                </p>

                                <p
                                    class="mt-1 line-clamp-2 text-sm leading-5 text-neutral/60"
                                    title="{{ $dokumen->instruksi }}"
                                >
                                    {{ $dokumen->instruksi }}
                                </p>
                            </td>

                            <td>
                                <div class="flex flex-col items-start gap-2">
                                    @if($dokumen->is_wajib)
                                        <span class="badge badge-success gap-1">
                                            <span class="material-icons text-xs">check_circle</span>
                                            Wajib
                                        </span>
                                    @else
                                        <span class="badge badge-ghost gap-1">
                                            <span class="material-icons text-xs">add_circle_outline</span>
                                            Opsional
                                        </span>
                                    @endif

                                    @if($dokumen->berlaku_untuk === 'SEMUA')
                                        <span class="badge badge-outline gap-1">
                                            <span class="material-icons text-xs">groups</span>
                                            Semua Guru
                                        </span>
                                    @else
                                        <span class="badge badge-secondary gap-1">
                                            <span class="material-icons text-xs">account_balance</span>
                                            Guru Kepsek
                                        </span>
                                    @endif
                                </div>
                            </td>

                            <td>
                                @if($dokumen->is_active)
                                    <span class="badge badge-success gap-1">
                                        <span class="material-icons text-xs">visibility</span>
                                        Aktif
                                    </span>
                                @else
                                    <span class="badge badge-ghost gap-1">
                                        <span class="material-icons text-xs">visibility_off</span>
                                        Nonaktif
                                    </span>
                                @endif
                            </td>

                            <td>
                                <div class="flex justify-center gap-2">
                                    <a
                                        href="{{ route('admin.dokumen.edit', $dokumen->id) }}"
                                        class="btn btn-square btn-sm btn-ghost rounded-xl text-primary hover:bg-primary/10"
                                        title="Edit dokumen"
                                        aria-label="Edit {{ $dokumen->nama_dokumen }}"
                                    >
                                        <span class="material-icons text-base">edit</span>
                                    </a>

                                    <button
                                        type="button"
                                        class="btn btn-square btn-sm btn-ghost rounded-xl text-error hover:bg-error/10"
                                        title="Hapus dokumen"
                                        aria-label="Hapus {{ $dokumen->nama_dokumen }}"
                                        onclick="document.getElementById('hapus-dokumen-{{ $dokumen->id }}').showModal()"
                                    >
                                        <span class="material-icons text-base">delete</span>
                                    </button>
                                </div>

                                <dialog id="hapus-dokumen-{{ $dokumen->id }}" class="modal">
                                    <div class="modal-box rounded-3xl">
                                        <div class="flex items-start gap-3">
                                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-error/10 text-error">
                                                <span class="material-icons">delete_forever</span>
                                            </div>

                                            <div>
                                                <h3 class="font-display text-xl font-semibold">
                                                    Hapus Dokumen?
                                                </h3>

                                                <p class="mt-2 text-sm leading-6 text-neutral/65">
                                                    Dokumen <strong>{{ $dokumen->nama_dokumen }}</strong> akan dihapus dari konfigurasi.
                                                    Tindakan ini dapat memengaruhi daftar dokumen guru.
                                                </p>
                                            </div>
                                        </div>

                                        <div class="modal-action mt-6">
                                            <form method="dialog">
                                                <button type="submit" class="btn btn-ghost rounded-xl">
                                                    Batal
                                                </button>
                                            </form>

                                            <form action="{{ route('admin.dokumen.destroy', $dokumen->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-error rounded-xl">
                                                    <span class="material-icons">delete</span>
                                                    Ya, Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    <form method="dialog" class="modal-backdrop">
                                        <button aria-label="Tutup">Tutup</button>
                                    </form>
                                </dialog>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-14 text-center">
                                <div class="mx-auto flex max-w-sm flex-col items-center">
                                    <div class="flex h-16 w-16 items-center justify-center rounded-3xl bg-base-200 text-primary">
                                        <span class="material-icons text-3xl">description</span>
                                    </div>

                                    <h3 class="font-display mt-4 text-xl font-semibold">
                                        Belum ada dokumen wajib
                                    </h3>

                                    <p class="mt-2 text-sm leading-6 text-neutral/60">
                                        Mulai dengan menambahkan dokumen yang harus diunggah guru pada tiap triwulan.
                                    </p>

                                    <a href="{{ route('admin.dokumen.create') }}" class="btn btn-primary mt-5 rounded-xl">
                                        <span class="material-icons">add</span>
                                        Tambah Dokumen Pertama
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