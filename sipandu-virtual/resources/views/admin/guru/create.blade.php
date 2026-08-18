@extends('layouts.admin')

@section('title', 'Tambah Guru Binaan')

@section('content')
<div class="max-w-4xl space-y-6">

    {{-- Header --}}
    <section class="flex flex-col gap-4 border-b border-base-300 pb-5 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.14em] text-secondary">
                Data Utama
            </p>

            <h1 class="font-display mt-1 text-3xl font-semibold text-neutral">
                Tambah Guru Binaan
            </h1>

            <p class="mt-2 text-sm leading-6 text-neutral/60">
                Isi data guru dengan benar. Data ini akan digunakan untuk validasi registrasi akun guru.
            </p>
        </div>

        <a href="{{ route('admin.guru.index') }}" class="btn btn-ghost rounded-xl">
            <span class="material-icons">arrow_back</span>
            Kembali
        </a>
    </section>

    <form action="{{ route('admin.guru.store') }}" method="POST" class="space-y-6">
        @csrf

        {{-- Informasi Utama --}}
        <section class="card border border-base-300 bg-base-100 shadow-sm">
            <div class="card-body gap-6 p-5 sm:p-7">
                <div class="flex items-start gap-3">
                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-primary/10 text-primary">
                        <span class="material-icons">person</span>
                    </div>

                    <div>
                        <h2 class="font-display text-xl font-semibold">
                            Informasi Guru
                        </h2>

                        <p class="mt-1 text-sm text-neutral/60">
                            Masukkan identitas utama guru binaan.
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
                            value="{{ old('nama_lengkap') }}"
                            placeholder="Contoh: Ahmad Fauzan, S.Pd.I."
                            class="input input-bordered w-full rounded-xl @error('nama_lengkap') input-error @enderror"
                            required
                            autofocus
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
                                    {{ old('sekolah_id') == $sekolah->id ? 'selected' : '' }}
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
                            value="{{ old('nip_siaga') }}"
                            placeholder="Contoh: 199001012020011001"
                            class="input input-bordered w-full rounded-xl @error('nip_siaga') input-error @enderror"
                            inputmode="numeric"
                        >

                        <label class="label">
                            <span class="label-text-alt text-neutral/55">
                                Digunakan untuk mencocokkan data saat registrasi guru.
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

        {{-- Jabatan dan Status --}}
        <section class="card border border-base-300 bg-base-100 shadow-sm">
            <div class="card-body gap-6 p-5 sm:p-7">
                <div class="flex items-start gap-3">
                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-secondary/15 text-secondary">
                        <span class="material-icons">badge</span>
                    </div>

                    <div>
                        <h2 class="font-display text-xl font-semibold">
                            Jabatan dan Status
                        </h2>

                        <p class="mt-1 text-sm text-neutral/60">
                            Status jabatan menentukan kebutuhan dokumen yang ditampilkan di sistem.
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
                            <option value="GURU" {{ old('status_jabatan', 'GURU') === 'GURU' ? 'selected' : '' }}>
                                Guru PAI
                            </option>

                            <option value="GURU_KEPSEK" {{ old('status_jabatan') === 'GURU_KEPSEK' ? 'selected' : '' }}>
                                Guru PAI merangkap Kepala Sekolah
                            </option>
                        </select>

                        @error('status_jabatan')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <div class="rounded-2xl border border-base-300 bg-base-200/60 p-4">
                        <label for="is_active" class="flex cursor-pointer items-center justify-between gap-4">
                            <div>
                                <p class="font-semibold">Status Guru Aktif</p>
                                <p class="mt-1 text-sm leading-5 text-neutral/60">
                                    Guru aktif dapat dicocokkan saat melakukan registrasi akun.
                                </p>
                            </div>

                            <input
                                id="is_active"
                                type="checkbox"
                                name="is_active"
                                value="1"
                                {{ old('is_active', true) ? 'checked' : '' }}
                                class="toggle toggle-primary"
                            >
                        </label>
                    </div>
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
                Simpan Guru Binaan
            </button>
        </section>
    </form>
</div>
@endsection