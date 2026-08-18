@extends('layouts.admin')

@section('title', 'Triwulan')

@section('content')
@php
    $totalTriwulan = $triwulans->count();
    $triwulanTerbuka = $triwulans->where('is_open', true)->count();
    $triwulanTertutup = $totalTriwulan - $triwulanTerbuka;

    $deadlineTerdekat = $triwulans
        ->filter(fn ($tw) => $tw->deadline && $tw->deadline->isFuture())
        ->sortBy('deadline')
        ->first();

    $detailTriwulan = [
        1 => [
            'nama' => 'Triwulan I',
            'periode' => 'Januari – Maret',
            'icon' => 'map',
            'warna' => 'primary',
        ],
        2 => [
            'nama' => 'Triwulan II',
            'periode' => 'April – Juni',
            'icon' => 'support_agent',
            'warna' => 'secondary',
        ],
        3 => [
            'nama' => 'Triwulan III',
            'periode' => 'Juli – September',
            'icon' => 'visibility',
            'warna' => 'warning',
        ],
        4 => [
            'nama' => 'Triwulan IV',
            'periode' => 'Oktober – Desember',
            'icon' => 'summarize',
            'warna' => 'success',
        ],
    ];
@endphp

<div class="space-y-8">

    {{-- Header halaman --}}
    <section class="flex flex-col gap-4 border-b border-base-300 pb-5 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.14em] text-secondary">
                Pengaturan Pendampingan
            </p>

            <h1 class="font-display mt-1 text-3xl font-semibold text-neutral">
                Periode Triwulan
            </h1>

            <p class="mt-2 max-w-2xl text-sm leading-6 text-neutral/60">
                Atur periode, tema, batas waktu pengisian, dan status akses setiap triwulan untuk guru.
            </p>
        </div>

        <a href="{{ route('admin.triwulan.create') }}" class="btn btn-primary rounded-xl">
            <span class="material-icons">add</span>
            Tambah Triwulan
        </a>
    </section>

    {{-- Ringkasan --}}
    <section class="grid grid-cols-2 gap-3 sm:grid-cols-4 sm:gap-4">
        <article class="rounded-2xl border border-base-300 bg-base-100 p-4 shadow-sm sm:p-5">
            <div class="flex items-center justify-between">
                <span class="material-icons text-primary">date_range</span>
                <span class="text-[11px] font-bold uppercase tracking-wide text-neutral/45">Total</span>
            </div>

            <p class="mt-5 text-sm text-neutral/60">Periode Triwulan</p>
            <p class="font-display mt-1 text-3xl font-semibold text-primary">{{ $totalTriwulan }}</p>
        </article>

        <article class="rounded-2xl border border-base-300 bg-base-100 p-4 shadow-sm sm:p-5">
            <div class="flex items-center justify-between">
                <span class="material-icons text-success">lock_open</span>
                <span class="text-[11px] font-bold uppercase tracking-wide text-neutral/45">Akses</span>
            </div>

            <p class="mt-5 text-sm text-neutral/60">Triwulan Terbuka</p>
            <p class="font-display mt-1 text-3xl font-semibold text-success">{{ $triwulanTerbuka }}</p>
        </article>

        <article class="rounded-2xl border border-base-300 bg-base-100 p-4 shadow-sm sm:p-5">
            <div class="flex items-center justify-between">
                <span class="material-icons text-neutral/55">lock</span>
                <span class="text-[11px] font-bold uppercase tracking-wide text-neutral/45">Akses</span>
            </div>

            <p class="mt-5 text-sm text-neutral/60">Triwulan Tertutup</p>
            <p class="font-display mt-1 text-3xl font-semibold text-neutral">{{ $triwulanTertutup }}</p>
        </article>

        <article class="rounded-2xl border border-base-300 bg-base-100 p-4 shadow-sm sm:p-5">
            <div class="flex items-center justify-between">
                <span class="material-icons text-secondary">event</span>
                <span class="text-[11px] font-bold uppercase tracking-wide text-neutral/45">Terdekat</span>
            </div>

            <p class="mt-5 text-sm text-neutral/60">Deadline Berikutnya</p>

            @if($deadlineTerdekat)
                <p class="font-display mt-1 text-lg font-semibold text-secondary">
                    {{ $deadlineTerdekat->deadline->format('d M Y') }}
                </p>
                <p class="mt-1 text-xs text-neutral/55">
                    {{ $deadlineTerdekat->deadline->diffForHumans() }}
                </p>
            @else
                <p class="font-display mt-1 text-lg font-semibold text-neutral/50">
                    Belum ada
                </p>
            @endif
        </article>
    </section>

    {{-- Informasi singkat --}}
    <section class="rounded-2xl border border-secondary/20 bg-secondary/10 px-5 py-4">
        <div class="flex items-start gap-3">
            <span class="material-icons mt-0.5 text-secondary">info</span>

            <div>
                <h2 class="font-semibold text-neutral">Petunjuk singkat</h2>
                <p class="mt-1 text-sm leading-6 text-neutral/65">
                    Triwulan yang berstatus <strong>Terbuka</strong> dapat diakses oleh guru.
                    Pastikan deadline sudah sesuai sebelum membuka periode untuk guru.
                </p>
            </div>
        </div>
    </section>

    {{-- Tabel --}}
    <section class="overflow-hidden rounded-2xl border border-base-300 bg-base-100 shadow-sm">
        <div class="flex flex-col gap-2 border-b border-base-300 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="font-display text-xl font-semibold text-neutral">
                    Daftar Triwulan
                </h2>
                <p class="mt-1 text-sm text-neutral/60">
                    Semua periode triwulan yang telah dibuat.
                </p>
            </div>

            <span class="badge badge-outline gap-2 self-start sm:self-auto">
                <span class="material-icons text-sm">format_list_bulleted</span>
                {{ $totalTriwulan }} periode
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="table w-full">
                <thead class="bg-base-200/80 text-neutral/70">
                    <tr>
                        <th class="pl-5">Triwulan</th>
                        <th>Tahun Ajaran</th>
                        <th>Tema Pendampingan</th>
                        <th>Deadline</th>
                        <th>Status Akses</th>
                        <th class="pr-5 text-right">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($triwulans as $tw)
                        @php
                            $detail = $detailTriwulan[$tw->nomor] ?? [
                                'nama' => 'Triwulan ' . $tw->nomor,
                                'periode' => '-',
                                'icon' => 'date_range',
                                'warna' => 'primary',
                            ];

                            $deadlineLewat = $tw->deadline && $tw->deadline->isPast();
                            $hariTersisa = $tw->deadline ? now()->startOfDay()->diffInDays($tw->deadline->copy()->startOfDay(), false) : null;
                        @endphp

                        <tr class="hover:bg-base-200/40">
                            <td class="pl-5">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-{{ $detail['warna'] }}/10 text-{{ $detail['warna'] }}">
                                        <span class="material-icons">{{ $detail['icon'] }}</span>
                                    </div>

                                    <div>
                                        <p class="font-semibold text-neutral">{{ $detail['nama'] }}</p>
                                        <p class="text-xs text-neutral/55">{{ $detail['periode'] }}</p>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <span class="font-medium">{{ $tw->tahunAjaran->label ?? '-' }}</span>
                            </td>

                            <td>
                                <div class="max-w-sm">
                                    <p class="font-medium text-neutral">{{ $tw->tema }}</p>
                                </div>
                            </td>

                            <td>
                                @if($tw->deadline)
                                    <p class="font-medium text-neutral">
                                        {{ $tw->deadline->format('d M Y') }}
                                    </p>

                                    @if($deadlineLewat)
                                        <p class="mt-1 text-xs text-error">
                                            Deadline telah berakhir
                                        </p>
                                    @elseif($hariTersisa === 0)
                                        <p class="mt-1 text-xs font-semibold text-warning">
                                            Batas akhir hari ini
                                        </p>
                                    @elseif($hariTersisa !== null && $hariTersisa <= 7)
                                        <p class="mt-1 text-xs text-warning">
                                            {{ $hariTersisa }} hari lagi
                                        </p>
                                    @else
                                        <p class="mt-1 text-xs text-neutral/55">
                                            {{ $tw->deadline->diffForHumans() }}
                                        </p>
                                    @endif
                                @else
                                    <span class="text-neutral/50">Belum diatur</span>
                                @endif
                            </td>

                            <td>
                                @if($tw->is_open)
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
                            </td>

                            <td class="pr-5">
                                <div class="flex justify-end gap-2">
                                    <a
                                        href="{{ route('admin.triwulan.edit', $tw->id) }}"
                                        class="btn btn-sm btn-outline btn-primary rounded-xl"
                                        title="Edit triwulan"
                                        aria-label="Edit {{ $detail['nama'] }}"
                                    >
                                        <span class="material-icons text-base">edit</span>
                                        <span class="hidden lg:inline">Edit</span>
                                    </a>

                                    <form
                                        action="{{ route('admin.triwulan.destroy', $tw->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Hapus {{ $detail['nama'] }} untuk tahun ajaran {{ $tw->tahunAjaran->label ?? '-' }}? Data terkait dapat ikut terpengaruh.')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-sm btn-ghost rounded-xl text-error hover:bg-error/10"
                                            title="Hapus triwulan"
                                            aria-label="Hapus {{ $detail['nama'] }}"
                                        >
                                            <span class="material-icons text-base">delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-14 text-center">
                                <div class="mx-auto flex max-w-sm flex-col items-center">
                                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-base-200 text-primary">
                                        <span class="material-icons text-3xl">date_range</span>
                                    </div>

                                    <h3 class="font-display mt-4 text-xl font-semibold">
                                        Belum ada triwulan
                                    </h3>

                                    <p class="mt-2 text-sm leading-6 text-neutral/60">
                                        Buat periode triwulan untuk mulai mengatur jadwal dan dokumen pendampingan guru.
                                    </p>

                                    <a href="{{ route('admin.triwulan.create') }}" class="btn btn-primary mt-5 rounded-xl">
                                        <span class="material-icons">add</span>
                                        Tambah Triwulan Pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection