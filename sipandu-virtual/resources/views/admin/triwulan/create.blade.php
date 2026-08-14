@extends('layouts.admin')

@section('title', 'Tambah Triwulan')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-4">Tambah Triwulan</h1>

    <div class="card bg-base-200 shadow-md">
        <div class="card-body">
            <form action="{{ route('admin.triwulan.store') }}" method="POST">
                @csrf

                <div class="form-control mb-4">
                    <label class="label">
                        <span class="label-text">Tahun Ajaran</span>
                    </label>
                    <select name="tahun_ajaran_id" class="select select-bordered" required>
                        @foreach($tahunAjarans as $ta)
                            <option value="{{ $ta->id }}">{{ $ta->label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-control mb-4">
                    <label class="label">
                        <span class="label-text">Triwulan</span>
                    </label>
                    <select name="nomor" class="select select-bordered" required>
                        <option value="1">Triwulan I — Perencanaan & Pemetaan (Jan–Mar)</option>
                        <option value="2">Triwulan II — Pendampingan Tahap Awal (Apr–Jun)</option>
                        <option value="3">Triwulan III — Observasi & Umpan Balik (Jul–Sep)</option>
                        <option value="4">Triwulan IV — Evaluasi & Pelaporan (Okt–Des)</option>
                    </select>
                </div>

                <div class="form-control mb-4">
                    <label class="label">
                        <span class="label-text">Tema</span>
                    </label>
                    <input type="text" name="tema" value="{{ old('tema') }}" placeholder="Contoh: Pendampingan Tahap Awal" class="input input-bordered" required />
                </div>

                <div class="form-control mb-4">
                    <label class="label">
                        <span class="label-text">Deadline</span>
                    </label>
                    <input type="date" name="deadline" value="{{ old('deadline') }}" class="input input-bordered" required />
                </div>

                <div class="form-control mb-4">
                    <label class="label cursor-pointer">
                        <span class="label-text">Buka untuk guru?</span>
                        <input type="checkbox" name="is_open" value="1" {{ old('is_open') ? 'checked' : '' }} class="checkbox checkbox-primary" />
                    </label>
                </div>

                <div class="form-control mt-4">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('admin.triwulan.index') }}" class="btn btn-ghost">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection