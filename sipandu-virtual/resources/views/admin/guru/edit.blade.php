@extends('layouts.admin')

@section('title', 'Edit Guru Binaan')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-4">Edit Guru Binaan</h1>

    <div class="card bg-base-200 shadow-md">
        <div class="card-body">
            <form action="{{ route('admin.guru.update', $guru->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-control mb-4">
                    <label class="label">
                        <span class="label-text">Nama Lengkap</span>
                    </label>
                    <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $guru->nama_lengkap) }}" class="input input-bordered" required />
                </div>

                <div class="form-control mb-4">
                    <label class="label">
                        <span class="label-text">Sekolah</span>
                    </label>
                    <select name="sekolah_id" class="select select-bordered">
                        <option value="">-- Pilih Sekolah --</option>
                        @foreach($sekolahs as $sekolah)
                            <option value="{{ $sekolah->id }}" {{ old('sekolah_id', $guru->sekolah_id) == $sekolah->id ? 'selected' : '' }}>
                                {{ $sekolah->nama_sekolah }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-control mb-4">
                    <label class="label">
                        <span class="label-text">NIP/SIAGA</span>
                    </label>
                    <input type="text" name="nip_siaga" value="{{ old('nip_siaga', $guru->nip_siaga) }}" class="input input-bordered" />
                </div>

                <div class="form-control mb-4">
                    <label class="label">
                        <span class="label-text">Status Jabatan</span>
                    </label>
                    <select name="status_jabatan" class="select select-bordered" required>
                        <option value="GURU" {{ old('status_jabatan', $guru->status_jabatan) === 'GURU' ? 'selected' : '' }}>Guru PAI</option>
                        <option value="GURU_KEPSEK" {{ old('status_jabatan', $guru->status_jabatan) === 'GURU_KEPSEK' ? 'selected' : '' }}>Guru PAI merangkap Kepala Sekolah</option>
                    </select>
                </div>

                <div class="form-control mb-4">
                    <label class="label cursor-pointer">
                        <span class="label-text">Aktif?</span>
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $guru->is_active) ? 'checked' : '' }} class="checkbox checkbox-primary" />
                    </label>
                </div>

                <div class="form-control mt-4">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('admin.guru.index') }}" class="btn btn-ghost">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection