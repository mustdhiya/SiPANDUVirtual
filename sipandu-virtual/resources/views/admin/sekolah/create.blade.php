@extends('layouts.admin')

@section('title', 'Tambah Sekolah Binaan')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-4">Tambah Sekolah Binaan</h1>

    <div class="card bg-base-200 shadow-md">
        <div class="card-body">
            <form action="{{ route('admin.sekolah.store') }}" method="POST">
                @csrf

                <div class="form-control mb-4">
                    <label class="label">
                        <span class="label-text">Nama Sekolah</span>
                    </label>
                    <input type="text" name="nama_sekolah" value="{{ old('nama_sekolah') }}" placeholder="Contoh: SMA Negeri 1 Samarinda" class="input input-bordered" required />
                </div>

                <div class="form-control mb-4">
                    <label class="label">
                        <span class="label-text">Jenjang</span>
                    </label>
                    <select name="jenjang" class="select select-bordered" required>
                        <option value="SMA">SMA</option>
                        <option value="SMK">SMK</option>
                    </select>
                </div>

                <div class="form-control mb-4">
                    <label class="label">
                        <span class="label-text">Status</span>
                    </label>
                    <select name="status" class="select select-bordered" required>
                        <option value="N">Negeri</option>
                        <option value="S">Swasta</option>
                    </select>
                </div>

                <div class="form-control mb-4">
                    <label class="label cursor-pointer">
                        <span class="label-text">Aktif?</span>
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="checkbox checkbox-primary" />
                    </label>
                </div>

                <div class="form-control mt-4">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('admin.sekolah.index') }}" class="btn btn-ghost">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection