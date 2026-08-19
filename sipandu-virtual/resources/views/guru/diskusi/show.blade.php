@extends('layouts.guru')

@section('title', 'Diskusi TW ' . $periode->nomor)

@section('content')
@php
    $totalThread = $threads->count();
    $totalPesan = $threads->sum(fn ($thread) => $thread->pesanDiskusi->count());
    $threadTerkunci = $threads->where('is_locked', true)->count();
@endphp

<div class="max-w-5xl mx-auto">
    <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between mb-6">
        <div class="flex gap-3">
            <a
                href="{{ route('guru.diskusi.index') }}"
                class="btn btn-circle btn-ghost shrink-0"
                aria-label="Kembali ke daftar diskusi"
            >
                <span class="material-icons">arrow_back</span>
            </a>

            <div>
                <div class="text-sm font-bold tracking-wide uppercase text-secondary">
                    {{ $periode->tahunAjaran->label }}
                </div>

                <h1 class="font-display text-3xl font-semibold mt-1">
                    Diskusi Triwulan {{ $periode->nomor }}
                </h1>

                <p class="text-neutral/60 mt-1">
                    {{ $periode->tema }}
                </p>
            </div>
        </div>

        <a href="{{ route('guru.diskusi.create', $periode->id) }}" class="btn btn-primary gap-2">
            <span class="material-icons">add_comment</span>
            Buat Pertanyaan
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-6">
        <div class="stat bg-base-100 border border-base-300 rounded-2xl p-4">
            <div class="stat-figure text-primary">
                <span class="material-icons">forum</span>
            </div>
            <div class="stat-title">Total Thread</div>
            <div class="stat-value text-primary text-2xl">{{ $totalThread }}</div>
        </div>

        <div class="stat bg-base-100 border border-base-300 rounded-2xl p-4">
            <div class="stat-figure text-info">
                <span class="material-icons">chat</span>
            </div>
            <div class="stat-title">Total Pesan</div>
            <div class="stat-value text-info text-2xl">{{ $totalPesan }}</div>
        </div>

        <div class="stat bg-base-100 border border-base-300 rounded-2xl p-4">
            <div class="stat-figure text-warning">
                <span class="material-icons">lock</span>
            </div>
            <div class="stat-title">Thread Dikunci</div>
            <div class="stat-value text-warning text-2xl">{{ $threadTerkunci }}</div>
        </div>
    </div>

    <div class="alert alert-info mb-6">
        <span class="material-icons">tips_and_updates</span>
        <div>
            <strong>Tips menulis pertanyaan.</strong>
            <div class="text-sm">
                Gunakan judul yang spesifik, jelaskan kendala secara singkat, lalu tunggu tanggapan dari pengawas.
            </div>
        </div>
    </div>

    <div class="space-y-5">
        @forelse($threads as $thread)
            <article class="card bg-base-100 border border-base-300 shadow-sm">
                <div class="card-body p-0">
                    <div class="p-5 border-b border-base-300">
                        <div class="flex flex-col gap-3 md:flex-row md:items-start md:justify-between">
                            <div class="flex gap-3">
                                <div class="avatar placeholder">
                                    <div class="bg-primary text-primary-content rounded-full w-11">
                                        <span class="font-bold">
                                            {{ strtoupper(substr($thread->guru->nama_lengkap, 0, 1)) }}
                                        </span>
                                    </div>
                                </div>

                                <div>
                                    <h2 class="font-display text-xl font-semibold">
                                        {{ $thread->judul }}
                                    </h2>

                                    <p class="text-sm text-neutral/60 mt-1">
                                        {{ $thread->guru->nama_lengkap }}
                                        <span class="mx-1">•</span>
                                        {{ $thread->guru->sekolah->nama_sekolah ?? 'Sekolah belum diatur' }}
                                    </p>

                                    <p class="text-xs text-neutral/50 mt-1">
                                        Dibuat {{ $thread->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>

                            @if($thread->is_locked)
                                <span class="badge badge-warning gap-1">
                                    <span class="material-icons text-xs">lock</span>
                                    Diskusi Ditutup
                                </span>
                            @else
                                <span class="badge badge-success gap-1">
                                    <span class="material-icons text-xs">forum</span>
                                    Diskusi Aktif
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="p-5 bg-base-200/40">
                        <div class="space-y-3">
                            @forelse($thread->pesanDiskusi as $pesan)
                                <div class="flex gap-3 {{ $pesan->is_admin ? 'md:flex-row-reverse' : '' }}">
                                    <div class="avatar placeholder shrink-0">
                                        <div class="{{ $pesan->is_admin ? 'bg-secondary text-secondary-content' : 'bg-primary text-primary-content' }} rounded-full w-9">
                                            <span class="text-xs font-bold">
                                                {{ strtoupper(substr($pesan->user->name, 0, 1)) }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="max-w-3xl {{ $pesan->is_admin ? 'md:text-right' : '' }}">
                                        <div class="flex items-center gap-2 mb-1 {{ $pesan->is_admin ? 'md:justify-end' : '' }}">
                                            <span class="text-sm font-semibold">{{ $pesan->user->name }}</span>

                                            @if($pesan->is_admin)
                                                <span class="badge badge-secondary badge-sm">Pengawas</span>
                                            @endif

                                            <span class="text-xs text-neutral/50">
                                                {{ $pesan->created_at->format('d M Y, H:i') }}
                                            </span>
                                        </div>

                                        <div class="rounded-2xl px-4 py-3 text-sm leading-relaxed {{
                                            $pesan->is_admin
                                                ? 'bg-secondary text-secondary-content rounded-tr-sm'
                                                : 'bg-base-100 border border-base-300 rounded-tl-sm'
                                        }}">
                                            {!! nl2br(e($pesan->isi_pesan)) !!}
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8 text-neutral/60">
                                    Belum ada pesan pada diskusi ini.
                                </div>
                            @endforelse
                        </div>
                    </div>

                    @if(!$thread->is_locked)
                        <div class="p-5 border-t border-base-300">
                            <form action="{{ route('guru.diskusi.reply', $thread->id) }}" method="POST">
                                @csrf

                                <label class="form-control">
                                    <span class="label">
                                        <span class="label-text font-semibold">Tulis Balasan</span>
                                    </span>

                                    <textarea
                                        name="isi_pesan"
                                        class="textarea textarea-bordered min-h-28 @error('isi_pesan') textarea-error @enderror"
                                        placeholder="Tulis tanggapan atau tambahan informasi Anda..."
                                        required
                                    >{{ old('isi_pesan') }}</textarea>

                                    @error('isi_pesan')
                                        <span class="label">
                                            <span class="label-text-alt text-error">{{ $message }}</span>
                                        </span>
                                    @enderror
                                </label>

                                <div class="flex justify-end mt-3">
                                    <button type="submit" class="btn btn-primary gap-2">
                                        <span class="material-icons">send</span>
                                        Kirim Balasan
                                    </button>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="alert alert-warning rounded-none rounded-b-2xl">
                            <span class="material-icons">lock</span>
                            <div>
                                <strong>Thread ini telah dikunci pengawas.</strong>
                                <div class="text-sm">
                                    Anda masih dapat membaca diskusi, tetapi tidak dapat mengirim balasan baru.
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </article>
        @empty
            <div class="card bg-base-100 border border-base-300">
                <div class="card-body items-center text-center py-14">
                    <span class="material-icons text-6xl text-neutral/25">forum</span>
                    <h2 class="font-display text-2xl font-semibold mt-3">
                        Belum ada diskusi
                    </h2>
                    <p class="text-neutral/60 max-w-md">
                        Belum ada pertanyaan untuk Triwulan {{ $periode->nomor }}. Anda dapat memulai diskusi baru dengan pengawas.
                    </p>
                    <a href="{{ route('guru.diskusi.create', $periode->id) }}" class="btn btn-primary mt-3 gap-2">
                        <span class="material-icons">add_comment</span>
                        Buat Pertanyaan
                    </a>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection