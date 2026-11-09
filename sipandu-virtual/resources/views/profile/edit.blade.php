@extends(auth()->user()->isPanelPengawas() ? 'layouts.admin' : 'layouts.guru')

@section('title', 'Lengkapi Profil Wajib')

@section('content')
<div class="mx-auto max-w-3xl space-y-6">
    <div class="border-b border-base-300 pb-4">
        <h1 class="font-display text-2xl font-semibold text-base-content">
            Data Profil Wajib
        </h1>
        <p class="mt-1 text-sm text-base-content/70">
            Lengkapi identitas wajib Anda di bawah ini sebelum mulai menggunakan fitur pendampingan SiPANDU VIRTUAL.
        </p>
    </div>

    @if(session('success'))
        <div class="alert alert-success rounded-xl">
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-error rounded-xl">
            <ul class="list-disc list-inside text-sm">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" class="card border border-base-300 bg-base-100 shadow-sm">
        @csrf
        @method('PUT')

        <div class="card-body space-y-4">
            <div class="grid gap-4 sm:grid-cols-2">
                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">Nama Lengkap &amp; Gelar *</span></label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="input input-bordered rounded-xl" required />
                </div>

                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">Email Aktif *</span></label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="input input-bordered rounded-xl" required />
                </div>

                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">Nomor WhatsApp Aktif *</span></label>
                    <input type="text" name="nomor_wa" value="{{ old('nomor_wa', $user->nomor_wa) }}" class="input input-bordered rounded-xl" placeholder="08xxxxxxxxxx" required />
                </div>

                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">NIP / Nomor SIAGA *</span></label>
                    <input type="text" name="nip" value="{{ old('nip', $user->nip ?? ($profilGuru->nip_siaga ?? '')) }}" class="input input-bordered rounded-xl" required />
                </div>
            </div>

            @if($user->isGuru())
                <div class="divider">Data Penugasan Guru PAI</div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div class="form-control">
                        <label class="label"><span class="label-text font-semibold">Sekolah Tempat Mengajar *</span></label>
                        <select name="sekolah_id" class="select select-bordered rounded-xl" required>
                            <option value="">-- Pilih Sekolah --</option>
                            @foreach($sekolahs as $s)
                                <option value="{{ $s->id }}" {{ old('sekolah_id', $profilGuru->sekolah_id ?? '') == $s->id ? 'selected' : '' }}>
                                    {{ $s->nama_sekolah }} ({{ $s->jenjang }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-control">
                        <label class="label"><span class="label-text font-semibold">Status Jabatan *</span></label>
                        <select name="status_jabatan" class="select select-bordered rounded-xl" required>
                            <option value="GURU" {{ old('status_jabatan', $profilGuru->status_jabatan ?? 'GURU') === 'GURU' ? 'selected' : '' }}>
                                Guru PAI
                            </option>
                            <option value="GURU_KEPSEK" {{ old('status_jabatan', $profilGuru->status_jabatan ?? '') === 'GURU_KEPSEK' ? 'selected' : '' }}>
                                Guru PAI merangkap Kepala Sekolah
                            </option>
                        </select>
                    </div>
                </div>

                <div class="rounded-xl bg-base-200 p-3 text-xs text-base-content/70">
                    <strong>Pengawas Pembimbing Anda:</strong>
                    {{ $profilGuru?->pengawas?->name ?? 'Menunggu plotting dari Admin Utama / Pengawas' }}
                </div>
            @endif

            <div class="divider">Ubah Kata Sandi (Opsional)</div>

            <div class="grid gap-4 sm:grid-cols-2">
                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">Kata Sandi Baru</span></label>
                    <input type="password" name="password" class="input input-bordered rounded-xl" placeholder="Kosongkan jika tidak diubah" />
                </div>

                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">Ulangi Kata Sandi Baru</span></label>
                    <input type="password" name="password_confirmation" class="input input-bordered rounded-xl" placeholder="Ulangi kata sandi baru" />
                </div>
            </div>

            <div class="card-actions justify-end pt-4">
                <button type="submit" class="btn btn-primary rounded-xl">
                    <span class="material-icons text-base">save</span>
                    Simpan Data Wajib
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
