<!DOCTYPE html>
<html lang="id" data-fontscale="1">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta
        name="description"
        content="SiPANDU VIRTUAL — Sistem Pendampingan Terpadu Virtual untuk Pengawas dan Guru PAI SMA/SMK Kota Samarinda."
    >

    <title>SiPANDU VIRTUAL — Sistem Pendampingan Terpadu Virtual</title>

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

    <style>
        :root {
            --bg: #faf7f0;
            --bg-alt: #eef0e3;
            --dark: #3d4a2f;
            --dark-2: #2d3822;
            --gold: #a97f34;
            --gold-tint: #f2e6cc;
            --text: #1f2419;
            --text2: #4f5546;
            --border: rgba(61, 74, 47, .16);
            --card: #ffffff;
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
            font-size: 18px;
        }

        html[data-fontscale="2"] {
            font-size: 20px;
        }

        html[data-fontscale="3"] {
            font-size: 22px;
        }

        html[data-contrast="high"] {
            --text2: #1f2419;
            --border: #1f2419;
        }

        body {
            margin: 0;
            background: var(--bg);
            color: var(--text);
            font-family: Inter, sans-serif;
            line-height: 1.65;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        button {
            font: inherit;
        }

        .material-icons {
            font-size: 20px;
            line-height: 1;
            vertical-align: middle;
        }

        .container {
            width: min(1200px, calc(100% - 3rem));
            margin: 0 auto;
        }

        .font-display {
            font-family: Fraunces, serif;
        }

        .skip-link {
            position: fixed;
            top: -80px;
            left: 1rem;
            z-index: 200;
            border-radius: .75rem;
            background: var(--dark);
            color: #fff;
            padding: .7rem 1rem;
            font-weight: 700;
            transition: top .2s ease;
        }

        .skip-link:focus {
            top: 1rem;
        }

        a:focus-visible,
        button:focus-visible {
            outline: 3px solid var(--gold);
            outline-offset: 3px;
        }

        .reveal {
            opacity: 0;
            transform: translateY(22px);
            transition:
                opacity .55s cubic-bezier(.16, 1, .3, 1),
                transform .55s cubic-bezier(.16, 1, .3, 1);
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .navbar-main {
            position: sticky;
            top: 0;
            z-index: 100;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            border-bottom: 1px solid var(--border);
            background: rgba(250, 247, 240, .94);
            padding: 1rem max(1.5rem, calc((100% - 1200px) / 2));
            backdrop-filter: blur(12px);
        }

        .brand {
            display: flex;
            min-width: 0;
            align-items: center;
            gap: .7rem;
        }

        .logo-badge {
            display: grid;
            width: 42px;
            height: 42px;
            flex: 0 0 auto;
            place-items: center;
            border-radius: .8rem;
            background: var(--dark);
            color: #fff;
        }

        .logo-image {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .logo-badge-image {
            width: 46px;
            height: 46px;
            flex: 0 0 auto;
            border: 1px solid var(--border);
            border-radius: .8rem;
            background: #ffffff;
            padding: 3px;
            box-shadow: 0 4px 12px rgba(31, 36, 25, .12);
        }

        .logo-badge-image-footer {
            width: 46px;
            height: 46px;
            flex: 0 0 auto;
            border: 1px solid rgba(255, 255, 255, .25);
            border-radius: .8rem;
            background: #ffffff;
            padding: 3px;
        }

        .brand-top {
            display: block;
            color: var(--dark);
            font-family: Fraunces, serif;
            font-size: 1.1rem;
            font-weight: 700;
            line-height: 1;
        }

        .brand-bottom {
            display: block;
            margin-top: .25rem;
            color: var(--text2);
            font-size: .67rem;
            font-weight: 700;
            letter-spacing: .07em;
            line-height: 1.15;
            text-transform: uppercase;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 1.35rem;
        }

        .nav-link {
            border-bottom: 2px solid transparent;
            color: var(--text2);
            padding: .4rem 0;
            font-size: .88rem;
            font-weight: 700;
        }

        .nav-link:hover,
        .nav-link.active {
            border-bottom-color: var(--gold);
            color: var(--dark);
        }

        .btn {
            display: inline-flex;
            min-height: 48px;
            align-items: center;
            justify-content: center;
            gap: .5rem;
            border: 2px solid transparent;
            border-radius: 999px;
            padding: .75rem 1.25rem;
            cursor: pointer;
            font-size: .93rem;
            font-weight: 800;
            transition:
                transform .2s cubic-bezier(.16, 1, .3, 1),
                background .2s ease,
                color .2s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn-primary {
            background: var(--dark);
            color: #fff;
        }

        .btn-primary:hover {
            background: var(--dark-2);
        }

        .btn-outline {
            border-color: var(--dark);
            background: transparent;
            color: var(--dark);
        }

        .btn-outline:hover {
            background: rgba(61, 74, 47, .08);
        }

        .btn-light {
            background: #fff;
            color: var(--dark);
        }

        .btn-light:hover {
            background: var(--gold-tint);
        }

        .btn-sm {
            min-height: 40px;
            padding: .55rem .95rem;
            font-size: .85rem;
        }

        .hero {
            display: grid;
            min-height: 78vh;
            grid-template-columns: minmax(0, 1.15fr) minmax(300px, .85fr);
            align-items: center;
            gap: 3rem;
            padding: 4rem 0;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: .45rem;
            color: var(--gold);
            font-size: .78rem;
            font-weight: 800;
            letter-spacing: .1em;
            text-transform: uppercase;
        }

        .hero h1 {
            max-width: 720px;
            margin: .7rem 0 1rem;
            font-family: Fraunces, serif;
            font-size: clamp(2.4rem, 5.2vw, 4rem);
            font-weight: 600;
            letter-spacing: -.03em;
            line-height: 1.16;
        }

        .hero h1 em {
            color: var(--gold);
        }

        .hero-text {
            max-width: 610px;
            color: var(--text2);
            font-size: 1.06rem;
        }

        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: .75rem;
            margin-top: 1.6rem;
        }

        .trust-row {
            display: flex;
            flex-wrap: wrap;
            gap: .6rem;
            margin-top: 2rem;
        }

        .trust-pill {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            border: 1px solid var(--border);
            border-radius: 999px;
            background: var(--card);
            color: var(--text);
            padding: .5rem .8rem;
            font-size: .8rem;
            font-weight: 700;
        }

        .trust-pill .material-icons {
            color: var(--gold);
            font-size: 17px;
        }

        .hero-visual {
            position: relative;
            max-width: 420px;
            margin: 0 auto;
        }

        .hero-image {
            overflow: hidden;
            border: 10px solid rgba(255, 255, 255, .55);
            border-radius: 200px 200px 1.5rem 1.5rem;
            background: var(--dark);
            box-shadow: 0 18px 45px rgba(31, 36, 25, .16);
        }

        .hero-image img {
            display: block;
            width: 100%;
            aspect-ratio: 3 / 4;
            object-fit: cover;
        }

        .trust-seal {
            position: absolute;
            top: 1rem;
            right: -1.25rem;
            display: grid;
            width: 108px;
            height: 108px;
            place-items: center;
            border: 1px solid var(--border);
            border-radius: 50%;
            background: #fff;
            box-shadow: 0 10px 25px rgba(31, 36, 25, .12);
            color: var(--gold);
        }

        .trust-seal::before {
            position: absolute;
            inset: 10px;
            display: grid;
            place-items: center;
            color: var(--text2);
            content: 'TERPERCAYA • AMANAH • PROFESIONAL •';
            font-size: .49rem;
            font-weight: 800;
            letter-spacing: .08em;
            line-height: 2.5;
            text-align: center;
        }

        .trust-seal .material-icons {
            z-index: 1;
        }

        .section {
            padding: 5rem 0;
        }

        .section-alt {
            background: var(--bg-alt);
        }

        .section-heading {
            max-width: 720px;
        }

        .section-heading h2 {
            margin: .45rem 0 0;
            font-family: Fraunces, serif;
            font-size: clamp(1.9rem, 3.5vw, 2.7rem);
            font-weight: 600;
            line-height: 1.25;
        }

        .section-heading p {
            color: var(--text2);
        }

        .about-grid {
            display: grid;
            grid-template-columns: .9fr 1.2fr .9fr;
            align-items: center;
            gap: 2.5rem;
        }

        .about-image {
            width: 100%;
            min-height: 320px;
            border-radius: 1.35rem;
            object-fit: cover;
        }

        .about-copy p {
            color: var(--text2);
        }

        .stat-list {
            display: grid;
            gap: .85rem;
        }

        .stat-row {
            display: flex;
            align-items: center;
            gap: .75rem;
            border-radius: 1rem;
            background: rgba(255, 255, 255, .72);
            padding: .8rem;
        }

        .stat-icon {
            display: grid;
            width: 38px;
            height: 38px;
            flex: 0 0 auto;
            place-items: center;
            border-radius: 50%;
            background: var(--gold-tint);
            color: var(--dark);
        }

        .stat-row strong {
            display: block;
            font-size: .92rem;
        }

        .stat-row span:last-child {
            color: var(--text2);
            font-size: .82rem;
        }

        .feature-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
            margin-top: 2rem;
        }

        .feature-card {
            min-height: 230px;
            border: 1px solid var(--border);
            border-radius: 1.25rem;
            background: var(--card);
            padding: 1.4rem;
            transition:
                transform .2s cubic-bezier(.16, 1, .3, 1),
                box-shadow .2s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 18px 35px rgba(31, 36, 25, .09);
        }

        .feature-icon {
            display: grid;
            width: 50px;
            height: 50px;
            place-items: center;
            margin-bottom: 1rem;
            border-radius: .9rem;
            background: var(--gold-tint);
            color: var(--dark);
        }

        .feature-card h3 {
            margin: 0;
            font-family: Fraunces, serif;
            font-size: 1.15rem;
        }

        .feature-card p {
            margin: .55rem 0 0;
            color: var(--text2);
            font-size: .9rem;
        }

        .role-band {
            background: var(--dark);
            color: #fff;
            padding: 1.35rem 0;
        }

        .role-band-inner {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }

        .role-label {
            color: rgba(255, 255, 255, .65);
            font-size: .76rem;
            font-weight: 800;
            letter-spacing: .1em;
            text-transform: uppercase;
        }

        .role-list {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .role-item {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            font-size: .86rem;
            font-weight: 700;
        }

        .role-item .material-icons {
            border-radius: .45rem;
            background: rgba(255, 255, 255, .15);
            padding: .35rem;
            font-size: 16px;
        }

        .steps {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
            margin-top: 2rem;
        }

        .step-card {
            border: 1px solid var(--border);
            border-radius: 1.25rem;
            background: #fff;
            padding: 1.5rem;
            text-align: center;
        }

        .step-number {
            display: grid;
            width: 46px;
            height: 46px;
            place-items: center;
            margin: 0 auto .8rem;
            border-radius: .85rem;
            background: var(--dark);
            color: #fff;
            font-family: Fraunces, serif;
            font-weight: 700;
        }

        .step-card h3 {
            margin: 0;
            font-family: Fraunces, serif;
            font-size: 1.1rem;
        }

        .step-card p {
            margin: .5rem 0 0;
            color: var(--text2);
            font-size: .88rem;
        }

        .faq-wrap {
            max-width: 780px;
            margin: 2rem auto 0;
        }

        .faq-item {
            overflow: hidden;
            margin-bottom: .75rem;
            border: 1px solid var(--border);
            border-radius: 1rem;
            background: #fff;
        }

        .faq-button {
            display: flex;
            width: 100%;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            border: 0;
            background: transparent;
            color: var(--text);
            padding: 1.05rem 1.15rem;
            cursor: pointer;
            font-weight: 800;
            text-align: left;
        }

        .faq-content {
            display: none;
            color: var(--text2);
            padding: 0 1.15rem 1.1rem;
        }

        .faq-item.open .faq-content {
            display: block;
        }

        .faq-item.open .faq-button .material-icons {
            transform: rotate(180deg);
        }

        .faq-button .material-icons {
            transition: transform .2s ease;
        }

        .cta {
            background: var(--dark);
            color: #fff;
        }

        .cta-inner {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 2rem;
        }

        .cta h2 {
            max-width: 700px;
            margin: .4rem 0 0;
            color: #fff;
            font-family: Fraunces, serif;
            font-size: clamp(1.9rem, 3.5vw, 2.7rem);
            font-weight: 600;
            line-height: 1.25;
        }

        .cta p {
            max-width: 640px;
            color: rgba(255, 255, 255, .78);
        }

        footer {
            background: var(--dark-2);
            color: rgba(255, 255, 255, .72);
            padding: 3.5rem 0 1.3rem;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 1.4fr repeat(3, 1fr);
            gap: 2rem;
        }

        .footer-title {
            margin-bottom: .65rem;
            color: #fff;
            font-size: .92rem;
            font-weight: 800;
        }

        .footer-link {
            display: block;
            margin: .45rem 0;
            font-size: .88rem;
        }

        .footer-link:hover {
            color: #fff;
        }

        .footer-bottom {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            margin-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, .16);
            padding-top: 1.3rem;
            font-size: .8rem;
        }

        .a11y-toggle {
            position: fixed;
            right: 1rem;
            bottom: 1rem;
            z-index: 120;
            display: inline-grid;
            min-width: 48px;
            min-height: 48px;
            place-items: center;
            border: 2px solid var(--dark);
            border-radius: 999px;
            background: #fff;
            box-shadow: 0 8px 20px rgba(31, 36, 25, .18);
            color: var(--dark);
            cursor: pointer;
        }

        .a11y-panel {
            position: fixed;
            right: 1rem;
            bottom: 4.6rem;
            z-index: 120;
            display: none;
            width: min(290px, calc(100vw - 2rem));
            border: 1px solid var(--border);
            border-radius: 1rem;
            background: #fff;
            box-shadow: 0 15px 35px rgba(31, 36, 25, .18);
            padding: .8rem;
        }

        .a11y-panel.show {
            display: grid;
            gap: .5rem;
        }

        .a11y-panel button {
            display: flex;
            min-height: 44px;
            align-items: center;
            gap: .5rem;
            border: 1px solid var(--border);
            border-radius: .75rem;
            background: var(--bg);
            color: var(--dark);
            padding: .65rem .8rem;
            cursor: pointer;
            font-weight: 700;
            text-align: left;
        }

        @media (max-width: 980px) {
            .nav-links {
                display: none;
            }

            .hero {
                min-height: auto;
                grid-template-columns: 1fr;
                padding: 3rem 0;
            }

            .hero-visual {
                max-width: 360px;
            }

            .about-grid {
                grid-template-columns: 1fr 1.2fr;
            }

            .stat-list {
                grid-column: 1 / -1;
                grid-template-columns: repeat(2, 1fr);
            }

            .feature-grid,
            .steps {
                grid-template-columns: repeat(2, 1fr);
            }

            .footer-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 640px) {
            .container {
                width: min(100% - 2rem, 1200px);
            }

            .navbar-main {
                padding: .85rem 1rem;
            }

            .brand-bottom {
                display: none;
            }

            .btn {
                padding: .7rem 1rem;
            }

            .hero {
                gap: 2rem;
                padding: 2.4rem 0;
            }

            .hero h1 {
                font-size: clamp(2.15rem, 12vw, 3rem);
            }

            .hero-image {
                border-width: 7px;
            }

            .trust-seal {
                right: -.7rem;
                width: 88px;
                height: 88px;
            }

            .section {
                padding: 3.25rem 0;
            }

            .about-grid,
            .feature-grid,
            .steps,
            .stat-list,
            .footer-grid {
                grid-template-columns: 1fr;
            }

            .about-image {
                min-height: 240px;
            }

            .feature-card {
                min-height: auto;
            }
        }
    </style>
</head>

<body>
@php
    $dashboardRoute = null;

    if (auth()->check()) {
        $dashboardRoute = auth()->user()->isAdmin()
            ? route('admin.dashboard')
            : route('guru.dashboard');
    }
@endphp

<a class="skip-link" href="#konten-utama">
    Langsung ke konten utama
</a>

<nav class="navbar-main" aria-label="Navigasi utama">
    <a
        class="brand"
        href="#beranda"
        aria-label="SiPANDU VIRTUAL, kembali ke beranda"
    >
        <span class="logo-badge-image">
            <img
                src="{{ asset('images/logo.png') }}"
                alt="Logo SiPANDU VIRTUAL"
                class="logo-image"
            >
        </span>

        <span>
            <span class="brand-top">SiPANDU</span>
            <span class="brand-bottom">
                Virtual · Pengawas PAI Samarinda
            </span>
        </span>
    </a>

    <div class="nav-links" aria-label="Menu halaman">
        <a class="nav-link active" href="#beranda">Beranda</a>
        <a class="nav-link" href="#tentang">Tentang</a>
        <a class="nav-link" href="#manfaat">Manfaat</a>
        <a class="nav-link" href="#cara-kerja">Cara Kerja</a>
        <a class="nav-link" href="#pertanyaan">Pertanyaan</a>
    </div>

    @auth
        <a href="{{ $dashboardRoute }}" class="btn btn-primary btn-sm">
            <span class="material-icons">dashboard</span>
            <span>Ke Dashboard</span>
        </a>
    @else
        <a href="{{ route('login') }}" class="btn btn-primary btn-sm">
            <span class="material-icons">login</span>
            Masuk
        </a>
    @endauth
</nav>

<main id="konten-utama">
    <section id="beranda" class="container hero">
        <div class="reveal">
            <div class="eyebrow"><span class="material-icons">auto_awesome</span> Sistem Pendampingan PAI Kota Samarinda</div>
            <h1>Mendampingi Pendidikan PAI, <em>Menguatkan</em> Generasi.</h1>
            <p class="hero-text">Satu ruang digital untuk membantu Pengawas PAI dan Guru PAI mengelola pendampingan, dokumen triwulan, diskusi, monitoring, dan laporan secara lebih mudah.</p>

            <div class="hero-actions">
                @auth
                    <a href="{{ $dashboardRoute }}" class="btn btn-primary">
                        <span class="material-icons">dashboard</span>
                        Masuk ke Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary">
                        <span class="material-icons">login</span>
                        Masuk ke SiPANDU
                    </a>
                @endauth
                <a href="#tentang" class="btn btn-outline">
                    Pelajari Lebih Lanjut
                    <span class="material-icons">arrow_downward</span>
                </a>
            </div>

            <div class="trust-row" aria-label="Pengguna utama sistem">
                <span class="trust-pill"><span class="material-icons">verified_user</span> Pengawas PAI</span>
                <span class="trust-pill"><span class="material-icons">school</span> Guru PAI SMA/SMK</span>
                <span class="trust-pill"><span class="material-icons">folder_shared</span> Dokumen Terpusat</span>
            </div>
        </div>

        <div class="hero-visual reveal">
            <div class="hero-image">
                <img src="{{ asset('images/meuw1.png') }}" alt="Kegiatan pembelajaran dan pendampingan guru di lingkungan sekolah">
            </div>
            <div class="trust-seal" aria-label="Terpercaya, amanah, profesional">
              
            </div>
        </div>
    </section>

    <section id="tentang" class="section section-alt">
        <div class="container about-grid">
            <img class="about-image reveal" src="{{ asset('images/meuw.png') }}" alt="Suasana pembelajaran di sekolah">

            <div class="about-copy reveal">
                <div class="eyebrow">Tentang SiPANDU</div>
                <div class="section-heading">
                    <h2>Satu sistem untuk pendampingan PAI yang lebih teratur dan mudah dipantau.</h2>
                </div>
                <p>SiPANDU VIRTUAL membantu Pengawas PAI mendampingi Guru PAI melalui pengelolaan data, pengisian dokumen per triwulan, review, diskusi, monitoring, dan laporan.</p>
                <p>Setiap proses tersimpan dalam satu sistem sehingga tindak lanjut lebih jelas dan laporan tidak perlu disusun ulang dari awal.</p>
            </div>

            <div class="stat-list reveal" aria-label="Keunggulan SiPANDU">
                <div class="stat-row"><span class="stat-icon material-icons">calendar_month</span><span><strong>Triwulan terstruktur</strong><span>Deadline dan status jelas</span></span></div>
                <div class="stat-row"><span class="stat-icon material-icons">fact_check</span><span><strong>Review terdokumentasi</strong><span>Feedback tersimpan per dokumen</span></span></div>
                <div class="stat-row"><span class="stat-icon material-icons">forum</span><span><strong>Diskusi terarah</strong><span>Ruang diskusi per triwulan</span></span></div>
                <div class="stat-row"><span class="stat-icon material-icons">summarize</span><span><strong>Laporan siap ekspor</strong><span>Rekap Excel dan PDF</span></span></div>
            </div>
        </div>
    </section>

    <section id="manfaat" class="section">
        <div class="container">
            <div class="section-heading reveal">
                <div class="eyebrow">Apa yang dapat dilakukan</div>
                <h2>Manfaat SiPANDU untuk proses pendampingan.</h2>
                <p>Fitur disusun dengan bahasa dan langkah yang mudah dipahami agar proses kerja lebih tertib.</p>
            </div>

            <div class="feature-grid">
                <article class="feature-card reveal">
                    <div class="feature-icon"><span class="material-icons">groups</span></div>
                    <h3>Pendampingan Guru</h3>
                    <p>Data guru binaan, sekolah, dan status pendampingan tersusun rapi dalam satu tempat.</p>
                </article>
                <article class="feature-card reveal">
                    <div class="feature-icon"><span class="material-icons">upload_file</span></div>
                    <h3>Dokumen Triwulan</h3>
                    <p>Guru mengunggah dokumen sesuai triwulan dan daftar kewajiban yang ditetapkan.</p>
                </article>
                <article class="feature-card reveal">
                    <div class="feature-icon"><span class="material-icons">forum</span></div>
                    <h3>Diskusi Terarah</h3>
                    <p>Pengawas dan guru berdiskusi dalam ruang yang tersimpan berdasarkan periode triwulan.</p>
                </article>
                <article class="feature-card reveal">
                    <div class="feature-icon"><span class="material-icons">analytics</span></div>
                    <h3>Monitoring & Laporan</h3>
                    <p>Progress guru mudah dipantau, kemudian direkap menjadi laporan yang dapat diekspor.</p>
                </article>
            </div>
        </div>
    </section>

    <section class="role-band" aria-label="Pengguna sistem">
        <div class="container role-band-inner">
            <div class="role-label">Digunakan oleh</div>
            <div class="role-list">
                <span class="role-item"><span class="material-icons">verified_user</span> Pengawas PAI</span>
                <span class="role-item"><span class="material-icons">school</span> Guru PAI SMA/SMK</span>
                <span class="role-item"><span class="material-icons">admin_panel_settings</span> Admin Sistem</span>
            </div>
        </div>
    </section>

    <section id="cara-kerja" class="section section-alt">
        <div class="container">
            <div class="section-heading reveal">
                <div class="eyebrow">Proses sederhana</div>
                <h2>Bagaimana SiPANDU bekerja?</h2>
            </div>
            <div class="steps">
                <article class="step-card reveal"><div class="step-number">01</div><h3>Masuk</h3><p>Pengguna masuk sesuai akun dan perannya.</p></article>
                <article class="step-card reveal"><div class="step-number">02</div><h3>Isi & Unggah</h3><p>Guru mengisi kebutuhan triwulan dan mengunggah dokumen.</p></article>
                <article class="step-card reveal"><div class="step-number">03</div><h3>Review</h3><p>Pengawas memeriksa dokumen dan memberi umpan balik.</p></article>
                <article class="step-card reveal"><div class="step-number">04</div><h3>Pantau & Laporkan</h3><p>Progress dipantau dan laporan dapat diekspor.</p></article>
            </div>
        </div>
    </section>

    <section id="pertanyaan" class="section">
        <div class="container">
            <div class="section-heading reveal" style="margin: 0 auto; text-align: center;">
                <div class="eyebrow" style="justify-content:center;">Pertanyaan umum</div>
                <h2>Pertanyaan yang sering ditanyakan</h2>
            </div>

            <div class="faq-wrap">
                <div class="faq-item open reveal">
                    <button class="faq-button" type="button" aria-expanded="true"><span>Apa itu SiPANDU VIRTUAL?</span><span class="material-icons">expand_more</span></button>
                    <div class="faq-content">SiPANDU VIRTUAL adalah sistem pendampingan terpadu untuk membantu Pengawas PAI dan Guru PAI SMA/SMK Kota Samarinda mengelola proses pendampingan secara digital.</div>
                </div>
                <div class="faq-item reveal">
                    <button class="faq-button" type="button" aria-expanded="false"><span>Siapa yang dapat menggunakan SiPANDU?</span><span class="material-icons">expand_more</span></button>
                    <div class="faq-content">Sistem ini digunakan oleh Pengawas PAI sebagai admin dan Guru PAI sebagai pengguna yang mengisi dokumen serta mengikuti pendampingan.</div>
                </div>
                <div class="faq-item reveal">
                    <button class="faq-button" type="button" aria-expanded="false"><span>Bagaimana guru dapat memperoleh akses?</span><span class="material-icons">expand_more</span></button>
                    <div class="faq-content">Guru membuat akun, kemudian menunggu proses persetujuan dari Pengawas PAI. Setelah disetujui, guru dapat masuk ke dashboard.</div>
                </div>
                <div class="faq-item reveal">
                    <button class="faq-button" type="button" aria-expanded="false"><span>Apakah dokumen dan laporan tersimpan?</span><span class="material-icons">expand_more</span></button>
                    <div class="faq-content">Dokumen yang diunggah dan hasil review tersimpan berdasarkan akun guru dan periode triwulan, sehingga mudah dilacak kembali.</div>
                </div>
            </div>
        </div>
    </section>

    <section class="section cta">
        <div class="container cta-inner">
            <div>
                <div class="eyebrow" style="color: var(--gold);">Siap menggunakan SiPANDU?</div>
                <h2>Pendampingan Pendidikan PAI yang lebih tertata dimulai dari satu langkah sederhana.</h2>
                <p>Masuk ke sistem untuk melihat dashboard sesuai peran Anda.</p>
            </div>
            @auth
                <a href="{{ $dashboardRoute }}" class="btn btn-light">
                    <span class="material-icons">dashboard</span> Ke Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="btn btn-light">
                    <span class="material-icons">login</span> Masuk ke SiPANDU
                </a>
            @endauth
        </div>
    </section>
</main>

<footer>
    <div class="container footer-grid">
        <div>
            <div class="brand">
                <span class="logo-badge-image-footer">
                    <img
                        src="{{ asset('images/logo.png') }}"
                        alt="Logo SiPANDU VIRTUAL"
                        class="logo-image"
                    >
                </span>

                <span>
                    <span class="brand-top" style="color:#fff;">
                        SiPANDU
                    </span>

                    <span
                        class="brand-bottom"
                        style="color:rgba(255,255,255,.6);"
                    >
                        Virtual · Pengawas PAI Samarinda
                    </span>
                </span>
            </div>

            <p style="max-width:330px;font-size:.88rem;">
                Platform pendampingan Pendidikan Agama Islam untuk SMA/SMK Kota Samarinda.
            </p>
        </div>

        {{-- Footer lain tetap sama --}}
    </div>

    <div class="container footer-bottom">
        <span>
            &copy; {{ date('Y') }} SiPANDU VIRTUAL — Pengawas PAI SMA/SMK Kota Samarinda
        </span>

        <button
            type="button"
            class="btn btn-sm btn-light"
            onclick="window.scrollTo({ top: 0, behavior: 'smooth' })"
        >
            <span class="material-icons">north</span>
            Ke Atas
        </button>
    </div>
</footer>

<div class="a11y-panel" id="a11y-panel" aria-label="Pengaturan tampilan">
    <button type="button" onclick="ubahUkuranTeks(1)">
        <span class="material-icons">text_increase</span>
        Perbesar teks
    </button>

    <button type="button" onclick="ubahUkuranTeks(-1)">
        <span class="material-icons">text_decrease</span>
        Perkecil teks
    </button>

    <button type="button" onclick="toggleKontras()">
        <span class="material-icons">contrast</span>
        Kontras tinggi
    </button>
</div>

<button
    type="button"
    class="a11y-toggle"
    id="a11y-toggle"
    aria-label="Buka pengaturan tampilan"
    aria-expanded="false"
>
    <span class="material-icons">accessibility_new</span>
</button>

<script>
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.12
    });

    document.querySelectorAll('.reveal').forEach((element) => {
        observer.observe(element);
    });

    document.querySelectorAll('.faq-button').forEach((button) => {
        button.addEventListener('click', () => {
            const item = button.closest('.faq-item');
            const isOpen = item.classList.toggle('open');

            button.setAttribute('aria-expanded', String(isOpen));
        });
    });

    const panel = document.getElementById('a11y-panel');
    const toggle = document.getElementById('a11y-toggle');

    toggle.addEventListener('click', () => {
        const isOpen = panel.classList.toggle('show');

        toggle.setAttribute('aria-expanded', String(isOpen));
    });

    document.addEventListener('DOMContentLoaded', () => {
        const scale = localStorage.getItem('sipandu-fontscale') || '1';
        document.documentElement.setAttribute('data-fontscale', scale);

        if (localStorage.getItem('sipandu-contrast') === 'high') {
            document.documentElement.setAttribute('data-contrast', 'high');
        }
    });

    function ubahUkuranTeks(arah) {
        const html = document.documentElement;
        let current = parseInt(html.getAttribute('data-fontscale') || '1', 10);

        current = Math.min(3, Math.max(1, current + arah));

        html.setAttribute('data-fontscale', current);
        localStorage.setItem('sipandu-fontscale', current);
    }

    function toggleKontras() {
        const html = document.documentElement;
        const isHigh = html.getAttribute('data-contrast') === 'high';

        if (isHigh) {
            html.removeAttribute('data-contrast');
            localStorage.setItem('sipandu-contrast', 'normal');
        } else {
            html.setAttribute('data-contrast', 'high');
            localStorage.setItem('sipandu-contrast', 'high');
        }
    }
</script>
</body>
</html>