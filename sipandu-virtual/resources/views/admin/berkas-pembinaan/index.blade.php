@extends('layouts.admin')

@section('title', 'Generator Berkas Pembinaan Profesi Guru PAI')

@section('content')
<div class="mx-auto max-w-7xl space-y-8">

    @if(session('success'))
        <div class="alert alert-success rounded-2xl shadow-sm">
            <span class="material-icons">check_circle</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- Filter Pengawas (Khusus Mama / Super Admin jika ingin melihat berkas pengawas lain) --}}
    @if(auth()->user()->isAdmin() && $daftarPengawas->count() > 1)
        <form method="GET" action="{{ route('admin.berkas-pembinaan.index') }}" class="flex flex-wrap items-center gap-3 rounded-2xl border border-base-300 bg-base-100 p-4 shadow-sm">
            <span class="text-sm font-semibold">Tampilkan Generator Milik Pengawas:</span>
            <select name="pengawas_id" class="select select-bordered select-sm rounded-xl" onchange="this.form.submit()">
                @foreach($daftarPengawas as $p)
                    <option value="{{ $p->id }}" {{ $pengawas->id === $p->id ? 'selected' : '' }}>
                        {{ $p->name }} {{ $p->isAdmin() ? '(Saya / Admin Utama)' : '' }}
                    </option>
                @endforeach
            </select>
            <input type="hidden" name="tahun" value="{{ $tahun }}">
        </form>
    @endif

    {{-- Hero Banner Generator Berkas (Persis Gambar 1) --}}
    <section class="rounded-3xl border border-base-300 bg-base-100 p-6 shadow-sm lg:p-8">
        <div class="grid gap-6 lg:grid-cols-12 lg:items-center">
            <div class="lg:col-span-7 space-y-4">
                <div class="text-xs font-bold uppercase tracking-widest text-secondary">
                    {{ strtoupper($pengawas->jabatan_pengawas ?? 'PENGAWAS SEKOLAH BIDANG PAI') }}
                </div>

                <h1 class="font-display text-3xl font-semibold leading-tight text-base-content md:text-4xl">
                    Generator berkas pembinaan profesi guru PAI
                </h1>

                <p class="text-sm leading-relaxed text-base-content/75">
                    Setiap bulan menghasilkan tiga berkas resmi berdasarkan identitas pengawas dan tema yang dipilih:
                    <strong>laporan kegiatan beserta dokumentasi, materi presentasi, dan bukti presensi KKG/MGMP</strong>.
                </p>

                <div class="grid grid-cols-3 gap-3 pt-2">
                    <div class="rounded-2xl bg-base-200 p-4 text-center">
                        <div class="text-xs text-base-content/60">Guru binaan</div>
                        <div class="font-display mt-1 text-2xl font-bold">{{ $totalGuru }}</div>
                    </div>
                    <div class="rounded-2xl bg-base-200 p-4 text-center">
                        <div class="text-xs text-base-content/60">Sertifikasi</div>
                        <div class="font-display mt-1 text-2xl font-bold">{{ $totalSertifikasi }}</div>
                    </div>
                    <div class="rounded-2xl bg-base-200 p-4 text-center">
                        <div class="text-xs text-base-content/60">Berkas / bulan</div>
                        <div class="font-display mt-1 text-2xl font-bold">3</div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-5">
                <div class="rounded-3xl p-6 text-white shadow-md" style="background: linear-gradient(145deg, #243c2c 0%, #1b2e21 100%);">
                    <div class="text-[11px] font-semibold uppercase tracking-widest opacity-75">
                        WILAYAH DAMPINGAN
                    </div>
                    <h2 class="font-display mt-2 text-2xl font-semibold">
                        Data Guru Binaan di Wilayah Dampingan
                    </h2>
                    <p class="mt-2 text-xs leading-relaxed opacity-85">
                        {{ $totalGuru }} Guru PAI aktif &middot; {{ $pengawas->wilayah_binaan ?? 'Kota Samarinda' }}
                    </p>
                    <div class="mt-6 flex flex-wrap gap-2">
                        <a href="{{ route('admin.guru.index') }}" class="btn btn-sm rounded-xl border-none bg-white/15 text-white hover:bg-white/25">
                            Buka daftar lengkap &rarr;
                        </a>
                        <a href="{{ route('admin.berkas-pembinaan.identitas') }}" class="btn btn-sm rounded-xl border-none bg-amber-600 text-white hover:bg-amber-700">
                            <span class="material-icons text-sm">badge</span>
                            Identitas Kop &amp; TTD
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Map Tahunan 12 Bulan --}}
    <section class="space-y-4">
        <div class="flex flex-col justify-between gap-2 sm:flex-row sm:items-end">
            <div>
                <h2 class="font-display text-2xl font-semibold text-base-content">
                    Map tahunan {{ $tahun }}
                </h2>
                <p class="text-sm text-base-content/70">
                    Pilih bulan, tentukan tema, lengkapi dokumentasi, dan cetak tiga berkas pemberkasan.
                </p>
            </div>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($berkasBulanan as $bulan => $item)
                <a
                    href="{{ route('admin.berkas-pembinaan.show', ['tahun' => $tahun, 'bulan' => $bulan, 'pengawas_id' => $pengawas->id]) }}"
                    class="group flex flex-col justify-between overflow-hidden rounded-2xl border border-base-300 bg-base-100 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md"
                >
                    <div>
                        <div class="flex items-center justify-between px-5 py-3 text-white" style="background-color: #243c2c;">
                            <span class="font-display text-lg font-semibold">{{ $item->nama_bulan }}</span>
                            <span class="text-xs opacity-80">{{ $item->romawi_bulan }} / {{ $tahun }}</span>
                        </div>

                        <div class="p-5">
                            <p class="line-clamp-3 text-sm leading-relaxed text-base-content/85">
                                {{ $item->tema }}
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 border-t border-base-200 px-5 py-3 text-xs">
                        <span class="badge badge-ghost gap-1 rounded-lg py-2.5">
                            <span class="material-icons" style="font-size:14px;">description</span> Laporan
                        </span>
                        <span class="badge badge-ghost gap-1 rounded-lg py-2.5">
                            <span class="material-icons" style="font-size:14px;">co_present</span> Materi
                        </span>
                        <span class="badge badge-ghost gap-1 rounded-lg py-2.5">
                            <span class="material-icons" style="font-size:14px;">fact_check</span> Presensi
                        </span>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    {{-- Kartu Footer Identitas Pengawas --}}
    <section class="flex flex-col items-start justify-between gap-4 rounded-2xl border border-base-300 bg-base-100 p-5 shadow-sm sm:flex-row sm:items-center">
        <div class="flex items-center gap-4">
            @if($pengawas->foto_profil)
                <img src="{{ asset('storage/' . $pengawas->foto_profil) }}" alt="{{ $pengawas->name }}" class="h-14 w-14 rounded-full object-cover ring-2 ring-secondary" />
            @else
                <div class="flex h-14 w-14 items-center justify-center rounded-full bg-primary text-lg font-bold text-primary-content">
                    {{ strtoupper(substr($pengawas->name, 0, 1)) }}
                </div>
            @endif
            <div>
                <h3 class="font-display text-lg font-semibold text-base-content">{{ $pengawas->name }}</h3>
                <p class="text-xs text-base-content/70">
                    {{ $pengawas->jabatan_pengawas ?? 'Pengawas Sekolah Bidang PAI' }} &middot;
                    {{ $pengawas->unit_kerja ?? 'Kantor Kementerian Agama Kota Samarinda' }}
                </p>
                @if($pengawas->alias_julukan)
                    <p class="text-xs text-base-content/60">{{ $pengawas->alias_julukan }}</p>
                @endif
            </div>
        </div>

        <a href="{{ route('admin.berkas-pembinaan.identitas') }}" class="btn btn-outline btn-sm rounded-xl">
            Sunting identitas
        </a>
    </section>

</div>
@endsection