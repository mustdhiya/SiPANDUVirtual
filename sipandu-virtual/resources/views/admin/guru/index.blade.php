@extends('layouts.admin')

@section('title', 'Persetujuan & Manajemen Akun')

@section('content')
@php
    $totalPending = $pendingGurus->count();
    $isSuperAdmin = auth()->user()->isAdmin();
@endphp

<div class="mx-auto max-w-7xl space-y-8">

    {{-- Alert Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success rounded-2xl shadow-sm">
            <span class="material-icons">check_circle</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error rounded-2xl shadow-sm">
            <span class="material-icons">error</span>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    {{-- Header --}}
    <section class="flex flex-col gap-5 border-b border-base-300 pb-6 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-[0.14em] text-secondary">
                <span class="material-icons text-base">how_to_reg</span>
                Pendampingan &amp; Hak Akses
            </div>

            <h1 class="font-display mt-2 text-3xl font-semibold leading-tight text-base-content md:text-4xl">
                Persetujuan &amp; Pembagian Binaan
            </h1>

            <p class="mt-2 max-w-2xl text-sm leading-6 text-base-content/70">
                Setujui pendaftar baru sebagai Guru PAI atau Pengawas, lihat kredensial akun, dan checklist pembagian Guru Binaan.
            </p>
        </div>

        <div class="rounded-2xl border border-base-300 bg-base-200 px-4 py-3">
            <div class="flex items-center gap-2">
                <span class="material-icons text-secondary">person_add</span>
                <span class="text-sm font-semibold text-base-content">
                    {{ $totalPending }} Pendaftar Menunggu
                </span>
            </div>
            <p class="mt-1 text-xs text-base-content/60">
                Perlu diverifikasi sebelum bisa login.
            </p>
        </div>
    </section>

    {{-- BAGIAN 1: DAFTAR PENDAFTAR BARU (PENDING) --}}
    <section class="card border border-base-300 bg-base-100 shadow-sm">
        <div class="card-body p-0">
            <div class="flex flex-col gap-3 border-b border-base-300 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                <div>
                    <h2 class="font-display text-xl font-semibold text-base-content">
                        1. Daftar Pendaftaran Baru
                    </h2>
                    <p class="mt-1 text-sm text-base-content/70">
                        Pilih apakah pendaftar disetujui sebagai <strong>Guru PAI</strong> atau diangkat menjadi <strong>Pengawas</strong>.
                    </p>
                </div>

                @if($totalPending > 0)
                    <span class="badge badge-warning gap-2 self-start sm:self-auto">
                        <span class="material-icons text-sm">schedule</span>
                        {{ $totalPending }} menunggu
                    </span>
                @endif
            </div>

            @if($pendingGurus->isNotEmpty())
                <div class="overflow-x-auto">
                    <table class="table w-full">
                        <thead class="bg-base-200 text-base-content/70">
                            <tr>
                                <th class="pl-6">Nama Pendaftar</th>
                                <th>Kontak</th>
                                @if($isSuperAdmin)
                                    <th>Password Saat Daftar</th>
                                @endif
                                <th>Waktu Daftar</th>
                                <th class="pr-6 text-right">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingGurus as $guru)
                                <tr class="hover:bg-base-200">
                                    <td class="pl-6">
                                        <div class="flex items-center gap-3">
                                            <div class="avatar placeholder">
                                                <div class="w-10 rounded-full bg-primary text-primary-content">
                                                    <span class="text-sm font-bold">
                                                        {{ strtoupper(substr($guru->name, 0, 1)) }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div>
                                                <p class="font-semibold text-base-content">{{ $guru->name }}</p>
                                                <p class="mt-0.5 text-xs text-base-content/60">ID: #{{ $guru->id }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="space-y-1">
                                            <p class="text-sm text-base-content/80">{{ $guru->email }}</p>
                                            <p class="text-xs text-base-content/60">{{ $guru->nomor_wa ?: 'WA belum diisi' }}</p>
                                        </div>
                                    </td>
                                    @if($isSuperAdmin)
                                        <td>
                                            <code class="rounded bg-base-200 px-2 py-1 text-xs font-mono">
                                                {{ $guru->password_plain ?: '(Ter-enkripsi)' }}
                                            </code>
                                        </td>
                                    @endif
                                    <td>
                                        <p class="text-sm font-medium">{{ $guru->created_at->translatedFormat('d M Y') }}</p>
                                        <p class="text-xs text-base-content/60">{{ $guru->created_at->format('H:i') }}</p>
                                    </td>
                                    <td class="pr-6 text-right">
                                        <div class="flex justify-end gap-2">
                                            <button
                                                type="button"
                                                class="btn btn-sm btn-success rounded-xl"
                                                onclick="document.getElementById('approve-modal-{{ $guru->id }}').showModal()"
                                            >
                                                <span class="material-icons text-base">check</span>
                                                Setujui Sebagai...
                                            </button>

                                            <button
                                                type="button"
                                                class="btn btn-sm btn-outline btn-error rounded-xl"
                                                onclick="document.getElementById('reject-modal-{{ $guru->id }}').showModal()"
                                            >
                                                <span class="material-icons text-base">close</span>
                                                Tolak
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                {{-- Modal Approve dengan Pilihan Role & Pengawas --}}
                                <dialog id="approve-modal-{{ $guru->id }}" class="modal">
                                    <div class="modal-box max-w-md rounded-3xl p-0">
                                        <div class="border-b border-base-300 p-6">
                                            <h3 class="font-display text-xl font-semibold text-base-content">
                                                Setujui Pendaftaran: {{ $guru->name }}
                                            </h3>
                                            <p class="mt-1 text-sm text-base-content/70">
                                                Tentukan peran akun ini di dalam SiPANDU VIRTUAL.
                                            </p>
                                        </div>

                                        <form action="{{ route('admin.approve-guru.approve', $guru->id) }}" method="POST" class="p-6 space-y-4">
                                            @csrf

                                            @if($isSuperAdmin)
                                                <div class="form-control">
                                                    <label class="label">
                                                        <span class="label-text font-semibold">Setujui Sebagai Peran Apa?</span>
                                                    </label>
                                                    <select
                                                        name="role"
                                                        class="select select-bordered w-full rounded-xl"
                                                        onchange="document.getElementById('pilih-pengawas-{{ $guru->id }}').style.display = (this.value === 'guru' ? 'block' : 'none')"
                                                    >
                                                        <option value="guru" selected>Guru PAI (Guru Binaan)</option>
                                                        <option value="pengawas">Pengawas PAI (Rekan Pengawas)</option>
                                                    </select>
                                                </div>

                                                <div id="pilih-pengawas-{{ $guru->id }}" class="form-control">
                                                    <label class="label">
                                                        <span class="label-text font-semibold">Hubungkan ke Pengawas Siapa?</span>
                                                    </label>
                                                    <select name="pengawas_id" class="select select-bordered w-full rounded-xl">
                                                        @foreach($daftarPengawas as $p)
                                                            <option value="{{ $p->id }}" {{ $p->id === auth()->id() ? 'selected' : '' }}>
                                                                {{ $p->name }} {{ $p->isAdmin() ? '(Admin Utama / Saya)' : '(Pengawas)' }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            @else
                                                <input type="hidden" name="role" value="guru">
                                                <p class="text-sm text-base-content/75">
                                                    Guru ini akan langsung terhubung sebagai Guru Binaan Anda.
                                                </p>
                                            @endif

                                            <div class="mt-6 flex justify-end gap-2">
                                                <button
                                                    type="button"
                                                    class="btn btn-ghost rounded-xl"
                                                    onclick="document.getElementById('approve-modal-{{ $guru->id }}').close()"
                                                >
                                                    Batal
                                                </button>
                                                <button type="submit" class="btn btn-success rounded-xl">
                                                    <span class="material-icons text-base">check_circle</span>
                                                    Simpan &amp; Aktifkan
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </dialog>

                                {{-- Modal Reject --}}
                                <dialog id="reject-modal-{{ $guru->id }}" class="modal">
                                    <div class="modal-box max-w-md rounded-3xl p-6">
                                        <h3 class="font-display text-xl font-semibold text-base-content">
                                            Tolak Pendaftaran: {{ $guru->name }}
                                        </h3>
                                        <form action="{{ route('admin.approve-guru.reject', $guru->id) }}" method="POST" class="mt-4 space-y-4">
                                            @csrf
                                            <div class="form-control">
                                                <label class="label"><span class="label-text font-semibold">Alasan Penolakan</span></label>
                                                <textarea name="alasan" class="textarea textarea-bordered rounded-xl" required placeholder="Tulis alasan penolakan..."></textarea>
                                            </div>
                                            <div class="flex justify-end gap-2">
                                                <button type="button" class="btn btn-ghost rounded-xl" onclick="document.getElementById('reject-modal-{{ $guru->id }}').close()">Batal</button>
                                                <button type="submit" class="btn btn-error rounded-xl">Tolak</button>
                                            </div>
                                        </form>
                                    </div>
                                </dialog>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-8 text-center text-sm text-base-content/60">
                    Tidak ada pendaftar baru yang menunggu persetujuan saat ini.
                </div>
            @endif
        </div>
    </section>

    @if($isSuperAdmin)
        {{-- BAGIAN 2: CHECKLIST MANUAL GURU BINAAN KE PENGAWAS (KHUSUS MAMA / SUPER ADMIN) --}}
        <section class="card border border-base-300 bg-base-100 shadow-sm">
            <div class="card-body p-6">
                <h2 class="font-display text-xl font-semibold text-base-content">
                    2. Checklist Manual Guru Binaan ke Pengawas
                </h2>
                <p class="mt-1 text-sm text-base-content/70">
                    Centang guru-guru di bawah ini lalu pilih Pengawas pembimbingnya (bisa dihubungkan ke Anda sendiri atau ke rekan Pengawas lain).
                </p>

                <form action="{{ route('admin.approve-guru.checklist-assign') }}" method="POST" class="mt-4 space-y-4">
                    @csrf

                    <div class="flex flex-col gap-3 sm:flex-row sm:items-end">
                        <div class="form-control w-full sm:max-w-xs">
                            <label class="label">
                                <span class="label-text font-semibold">Pilih Pengawas Tujuan:</span>
                            </label>
                            <select name="pengawas_id" class="select select-bordered rounded-xl" required>
                                <option value="">-- Pilih Pengawas --</option>
                                @foreach($daftarPengawas as $pengawas)
                                    <option value="{{ $pengawas->id }}">
                                        {{ $pengawas->name }} ({{ $pengawas->isAdmin() ? 'Admin Utama & Pengawas' : 'Pengawas' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary rounded-xl">
                            <span class="material-icons text-base">fact_check</span>
                            Terapkan ke Guru yang Dicentang
                        </button>
                    </div>

                    <div class="overflow-x-auto rounded-2xl border border-base-300 mt-4">
                        <table class="table w-full">
                            <thead class="bg-base-200">
                                <tr>
                                    <th class="w-12 text-center">
                                        <input
                                            type="checkbox"
                                            class="checkbox checkbox-sm"
                                            onclick="document.querySelectorAll('.guru-checkbox').forEach(cb => cb.checked = this.checked)"
                                        />
                                    </th>
                                    <th>Nama Guru Binaan</th>
                                    <th>Sekolah</th>
                                    <th>NIP / SIAGA</th>
                                    <th>Pengawas Saat Ini</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($daftarGuruBinaan as $g)
                                    <tr class="hover:bg-base-200">
                                        <td class="text-center">
                                            <input type="checkbox" name="guru_ids[]" value="{{ $g->id }}" class="checkbox checkbox-sm guru-checkbox" />
                                        </td>
                                        <td class="font-medium">{{ $g->nama_lengkap }}</td>
                                        <td>{{ $g->sekolah->nama_sekolah ?? 'Belum pilih sekolah' }}</td>
                                        <td>{{ $g->nip_siaga ?? '-' }}</td>
                                        <td>
                                            @if($g->pengawas)
                                                <span class="badge badge-success badge-outline">{{ $g->pengawas->name }}</span>
                                            @else
                                                <span class="badge badge-ghost">Belum ada pengawas</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-6 text-base-content/60">Belum ada data Guru Binaan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </section>

        {{-- BAGIAN 3: DAFTAR SELURUH USER, ROLE, & PASSWORD (KHUSUS MAMA / SUPER ADMIN) --}}
        <section class="card border border-base-300 bg-base-100 shadow-sm">
            <div class="card-body p-6">
                <h2 class="font-display text-xl font-semibold text-base-content">
                    3. Daftar Seluruh Akun User &amp; Password (Khusus Admin Utama)
                </h2>
                <p class="mt-1 text-sm text-base-content/70">
                    Anda dapat melihat password user, mengubah role (Guru / Pengawas), atau mengganti password jika ada yang lupa.
                </p>

                <div class="overflow-x-auto rounded-2xl border border-base-300 mt-4">
                    <table class="table w-full">
                        <thead class="bg-base-200">
                            <tr>
                                <th>Nama &amp; Email</th>
                                <th>No. WA</th>
                                <th>Role Saat Ini</th>
                                <th>Password</th>
                                <th>Profil Wajib</th>
                                <th class="text-right">Ubah Role / Reset Password</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($allUsers as $u)
                                <tr>
                                    <td>
                                        <p class="font-semibold">{{ $u->name }}</p>
                                        <p class="text-xs text-base-content/60">{{ $u->email }}</p>
                                    </td>
                                    <td>{{ $u->nomor_wa ?: '-' }}</td>
                                    <td>
                                        @if($u->role === 'admin')
                                            <span class="badge badge-primary">Admin Utama &amp; Pengawas</span>
                                        @elseif($u->role === 'pengawas')
                                            <span class="badge badge-secondary">Pengawas PAI</span>
                                        @else
                                            <span class="badge badge-ghost">Guru Binaan</span>
                                        @endif
                                    </td>
                                    <td>
                                        <code class="rounded bg-base-200 px-2 py-1 text-xs font-mono">
                                            {{ $u->password_plain ?: '(Belum tercatat - isi password baru di kanan)' }}
                                        </code>
                                    </td>
                                    <td>
                                        @if($u->is_profile_complete)
                                            <span class="badge badge-success badge-sm">Lengkap</span>
                                        @else
                                            <span class="badge badge-warning badge-sm">Belum Lengkap</span>
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        <form action="{{ route('admin.approve-guru.update-user', $u->id) }}" method="POST" class="flex flex-wrap items-center justify-end gap-2">
                                            @csrf
                                            <select name="role" class="select select-bordered select-xs rounded-lg">
                                                <option value="guru" {{ $u->role === 'guru' ? 'selected' : '' }}>Guru</option>
                                                <option value="pengawas" {{ $u->role === 'pengawas' ? 'selected' : '' }}>Pengawas</option>
                                                <option value="admin" {{ $u->role === 'admin' ? 'selected' : '' }}>Admin Utama</option>
                                            </select>
                                            <input
                                                type="text"
                                                name="new_password"
                                                placeholder="Password baru (opsional)"
                                                class="input input-bordered input-xs w-36 rounded-lg"
                                            />
                                            <button type="submit" class="btn btn-xs btn-primary rounded-lg">Simpan</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    @endif

</div>
@endsection

