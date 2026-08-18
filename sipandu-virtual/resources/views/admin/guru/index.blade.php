@extends('layouts.admin')

@section('title', 'Guru Binaan')

@section('content')
@php
    $totalGuru = $gurus->count();
    $guruAktif = $gurus->where('is_active', true)->count();
    $guruTidakAktif = $totalGuru - $guruAktif;
    $guruKepsek = $gurus->where('status_jabatan', 'GURU_KEPSEK')->count();
@endphp

<div class="space-y-7">

    {{-- Header --}}
    <section class="flex flex-col gap-4 border-b border-base-300 pb-5 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.14em] text-secondary">
                Data Utama
            </p>

            <h1 class="font-display mt-1 text-3xl font-semibold text-neutral">
                Guru Binaan
            </h1>

            <p class="mt-2 max-w-2xl text-sm leading-6 text-neutral/60">
                Kelola data guru PAI binaan, sekolah asal, NIP/SIAGA, serta status jabatan.
            </p>
        </div>

        <a
            href="{{ route('admin.guru.create') }}"
            class="btn btn-primary rounded-xl"
        >
            <span class="material-icons">person_add</span>
            Tambah Guru
        </a>
    </section>

    {{-- Statistik --}}
    <section class="grid grid-cols-2 gap-3 sm:grid-cols-4 sm:gap-4">
        <article class="rounded-2xl border border-base-300 bg-base-100 p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="material-icons text-primary">groups</span>
                <span class="text-[11px] font-bold uppercase tracking-wide text-neutral/45">Total</span>
            </div>
            <p class="mt-4 text-sm text-neutral/60">Guru Binaan</p>
            <p class="font-display mt-1 text-3xl font-semibold text-primary">
                {{ $totalGuru }}
            </p>
        </article>

        <article class="rounded-2xl border border-base-300 bg-base-100 p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="material-icons text-success">check_circle</span>
                <span class="text-[11px] font-bold uppercase tracking-wide text-neutral/45">Aktif</span>
            </div>
            <p class="mt-4 text-sm text-neutral/60">Guru Aktif</p>
            <p class="font-display mt-1 text-3xl font-semibold text-success">
                {{ $guruAktif }}
            </p>
        </article>

        <article class="rounded-2xl border border-base-300 bg-base-100 p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="material-icons text-warning">pause_circle</span>
                <span class="text-[11px] font-bold uppercase tracking-wide text-neutral/45">Nonaktif</span>
            </div>
            <p class="mt-4 text-sm text-neutral/60">Guru Nonaktif</p>
            <p class="font-display mt-1 text-3xl font-semibold text-warning">
                {{ $guruTidakAktif }}
            </p>
        </article>

        <article class="rounded-2xl border border-base-300 bg-base-100 p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="material-icons text-secondary">account_balance</span>
                <span class="text-[11px] font-bold uppercase tracking-wide text-neutral/45">Kepsek</span>
            </div>
            <p class="mt-4 text-sm text-neutral/60">Guru + Kepsek</p>
            <p class="font-display mt-1 text-3xl font-semibold text-secondary">
                {{ $guruKepsek }}
            </p>
        </article>
    </section>

    {{-- Tabel Data --}}
    <section class="overflow-hidden rounded-2xl border border-base-300 bg-base-100 shadow-sm">
        <div class="flex flex-col gap-3 border-b border-base-300 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="font-display text-xl font-semibold text-neutral">
                    Daftar Guru Binaan
                </h2>
                <p class="mt-1 text-sm text-neutral/60">
                    Total {{ $totalGuru }} data guru tercatat dalam sistem.
                </p>
            </div>

            <a href="{{ route('admin.guru.create') }}" class="btn btn-outline btn-primary btn-sm rounded-xl">
                <span class="material-icons text-base">add</span>
                Tambah Data
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="table w-full">
                <thead class="bg-base-200/70 text-neutral/65">
                    <tr>
                        <th class="w-14 text-center">No.</th>
                        <th>Guru Binaan</th>
                        <th>Sekolah</th>
                        <th>NIP / SIAGA</th>
                        <th>Jabatan</th>
                        <th>Status</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($gurus as $index => $guru)
                        @php
                            $inisial = collect(explode(' ', trim($guru->nama_lengkap)))
                                ->filter()
                                ->take(2)
                                ->map(fn ($nama) => strtoupper(substr($nama, 0, 1)))
                                ->implode('');
                        @endphp

                        <tr class="hover:bg-base-200/40">
                            <td class="text-center font-medium text-neutral/60">
                                {{ $index + 1 }}
                            </td>

                            <td>
                                <div class="flex min-w-52 items-center gap-3">
                                    <div class="avatar placeholder">
                                        <div class="w-10 rounded-full bg-primary/15 text-primary">
                                            <span class="text-xs font-bold">{{ $inisial ?: 'G' }}</span>
                                        </div>
                                    </div>

                                    <div class="min-w-0">
                                        <p class="truncate font-semibold text-neutral">
                                            {{ $guru->nama_lengkap }}
                                        </p>
                                        <p class="text-xs text-neutral/55">
                                            ID Guru: {{ $guru->id }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div class="max-w-56">
                                    <p class="truncate font-medium">
                                        {{ $guru->sekolah->nama_sekolah ?? 'Belum diatur' }}
                                    </p>

                                    @if($guru->sekolah)
                                        <p class="text-xs text-neutral/55">
                                            {{ $guru->sekolah->jenjang ?? '-' }}
                                            ·
                                            {{ $guru->sekolah->status === 'N' ? 'Negeri' : 'Swasta' }}
                                        </p>
                                    @endif
                                </div>
                            </td>

                            <td>
                                <span class="font-mono text-sm text-neutral/70">
                                    {{ $guru->nip_siaga ?? '-' }}
                                </span>
                            </td>

                            <td>
                                @if($guru->status_jabatan === 'GURU')
                                    <span class="badge badge-primary badge-outline gap-1">
                                        <span class="material-icons text-xs">person</span>
                                        Guru PAI
                                    </span>
                                @else
                                    <span class="badge badge-secondary gap-1">
                                        <span class="material-icons text-xs">account_balance</span>
                                        Guru + Kepsek
                                    </span>
                                @endif
                            </td>

                            <td>
                                @if($guru->is_active)
                                    <span class="badge badge-success gap-1">
                                        <span class="material-icons text-xs">check_circle</span>
                                        Aktif
                                    </span>
                                @else
                                    <span class="badge badge-warning gap-1">
                                        <span class="material-icons text-xs">pause_circle</span>
                                        Nonaktif
                                    </span>
                                @endif
                            </td>

                            <td>
                                <div class="flex justify-end gap-2">
                                    <a
                                        href="{{ route('admin.guru.edit', $guru->id) }}"
                                        class="btn btn-square btn-sm btn-ghost rounded-xl text-primary hover:bg-primary/10"
                                        title="Edit data {{ $guru->nama_lengkap }}"
                                        aria-label="Edit data {{ $guru->nama_lengkap }}"
                                    >
                                        <span class="material-icons text-base">edit</span>
                                    </a>

                                    <button
                                        type="button"
                                        class="btn btn-square btn-sm btn-ghost rounded-xl text-error hover:bg-error/10"
                                        title="Hapus data {{ $guru->nama_lengkap }}"
                                        aria-label="Hapus data {{ $guru->nama_lengkap }}"
                                        onclick="document.getElementById('delete-guru-{{ $guru->id }}').showModal()"
                                    >
                                        <span class="material-icons text-base">delete_outline</span>
                                    </button>
                                </div>

                                <dialog id="delete-guru-{{ $guru->id }}" class="modal">
                                    <div class="modal-box max-w-md rounded-2xl">
                                        <div class="flex items-start gap-3">
                                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-error/10 text-error">
                                                <span class="material-icons">warning</span>
                                            </div>

                                            <div>
                                                <h3 class="font-display text-xl font-semibold">
                                                    Hapus Guru Binaan?
                                                </h3>

                                                <p class="mt-2 text-sm leading-6 text-neutral/65">
                                                    Data <strong>{{ $guru->nama_lengkap }}</strong> akan dinonaktifkan dari daftar utama.
                                                    Tindakan ini dapat memengaruhi relasi data terkait.
                                                </p>
                                            </div>
                                        </div>

                                        <div class="modal-action">
                                            <form method="dialog">
                                                <button type="submit" class="btn btn-ghost rounded-xl">
                                                    Batal
                                                </button>
                                            </form>

                                            <form action="{{ route('admin.guru.destroy', $guru->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-error rounded-xl">
                                                    <span class="material-icons text-base">delete</span>
                                                    Hapus Guru
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    <form method="dialog" class="modal-backdrop">
                                        <button type="submit">Tutup</button>
                                    </form>
                                </dialog>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="flex flex-col items-center justify-center px-4 py-14 text-center">
                                    <div class="flex h-16 w-16 items-center justify-center rounded-full bg-base-200 text-primary">
                                        <span class="material-icons text-3xl">groups</span>
                                    </div>

                                    <h3 class="font-display mt-4 text-xl font-semibold">
                                        Belum Ada Guru Binaan
                                    </h3>

                                    <p class="mt-2 max-w-sm text-sm leading-6 text-neutral/60">
                                        Tambahkan data guru binaan terlebih dahulu agar proses registrasi, triwulan, dan monitoring dapat digunakan.
                                    </p>

                                    <a href="{{ route('admin.guru.create') }}" class="btn btn-primary mt-5 rounded-xl">
                                        <span class="material-icons">person_add</span>
                                        Tambah Guru Pertama
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