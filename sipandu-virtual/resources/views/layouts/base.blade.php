<!DOCTYPE html>
<html lang="id" data-theme="sipandu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'SiPANDU VIRTUAL') - SiPANDU VIRTUAL</title>

    {{-- PWA & Mobile App Support (Android & iOS) --}}
    <link rel="manifest" href="{{ asset('manifest.webmanifest') }}">
    <meta name="theme-color" content="#1E4D2B">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="SiPANDU">

    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >
    <link
        href="https://fonts.googleapis.com/icon?family=Material+Icons"
        rel="stylesheet"
    >

    {{-- Terapkan ukuran huruf & mode kontras sebelum halaman tampil agar tidak berkedip --}}
    <script>
        (function () {
            try {
                var savedSize = localStorage.getItem('sipandu_font_size');
                if (savedSize && ['16px', '17px', '19px', '21px'].indexOf(savedSize) !== -1) {
                    document.documentElement.style.setProperty('--sipandu-font-size', savedSize);
                }
                var savedTheme = localStorage.getItem('sipandu_theme');
                if (savedTheme === 'sipandu' || savedTheme === 'sipandu-hc') {
                    document.documentElement.setAttribute('data-theme', savedTheme);
                }
            } catch (e) {}
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .material-icons {
            line-height: 1;
            vertical-align: middle;
        }

        .page-shell {
            width: 100%;
            max-width: 1440px;
            margin-left: auto;
            margin-right: auto;
        }

        .sipandu-logo-image {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .sipandu-logo-header {
            width: 44px;
            height: 44px;
            padding: 4px;
            border-radius: 0.85rem;
            background: #ffffff;
            border: 2px solid hsl(var(--b3));
        }

        .sipandu-logo-sidebar {
            width: 52px;
            height: 52px;
            padding: 4px;
            border-radius: 1rem;
            background: #ffffff;
            border: 2px solid hsl(var(--b3));
        }

        /* Bottom Bar Mobile - Style 05 Pill Highlight */
        .mobile-bottom-nav {
            padding-bottom: max(0.45rem, env(safe-area-inset-bottom));
        }
    </style>

    @stack('styles')
</head>

<body class="min-h-screen bg-base-200 text-base-content">
    <div class="drawer lg:drawer-open">
        <input
            id="app-drawer"
            type="checkbox"
            class="drawer-toggle"
        >

        <div class="drawer-content flex min-h-screen flex-col bg-base-200">
            @yield('navbar')

            {{-- Banner Pasang Aplikasi PWA di HP (muncul otomatis jika belum terpasang) --}}
            <div id="pwa-install-banner" class="hidden border-b-2 border-primary/20 bg-primary/10 px-4 py-3">
                <div class="page-shell flex flex-wrap items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <span class="material-icons text-2xl text-primary">install_mobile</span>
                        <div>
                            <p class="text-sm font-extrabold text-primary">Pasang SiPANDU di HP Anda</p>
                            <p id="pwa-install-desc" class="text-xs font-medium text-base-content/85">
                                Buka lebih cepat langsung dari layar utama seperti aplikasi biasa.
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <button id="pwa-install-btn" type="button" class="btn btn-primary btn-sm">
                            Pasang Sekarang
                        </button>
                        <button id="pwa-dismiss-btn" type="button" class="btn btn-ghost btn-sm min-h-0 h-9 px-2" aria-label="Tutup">
                            <span class="material-icons text-lg">close</span>
                        </button>
                    </div>
                </div>
            </div>

            <main class="flex-1 bg-base-200 p-4 pb-28 sm:p-6 sm:pb-28 lg:p-8 lg:pb-8">
                <div class="page-shell">
                    @if(session('success'))
                        <div class="alert alert-success mb-6 shadow-sm" role="status">
                            <span class="material-icons text-2xl">check_circle</span>
                            <span class="font-semibold">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-error mb-6 shadow-sm" role="alert">
                            <span class="material-icons text-2xl">error</span>
                            <span class="font-semibold">{{ session('error') }}</span>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-error mb-6 shadow-sm" role="alert">
                            <span class="material-icons text-2xl">warning</span>

                            <div>
                                <p class="font-bold">Mohon periksa kembali isian berikut:</p>

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

            {{-- Navigasi Bawah khusus Mobile (Style 05 Pill Highlight) --}}
            @yield('bottom_nav')
        </div>

        <div class="drawer-side z-50">
            <label
                for="app-drawer"
                aria-label="Tutup menu samping"
                class="drawer-overlay"
            ></label>

            @yield('sidebar')
        </div>
    </div>

    {{-- Pengontrol Ukuran Huruf, Kontras & PWA Service Worker --}}
    <script>
        window.sipanduUI = {
            sizes: ['16px', '17px', '19px', '21px'],
            labels: { '16px': 'Normal', '17px': 'Nyaman', '19px': 'Besar', '21px': 'Sangat Besar' },
            getSize: function () {
                return localStorage.getItem('sipandu_font_size') || '17px';
            },
            setSize: function (size) {
                document.documentElement.style.setProperty('--sipandu-font-size', size);
                try { localStorage.setItem('sipandu_font_size', size); } catch (e) {}
                this.syncUI();
            },
            stepSize: function (delta) {
                var current = this.getSize();
                var idx = this.sizes.indexOf(current);
                if (idx === -1) idx = 1;
                var nextIdx = Math.max(0, Math.min(this.sizes.length - 1, idx + delta));
                this.setSize(this.sizes[nextIdx]);
            },
            toggleContrast: function () {
                var current = document.documentElement.getAttribute('data-theme') || 'sipandu';
                var next = current === 'sipandu-hc' ? 'sipandu' : 'sipandu-hc';
                document.documentElement.setAttribute('data-theme', next);
                try { localStorage.setItem('sipandu_theme', next); } catch (e) {}
                this.syncUI();
            },
            syncUI: function () {
                var size = this.getSize();
                var label = this.labels[size] || 'Nyaman';
                document.querySelectorAll('[data-font-label]').forEach(function (el) {
                    el.textContent = label;
                });
                var isHC = (document.documentElement.getAttribute('data-theme') === 'sipandu-hc');
                document.querySelectorAll('[data-contrast-btn]').forEach(function (btn) {
                    btn.classList.toggle('btn-neutral', isHC);
                    btn.classList.toggle('btn-ghost', !isHC);
                    btn.setAttribute('aria-pressed', isHC ? 'true' : 'false');
                });
            }
        };

        document.addEventListener('DOMContentLoaded', function () {
            window.sipanduUI.syncUI();

            // Registrasi Service Worker PWA
            if ('serviceWorker' in navigator) {
                navigator.serviceWorker.register('/sw.js').catch(function () {});
            }

            // PWA Install Prompt (Android Chrome/Edge + Panduan iOS Safari)
            var deferredPrompt = null;
            var banner = document.getElementById('pwa-install-banner');
            var installBtn = document.getElementById('pwa-install-btn');
            var dismissBtn = document.getElementById('pwa-dismiss-btn');
            var descEl = document.getElementById('pwa-install-desc');
            var isStandalone = window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true;
            var isDismissed = sessionStorage.getItem('sipandu_pwa_dismissed') === '1';

            if (!isStandalone && !isDismissed && banner) {
                // Android / Desktop Chrome
                window.addEventListener('beforeinstallprompt', function (e) {
                    e.preventDefault();
                    deferredPrompt = e;
                    banner.classList.remove('hidden');
                });

                // iOS Safari (tidak punya beforeinstallprompt)
                var isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
                if (isIOS) {
                    descEl.textContent = 'Di iPhone/iPad: tekan tombol Bagikan (Share), lalu pilih "Tambah ke Layar Utama".';
                    installBtn.classList.add('hidden');
                    banner.classList.remove('hidden');
                }

                if (installBtn) {
                    installBtn.addEventListener('click', function () {
                        if (!deferredPrompt) return;
                        deferredPrompt.prompt();
                        deferredPrompt.userChoice.then(function () {
                            deferredPrompt = null;
                            banner.classList.add('hidden');
                        });
                    });
                }

                if (dismissBtn) {
                    dismissBtn.addEventListener('click', function () {
                        banner.classList.add('hidden');
                        sessionStorage.setItem('sipandu_pwa_dismissed', '1');
                    });
                }
            }

            // Driver.js Tur Interaktif (bisa dipicu di SEMUA halaman + otomatis 1x untuk akun baru)
            @auth
                @php
                    $isDashboardRoute = request()->routeIs('admin.dashboard') || request()->routeIs('guru.dashboard');
                    $forceTour = request()->boolean('start_tour');
                    $shouldAutoTour = ($isDashboardRoute && !auth()->user()->has_seen_tour) || $forceTour;
                    $tourStorageKey = 'sipandu_tour_done_' . auth()->id();
                @endphp
                var tourConfig = {
                    role: @json(auth()->user()->role),
                    options: {
                        storageKey: @json($tourStorageKey),
                        completeUrl: @json(route('tour.complete')),
                        csrfToken: @json(csrf_token())
                    }
                };

                window.triggerPageTour = function () {
                    if (typeof window.startSipanduTour === 'function') {
                        window.startSipanduTour(tourConfig.role, tourConfig.options);
                    }
                };

                var shouldAutoTour = @json($shouldAutoTour);
                var forceTour = @json($forceTour);
                var alreadySeenLocal = localStorage.getItem(tourConfig.options.storageKey) === '1';

                if (shouldAutoTour && (forceTour || !alreadySeenLocal)) {
                    if (typeof window.startSipanduTour === 'function') {
                        setTimeout(function () {
                            window.startSipanduTour(tourConfig.role, tourConfig.options);
                        }, 350);
                    } else {
                        window.__SIPANDU_AUTO_TOUR__ = tourConfig;
                    }
                }
            @endauth
        });
    </script>

    @stack('scripts')
</body>
</html>
