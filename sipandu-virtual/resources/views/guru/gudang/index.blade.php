@extends('layouts.guru')

@section('title', 'Gudang PAI-BMTS')

@section('content')
@php
    $totalMateri = $materis->count();
    $materiUmum = $materis->where('kategori', 'materi')->count();
    $instrumenRiset = $materis->where('kategori', 'instrumen_riset')->count();
    $contohPerangkat = $materis->where('kategori', 'contoh_perangkat')->count();
@endphp

<div class="max-w-6xl mx-auto">
    <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between mb-6">
        <div>
            <div class="text-sm font-bold tracking-wide uppercase text-secondary">
                Referensi Pendampingan
            </div>
            <h1 class="font-display text-3xl font-semibold mt-1">
                Gudang PAI-BMTS
            </h1>
            <p class="text-neutral/60 mt-1">
                Unduh materi, instrumen riset, dan contoh perangkat yang dibagikan pengawas.
            </p>
        </div>

        <a href="{{ route('guru.triwulan.index') }}" class="btn btn-outline btn-primary gap-2">
            <span class="material-icons">upload_file</span>
            Buka Triwulan
        </a>
    </div>

    <div class="alert alert-info mb-6">
        <span class="material-icons">info</span>
        <div>
            <strong>Gunakan materi sesuai kebutuhan.</strong>
            <div class="text-sm">
                Klik tombol Download untuk menyimpan file ke perangkat Anda.
            </div>
        </div>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-7">
        <div class="stat bg-base-100 border border-base-300 rounded-2xl p-4">
            <div class="stat-figure text-primary">
                <span class="material-icons">folder</span>
            </div>
            <div class="stat-title">Total Materi</div>
            <div class="stat-value text-primary text-2xl">{{ $totalMateri }}</div>
        </div>

        <div class="stat bg-base-100 border border-base-300 rounded-2xl p-4">
            <div class="stat-figure text-info">
                <span class="material-icons">menu_book</span>
            </div>
            <div class="stat-title">Materi</div>
            <div class="stat-value text-info text-2xl">{{ $materiUmum }}</div>
        </div>

        <div class="stat bg-base-100 border border-base-300 rounded-2xl p-4">
            <div class="stat-figure text-warning">
                <span class="material-icons">assignment</span>
            </div>
            <div class="stat-title">Instrumen Riset</div>
            <div class="stat-value text-warning text-2xl">{{ $instrumenRiset }}</div>
        </div>

        <div class="stat bg-base-100 border border-base-300 rounded-2xl p-4">
            <div class="stat-figure text-success">
                <span class="material-icons">description</span>
            </div>
            <div class="stat-title">Contoh Perangkat</div>
            <div class="stat-value text-success text-2xl">{{ $contohPerangkat }}</div>
        </div>
    </div>

    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between mb-4">
        <div>
            <h2 class="font-display text-2xl font-semibold">Daftar Materi</h2>
            <p class="text-sm text-neutral/60">
                Pilih materi yang ingin Anda unduh.
            </p>
        </div>

        <label class="input input-bordered flex items-center gap-2 w-full md:w-80">
            <span class="material-icons text-neutral/50">search</span>
            <input
                id="materi-search"
                type="search"
                class="grow"
                placeholder="Cari judul materi..."
                aria-label="Cari materi"
            >
        </label>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" id="materi-grid">
        @forelse($materis as $materi)
            @php
                $kategoriConfig = match($materi->kategori) {
                    'materi' => [
                        'icon' => 'menu_book',
                        'badge' => 'badge-info',
                        'color' => 'text-info',
                        'label' => 'Materi',
                    ],
                    'instrumen_riset' => [
                        'icon' => 'assignment',
                        'badge' => 'badge-warning',
                        'color' => 'text-warning',
                        'label' => 'Instrumen Riset',
                    ],
                    default => [
                        'icon' => 'description',
                        'badge' => 'badge-success',
                        'color' => 'text-success',
                        'label' => 'Contoh Perangkat',
                    ],
                };
            @endphp

            <article
                class="materi-card card bg-base-100 border border-base-300 hover:shadow-lg hover:-translate-y-0.5 transition-all"
                data-search="{{ strtolower($materi->judul . ' ' . $materi->deskripsi . ' ' . $kategoriConfig['label']) }}"
            >
                <div class="card-body">
                    <div class="flex items-start justify-between gap-3">
                        <div class="w-12 h-12 rounded-xl bg-base-200 flex items-center justify-center">
                            <span class="material-icons {{ $kategoriConfig['color'] }}">
                                {{ $kategoriConfig['icon'] }}
                            </span>
                        </div>

                        <span class="badge {{ $kategoriConfig['badge'] }}">
                            {{ $kategoriConfig['label'] }}
                        </span>
                    </div>

                    <h3 class="card-title font-display text-xl mt-3">
                        {{ $materi->judul }}
                    </h3>

                    <p class="text-sm text-neutral/60 min-h-[48px]">
                        {{ $materi->deskripsi ? Str::limit($materi->deskripsi, 115) : 'Tidak ada deskripsi untuk materi ini.' }}
                    </p>

                    <div class="flex items-center justify-between gap-3 pt-3 border-t border-base-300 mt-2">
                        <span class="text-xs text-neutral/50">
                            Dibagikan {{ $materi->created_at->format('d M Y') }}
                        </span>

                        <a
                            href="{{ route('guru.gudang.download', $materi->id) }}"
                            class="btn btn-primary btn-sm gap-1"
                        >
                            <span class="material-icons text-base">download</span>
                            Download
                        </a>
                    </div>
                </div>
            </article>
        @empty
            <div class="col-span-full">
                <div class="card bg-base-100 border border-base-300">
                    <div class="card-body items-center text-center py-14">
                        <span class="material-icons text-6xl text-neutral/25">folder_off</span>
                        <h2 class="font-display text-2xl font-semibold mt-3">
                            Belum ada materi
                        </h2>
                        <p class="text-neutral/60 max-w-md">
                            Materi, instrumen riset, dan contoh perangkat dari pengawas akan tampil di halaman ini.
                        </p>
                    </div>
                </div>
            </div>
        @endforelse

        <div id="materi-search-empty" class="hidden col-span-full">
            <div class="card bg-base-100 border border-base-300">
                <div class="card-body items-center text-center py-10">
                    <span class="material-icons text-5xl text-neutral/30">search_off</span>
                    <p class="font-semibold mt-3">Materi tidak ditemukan.</p>
                    <p class="text-sm text-neutral/60">Coba gunakan kata kunci lain.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const materiSearch = document.getElementById('materi-search');
    const materiCards = Array.from(document.querySelectorAll('.materi-card'));
    const materiSearchEmpty = document.getElementById('materi-search-empty');

    if (materiSearch) {
        materiSearch.addEventListener('input', function () {
            const keyword = this.value.toLowerCase().trim();
            let visibleCount = 0;

            materiCards.forEach((card) => {
                const matches = card.dataset.search.includes(keyword);
                card.classList.toggle('hidden', !matches);

                if (matches) {
                    visibleCount++;
                }
            });

            materiSearchEmpty.classList.toggle(
                'hidden',
                visibleCount > 0 || keyword === ''
            );
        });
    }
</script>
@endpush