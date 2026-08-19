@extends('layouts.admin')

@section('title', 'Tambah Triwulan')

@section('content')
<div class="mx-auto max-w-6xl space-y-7">

    {{-- Header --}}
    <section class="flex flex-col gap-4 border-b border-base-300 pb-6 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.14em] text-secondary">
                Pengaturan Pendampingan
            </p>

            <h1 class="font-display mt-2 text-3xl font-semibold text-base-content">
                Tambah Triwulan
            </h1>

            <p class="mt-2 max-w-2xl text-sm leading-6 text-base-content/70">
                Buat periode triwulan baru, tentukan tahun ajaran, tema, deadline, dan status akses guru.
            </p>
        </div>

        <a href="{{ route('admin.triwulan.index') }}" class="btn btn-ghost rounded-xl">
            <span class="material-icons">arrow_back</span>
            Kembali ke Daftar
        </a>
    </section>

    @if($tahunAjarans->isEmpty())
        <section class="alert alert-warning rounded-2xl border border-warning/30 shadow-sm">
            <span class="material-icons">warning</span>

            <div>
                <h2 class="font-bold">Belum ada tahun ajaran.</h2>
                <p class="mt-1 text-sm">
                    Buat dan aktifkan tahun ajaran terlebih dahulu sebelum menambahkan periode triwulan.
                </p>
            </div>

            <a href="{{ route('admin.tahun-ajaran.create') }}" class="btn btn-sm btn-warning">
                Buat Tahun Ajaran
            </a>
        </section>
    @else
        <form action="{{ route('admin.triwulan.store') }}" method="POST">
            @csrf

            <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_320px]">

                {{-- Form utama --}}
                <section class="card border border-base-300 bg-base-100 shadow-sm">
                    <div class="card-body gap-6 p-5 sm:p-7">
                        <div>
                            <h2 class="font-display text-2xl font-semibold text-base-content">
                                Informasi Triwulan
                            </h2>

                            <p class="mt-1 text-sm text-base-content/70">
                                Isi seluruh informasi dasar periode pendampingan.
                            </p>
                        </div>

                        <div class="grid gap-5 md:grid-cols-2">
                            <div class="form-control">
                                <label for="tahun_ajaran_id" class="label px-0">
                                    <span class="label-text font-semibold">Tahun Ajaran</span>
                                </label>

                                <select
                                    id="tahun_ajaran_id"
                                    name="tahun_ajaran_id"
                                    class="select select-bordered w-full rounded-xl @error('tahun_ajaran_id') select-error @enderror"
                                    required
                                >
                                    <option value="" disabled {{ old('tahun_ajaran_id') ? '' : 'selected' }}>
                                        Pilih tahun ajaran
                                    </option>

                                    @foreach($tahunAjarans as $ta)
                                        <option
                                            value="{{ $ta->id }}"
                                            @selected(old('tahun_ajaran_id') == $ta->id)
                                        >
                                            {{ $ta->label }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('tahun_ajaran_id')
                                    <label class="label px-0">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>

                            <div class="form-control">
                                <label for="nomor" class="label px-0">
                                    <span class="label-text font-semibold">Nomor Triwulan</span>
                                </label>

                                <select
                                    id="nomor"
                                    name="nomor"
                                    class="select select-bordered w-full rounded-xl @error('nomor') select-error @enderror"
                                    required
                                >
                                    <option value="" disabled {{ old('nomor') ? '' : 'selected' }}>
                                        Pilih triwulan
                                    </option>
                                    <option value="1" @selected(old('nomor') == 1)>Triwulan I — Januari sampai Maret</option>
                                    <option value="2" @selected(old('nomor') == 2)>Triwulan II — April sampai Juni</option>
                                    <option value="3" @selected(old('nomor') == 3)>Triwulan III — Juli sampai September</option>
                                    <option value="4" @selected(old('nomor') == 4)>Triwulan IV — Oktober sampai Desember</option>
                                </select>

                                @error('nomor')
                                    <label class="label px-0">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>
                        </div>

                        <div class="form-control">
                            <label for="tema" class="label px-0">
                                <span class="label-text font-semibold">Tema Pendampingan</span>
                            </label>

                            <input
                                id="tema"
                                type="text"
                                name="tema"
                                value="{{ old('tema') }}"
                                placeholder="Contoh: Pendampingan Tahap Awal"
                                class="input input-bordered w-full rounded-xl @error('tema') input-error @enderror"
                                required
                            >

                            <label class="label px-0">
                                <span class="label-text-alt text-base-content/60">
                                    Tema akan tampil pada dashboard dan halaman triwulan guru.
                                </span>
                            </label>

                            @error('tema')
                                <label class="label px-0">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label for="deadline" class="label px-0">
                                <span class="label-text font-semibold">Batas Waktu Pengisian</span>
                            </label>

                            <input
                                id="deadline"
                                type="date"
                                name="deadline"
                                value="{{ old('deadline') }}"
                                class="input input-bordered w-full rounded-xl @error('deadline') input-error @enderror"
                                required
                            >

                            <label class="label px-0">
                                <span class="label-text-alt text-base-content/60">
                                    Tetapkan deadline yang realistis agar guru mempunyai waktu cukup untuk menyiapkan dokumen.
                                </span>
                            </label>

                            @error('deadline')
                                <label class="label px-0">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <div class="rounded-2xl border border-base-300 bg-base-200 p-4">
                            <label for="is_open" class="flex cursor-pointer items-start gap-4">
                                <input type="hidden" name="is_open" value="0">

                                <input
                                    id="is_open"
                                    type="checkbox"
                                    name="is_open"
                                    value="1"
                                    @checked(old('is_open'))
                                    class="toggle toggle-primary mt-0.5"
                                >

                                <div>
                                    <p class="font-semibold text-base-content">
                                        Buka akses untuk guru
                                    </p>

                                    <p class="mt-1 text-sm leading-6 text-base-content/70">
                                        Jika aktif, guru dapat melihat periode ini serta mengunggah dokumen dan mengisi instrumen.
                                    </p>
                                </div>
                            </label>
                        </div>

                        <div class="flex flex-col-reverse gap-3 border-t border-base-300 pt-5 sm:flex-row sm:justify-end">
                            <a href="{{ route('admin.triwulan.index') }}" class="btn btn-ghost rounded-xl">
                                Batal
                            </a>

                            <button type="submit" class="btn btn-primary rounded-xl">
                                <span class="material-icons">save</span>
                                Simpan Triwulan
                            </button>
                        </div>
                    </div>
                </section>

                {{-- Informasi bantuan --}}
                <aside class="space-y-4">
                    <section class="rounded-2xl border border-secondary/30 bg-secondary/10 p-5">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-secondary/20 text-secondary">
                            <span class="material-icons">lightbulb</span>
                        </div>

                        <h2 class="font-display mt-4 text-xl font-semibold text-base-content">
                            Sebelum Menyimpan
                        </h2>

                        <ul class="mt-3 space-y-3 text-sm leading-6 text-base-content/75">
                            <li class="flex gap-2">
                                <span class="material-icons mt-1 text-base text-secondary">check_circle</span>
                                Pilih tahun ajaran yang tepat.
                            </li>
                            <li class="flex gap-2">
                                <span class="material-icons mt-1 text-base text-secondary">check_circle</span>
                                Gunakan deadline yang realistis bagi guru.
                            </li>
                            <li class="flex gap-2">
                                <span class="material-icons mt-1 text-base text-secondary">check_circle</span>
                                Buka akses hanya jika dokumen wajib sudah siap.
                            </li>
                        </ul>
                    </section>

                    <section class="rounded-2xl border border-base-300 bg-base-100 p-5">
                        <div class="flex items-center gap-2">
                            <span class="material-icons text-primary">info</span>
                            <h2 class="font-semibold text-base-content">Alur Pendampingan</h2>
                        </div>

                        <ol class="mt-4 space-y-3 text-sm text-base-content/70">
                            <li class="flex gap-3">
                                <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-primary text-xs font-bold text-primary-content">1</span>
                                Atur tahun ajaran.
                            </li>
                            <li class="flex gap-3">
                                <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-primary text-xs font-bold text-primary-content">2</span>
                                Buat periode triwulan.
                            </li>
                            <li class="flex gap-3">
                                <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-primary text-xs font-bold text-primary-content">3</span>
                                Konfigurasi dokumen wajib.
                            </li>
                            <li class="flex gap-3">
                                <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-primary text-xs font-bold text-primary-content">4</span>
                                Buka akses untuk guru.
                            </li>
                        </ol>
                    </section>
                </aside>
            </div>
        </form>
    @endif
</div>
@endsection