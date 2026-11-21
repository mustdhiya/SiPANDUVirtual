@extends('layouts.admin')

@section('title', 'Akun & Kata Sandi')

@section('content')
@php
    $roleFilter = $roleFilter ?? request('role');
    $roleLabels = [
        'admin' => ['label' => 'Super Admin', 'badge' => 'badge-secondary'],
        'pengawas' => ['label' => 'Pengawas PAI', 'badge' => 'badge-primary'],
        'guru' => ['label' => 'Guru Binaan', 'badge' => 'badge-info'],
    ];
@endphp

<div class="mx-auto max-w-6xl space-y-6">

    {{-- Header --}}
    <section class="rounded-2xl border-2 border-base-300 bg-base-100 p-6 shadow-sm">
        <span class="badge badge-secondary mb-2">Khusus Super Admin</span>
        <h1 class="text-2xl font-extrabold text-base-content sm:text-3xl">
            Daftar Akun &amp; Kata Sandi Pengguna
        </h1>
        <p class="mt-2 text-base text-base-content/80">
            Halaman ini menampilkan email (username) dan kata sandi seluruh pengguna untuk membantu jika ada pengawas atau guru yang lupa akunnya.
        </p>
    </section>

    {{-- Filter Peran & Pencarian --}}
    <section class="rounded-2xl border-2 border-base-300 bg-base-100 p-5 shadow-sm space-y-4">
        {{-- Tombol Filter Peran --}}
        <div class="flex flex-wrap items-center gap-2">
            <span class="text-sm font-bold text-base-content mr-1">Tampilkan:</span>
            <a href="{{ route('admin.users.index', ['search' => $search]) }}"
               class="btn btn-sm {{ empty($roleFilter) ? 'btn-primary' : 'btn-outline border-2 border-base-300' }}">
                Semua Akun
            </a>
            <a href="{{ route('admin.users.index', ['role' => 'admin', 'search' => $search]) }}"
               class="btn btn-sm {{ $roleFilter === 'admin' ? 'btn-secondary' : 'btn-outline border-2 border-base-300' }}">
                Super Admin
            </a>
            <a href="{{ route('admin.users.index', ['role' => 'pengawas', 'search' => $search]) }}"
               class="btn btn-sm {{ $roleFilter === 'pengawas' ? 'btn-primary' : 'btn-outline border-2 border-base-300' }}">
                Pengawas
            </a>
            <a href="{{ route('admin.users.index', ['role' => 'guru', 'search' => $search]) }}"
               class="btn btn-sm {{ $roleFilter === 'guru' ? 'btn-info' : 'btn-outline border-2 border-base-300' }}">
                Guru Binaan
            </a>
        </div>

        {{-- Form Pencarian --}}
        <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-col gap-3 sm:flex-row">
            @if($roleFilter)
                <input type="hidden" name="role" value="{{ $roleFilter }}">
            @endif
            <input
                type="text"
                name="search"
                value="{{ $search }}"
                placeholder="Ketik nama, email, atau NIP yang ingin dicari..."
                class="input input-bordered w-full flex-1"
            />
            <div class="flex gap-2">
                <button type="submit" class="btn btn-primary flex-1 sm:flex-none">
                    <span class="material-icons text-xl">search</span>
                    Cari
                </button>
                @if($search || $roleFilter)
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline border-2 border-base-300">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </section>

    {{-- Tabel Desktop --}}
    <section class="hidden overflow-hidden rounded-2xl border-2 border-base-300 bg-base-100 shadow-sm lg:block">
        <div class="overflow-x-auto">
            <table class="table w-full">
                <thead>
                    <tr>
                        <th>Nama &amp; WhatsApp</th>
                        <th>Email (Username)</th>
                        <th>Peran</th>
                        <th>Status Akun</th>
                        <th>Kata Sandi</th>
                        <th class="text-right">Hak Angkat / Ubah Peran</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $u)
                        @php
                            $roleInfo = $roleLabels[$u->role] ?? ['label' => ucfirst($u->role), 'badge' => 'badge-ghost'];
                        @endphp
                        <tr class="hover:bg-base-200/60">
                            <td>
                                <div class="text-base font-bold text-base-content">{{ $u->name }}</div>
                                <div class="mt-0.5 text-sm text-base-content/75">
                                    WA: {{ $u->nomor_wa ?: '-' }}
                                    @if($u->nip)
                                        &middot; NIP: {{ $u->nip }}
                                    @endif
                                </div>
                            </td>

                            <td>
                                <div class="flex items-center gap-2">
                                    <span class="font-semibold text-base-content">{{ $u->email }}</span>
                                    <button
                                        type="button"
                                        onclick="copyText(this, @js($u->email))"
                                        class="btn btn-ghost btn-sm min-h-0 h-8 px-2"
                                        title="Salin email"
                                    >
                                        <span class="material-icons text-base">content_copy</span>
                                    </button>
                                </div>
                            </td>

                            <td>
                                <span class="badge {{ $roleInfo['badge'] }}">
                                    {{ $roleInfo['label'] }}
                                </span>
                            </td>

                            <td>
                                <div class="flex flex-col gap-1 items-start">
                                    @if($u->is_approved)
                                        <span class="badge badge-success">Aktif / Disetujui</span>
                                    @else
                                        <span class="badge badge-warning">Menunggu Izin</span>
                                    @endif

                                    @if(!$u->is_profile_complete)
                                        <span class="badge badge-error">Profil Belum Lengkap</span>
                                    @endif
                                </div>
                            </td>

                            <td>
                                @if(!empty($u->password_plain))
                                    <div class="flex items-center gap-2">
                                        <code class="rounded-lg border border-base-300 bg-base-200 px-3 py-1.5 text-base font-bold tracking-wide text-base-content">
                                            {{ $u->password_plain }}
                                        </code>
                                        <button
                                            type="button"
                                            onclick="copyText(this, @js($u->password_plain))"
                                            class="btn btn-outline btn-sm border-2 border-base-300"
                                            title="Salin kata sandi"
                                        >
                                            <span class="material-icons text-base">content_copy</span>
                                            Salin
                                        </button>
                                    </div>
                                @else
                                    <span class="text-sm font-medium text-base-content/75">Belum tersimpan</span>
                                @endif
                            </td>

                            <td class="text-right">
                                <div class="inline-flex flex-wrap items-center justify-end gap-2">
                                    <button
                                        type="button"
                                        onclick="openPasswordModal({{ $u->id }}, @js($u->name))"
                                        class="btn btn-outline btn-secondary btn-sm border-2"
                                        title="Ubah kata sandi user ini"
                                    >
                                        <span class="material-icons text-base">lock_reset</span>
                                        Ubah Sandi
                                    </button>

                                    @if($u->id === auth()->id() || $u->isAdmin())
                                        <span class="badge badge-secondary">Atasan Tertinggi</span>
                                    @elseif($u->role === 'pengawas')
                                        <form action="{{ route('admin.users.update-role', $u->id) }}" method="POST" onsubmit="return confirm('Ubah {{ $u->name }} menjadi Guru Binaan?')">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="role" value="guru">
                                            <button type="submit" class="btn btn-outline btn-info btn-sm border-2">
                                                Jadikan Guru
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.users.update-role', $u->id) }}" method="POST" onsubmit="return confirm('Angkat {{ $u->name }} menjadi Pengawas PAI?')">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="role" value="pengawas">
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                <span class="material-icons text-base">upgrade</span>
                                                Angkat Pengawas
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-base font-semibold text-base-content/75">
                                Data akun tidak ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    {{-- Tampilan Kartu untuk HP / Tablet (Tidak Perlu Geser Samping) --}}
    <section class="space-y-4 lg:hidden">
        @forelse($users as $u)
            @php
                $roleInfo = $roleLabels[$u->role] ?? ['label' => ucfirst($u->role), 'badge' => 'badge-ghost'];
            @endphp
            <article class="rounded-2xl border-2 border-base-300 bg-base-100 p-5 shadow-sm space-y-3">
                <div class="flex flex-wrap items-start justify-between gap-2">
                    <div>
                        <h2 class="text-lg font-extrabold text-base-content">{{ $u->name }}</h2>
                        <p class="text-sm text-base-content/80">WA: {{ $u->nomor_wa ?: '-' }}</p>
                    </div>
                    <span class="badge {{ $roleInfo['badge'] }}">{{ $roleInfo['label'] }}</span>
                </div>

                <div class="rounded-xl bg-base-200 p-3.5 space-y-2 text-sm">
                    <div class="flex items-center justify-between gap-2">
                        <div>
                            <span class="font-bold text-base-content/75">Email:</span>
                            <p class="font-bold text-base-content break-all">{{ $u->email }}</p>
                        </div>
                        <button type="button" onclick="copyText(this, @js($u->email))" class="btn btn-outline btn-sm border-2 border-base-300">
                            Salin
                        </button>
                    </div>

                    <div class="border-t border-base-300 pt-2 flex items-center justify-between gap-2">
                        <div>
                            <span class="font-bold text-base-content/75">Kata Sandi:</span>
                            <p class="font-mono text-base font-extrabold text-base-content">
                                {{ $u->password_plain ?: 'Belum tersimpan' }}
                            </p>
                        </div>
                        @if(!empty($u->password_plain))
                            <button type="button" onclick="copyText(this, @js($u->password_plain))" class="btn btn-primary btn-sm">
                                Salin Sandi
                            </button>
                        @endif
                    </div>
                </div>

                <div class="flex flex-wrap items-center justify-between gap-2 pt-1">
                    <div class="flex flex-wrap gap-2">
                        @if($u->is_approved)
                            <span class="badge badge-success">Aktif / Disetujui</span>
                        @else
                            <span class="badge badge-warning">Menunggu Izin</span>
                        @endif
                        @if(!$u->is_profile_complete)
                            <span class="badge badge-error">Profil Belum Lengkap</span>
                        @endif
                    </div>

                    <div class="flex flex-wrap items-center gap-2">
                        <button
                            type="button"
                            onclick="openPasswordModal({{ $u->id }}, @js($u->name))"
                            class="btn btn-outline btn-secondary btn-sm border-2"
                        >
                            <span class="material-icons text-base">lock_reset</span>
                            Ubah Sandi
                        </button>

                        @if($u->id !== auth()->id() && !$u->isAdmin())
                            <form action="{{ route('admin.users.update-role', $u->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="role" value="{{ $u->role === 'pengawas' ? 'guru' : 'pengawas' }}">
                                <button type="submit" class="btn {{ $u->role === 'pengawas' ? 'btn-outline btn-info border-2' : 'btn-primary' }} btn-sm">
                                    {{ $u->role === 'pengawas' ? 'Jadikan Guru' : 'Angkat Pengawas' }}
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </article>
        @empty
            <div class="rounded-2xl border-2 border-base-300 bg-base-100 p-10 text-center text-base font-semibold">
                Data akun tidak ditemukan.
            </div>
        @endforelse
    </section>

    <div class="flex justify-center pt-2">
        {{ $users->links() }}
    </div>
</div>

{{-- Modal Ubah Kata Sandi User (Khusus Super Admin) --}}
<dialog id="change-password-modal" class="modal">
    <div class="modal-box max-w-md rounded-2xl border-2 border-base-300 bg-base-100 p-6">
        <h3 class="text-xl font-extrabold text-base-content">Ubah Kata Sandi Pengguna</h3>
        <p class="mt-1 text-base text-base-content/80">
            Akun: <strong id="modal-user-name" class="text-primary"></strong>
        </p>

        <form id="change-password-form" method="POST" action="" class="mt-5 space-y-4">
            @csrf
            @method('PUT')

            <div class="form-control">
                <label for="modal-new-password" class="label pb-1.5">
                    <span class="label-text text-base font-bold">Kata Sandi Baru (Minimal 6 karakter)</span>
                </label>
                <input
                    id="modal-new-password"
                    type="text"
                    name="password"
                    minlength="6"
                    required
                    placeholder="Ketik kata sandi baru..."
                    class="input input-bordered w-full font-mono text-base font-bold"
                />
            </div>

            <div class="flex items-center justify-between rounded-xl border border-base-300 bg-base-200 px-3.5 py-2.5">
                <span class="text-sm font-medium text-base-content/80">Atau gunakan sandi standar:</span>
                <button
                    type="button"
                    onclick="document.getElementById('modal-new-password').value = '123456'"
                    class="btn btn-outline btn-secondary btn-sm border-2"
                >
                    Isi 123456
                </button>
            </div>

            <div class="modal-action mt-6 flex gap-2">
                <button
                    type="button"
                    onclick="document.getElementById('change-password-modal').close()"
                    class="btn btn-outline border-2 border-base-300 flex-1"
                >
                    Batal
                </button>
                <button type="submit" class="btn btn-primary flex-1">
                    <span class="material-icons text-xl">save</span>
                    Simpan Sandi
                </button>
            </div>
        </form>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>tutup</button>
    </form>
</dialog>

@push('scripts')
<script>
function openPasswordModal(userId, userName) {
    var modal = document.getElementById('change-password-modal');
    var form = document.getElementById('change-password-form');
    var nameEl = document.getElementById('modal-user-name');
    var input = document.getElementById('modal-new-password');

    form.action = "{{ url('/admin/users') }}/" + userId + "/password";
    nameEl.textContent = userName;
    input.value = '';
    modal.showModal();
    setTimeout(function () { input.focus(); }, 100);
}

function copyText(btn, text) {
    if (!navigator.clipboard) {
        alert('Salin manual: ' + text);
        return;
    }
    navigator.clipboard.writeText(text).then(function () {
        var oldHtml = btn.innerHTML;
        btn.innerHTML = '<span class="material-icons text-base">check</span> Tersalin';
        btn.classList.add('btn-success');
        setTimeout(function () {
            btn.innerHTML = oldHtml;
            btn.classList.remove('btn-success');
        }, 1800);
    });
}
</script>
@endpush
@endsection
