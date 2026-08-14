@extends('layouts.admin')

@section('title', 'Sekolah Binaan')

@section('content')
<div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-3xl font-bold">Sekolah Binaan</h1>
        <a href="{{ route('admin.sekolah.create') }}" class="btn btn-primary">
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
                    <th>Nama Sekolah</th>
                    <th>Jenjang</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sekolahs as $sekolah)
                    <tr>
                        <td>{{ $sekolah->id }}</td>
                        <td>{{ $sekolah->nama_sekolah }}</td>
                        <td>{{ $sekolah->jenjang }}</td>
                        <td>
                            @if($sekolah->status === 'N')
                                <span class="badge badge-info">Negeri</span>
                            @else
                                <span class="badge badge-warning">Swasta</span>
                            @endif
                        </td>
                        <td>
                            <div class="join">
                                <a href="{{ route('admin.sekolah.edit', $sekolah->id) }}" class="btn btn-sm btn-info join-item">
                                    <span class="material-icons text-sm">edit</span>
                                </a>
                                <form action="{{ route('admin.sekolah.destroy', $sekolah->id) }}" method="POST" class="join-item" onsubmit="return confirm('Yakin ingin menghapus?')">
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
                        <td colspan="5" class="text-center">Belum ada data sekolah binaan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection