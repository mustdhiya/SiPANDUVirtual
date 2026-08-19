@extends('layouts.admin')

@section('title', 'Ruang Diskusi')

@section('content')
@php
    $totalPeriode = $periodes->count();
    $periodeTerbuka = $periodes->where('is_open', true)->count();
@endphp

<div class="mx-auto max-w-7xl space-y-8">

    {{-- Header halaman --}}
    <section class="flex flex-col gap-4 border-b border-base-300 pb-6 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.14em] text-secondary">
                Pendampingan Guru
            </p>

            <h1 class="font-display mt-2 text-3xl font-semibold text-base-content md:text-4xl">
                Ruang Diskusi
            </h1>

            <p class="mt-2 max-w-2xl text-sm leading-6 text-base-content/70">
                Pilih triwulan untuk membaca pertanyaan guru, memberikan arahan,
                dan mengelola percakapan pendampingan.
            </p>
        </div>

        <div class="flex flex-wrap gap-2">
            <span class="badge badge-outline badge-lg gap-2">
                <span class="material-icons text-base text-primary">date_range</span>
                {{ $totalPeriode }} Triwulan
            </span>

            <span class="badge badge-success badge-lg gap-2">
                <span class="material-icons text-base">lock_open</span>
                {{ $periodeTerbuka }} Terbuka
            </span>
        </div>
    </section>

    {{-- Informasi penggunaan --}}
    <section class="rounded-2xl border border-secondary/30 bg-secondary/10 px-5 py-4">
        <div class="flex items-start gap-3">
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-secondary/20 text-secondary">
                <span class="material-icons">forum</span>
            </div>

            <div>
                <h2 class="font-semibold text-base-content">
                    Cara menggunakan ruang diskusi
                </h2>

                <p class="mt-1 text-sm leading-6 text-base-content/75">
                    Buka periode triwulan untuk melihat seluruh thread diskusi.
                    Pengawas dapat membalas pertanyaan guru dan mengunci thread
                    yang pembahasannya sudah selesai.
                </p>
            </div>
        </div>
    </section>

    {{-- Daftar triwulan --}}
    <section>
        <div class="mb-4">
            <p class="text-xs font-bold uppercase tracking-[0.14em] text-secondary">
                Pilih Periode
            </p>

            <h2 class="font-display mt-1 text-2xl font-semibold text-base-content">
                Diskusi Berdasarkan Triwulan
            </h2>
        </div>

        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            @forelse($periodes as $periode)
                @php
                    $isOpen = (bool) $periode->is_open;
                    $isPastDeadline = $periode->deadline && now()->greaterThan($periode->deadline);
                @endphp

                <article class="card overflow-hidden border border-base-300 bg-base-100 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:border-primary hover:shadow-md">
                    <div class="h-1.5 {{ $isOpen ? 'bg-primary' : 'bg-base-300' }}"></div>

                    <div class="card-body gap-5 p-5">
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl {{ $isOpen ? 'bg-primary/15 text-primary' : 'bg-base-200 text-base-content/60' }}">
                                <span class="material-icons">forum</span>
                            </div>

                            @if($isOpen)
                                <span class="badge badge-success gap-1">
                                    <span class="material-icons text-sm">lock_open</span>
                                    Terbuka
                                </span>
                            @else
                                <span class="badge badge-ghost gap-1">
                                    <span class="material-icons text-sm">lock</span>
                                    Tertutup
                                </span>
                            @endif
                        </div>

                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.12em] text-secondary">
                                Triwulan {{ $periode->nomor }}
                            </p>

                            <h3 class="font-display mt-1 text-xl font-semibold leading-snug text-base-content">
                                {{ $periode->tahunAjaran->label ?? 'Tahun ajaran belum diatur' }}
                            </h3>

                            <p class="mt-2 min-h-12 text-sm leading-6 text-base-content/70">
                                {{ $periode->tema }}
                            </p>
                        </div>

                        <div class="rounded-xl bg-base-200 px-3 py-3 text-sm">
                            <div class="flex items-center gap-2 text-base-content/75">
                                <span class="material-icons text-base text-secondary">event</span>

                                <span>
                                    Deadline:
                                    <strong class="font-semibold text-base-content">
                                        {{ $periode->deadline ? $periode->deadline->translatedFormat('d M Y') : 'Belum ditentukan' }}
                                    </strong>
                                </span>
                            </div>

                            @if($isPastDeadline)
                                <p class="mt-2 text-xs font-semibold text-warning">
                                    Deadline periode ini sudah berlalu.
                                </p>
                            @elseif($periode->deadline)
                                <p class="mt-2 text-xs text-base-content/60">
                                    {{ $periode->deadline->diffForHumans() }}
                                </p>
                            @endif
                        </div>

                        <div class="card-actions mt-auto">
                            <a
                                href="{{ route('admin.diskusi.show', $periode->id) }}"
                                class="btn btn-primary w-full rounded-xl"
                            >
                                <span class="material-icons text-base">chat</span>
                                Buka Ruang Diskusi
                            </a>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-full rounded-2xl border border-dashed border-base-300 bg-base-100 px-5 py-14 text-center">
                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-base-200 text-base-content/60">
                        <span class="material-icons text-3xl">date_range</span>
                    </div>

                    <h2 class="font-display mt-4 text-xl font-semibold text-base-content">
                        Belum Ada Triwulan
                    </h2>

                    <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-base-content/70">
                        Buat tahun ajaran dan periode triwulan terlebih dahulu agar ruang diskusi dapat digunakan.
                    </p>

                    <a
                        href="{{ route('admin.triwulan.index') }}"
                        class="btn btn-primary mt-5 rounded-xl"
                    >
                        <span class="material-icons text-base">add</span>
                        Kelola Triwulan
                    </a>
                </div>
            @endforelse
        </div>
    </section>
</div>
@endsection