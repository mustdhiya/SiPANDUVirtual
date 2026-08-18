@extends('layouts.admin')

@section('title', 'Upload Materi')

@section('content')
<div class="max-w-4xl space-y-7">

    {{-- Header --}}
    <section class="flex flex-col gap-4 border-b border-base-300 pb-5 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.14em] text-secondary">
                Gudang PAI-BMTS
            </p>

            <h1 class="font-display mt-1 text-3xl font-semibold leading-tight text-neutral">
                Upload Materi Baru
            </h1>

            <p class="mt-2 text-sm leading-6 text-neutral/60">
                Tambahkan materi pendampingan, instrumen riset, atau contoh perangkat untuk guru binaan.
            </p>
        </div>

        <a href="{{ route('admin.gudang.index') }}" class="btn btn-ghost rounded-xl">
            <span class="material-icons">arrow_back</span>
            Kembali
        </a>
    </section>

    {{-- Petunjuk --}}
    <section class="rounded-2xl border border-secondary/20 bg-secondary/10 px-4 py-4">
        <div class="flex items-start gap-3">
            <span class="material-icons mt-0.5 text-secondary">info</span>

            <div>
                <h2 class="font-semibold text-neutral">
                    Sebelum mengunggah
                </h2>

                <p class="mt-1 text-sm leading-6 text-neutral/65">
                    Pastikan judul mudah dipahami, kategori sesuai, dan file yang diunggah adalah versi final.
                    Ukuran maksimum file adalah 100 MB.
                </p>
            </div>
        </div>
    </section>

    {{-- Form --}}
    <section class="card border border-base-300 bg-base-100 shadow-sm">
        <div class="card-body p-5 sm:p-7">
            <form
                action="{{ route('admin.gudang.store') }}"
                method="POST"
                enctype="multipart/form-data"
                class="space-y-6"
            >
                @csrf

                <div class="grid gap-6 md:grid-cols-2">
                    <div class="form-control md:col-span-2">
                        <label for="judul" class="label px-0">
                            <span class="label-text font-semibold">
                                Judul Materi
                            </span>
                            <span class="label-text-alt text-error">Wajib</span>
                        </label>

                        <input
                            id="judul"
                            type="text"
                            name="judul"
                            value="{{ old('judul') }}"
                            placeholder="Contoh: Instrumen Riset PAI-BMTS Tahun 2026"
                            class="input input-bordered w-full rounded-xl @error('judul') input-error @enderror"
                            required
                            autofocus
                        >

                        @error('judul')
                            <label class="label px-0">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <div class="form-control">
                        <label for="kategori" class="label px-0">
                            <span class="label-text font-semibold">
                                Kategori Materi
                            </span>
                            <span class="label-text-alt text-error">Wajib</span>
                        </label>

                        <select
                            id="kategori"
                            name="kategori"
                            class="select select-bordered w-full rounded-xl @error('kategori') select-error @enderror"
                            required
                        >
                            <option value="" disabled {{ old('kategori') ? '' : 'selected' }}>
                                Pilih kategori materi
                            </option>
                            <option value="materi" {{ old('kategori') === 'materi' ? 'selected' : '' }}>
                                Materi Pendampingan
                            </option>
                            <option value="instrumen_riset" {{ old('kategori') === 'instrumen_riset' ? 'selected' : '' }}>
                                Instrumen Riset
                            </option>
                            <option value="contoh_perangkat" {{ old('kategori') === 'contoh_perangkat' ? 'selected' : '' }}>
                                Contoh Perangkat
                            </option>
                        </select>

                        @error('kategori')
                            <label class="label px-0">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <div class="form-control">
                        <label for="file" class="label px-0">
                            <span class="label-text font-semibold">
                                File Materi
                            </span>
                            <span class="label-text-alt text-error">Wajib</span>
                        </label>

                        <input
                            id="file"
                            type="file"
                            name="file"
                            class="file-input file-input-bordered w-full rounded-xl @error('file') file-input-error @enderror"
                            required
                        >

                        <label class="label px-0">
                            <span class="label-text-alt text-neutral/55">
                                Maksimal 100 MB
                            </span>
                        </label>

                        @error('file')
                            <label class="label px-0">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>
                </div>

                <div class="form-control">
                    <label for="deskripsi" class="label px-0">
                        <span class="label-text font-semibold">
                            Deskripsi atau Petunjuk Penggunaan
                        </span>
                        <span class="label-text-alt text-neutral/55">Opsional</span>
                    </label>

                    <textarea
                        id="deskripsi"
                        name="deskripsi"
                        rows="5"
                        maxlength="1000"
                        placeholder="Jelaskan isi materi, tujuan, atau cara menggunakan dokumen ini."
                        class="textarea textarea-bordered w-full rounded-xl @error('deskripsi') textarea-error @enderror"
                    >{{ old('deskripsi') }}</textarea>

                    <label class="label px-0">
                        <span class="label-text-alt text-neutral/55">
                            Maksimal 1.000 karakter
                        </span>
                    </label>

                    @error('deskripsi')
                        <label class="label px-0">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                <div class="rounded-2xl border border-base-300 bg-base-200/65 p-4">
                    <label for="is_active" class="flex cursor-pointer items-start gap-3">
                        <input
                            id="is_active"
                            type="checkbox"
                            name="is_active"
                            value="1"
                            {{ old('is_active', true) ? 'checked' : '' }}
                            class="checkbox checkbox-primary mt-0.5"
                        >

                        <span>
                            <span class="block font-semibold text-neutral">
                                Tampilkan materi kepada guru
                            </span>

                            <span class="mt-1 block text-sm leading-5 text-neutral/60">
                                Jika tidak dicentang, materi tersimpan sebagai arsip dan belum dapat dilihat guru.
                            </span>
                        </span>
                    </label>
                </div>

                <div class="flex flex-col-reverse gap-3 border-t border-base-300 pt-5 sm:flex-row sm:justify-end">
                    <a href="{{ route('admin.gudang.index') }}" class="btn btn-ghost rounded-xl">
                        Batal
                    </a>

                    <button type="submit" class="btn btn-primary rounded-xl">
                        <span class="material-icons">upload_file</span>
                        Upload Materi
                    </button>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection