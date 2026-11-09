@extends('layouts.admin')

@section('title', 'Identitas Pengawas - Generator Berkas')

@section('content')
<div class="mx-auto max-w-5xl space-y-6">

    <div class="flex items-center justify-between border-b border-base-300 pb-4">
        <div>
            <h1 class="font-display text-3xl font-semibold text-base-content">Identitas pengawas</h1>
            <p class="mt-1 text-sm text-base-content/70">
                Data ini menempel otomatis di kop surat, tanda tangan laporan, footer materi, dan daftar hadir presensi.
            </p>
        </div>
        <a href="{{ route('admin.berkas-pembinaan.index') }}" class="btn btn-ghost btn-sm rounded-xl">
            &larr; Kembali ke Berkas Bulanan
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-error rounded-2xl text-sm">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.berkas-pembinaan.identitas.update') }}" method="POST" enctype="multipart/form-data" class="grid gap-6 lg:grid-cols-12">
        @csrf
        @method('PUT')

        {{-- Kolom Kiri: Form Identitas --}}
        <div class="lg:col-span-8 card border border-base-300 bg-base-100 shadow-sm">
            <div class="card-body space-y-4">
                <div class="grid gap-4 sm:grid-cols-2">
                    <div class="form-control">
                        <label class="label"><span class="label-text text-xs font-semibold">Nama lengkap beserta gelar</span></label>
                        <input type="text" name="name" value="{{ old('name', $pengawas->name) }}" class="input input-bordered rounded-xl" required />
                    </div>

                    <div class="form-control">
                        <label class="label"><span class="label-text text-xs font-semibold">Nama tanpa gelar (untuk file &amp; footer)</span></label>
                        <input type="text" name="nama_tanpa_gelar" value="{{ old('nama_tanpa_gelar', $pengawas->nama_tanpa_gelar ?? $pengawas->name) }}" class="input input-bordered rounded-xl" />
                    </div>

                    <div class="form-control">
                        <label class="label"><span class="label-text text-xs font-semibold">NIP (opsional)</span></label>
                        <input type="text" name="nip" value="{{ old('nip', $pengawas->nip) }}" class="input input-bordered rounded-xl" placeholder="19xxxxxxxxxxxxxxxx" />
                    </div>

                    <div class="form-control">
                        <label class="label"><span class="label-text text-xs font-semibold">Pangkat / golongan</span></label>
                        <input type="text" name="pangkat_golongan" value="{{ old('pangkat_golongan', $pengawas->pangkat_golongan ?? 'Pembina / IV.a') }}" class="input input-bordered rounded-xl" required />
                    </div>

                    <div class="form-control">
                        <label class="label"><span class="label-text text-xs font-semibold">Jabatan</span></label>
                        <input type="text" name="jabatan_pengawas" value="{{ old('jabatan_pengawas', $pengawas->jabatan_pengawas ?? 'Pengawas Sekolah Bidang PAI') }}" class="input input-bordered rounded-xl" required />
                    </div>

                    <div class="form-control">
                        <label class="label"><span class="label-text text-xs font-semibold">Unit kerja (kop surat)</span></label>
                        <input type="text" name="unit_kerja" value="{{ old('unit_kerja', $pengawas->unit_kerja ?? 'Kantor Kementerian Agama Kota Samarinda') }}" class="input input-bordered rounded-xl" required />
                    </div>

                    <div class="form-control">
                        <label class="label"><span class="label-text text-xs font-semibold">Kabupaten / kota</span></label>
                        <input type="text" name="kabupaten_kota" value="{{ old('kabupaten_kota', $pengawas->kabupaten_kota ?? 'Kota Samarinda') }}" class="input input-bordered rounded-xl" required />
                    </div>

                    <div class="form-control">
                        <label class="label"><span class="label-text text-xs font-semibold">Provinsi</span></label>
                        <input type="text" name="provinsi" value="{{ old('provinsi', $pengawas->provinsi ?? 'Kalimantan Timur') }}" class="input input-bordered rounded-xl" required />
                    </div>

                    <div class="form-control">
                        <label class="label"><span class="label-text text-xs font-semibold">Wilayah binaan</span></label>
                        <input type="text" name="wilayah_binaan" value="{{ old('wilayah_binaan', $pengawas->wilayah_binaan ?? 'Kota Samarinda') }}" class="input input-bordered rounded-xl" required />
                    </div>

                    <div class="form-control">
                        <label class="label"><span class="label-text text-xs font-semibold">WhatsApp</span></label>
                        <input type="text" name="nomor_wa" value="{{ old('nomor_wa', $pengawas->nomor_wa) }}" class="input input-bordered rounded-xl" />
                    </div>

                    <div class="form-control">
                        <label class="label"><span class="label-text text-xs font-semibold">Email</span></label>
                        <input type="email" name="email" value="{{ old('email', $pengawas->email) }}" class="input input-bordered rounded-xl" required />
                    </div>

                    <div class="form-control">
                        <label class="label"><span class="label-text text-xs font-semibold">Alias / julukan (opsional)</span></label>
                        <input type="text" name="alias_julukan" value="{{ old('alias_julukan', $pengawas->alias_julukan) }}" class="input input-bordered rounded-xl" />
                    </div>
                </div>

                <div class="form-control">
                    <label class="label"><span class="label-text text-xs font-semibold">Riwayat singkat (narasumber)</span></label>
                    <textarea name="riwayat_singkat" rows="3" class="textarea textarea-bordered rounded-xl">{{ old('riwayat_singkat', $pengawas->riwayat_singkat ?? 'Pengawas Sekolah Bidang Pendidikan Agama Islam pada Kantor Kementerian Agama Kota Samarinda.') }}</textarea>
                </div>

                <div class="pt-2">
                    <button type="submit" class="btn btn-primary rounded-xl">
                        <span class="material-icons text-base">save</span>
                        Simpan identitas
                    </button>
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Pas Foto & Tanda Tangan --}}
        <div class="lg:col-span-4 space-y-6">
            <div class="card border border-base-300 bg-base-100 p-5 shadow-sm space-y-3">
                <div class="text-xs font-semibold text-base-content/70">Pas foto / foto narasumber</div>
                @if($pengawas->foto_profil)
                    <img src="{{ asset('storage/' . $pengawas->foto_profil) }}" alt="Pas Foto" class="mx-auto h-56 w-44 rounded-2xl object-cover shadow" />
                @else
                    <div class="flex h-56 w-full items-center justify-center rounded-2xl bg-base-200 text-xs text-base-content/50">
                        Belum ada pas foto
                    </div>
                @endif
                <input type="file" name="foto_profil" accept="image/*" class="file-input file-input-bordered file-input-sm w-full rounded-xl" />
            </div>

            <div class="card border border-base-300 bg-base-100 p-5 shadow-sm space-y-3">
                <div class="text-xs font-semibold text-base-content/70">Gambar tanda tangan (opsional)</div>
                <p class="text-[11px] text-base-content/60">Jika kosong, pas foto akan ditampilkan pada blok tanda tangan.</p>
                @if($pengawas->ttd_image)
                    <img src="{{ asset('storage/' . $pengawas->ttd_image) }}" alt="TTD" class="mx-auto h-28 object-contain" />
                @endif
                <input type="file" name="ttd_image" accept="image/*" class="file-input file-input-bordered file-input-sm w-full rounded-xl" />
            </div>
        </div>
    </form>

</div>
@endsection