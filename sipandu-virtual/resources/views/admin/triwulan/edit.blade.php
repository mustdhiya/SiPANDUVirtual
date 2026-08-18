@extends('layouts.admin')

@section('title', 'Edit Triwulan')

@section('content')
@php
    $statusTerbuka = (bool) old('is_open', $triwulan->is_open);
@endphp

<div class="space-y-7">

    {{-- Header --}}
    <section class="flex flex-col gap-4 border-b border-base-300 pb-5 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.14em] text-secondary">
                Pengaturan Pendampingan
            </p>

            <h1 class="font-display mt-1 text-3xl font-semibold text-neutral">
                Edit Triwulan
            </h1>

            <p class="mt-2 max-w-2xl text-sm leading-6 text-neutral/60">
                Perbarui tema, deadline, atau status akses guru untuk periode triwulan ini.
            </p>
        </div>

        <a href="{{ route('admin.triwulan.index') }}" class="btn btn-ghost rounded-xl">
            <span class="material-icons">arrow_back</span>
            Kembali ke Daftar
        </a>
    </section>

    {{-- Ringkasan periode saat ini --}}
    <section class="rounded-2xl border border-base-300 bg-base-200/75 p-4 sm:p-5">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-3">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-primary text-primary-content">
                    <span class="material-icons">date_range</span>
                </div>

                <div>
                    <p class="text-sm text-neutral/60">Periode yang sedang diedit</p>
                    <h2 class="font-display text-xl font-semibold">
                        TW {{ $triwulan->nomor }} — {{ $triwulan->tahunAjaran->label ?? '-' }}
                    </h2>
                </div>
            </div>

            @if($triwulan->is_open)
                <span class="badge badge-success badge-lg gap-2 self-start sm:self-auto">
                    <span class="material-icons text-base">lock_open</span>
                    Saat ini terbuka untuk guru
                </span>
            @else
                <span class="badge badge-ghost badge-lg gap-2 self-start sm:self-auto">
                    <span class="material-icons text-base">lock</span>
                    Saat ini tertutup untuk guru
                </span>
            @endif
        </div>
    </section>

    <form action="{{ route('admin.triwulan.update', $triwulan->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_320px]">

            {{-- Form utama --}}
            <section class="card border border-base-300 bg-base-100 shadow-sm">
                <div class="card-body gap-6 p-5 sm:p-7">
                    <div>
                        <h2 class="font-display text-2xl font-semibold text-neutral">
                            Informasi Triwulan
                        </h2>
                        <p class="mt-1 text-sm text-neutral/60">
                            Pastikan informasi berikut sudah benar sebelum disimpan.
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
                                @foreach($tahunAjarans as $ta)
                                    <option
                                        value="{{ $ta->id }}"
                                        {{ old('tahun_ajaran_id', $triwulan->tahun_ajaran_id) == $ta->id ? 'selected' : '' }}
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
                                <option value="1" {{ old('nomor', $triwulan->nomor) == 1 ? 'selected' : '' }}>
                                    Triwulan I — Jan sampai Mar
                                </option>
                                <option value="2" {{ old('nomor', $triwulan->nomor) == 2 ? 'selected' : '' }}>
                                    Triwulan II — Apr sampai Jun
                                </option>
                                <option value="3" {{ old('nomor', $triwulan->nomor) == 3 ? 'selected' : '' }}>
                                    Triwulan III — Jul sampai Sep
                                </option>
                                <option value="4" {{ old('nomor', $triwulan->nomor) == 4 ? 'selected' : '' }}>
                                    Triwulan IV — Okt sampai Des
                                </option>
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
                            value="{{ old('tema', $triwulan->tema) }}"
                            class="input input-bordered w-full rounded-xl @error('tema') input-error @enderror"
                            required
                        >

                        <label class="label px-0">
                            <span class="label-text-alt text-neutral/55">
                                Contoh: Perencanaan dan Pemetaan, Observasi dan Umpan Balik.
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
                            value="{{ old('deadline', optional($triwulan->deadline)->format('Y-m-d')) }}"
                            class="input input-bordered w-full rounded-xl @error('deadline') input-error @enderror"
                            required
                        >

                        @if($triwulan->deadline)
                            <label class="label px-0">
                                <span class="label-text-alt text-neutral/55">
                                    Deadline saat ini: {{ $triwulan->deadline->translatedFormat('d F Y') }}
                                    ({{ $triwulan->deadline->diffForHumans() }}).
                                </span>
                            </label>
                        @endif

                        @error('deadline')
                            <label class="label px-0">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    {{-- Status akses --}}
                    <div class="rounded-2xl border {{ $statusTerbuka ? 'border-success/35 bg-success/10' : 'border-base-300 bg-base-200/70' }} p-4">
                        <label for="is_open" class="flex cursor-pointer items-start gap-4">
                            <input
                                id="is_open"
                                type="checkbox"
                                name="is_open"
                                value="1"
                                {{ $statusTerbuka ? 'checked' : '' }}
                                class="toggle toggle-primary mt-0.5"
                            >

                            <div>
                                <div class="flex flex-wrap items-center gap-2">
                                    <p class="font-semibold text-neutral">
                                        Buka akses untuk guru
                                    </p>

                                    @if($statusTerbuka)
                                        <span class="badge badge-success badge-sm">Aktif</span>
                                    @else
                                        <span class="badge badge-ghost badge-sm">Tidak aktif</span>
                                    @endif
                                </div>

                                <p class="mt-1 text-sm leading-6 text-neutral/60">
                                    Jika aktif, guru dapat melihat dan mengisi triwulan ini. Jika dinonaktifkan, halaman triwulan tidak dapat diakses guru.
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
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </section>

            {{-- Panel dampak perubahan --}}
            <aside class="space-y-4">
                <section class="rounded-2xl border border-warning/25 bg-warning/10 p-5">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-warning/20 text-warning">
                        <span class="material-icons">warning</span>
                    </div>

                    <h2 class="font-display mt-4 text-xl font-semibold">
                        Perhatikan Perubahan
                    </h2>

                    <ul class="mt-3 space-y-3 text-sm leading-6 text-neutral/65">
                        <li class="flex gap-2">
                            <span class="material-icons mt-1 text-base text-warning">arrow_right</span>
                            Mengubah deadline memengaruhi waktu pengisian guru.
                        </li>
                        <li class="flex gap-2">
                            <span class="material-icons mt-1 text-base text-warning">arrow_right</span>
                            Menutup akses akan membatasi guru mengakses periode ini.
                        </li>
                        <li class="flex gap-2">
                            <span class="material-icons mt-1 text-base text-warning">arrow_right</span>
                            Pastikan tema sesuai program pendampingan.
                        </li>
                    </ul>
                </section>

                <section class="rounded-2xl border border-base-300 bg-base-100 p-5">
                    <div class="flex items-center gap-2">
                        <span class="material-icons text-primary">checklist</span>
                        <h2 class="font-semibold">Checklist Admin</h2>
                    </div>

                    <div class="mt-4 space-y-3 text-sm text-neutral/65">
                        <div class="flex items-center gap-3">
                            <span class="material-icons text-success">check_circle</span>
                            Tahun ajaran sudah sesuai
                        </div>

                        <div class="flex items-center gap-3">
                            <span class="material-icons text-success">check_circle</span>
                            Deadline sudah ditetapkan
                        </div>

                        <div class="flex items-center gap-3">
                            <span class="material-icons text-success">check_circle</span>
                            Dokumen wajib telah dikonfigurasi
                        </div>
                    </div>
                </section>
            </aside>
        </div>
    </form>
</div>
@endsection