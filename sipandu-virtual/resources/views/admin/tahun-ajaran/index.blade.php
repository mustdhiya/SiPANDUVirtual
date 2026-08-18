@extends('layouts.admin')

@section('title', 'Tahun Ajaran')

@section('content')
@php
    $totalTahunAjaran = $tahunAjarans->count();
    $tahunAjaranAktif = $tahunAjarans->firstWhere('is_active', true);
@endphp

<div class="space-y-7">

    {{-- Header --}}
    <section class="flex flex-col gap-4 border-b border-base-300 pb-5 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.14em] text-secondary">
                Data Utama
            </p>

            <h1 class="font-display mt-1 text-3xl font-semibold text-neutral">
                Tahun Ajaran
            </h1>

            <p class="mt-2 max-w-2xl text-sm leading-6 text-neutral/60">
                Atur periode tahun ajaran yang digunakan sebagai dasar pengelolaan triwulan dan pendampingan guru.
            </p>
        </div>

        <a
            href="{{ route('admin.tahun-ajaran.create') }}"
            class="btn btn-primary rounded-xl"
        >
            <span class="material-icons text-base">add</span>
            Tambah Tahun Ajaran
        </a>
    </section>

    {{-- Summary --}}
    <section class="grid gap-4 sm:grid-cols-2">
        <article class="rounded-2xl border border-base-300 bg-base-100 p-5 shadow-sm">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-sm text-neutral/60">Total Tahun Ajaran</p>
                    <p class="font-display mt-1 text-3xl font-semibold text-primary">
                        {{ $totalTahunAjaran }}
                    </p>
                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-primary/10 text-primary">
                    <span class="material-icons">calendar_today</span>
                </div>
            </div>

            <p class="mt-4 text-sm text-neutral/55">
                Data tahun ajaran tersimpan dalam sistem.
            </p>
        </article>

        <article class="rounded-2xl border border-base-300 bg-base-100 p-5 shadow-sm">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-sm text-neutral/60">Tahun Ajaran Aktif</p>

                    @if($tahunAjaranAktif)
                        <p class="font-display mt-1 text-3xl font-semibold text-secondary">
                            {{ $tahunAjaranAktif->label }}
                        </p>
                    @else
                        <p class="font-display mt-1 text-xl font-semibold text-warning">
                            Belum ditentukan
                        </p>
                    @endif
                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-secondary/15 text-secondary">
                    <span class="material-icons">event_available</span>
                </div>
            </div>

            <p class="mt-4 text-sm text-neutral/55">
                @if($tahunAjaranAktif)
                    Digunakan sebagai periode utama sistem saat ini.
                @else
                    Pilih satu tahun ajaran aktif agar periode dapat digunakan.
                @endif
            </p>
        </article>
    </section>

    {{-- Table --}}
    <section class="overflow-hidden rounded-2xl border border-base-300 bg-base-100 shadow-sm">
        <div class="flex flex-col gap-3 border-b border-base-300 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="font-display text-xl font-semibold text-neutral">
                    Daftar Tahun Ajaran
                </h2>
                <p class="mt-1 text-sm text-neutral/60">
                    Klik ikon pensil untuk mengubah data tahun ajaran.
                </p>
            </div>

            <span class="badge badge-outline gap-2 self-start sm:self-auto">
                <span class="material-icons text-base">list_alt</span>
                {{ $totalTahunAjaran }} data
            </span>
        </div>

        @if($tahunAjarans->isNotEmpty())
            <div class="overflow-x-auto">
                <table class="table table-lg w-full">
                    <thead>
                        <tr class="border-base-300 text-xs uppercase tracking-wide text-neutral/55">
                            <th class="w-20">No.</th>
                            <th>Tahun Ajaran</th>
                            <th>Status</th>
                            <th>Dibuat</th>
                            <th class="w-32 text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($tahunAjarans as $index => $ta)
                            <tr class="hover:bg-base-200/60">
                                <td class="font-medium text-neutral/55">
                                    {{ $index + 1 }}
                                </td>

                                <td>
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-primary/10 text-primary">
                                            <span class="material-icons text-lg">calendar_month</span>
                                        </div>

                                        <div>
                                            <p class="font-display text-lg font-semibold text-neutral">
                                                {{ $ta->label }}
                                            </p>

                                            @if($ta->is_active)
                                                <p class="mt-0.5 text-xs text-neutral/55">
                                                    Periode utama yang sedang digunakan.
                                                </p>
                                            @else
                                                <p class="mt-0.5 text-xs text-neutral/55">
                                                    Periode arsip atau belum digunakan.
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    @if($ta->is_active)
                                        <span class="badge badge-success gap-1 font-semibold">
                                            <span class="material-icons text-sm">check_circle</span>
                                            Aktif
                                        </span>
                                    @else
                                        <span class="badge badge-ghost gap-1">
                                            <span class="material-icons text-sm">pause_circle</span>
                                            Tidak Aktif
                                        </span>
                                    @endif
                                </td>

                                <td class="text-sm text-neutral/60">
                                    <div class="flex flex-col">
                                        <span>{{ $ta->created_at->translatedFormat('d M Y') }}</span>
                                        <span class="text-xs text-neutral/45">
                                            {{ $ta->created_at->format('H:i') }}
                                        </span>
                                    </div>
                                </td>

                                <td>
                                    <div class="flex justify-center gap-2">
                                        <a
                                            href="{{ route('admin.tahun-ajaran.edit', $ta->id) }}"
                                            class="btn btn-square btn-sm btn-ghost rounded-xl text-primary hover:bg-primary/10"
                                            title="Edit tahun ajaran {{ $ta->label }}"
                                            aria-label="Edit tahun ajaran {{ $ta->label }}"
                                        >
                                            <span class="material-icons text-lg">edit</span>
                                        </a>

                                        <button
                                            type="button"
                                            class="btn btn-square btn-sm btn-ghost rounded-xl text-error hover:bg-error/10"
                                            title="Hapus tahun ajaran {{ $ta->label }}"
                                            aria-label="Hapus tahun ajaran {{ $ta->label }}"
                                            onclick="document.getElementById('delete-modal-{{ $ta->id }}').showModal()"
                                        >
                                            <span class="material-icons text-lg">delete</span>
                                        </button>
                                    </div>

                                    <dialog id="delete-modal-{{ $ta->id }}" class="modal">
                                        <div class="modal-box max-w-md rounded-3xl p-6">
                                            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-error/10 text-error">
                                                <span class="material-icons">delete_forever</span>
                                            </div>

                                            <h3 class="font-display mt-4 text-2xl font-semibold text-neutral">
                                                Hapus Tahun Ajaran?
                                            </h3>

                                            <p class="mt-2 text-sm leading-6 text-neutral/65">
                                                Anda akan menghapus tahun ajaran
                                                <strong>{{ $ta->label }}</strong>.
                                                Tindakan ini tidak dapat dibatalkan.
                                            </p>

                                            <div class="modal-action mt-6">
                                                <form method="dialog">
                                                    <button type="submit" class="btn btn-ghost rounded-xl">
                                                        Batal
                                                    </button>
                                                </form>

                                                <form
                                                    action="{{ route('admin.tahun-ajaran.destroy', $ta->id) }}"
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
                                            <button aria-label="Tutup modal">Tutup</button>
                                        </form>
                                    </dialog>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="flex flex-col items-center justify-center px-6 py-16 text-center">
                <div class="flex h-16 w-16 items-center justify-center rounded-3xl bg-primary/10 text-primary">
                    <span class="material-icons text-3xl">calendar_month</span>
                </div>

                <h3 class="font-display mt-5 text-xl font-semibold text-neutral">
                    Belum ada tahun ajaran
                </h3>

                <p class="mt-2 max-w-md text-sm leading-6 text-neutral/60">
                    Tambahkan tahun ajaran terlebih dahulu sebelum membuat periode triwulan.
                </p>

                <a
                    href="{{ route('admin.tahun-ajaran.create') }}"
                    class="btn btn-primary mt-5 rounded-xl"
                >
                    <span class="material-icons text-base">add</span>
                    Tambah Tahun Ajaran
                </a>
            </div>
        @endif
    </section>
</div>
@endsection