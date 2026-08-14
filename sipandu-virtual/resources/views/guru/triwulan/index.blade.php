@extends('layouts.guru')

@section('title', 'Triwulan')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-4">Triwulan</h1>

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

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($periodes as $periode)
            @php
                $submission = $submissions->firstWhere('periode_id', $periode->id);
                $statusClass = [
                    'draft' => 'badge-ghost',
                    'submitted' => 'badge-info',
                    'revisi' => 'badge-warning',
                    'lengkap' => 'badge-success',
                ][$submission?->status_review ?? 'draft'];
            @endphp

            <div class="card bg-base-200 shadow-md">
                <div class="card-body">
                    <h2 class="card-title">
                        <span class="material-icons align-middle text-primary">date_range</span>
                        TW {{ $periode->nomor }} - {{ $periode->tahunAjaran->label }}
                    </h2>
                    <p class="text-sm">{{ $periode->tema }}</p>
                    <p class="text-xs">Deadline: {{ $periode->deadline->format('d M Y') }}</p>

                    <div class="card-actions justify-between items-center mt-4">
                        <span class="badge {{ $statusClass }}">
                            {{ ucfirst($submission?->status_review ?? 'Belum Mulai') }}
                        </span>
                        <a href="{{ route('guru.triwulan.show', $periode->id) }}" class="btn btn-primary btn-sm">
                            <span class="material-icons text-sm align-middle mr-1">folder_open</span>
                            Isi
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