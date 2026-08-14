<!DOCTYPE html>
<html lang="id" data-theme="sipandu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - SiPANDU VIRTUAL</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-base-100 min-h-screen">

    {{-- Navbar --}}
    <div class="navbar bg-base-200 shadow-md">
        <div class="flex-1">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-ghost normal-case text-xl">
                <span class="material-icons align-middle mr-1">verified_user</span>
                SiPANDU VIRTUAL - Admin
            </a>
        </div>
        <div class="flex-none">
            <span class="mr-2">{{ auth()->user()->name }}</span>
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="btn btn-sm btn-error">
                    <span class="material-icons text-sm align-middle">logout</span>
                    Logout
                </button>
            </form>
        </div>
    </div>

    {{-- Sidebar + Content --}}
    <div class="flex">
        {{-- Sidebar --}}
        <aside class="w-64 bg-base-200 min-h-screen shadow-lg hidden md:block">
            <ul class="menu p-4">
                <li class="menu-title">Menu Guru</li>
                <li>
                    <a href="{{ route('guru.dashboard') }}">
                        <span class="material-icons align-middle">dashboard</span>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('guru.triwulan.index') }}">
                        <span class="material-icons align-middle">date_range</span>
                        Triwulan
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="material-icons align-middle">description</span>
                        Dokumen Saya
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="material-icons align-middle">forum</span>
                        Diskusi
                    </a>
                </li>
            </ul>
        </aside>

        {{-- Main Content --}}
        <main class="flex-1">
            @yield('content')
        </main>
    </div>

</body>
</html>