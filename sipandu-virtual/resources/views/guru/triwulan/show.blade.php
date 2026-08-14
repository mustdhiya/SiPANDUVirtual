@extends('layouts.guru')

@section('title', 'TW ' . $periode->nomor)

@section('content')
<div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-3xl font-bold">
            TW {{ $periode->nomor }} - {{ $periode->tahunAjaran->label }}
        </h1>
        <a href="{{ route('guru.triwulan.index') }}" class="btn btn-ghost">
            <span class="material-icons align-middle">arrow_back</span>
            Kembali
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success shadow-lg mb-4">
            <span class="material-icons align-middle mr-2">check_circle</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="alert alert-info shadow-lg mb-4">
        <span class="material-icons align-middle mr-2">info</span>
        <div>
            <h3 class="font-bold">{{ $periode->tema }}</h3>
            <p>Deadline: {{ $periode->deadline->format('d M Y') }}</p>
            <p>Status: {{ $periode->is_open ? 'Buka' : 'Tutup' }}</p>
        </div>
    </div>

    <div class="card bg-base-200 shadow-md">
        <div class="card-body">
            <h2 class="card-title mb-4">Upload Dokumen</h2>

            @forelse($dokumenWajibs as $dokumen)
                @php
                    $uploaded = $uploadedDocs->get($dokumen->id);
                @endphp

                <div class="mb-6 p-4 bg-base-100 rounded">
                    <h3 class="font-bold text-lg mb-2">
                        {{ $dokumen->nama_dokumen }}
                        @if($dokumen->is_wajib)
                            <span class="badge badge-error ml-2">Wajib</span>
                        @endif
                    </h3>
                    <p class="text-sm mb-4">{{ $dokumen->instruksi }}</p>

                    @if($uploaded)
                        <div class="alert alert-success">
                            <span class="material-icons align-middle mr-2">check_circle</span>
                            <span>Sudah diupload - Status: {{ ucfirst($uploaded->status) }}</span>
                        </div>

                        @if($uploaded->feedback_admin)
                            <div class="alert alert-warning mt-2">
                                <span class="material-icons align-middle mr-2">feedback</span>
                                <span>Feedback: {{ $uploaded->feedback_admin }}</span>
                            </div>
                        @endif

                        <div class="mt-2">
                            <a href="{{ asset('storage/' . $uploaded->file) }}" class="btn btn-sm btn-info" target="_blank">
                                <span class="material-icons text-sm align-middle mr-1">visibility</span>
                                Lihat Dokumen
                            </a>
                        </div>
                    @else
                        <form action="{{ route('guru.triwulan.upload', $periode->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="dokumen_wajib_id" value="{{ $dokumen->id }}">

                            <div class="form-control mb-4">
                                <label class="label">
                                    <span class="label-text">File (max 10MB)</span>
                                </label>
                                <input type="file" name="file" class="file-input file-input-bordered" required />
                            </div>

                            <div class="form-control mb-4">
                                <label class="label">
                                    <span class="label-text">Catatan (opsional)</span>
                                </label>
                                <textarea name="catatan" class="textarea textarea-bordered" rows="2"></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary btn-sm">
                                <span class="material-icons text-sm align-middle mr-1">upload_file</span>
                                Upload
                            </button>
                        </form>
                    @endif
                </div>
            @empty
                <p>Belum ada dokumen wajib untuk triwulan ini.</p>
            @endforelse

            @if($submission->status_review === 'draft' && $dokumenWajibs->count() > 0)
                <form action="{{ route('guru.triwulan.submit', $periode->id) }}" method="POST" class="mt-4">
                    @csrf
                    <button type="submit" class="btn btn-success">
                        <span class="material-icons align-middle mr-2">send</span>
                        Submit untuk Review
                    </button>
                </form>
            @elseif($submission->status_review === 'submitted')
                <div class="alert alert-info mt-4">
                    <span class="material-icons align-middle mr-2">info</span>
                    <span>Submission sudah dikirim dan menunggu review admin.</span>
                </div>
            @elseif($submission->status_review === 'lengkap')
                <div class="alert alert-success mt-4">
                    <span class="material-icons align-middle mr-2">check_circle</span>
                    <span>Submission sudah lengkap dan disetujui admin.</span>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection