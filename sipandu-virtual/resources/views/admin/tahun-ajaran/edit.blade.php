@extends('layouts.admin')

@section('title', 'Edit Tahun Ajaran')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-4">Edit Tahun Ajaran</h1>

    <div class="card bg-base-200 shadow-md">
        <div class="card-body">
            <form action="{{ route('admin.tahun-ajaran.update', $tahunAjaran->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-control mb-4">
                    <label class="label">
                        <span class="label-text">Label Tahun Ajaran</span>
                    </label>
                    <input type="text" name="label" value="{{ old('label', $tahunAjaran->label) }}" placeholder="Contoh: 2025/2026" class="input input-bordered" required />
                    @error('label')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                <div class="form-control mb-4">
                    <label class="label cursor-pointer">
                        <span class="label-text">Aktif?</span>
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $tahunAjaran->is_active) ? 'checked' : '' }} class="checkbox checkbox-primary" />
                    </label>
                </div>

                <div class="form-control mt-4">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('admin.tahun-ajaran.index') }}" class="btn btn-ghost">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection