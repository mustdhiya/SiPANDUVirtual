@extends('layouts.admin')

@section('title', 'Approve Guru')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-4">Approve Registrasi Guru</h1>

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
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Nomor WA</th>
                    <th>Terdaftar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pendingGurus as $guru)
                    <tr>
                        <td>{{ $guru->id }}</td>
                        <td>{{ $guru->name }}</td>
                        <td>{{ $guru->email }}</td>
                        <td>{{ $guru->nomor_wa ?? '-' }}</td>
                        <td>{{ $guru->created_at->format('d M Y H:i') }}</td>
                        <td>
                            <div class="join">
                                <form action="{{ route('admin.approve-guru.approve', $guru->id) }}" method="POST" class="join-item">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success">
                                        <span class="material-icons text-sm">check</span>
                                        Setujui
                                    </button>
                                </form>

                                <button onclick="document.getElementById('reject-modal-{{ $guru->id }}').showModal()" class="btn btn-sm btn-error join-item">
                                    <span class="material-icons text-sm">close</span>
                                    Tolak
                                </button>
                            </div>

                            <dialog id="reject-modal-{{ $guru->id }}" class="modal">
                                <form method="dialog" class="modal-box">
                                    <h3 class="font-bold text-lg mb-4">Tolak Registrasi Guru</h3>
                                    <form action="{{ route('admin.approve-guru.reject', $guru->id) }}" method="POST">
                                        @csrf
                                        <div class="form-control mb-4">
                                            <label class="label">
                                                <span class="label-text">Alasan Penolakan</span>
                                            </label>
                                            <textarea name="alasan" class="textarea textarea-bordered" rows="3" required></textarea>
                                        </div>
                                        <div class="modal-action">
                                            <button type="submit" class="btn btn-error">Tolak</button>
                                            <button class="btn">Batal</button>
                                        </div>
                                    </form>
                                </form>
                            </dialog>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada registrasi guru yang pending.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection