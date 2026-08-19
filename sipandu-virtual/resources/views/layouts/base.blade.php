<!DOCTYPE html>
<html lang="id" data-theme="sipandu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'SiPANDU VIRTUAL') — SiPANDU VIRTUAL</title>

    <link
        rel="icon"
        type="image/png"
        href="{{ asset('images/logo.png') }}"
    >

    <link
        rel="apple-touch-icon"
        href="{{ asset('images/logo.png') }}"
    >

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link
        href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700&family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    <link
        href="https://fonts.googleapis.com/icon?family=Material+Icons"
        rel="stylesheet"
    >

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .font-display {
            font-family: 'Fraunces', serif;
        }

        .material-icons {
            line-height: 1;
            vertical-align: middle;
        }

        .page-shell {
            width: 100%;
            max-width: 1600px;
            margin-left: auto;
            margin-right: auto;
        }

        /*
        |--------------------------------------------------------------------------
        | SiPANDU Logo
        |--------------------------------------------------------------------------
        */

        .sipandu-logo-image {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .sipandu-logo-header {
            width: 42px;
            height: 42px;
            padding: 3px;
            border-radius: 0.85rem;
            background: hsl(var(--b1));
            border: 1px solid hsl(var(--b3));
            box-shadow: 0 2px 8px hsl(var(--bc) / 0.10);
        }

        .sipandu-logo-sidebar {
            width: 50px;
            height: 50px;
            padding: 4px;
            border-radius: 1rem;
            background: hsl(var(--b1));
            border: 1px solid hsl(var(--b3));
            box-shadow: 0 5px 14px hsl(var(--bc) / 0.12);
        }

        .sipandu-logo-footer {
            width: 42px;
            height: 42px;
            padding: 3px;
            border-radius: 0.85rem;
            background: hsl(var(--b1));
            border: 1px solid hsl(var(--b3));
        }
    </style>

    @stack('styles')
</head>

<body class="min-h-screen bg-base-100 text-base-content">
    <div class="drawer lg:drawer-open">
        <input
            id="app-drawer"
            type="checkbox"
            class="drawer-toggle"
        >

        <div class="drawer-content flex min-h-screen flex-col bg-base-100">
            @yield('navbar')

            <main class="flex-1 bg-base-100 p-4 sm:p-5 lg:p-7">
                <div class="page-shell">
                    @if(session('success'))
                        <div class="alert alert-success mb-5 rounded-2xl shadow-sm">
                            <span class="material-icons">check_circle</span>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-error mb-5 rounded-2xl shadow-sm">
                            <span class="material-icons">error</span>
                            <span>{{ session('error') }}</span>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-error mb-5 rounded-2xl shadow-sm">
                            <span class="material-icons">warning</span>

                            <div>
                                <p class="font-bold">Periksa kembali data yang diisi.</p>

                                <ul class="mt-1 list-inside list-disc text-sm">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>

        <div class="drawer-side z-40">
            <label
                for="app-drawer"
                aria-label="Tutup menu"
                class="drawer-overlay"
            ></label>

            @yield('sidebar')
        </div>
    </div>

    @include('components.theme-switcher')

    @stack('scripts')
</body>
</html>