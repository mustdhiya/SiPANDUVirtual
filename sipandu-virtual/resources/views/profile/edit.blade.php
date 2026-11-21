@extends(auth()->user()->isPanelPengawas() ? 'layouts.admin' : 'layouts.guru')

@section('title', 'Profil & Kata Sandi')

@section('content')
<div class="mx-auto max-w-3xl space-y-6">

    <section class="rounded-2xl border-2 border-base-300 bg-base-100 p-6 shadow-sm">
        <span class="badge badge-primary mb-2">Pengaturan Akun</span>
        <h1 class="text-2xl font-extrabold text-base-content sm:text-3xl">
            Profil Wajib &amp; Kata Sandi
        </h1>
        <p class="mt-2 text-base text-base-content/80">
            Pastikan data identitas Anda lengkap dan benar. Setelah selesai mengubah, tekan tombol <strong>Simpan Data</strong> di bagian bawah.
        </p>
    </section>

    <form action="{{ route('profile.update') }}" method="POST" class="rounded-2xl border-2 border-base-300 bg-base-100 p-6 shadow-sm space-y-6">
        @csrf
        @method('PUT')

        <div class="grid gap-5 sm:grid-cols-2">
            <div class="form-control">
                <label class="label pb-1.5"><span class="label-text text-base font-bold">Nama Lengkap &amp; Gelar *</span></label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="input input-bordered w-full" required />
            </div>

            <div class="form-control">
                <label class="label pb-1.5"><span class="label-text text-base font-bold">Email Aktif *</span></label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="input input-bordered w-full" required />
            </div>

            <div class="form-control">
                <label class="label pb-1.5"><span class="label-text text-base font-bold">Nomor WhatsApp Aktif *</span></label>
                <input type="text" name="nomor_wa" value="{{ old('nomor_wa', $user->nomor_wa) }}" class="input input-bordered w-full" placeholder="08xxxxxxxxxx" required />
            </div>

            <div class="form-control">
                <label class="label pb-1.5"><span class="label-text text-base font-bold">NIP / Nomor SIAGA *</span></label>
                <input type="text" name="nip" value="{{ old('nip', $user->nip ?? ($profilGuru->nip_siaga ?? '')) }}" class="input input-bordered w-full" required />
            </div>
        </div>

        @if($user->isGuru())
            <div class="divider text-base font-bold">Data Sekolah &amp; Penugasan Guru PAI</div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div class="form-control">
                    <label class="label pb-1.5"><span class="label-text text-base font-bold">Sekolah Tempat Mengajar *</span></label>
                    <select name="sekolah_id" class="select select-bordered w-full" required>
                        <option value="">-- Pilih Sekolah --</option>
                        @foreach($sekolahs as $s)
                            <option value="{{ $s->id }}" {{ old('sekolah_id', $profilGuru->sekolah_id ?? '') == $s->id ? 'selected' : '' }}>
                                {{ $s->nama_sekolah }} ({{ $s->jenjang }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-control">
                    <label class="label pb-1.5"><span class="label-text text-base font-bold">Status Jabatan *</span></label>
                    <select name="status_jabatan" class="select select-bordered w-full" required>
                        <option value="GURU" {{ old('status_jabatan', $profilGuru->status_jabatan ?? 'GURU') === 'GURU' ? 'selected' : '' }}>
                            Guru PAI
                        </option>
                        <option value="GURU_KEPSEK" {{ old('status_jabatan', $profilGuru->status_jabatan ?? '') === 'GURU_KEPSEK' ? 'selected' : '' }}>
                            Guru PAI merangkap Kepala Sekolah
                        </option>
                    </select>
                </div>
            </div>

            <div class="form-control">
                <label class="label pb-1.5"><span class="label-text text-base font-bold">Pilih Pengawas Pembimbing *</span></label>
                <select name="pengawas_id" class="select select-bordered w-full" required>
                    <option value="">-- Pilih Pengawas PAI Anda --</option>
                    @foreach($daftarPengawas as $pengawas)
                        <option value="{{ $pengawas->id }}" {{ old('pengawas_id', $profilGuru->pengawas_id ?? '') == $pengawas->id ? 'selected' : '' }}>
                            {{ $pengawas->name }} {{ $pengawas->isAdmin() ? '(Super Admin & Pengawas)' : '(Pengawas PAI)' }}
                        </option>
                    @endforeach
                </select>
                <p class="mt-1.5 text-xs font-medium text-base-content/75">
                    Pilih nama Pengawas PAI yang membina sekolah Anda agar laporan triwulan langsung masuk ke Pengawas tersebut.
                </p>
            </div>
        @endif

        <div class="divider text-base font-bold">Ubah Kata Sandi (Opsional)</div>

        <div class="grid gap-5 sm:grid-cols-2">
            <div class="form-control">
                <label class="label pb-1.5"><span class="label-text text-base font-bold">Kata Sandi Baru</span></label>
                <input type="password" name="password" class="input input-bordered w-full" placeholder="Kosongkan jika tidak ingin diganti" />
            </div>

            <div class="form-control">
                <label class="label pb-1.5"><span class="label-text text-base font-bold">Ulangi Kata Sandi Baru</span></label>
                <input type="password" name="password_confirmation" class="input input-bordered w-full" placeholder="Ketik ulang kata sandi baru" />
            </div>
        </div>

        <div class="flex justify-end border-t-2 border-base-200 pt-5">
            <button type="submit" class="btn btn-primary btn-lg w-full sm:w-auto">
                <span class="material-icons text-2xl">save</span>
                Simpan Data Profil
            </button>
        </div>
    </form>
</div>
@endsection
