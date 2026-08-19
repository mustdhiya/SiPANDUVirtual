@extends('layouts.admin')

@section('title', 'Edit Triwulan')

@section('content')
@php
    $statusTerbuka = (bool) old('is_open', $triwulan->is_open);

    $namaTriwulan = [
        1 => 'Triwulan I — Januari sampai Maret',
        2 => 'Triwulan II — April sampai Juni',
        3 => 'Triwulan III — Juli sampai September',
        4 => 'Triwulan IV — Oktober sampai Desember',
    ];

    $iconTriwulan = [
        1 => 'map',
        2 => 'support_agent',
        3 => 'visibility',
        4 => 'summarize',
    ];

    $namaPeriode = $namaTriwulan[$triwulan->nomor] ?? 'Triwulan ' . $triwulan->nomor;
    $iconPeriode = $iconTriwulan[$triwulan->nomor] ?? 'date_range';

    $deadlineLewat = $triwulan->deadline && $triwulan->deadline->isPast();
    $hariTersisa = $triwulan->deadline
        ? now()->startOfDay()->diffInDays($triwulan->deadline->copy()->startOfDay(), false)
        : null;
@endphp

<div class="mx-auto max-w-6xl space-y-7">

    {{-- Header --}}
    <section class="flex flex-col gap-4 border-b border-base-300 pb-6 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.14em] text-secondary">
                Pengaturan Pendampingan
            </p>

            <h1 class="font-display mt-2 text-3xl font-semibold text-base-content md:text-4xl">
                Edit Triwulan
            </h1>

            <p class="mt-2 max-w-2xl text-sm leading-6 text-base-content/70">
                Perbarui tema pendampingan, batas waktu pengisian, dan status akses guru untuk periode ini.
            </p>
        </div>

        <a
            href="{{ route('admin.triwulan.index') }}"
            class="btn btn-ghost rounded-xl"
        >
            <span class="material-icons">arrow_back</span>
            Kembali ke Daftar
        </a>
    </section>

    {{-- Ringkasan periode --}}
    <section class="rounded-2xl border border-base-300 bg-base-200 p-4 sm:p-5">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div class="flex items-center gap-3">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-primary text-primary-content">
                    <span class="material-icons">{{ $iconPeriode }}</span>
                </div>

                <div>
                    <p class="text-sm text-base-content/70">
                        Periode yang sedang diedit
                    </p>

                    <h2 class="font-display text-xl font-semibold text-base-content">
                        {{ $namaPeriode }}
                    </h2>

                    <p class="mt-1 text-sm text-base-content/60">
                        Tahun Ajaran: {{ $triwulan->tahunAjaran->label ?? '-' }}
                    </p>
                </div>
            </div>

            @if($triwulan->is_open)
                <span class="badge badge-success badge-lg gap-2 self-start sm:self-auto">
                    <span class="material-icons text-base">lock_open</span>
                    Terbuka untuk Guru
                </span>
            @else
                <span class="badge badge-ghost badge-lg gap-2 self-start sm:self-auto">
                    <span class="material-icons text-base">lock</span>
                    Tertutup untuk Guru
                </span>
            @endif
        </div>
    </section>

    <form
        action="{{ route('admin.triwulan.update', $triwulan->id) }}"
        method="POST"
    >
        @csrf
        @method('PUT')

        <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_320px]">

            {{-- Form utama --}}
            <section class="card border border-base-300 bg-base-100 shadow-sm">
                <div class="card-body gap-6 p-5 sm:p-7">

                    <div>
                        <h2 class="font-display text-2xl font-semibold text-base-content">
                            Informasi Triwulan
                        </h2>

                        <p class="mt-1 text-sm text-base-content/70">
                            Pastikan seluruh informasi sudah benar sebelum menyimpan perubahan.
                        </p>
                    </div>

                    {{-- Tahun Ajaran dan Nomor --}}
                    <div class="grid gap-5 md:grid-cols-2">

                        <div class="form-control">
                            <label for="tahun_ajaran_id" class="label px-0">
                                <span class="label-text font-semibold">
                                    Tahun Ajaran
                                </span>
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
                                        @selected(old('tahun_ajaran_id', $triwulan->tahun_ajaran_id) == $ta->id)
                                    >
                                        {{ $ta->label }}
                                    </option>
                                @endforeach
                            </select>

                            @error('tahun_ajaran_id')
                                <label class="label px-0">
                                    <span class="label-text-alt text-error">
                                        {{ $message }}
                                    </span>
                                </label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label for="nomor" class="label px-0">
                                <span class="label-text font-semibold">
                                    Nomor Triwulan
                                </span>
                            </label>

                            <select
                                id="nomor"
                                name="nomor"
                                class="select select-bordered w-full rounded-xl @error('nomor') select-error @enderror"
                                required
                            >
                                <option
                                    value="1"
                                    @selected(old('nomor', $triwulan->nomor) == 1)
                                >
                                    Triwulan I — Januari sampai Maret
                                </option>

                                <option
                                    value="2"
                                    @selected(old('nomor', $triwulan->nomor) == 2)
                                >
                                    Triwulan II — April sampai Juni
                                </option>

                                <option
                                    value="3"
                                    @selected(old('nomor', $triwulan->nomor) == 3)
                                >
                                    Triwulan III — Juli sampai September
                                </option>

                                <option
                                    value="4"
                                    @selected(old('nomor', $triwulan->nomor) == 4)
                                >
                                    Triwulan IV — Oktober sampai Desember
                                </option>
                            </select>

                            @error('nomor')
                                <label class="label px-0">
                                    <span class="label-text-alt text-error">
                                        {{ $message }}
                                    </span>
                                </label>
                            @enderror
                        </div>
                    </div>

                    {{-- Tema --}}
                    <div class="form-control">
                        <label for="tema" class="label px-0">
                            <span class="label-text font-semibold">
                                Tema Pendampingan
                            </span>
                        </label>

                        <input
                            id="tema"
                            type="text"
                            name="tema"
                            value="{{ old('tema', $triwulan->tema) }}"
                            placeholder="Contoh: Observasi dan Umpan Balik"
                            class="input input-bordered w-full rounded-xl @error('tema') input-error @enderror"
                            required
                        >

                        <label class="label px-0">
                            <span class="label-text-alt text-base-content/60">
                                Tema ini akan terlihat pada halaman triwulan guru.
                            </span>
                        </label>

                        @error('tema')
                            <label class="label px-0">
                                <span class="label-text-alt text-error">
                                    {{ $message }}
                                </span>
                            </label>
                        @enderror
                    </div>

                    {{-- Deadline --}}
                    <div class="form-control">
                        <label for="deadline" class="label px-0">
                            <span class="label-text font-semibold">
                                Batas Waktu Pengisian
                            </span>
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
                            <div class="mt-3 rounded-xl border border-base-300 bg-base-200 p-3">
                                <div class="flex items-start gap-2">
                                    <span class="material-icons text-secondary">event</span>

                                    <div>
                                        <p class="text-sm font-semibold text-base-content">
                                            Deadline saat ini:
                                            {{ $triwulan->deadline->translatedFormat('d F Y') }}
                                        </p>

                                        @if($deadlineLewat)
                                            <p class="mt-1 text-xs font-semibold text-error">
                                                Deadline telah berakhir.
                                            </p>
                                        @elseif($hariTersisa === 0)
                                            <p class="mt-1 text-xs font-semibold text-warning">
                                                Batas akhir adalah hari ini.
                                            </p>
                                        @elseif($hariTersisa !== null && $hariTersisa <= 7)
                                            <p class="mt-1 text-xs font-semibold text-warning">
                                                Tersisa {{ $hariTersisa }} hari.
                                            </p>
                                        @else
                                            <p class="mt-1 text-xs text-base-content/60">
                                                {{ $triwulan->deadline->diffForHumans() }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif

                        @error('deadline')
                            <label class="label px-0">
                                <span class="label-text-alt text-error">
                                    {{ $message }}
                                </span>
                            </label>
                        @enderror
                    </div>

                    {{-- Status akses --}}
                    <div
                        class="rounded-2xl border p-4 {{
                            $statusTerbuka
                                ? 'border-success/40 bg-success/10'
                                : 'border-base-300 bg-base-200'
                        }}"
                    >
                        <label for="is_open" class="flex cursor-pointer items-start gap-4">
                            <input type="hidden" name="is_open" value="0">

                            <input
                                id="is_open"
                                type="checkbox"
                                name="is_open"
                                value="1"
                                @checked($statusTerbuka)
                                class="toggle toggle-primary mt-0.5"
                            >

                            <div class="min-w-0">
                                <div class="flex flex-wrap items-center gap-2">
                                    <p class="font-semibold text-base-content">
                                        Buka akses untuk guru
                                    </p>

                                    @if($statusTerbuka)
                                        <span class="badge badge-success badge-sm">
                                            Aktif
                                        </span>
                                    @else
                                        <span class="badge badge-ghost badge-sm">
                                            Tidak aktif
                                        </span>
                                    @endif
                                </div>

                                <p class="mt-1 text-sm leading-6 text-base-content/70">
                                    Jika diaktifkan, guru dapat melihat periode ini serta mengunggah dokumen dan mengisi instrumen.
                                    Jika dinonaktifkan, guru tidak dapat mengakses halaman triwulan ini.
                                </p>
                            </div>
                        </label>
                    </div>

                    {{-- Aksi --}}
                    <div class="flex flex-col-reverse gap-3 border-t border-base-300 pt-5 sm:flex-row sm:justify-end">
                        <a
                            href="{{ route('admin.triwulan.index') }}"
                            class="btn btn-ghost rounded-xl"
                        >
                            Batal
                        </a>

                        <button
                            type="submit"
                            class="btn btn-primary rounded-xl"
                        >
                            <span class="material-icons">save</span>
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </section>

            {{-- Sidebar bantuan --}}
            <aside class="space-y-4">

                {{-- Dampak perubahan --}}
                <section class="rounded-2xl border border-warning/30 bg-warning/10 p-5">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-warning/20 text-warning">
                        <span class="material-icons">warning</span>
                    </div>

                    <h2 class="font-display mt-4 text-xl font-semibold text-base-content">
                        Perhatikan Perubahan
                    </h2>

                    <ul class="mt-4 space-y-3 text-sm leading-6 text-base-content/75">
                        <li class="flex gap-2">
                            <span class="material-icons mt-1 text-base text-warning">
                                arrow_right
                            </span>
                            Mengubah deadline memengaruhi waktu pengisian guru.
                        </li>

                        <li class="flex gap-2">
                            <span class="material-icons mt-1 text-base text-warning">
                                arrow_right
                            </span>
                            Menutup akses membatasi guru melihat dan mengunggah dokumen.
                        </li>

                        <li class="flex gap-2">
                            <span class="material-icons mt-1 text-base text-warning">
                                arrow_right
                            </span>
                            Pastikan tema sesuai dengan program pendampingan.
                        </li>
                    </ul>
                </section>

                {{-- Checklist --}}
                <section class="rounded-2xl border border-base-300 bg-base-100 p-5">
                    <div class="flex items-center gap-2">
                        <span class="material-icons text-primary">checklist</span>
                        <h2 class="font-semibold text-base-content">
                            Checklist Admin
                        </h2>
                    </div>

                    <div class="mt-4 space-y-3 text-sm text-base-content/70">
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

                {{-- Akses cepat --}}
                <section class="rounded-2xl border border-base-300 bg-base-200 p-5">
                    <div class="flex items-start gap-3">
                        <span class="material-icons text-secondary">fact_check</span>

                        <div>
                            <h2 class="font-semibold text-base-content">
                                Setelah Perubahan
                            </h2>

                            <p class="mt-1 text-sm leading-6 text-base-content/70">
                                Jika guru telah mengirim dokumen, lanjutkan ke menu Review Triwulan.
                            </p>

                            <a
                                href="{{ route('admin.review-triwulan.index') }}"
                                class="btn btn-outline btn-primary btn-sm mt-4 rounded-xl"
                            >
                                <span class="material-icons text-base">fact_check</span>
                                Buka Review
                            </a>
                        </div>
                    </div>
                </section>
            </aside>
        </div>
    </form>
</div>
@endsection