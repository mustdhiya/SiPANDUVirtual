@extends('layouts.admin')

@section('title', 'Tambah Tahun Ajaran')

@section('content')
<div class="mx-auto max-w-3xl space-y-7">

    {{-- Header --}}
    <section class="border-b border-base-300 pb-5">
        <a
            href="{{ route('admin.tahun-ajaran.index') }}"
            class="mb-3 inline-flex items-center gap-1 text-sm font-semibold text-primary hover:underline"
        >
            <span class="material-icons text-base">arrow_back</span>
            Kembali ke Tahun Ajaran
        </a>

        <p class="text-xs font-bold uppercase tracking-[0.14em] text-secondary">
            Data Utama
        </p>

        <h1 class="font-display mt-1 text-3xl font-semibold text-base-content">
            Tambah Tahun Ajaran
        </h1>

        <p class="mt-2 text-sm leading-6 text-base-content/70">
            Buat periode tahun ajaran baru untuk digunakan dalam pengelolaan triwulan dan pendampingan.
        </p>
    </section>

    {{-- Form --}}
    <section class="overflow-hidden rounded-3xl border border-base-300 bg-base-100 shadow-sm">
        <div class="border-b border-base-300 bg-base-200 px-5 py-4 sm:px-6">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-primary/15 text-primary">
                    <span class="material-icons">calendar_month</span>
                </div>

                <div>
                    <h2 class="font-display text-lg font-semibold text-base-content">
                        Informasi Tahun Ajaran
                    </h2>

                    <p class="text-sm text-base-content/70">
                        Isi data dengan format yang mudah dikenali.
                    </p>
                </div>
            </div>
        </div>

        <form
            action="{{ route('admin.tahun-ajaran.store') }}"
            method="POST"
            class="space-y-7 p-5 sm:p-6"
        >
            @csrf

            <div class="form-control">
                <label for="label" class="label px-0">
                    <span class="label-text text-sm font-semibold text-base-content">
                        Label Tahun Ajaran
                    </span>
                </label>

                <input
                    id="label"
                    type="text"
                    name="label"
                    value="{{ old('label') }}"
                    placeholder="Contoh: 2026/2027"
                    class="input input-bordered h-12 rounded-xl bg-base-100 text-base text-base-content focus:border-primary focus:outline-none @error('label') input-error @enderror"
                    required
                    autofocus
                    maxlength="20"
                    aria-describedby="label-help @error('label') label-error @enderror"
                >

                <p id="label-help" class="mt-2 text-sm text-base-content/60">
                    Gunakan format empat digit tahun awal dan empat digit tahun akhir, misalnya 2026/2027.
                </p>

                @error('label')
                    <p id="label-error" class="mt-2 flex items-center gap-1 text-sm text-error">
                        <span class="material-icons text-base">error_outline</span>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="rounded-2xl border border-secondary/30 bg-secondary/10 p-4">
                <label for="is_active" class="flex cursor-pointer items-start justify-between gap-4">
                    <div>
                        <p class="font-semibold text-base-content">
                            Jadikan tahun ajaran aktif
                        </p>

                        <p class="mt-1 text-sm leading-6 text-base-content/70">
                            Jika diaktifkan, tahun ajaran aktif sebelumnya akan otomatis dinonaktifkan.
                        </p>
                    </div>

                    <input
                        id="is_active"
                        type="checkbox"
                        name="is_active"
                        value="1"
                        {{ old('is_active') ? 'checked' : '' }}
                        class="toggle toggle-primary mt-1"
                    >
                </label>
            </div>

            <div class="flex flex-col-reverse gap-3 border-t border-base-300 pt-5 sm:flex-row sm:justify-end">
                <a
                    href="{{ route('admin.tahun-ajaran.index') }}"
                    class="btn btn-ghost rounded-xl"
                >
                    Batal
                </a>

                <button type="submit" class="btn btn-primary rounded-xl">
                    <span class="material-icons text-base">save</span>
                    Simpan Tahun Ajaran
                </button>
            </div>
        </form>
    </section>

    {{-- Informasi --}}
    <section class="rounded-2xl border border-base-300 bg-base-200 p-4">
        <div class="flex gap-3">
            <span class="material-icons mt-0.5 text-secondary">info</span>

            <div>
                <h2 class="font-semibold text-base-content">Catatan</h2>

                <p class="mt-1 text-sm leading-6 text-base-content/70">
                    Setelah tahun ajaran dibuat, lanjutkan dengan membuat periode Triwulan I sampai IV pada menu Triwulan.
                </p>
            </div>
        </div>
    </section>
</div>
@endsection