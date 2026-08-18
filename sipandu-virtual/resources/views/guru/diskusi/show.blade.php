@extends('layouts.guru')

@section('title', 'Diskusi TW ' . $periode->nomor)

@section('content')
<div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-3xl font-bold">
            Diskusi TW {{ $periode->nomor }} - {{ $periode->tahunAjaran->label }}
        </h1>
        <div>
            <a href="{{ route('guru.diskusi.index') }}" class="btn btn-ghost">
                <span class="material-icons align-middle">arrow_back</span>
                Kembali
            </a>
            <a href="{{ route('guru.diskusi.create', $periode->id) }}" class="btn btn-primary">
                <span class="material-icons align-middle mr-1">add</span>
                Buat Thread
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success shadow-lg mb-4">
            <span class="material-icons align-middle mr-2">check_circle</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error shadow-lg mb-4">
            <span class="material-icons align-middle mr-2">error</span>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    @forelse($threads as $thread)
        <div class="card bg-base-200 shadow-md mb-4">
            <div class="card-body">
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="card-title">{{ $thread->judul }}</h2>
                        <p class="text-sm text-gray-500">
                            Oleh: {{ $thread->guru->nama_lengkap }} ({{ $thread->guru->sekolah->nama_sekolah ?? '-' }})
                            • {{ $thread->created_at->diffForHumans() }}
                            @if($thread->is_locked)
                                <span class="badge badge-error ml-2">Dikunci</span>
                            @endif
                        </p>
                    </div>
                </div>

                <div class="mt-4 space-y-2">
                    @foreach($thread->pesanDiskusi as $pesan)
                        <div class="p-3 bg-base-100 rounded {{ $pesan->is_admin ? 'border-2 border-primary' : '' }}">
                            <div class="flex justify-between items-center mb-2">
                                <span class="font-bold text-sm">
                                    {{ $pesan->user->name }}
                                    @if($pesan->is_admin)
                                        <span class="badge badge-info ml-2">Admin</span>
                                    @endif
                                </span>
                                <span class="text-xs text-gray-500">{{ $pesan->created_at->format('d M Y H:i') }}</span>
                            </div>
                            <p class="text-sm">{{ $pesan->isi_pesan }}</p>
                        </div>
                    @endforeach
                </div>

                @if(!$thread->is_locked)
                    <form action="{{ route('guru.diskusi.reply', $thread->id) }}" method="POST" class="mt-4">
                        @csrf
                        <div class="form-control">
                            <textarea name="isi_pesan" class="textarea textarea-bordered" rows="2" placeholder="Balas thread..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-sm btn-primary mt-2">
                            <span class="material-icons text-sm align-middle mr-1">reply</span>
                            Balas
                        </button>
                    </form>
                @else
                    <div class="alert alert-warning mt-4">
                        <span class="material-icons align-middle mr-2">lock</span>
                        <span>Thread ini sudah dikunci oleh admin.</span>
                    </div>
                @endif
            </div>
        </div>
    @empty
        <div class="text-center py-8">
            <p>Belum ada thread diskusi untuk triwulan ini.</p>
        </div>
    @endforelse
</div>
@endsection