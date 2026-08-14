@extends('layouts.admin')

@section('title', 'Tahun Ajaran')

@section('content')
<div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-3xl font-bold">Tahun Ajaran</h1>
        <a href="{{ route('admin.tahun-ajaran.create') }}" class="btn btn-primary">
            <span class="material-icons text-sm align-middle mr-1">add</span>
            Tambah
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success shadow-lg mb-4">
            <span class="material-icons align-middle mr-2">check_circle</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="table table-zebra w-full">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Label</th>
                    <th>Status</th>
                    <th>Dibuat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tahunAjarans as $ta)
                    <tr>
                        <td>{{ $ta->id }}</td>
                        <td>{{ $ta->label }}</td>
                        <td>
                            @if($ta->is_active)
                                <span class="badge badge-success">Aktif</span>
                            @else
                                <span class="badge badge-ghost">Tidak Aktif</span>
                            @endif
                        </td>
                        <td>{{ $ta->created_at->format('d M Y') }}</td>
                        <td>
                            <div class="join">
                                <a href="{{ route('admin.tahun-ajaran.edit', $ta->id) }}" class="btn btn-sm btn-info join-item">
                                    <span class="material-icons text-sm">edit</span>
                                </a>
                                <form action="{{ route('admin.tahun-ajaran.destroy', $ta->id) }}" method="POST" class="join-item" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-error">
                                        <span class="material-icons text-sm">delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Belum ada data tahun ajaran.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection