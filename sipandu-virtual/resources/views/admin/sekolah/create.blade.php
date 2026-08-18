@extends('layouts.admin')

@section('title', 'Tambah Sekolah Binaan')

@section('content')
<div class="mx-auto max-w-3xl space-y-7">

    {{-- Header --}}
    <section class="flex flex-col gap-4 border-b border-base-300 pb-5 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-[0.14em] text-secondary">
                <span class="material-icons text-base">add_business</span>
                Data Utama
            </div>

            <h1 class="font-display mt-2 text-3xl font-semibold text-neutral">
                Tambah Sekolah Binaan
            </h1>

            <p class="mt-2 max-w-xl text-sm leading-6 text-neutral/60">
                Lengkapi data sekolah yang menjadi binaan Pengawas PAI Kota Samarinda.
            </p>
        </div>

        <a href="{{ route('admin.sekolah.index') }}" class="btn btn-ghost rounded-xl">
            <span class="material-icons">arrow_back</span>
            Kembali
        </a>
    </section>

    {{-- Form card --}}
    <section class="overflow-hidden rounded-3xl border border-base-300 bg-base-100 shadow-sm">
        <div class="border-b border-base-300 bg-base-200/55 px-5 py-4 sm:px-6">
            <div class="flex items-start gap-3">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-primary text-primary-content">
                    <span class="material-icons">school</span>
                </div>

                <div>
                    <h2 class="font-display text-lg font-semibold text-neutral">
                        Informasi Sekolah
                    </h2>

                    <p class="mt-1 text-sm text-neutral/60">
                        Kolom dengan tanda <span class="font-bold text-error">*</span> wajib diisi.
                    </p>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.sekolah.store') }}" method="POST" class="p-5 sm:p-6">
            @csrf

            <div class="space-y-6">
                <div class="form-control">
                    <label for="nama_sekolah" class="label px-0 pt-0">
                        <span class="label-text font-semibold">
                            Nama Sekolah <span class="text-error">*</span>
                        </span>
                    </label>

                    <input
                        id="nama_sekolah"
                        type="text"
                        name="nama_sekolah"
                        value="{{ old('nama_sekolah') }}"
                        placeholder="Contoh: SMA Negeri 1 Samarinda"
                        class="input input-bordered w-full rounded-xl @error('nama_sekolah') input-error @enderror"
                        required
                        autofocus
                    >

                    <label class="label px-0">
                        @error('nama_sekolah')
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        @else
                            <span class="label-text-alt text-neutral/55">
                                Gunakan nama resmi sekolah.
                            </span>
                        @enderror
                    </label>
                </div>

                <div class="grid gap-6 sm:grid-cols-2">
                    <div class="form-control">
                        <label for="jenjang" class="label px-0 pt-0">
                            <span class="label-text font-semibold">
                                Jenjang <span class="text-error">*</span>
                            </span>
                        </label>

                        <select
                            id="jenjang"
                            name="jenjang"
                            class="select select-bordered w-full rounded-xl @error('jenjang') select-error @enderror"
                            required
                        >
                            <option value="" disabled {{ old('jenjang') ? '' : 'selected' }}>
                                Pilih jenjang sekolah
                            </option>
                            <option value="SMA" {{ old('jenjang') === 'SMA' ? 'selected' : '' }}>
                                SMA
                            </option>
                            <option value="SMK" {{ old('jenjang') === 'SMK' ? 'selected' : '' }}>
                                SMK
                            </option>
                        </select>

                        @error('jenjang')
                            <label class="label px-0">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <div class="form-control">
                        <label for="status" class="label px-0 pt-0">
                            <span class="label-text font-semibold">
                                Status Sekolah <span class="text-error">*</span>
                            </span>
                        </label>

                        <select
                            id="status"
                            name="status"
                            class="select select-bordered w-full rounded-xl @error('status') select-error @enderror"
                            required
                        >
                            <option value="" disabled {{ old('status') ? '' : 'selected' }}>
                                Pilih status sekolah
                            </option>
                            <option value="N" {{ old('status') === 'N' ? 'selected' : '' }}>
                                Negeri
                            </option>
                            <option value="S" {{ old('status') === 'S' ? 'selected' : '' }}>
                                Swasta
                            </option>
                        </select>

                        @error('status')
                            <label class="label px-0">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>
                </div>

                <div class="rounded-2xl border border-base-300 bg-base-200/60 p-4">
                    <label class="flex cursor-pointer items-start justify-between gap-4">
                        <div>
                            <span class="font-semibold text-neutral">
                                Sekolah aktif
                            </span>

                            <p class="mt-1 text-sm leading-6 text-neutral/60">
                                Aktifkan jika sekolah masih termasuk dalam daftar binaan saat ini.
                            </p>
                        </div>

                        <input
                            type="checkbox"
                            name="is_active"
                            value="1"
                            class="toggle toggle-primary mt-1"
                            {{ old('is_active', true) ? 'checked' : '' }}
                        >
                    </label>
                </div>
            </div>

            <div class="mt-8 flex flex-col-reverse gap-3 border-t border-base-300 pt-5 sm:flex-row sm:justify-end">
                <a href="{{ route('admin.sekolah.index') }}" class="btn btn-ghost rounded-xl">
                    Batal
                </a>

                <button type="submit" class="btn btn-primary rounded-xl">
                    <span class="material-icons">save</span>
                    Simpan Sekolah
                </button>
            </div>
        </form>
    </section>
</div>
@endsection