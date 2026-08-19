@extends('layouts.admin')

@section('title', 'Guru Binaan')

@section('content')
@php
    $totalGuru = $gurus->count();
    $guruAktif = $gurus->where('is_active', true)->count();
    $guruTidakAktif = $totalGuru - $guruAktif;
    $guruKepsek = $gurus->where('status_jabatan', 'GURU_KEPSEK')->count();
@endphp

<div class="mx-auto max-w-7xl space-y-8">

    {{-- Header --}}
    <section class="flex flex-col gap-4 border-b border-base-300 pb-6 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.14em] text-secondary">
                Data Utama
            </p>

            <h1 class="font-display mt-2 text-3xl font-semibold text-base-content md:text-4xl">
                Guru Binaan
            </h1>

            <p class="mt-2 max-w-2xl text-sm leading-6 text-base-content/70">
                Kelola data guru PAI binaan, sekolah asal, NIP/SIAGA, serta status jabatan.
            </p>
        </div>

        <div class="flex flex-wrap gap-2">
            <a
                href="{{ route('admin.guru.link-account') }}"
                class="btn btn-outline btn-primary rounded-xl"
            >
                <span class="material-icons">link</span>
                Hubungkan Akun Guru
            </a>

            <a
                href="{{ route('admin.guru.create') }}"
                class="btn btn-primary rounded-xl"
            >
                <span class="material-icons">person_add</span>
                Tambah Guru Baru
            </a>
        </div>
    </section>

    {{-- Statistik --}}
    <section class="grid grid-cols-2 gap-3 sm:grid-cols-4 sm:gap-4">

        <article class="rounded-2xl border border-base-300 bg-base-100 p-4 shadow-sm sm:p-5">
            <div class="flex items-center justify-between">
                <span class="material-icons text-primary">groups</span>

                <span class="text-[11px] font-bold uppercase tracking-wide text-base-content/50">
                    Total
                </span>
            </div>

            <p class="mt-5 text-sm text-base-content/70">Guru Binaan</p>

            <p class="font-display mt-1 text-3xl font-semibold text-primary">
                {{ $totalGuru }}
            </p>
        </article>

        <article class="rounded-2xl border border-base-300 bg-base-100 p-4 shadow-sm sm:p-5">
            <div class="flex items-center justify-between">
                <span class="material-icons text-success">check_circle</span>

                <span class="text-[11px] font-bold uppercase tracking-wide text-base-content/50">
                    Aktif
                </span>
            </div>

            <p class="mt-5 text-sm text-base-content/70">Guru Aktif</p>

            <p class="font-display mt-1 text-3xl font-semibold text-success">
                {{ $guruAktif }}
            </p>
        </article>

        <article class="rounded-2xl border border-base-300 bg-base-100 p-4 shadow-sm sm:p-5">
            <div class="flex items-center justify-between">
                <span class="material-icons text-warning">pause_circle</span>

                <span class="text-[11px] font-bold uppercase tracking-wide text-base-content/50">
                    Nonaktif
                </span>
            </div>

            <p class="mt-5 text-sm text-base-content/70">Guru Nonaktif</p>

            <p class="font-display mt-1 text-3xl font-semibold text-warning">
                {{ $guruTidakAktif }}
            </p>
        </article>

        <article class="rounded-2xl border border-base-300 bg-base-100 p-4 shadow-sm sm:p-5">
            <div class="flex items-center justify-between">
                <span class="material-icons text-secondary">account_balance</span>

                <span class="text-[11px] font-bold uppercase tracking-wide text-base-content/50">
                    Kepsek
                </span>
            </div>

            <p class="mt-5 text-sm text-base-content/70">Guru + Kepsek</p>

            <p class="font-display mt-1 text-3xl font-semibold text-secondary">
                {{ $guruKepsek }}
            </p>
        </article>
    </section>

    {{-- Informasi Aksi --}}
    <section class="rounded-2xl border border-secondary/30 bg-secondary/10 p-4 sm:p-5">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-start gap-3">
                <span class="material-icons mt-0.5 text-secondary">
                    info
                </span>

                <div>
                    <h2 class="font-semibold text-base-content">
                        Pilih cara menambahkan guru
                    </h2>

                    <p class="mt-1 text-sm leading-6 text-base-content/75">
                        Gunakan <strong>Tambah Guru Baru</strong> untuk memasukkan data master secara manual.
                        Gunakan <strong>Hubungkan Akun Guru</strong> jika guru sudah memiliki akun yang terdaftar di SiPANDU.
                    </p>
                </div>
            </div>

            <a
                href="{{ route('admin.guru.link-account') }}"
                class="btn btn-sm btn-secondary rounded-xl self-start sm:self-auto"
            >
                <span class="material-icons text-base">link</span>
                Hubungkan Akun
            </a>
        </div>
    </section>

    {{-- Tabel Data --}}
    <section class="overflow-hidden rounded-2xl border border-base-300 bg-base-100 shadow-sm">
        <div class="flex flex-col gap-4 border-b border-base-300 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="font-display text-xl font-semibold text-base-content">
                    Daftar Guru Binaan
                </h2>

                <p class="mt-1 text-sm text-base-content/70">
                    Total {{ $totalGuru }} data guru tercatat dalam sistem.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <label class="input input-bordered flex h-10 w-full items-center gap-2 rounded-xl sm:w-72">
                    <span class="material-icons text-base-content/50">
                        search
                    </span>

                    <input
                        id="guru-search"
                        type="search"
                        class="grow"
                        placeholder="Cari nama, sekolah, NIP..."
                        aria-label="Cari guru binaan"
                    >
                </label>

                <a
                    href="{{ route('admin.guru.create') }}"
                    class="btn btn-primary btn-sm rounded-xl"
                >
                    <span class="material-icons text-base">add</span>
                    Tambah
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="table w-full">
                <thead class="bg-base-200 text-base-content/70">
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

                <tbody id="guru-table-body">
                    @forelse($gurus as $index => $guru)
                        @php
                            $inisial = collect(explode(' ', trim($guru->nama_lengkap)))
                                ->filter()
                                ->take(2)
                                ->map(fn ($nama) => strtoupper(substr($nama, 0, 1)))
                                ->implode('');
                        @endphp

                        <tr class="guru-row hover:bg-base-200">
                            <td class="text-center font-medium text-base-content/60">
                                {{ $index + 1 }}
                            </td>

                            <td>
                                <div class="flex min-w-52 items-center gap-3">
                                    <div class="avatar placeholder">
                                        <div class="w-10 rounded-full bg-primary/15 text-primary">
                                            <span class="text-xs font-bold">
                                                {{ $inisial ?: 'G' }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="min-w-0">
                                        <p class="truncate font-semibold text-base-content">
                                            {{ $guru->nama_lengkap }}
                                        </p>

                                        <p class="mt-0.5 text-xs text-base-content/60">
                                            ID Guru: {{ $guru->id }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div class="max-w-56">
                                    <p class="truncate font-medium text-base-content">
                                        {{ $guru->sekolah->nama_sekolah ?? 'Belum diatur' }}
                                    </p>

                                    @if($guru->sekolah)
                                        <p class="mt-0.5 text-xs text-base-content/60">
                                            {{ $guru->sekolah->jenjang ?? '-' }}
                                            ·
                                            {{ $guru->sekolah->status === 'N' ? 'Negeri' : 'Swasta' }}
                                        </p>
                                    @endif
                                </div>
                            </td>

                            <td>
                                <span class="font-mono text-sm text-base-content/70">
                                    {{ $guru->nip_siaga ?? '—' }}
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
                                        <span class="material-icons text-base">
                                            edit
                                        </span>
                                    </a>

                                    <button
                                        type="button"
                                        class="btn btn-square btn-sm btn-ghost rounded-xl text-error hover:bg-error/10"
                                        title="Hapus data {{ $guru->nama_lengkap }}"
                                        aria-label="Hapus data {{ $guru->nama_lengkap }}"
                                        onclick="document.getElementById('delete-guru-{{ $guru->id }}').showModal()"
                                    >
                                        <span class="material-icons text-base">
                                            delete_outline
                                        </span>
                                    </button>
                                </div>

                                <dialog id="delete-guru-{{ $guru->id }}" class="modal">
                                    <div class="modal-box max-w-md rounded-2xl">
                                        <div class="flex items-start gap-3">
                                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-error/15 text-error">
                                                <span class="material-icons">
                                                    warning
                                                </span>
                                            </div>

                                            <div>
                                                <h3 class="font-display text-xl font-semibold text-base-content">
                                                    Hapus Guru Binaan?
                                                </h3>

                                                <p class="mt-2 text-sm leading-6 text-base-content/70">
                                                    Data <strong>{{ $guru->nama_lengkap }}</strong> akan dihapus dari daftar guru binaan.
                                                    Tindakan ini dapat memengaruhi data yang terkait.
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
                                                    <span class="material-icons text-base">
                                                        delete
                                                    </span>
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
                                        <span class="material-icons text-3xl">
                                            groups
                                        </span>
                                    </div>

                                    <h3 class="font-display mt-4 text-xl font-semibold text-base-content">
                                        Belum Ada Guru Binaan
                                    </h3>

                                    <p class="mt-2 max-w-sm text-sm leading-6 text-base-content/70">
                                        Tambahkan data guru binaan terlebih dahulu agar proses registrasi,
                                        triwulan, dan monitoring dapat digunakan.
                                    </p>

                                    <div class="mt-5 flex flex-wrap justify-center gap-2">
                                        <a
                                            href="{{ route('admin.guru.link-account') }}"
                                            class="btn btn-outline btn-primary rounded-xl"
                                        >
                                            <span class="material-icons">
                                                link
                                            </span>
                                            Hubungkan Akun Guru
                                        </a>

                                        <a
                                            href="{{ route('admin.guru.create') }}"
                                            class="btn btn-primary rounded-xl"
                                        >
                                            <span class="material-icons">
                                                person_add
                                            </span>
                                            Tambah Guru Baru
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse

                    <tr id="search-empty-row" class="hidden">
                        <td colspan="7" class="py-12 text-center">
                            <div class="flex flex-col items-center">
                                <span class="material-icons text-4xl text-base-content/40">
                                    search_off
                                </span>

                                <p class="mt-3 font-semibold text-base-content">
                                    Data guru tidak ditemukan
                                </p>

                                <p class="mt-1 text-sm text-base-content/60">
                                    Ubah kata kunci pencarian lalu coba lagi.
                                </p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
    const guruSearch = document.getElementById('guru-search');
    const guruRows = Array.from(document.querySelectorAll('.guru-row'));
    const searchEmptyRow = document.getElementById('search-empty-row');

    if (guruSearch) {
        guruSearch.addEventListener('input', function () {
            const keyword = this.value.toLowerCase().trim();
            let visible = 0;

            guruRows.forEach((row) => {
                const content = row.textContent.toLowerCase();
                const matches = content.includes(keyword);

                row.classList.toggle('hidden', !matches);

                if (matches) {
                    visible++;
                }
            });

            if (searchEmptyRow) {
                searchEmptyRow.classList.toggle(
                    'hidden',
                    visible > 0 || keyword === ''
                );
            }
        });
    }
</script>
@endpush