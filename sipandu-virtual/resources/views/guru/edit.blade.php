@extends('layouts.admin')

@section('title', 'Edit Guru Binaan')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.guru.index') }}" class="btn btn-circle btn-ghost" aria-label="Kembali ke daftar guru"><span class="material-icons">arrow_back</span></a>
        <div>
            <div class="text-sm font-bold tracking-wide uppercase text-secondary">Data Utama</div>
            <h1 class="font-display text-3xl font-semibold">Edit Guru Binaan</h1>
            <p class="text-neutral/60 mt-1">Perbarui data <strong>{{ $guru->nama_lengkap }}</strong> bila diperlukan.</p>
        </div>
    </div>

    <form action="{{ route('admin.guru.update', $guru->id) }}" method="POST" class="card bg-base-100 border border-base-300 shadow-sm">
        @csrf
        @method('PUT')
        <div class="card-body gap-5">
            <div class="form-control">
                <label class="label" for="nama_lengkap"><span class="label-text font-semibold">Nama Lengkap <span class="text-error">*</span></span></label>
                <input id="nama_lengkap" name="nama_lengkap" type="text" value="{{ old('nama_lengkap', $guru->nama_lengkap) }}" class="input input-bordered w-full @error('nama_lengkap') input-error @enderror" required autofocus>
                @error('nama_lengkap')<label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>@enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="form-control">
                    <label class="label" for="sekolah_id"><span class="label-text font-semibold">Sekolah Binaan</span></label>
                    <select id="sekolah_id" name="sekolah_id" class="select select-bordered w-full @error('sekolah_id') select-error @enderror">
                        <option value="">Pilih sekolah (opsional)</option>
                        @foreach($sekolahs as $sekolah)
                            <option value="{{ $sekolah->id }}" @selected(old('sekolah_id', $guru->sekolah_id) == $sekolah->id)>{{ $sekolah->nama_sekolah }}</option>
                        @endforeach
                    </select>
                    @error('sekolah_id')<label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>@enderror
                </div>

                <div class="form-control">
                    <label class="label" for="nip_siaga"><span class="label-text font-semibold">NIP / SIAGA</span></label>
                    <input id="nip_siaga" name="nip_siaga" type="text" value="{{ old('nip_siaga', $guru->nip_siaga) }}" class="input input-bordered w-full @error('nip_siaga') input-error @enderror">
                    @error('nip_siaga')<label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>@enderror
                </div>
            </div>

            <fieldset class="form-control">
                <legend class="label"><span class="label-text font-semibold">Status Jabatan <span class="text-error">*</span></span></legend>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <label class="cursor-pointer border border-base-300 rounded-xl p-4 flex gap-3 items-start hover:bg-base-200">
                        <input type="radio" name="status_jabatan" value="GURU" class="radio radio-primary mt-1" @checked(old('status_jabatan', $guru->status_jabatan) === 'GURU')>
                        <span><strong class="block">Guru PAI</strong><small class="text-neutral/60">Dokumen wajib guru PAI.</small></span>
                    </label>
                    <label class="cursor-pointer border border-base-300 rounded-xl p-4 flex gap-3 items-start hover:bg-base-200">
                        <input type="radio" name="status_jabatan" value="GURU_KEPSEK" class="radio radio-primary mt-1" @checked(old('status_jabatan', $guru->status_jabatan) === 'GURU_KEPSEK')>
                        <span><strong class="block">Guru PAI + Kepala Sekolah</strong><small class="text-neutral/60">Termasuk kebutuhan dokumen tambahan.</small></span>
                    </label>
                </div>
                @error('status_jabatan')<label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>@enderror
            </fieldset>

            <label class="flex items-center justify-between p-4 rounded-xl bg-base-200 cursor-pointer">
                <span><strong class="block">Status aktif</strong><small class="text-neutral/60">Nonaktifkan jika guru mutasi atau tidak lagi menjadi binaan.</small></span>
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" value="1" class="toggle toggle-primary" @checked(old('is_active', $guru->is_active))>
            </label>

            <div class="card-actions justify-end pt-2 border-t border-base-300">
                <a href="{{ route('admin.guru.index') }}" class="btn btn-ghost">Batal</a>
                <button type="submit" class="btn btn-primary gap-2"><span class="material-icons">save</span> Simpan Perubahan</button>
            </div>
        </div>
    </form>
</div>
@endsection