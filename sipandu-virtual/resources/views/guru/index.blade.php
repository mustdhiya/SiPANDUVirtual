@extends('layouts.admin')

@section('title', 'Guru Binaan')

@section('content')
<div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-3xl font-bold">Guru Binaan</h1>
        <a href="{{ route('admin.guru.create') }}" class="btn btn-primary">
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
                    <th>Nama Lengkap</th>
                    <th>Sekolah</th>
                    <th>NIP/SIAGA</th>
                    <th>Jabatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($gurus as $guru)
                    <tr>
                        <td>{{ $guru->id }}</td>
                        <td>{{ $guru->nama_lengkap }}</td>
                        <td>{{ $guru->sekolah->nama_sekolah ?? '-' }}</td>
                        <td>{{ $guru->nip_siaga ?? '-' }}</td>
                        <td>
                            @if($guru->status_jabatan === 'GURU')
                                <span class="badge badge-info">Guru PAI</span>
                            @else
                                <span class="badge badge-secondary">Guru + Kepsek</span>
                            @endif
                        </td>
                        <td>
                            <div class="join">
                                <a href="{{ route('admin.guru.edit', $guru->id) }}" class="btn btn-sm btn-info join-item">
                                    <span class="material-icons text-sm">edit</span>
                                </a>
                                <form action="{{ route('admin.guru.destroy', $guru->id) }}" method="POST" class="join-item" onsubmit="return confirm('Yakin ingin menghapus?')">
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
                        <td colspan="6" class="text-center">Belum ada data guru binaan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection