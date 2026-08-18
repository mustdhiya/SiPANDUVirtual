@extends('layouts.admin')

@section('title', 'Edit Dokumen Wajib')

@section('content')
<div class="max-w-4xl space-y-6">

    {{-- Header --}}
    <section class="flex flex-col gap-4 border-b border-base-300 pb-5 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.14em] text-secondary">
                Konfigurasi Triwulan
            </p>

            <h1 class="font-display mt-1 text-3xl font-semibold text-neutral">
                Edit Dokumen Wajib
            </h1>

            <p class="mt-2 text-sm leading-6 text-neutral/60">
                Perbarui informasi dan ketentuan untuk dokumen
                <strong>{{ $dokumen->nama_dokumen }}</strong>.
            </p>
        </div>

        <a href="{{ route('admin.dokumen.index') }}" class="btn btn-ghost rounded-xl">
            <span class="material-icons">arrow_back</span>
            Kembali
        </a>
    </section>

    {{-- Status ringkas --}}
    <section class="grid gap-3 sm:grid-cols-3">
        <div class="rounded-2xl border border-base-300 bg-base-100 p-4">
            <p class="text-xs font-bold uppercase tracking-wide text-neutral/45">Triwulan</p>
            <p class="mt-1 font-display text-xl font-semibold text-primary">
                TW {{ $dokumen->triwulan }}
            </p>
        </div>

        <div class="rounded-2xl border border-base-300 bg-base-100 p-4">
            <p class="text-xs font-bold uppercase tracking-wide text-neutral/45">Sifat</p>
            <p class="mt-1 font-display text-xl font-semibold text-neutral">
                {{ $dokumen->is_wajib ? 'Wajib' : 'Opsional' }}
            </p>
        </div>

        <div class="rounded-2xl border border-base-300 bg-base-100 p-4">
            <p class="text-xs font-bold uppercase tracking-wide text-neutral/45">Status</p>
            <p class="mt-1 font-display text-xl font-semibold {{ $dokumen->is_active ? 'text-success' : 'text-neutral/60' }}">
                {{ $dokumen->is_active ? 'Aktif' : 'Nonaktif' }}
            </p>
        </div>
    </section>

    {{-- Form --}}
    <form action="{{ route('admin.dokumen.update', $dokumen->id) }}" method="POST">
        @csrf
        @method('PUT')

        <section class="card border border-base-300 bg-base-100 shadow-sm">
            <div class="card-body gap-6 p-5 sm:p-7">

                <div>
                    <h2 class="font-display text-xl font-semibold text-neutral">
                        Informasi Dokumen
                    </h2>

                    <p class="mt-1 text-sm text-neutral/60">
                        Pastikan informasi yang tampil kepada guru sudah akurat dan mudah dipahami.
                    </p>
                </div>

                <div class="grid gap-5 md:grid-cols-2">
                    <div class="form-control">
                        <label for="triwulan" class="label">
                            <span class="label-text font-semibold">Berlaku pada Triwulan</span>
                        </label>

                        <select id="triwulan" name="triwulan" class="select select-bordered w-full rounded-xl" required>
                            <option value="1" {{ old('triwulan', $dokumen->triwulan) == 1 ? 'selected' : '' }}>
                                Triwulan I
                            </option>
                            <option value="2" {{ old('triwulan', $dokumen->triwulan) == 2 ? 'selected' : '' }}>
                                Triwulan II
                            </option>
                            <option value="3" {{ old('triwulan', $dokumen->triwulan) == 3 ? 'selected' : '' }}>
                                Triwulan III
                            </option>
                            <option value="4" {{ old('triwulan', $dokumen->triwulan) == 4 ? 'selected' : '' }}>
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
                            value="{{ old('urutan', $dokumen->urutan) }}"
                            min="0"
                            class="input input-bordered w-full rounded-xl"
                            required
                        >

                        <label class="label">
                            <span class="label-text-alt text-neutral/55">
                                Angka lebih kecil tampil lebih dahulu.
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
                        value="{{ old('nama_dokumen', $dokumen->nama_dokumen) }}"
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
                        class="textarea textarea-bordered w-full rounded-xl leading-6"
                        required
                    >{{ old('instruksi', $dokumen->instruksi) }}</textarea>

                    <label class="label">
                        <span class="label-text-alt text-neutral/55">
                            Jelaskan dengan singkat dokumen yang harus diunggah guru.
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
                        Perubahan ini akan memengaruhi dokumen yang terlihat oleh guru pada periode terkait.
                    </p>
                </div>

                <div class="grid gap-5 md:grid-cols-2">
                    <div class="form-control">
                        <label for="is_wajib" class="label">
                            <span class="label-text font-semibold">Sifat Dokumen</span>
                        </label>

                        <select id="is_wajib" name="is_wajib" class="select select-bordered w-full rounded-xl" required>
                            <option value="1" {{ old('is_wajib', $dokumen->is_wajib ? '1' : '0') == '1' ? 'selected' : '' }}>
                                Wajib diunggah
                            </option>
                            <option value="0" {{ old('is_wajib', $dokumen->is_wajib ? '1' : '0') == '0' ? 'selected' : '' }}>
                                Opsional
                            </option>
                        </select>
                    </div>

                    <div class="form-control">
                        <label for="berlaku_untuk" class="label">
                            <span class="label-text font-semibold">Berlaku Untuk</span>
                        </label>

                        <select id="berlaku_untuk" name="berlaku_untuk" class="select select-bordered w-full rounded-xl" required>
                            <option value="SEMUA" {{ old('berlaku_untuk', $dokumen->berlaku_untuk) === 'SEMUA' ? 'selected' : '' }}>
                                Semua Guru PAI
                            </option>
                            <option value="KEPSEK" {{ old('berlaku_untuk', $dokumen->berlaku_untuk) === 'KEPSEK' ? 'selected' : '' }}>
                                Guru PAI merangkap Kepala Sekolah
                            </option>
                        </select>
                    </div>
                </div>

                <label class="flex cursor-pointer items-center justify-between rounded-2xl border border-base-300 bg-base-200/55 px-4 py-4">
                    <span>
                        <span class="block font-semibold text-neutral">Dokumen aktif</span>
                        <span class="mt-1 block text-sm text-neutral/60">
                            Nonaktifkan jika dokumen sementara tidak perlu dilihat guru.
                        </span>
                    </span>

                    <input
                        type="checkbox"
                        name="is_active"
                        value="1"
                        class="toggle toggle-primary"
                        {{ old('is_active', $dokumen->is_active) ? 'checked' : '' }}
                    >
                </label>
            </div>
        </section>

        {{-- Action --}}
        <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
            <a href="{{ route('admin.dokumen.index') }}" class="btn btn-ghost rounded-xl">
                Batal
            </a>

            <button type="submit" class="btn btn-primary rounded-xl">
                <span class="material-icons">save</span>
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection