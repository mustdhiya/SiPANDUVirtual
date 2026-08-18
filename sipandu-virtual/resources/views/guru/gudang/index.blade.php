@extends('layouts.guru')

@section('title', 'Gudang PAI-BMTS')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-4">Gudang PAI-BMTS</h1>

    <div class="alert alert-info shadow-lg mb-4">
        <span class="material-icons align-middle mr-2">info</span>
        <span>Download materi, instrumen riset, dan contoh perangkat dari admin.</span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($materis as $materi)
            <div class="card bg-base-200 shadow-md">
                <div class="card-body">
                    <h2 class="card-title">
                        @if($materi->kategori === 'materi')
                            <span class="material-icons align-middle text-info">menu_book</span>
                        @elseif($materi->kategori === 'instrumen_riset')
                            <span class="material-icons align-middle text-warning">assignment</span>
                        @else
                            <span class="material-icons align-middle text-success">description</span>
                        @endif
                        {{ $materi->judul }}
                    </h2>
                    <p class="text-sm">{{ Str::limit($materi->deskripsi, 100) }}</p>

                    <div class="card-actions justify-between items-center mt-4">
                        <span class="badge {{ $materi->kategori === 'materi' ? 'badge-info' : ($materi->kategori === 'instrumen_riset' ? 'badge-warning' : 'badge-success') }}">
                            {{ ucfirst(str_replace('_', ' ', $materi->kategori)) }}
                        </span>
                        <a href="{{ route('guru.gudang.download', $materi->id) }}" class="btn btn-sm btn-primary">
                            <span class="material-icons text-sm align-middle mr-1">download</span>
                            Download
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center">
                <p>Belum ada materi di gudang.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection