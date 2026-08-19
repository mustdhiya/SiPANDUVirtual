@extends('layouts.admin')

@section('title', 'Hubungkan Akun Guru')

@section('content')
<div class="mx-auto max-w-4xl space-y-7">

    {{-- Header Halaman --}}
    <section class="flex flex-col gap-4 border-b border-base-300 pb-6 sm:flex-row sm:items-end sm:justify-between">
        <div class="flex items-start gap-3">
            <a
                href="{{ route('admin.guru.index') }}"
                class="btn btn-square btn-ghost rounded-xl"
                aria-label="Kembali ke daftar guru binaan"
                title="Kembali"
            >
                <span class="material-icons">arrow_back</span>
            </a>

            <div>
                <p class="text-xs font-bold uppercase tracking-[0.14em] text-secondary">
                    Guru Binaan
                </p>

                <h1 class="font-display mt-1 text-3xl font-semibold text-base-content">
                    Hubungkan Akun Guru
                </h1>

                <p class="mt-2 max-w-2xl text-sm leading-6 text-base-content/70">
                    Pilih akun guru yang sudah terdaftar, lalu lengkapi data binaannya agar akun dapat digunakan untuk proses pendampingan.
                </p>
            </div>
        </div>

        <a
            href="{{ route('admin.guru.create') }}"
            class="btn btn-outline btn-primary rounded-xl self-start sm:self-auto"
        >
            <span class="material-icons">person_add</span>
            Tambah Guru Manual
        </a>
    </section>

    {{-- Ringkasan --}}
    <section class="grid gap-4 sm:grid-cols-2">
        <article class="rounded-2xl border border-base-300 bg-base-100 p-5 shadow-sm">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-sm text-base-content/70">
                        Akun Guru Tersedia
                    </p>

                    <p class="font-display mt-1 text-3xl font-semibold text-primary">
                        {{ $users->count() }}
                    </p>
                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-primary/15 text-primary">
                    <span class="material-icons">person_search</span>
                </div>
            </div>

            <p class="mt-4 text-sm leading-6 text-base-content/60">
                Akun guru yang belum dihubungkan ke data guru binaan.
            </p>
        </article>

        <article class="rounded-2xl border border-base-300 bg-base-100 p-5 shadow-sm">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-sm text-base-content/70">
                        Sekolah Binaan Aktif
                    </p>

                    <p class="font-display mt-1 text-3xl font-semibold text-secondary">
                        {{ $sekolahs->count() }}
                    </p>
                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-secondary/15 text-secondary">
                    <span class="material-icons">school</span>
                </div>
            </div>

            <p class="mt-4 text-sm leading-6 text-base-content/60">
                Pilih sekolah asal guru apabila datanya sudah tersedia.
            </p>
        </article>
    </section>

    {{-- Form Utama --}}
    <section class="overflow-hidden rounded-2xl border border-base-300 bg-base-100 shadow-sm">
        <form action="{{ route('admin.guru.store-linked-account') }}" method="POST">
            @csrf

            <div class="space-y-6 p-5 sm:p-7">

                {{-- Informasi --}}
                <div class="alert alert-info rounded-xl">
                    <span class="material-icons">info</span>

                    <div>
                        <h2 class="font-semibold">
                            Pilih akun yang belum terhubung
                        </h2>

                        <p class="mt-1 text-sm leading-6">
                            Akun yang dipilih akan menjadi akun login guru binaan. Satu akun hanya dapat dihubungkan dengan satu data guru binaan.
                        </p>
                    </div>
                </div>

                {{-- Pilih Akun --}}
                <div class="form-control">
                    <label for="user_id" class="label px-0">
                        <span class="label-text font-semibold">
                            Akun Guru <span class="text-error">*</span>
                        </span>
                    </label>

                    <select
                        id="user_id"
                        name="user_id"
                        class="select select-bordered w-full rounded-xl @error('user_id') select-error @enderror"
                        required
                        @disabled($users->isEmpty())
                    >
                        <option value="">
                            {{ $users->isEmpty()
                                ? 'Tidak ada akun guru yang tersedia'
                                : 'Pilih akun guru yang sudah terdaftar' }}
                        </option>

                        @foreach($users as $user)
                            <option
                                value="{{ $user->id }}"
                                @selected(old('user_id') == $user->id)
                            >
                                {{ $user->name }} — {{ $user->email }}
                            </option>
                        @endforeach
                    </select>

                    @error('user_id')
                        <label class="label px-0">
                            <span class="label-text-alt flex items-center gap-1 text-error">
                                <span class="material-icons text-sm">error_outline</span>
                                {{ $message }}
                            </span>
                        </label>
                    @enderror

                    <label class="label px-0">
                        <span class="label-text-alt text-base-content/60">
                            Hanya akun dengan role Guru yang belum dihubungkan yang ditampilkan.
                        </span>
                    </label>
                </div>

                {{-- Tidak Ada Akun --}}
                @if($users->isEmpty())
                    <div class="rounded-2xl border border-warning/30 bg-warning/10 p-5">
                        <div class="flex items-start gap-3">
                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-warning/20 text-warning">
                                <span class="material-icons">warning</span>
                            </div>

                            <div>
                                <h2 class="font-display text-xl font-semibold text-base-content">
                                    Tidak ada akun guru yang dapat dihubungkan
                                </h2>

                                <p class="mt-2 text-sm leading-6 text-base-content/70">
                                    Semua akun guru sudah terhubung ke data binaan, atau belum ada guru yang melakukan registrasi.
                                </p>

                                <div class="mt-4 flex flex-wrap gap-2">
                                    <a
                                        href="{{ route('admin.guru.create') }}"
                                        class="btn btn-sm btn-warning rounded-xl"
                                    >
                                        <span class="material-icons text-base">person_add</span>
                                        Tambah Guru Manual
                                    </a>

                                    <a
                                        href="{{ route('admin.guru.index') }}"
                                        class="btn btn-sm btn-ghost rounded-xl"
                                    >
                                        Kembali ke Daftar Guru
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @else

                    {{-- Data Binaan --}}
                    <div class="border-t border-base-300 pt-6">
                        <div class="mb-4">
                            <p class="text-xs font-bold uppercase tracking-[0.14em] text-secondary">
                                Data Binaan
                            </p>

                            <h2 class="font-display mt-1 text-2xl font-semibold text-base-content">
                                Lengkapi Data Guru
                            </h2>

                            <p class="mt-1 text-sm text-base-content/70">
                                Informasi ini digunakan untuk mengelompokkan guru ke sekolah dan menentukan dokumen yang wajib dipenuhi.
                            </p>
                        </div>

                        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

                            {{-- Sekolah --}}
                            <div class="form-control">
                                <label for="sekolah_id" class="label px-0">
                                    <span class="label-text font-semibold">
                                        Sekolah Binaan
                                    </span>
                                </label>

                                <select
                                    id="sekolah_id"
                                    name="sekolah_id"
                                    class="select select-bordered w-full rounded-xl @error('sekolah_id') select-error @enderror"
                                >
                                    <option value="">Pilih sekolah (opsional)</option>

                                    @foreach($sekolahs as $sekolah)
                                        <option
                                            value="{{ $sekolah->id }}"
                                            @selected(old('sekolah_id') == $sekolah->id)
                                        >
                                            {{ $sekolah->nama_sekolah }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('sekolah_id')
                                    <label class="label px-0">
                                        <span class="label-text-alt flex items-center gap-1 text-error">
                                            <span class="material-icons text-sm">error_outline</span>
                                            {{ $message }}
                                        </span>
                                    </label>
                                @enderror
                            </div>

                            {{-- NIP/SIAGA --}}
                            <div class="form-control">
                                <label for="nip_siaga" class="label px-0">
                                    <span class="label-text font-semibold">
                                        NIP / SIAGA
                                    </span>
                                </label>

                                <input
                                    id="nip_siaga"
                                    name="nip_siaga"
                                    type="text"
                                    value="{{ old('nip_siaga') }}"
                                    class="input input-bordered w-full rounded-xl font-mono @error('nip_siaga') input-error @enderror"
                                    placeholder="Contoh: 199001012020011001"
                                >

                                @error('nip_siaga')
                                    <label class="label px-0">
                                        <span class="label-text-alt flex items-center gap-1 text-error">
                                            <span class="material-icons text-sm">error_outline</span>
                                            {{ $message }}
                                        </span>
                                    </label>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Status Jabatan --}}
                    <fieldset class="form-control">
                        <legend class="label px-0">
                            <span class="label-text font-semibold">
                                Status Jabatan <span class="text-error">*</span>
                            </span>
                        </legend>

                        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">

                            <label class="cursor-pointer rounded-2xl border border-base-300 bg-base-100 p-4 transition hover:border-primary hover:bg-base-200">
                                <div class="flex items-start gap-3">
                                    <input
                                        type="radio"
                                        name="status_jabatan"
                                        value="GURU"
                                        class="radio radio-primary mt-1"
                                        @checked(old('status_jabatan', 'GURU') === 'GURU')
                                    >

                                    <div>
                                        <div class="flex items-center gap-2">
                                            <span class="material-icons text-primary">school</span>
                                            <p class="font-semibold text-base-content">
                                                Guru PAI
                                            </p>
                                        </div>

                                        <p class="mt-2 text-sm leading-6 text-base-content/70">
                                            Mengikuti dokumen wajib standar untuk guru PAI.
                                        </p>
                                    </div>
                                </div>
                            </label>

                            <label class="cursor-pointer rounded-2xl border border-base-300 bg-base-100 p-4 transition hover:border-secondary hover:bg-base-200">
                                <div class="flex items-start gap-3">
                                    <input
                                        type="radio"
                                        name="status_jabatan"
                                        value="GURU_KEPSEK"
                                        class="radio radio-primary mt-1"
                                        @checked(old('status_jabatan') === 'GURU_KEPSEK')
                                    >

                                    <div>
                                        <div class="flex items-center gap-2">
                                            <span class="material-icons text-secondary">account_balance</span>
                                            <p class="font-semibold text-base-content">
                                                Guru PAI + Kepala Sekolah
                                            </p>
                                        </div>

                                        <p class="mt-2 text-sm leading-6 text-base-content/70">
                                            Memiliki tambahan dokumen khusus program pengembangan PAI kepala sekolah.
                                        </p>
                                    </div>
                                </div>
                            </label>
                        </div>

                        @error('status_jabatan')
                            <label class="label px-0">
                                <span class="label-text-alt flex items-center gap-1 text-error">
                                    <span class="material-icons text-sm">error_outline</span>
                                    {{ $message }}
                                </span>
                            </label>
                        @enderror
                    </fieldset>

                    {{-- Status Aktif --}}
                    <section class="rounded-2xl border border-base-300 bg-base-200 p-4">
                        <label class="flex cursor-pointer items-start justify-between gap-4">
                            <div>
                                <div class="flex items-center gap-2">
                                    <span class="material-icons text-success">check_circle</span>
                                    <p class="font-semibold text-base-content">
                                        Status aktif
                                    </p>
                                </div>

                                <p class="mt-2 text-sm leading-6 text-base-content/70">
                                    Guru aktif dapat mengikuti triwulan, mengunggah dokumen, berdiskusi, dan menerima pendampingan.
                                </p>
                            </div>

                            <input type="hidden" name="is_active" value="0">

                            <input
                                type="checkbox"
                                name="is_active"
                                value="1"
                                class="toggle toggle-primary mt-1"
                                @checked(old('is_active', true))
                            >
                        </label>
                    </section>
                @endif
            </div>

            {{-- Aksi Form --}}
            <div class="flex flex-col-reverse gap-3 border-t border-base-300 bg-base-200 p-5 sm:flex-row sm:justify-end sm:p-7">
                <a
                    href="{{ route('admin.guru.index') }}"
                    class="btn btn-ghost rounded-xl"
                >
                    Batal
                </a>

                @if($users->isNotEmpty())
                    <button type="submit" class="btn btn-primary rounded-xl">
                        <span class="material-icons">link</span>
                        Hubungkan Akun Guru
                    </button>
                @endif
            </div>
        </form>
    </section>

    {{-- Bantuan --}}
    <section class="rounded-2xl border border-base-300 bg-base-200 p-5">
        <div class="flex items-start gap-3">
            <span class="material-icons text-secondary">help_outline</span>

            <div>
                <h2 class="font-semibold text-base-content">
                    Kapan menggunakan halaman ini?
                </h2>

                <p class="mt-1 text-sm leading-6 text-base-content/70">
                    Gunakan halaman ini jika guru sudah membuat akun melalui registrasi, tetapi belum masuk ke daftar Guru Binaan.
                    Jika guru belum mempunyai akun, gunakan tombol <strong>Tambah Guru Manual</strong>.
                </p>
            </div>
        </div>
    </section>
</div>
@endsection