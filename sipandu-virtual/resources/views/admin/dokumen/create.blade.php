@extends('layouts.admin')

@section('title', 'Tambah Dokumen Wajib')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-4">Tambah Dokumen Wajib</h1>

    <div class="card bg-base-200 shadow-md">
        <div class="card-body">
            <form action="{{ route('admin.dokumen.store') }}" method="POST">
                @csrf

                <div class="form-control mb-4">
                    <label class="label">
                        <span class="label-text">Triwulan</span>
                    </label>
                    <select name="triwulan" class="select select-bordered" required>
                        <option value="1">Triwulan I</option>
                        <option value="2">Triwulan II</option>
                        <option value="3">Triwulan III</option>
                        <option value="4">Triwulan IV</option>
                    </select>
                </div>

                <div class="form-control mb-4">
                    <label class="label">
                        <span class="label-text">Nama Dokumen</span>
                    </label>
                    <input type="text" name="nama_dokumen" value="{{ old('nama_dokumen') }}" placeholder="Contoh: Prota & Promes" class="input input-bordered" required />
                </div>

                <div class="form-control mb-4">
                    <label class="label">
                        <span class="label-text">Instruksi</span>
                    </label>
                    <textarea name="instruksi" class="textarea textarea-bordered" rows="3" required>{{ old('instruksi') }}</textarea>
                </div>

                <div class="form-control mb-4">
                    <label class="label cursor-pointer">
                        <span class="label-text">Wajib?</span>
                        <input type="checkbox" name="is_wajib" value="1" {{ old('is_wajib', true) ? 'checked' : '' }} class="checkbox checkbox-primary" />
                    </label>
                </div>

                <div class="form-control mb-4">
                    <label class="label">
                        <span class="label-text">Berlaku Untuk</span>
                    </label>
                    <select name="berlaku_untuk" class="select select-bordered" required>
                        <option value="SEMUA" {{ old('berlaku_untuk') === 'SEMUA' ? 'selected' : '' }}>Semua Guru</option>
                        <option value="KEPSEK" {{ old('berlaku_untuk') === 'KEPSEK' ? 'selected' : '' }}>Guru merangkap Kepsek saja</option>
                    </select>
                </div>

                <div class="form-control mb-4">
                    <label class="label">
                        <span class="label-text">Urutan</span>
                    </label>
                    <input type="number" name="urutan" value="{{ old('urutan', 0) }}" class="input input-bordered" min="0" />
                </div>

                <div class="form-control mb-4">
                    <label class="label cursor-pointer">
                        <span class="label-text">Aktif?</span>
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="checkbox checkbox-primary" />
                    </label>
                </div>

                <div class="form-control mt-4">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('admin.dokumen.index') }}" class="btn btn-ghost">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection