@extends('layouts.admin')

@section('title', 'Edit Tahun Ajaran')

@section('content')
<div class="max-w-3xl space-y-7">

    {{-- Header --}}
    <section class="flex flex-col gap-4 border-b border-base-300 pb-5 sm:flex-row sm:items-end sm:justify-between">
        <div>
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

            <h1 class="font-display mt-1 text-3xl font-semibold text-neutral">
                Edit Tahun Ajaran
            </h1>

            <p class="mt-2 text-sm leading-6 text-neutral/60">
                Perbarui label atau status tahun ajaran <strong>{{ $tahunAjaran->label }}</strong>.
            </p>
        </div>

        @if($tahunAjaran->is_active)
            <span class="badge badge-success badge-lg gap-2 self-start sm:self-auto">
                <span class="material-icons text-base">check_circle</span>
                Sedang Aktif
            </span>
        @else
            <span class="badge badge-ghost badge-lg gap-2 self-start sm:self-auto">
                <span class="material-icons text-base">pause_circle</span>
                Tidak Aktif
            </span>
        @endif
    </section>

    {{-- Form --}}
    <section class="overflow-hidden rounded-3xl border border-base-300 bg-base-100 shadow-sm">
        <div class="border-b border-base-300 bg-base-200/55 px-5 py-4 sm:px-6">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-primary/10 text-primary">
                    <span class="material-icons">edit_calendar</span>
                </div>

                <div>
                    <h2 class="font-display text-lg font-semibold text-neutral">
                        Informasi Tahun Ajaran
                    </h2>
                    <p class="text-sm text-neutral/60">
                        Perubahan akan langsung digunakan dalam sistem.
                    </p>
                </div>
            </div>
        </div>

        <form
            action="{{ route('admin.tahun-ajaran.update', $tahunAjaran->id) }}"
            method="POST"
            class="space-y-7 p-5 sm:p-6"
        >
            @csrf
            @method('PUT')

            <div class="form-control">
                <label for="label" class="label px-0">
                    <span class="label-text text-sm font-semibold text-neutral">
                        Label Tahun Ajaran
                    </span>
                </label>

                <input
                    id="label"
                    type="text"
                    name="label"
                    value="{{ old('label', $tahunAjaran->label) }}"
                    placeholder="Contoh: 2026/2027"
                    class="input input-bordered h-12 rounded-xl bg-base-100 text-base focus:border-primary focus:outline-none"
                    required
                    autofocus
                    maxlength="20"
                    aria-describedby="label-help @error('label') label-error @enderror"
                >

                <p id="label-help" class="mt-2 text-sm text-neutral/55">
                    Gunakan format empat digit tahun awal dan empat digit tahun akhir.
                </p>

                @error('label')
                    <p id="label-error" class="mt-2 flex items-center gap-1 text-sm text-error">
                        <span class="material-icons text-base">error_outline</span>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="rounded-2xl border border-secondary/25 bg-secondary/10 p-4">
                <label for="is_active" class="flex cursor-pointer items-start justify-between gap-4">
                    <div>
                        <p class="font-semibold text-neutral">
                            Jadikan tahun ajaran aktif
                        </p>

                        <p class="mt-1 text-sm leading-6 text-neutral/65">
                            Hanya satu tahun ajaran yang dapat aktif dalam satu waktu. Mengaktifkan periode ini akan menonaktifkan periode aktif sebelumnya.
                        </p>
                    </div>

                    <input
                        id="is_active"
                        type="checkbox"
                        name="is_active"
                        value="1"
                        {{ old('is_active', $tahunAjaran->is_active) ? 'checked' : '' }}
                        class="toggle toggle-primary mt-1"
                    >
                </label>
            </div>

            <div class="grid gap-3 rounded-2xl border border-base-300 bg-base-200/50 p-4 sm:grid-cols-2">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wide text-neutral/45">
                        Dibuat
                    </p>
                    <p class="mt-1 text-sm font-semibold text-neutral">
                        {{ $tahunAjaran->created_at->translatedFormat('d F Y, H:i') }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-bold uppercase tracking-wide text-neutral/45">
                        Terakhir Diubah
                    </p>
                    <p class="mt-1 text-sm font-semibold text-neutral">
                        {{ $tahunAjaran->updated_at->translatedFormat('d F Y, H:i') }}
                    </p>
                </div>
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
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </section>
</div>
@endsection