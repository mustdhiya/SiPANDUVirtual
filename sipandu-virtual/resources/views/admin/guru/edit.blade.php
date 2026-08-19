@extends('layouts.admin')

@section('title', 'Edit Guru Binaan')

@section('content')
@php
    $inisial = collect(explode(' ', trim($guru->nama_lengkap)))
        ->filter()
        ->take(2)
        ->map(fn ($nama) => strtoupper(substr($nama, 0, 1)))
        ->implode('');
@endphp

<div class="mx-auto max-w-4xl space-y-6">

    {{-- Header --}}
    <section class="flex flex-col gap-4 border-b border-base-300 pb-6 sm:flex-row sm:items-end sm:justify-between">
        <div class="flex items-center gap-4">
            <div class="avatar placeholder">
                <div class="w-14 rounded-2xl bg-primary/15 text-primary">
                    <span class="font-display text-lg font-semibold">
                        {{ $inisial ?: 'G' }}
                    </span>
                </div>
            </div>

            <div>
                <p class="text-xs font-bold uppercase tracking-[0.14em] text-secondary">
                    Data Utama
                </p>

                <h1 class="font-display mt-1 text-3xl font-semibold text-base-content">
                    Edit Guru Binaan
                </h1>

                <p class="mt-1 text-sm text-base-content/70">
                    {{ $guru->nama_lengkap }}
                </p>
            </div>
        </div>

        <a href="{{ route('admin.guru.index') }}" class="btn btn-ghost rounded-xl">
            <span class="material-icons">arrow_back</span>
            Kembali
        </a>
    </section>

    <form action="{{ route('admin.guru.update', $guru->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Informasi Utama --}}
        <section class="card border border-base-300 bg-base-100 shadow-sm">
            <div class="card-body gap-6 p-5 sm:p-7">
                <div class="flex items-start gap-3">
                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-primary/15 text-primary">
                        <span class="material-icons">person</span>
                    </div>

                    <div>
                        <h2 class="font-display text-xl font-semibold text-base-content">
                            Informasi Guru
                        </h2>

                        <p class="mt-1 text-sm text-base-content/70">
                            Perbarui data identitas dan sekolah asal guru binaan.
                        </p>
                    </div>
                </div>

                <div class="grid gap-5 md:grid-cols-2">
                    <div class="form-control md:col-span-2">
                        <label for="nama_lengkap" class="label">
                            <span class="label-text font-semibold">
                                Nama Lengkap <span class="text-error">*</span>
                            </span>
                        </label>

                        <input
                            id="nama_lengkap"
                            type="text"
                            name="nama_lengkap"
                            value="{{ old('nama_lengkap', $guru->nama_lengkap) }}"
                            class="input input-bordered w-full rounded-xl @error('nama_lengkap') input-error @enderror"
                            required
                        >

                        @error('nama_lengkap')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <div class="form-control">
                        <label for="sekolah_id" class="label">
                            <span class="label-text font-semibold">Sekolah Binaan</span>
                        </label>

                        <select
                            id="sekolah_id"
                            name="sekolah_id"
                            class="select select-bordered w-full rounded-xl @error('sekolah_id') select-error @enderror"
                        >
                            <option value="">Pilih sekolah binaan</option>

                            @foreach($sekolahs as $sekolah)
                                <option
                                    value="{{ $sekolah->id }}"
                                    @selected(old('sekolah_id', $guru->sekolah_id) == $sekolah->id)
                                >
                                    {{ $sekolah->nama_sekolah }}
                                    @if($sekolah->jenjang)
                                        — {{ $sekolah->jenjang }}
                                    @endif
                                </option>
                            @endforeach
                        </select>

                        @error('sekolah_id')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <div class="form-control">
                        <label for="nip_siaga" class="label">
                            <span class="label-text font-semibold">NIP / SIAGA</span>
                        </label>

                        <input
                            id="nip_siaga"
                            type="text"
                            name="nip_siaga"
                            value="{{ old('nip_siaga', $guru->nip_siaga) }}"
                            class="input input-bordered w-full rounded-xl @error('nip_siaga') input-error @enderror"
                            inputmode="numeric"
                        >

                        <label class="label">
                            <span class="label-text-alt text-base-content/60">
                                Pastikan nomor sesuai dengan data guru binaan.
                            </span>
                        </label>

                        @error('nip_siaga')
                            <label class="label pt-0">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>
                </div>
            </div>
        </section>

        {{-- Status --}}
        <section class="card border border-base-300 bg-base-100 shadow-sm">
            <div class="card-body gap-6 p-5 sm:p-7">
                <div class="flex items-start gap-3">
                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-secondary/15 text-secondary">
                        <span class="material-icons">badge</span>
                    </div>

                    <div>
                        <h2 class="font-display text-xl font-semibold text-base-content">
                            Jabatan dan Status
                        </h2>

                        <p class="mt-1 text-sm text-base-content/70">
                            Sesuaikan jabatan dan status aktif guru dalam sistem.
                        </p>
                    </div>
                </div>

                <div class="grid gap-5 md:grid-cols-2">
                    <div class="form-control">
                        <label for="status_jabatan" class="label">
                            <span class="label-text font-semibold">
                                Status Jabatan <span class="text-error">*</span>
                            </span>
                        </label>

                        <select
                            id="status_jabatan"
                            name="status_jabatan"
                            class="select select-bordered w-full rounded-xl @error('status_jabatan') select-error @enderror"
                            required
                        >
                            <option
                                value="GURU"
                                @selected(old('status_jabatan', $guru->status_jabatan) === 'GURU')
                            >
                                Guru PAI
                            </option>

                            <option
                                value="GURU_KEPSEK"
                                @selected(old('status_jabatan', $guru->status_jabatan) === 'GURU_KEPSEK')
                            >
                                Guru PAI merangkap Kepala Sekolah
                            </option>
                        </select>

                        @error('status_jabatan')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <div class="rounded-2xl border border-base-300 bg-base-200 p-4">
                        <label for="is_active" class="flex cursor-pointer items-center justify-between gap-4">
                            <div>
                                <p class="font-semibold text-base-content">
                                    Status Guru Aktif
                                </p>

                                <p class="mt-1 text-sm leading-5 text-base-content/70">
                                    Nonaktifkan hanya jika guru mutasi, pensiun, atau tidak lagi menjadi binaan.
                                </p>
                            </div>

                            <input type="hidden" name="is_active" value="0">

                            <input
                                id="is_active"
                                type="checkbox"
                                name="is_active"
                                value="1"
                                @checked(old('is_active', $guru->is_active))
                                class="toggle toggle-primary"
                            >
                        </label>
                    </div>
                </div>
            </div>
        </section>

        {{-- Informasi --}}
        <section class="rounded-2xl border border-secondary/30 bg-secondary/10 p-4">
            <div class="flex items-start gap-3">
                <span class="material-icons mt-0.5 text-secondary">info</span>

                <div>
                    <p class="font-semibold text-base-content">
                        Perhatikan sebelum menyimpan
                    </p>

                    <p class="mt-1 text-sm leading-6 text-base-content/70">
                        Perubahan NIP/SIAGA atau status guru dapat memengaruhi proses pencocokan
                        saat registrasi akun guru.
                    </p>
                </div>
            </div>
        </section>

        {{-- Action --}}
        <section class="flex flex-col-reverse gap-3 border-t border-base-300 pt-5 sm:flex-row sm:justify-end">
            <a href="{{ route('admin.guru.index') }}" class="btn btn-ghost rounded-xl">
                Batal
            </a>

            <button type="submit" class="btn btn-primary rounded-xl">
                <span class="material-icons">save</span>
                Simpan Perubahan
            </button>
        </section>
    </form>
</div>
@endsection