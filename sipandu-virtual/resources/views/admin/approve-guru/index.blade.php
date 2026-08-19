@extends('layouts.admin')

@section('title', 'Persetujuan Guru')

@section('content')
@php
    $totalPending = $pendingGurus->count();
@endphp

<div class="mx-auto max-w-7xl space-y-8">

    {{-- Header --}}
    <section class="flex flex-col gap-5 border-b border-base-300 pb-6 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-[0.14em] text-secondary">
                <span class="material-icons text-base">how_to_reg</span>
                Pendampingan
            </div>

            <h1 class="font-display mt-2 text-3xl font-semibold leading-tight text-base-content md:text-4xl">
                Persetujuan Guru
            </h1>

            <p class="mt-2 max-w-2xl text-sm leading-6 text-base-content/70">
                Periksa data pendaftar sebelum mengaktifkan akses mereka ke SiPANDU VIRTUAL.
            </p>
        </div>

        <div class="rounded-2xl border border-base-300 bg-base-200 px-4 py-3">
            <div class="flex items-center gap-2">
                <span class="material-icons text-secondary">person_add</span>
                <span class="text-sm font-semibold text-base-content">
                    {{ $totalPending }} Guru Menunggu
                </span>
            </div>

            <p class="mt-1 text-xs text-base-content/60">
                Perlu diverifikasi oleh Pengawas PAI.
            </p>
        </div>
    </section>

    {{-- Penjelasan --}}
    <section class="rounded-2xl border border-secondary/30 bg-secondary/10 p-4 sm:p-5">
        <div class="flex items-start gap-3">
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-secondary/20 text-secondary">
                <span class="material-icons">info</span>
            </div>

            <div>
                <h2 class="font-semibold text-base-content">
                    Periksa sebelum menyetujui
                </h2>

                <p class="mt-1 text-sm leading-6 text-base-content/75">
                    Pastikan nama, email, serta nomor WhatsApp sesuai dengan data Guru Binaan.
                    Guru yang disetujui akan dapat masuk dan mengakses layanan pendampingan.
                </p>
            </div>
        </div>
    </section>

    {{-- Daftar pending --}}
    <section class="card border border-base-300 bg-base-100 shadow-sm">
        <div class="card-body p-0">

            <div class="flex flex-col gap-3 border-b border-base-300 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                <div>
                    <h2 class="font-display text-xl font-semibold text-base-content">
                        Daftar Pendaftaran
                    </h2>

                    <p class="mt-1 text-sm text-base-content/70">
                        Data akun guru yang sedang menunggu keputusan Anda.
                    </p>
                </div>

                @if($totalPending > 0)
                    <span class="badge badge-warning gap-2 self-start sm:self-auto">
                        <span class="material-icons text-sm">schedule</span>
                        {{ $totalPending }} menunggu
                    </span>
                @endif
            </div>

            @if($pendingGurus->isNotEmpty())

                {{-- Desktop table --}}
                <div class="hidden overflow-x-auto md:block">
                    <table class="table w-full">
                        <thead class="bg-base-200 text-base-content/70">
                            <tr>
                                <th class="pl-6">Guru</th>
                                <th>Kontak</th>
                                <th>Waktu Daftar</th>
                                <th class="pr-6 text-right">Tindakan</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($pendingGurus as $guru)
                                <tr class="hover:bg-base-200">
                                    <td class="pl-6">
                                        <div class="flex items-center gap-3">
                                            <div class="avatar placeholder">
                                                <div class="w-10 rounded-full bg-primary text-primary-content">
                                                    <span class="text-sm font-bold">
                                                        {{ strtoupper(substr($guru->name, 0, 1)) }}
                                                    </span>
                                                </div>
                                            </div>

                                            <div>
                                                <p class="font-semibold text-base-content">
                                                    {{ $guru->name }}
                                                </p>

                                                <p class="mt-0.5 text-xs text-base-content/60">
                                                    ID Pendaftar: #{{ $guru->id }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="space-y-2">
                                            <p class="flex items-center gap-2 text-sm text-base-content/75">
                                                <span class="material-icons text-base text-base-content/50">mail</span>
                                                {{ $guru->email }}
                                            </p>

                                            <p class="flex items-center gap-2 text-sm text-base-content/75">
                                                <span class="material-icons text-base text-base-content/50">phone</span>
                                                {{ $guru->nomor_wa ?: 'Nomor WA belum diisi' }}
                                            </p>
                                        </div>
                                    </td>

                                    <td>
                                        <p class="text-sm font-medium text-base-content">
                                            {{ $guru->created_at->translatedFormat('d M Y') }}
                                        </p>

                                        <p class="mt-0.5 text-xs text-base-content/60">
                                            Pukul {{ $guru->created_at->format('H:i') }}
                                        </p>
                                    </td>

                                    <td class="pr-6 text-right">
                                        <div class="flex justify-end gap-2">
                                            <button
                                                type="button"
                                                class="btn btn-sm btn-success rounded-xl"
                                                onclick="document.getElementById('approve-modal-{{ $guru->id }}').showModal()"
                                            >
                                                <span class="material-icons text-base">check</span>
                                                Setujui
                                            </button>

                                            <button
                                                type="button"
                                                class="btn btn-sm btn-outline btn-error rounded-xl"
                                                onclick="document.getElementById('reject-modal-{{ $guru->id }}').showModal()"
                                            >
                                                <span class="material-icons text-base">close</span>
                                                Tolak
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                {{-- Modal approve --}}
                                <dialog id="approve-modal-{{ $guru->id }}" class="modal">
                                    <div class="modal-box max-w-md rounded-3xl p-0">
                                        <div class="border-b border-base-300 p-6">
                                            <div class="flex items-start gap-4">
                                                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-success/15 text-success">
                                                    <span class="material-icons">how_to_reg</span>
                                                </div>

                                                <div>
                                                    <h3 class="font-display text-xl font-semibold text-base-content">
                                                        Setujui Pendaftaran?
                                                    </h3>

                                                    <p class="mt-1 text-sm leading-6 text-base-content/70">
                                                        Guru akan mendapatkan akses ke SiPANDU VIRTUAL setelah disetujui.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="p-6">
                                            <div class="rounded-2xl border border-base-300 bg-base-200 p-4">
                                                <p class="font-semibold text-base-content">
                                                    {{ $guru->name }}
                                                </p>

                                                <p class="mt-1 text-sm text-base-content/70">
                                                    {{ $guru->email }}
                                                </p>

                                                <p class="mt-1 text-sm text-base-content/70">
                                                    {{ $guru->nomor_wa ?: 'Nomor WA belum diisi' }}
                                                </p>
                                            </div>

                                            <form
                                                action="{{ route('admin.approve-guru.approve', $guru->id) }}"
                                                method="POST"
                                                class="mt-6 flex flex-col-reverse gap-2 sm:flex-row sm:justify-end"
                                            >
                                                @csrf

                                                <button
                                                    type="button"
                                                    class="btn btn-ghost rounded-xl"
                                                    onclick="document.getElementById('approve-modal-{{ $guru->id }}').close()"
                                                >
                                                    Batal
                                                </button>

                                                <button type="submit" class="btn btn-success rounded-xl">
                                                    <span class="material-icons text-base">check_circle</span>
                                                    Ya, Setujui Guru
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    <form method="dialog" class="modal-backdrop">
                                        <button aria-label="Tutup modal">Tutup</button>
                                    </form>
                                </dialog>

                                {{-- Modal reject --}}
                                <dialog id="reject-modal-{{ $guru->id }}" class="modal">
                                    <div class="modal-box max-w-md rounded-3xl p-0">
                                        <div class="border-b border-base-300 p-6">
                                            <div class="flex items-start gap-4">
                                                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-error/15 text-error">
                                                    <span class="material-icons">person_off</span>
                                                </div>

                                                <div>
                                                    <h3 class="font-display text-xl font-semibold text-base-content">
                                                        Tolak Pendaftaran
                                                    </h3>

                                                    <p class="mt-1 text-sm leading-6 text-base-content/70">
                                                        Berikan alasan yang jelas agar guru memahami langkah berikutnya.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                        <form
                                            action="{{ route('admin.approve-guru.reject', $guru->id) }}"
                                            method="POST"
                                            class="p-6"
                                        >
                                            @csrf

                                            <div class="rounded-2xl border border-base-300 bg-base-200 p-4">
                                                <p class="font-semibold text-base-content">
                                                    {{ $guru->name }}
                                                </p>

                                                <p class="mt-1 text-sm text-base-content/70">
                                                    {{ $guru->email }}
                                                </p>
                                            </div>

                                            <div class="form-control mt-5">
                                                <label for="alasan-{{ $guru->id }}" class="label px-0">
                                                    <span class="label-text font-semibold">
                                                        Alasan Penolakan
                                                    </span>
                                                </label>

                                                <textarea
                                                    id="alasan-{{ $guru->id }}"
                                                    name="alasan"
                                                    class="textarea textarea-bordered min-h-28 rounded-xl"
                                                    placeholder="Contoh: Data NIP/SIAGA belum sesuai dengan data Guru Binaan."
                                                    required
                                                ></textarea>

                                                <label class="label px-0">
                                                    <span class="label-text-alt text-base-content/60">
                                                        Alasan ini akan disampaikan kepada guru.
                                                    </span>
                                                </label>
                                            </div>

                                            <div class="mt-5 flex flex-col-reverse gap-2 sm:flex-row sm:justify-end">
                                                <button
                                                    type="button"
                                                    class="btn btn-ghost rounded-xl"
                                                    onclick="document.getElementById('reject-modal-{{ $guru->id }}').close()"
                                                >
                                                    Batal
                                                </button>

                                                <button type="submit" class="btn btn-error rounded-xl">
                                                    <span class="material-icons text-base">close</span>
                                                    Tolak Pendaftaran
                                                </button>
                                            </div>
                                        </form>
                                    </div>

                                    <form method="dialog" class="modal-backdrop">
                                        <button aria-label="Tutup modal">Tutup</button>
                                    </form>
                                </dialog>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Mobile cards --}}
                <div class="space-y-3 p-4 md:hidden">
                    @foreach($pendingGurus as $guru)
                        <article class="rounded-2xl border border-base-300 bg-base-100 p-4">
                            <div class="flex items-start gap-3">
                                <div class="avatar placeholder">
                                    <div class="w-11 rounded-full bg-primary text-primary-content">
                                        <span class="text-sm font-bold">
                                            {{ strtoupper(substr($guru->name, 0, 1)) }}
                                        </span>
                                    </div>
                                </div>

                                <div class="min-w-0 flex-1">
                                    <p class="truncate font-semibold text-base-content">
                                        {{ $guru->name }}
                                    </p>

                                    <p class="mt-1 truncate text-sm text-base-content/70">
                                        {{ $guru->email }}
                                    </p>

                                    <p class="mt-1 text-sm text-base-content/70">
                                        {{ $guru->nomor_wa ?: 'Nomor WA belum diisi' }}
                                    </p>

                                    <p class="mt-2 text-xs text-base-content/60">
                                        Daftar: {{ $guru->created_at->translatedFormat('d M Y, H:i') }}
                                    </p>
                                </div>
                            </div>

                            <div class="mt-4 grid grid-cols-2 gap-2">
                                <button
                                    type="button"
                                    class="btn btn-success rounded-xl"
                                    onclick="document.getElementById('approve-modal-{{ $guru->id }}').showModal()"
                                >
                                    <span class="material-icons text-base">check</span>
                                    Setujui
                                </button>

                                <button
                                    type="button"
                                    class="btn btn-outline btn-error rounded-xl"
                                    onclick="document.getElementById('reject-modal-{{ $guru->id }}').showModal()"
                                >
                                    <span class="material-icons text-base">close</span>
                                    Tolak
                                </button>
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                {{-- Empty state --}}
                <div class="flex flex-col items-center px-5 py-14 text-center sm:px-8">
                    <div class="flex h-16 w-16 items-center justify-center rounded-full bg-success/15 text-success">
                        <span class="material-icons text-3xl">check_circle</span>
                    </div>

                    <h2 class="font-display mt-5 text-2xl font-semibold text-base-content">
                        Semua Pendaftaran Sudah Ditangani
                    </h2>

                    <p class="mt-2 max-w-md text-sm leading-6 text-base-content/70">
                        Tidak ada akun guru yang sedang menunggu persetujuan.
                        Pendaftaran baru akan muncul di halaman ini.
                    </p>

                    <a href="{{ route('admin.dashboard') }}" class="btn btn-primary mt-6 rounded-xl">
                        <span class="material-icons text-base">dashboard</span>
                        Kembali ke Dashboard
                    </a>
                </div>
            @endif
        </div>
    </section>
</div>
@endsection