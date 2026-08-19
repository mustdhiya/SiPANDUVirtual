@extends('layouts.admin')

@section('title', 'Guru Binaan')

@section('content')
@php
    $totalGuru = $gurus->count();
    $guruAktif = $gurus->where('is_active', true)->count();
    $guruKepsek = $gurus->where('status_jabatan', 'GURU_KEPSEK')->count();
    $guruTerhubung = $gurus->filter(fn ($guru) => $guru->userAccount !== null)->count();
@endphp

<div class="max-w-6xl mx-auto">
    <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between mb-6">
        <div>
            <div class="flex items-center gap-2 text-sm font-bold tracking-wide uppercase text-secondary">
                <span class="material-icons text-base">groups</span>
                Data Utama
            </div>
            <h1 class="font-display text-3xl font-semibold mt-1">Guru Binaan</h1>
            <p class="text-neutral/60 mt-1">Kelola data guru PAI binaan, sekolah, NIP/SIAGA, dan status jabatan.</p>
        </div>
        <a href="{{ route('admin.guru.create') }}" class="btn btn-primary gap-2">
            <span class="material-icons">person_add</span>
            Tambah Guru Binaan
        </a>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-6">
        <div class="stat bg-base-200 border border-base-300 rounded-2xl p-4">
            <div class="stat-figure text-primary"><span class="material-icons">groups</span></div>
            <div class="stat-title">Total Guru</div>
            <div class="stat-value text-primary text-2xl">{{ $totalGuru }}</div>
        </div>
        <div class="stat bg-base-200 border border-base-300 rounded-2xl p-4">
            <div class="stat-figure text-success"><span class="material-icons">check_circle</span></div>
            <div class="stat-title">Guru Aktif</div>
            <div class="stat-value text-success text-2xl">{{ $guruAktif }}</div>
        </div>
        <div class="stat bg-base-200 border border-base-300 rounded-2xl p-4">
            <div class="stat-figure text-secondary"><span class="material-icons">account_balance</span></div>
            <div class="stat-title">Guru + Kepsek</div>
            <div class="stat-value text-secondary text-2xl">{{ $guruKepsek }}</div>
        </div>
        <div class="stat bg-base-200 border border-base-300 rounded-2xl p-4">
            <div class="stat-figure text-info"><span class="material-icons">link</span></div>
            <div class="stat-title">Akun Terhubung</div>
            <div class="stat-value text-info text-2xl">{{ $guruTerhubung }}</div>
        </div>
    </div>

    <div class="card bg-base-100 border border-base-300 shadow-sm">
        <div class="card-body p-0">
            <div class="p-4 border-b border-base-300 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                <div>
                    <h2 class="font-display text-xl font-semibold">Daftar Guru Binaan</h2>
                    <p class="text-sm text-neutral/60">Gunakan kolom pencarian untuk menemukan data guru dengan cepat.</p>
                </div>
                <label class="input input-bordered flex items-center gap-2 w-full md:w-80">
                    <span class="material-icons text-neutral/50">search</span>
                    <input id="guru-search" type="search" class="grow" placeholder="Cari nama, sekolah, atau NIP..." aria-label="Cari guru binaan">
                </label>
            </div>

            <div class="overflow-x-auto">
                <table class="table table-zebra table-md w-full" aria-label="Daftar guru binaan">
                    <thead>
                        <tr>
                            <th>No.</th>
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
                            <tr class="guru-row">
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <div class="flex items-center gap-3">
                                        <div class="avatar placeholder">
                                            <div class="bg-primary text-primary-content rounded-full w-10">
                                                <span class="text-sm font-bold">{{ strtoupper(substr($guru->nama_lengkap, 0, 1)) }}</span>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="font-semibold guru-name">{{ $guru->nama_lengkap }}</div>
                                            <div class="text-xs text-neutral/55">
                                                @if($guru->userAccount)
                                                    <span class="inline-flex items-center gap-1 text-success"><span class="material-icons text-xs">verified</span> Akun terhubung</span>
                                                @else
                                                    <span class="inline-flex items-center gap-1"><span class="material-icons text-xs">person_outline</span> Belum punya akun</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="guru-school">{{ $guru->sekolah->nama_sekolah ?? 'Belum dipilih' }}</td>
                                <td class="font-mono text-sm guru-nip">{{ $guru->nip_siaga ?? '—' }}</td>
                                <td>
                                    @if($guru->status_jabatan === 'GURU')
                                        <span class="badge badge-info gap-1"><span class="material-icons text-xs">school</span> Guru PAI</span>
                                    @else
                                        <span class="badge badge-secondary gap-1"><span class="material-icons text-xs">account_balance</span> Guru + Kepsek</span>
                                    @endif
                                </td>
                                <td>
                                    @if($guru->is_active)
                                        <span class="badge badge-success gap-1"><span class="material-icons text-xs">check_circle</span> Aktif</span>
                                    @else
                                        <span class="badge badge-ghost gap-1"><span class="material-icons text-xs">pause_circle</span> Nonaktif</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('admin.guru.edit', $guru->id) }}" class="btn btn-sm btn-outline btn-primary" title="Edit {{ $guru->nama_lengkap }}">
                                            <span class="material-icons text-base">edit</span>
                                            <span class="hidden lg:inline">Edit</span>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline btn-error" onclick="document.getElementById('delete-guru-{{ $guru->id }}').showModal()" title="Hapus {{ $guru->nama_lengkap }}">
                                            <span class="material-icons text-base">delete</span>
                                        </button>
                                    </div>

                                    <dialog id="delete-guru-{{ $guru->id }}" class="modal">
                                        <div class="modal-box">
                                            <div class="flex items-start gap-3">
                                                <span class="material-icons text-error text-3xl">warning</span>
                                                <div>
                                                    <h3 class="font-display text-xl font-semibold">Hapus data guru?</h3>
                                                    <p class="py-2 text-neutral/70">Data <strong>{{ $guru->nama_lengkap }}</strong> akan dihapus dari daftar guru binaan.</p>
                                                </div>
                                            </div>
                                            <div class="modal-action">
                                                <form method="dialog"><button type="submit" class="btn btn-ghost">Batal</button></form>
                                                <form action="{{ route('admin.guru.destroy', $guru->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-error">Ya, Hapus</button>
                                                </form>
                                            </div>
                                        </div>
                                        <form method="dialog" class="modal-backdrop"><button>tutup</button></form>
                                    </dialog>
                                </td>
                            </tr>
                        @empty
                            <tr id="empty-guru-row">
                                <td colspan="7" class="py-12 text-center">
                                    <span class="material-icons text-5xl text-neutral/30">group_off</span>
                                    <p class="mt-3 font-semibold">Belum ada guru binaan</p>
                                    <p class="text-sm text-neutral/60">Tambahkan guru binaan terlebih dahulu untuk memulai.</p>
                                    <a href="{{ route('admin.guru.create') }}" class="btn btn-primary btn-sm mt-4">Tambah Guru Binaan</a>
                                </td>
                            </tr>
                        @endforelse
                        <tr id="search-empty-row" class="hidden">
                            <td colspan="7" class="py-10 text-center text-neutral/60">Data guru yang dicari tidak ditemukan.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
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
                if (matches) visible++;
            });

            if (searchEmptyRow) {
                searchEmptyRow.classList.toggle('hidden', visible > 0 || keyword === '');
            }
        });
    }
</script>
@endpush