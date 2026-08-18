@extends('layouts.admin')

@section('title', 'Diskusi TW ' . $periode->nomor)

@section('content')
@php
    $totalThreads = $threads->count();
    $lockedThreads = $threads->where('is_locked', true)->count();
    $activeThreads = $totalThreads - $lockedThreads;
@endphp

<div class="space-y-7">

    {{-- Breadcrumb dan header --}}
    <section class="border-b border-base-300 pb-5">
        <a
            href="{{ route('admin.diskusi.index') }}"
            class="btn btn-ghost btn-sm -ml-2 mb-4 rounded-xl text-neutral/65 hover:text-primary"
        >
            <span class="material-icons text-base">arrow_back</span>
            Kembali ke Daftar Triwulan
        </a>

        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.14em] text-secondary">
                    Ruang Diskusi Triwulan {{ $periode->nomor }}
                </p>

                <h1 class="font-display mt-1 text-3xl font-semibold leading-tight text-neutral">
                    {{ $periode->tahunAjaran->label }}
                </h1>

                <p class="mt-2 max-w-2xl text-sm leading-6 text-neutral/60">
                    {{ $periode->tema }}
                </p>
            </div>

            <div class="flex flex-wrap gap-2">
                <span class="badge badge-outline badge-lg gap-2">
                    <span class="material-icons text-base text-primary">forum</span>
                    {{ $totalThreads }} Thread
                </span>

                <span class="badge badge-success badge-lg gap-2">
                    <span class="material-icons text-base">mark_chat_read</span>
                    {{ $activeThreads }} Aktif
                </span>

                @if($lockedThreads > 0)
                    <span class="badge badge-ghost badge-lg gap-2">
                        <span class="material-icons text-base">lock</span>
                        {{ $lockedThreads }} Terkunci
                    </span>
                @endif
            </div>
        </div>
    </section>

    {{-- Informasi status periode --}}
    <section class="rounded-2xl border border-base-300 bg-base-200/65 p-4 sm:p-5">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div class="flex items-start gap-3">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-primary/10 text-primary">
                    <span class="material-icons">info</span>
                </div>

                <div>
                    <h2 class="font-semibold text-neutral">
                        Panduan untuk Pengawas
                    </h2>

                    <p class="mt-1 text-sm leading-6 text-neutral/65">
                        Balas pertanyaan yang membutuhkan arahan. Gunakan tombol kunci jika pembahasan sudah selesai agar percakapan tidak berubah lagi.
                    </p>
                </div>
            </div>

            <div class="rounded-xl border border-base-300 bg-base-100 px-4 py-3 text-sm">
                <p class="text-xs font-semibold uppercase tracking-wide text-neutral/50">
                    Deadline Triwulan
                </p>
                <p class="mt-1 flex items-center gap-2 font-semibold text-neutral">
                    <span class="material-icons text-base text-secondary">event</span>
                    {{ $periode->deadline ? $periode->deadline->format('d M Y') : 'Belum ditentukan' }}
                </p>
            </div>
        </div>
    </section>

    {{-- Daftar thread --}}
    <section>
        <div class="mb-4">
            <p class="text-xs font-bold uppercase tracking-[0.14em] text-secondary">
                Percakapan Guru
            </p>

            <h2 class="font-display mt-1 text-2xl font-semibold text-neutral">
                Thread Diskusi
            </h2>
        </div>

        <div class="space-y-5">
            @forelse($threads as $thread)
                @php
                    $totalPesan = $thread->pesanDiskusi->count();
                    $lastMessage = $thread->pesanDiskusi->sortByDesc('created_at')->first();
                @endphp

                <article class="overflow-hidden rounded-2xl border border-base-300 bg-base-100 shadow-sm">
                    {{-- Thread header --}}
                    <div class="border-b border-base-300 bg-base-200/60 px-5 py-4 sm:px-6">
                        <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                            <div class="flex min-w-0 gap-3">
                                <div class="avatar placeholder mt-0.5">
                                    <div class="w-10 rounded-full bg-secondary/15 text-secondary">
                                        <span class="text-sm font-bold">
                                            {{ strtoupper(substr($thread->guru->nama_lengkap, 0, 1)) }}
                                        </span>
                                    </div>
                                </div>

                                <div class="min-w-0">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <h3 class="font-display text-xl font-semibold leading-snug text-neutral">
                                            {{ $thread->judul }}
                                        </h3>

                                        @if($thread->is_locked)
                                            <span class="badge badge-ghost gap-1">
                                                <span class="material-icons text-sm">lock</span>
                                                Dikunci
                                            </span>
                                        @else
                                            <span class="badge badge-success gap-1">
                                                <span class="material-icons text-sm">lock_open</span>
                                                Aktif
                                            </span>
                                        @endif
                                    </div>

                                    <p class="mt-1 text-sm text-neutral/65">
                                        <strong class="font-semibold text-neutral">
                                            {{ $thread->guru->nama_lengkap }}
                                        </strong>
                                        <span class="mx-1">·</span>
                                        {{ $thread->guru->sekolah->nama_sekolah ?? 'Sekolah belum diatur' }}
                                    </p>

                                    <div class="mt-2 flex flex-wrap gap-x-4 gap-y-1 text-xs text-neutral/50">
                                        <span class="inline-flex items-center gap-1">
                                            <span class="material-icons text-sm">schedule</span>
                                            Dibuat {{ $thread->created_at->diffForHumans() }}
                                        </span>

                                        <span class="inline-flex items-center gap-1">
                                            <span class="material-icons text-sm">chat_bubble_outline</span>
                                            {{ $totalPesan }} pesan
                                        </span>

                                        @if($lastMessage)
                                            <span class="inline-flex items-center gap-1">
                                                <span class="material-icons text-sm">update</span>
                                                Aktivitas terakhir {{ $lastMessage->created_at->diffForHumans() }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="flex shrink-0 gap-2">
                                @if($thread->is_locked)
                                    <form action="{{ route('admin.diskusi.unlock', $thread->id) }}" method="POST">
                                        @csrf

                                        <button
                                            type="submit"
                                            class="btn btn-sm btn-outline btn-success rounded-xl"
                                            title="Buka kembali thread ini"
                                        >
                                            <span class="material-icons text-base">lock_open</span>
                                            Buka
                                        </button>
                                    </form>
                                @else
                                    <form
                                        action="{{ route('admin.diskusi.lock', $thread->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Kunci thread ini? Guru tidak dapat lagi mengirim balasan setelah thread dikunci.')"
                                    >
                                        @csrf

                                        <button
                                            type="submit"
                                            class="btn btn-sm btn-outline btn-error rounded-xl"
                                            title="Kunci thread diskusi"
                                        >
                                            <span class="material-icons text-base">lock</span>
                                            Kunci
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Isi pesan --}}
                    <div class="space-y-4 px-5 py-5 sm:px-6">
                        @forelse($thread->pesanDiskusi as $pesan)
                            <div class="flex gap-3 {{ $pesan->is_admin ? 'justify-end' : 'justify-start' }}">
                                @if(!$pesan->is_admin)
                                    <div class="avatar placeholder mt-1">
                                        <div class="w-8 rounded-full bg-base-300 text-neutral/65">
                                            <span class="text-xs font-bold">
                                                {{ strtoupper(substr($pesan->user->name, 0, 1)) }}
                                            </span>
                                        </div>
                                    </div>
                                @endif

                                <div class="max-w-3xl {{ $pesan->is_admin ? 'order-1' : '' }}">
                                    <div class="mb-1 flex items-center gap-2 {{ $pesan->is_admin ? 'justify-end' : '' }}">
                                        <span class="text-xs font-semibold text-neutral/65">
                                            {{ $pesan->is_admin ? 'Anda — Pengawas PAI' : $pesan->user->name }}
                                        </span>

                                        @if($pesan->is_admin)
                                            <span class="badge badge-primary badge-sm">Admin</span>
                                        @endif

                                        <span class="text-xs text-neutral/45">
                                            {{ $pesan->created_at->format('d M Y, H:i') }}
                                        </span>
                                    </div>

                                    <div class="rounded-2xl px-4 py-3 text-sm leading-6 shadow-sm {{ $pesan->is_admin ? 'bg-primary text-primary-content rounded-tr-sm' : 'border border-base-300 bg-base-100 text-neutral rounded-tl-sm' }}">
                                        {!! nl2br(e($pesan->isi_pesan)) !!}
                                    </div>
                                </div>

                                @if($pesan->is_admin)
                                    <div class="avatar placeholder order-2 mt-1">
                                        <div class="w-8 rounded-full bg-primary text-primary-content">
                                            <span class="text-xs font-bold">
                                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                            </span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="rounded-xl border border-dashed border-base-300 bg-base-200/45 px-4 py-5 text-center text-sm text-neutral/60">
                                Belum ada pesan dalam thread ini.
                            </div>
                        @endforelse
                    </div>

                    {{-- Form balasan --}}
                    @if(!$thread->is_locked)
                        <div class="border-t border-base-300 bg-base-200/45 px-5 py-4 sm:px-6">
                            <form action="{{ route('admin.diskusi.reply', $thread->id) }}" method="POST">
                                @csrf

                                <label for="reply-{{ $thread->id }}" class="mb-2 block text-sm font-semibold text-neutral">
                                    Balas sebagai Pengawas PAI
                                </label>

                                <div class="flex flex-col gap-3 sm:flex-row sm:items-end">
                                    <textarea
                                        id="reply-{{ $thread->id }}"
                                        name="isi_pesan"
                                        class="textarea textarea-bordered min-h-24 flex-1 rounded-xl bg-base-100 focus:border-primary focus:outline-primary"
                                        rows="3"
                                        placeholder="Tulis arahan atau jawaban untuk guru..."
                                        required
                                    ></textarea>

                                    <button type="submit" class="btn btn-primary rounded-xl sm:min-w-32">
                                        <span class="material-icons text-base">send</span>
                                        Kirim Balasan
                                    </button>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="border-t border-base-300 bg-base-200/60 px-5 py-4 sm:px-6">
                            <div class="flex items-center gap-2 text-sm text-neutral/65">
                                <span class="material-icons text-secondary">lock</span>
                                Thread dikunci. Buka kembali thread jika percakapan perlu dilanjutkan.
                            </div>
                        </div>
                    @endif
                </article>
            @empty
                <div class="rounded-2xl border border-dashed border-base-300 bg-base-100 px-5 py-14 text-center">
                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-base-200 text-neutral/50">
                        <span class="material-icons text-3xl">forum</span>
                    </div>

                    <h2 class="font-display mt-4 text-xl font-semibold text-neutral">
                        Belum Ada Diskusi
                    </h2>

                    <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-neutral/60">
                        Belum ada guru yang membuat thread diskusi pada Triwulan {{ $periode->nomor }}.
                    </p>
                </div>
            @endforelse
        </div>
    </section>
</div>
@endsection