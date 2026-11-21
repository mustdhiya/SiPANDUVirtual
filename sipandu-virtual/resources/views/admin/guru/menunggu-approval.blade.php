@extends('layouts.guru')

@section('title', 'Menunggu Persetujuan')

@section('content')
<div class="mx-auto max-w-2xl space-y-6">
    <div class="card border border-base-300 bg-base-100 shadow-sm">
        <div class="card-body items-center text-center">
            <div class="rounded-full bg-warning/20 p-4">
                <span class="material-icons text-warning text-4xl">hourglass_top</span>
            </div>

            <h1 class="font-display text-2xl font-semibold text-base-content">
                Akun Menunggu Persetujuan
            </h1>

            <p class="text-base-content/70">
                Akun Anda sebagai <strong>Guru Binaan</strong> belum disetujui oleh Admin.
                Silakan hubungi Admin Utama atau Pengawas untuk melakukan persetujuan akun.
            </p>

            <div class="rounded-xl bg-base-200 p-4 text-sm">
                <p><strong>Nama:</strong> {{ auth()->user()->name }}</p>
                <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
                <p><strong>Status:</strong> Belum disetujui</p>
            </div>

            <form action="{{ route('logout') }}" method="POST" class="pt-2">
                @csrf
                <button type="submit" class="btn btn-outline btn-error rounded-xl">
                    <span class="material-icons text-base">logout</span>
                    Keluar
                </button>
            </form>
        </div>
    </div>
</div>
@endsection