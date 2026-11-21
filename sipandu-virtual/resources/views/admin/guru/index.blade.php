@extends('layouts.admin')

@section('title', 'Daftar Guru Binaan')

@section('content')
@php
    $isSuperAdmin = auth()->user()->isAdmin();
@endphp

<div class="mx-auto max-w-6xl space-y-6">

    {{-- Header --}}
    <section class="rounded-2xl border-2 border-base-300 bg-base-100 p-6 shadow-sm">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <span class="badge badge-primary mb-2">Data Binaan</span>
                <h1 class="text-2xl font-extrabold text-base-content sm:text-3xl">
                    Daftar Guru Binaan
                </h1>
                <p class="mt-2 text-base text-base-content/80">
                    @if($isSuperAdmin)
                        Menampilkan seluruh guru PAI binaan dari semua pengawas. Pengaturan ubah peran &amp; kata sandi berada di menu <strong>Khusus Super Admin &rarr; Akun &amp; Kata Sandi</strong>.
                    @else
                        Daftar guru PAI yang berada di bawah binaan Anda.
                    @endif
                </p>
            </div>

            <a href="{{ route('admin.guru.create') }}" class="btn btn-primary btn-lg shrink-0">
                <span class="material-icons text-2xl">person_add</span>
                Tambah Guru
            </a>
        </div>
    </section>

    {{-- Ringkasan --}}
    <section class="grid grid-cols-2 gap-4">
        <div class="rounded-2xl border-2 border-base-300 bg-base-100 p-5 shadow-sm">
            <p class="text-sm font-bold text-base-content/80">Total Guru Binaan</p>
            <p class="mt-2 text-3xl font-extrabold text-primary">{{ $totalGuru }}</p>
        </div>
        <div class="rounded-2xl border-2 border-base-300 bg-base-100 p-5 shadow-sm">
            <p class="text-sm font-bold text-base-content/80">Guru Aktif</p>
            <p class="mt-2 text-3xl font-extrabold text-success">{{ $totalAktif }}</p>
        </div>
    </section>

    {{-- Pencarian --}}
    <section class="rounded-2xl border-2 border-base-300 bg-base-100 p-5 shadow-sm">
        <form method="GET" action="{{ route('admin.guru.index') }}" class="flex flex-col gap-3 sm:flex-row">
            <input
                type="text"
                name="search"
                value="{{ $search ?? '' }}"
                placeholder="Cari nama guru atau NIP / SIAGA..."
                class="input input-bordered w-full flex-1"
            />
            <div class="flex gap-2">
                <button type="submit" class="btn btn-primary flex-1 sm:flex-none">
                    <span class="material-icons text-xl">search</span>
                    Cari
                </button>
                @if(!empty($search))
                    <a href="{{ route('admin.guru.index') }}" class="btn btn-outline border-2 border-base-300">Reset</a>
                @endif
            </div>
        </form>
    </section>

    {{-- Tabel Guru Binaan --}}
    <section class="overflow-hidden rounded-2xl border-2 border-base-300 bg-base-100 shadow-sm">
        <div class="overflow-x-auto">
            <table class="table w-full">
                <thead>
                    <tr class="!bg-[#243c2c] !text-white">
                        <th class="w-12 !bg-[#243c2c] !text-white">No.</th>
                        <th class="!bg-[#243c2c] !text-white">Nama Guru &amp; NIP/SIAGA</th>
                        <th class="!bg-[#243c2c] !text-white">Sekolah &amp; Kepala Sekolah</th>
                        @if($isSuperAdmin)
                            <th class="!bg-[#243c2c] !text-white">Pengawas Pembimbing</th>
                        @endif
                        <th class="!bg-[#243c2c] !text-white">Sertifikasi &amp; Status</th>
                        <th class="text-right !bg-[#243c2c] !text-white">Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($gurus as $index => $guru)
                        <tr class="hover:bg-base-200/60">
                            <td class="font-bold">{{ $gurus->firstItem() + $index }}</td>

                            <td>
                                <p class="font-bold text-base-content">{{ $guru->nama_lengkap }}</p>
                                <p class="text-xs font-medium text-base-content/75">
                                    NIP/SIAGA: {{ $guru->nip_siaga ?: '-' }}
                                    &middot; {{ $guru->status_jabatan === 'GURU_KEPSEK' ? 'Guru PAI & Kepsek' : 'Guru PAI' }}
                                </p>
                            </td>

                            <td>
                                <p class="font-semibold text-base-content">
                                    {{ $guru->sekolah->nama_sekolah ?? 'Belum dipilih' }}
                                </p>
                                @if(!empty($guru->sekolah?->nama_kepsek))
                                    <p class="text-xs text-base-content/75">
                                        Kepsek: {{ $guru->sekolah->nama_kepsek }}
                                    </p>
                                @endif
                            </td>

                            @if($isSuperAdmin)
                                <td>
                                    <span class="font-medium text-base-content">
                                        {{ $guru->pengawas->name ?? 'Belum diatur' }}
                                    </span>
                                </td>
                            @endif

                            <td>
                                <div class="flex flex-wrap gap-1.5">
                                    @if(!empty($guru->sudah_sertifikasi))
                                        <span class="badge badge-success">Sertifikasi</span>
                                    @else
                                        <span class="badge badge-warning">Belum Sertifikasi</span>
                                    @endif

                                    @if($guru->is_active)
                                        <span class="badge badge-outline border-success text-success">Aktif</span>
                                    @else
                                        <span class="badge badge-ghost border border-base-300">Nonaktif</span>
                                    @endif
                                </div>
                            </td>

                            <td class="text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('admin.guru.edit', $guru->id) }}" class="btn btn-outline btn-primary btn-sm border-2">
                                        <span class="material-icons text-base">edit</span>
                                        Ubah
                                    </a>
                                    <form action="{{ route('admin.guru.destroy', $guru->id) }}" method="POST" onsubmit="return confirm('Hapus data guru {{ $guru->nama_lengkap }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline btn-error btn-sm border-2">
                                            <span class="material-icons text-base">delete</span>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ $isSuperAdmin ? 6 : 5 }}" class="py-12 text-center text-base font-semibold text-base-content/75">
                                Belum ada data guru binaan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <div class="flex justify-center pt-2">
        {{ $gurus->links() }}
    </div>
</div>
@endsection
