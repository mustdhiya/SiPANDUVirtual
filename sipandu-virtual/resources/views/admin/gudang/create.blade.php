@extends('layouts.admin')

@section('title', 'Upload Materi')

@section('content')
<div class="mx-auto max-w-4xl space-y-7">

    {{-- Header --}}
    <section class="flex flex-col gap-4 border-b border-base-300 pb-6 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.14em] text-secondary">
                Gudang PAI-BMTS
            </p>

            <h1 class="font-display mt-2 text-3xl font-semibold leading-tight text-base-content">
                Upload Materi Baru
            </h1>

            <p class="mt-2 text-sm leading-6 text-base-content/70">
                Tambahkan materi pendampingan, instrumen riset, atau contoh perangkat untuk guru binaan.
            </p>
        </div>

        <a href="{{ route('admin.gudang.index') }}" class="btn btn-ghost rounded-xl">
            <span class="material-icons">arrow_back</span>
            Kembali
        </a>
    </section>

    {{-- Petunjuk --}}
    <section class="rounded-2xl border border-secondary/30 bg-secondary/10 px-5 py-4">
        <div class="flex items-start gap-3">
            <span class="material-icons mt-0.5 text-secondary">info</span>

            <div>
                <h2 class="font-semibold text-base-content">
                    Sebelum mengunggah
                </h2>

                <p class="mt-1 text-sm leading-6 text-base-content/75">
                    Pastikan judul mudah dipahami, kategori sesuai, dan file yang diunggah merupakan versi final.
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

                    {{-- Judul --}}
                    <div class="form-control md:col-span-2">
                        <label for="judul" class="label px-0">
                            <span class="label-text font-semibold">
                                Judul Materi
                            </span>

                            <span class="label-text-alt text-error">
                                Wajib
                            </span>
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

                    {{-- Kategori --}}
                    <div class="form-control">
                        <label for="kategori" class="label px-0">
                            <span class="label-text font-semibold">
                                Kategori Materi
                            </span>

                            <span class="label-text-alt text-error">
                                Wajib
                            </span>
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

                            <option value="materi" @selected(old('kategori') === 'materi')>
                                Materi Pendampingan
                            </option>

                            <option value="instrumen_riset" @selected(old('kategori') === 'instrumen_riset')>
                                Instrumen Riset
                            </option>

                            <option value="contoh_perangkat" @selected(old('kategori') === 'contoh_perangkat')>
                                Contoh Perangkat
                            </option>
                        </select>

                        @error('kategori')
                            <label class="label px-0">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    {{-- File --}}
                    <div class="form-control">
                        <label for="file" class="label px-0">
                            <span class="label-text font-semibold">
                                File Materi
                            </span>

                            <span class="label-text-alt text-error">
                                Wajib
                            </span>
                        </label>

                        <input
                            id="file"
                            type="file"
                            name="file"
                            class="file-input file-input-bordered w-full rounded-xl @error('file') file-input-error @enderror"
                            required
                        >

                        <label class="label px-0">
                            <span class="label-text-alt text-base-content/60">
                                Maksimal ukuran file: 100 MB.
                            </span>
                        </label>

                        @error('file')
                            <label class="label px-0">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>
                </div>

                {{-- Deskripsi --}}
                <div class="form-control">
                    <label for="deskripsi" class="label px-0">
                        <span class="label-text font-semibold">
                            Deskripsi Materi
                        </span>

                        <span class="label-text-alt text-base-content/60">
                            Opsional
                        </span>
                    </label>

                    <textarea
                        id="deskripsi"
                        name="deskripsi"
                        rows="5"
                        placeholder="Jelaskan isi, tujuan penggunaan, atau sasaran materi ini..."
                        class="textarea textarea-bordered w-full rounded-xl @error('deskripsi') textarea-error @enderror"
                    >{{ old('deskripsi') }}</textarea>

                    <label class="label px-0">
                        <span class="label-text-alt text-base-content/60">
                            Deskripsi membantu guru memahami materi sebelum mengunduhnya.
                        </span>
                    </label>

                    @error('deskripsi')
                        <label class="label px-0">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                {{-- Status aktif --}}
                <div class="rounded-2xl border border-base-300 bg-base-200 p-4">
                    <label for="is_active" class="flex cursor-pointer items-start gap-4">
                        <input type="hidden" name="is_active" value="0">

                        <input
                            id="is_active"
                            type="checkbox"
                            name="is_active"
                            value="1"
                            @checked(old('is_active', true))
                            class="toggle toggle-primary mt-0.5"
                        >

                        <div>
                            <p class="font-semibold text-base-content">
                                Tampilkan untuk guru
                            </p>

                            <p class="mt-1 text-sm leading-6 text-base-content/70">
                                Jika aktif, materi dapat langsung dilihat dan diunduh oleh guru dari Gudang PAI-BMTS.
                            </p>
                        </div>
                    </label>
                </div>

                {{-- Aksi --}}
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