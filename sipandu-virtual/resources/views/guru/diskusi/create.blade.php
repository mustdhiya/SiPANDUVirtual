@extends('layouts.guru')

@section('title', 'Buat Diskusi Baru')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex items-center gap-3 mb-6">
        <a
            href="{{ route('guru.diskusi.show', $periode->id) }}"
            class="btn btn-circle btn-ghost"
            aria-label="Kembali ke ruang diskusi"
        >
            <span class="material-icons">arrow_back</span>
        </a>

        <div>
            <div class="text-sm font-bold tracking-wide uppercase text-secondary">
                Triwulan {{ $periode->nomor }} · {{ $periode->tahunAjaran->label }}
            </div>

            <h1 class="font-display text-3xl font-semibold mt-1">
                Buat Pertanyaan Baru
            </h1>

            <p class="text-neutral/60 mt-1">
                {{ $periode->tema }}
            </p>
        </div>
    </div>

    <form
        action="{{ route('guru.diskusi.store', $periode->id) }}"
        method="POST"
        class="card bg-base-100 border border-base-300 shadow-sm"
    >
        @csrf

        <div class="card-body gap-5">
            <div class="alert alert-info">
                <span class="material-icons">tips_and_updates</span>
                <div>
                    <strong>Tulis pertanyaan dengan jelas.</strong>
                    <div class="text-sm">
                        Jelaskan kendala yang dihadapi agar pengawas dapat memberi arahan yang sesuai.
                    </div>
                </div>
            </div>

            <div class="form-control">
                <label class="label" for="judul">
                    <span class="label-text font-semibold">
                        Judul Pertanyaan <span class="text-error">*</span>
                    </span>
                </label>

                <input
                    id="judul"
                    type="text"
                    name="judul"
                    value="{{ old('judul') }}"
                    class="input input-bordered w-full @error('judul') input-error @enderror"
                    placeholder="Contoh: Cara mengunggah dokumen Prota dan Promes"
                    required
                    autofocus
                >

                @error('judul')
                    <label class="label">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </label>
                @enderror
            </div>

            <div class="form-control">
                <label class="label" for="isi">
                    <span class="label-text font-semibold">
                        Isi Pertanyaan <span class="text-error">*</span>
                    </span>
                </label>

                <textarea
                    id="isi"
                    name="isi"
                    class="textarea textarea-bordered min-h-44 @error('isi') textarea-error @enderror"
                    placeholder="Tuliskan detail pertanyaan atau kendala Anda..."
                    required
                >{{ old('isi') }}</textarea>

                @error('isi')
                    <label class="label">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </label>
                @enderror
            </div>

            <div class="card-actions justify-end pt-3 border-t border-base-300">
                <a href="{{ route('guru.diskusi.show', $periode->id) }}" class="btn btn-ghost">
                    Batal
                </a>

                <button type="submit" class="btn btn-primary gap-2">
                    <span class="material-icons">send</span>
                    Kirim Pertanyaan
                </button>
            </div>
        </div>
    </form>
</div>
@endsection