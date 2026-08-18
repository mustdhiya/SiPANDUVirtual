@extends('layouts.admin')

@section('title', 'Sekolah Binaan')

@section('content')
@php
    $totalSekolah = $sekolahs->count();
    $totalAktif = $sekolahs->where('is_active', true)->count();
    $totalSma = $sekolahs->where('jenjang', 'SMA')->count();
    $totalSmk = $sekolahs->where('jenjang', 'SMK')->count();
@endphp

<div class="space-y-7">

    {{-- Header --}}
    <section class="flex flex-col gap-4 border-b border-base-300 pb-5 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.14em] text-secondary">
                Data Utama
            </p>

            <h1 class="font-display mt-1 text-3xl font-semibold text-neutral">
                Sekolah Binaan
            </h1>

            <p class="mt-2 max-w-2xl text-sm leading-6 text-neutral/60">
                Kelola daftar sekolah SMA dan SMK yang menjadi binaan Pengawas PAI Kota Samarinda.
            </p>
        </div>

        <a href="{{ route('admin.sekolah.create') }}" class="btn btn-primary rounded-xl">
            <span class="material-icons">add</span>
            Tambah Sekolah
        </a>
    </section>

    {{-- Statistik --}}
    <section class="grid grid-cols-2 gap-3 sm:gap-4 lg:grid-cols-4">
        <article class="rounded-2xl border border-base-300 bg-base-100 p-4 shadow-sm sm:p-5">
            <div class="flex items-center justify-between">
                <span class="material-icons text-primary">school</span>
                <span class="text-[11px] font-bold uppercase tracking-wide text-neutral/45">
                    Total
                </span>
            </div>

            <p class="mt-5 text-sm text-neutral/60">Sekolah Terdaftar</p>

            <p class="font-display mt-1 text-3xl font-semibold text-primary">
                {{ $totalSekolah }}
            </p>
        </article>

        <article class="rounded-2xl border border-base-300 bg-base-100 p-4 shadow-sm sm:p-5">
            <div class="flex items-center justify-between">
                <span class="material-icons text-success">check_circle</span>
                <span class="text-[11px] font-bold uppercase tracking-wide text-neutral/45">
                    Aktif
                </span>
            </div>

            <p class="mt-5 text-sm text-neutral/60">Sekolah Aktif</p>

            <p class="font-display mt-1 text-3xl font-semibold text-success">
                {{ $totalAktif }}
            </p>
        </article>

        <article class="rounded-2xl border border-base-300 bg-base-100 p-4 shadow-sm sm:p-5">
            <div class="flex items-center justify-between">
                <span class="material-icons text-secondary">account_balance</span>
                <span class="text-[11px] font-bold uppercase tracking-wide text-neutral/45">
                    Jenjang
                </span>
            </div>

            <p class="mt-5 text-sm text-neutral/60">SMA Binaan</p>

            <p class="font-display mt-1 text-3xl font-semibold text-secondary">
                {{ $totalSma }}
            </p>
        </article>

        <article class="rounded-2xl border border-base-300 bg-base-100 p-4 shadow-sm sm:p-5">
            <div class="flex items-center justify-between">
                <span class="material-icons text-warning">construction</span>
                <span class="text-[11px] font-bold uppercase tracking-wide text-neutral/45">
                    Jenjang
                </span>
            </div>

            <p class="mt-5 text-sm text-neutral/60">SMK Binaan</p>

            <p class="font-display mt-1 text-3xl font-semibold text-warning">
                {{ $totalSmk }}
            </p>
        </article>
    </section>

    {{-- Daftar sekolah --}}
    <section class="overflow-hidden rounded-2xl border border-base-300 bg-base-100 shadow-sm">
        <div class="flex flex-col gap-3 border-b border-base-300 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="font-display text-xl font-semibold text-neutral">
                    Daftar Sekolah
                </h2>
                <p class="mt-1 text-sm text-neutral/60">
                    {{ $totalSekolah }} sekolah tersedia di dalam sistem.
                </p>
            </div>

            <div class="flex items-center gap-2 rounded-xl bg-base-200 px-3 py-2 text-sm text-neutral/60">
                <span class="material-icons text-base text-secondary">info</span>
                Pilih ikon pensil untuk mengubah data.
            </div>
        </div>

        @if($sekolahs->isNotEmpty())
            <div class="overflow-x-auto">
                <table class="table table-zebra w-full">
                    <thead class="bg-base-200 text-neutral">
                        <tr>
                            <th class="w-16">No.</th>
                            <th>Nama Sekolah</th>
                            <th>Jenjang</th>
                            <th>Status Sekolah</th>
                            <th>Status Data</th>
                            <th class="w-32 text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($sekolahs as $index => $sekolah)
                            <tr class="hover">
                                <td class="font-semibold text-neutral/55">
                                    {{ $index + 1 }}
                                </td>

                                <td>
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-primary/10 text-primary">
                                            <span class="material-icons">school</span>
                                        </div>

                                        <div>
                                            <p class="font-semibold text-neutral">
                                                {{ $sekolah->nama_sekolah }}
                                            </p>

                                            <p class="mt-0.5 text-xs text-neutral/55">
                                                ID Sekolah: #{{ $sekolah->id }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <span class="badge badge-outline border-primary/35 bg-primary/5 font-semibold text-primary">
                                        {{ $sekolah->jenjang }}
                                    </span>
                                </td>

                                <td>
                                    @if($sekolah->status === 'N')
                                        <span class="badge badge-info gap-1">
                                            <span class="material-icons text-sm">account_balance</span>
                                            Negeri
                                        </span>
                                    @else
                                        <span class="badge badge-warning gap-1">
                                            <span class="material-icons text-sm">business</span>
                                            Swasta
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    @if($sekolah->is_active)
                                        <span class="badge badge-success gap-1">
                                            <span class="material-icons text-sm">check_circle</span>
                                            Aktif
                                        </span>
                                    @else
                                        <span class="badge badge-ghost gap-1">
                                            <span class="material-icons text-sm">pause_circle</span>
                                            Nonaktif
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    <div class="flex justify-center gap-2">
                                        <a
                                            href="{{ route('admin.sekolah.edit', $sekolah->id) }}"
                                            class="btn btn-square btn-sm btn-outline btn-primary rounded-xl"
                                            title="Ubah data {{ $sekolah->nama_sekolah }}"
                                            aria-label="Ubah data {{ $sekolah->nama_sekolah }}"
                                        >
                                            <span class="material-icons text-base">edit</span>
                                        </a>

                                        <button
                                            type="button"
                                            class="btn btn-square btn-sm btn-outline btn-error rounded-xl"
                                            title="Hapus {{ $sekolah->nama_sekolah }}"
                                            aria-label="Hapus {{ $sekolah->nama_sekolah }}"
                                            onclick="document.getElementById('hapus-sekolah-{{ $sekolah->id }}').showModal()"
                                        >
                                            <span class="material-icons text-base">delete</span>
                                        </button>

                                        <dialog id="hapus-sekolah-{{ $sekolah->id }}" class="modal">
                                            <div class="modal-box max-w-md rounded-3xl">
                                                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-error/10 text-error">
                                                    <span class="material-icons">delete_forever</span>
                                                </div>

                                                <h3 class="font-display mt-4 text-xl font-semibold">
                                                    Hapus Sekolah?
                                                </h3>

                                                <p class="mt-2 text-sm leading-6 text-neutral/65">
                                                    Data <strong>{{ $sekolah->nama_sekolah }}</strong> akan dihapus dari daftar sekolah binaan.
                                                    Pastikan sekolah ini memang tidak lagi diperlukan.
                                                </p>

                                                <div class="modal-action">
                                                    <form method="dialog">
                                                        <button type="button" class="btn btn-ghost rounded-xl">
                                                            Batal
                                                        </button>
                                                    </form>

                                                    <form
                                                        action="{{ route('admin.sekolah.destroy', $sekolah->id) }}"
                                                        method="POST"
                                                    >
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
                                                <button aria-label="Tutup dialog">Tutup</button>
                                            </form>
                                        </dialog>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="flex flex-col items-center justify-center px-6 py-16 text-center">
                <div class="flex h-16 w-16 items-center justify-center rounded-3xl bg-base-200 text-primary">
                    <span class="material-icons text-3xl">school</span>
                </div>

                <h2 class="font-display mt-5 text-2xl font-semibold">
                    Belum ada sekolah binaan
                </h2>

                <p class="mt-2 max-w-md text-sm leading-6 text-neutral/60">
                    Tambahkan sekolah pertama agar data guru binaan dapat dihubungkan dengan sekolahnya.
                </p>

                <a href="{{ route('admin.sekolah.create') }}" class="btn btn-primary mt-5 rounded-xl">
                    <span class="material-icons">add</span>
                    Tambah Sekolah Pertama
                </a>
            </div>
        @endif
    </section>
</div>
@endsection