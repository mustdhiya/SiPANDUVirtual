@extends('layouts.admin')

@section('title', 'Sekolah Binaan')

@section('content')
@php
    $isSuperAdmin = auth()->user()->isAdmin();
@endphp

<div class="mx-auto max-w-6xl space-y-6">

    {{-- Header --}}
    <section class="rounded-2xl border-2 border-base-300 bg-base-100 p-6 shadow-sm">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <span class="badge {{ $isSuperAdmin ? 'badge-secondary' : 'badge-primary' }} mb-2">
                    {{ $isSuperAdmin ? 'Dikelola Super Admin' : 'Daftar Pilihan Sekolah' }}
                </span>
                <h1 class="text-2xl font-extrabold text-base-content sm:text-3xl">
                    Sekolah Binaan
                </h1>
                <p class="mt-2 text-base text-base-content/80">
                    @if($isSuperAdmin)
                        Kelola daftar sekolah SMA/SMK binaan beserta nama Kepala Sekolah. Pengawas dan guru akan memilih dari daftar ini.
                    @else
                        Daftar sekolah SMA/SMK binaan resmi beserta nama Kepala Sekolah (dikelola terpusat oleh Super Admin).
                    @endif
                </p>
            </div>

            @if($isSuperAdmin)
                <a href="{{ route('admin.sekolah.create') }}" class="btn btn-primary btn-lg shrink-0">
                    <span class="material-icons text-2xl">add</span>
                    Tambah Sekolah
                </a>
            @endif
        </div>
    </section>

    {{-- Statistik --}}
    <section class="grid grid-cols-2 gap-4 lg:grid-cols-4">
        <div class="rounded-2xl border-2 border-base-300 bg-base-100 p-5 shadow-sm">
            <p class="text-sm font-bold text-base-content/80">Total Sekolah</p>
            <p class="mt-2 text-3xl font-extrabold text-primary">{{ $totalSekolah }}</p>
        </div>
        <div class="rounded-2xl border-2 border-base-300 bg-base-100 p-5 shadow-sm">
            <p class="text-sm font-bold text-base-content/80">Sekolah Aktif</p>
            <p class="mt-2 text-3xl font-extrabold text-success">{{ $totalAktif }}</p>
        </div>
        <div class="rounded-2xl border-2 border-base-300 bg-base-100 p-5 shadow-sm">
            <p class="text-sm font-bold text-base-content/80">SMA Binaan</p>
            <p class="mt-2 text-3xl font-extrabold text-secondary">{{ $totalSma }}</p>
        </div>
        <div class="rounded-2xl border-2 border-base-300 bg-base-100 p-5 shadow-sm">
            <p class="text-sm font-bold text-base-content/80">SMK Binaan</p>
            <p class="mt-2 text-3xl font-extrabold text-info">{{ $totalSmk }}</p>
        </div>
    </section>

    {{-- Pencarian --}}
    <section class="rounded-2xl border-2 border-base-300 bg-base-100 p-5 shadow-sm">
        <form method="GET" action="{{ route('admin.sekolah.index') }}" class="flex flex-col gap-3 sm:flex-row">
            <input
                type="text"
                name="search"
                value="{{ $search ?? '' }}"
                placeholder="Cari nama sekolah atau nama Kepala Sekolah..."
                class="input input-bordered w-full flex-1"
            />
            <div class="flex gap-2">
                <button type="submit" class="btn btn-primary flex-1 sm:flex-none">
                    <span class="material-icons text-xl">search</span>
                    Cari
                </button>
                @if(!empty($search))
                    <a href="{{ route('admin.sekolah.index') }}" class="btn btn-outline border-2 border-base-300">Reset</a>
                @endif
            </div>
        </form>
    </section>

    {{-- Tabel Sekolah --}}
    <section class="overflow-hidden rounded-2xl border-2 border-base-300 bg-base-100 shadow-sm">
        <div class="overflow-x-auto">
            <table class="table w-full">
                <thead>
                    <tr>
                        <th class="w-12">No.</th>
                        <th>Nama Sekolah</th>
                        <th>Nama Kepala Sekolah</th>
                        <th>Jenjang &amp; Status</th>
                        <th>Keaktifan</th>
                        @if($isSuperAdmin)
                            <th class="text-right">Tindakan</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($sekolahs as $index => $sekolah)
                        <tr class="hover:bg-base-200/60">
                            <td class="font-bold">{{ $sekolahs->firstItem() + $index }}</td>
                            <td class="font-bold text-base-content">{{ $sekolah->nama_sekolah }}</td>
                            <td class="font-medium text-base-content">
                                {{ $sekolah->nama_kepsek ?: 'Belum diisi' }}
                            </td>
                            <td>
                                <div class="flex flex-wrap gap-1.5">
                                    <span class="badge badge-outline border-primary font-bold text-primary">{{ $sekolah->jenjang }}</span>
                                    <span class="badge {{ $sekolah->status === 'N' ? 'badge-info' : 'badge-warning' }}">
                                        {{ $sekolah->status === 'N' ? 'Negeri' : 'Swasta' }}
                                    </span>
                                </div>
                            </td>
                            <td>
                                @if($sekolah->is_active)
                                    <span class="badge badge-success">Aktif</span>
                                @else
                                    <span class="badge badge-ghost border border-base-300">Nonaktif</span>
                                @endif
                            </td>
                            @if($isSuperAdmin)
                                <td class="text-right">
                                    <div class="inline-flex items-center gap-2">
                                        <a href="{{ route('admin.sekolah.edit', $sekolah->id) }}" class="btn btn-outline btn-primary btn-sm border-2">
                                            <span class="material-icons text-base">edit</span>
                                            Ubah
                                        </a>
                                        <form action="{{ route('admin.sekolah.destroy', $sekolah->id) }}" method="POST" onsubmit="return confirm('Hapus sekolah {{ $sekolah->nama_sekolah }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline btn-error btn-sm border-2">
                                                <span class="material-icons text-base">delete</span>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ $isSuperAdmin ? 6 : 5 }}" class="py-12 text-center text-base font-semibold text-base-content/75">
                                Belum ada data sekolah binaan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <div class="flex justify-center pt-2">
        {{ $sekolahs->links() }}
    </div>
</div>
@endsection
