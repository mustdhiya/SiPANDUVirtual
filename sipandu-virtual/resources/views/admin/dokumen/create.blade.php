@extends('layouts.admin')

@section('title', 'Tambah Dokumen Wajib')

@section('content')
<div class="max-w-4xl space-y-6">

    {{-- Header --}}
    <section class="flex flex-col gap-4 border-b border-base-300 pb-5 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.14em] text-secondary">
                Konfigurasi Triwulan
            </p>

            <h1 class="font-display mt-1 text-3xl font-semibold text-neutral">
                Tambah Dokumen Wajib
            </h1>

            <p class="mt-2 text-sm leading-6 text-neutral/60">
                Buat daftar dokumen yang perlu disiapkan atau diunggah oleh guru.
            </p>
        </div>

        <a href="{{ route('admin.dokumen.index') }}" class="btn btn-ghost rounded-xl">
            <span class="material-icons">arrow_back</span>
            Kembali
        </a>
    </section>

    {{-- Bantuan --}}
    <section class="rounded-2xl border border-secondary/20 bg-secondary/10 px-4 py-4 sm:px-5">
        <div class="flex gap-3">
            <span class="material-icons mt-0.5 shrink-0 text-secondary">lightbulb</span>

            <div>
                <p class="font-semibold text-neutral">
                    Buat nama dokumen yang jelas dan mudah dipahami guru.
                </p>

                <p class="mt-1 text-sm leading-6 text-neutral/65">
                    Contoh: “Prota dan Promes”, “Modul Ajar”, atau “Program Pengembangan PAI Kepala Sekolah”.
                </p>
            </div>
        </div>
    </section>

    {{-- Form --}}
    <form action="{{ route('admin.dokumen.store') }}" method="POST">
        @csrf

        <section class="card border border-base-300 bg-base-100 shadow-sm">
            <div class="card-body gap-6 p-5 sm:p-7">

                <div>
                    <h2 class="font-display text-xl font-semibold text-neutral">
                        Informasi Dokumen
                    </h2>

                    <p class="mt-1 text-sm text-neutral/60">
                        Isi informasi utama yang akan dilihat oleh guru.
                    </p>
                </div>

                <div class="grid gap-5 md:grid-cols-2">
                    <div class="form-control">
                        <label for="triwulan" class="label">
                            <span class="label-text font-semibold">Berlaku pada Triwulan</span>
                        </label>

                        <select id="triwulan" name="triwulan" class="select select-bordered w-full rounded-xl" required>
                            <option value="1" {{ old('triwulan') == 1 ? 'selected' : '' }}>
                                Triwulan I
                            </option>
                            <option value="2" {{ old('triwulan') == 2 ? 'selected' : '' }}>
                                Triwulan II
                            </option>
                            <option value="3" {{ old('triwulan') == 3 ? 'selected' : '' }}>
                                Triwulan III
                            </option>
                            <option value="4" {{ old('triwulan') == 4 ? 'selected' : '' }}>
                                Triwulan IV
                            </option>
                        </select>

                        @error('triwulan')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <div class="form-control">
                        <label for="urutan" class="label">
                            <span class="label-text font-semibold">Urutan Tampil</span>
                        </label>

                        <input
                            id="urutan"
                            type="number"
                            name="urutan"
                            value="{{ old('urutan', 0) }}"
                            min="0"
                            class="input input-bordered w-full rounded-xl"
                            required
                        >

                        <label class="label">
                            <span class="label-text-alt text-neutral/55">
                                Gunakan 1 untuk dokumen pertama.
                            </span>
                        </label>

                        @error('urutan')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>
                </div>

                <div class="form-control">
                    <label for="nama_dokumen" class="label">
                        <span class="label-text font-semibold">Nama Dokumen</span>
                    </label>

                    <input
                        id="nama_dokumen"
                        type="text"
                        name="nama_dokumen"
                        value="{{ old('nama_dokumen') }}"
                        placeholder="Contoh: Prota dan Promes"
                        class="input input-bordered w-full rounded-xl"
                        required
                    >

                    @error('nama_dokumen')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                <div class="form-control">
                    <label for="instruksi" class="label">
                        <span class="label-text font-semibold">Instruksi untuk Guru</span>
                    </label>

                    <textarea
                        id="instruksi"
                        name="instruksi"
                        rows="5"
                        placeholder="Jelaskan dokumen apa yang harus diunggah, format yang dianjurkan, atau hal penting lain."
                        class="textarea textarea-bordered w-full rounded-xl leading-6"
                        required
                    >{{ old('instruksi') }}</textarea>

                    <label class="label">
                        <span class="label-text-alt text-neutral/55">
                            Gunakan bahasa singkat, jelas, dan mudah dipahami.
                        </span>
                    </label>

                    @error('instruksi')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>
            </div>
        </section>

        {{-- Ketentuan --}}
        <section class="card mt-5 border border-base-300 bg-base-100 shadow-sm">
            <div class="card-body gap-6 p-5 sm:p-7">

                <div>
                    <h2 class="font-display text-xl font-semibold text-neutral">
                        Ketentuan Dokumen
                    </h2>

                    <p class="mt-1 text-sm text-neutral/60">
                        Tentukan siapa yang wajib mengunggah dokumen ini.
                    </p>
                </div>

                <div class="grid gap-5 md:grid-cols-2">
                    <div class="form-control">
                        <label for="is_wajib" class="label">
                            <span class="label-text font-semibold">Sifat Dokumen</span>
                        </label>

                        <select id="is_wajib" name="is_wajib" class="select select-bordered w-full rounded-xl" required>
                            <option value="1" {{ old('is_wajib', '1') == '1' ? 'selected' : '' }}>
                                Wajib diunggah
                            </option>
                            <option value="0" {{ old('is_wajib') === '0' ? 'selected' : '' }}>
                                Opsional
                            </option>
                        </select>
                    </div>

                    <div class="form-control">
                        <label for="berlaku_untuk" class="label">
                            <span class="label-text font-semibold">Berlaku Untuk</span>
                        </label>

                        <select id="berlaku_untuk" name="berlaku_untuk" class="select select-bordered w-full rounded-xl" required>
                            <option value="SEMUA" {{ old('berlaku_untuk', 'SEMUA') === 'SEMUA' ? 'selected' : '' }}>
                                Semua Guru PAI
                            </option>
                            <option value="KEPSEK" {{ old('berlaku_untuk') === 'KEPSEK' ? 'selected' : '' }}>
                                Guru PAI merangkap Kepala Sekolah
                            </option>
                        </select>
                    </div>
                </div>

                <label class="flex cursor-pointer items-center justify-between rounded-2xl border border-base-300 bg-base-200/55 px-4 py-4">
                    <span>
                        <span class="block font-semibold text-neutral">Dokumen aktif</span>
                        <span class="mt-1 block text-sm text-neutral/60">
                            Aktifkan agar dokumen terlihat oleh guru pada triwulan terkait.
                        </span>
                    </span>

                    <input
                        type="checkbox"
                        name="is_active"
                        value="1"
                        class="toggle toggle-primary"
                        {{ old('is_active', true) ? 'checked' : '' }}
                    >
                </label>
            </div>
        </section>

        {{-- Tombol aksi --}}
        <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
            <a href="{{ route('admin.dokumen.index') }}" class="btn btn-ghost rounded-xl">
                Batal
            </a>

            <button type="submit" class="btn btn-primary rounded-xl">
                <span class="material-icons">save</span>
                Simpan Dokumen
            </button>
        </div>
    </form>
</div>
@endsection