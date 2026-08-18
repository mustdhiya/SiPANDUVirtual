@extends('layouts.guru')

@section('title', 'Diskusi')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-4">Ruang Diskusi</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($periodes as $periode)
            <div class="card bg-base-200 shadow-md">
                <div class="card-body">
                    <h2 class="card-title">
                        <span class="material-icons align-middle text-primary">forum</span>
                        TW {{ $periode->nomor }} - {{ $periode->tahunAjaran->label }}
                    </h2>
                    <p class="text-sm">{{ $periode->tema }}</p>

                    <div class="card-actions justify-end mt-4">
                        <a href="{{ route('guru.diskusi.show', $periode->id) }}" class="btn btn-primary btn-sm">
                            <span class="material-icons text-sm align-middle mr-1">chat</span>
                            Buka Diskusi
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center">
                <p>Belum ada triwulan yang tersedia.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection