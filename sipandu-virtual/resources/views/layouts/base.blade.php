<!DOCTYPE html>
<html lang="id" data-theme="sipandu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — SiPANDU VIRTUAL</title>

    <meta name="theme-color" content="#3d4a2f">
    <meta name="description" content="SiPANDU VIRTUAL — Sistem Pendampingan Terpadu Virtual Pengawas PAI SMA/SMK Kota Samarinda.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700&family=Inter:wght@400;500;600;700&display=swap"
        rel="stylesheet"
    >

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --sipandu-ink: #1f2419;
            --sipandu-muted: #66705c;
            --sipandu-olive: #3d4a2f;
            --sipandu-olive-dark: #2d3822;
            --sipandu-gold: #a97f34;
            --sipandu-gold-soft: #f2e6cc;
            --sipandu-cream: #faf7f0;
            --sipandu-sage: #eef0e3;
            --sipandu-border: rgba(61, 74, 47, 0.14);
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
            color: var(--sipandu-ink);
            background:
                radial-gradient(circle at 100% 0%, rgba(242, 230, 204, 0.32), transparent 24rem),
                var(--sipandu-cream);
        }

        .font-display {
            font-family: 'Fraunces', serif;
        }

        .material-icons {
            font-size: 20px;
            line-height: 1;
            vertical-align: middle;
        }

        .skip-link {
            position: fixed;
            top: 0.75rem;
            left: 0.75rem;
            z-index: 100;
            transform: translateY(-160%);
            border-radius: 0.875rem;
            background: var(--sipandu-olive);
            color: #ffffff;
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
            font-weight: 700;
            box-shadow: 0 8px 20px rgba(45, 56, 34, 0.22);
            transition: transform 180ms ease;
        }

        .skip-link:focus {
            transform: translateY(0);
        }

        .page-shell {
            width: 100%;
            max-width: 1440px;
            margin: 0 auto;
        }

        .content-shell {
            width: 100%;
            max-width: 1240px;
            margin: 0 auto;
        }

        .toast-alert {
            animation: toast-enter 220ms ease-out both;
        }

        @keyframes toast-enter {
            from {
                opacity: 0;
                transform: translateY(-0.5rem);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
                scroll-behavior: auto !important;
            }
        }
    </style>

    @stack('styles')
</head>

<body class="min-h-screen">
    <a href="#main-content" class="skip-link">
        Langsung ke isi halaman
    </a>

    <div class="drawer lg:drawer-open">
        <input id="app-drawer" type="checkbox" class="drawer-toggle">

        <div class="drawer-content flex min-h-screen flex-col">
            @yield('navbar')

            <main
                id="main-content"
                class="flex-1 px-4 py-5 sm:px-6 sm:py-6 lg:px-8 lg:py-8"
            >
                <div class="content-shell">
                    @if(session('success'))
                        <div
                            role="alert"
                            class="toast-alert alert alert-success mb-5 rounded-2xl border border-success/20 shadow-sm"
                        >
                            <span class="material-icons">check_circle</span>
                            <span class="font-medium">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if(session('error'))
                        <div
                            role="alert"
                            class="toast-alert alert alert-error mb-5 rounded-2xl border border-error/20 shadow-sm"
                        >
                            <span class="material-icons">error</span>
                            <span class="font-medium">{{ session('error') }}</span>
                        </div>
                    @endif

                    @if($errors->any())
                        <div
                            role="alert"
                            class="toast-alert alert alert-error mb-5 rounded-2xl border border-error/20 shadow-sm"
                        >
                            <span class="material-icons">error_outline</span>
                            <div>
                                <p class="font-bold">Ada data yang perlu diperbaiki.</p>
                                <p class="mt-1 text-sm">{{ $errors->first() }}</p>
                            </div>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>

        <div class="drawer-side z-50">
            <label
                for="app-drawer"
                aria-label="Tutup menu"
                class="drawer-overlay"
            ></label>

            @yield('sidebar')
        </div>
    </div>

    @stack('scripts')
</body>
</html>