@extends('layouts.admin')

@section('title', 'Edit Sekolah Binaan')

@section('content')
<div class="mx-auto max-w-3xl space-y-7">

    {{-- Header --}}
    <section class="flex flex-col gap-4 border-b border-base-300 pb-5 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-[0.14em] text-secondary">
                <span class="material-icons text-base">edit</span>
                Data Utama
            </div>

            <h1 class="font-display mt-2 text-3xl font-semibold text-neutral">
                Edit Sekolah Binaan
            </h1>

            <p class="mt-2 max-w-xl text-sm leading-6 text-neutral/60">
                Perbarui data sekolah binaan sesuai kondisi terbaru.
            </p>
        </div>

        <a href="{{ route('admin.sekolah.index') }}" class="btn btn-ghost rounded-xl">
            <span class="material-icons">arrow_back</span>
            Kembali
        </a>
    </section>

    {{-- School summary --}}
    <section class="rounded-2xl border border-base-300 bg-base-200/60 p-4">
        <div class="flex items-center gap-3">
            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-primary text-primary-content">
                <span class="material-icons">school</span>
            </div>

            <div class="min-w-0">
                <p class="truncate font-semibold text-neutral">
                    {{ $sekolah->nama_sekolah }}
                </p>

                <div class="mt-1 flex flex-wrap items-center gap-2">
                    <span class="badge badge-outline border-primary/35 bg-primary/5 font-semibold text-primary">
                        {{ $sekolah->jenjang }}
                    </span>

                    @if($sekolah->status === 'N')
                        <span class="badge badge-info">Negeri</span>
                    @else
                        <span class="badge badge-warning">Swasta</span>
                    @endif

                    @if($sekolah->is_active)
                        <span class="badge badge-success">Aktif</span>
                    @else
                        <span class="badge badge-ghost">Nonaktif</span>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- Form --}}
    <section class="overflow-hidden rounded-3xl border border-base-300 bg-base-100 shadow-sm">
        <div class="border-b border-base-300 bg-base-200/55 px-5 py-4 sm:px-6">
            <div class="flex items-start gap-3">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-secondary/15 text-secondary">
                    <span class="material-icons">edit_note</span>
                </div>

                <div>
                    <h2 class="font-display text-lg font-semibold text-neutral">
                        Perbarui Informasi Sekolah
                    </h2>

                    <p class="mt-1 text-sm text-neutral/60">
                        Pastikan nama, jenjang, status, dan keaktifan sekolah sudah benar.
                    </p>
                </div>
            </div>
        </div>

        <form
            action="{{ route('admin.sekolah.update', $sekolah->id) }}"
            method="POST"
            class="p-5 sm:p-6"
        >
            @csrf
            @method('PUT')

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
                        value="{{ old('nama_sekolah', $sekolah->nama_sekolah) }}"
                        class="input input-bordered w-full rounded-xl @error('nama_sekolah') input-error @enderror"
                        required
                        autofocus
                    >

                    @error('nama_sekolah')
                        <label class="label px-0">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
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
                            <option value="SMA" {{ old('jenjang', $sekolah->jenjang) === 'SMA' ? 'selected' : '' }}>
                                SMA
                            </option>
                            <option value="SMK" {{ old('jenjang', $sekolah->jenjang) === 'SMK' ? 'selected' : '' }}>
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
                            <option value="N" {{ old('status', $sekolah->status) === 'N' ? 'selected' : '' }}>
                                Negeri
                            </option>
                            <option value="S" {{ old('status', $sekolah->status) === 'S' ? 'selected' : '' }}>
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
                                Nonaktifkan hanya jika sekolah tidak lagi menjadi bagian dari sekolah binaan.
                            </p>
                        </div>

                        <input
                            type="checkbox"
                            name="is_active"
                            value="1"
                            class="toggle toggle-primary mt-1"
                            {{ old('is_active', $sekolah->is_active) ? 'checked' : '' }}
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
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </section>
</div>
@endsection