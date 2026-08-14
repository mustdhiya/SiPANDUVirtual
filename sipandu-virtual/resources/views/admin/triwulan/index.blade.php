@extends('layouts.admin')

@section('title', 'Triwulan')

@section('content')
<div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-3xl font-bold">Triwulan</h1>
        <a href="{{ route('admin.triwulan.create') }}" class="btn btn-primary">
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
                    <th>Tahun Ajaran</th>
                    <th>Triwulan</th>
                    <th>Tema</th>
                    <th>Deadline</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($triwulans as $tw)
                    <tr>
                        <td>{{ $tw->id }}</td>
                        <td>{{ $tw->tahunAjaran->label }}</td>
                        <td>TW {{ $tw->nomor }}</td>
                        <td>{{ $tw->tema }}</td>
                        <td>{{ $tw->deadline->format('d M Y') }}</td>
                        <td>
                            @if($tw->is_open)
                                <span class="badge badge-success">Buka</span>
                            @else
                                <span class="badge badge-ghost">Tutup</span>
                            @endif
                        </td>
                        <td>
                            <div class="join">
                                <a href="{{ route('admin.triwulan.edit', $tw->id) }}" class="btn btn-sm btn-info join-item">
                                    <span class="material-icons text-sm">edit</span>
                                </a>
                                <form action="{{ route('admin.triwulan.destroy', $tw->id) }}" method="POST" class="join-item" onsubmit="return confirm('Yakin ingin menghapus?')">
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
                        <td colspan="7" class="text-center">Belum ada data triwulan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection