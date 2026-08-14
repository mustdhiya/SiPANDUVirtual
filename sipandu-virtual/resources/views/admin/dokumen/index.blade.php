@extends('layouts.admin')

@section('title', 'Dokumen Wajib')

@section('content')
<div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-3xl font-bold">Dokumen Wajib</h1>
        <a href="{{ route('admin.dokumen.create') }}" class="btn btn-primary">
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
                    <th>Triwulan</th>
                    <th>Nama Dokumen</th>
                    <th>Instruksi</th>
                    <th>Wajib</th>
                    <th>Berlaku Untuk</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($dokumens as $dokumen)
                    <tr>
                        <td>{{ $dokumen->id }}</td>
                        <td>TW {{ $dokumen->triwulan }}</td>
                        <td>{{ $dokumen->nama_dokumen }}</td>
                        <td class="max-w-xs truncate">{{ $dokumen->instruksi }}</td>
                        <td>
                            @if($dokumen->is_wajib)
                                <span class="badge badge-success">Wajib</span>
                            @else
                                <span class="badge badge-ghost">Opsional</span>
                            @endif
                        </td>
                        <td>
                            @if($dokumen->berlaku_untuk === 'SEMUA')
                                <span class="badge badge-info">Semua Guru</span>
                            @else
                                <span class="badge badge-secondary">Kepsek Saja</span>
                            @endif
                        </td>
                        <td>
                            <div class="join">
                                <a href="{{ route('admin.dokumen.edit', $dokumen->id) }}" class="btn btn-sm btn-info join-item">
                                    <span class="material-icons text-sm">edit</span>
                                </a>
                                <form action="{{ route('admin.dokumen.destroy', $dokumen->id) }}" method="POST" class="join-item" onsubmit="return confirm('Yakin ingin menghapus?')">
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
                        <td colspan="7" class="text-center">Belum ada data dokumen wajib.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection