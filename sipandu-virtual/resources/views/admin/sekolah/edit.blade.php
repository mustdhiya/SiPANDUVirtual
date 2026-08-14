@extends('layouts.admin')

@section('title', 'Edit Sekolah Binaan')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-4">Edit Sekolah Binaan</h1>

    <div class="card bg-base-200 shadow-md">
        <div class="card-body">
            <form action="{{ route('admin.sekolah.update', $sekolah->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-control mb-4">
                    <label class="label">
                        <span class="label-text">Nama Sekolah</span>
                    </label>
                    <input type="text" name="nama_sekolah" value="{{ old('nama_sekolah', $sekolah->nama_sekolah) }}" class="input input-bordered" required />
                </div>

                <div class="form-control mb-4">
                    <label class="label">
                        <span class="label-text">Jenjang</span>
                    </label>
                    <select name="jenjang" class="select select-bordered" required>
                        <option value="SMA" {{ $sekolah->jenjang === 'SMA' ? 'selected' : '' }}>SMA</option>
                        <option value="SMK" {{ $sekolah->jenjang === 'SMK' ? 'selected' : '' }}>SMK</option>
                    </select>
                </div>

                <div class="form-control mb-4">
                    <label class="label">
                        <span class="label-text">Status</span>
                    </label>
                    <select name="status" class="select select-bordered" required>
                        <option value="N" {{ $sekolah->status === 'N' ? 'selected' : '' }}>Negeri</option>
                        <option value="S" {{ $sekolah->status === 'S' ? 'selected' : '' }}>Swasta</option>
                    </select>
                </div>

                <div class="form-control mb-4">
                    <label class="label cursor-pointer">
                        <span class="label-text">Aktif?</span>
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $sekolah->is_active) ? 'checked' : '' }} class="checkbox checkbox-primary" />
                    </label>
                </div>

                <div class="form-control mt-4">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('admin.sekolah.index') }}" class="btn btn-ghost">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection