@extends('layouts.admin')

@section('title', 'Edit Materi')

@section('content')
<div class="max-w-4xl space-y-7">

    {{-- Header --}}
    <section class="flex flex-col gap-4 border-b border-base-300 pb-5 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.14em] text-secondary">
                Gudang PAI-BMTS
            </p>

            <h1 class="font-display mt-1 text-3xl font-semibold leading-tight text-neutral">
                Edit Materi
            </h1>

            <p class="mt-2 text-sm leading-6 text-neutral/60">
                Perbarui informasi materi dan atur apakah materi dapat dilihat oleh guru.
            </p>
        </div>

        <a href="{{ route('admin.gudang.index') }}" class="btn btn-ghost rounded-xl">
            <span class="material-icons">arrow_back</span>
            Kembali
        </a>
    </section>

    {{-- Informasi file --}}
    <section class="rounded-2xl border border-primary/15 bg-primary/5 p-4">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-start gap-3">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-primary/10 text-primary">
                    <span class="material-icons">attach_file</span>
                </div>

                <div>
                    <h2 class="font-semibold text-neutral">
                        File yang tersimpan
                    </h2>

                    <p class="mt-1 max-w-xl break-all text-sm text-neutral/60">
                        {{ basename($materi->file) }}
                    </p>
                </div>
            </div>

            <a
                href="{{ asset('storage/' . $materi->file) }}"
                target="_blank"
                rel="noopener"
                class="btn btn-outline btn-primary btn-sm rounded-xl"
            >
                <span class="material-icons text-base">download</span>
                Lihat File
            </a>
        </div>
    </section>

    {{-- Form --}}
    <section class="card border border-base-300 bg-base-100 shadow-sm">
        <div class="card-body p-5 sm:p-7">
            <form
                action="{{ route('admin.gudang.update', $materi->id) }}"
                method="POST"
                class="space-y-6"
            >
                @csrf
                @method('PUT')

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
                            value="{{ old('judul', $materi->judul) }}"
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
                            <option value="materi" {{ old('kategori', $materi->kategori) === 'materi' ? 'selected' : '' }}>
                                Materi Pendampingan
                            </option>

                            <option value="instrumen_riset" {{ old('kategori', $materi->kategori) === 'instrumen_riset' ? 'selected' : '' }}>
                                Instrumen Riset
                            </option>

                            <option value="contoh_perangkat" {{ old('kategori', $materi->kategori) === 'contoh_perangkat' ? 'selected' : '' }}>
                                Contoh Perangkat
                            </option>
                        </select>

                        @error('kategori')
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
                                {{ old('is_active', $materi->is_active) ? 'checked' : '' }}
                                class="checkbox checkbox-primary mt-0.5"
                            >

                            <span>
                                <span class="block font-semibold text-neutral">
                                    Tampilkan kepada guru
                                </span>

                                <span class="mt-1 block text-sm leading-5 text-neutral/60">
                                    Materi nonaktif hanya tersimpan sebagai arsip admin.
                                </span>
                            </span>
                        </label>
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
                        class="textarea textarea-bordered w-full rounded-xl @error('deskripsi') textarea-error @enderror"
                    >{{ old('deskripsi', $materi->deskripsi) }}</textarea>

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

                <div class="flex flex-col-reverse gap-3 border-t border-base-300 pt-5 sm:flex-row sm:justify-end">
                    <a href="{{ route('admin.gudang.index') }}" class="btn btn-ghost rounded-xl">
                        Batal
                    </a>

                    <button type="submit" class="btn btn-primary rounded-xl">
                        <span class="material-icons">save</span>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection