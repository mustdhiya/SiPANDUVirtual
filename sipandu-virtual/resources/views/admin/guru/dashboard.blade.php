<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Guru - SiPANDU VIRTUAL</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="bg-base-100 min-h-screen">

    <div class="navbar bg-base-200 shadow-md">
        <div class="flex-1">
            <a class="btn btn-ghost normal-case text-xl">SiPANDU VIRTUAL - Guru</a>
        </div>
        <div class="flex-none">
            <span class="mr-2">{{ auth()->user()->name }}</span>
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="btn btn-sm btn-error">Logout</button>
            </form>
        </div>
    </div>

    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-4">Dashboard Guru</h1>

        <div class="alert alert-info shadow-lg">
            <span>Selamat datang, {{ auth()->user()->name }}! Ini adalah dashboard guru SiPANDU VIRTUAL.</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-6">
            <div class="card bg-base-200 shadow-md">
                <div class="card-body">
                    <h2 class="card-title">Profil Saya</h2>
                    <p>Lihat dan edit profil</p>
                    <div class="card-actions justify-end">
                        <button class="btn btn-primary btn-sm">Profil</button>
                    </div>
                </div>
            </div>

            <div class="card bg-base-200 shadow-md">
                <div class="card-body">
                    <h2 class="card-title">Triwulan</h2>
                    <p>Isi instrumen triwulan</p>
                    <div class="card-actions justify-end">
                        <button class="btn btn-primary btn-sm">Triwulan</button>
                    </div>
                </div>
            </div>

            <div class="card bg-base-200 shadow-md">
                <div class="card-body">
                    <h2 class="card-title">Dokumen</h2>
                    <p>Upload dokumen bukti fisik</p>
                    <div class="card-actions justify-end">
                        <button class="btn btn-primary btn-sm">Dokumen</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>