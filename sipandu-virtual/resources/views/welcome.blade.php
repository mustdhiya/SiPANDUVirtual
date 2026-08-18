<!DOCTYPE html>
<html lang="id" data-fontscale="1">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SiPANDU VIRTUAL — Sistem Pendampingan Terpadu Virtual</title>
<meta name="description" content="SiPANDU VIRTUAL membantu Pengawas, Guru, Sekolah, dan Orang Tua mendapatkan informasi pendampingan Pendidikan Agama Islam SMA/SMK Kota Samarinda dengan lebih mudah.">
<link href="https://cdn.jsdelivr.net/npm/daisyui@5/daisyui.css" rel="stylesheet" type="text/css" />
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,500;0,9..144,600;0,9..144,700;1,9..144,500&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<style>
  :root{
    --bg:#faf7f0; --bg-alt:#eef0e3; --dark:#3d4a2f; --dark-2:#2d3822; --gold:#a97f34; --gold-tint:#f2e6cc;
    --text:#1f2419; --text2:#4f5546; --border:rgba(61,74,47,0.16); --card:#ffffff;
  }
  *{box-sizing:border-box;}
  html{scroll-behavior:smooth; font-size:18px;}
  html[data-fontscale="2"]{font-size:20px;}
  html[data-fontscale="3"]{font-size:22px;}
  html[data-contrast="high"]{ --text2:#1f2419; --border:#1f2419; }
  body{
    margin:0; background:var(--bg); color:var(--text);
    font-family:'Inter',sans-serif; line-height:1.7;
  }
  ::-webkit-scrollbar{width:8px;height:8px;}
  ::-webkit-scrollbar-track{background:var(--bg);}
  ::-webkit-scrollbar-thumb{background:var(--gold);border-radius:10px;}

  .font-display{font-family:'Fraunces',serif;}
  a{text-decoration:none;color:inherit;}
  .container{max-width:1200px;margin:0 auto;}

  .skip-link{position:absolute;left:-9999px;top:0;background:var(--dark);color:#fff;padding:0.75rem 1.25rem;z-index:200;border-radius:0 0 0.75rem 0;font-weight:600;}
  .skip-link:focus{left:0;}
  a:focus-visible, button:focus-visible, input:focus-visible{outline:3px solid var(--gold); outline-offset:2px;}

  .reveal{opacity:0; transform:translateY(28px); transition:opacity 550ms cubic-bezier(0.16,1,0.3,1), transform 550ms cubic-bezier(0.16,1,0.3,1);}
  .reveal.visible{opacity:1; transform:translateY(0);}

  /* accessibility toolbar */
  .a11y-toolbar{position:fixed; bottom:1.25rem; right:1.25rem; z-index:150; display:flex; flex-direction:column; gap:0.5rem;}
  .a11y-btn{
    min-height:48px; padding:0 1.1rem; border-radius:9999px; font-weight:700; font-size:0.9rem;
    display:inline-flex; align-items:center; gap:0.4rem; border:2px solid var(--dark); background:#fff; color:var(--dark);
    cursor:pointer; box-shadow:0 6px 16px rgba(0,0,0,0.12);
  }
  .a11y-btn.primary{background:var(--dark); color:#fff;}
  .a11y-btn:hover{transform:scale(1.03);}

  /* navbar */
  nav.navbar-main{
    position:sticky; top:0; z-index:100; background:rgba(250,247,240,0.92);
    backdrop-filter:blur(10px);
    padding:1.1rem 3rem;
    display:flex; align-items:center; justify-content:space-between;
    border-bottom:1px solid var(--border);
  }
  .logo-badge{
    width:44px;height:44px;background:var(--dark);color:#fff;
    border-radius:0.75rem; display:flex; align-items:center; justify-content:center;
    flex-shrink:0;
  }
  .logo-text-top{font-weight:800;font-size:1.05rem;letter-spacing:0.04em;line-height:1.2; font-family:'Fraunces',serif; color:var(--dark);}
  .logo-text-bottom{font-weight:600;font-size:0.72rem;letter-spacing:0.08em;color:var(--text2);line-height:1.3;}
  .nav-link{font-size:1rem;font-weight:600;color:var(--text);padding-bottom:4px;}
  .nav-link.active{color:var(--dark);border-bottom:2px solid var(--gold);}
  .nav-link:hover{color:var(--dark);}

  .btn-base{
    min-height:48px; border-radius:9999px; padding:0.85rem 1.6rem; font-weight:700; font-size:1rem;
    display:inline-flex; align-items:center; gap:0.5rem; border:none; cursor:pointer;
    transition:transform 200ms cubic-bezier(0.16,1,0.3,1), background-color 200ms ease;
  }
  .btn-base:hover{transform:scale(1.03);}
  .btn-dark{background:var(--dark); color:#fff;}
  .btn-dark:hover{background:var(--dark-2); color:#fff;}
  .btn-outline-dark{background:transparent; border:2px solid var(--dark); color:var(--dark);}
  .btn-outline-dark:hover{background:rgba(61,74,47,0.08);}
  .btn-gold-outline{background:var(--gold-tint); border:2px solid var(--gold); color:var(--text);}
  .btn-gold-outline:hover{background:#ecdbb1;}
  .btn-on-dark{background:#fff; color:var(--dark);}
  .btn-on-dark:hover{background:var(--gold-tint);}

  /* hero */
  .hero-section{
    min-height:82vh; padding:2.5rem 3rem 4rem; display:grid;
    grid-template-columns:55% 45%; align-items:center; gap:2.5rem; position:relative;
  }
  .hero-label{font-size:0.95rem;letter-spacing:0.06em;color:var(--gold);text-transform:uppercase;font-weight:700;}
  .hero-h1{font-family:'Fraunces',serif; font-size:clamp(2.4rem,5vw,3.6rem); font-weight:600; line-height:1.2; color:var(--text); margin:0.6rem 0;}
  .hero-h1 em{font-style:italic; color:var(--gold); font-weight:600;}
  .hero-sub{font-size:1.15rem;color:var(--text2);line-height:1.75;max-width:460px;margin-top:1rem;}
  .connect-label{font-size:0.85rem;letter-spacing:0.06em;color:var(--text2);margin-top:2.5rem;text-transform:uppercase;font-weight:700;}
  .trust-row{display:flex;flex-wrap:wrap;gap:0.85rem;margin-top:1rem;}
  .trust-pill{
    display:flex;align-items:center;gap:0.5rem; padding:0.55rem 1rem; border-radius:9999px;
    background:#fff; border:1px solid var(--border); font-weight:600; font-size:0.95rem; color:var(--text);
  }

  .hero-image-wrap{position:relative; width:100%; max-width:420px; margin-left:auto;}
  .hero-arch{
    border-radius:200px 200px 24px 24px; background:var(--dark);
    width:100%; aspect-ratio:3/4; position:relative; overflow:hidden;
  }
  .hero-arch img{width:100%;height:100%;object-fit:cover;display:block;}
  .badge-circle{
    position:absolute; top:-1rem; right:-1.5rem; width:120px; height:120px; border-radius:50%;
    background:#fff; border:1px solid var(--border); box-shadow:0 8px 24px rgba(0,0,0,0.1);
    display:flex; align-items:center; justify-content:center;
    animation: rotateBadge 22s linear infinite;
  }
  @keyframes rotateBadge{from{transform:rotate(0deg);}to{transform:rotate(360deg);}}
  .badge-circle svg.spin-text{position:absolute; width:100%; height:100%;}
  .badge-center-icon{position:absolute; color:var(--gold);}
  .leaf-deco{position:absolute; opacity:0.6; pointer-events:none;}

  /* about */
  .about-section{background:var(--bg-alt); padding:4.5rem 3rem; display:grid; grid-template-columns:25% 45% 30%; gap:2.5rem; align-items:center;}
  .about-img{border-radius:1.25rem; object-fit:cover; aspect-ratio:1/1.2; width:100%; display:block;}
  .section-label{font-size:0.95rem;letter-spacing:0.06em;color:var(--gold);text-transform:uppercase;font-weight:700;display:flex;align-items:center;gap:0.35rem;}
  .about-h2{font-family:'Fraunces',serif; font-size:clamp(1.7rem,3.5vw,2.3rem); font-weight:600; color:var(--text); line-height:1.35; margin:0.6rem 0;}
  .about-body{font-size:1.05rem;color:var(--text2);line-height:1.75;margin-top:1rem;}
  .stat-list{display:flex;flex-direction:column;gap:1.1rem;}
  .stat-item{display:flex;align-items:center;gap:0.75rem;}
  .stat-icon{width:38px;height:38px;border-radius:50%;background:#fff;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
  .stat-text{font-size:0.98rem;font-weight:700;color:var(--text);}

  /* manfaat */
  .services-section{background:var(--bg); padding:4.5rem 3rem;}
  .section-header-row{display:flex; justify-content:space-between; align-items:baseline; flex-wrap:wrap; gap:1rem;}
  .section-h2{font-family:'Fraunces',serif; font-weight:600; margin:0.4rem 0 0; font-size:clamp(1.9rem,4vw,2.5rem);}
  .services-grid{display:grid; grid-template-columns:repeat(4,1fr); gap:1.5rem; margin-top:2.5rem;}
  .service-card{
    background:var(--card); border:1px solid var(--border); border-radius:1.25rem; padding:1.85rem;
    min-height:220px;
    transition:transform 200ms cubic-bezier(0.16,1,0.3,1), box-shadow 200ms cubic-bezier(0.16,1,0.3,1);
  }
  .service-card:hover{transform:translateY(-6px); box-shadow:0 16px 32px rgba(0,0,0,0.09);}
  .service-icon{width:52px;height:52px;border-radius:0.9rem;background:var(--gold-tint);display:flex;align-items:center;justify-content:center;margin-bottom:1rem;}
  .service-title{font-family:'Fraunces',serif; font-weight:700; font-size:1.2rem; color:var(--text); margin-bottom:0.5rem;}
  .service-desc{font-size:1rem;color:var(--text2);line-height:1.65;}

  /* pengguna bar */
  .users-bar{background:var(--dark); padding:1.75rem 3rem; display:flex; align-items:center; gap:2.5rem; flex-wrap:wrap; justify-content:center;}
  .users-label{font-size:0.85rem;letter-spacing:0.06em;color:rgba(255,255,255,0.65);text-transform:uppercase;font-weight:700;flex-shrink:0;}
  .users-list{display:flex;gap:2rem;flex-wrap:wrap;justify-content:center;}
  .user-item{display:flex;align-items:center;gap:0.5rem;color:#fff;font-size:1rem;font-weight:600;flex-shrink:0;}
  .user-icon-sq{width:30px;height:30px;border-radius:8px;display:flex;align-items:center;justify-content:center;background:rgba(255,255,255,0.15);flex-shrink:0;}

  /* informasi */
  .projects-section{background:var(--bg); padding:4.5rem 3rem;}
  .view-all-link{font-size:1rem;color:var(--dark);font-weight:700;display:inline-flex;align-items:center;gap:0.3rem;}
  .projects-grid{display:grid; grid-template-columns:repeat(3,1fr); gap:1.5rem; margin-top:2.5rem;}
  .project-card{border-radius:1.25rem; overflow:hidden; position:relative; box-shadow:0 8px 24px rgba(0,0,0,0.06); background:#fff; border:1px solid var(--border);}
  .project-card img{width:100%; aspect-ratio:4/3; object-fit:cover; display:block;}
  .project-info{padding:1.25rem; }
  .project-badge{display:inline-block; background:var(--gold-tint); color:var(--text); font-size:0.82rem; font-weight:700; padding:0.3rem 0.75rem; border-radius:9999px; margin-bottom:0.6rem;}
  .project-title{font-weight:700;font-size:1.1rem;color:var(--text); font-family:'Fraunces',serif;}
  .project-desc{font-size:0.98rem;color:var(--text2);margin-top:0.4rem;line-height:1.6;}
  .project-date{font-size:0.85rem;color:var(--text2);margin-top:0.6rem;}
  .project-link{margin-top:0.75rem; display:inline-flex; align-items:center; gap:0.35rem; font-weight:700; color:var(--gold); font-size:0.98rem;}

  /* testimonials */
  .testimonials-section{background:var(--bg-alt); padding:4.5rem 3rem; display:grid; grid-template-columns:60% 40%; gap:2.5rem; align-items:center;}
  .testi-grid{display:grid; grid-template-columns:1fr 1fr; gap:1.5rem; margin-top:2.5rem;}
  .testi-card{background:#fff; border-radius:1.25rem; padding:1.75rem; border:1px solid var(--border); position:relative;}
  .testi-quote-text{font-style:italic; font-size:1.02rem; color:var(--text); line-height:1.65; margin:0.85rem 0;}
  .testi-name{font-weight:700;font-size:1rem;color:var(--text);}
  .testi-role{font-size:0.9rem;color:var(--text2);}
  .testi-img{border-radius:1.25rem; aspect-ratio:3/4; object-fit:cover; width:100%; display:block;}

  /* faq */
  .faq-section{background:var(--bg); padding:4.5rem 3rem;}
  .faq-item{background:#fff; border:1px solid var(--border); border-radius:1.1rem; padding:1.4rem 1.6rem; margin-bottom:1rem;}
  .faq-q{font-weight:700; font-size:1.1rem; display:flex; justify-content:space-between; align-items:center; cursor:pointer; color:var(--text);}
  .faq-a{font-size:1rem; color:var(--text2); margin-top:0.85rem; line-height:1.7; display:none;}
  .faq-item.open .faq-a{display:block;}
  .faq-item.open .faq-chevron{transform:rotate(180deg);}
  .faq-chevron{transition:transform 200ms ease;}

  /* contact / CTA */
  .contact-section{background:var(--dark); padding:4.5rem 3rem; border-radius:0; }
  .contact-h2{font-family:'Fraunces',serif; font-size:clamp(1.9rem,4vw,2.6rem); font-weight:600; margin:0.6rem 0; color:#fff;}
  .contact-info-row{display:flex; align-items:center; gap:0.6rem; font-size:1.02rem; color:#fff;}

  /* footer */
  footer.main-footer{background:var(--dark-2); padding:3.5rem 3rem 1.75rem; color:rgba(255,255,255,0.78);}
  .footer-grid{display:grid; grid-template-columns:repeat(4,1fr); gap:2.25rem;}
  .footer-heading{font-weight:700;font-size:1rem;color:#fff;margin-bottom:0.85rem;}
  .footer-link{font-size:0.95rem;color:rgba(255,255,255,0.7);line-height:2;display:block;transition:color 160ms;}
  .footer-link:hover{color:#fff;}
  .footer-divider{border-top:1px solid rgba(255,255,255,0.15); margin-top:2.25rem; padding-top:1.5rem; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:1rem;}
  .scroll-top-btn{min-width:48px;min-height:48px;padding:0 1rem;border-radius:9999px;background:rgba(255,255,255,0.12);color:#fff;display:inline-flex;align-items:center;gap:0.4rem;border:none;cursor:pointer;font-weight:600;}
  .scroll-top-btn:hover{background:var(--gold);}

  @media (max-width:900px){
    .hero-section{grid-template-columns:1fr;}
    .about-section{grid-template-columns:1fr; text-align:left;}
    .services-grid{grid-template-columns:repeat(2,1fr);}
    .projects-grid{grid-template-columns:1fr;}
    .testimonials-section{grid-template-columns:1fr;}
    .testi-grid{grid-template-columns:1fr;}
    .footer-grid{grid-template-columns:repeat(2,1fr);}
  }
  @media (max-width:768px){
    nav.navbar-main{padding:1rem 1.25rem;}
    .nav-center-links{display:none;}
    .hero-section{padding:1.75rem 1.5rem 3rem;}
    .about-section, .services-section, .projects-section, .testimonials-section, .contact-section, .faq-section{padding:3rem 1.5rem;}
    .users-bar{padding:1.5rem 1.5rem;}
    footer.main-footer{padding:3rem 1.5rem 1.5rem;}
    .a11y-toolbar{bottom:0.85rem; right:0.85rem;}
  }
</style>
</head>
<body>

<a href="#konten-utama" class="skip-link">Langsung ke konten utama</a>

<div class="a11y-toolbar" role="region" aria-label="Pengaturan tampilan">
  <button type="button" class="a11y-btn primary" onclick="ubahUkuranTeks(1)" aria-label="Perbesar ukuran teks">
    <i data-lucide="plus" style="width:16px;height:16px;"></i> Perbesar Teks
  </button>
  <button type="button" class="a11y-btn" onclick="ubahUkuranTeks(-1)" aria-label="Perkecil ukuran teks">
    <i data-lucide="minus" style="width:16px;height:16px;"></i> Perkecil Teks
  </button>
  <button type="button" class="a11y-btn" onclick="toggleKontras()" aria-label="Ubah kontras tinggi">
    <i data-lucide="contrast" style="width:16px;height:16px;"></i> Kontras Tinggi
  </button>
</div>

<nav class="navbar-main" aria-label="Navigasi utama">
  <a href="#home" style="display:flex;align-items:center;gap:0.75rem;">
    <div class="logo-badge"><i data-lucide="compass" style="width:22px;height:22px;"></i></div>
    <div>
      <div class="logo-text-top">SiPANDU</div>
      <div class="logo-text-bottom">VIRTUAL &middot; Pengawas PAI Samarinda</div>
    </div>
  </a>
  <div class="nav-center-links" style="display:flex;gap:2rem;">
    <a href="#home" class="nav-link active">Beranda</a>
    <a href="#about" class="nav-link">Tentang</a>
    <a href="#services" class="nav-link">Manfaat</a>
    <a href="#cara-kerja" class="nav-link">Cara Kerja</a>
    <a href="#informasi" class="nav-link">Informasi</a>
    <a href="#faq" class="nav-link">Pertanyaan</a>
  </div>
  <a href="{{ route('login') }}" class="btn-base btn-dark">
    <i data-lucide="log-in" style="width:16px;height:16px;"></i> Masuk
  </a>
</nav>

<main id="konten-utama">

<section class="hero-section" id="home">
  <div class="reveal">
    <div class="hero-label">Sistem Pendampingan PAI Kota Samarinda</div>
    <h1 class="hero-h1">
      Mendampingi Pendidikan PAI,<br>
      <em>Menguatkan</em> Generasi
    </h1>
    <p class="hero-sub">Satu ruang digital untuk membantu Pengawas, Guru, Sekolah, dan Orang Tua mendapatkan informasi pendidikan PAI dengan lebih mudah.</p>
    <div style="display:flex;gap:1rem;margin-top:2rem;flex-wrap:wrap;">
      <a href="{{ route('login') }}" class="btn-base btn-dark">Mulai Menggunakan SiPANDU <i data-lucide="arrow-right" style="width:16px;height:16px;"></i></a>
      <a href="#about" class="btn-base btn-outline-dark">Pelajari Lebih Lanjut</a>
    </div>
    <div class="connect-label">Dipercaya Untuk Mendukung Pendampingan PAI</div>
    <div class="trust-row">
      <div class="trust-pill"><i data-lucide="shield-check" style="width:18px;height:18px;color:var(--gold);"></i> Pengawas PAI</div>
      <div class="trust-pill"><i data-lucide="graduation-cap" style="width:18px;height:18px;color:var(--gold);"></i> Guru PAI</div>
      <div class="trust-pill"><i data-lucide="building-2" style="width:18px;height:18px;color:var(--gold);"></i> Sekolah SMA/SMK</div>
    </div>
  </div>
  <div class="hero-image-wrap reveal">
    <div class="hero-arch">
      <img src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?w=600&h=800&fit=crop" alt="Guru PAI berdiskusi hangat dengan siswa dan orang tua di lingkungan sekolah">
    </div>
    <div class="badge-circle">
      <svg class="spin-text" viewBox="0 0 200 200">
        <defs><path id="circlePath" d="M 100,100 m -75,0 a 75,75 0 1,1 150,0 a 75,75 0 1,1 -150,0"/></defs>
        <text font-size="9" letter-spacing="1.5" fill="#4f5546" style="text-transform:uppercase;">
          <textPath href="#circlePath">- TERPERCAYA - PROFESIONAL - AMANAH - </textPath>
        </text>
      </svg>
      <i data-lucide="sparkles" class="badge-center-icon" style="width:22px;height:22px;"></i>
    </div>
    <svg class="leaf-deco" style="top:-30px;left:-40px;width:80px;height:80px;" viewBox="0 0 100 100" aria-hidden="true"><path d="M50 10 Q70 30 50 50 Q30 30 50 10Z" fill="none" stroke="#3d4a2f" stroke-width="1.5" opacity="0.5"/></svg>
  </div>
</section>

<section class="about-section" id="about">
  <img class="about-img reveal" src="https://images.unsplash.com/photo-1577896334614-5498a338b4f2?w=400&h=500&fit=crop" alt="Suasana sekolah SMA/SMK di Kota Samarinda">
  <div class="reveal">
    <div class="section-label">Tentang SiPANDU</div>
    <h2 class="about-h2">Satu sistem untuk pendampingan PAI yang lebih teratur dan mudah dipantau.</h2>
    <p class="about-body">SiPANDU VIRTUAL adalah sistem digital yang membantu proses pendampingan Pendidikan Agama Islam agar lebih teratur, mudah dipantau, dan terdokumentasi dengan baik.</p>
    <p class="about-body">Melalui SiPANDU, Pengawas dan Guru dapat berkomunikasi, melakukan pendampingan, mengelola laporan, dan memantau kegiatan secara lebih mudah.</p>
  </div>
  <div class="stat-list reveal">
    <div class="stat-item"><div class="stat-icon"><i data-lucide="building-2" style="width:18px;height:18px;color:var(--gold);"></i></div><div class="stat-text">42+ Sekolah Binaan</div></div>
    <div class="stat-item"><div class="stat-icon"><i data-lucide="users" style="width:18px;height:18px;color:var(--gold);"></i></div><div class="stat-text">128+ Guru PAI</div></div>
    <div class="stat-item"><div class="stat-icon"><i data-lucide="calendar-check" style="width:18px;height:18px;color:var(--gold);"></i></div><div class="stat-text">12 Bulan Pendampingan</div></div>
    <div class="stat-item"><div class="stat-icon"><i data-lucide="layout-grid" style="width:18px;height:18px;color:var(--gold);"></i></div><div class="stat-text">1 Sistem Terpadu</div></div>
  </div>
</section>

<section class="services-section" id="services">
  <div class="section-header-row">
    <div>
      <div class="section-label">Apa yang Bisa Dilakukan</div>
      <h2 class="section-h2">Manfaat SiPANDU</h2>
    </div>
  </div>
  <div class="services-grid">
    <div class="service-card reveal">
      <div class="service-icon"><i data-lucide="graduation-cap" style="width:24px;height:24px;color:var(--dark);"></i></div>
      <div class="service-title">Pendampingan Guru</div>
      <div class="service-desc">Membantu Pengawas mendampingi Guru PAI secara teratur dan terdokumentasi.</div>
    </div>
    <div class="service-card reveal" style="transition-delay:100ms;">
      <div class="service-icon"><i data-lucide="message-circle" style="width:24px;height:24px;color:var(--dark);"></i></div>
      <div class="service-title">Diskusi &amp; Komunikasi</div>
      <div class="service-desc">Ruang komunikasi untuk berbagi informasi, pertanyaan, dan pengalaman.</div>
    </div>
    <div class="service-card reveal" style="transition-delay:200ms;">
      <div class="service-icon"><i data-lucide="clipboard-check" style="width:24px;height:24px;color:var(--dark);"></i></div>
      <div class="service-title">Pendampingan Terpantau</div>
      <div class="service-desc">Melihat proses pendampingan dan tindak lanjut secara lebih mudah.</div>
    </div>
    <div class="service-card reveal" style="transition-delay:300ms;">
      <div class="service-icon"><i data-lucide="file-text" style="width:24px;height:24px;color:var(--dark);"></i></div>
      <div class="service-title">Laporan</div>
      <div class="service-desc">Membuat dan mengelola laporan pendampingan secara terstruktur.</div>
    </div>
  </div>
</section>

<div class="users-bar">
  <div class="users-label">Digunakan Oleh</div>
  <div class="users-list">
    <div class="user-item"><div class="user-icon-sq"><i data-lucide="shield-check" style="width:16px;height:16px;"></i></div>Pengawas PAI</div>
    <div class="user-item"><div class="user-icon-sq"><i data-lucide="graduation-cap" style="width:16px;height:16px;"></i></div>Guru PAI</div>
    <div class="user-item"><div class="user-icon-sq"><i data-lucide="settings" style="width:16px;height:16px;"></i></div>Admin Sekolah</div>
    <div class="user-item"><div class="user-icon-sq"><i data-lucide="users" style="width:16px;height:16px;"></i></div>Orang Tua/Wali</div>
  </div>
</div>

<section id="cara-kerja" class="projects-section" style="background:var(--bg-alt);">
  <div class="section-header-row">
    <div>
      <div class="section-label">Proses yang Sederhana</div>
      <h2 class="section-h2">Bagaimana SiPANDU Bekerja?</h2>
    </div>
  </div>
  <div class="services-grid" style="margin-top:2.5rem;">
    <div class="service-card reveal" style="text-align:center;">
      <div class="service-icon" style="margin:0 auto 1rem;background:var(--dark);"><span style="color:#fff;font-weight:800;font-family:'Fraunces',serif;">01</span></div>
      <div class="service-title">Daftar &amp; Masuk</div>
      <div class="service-desc">Pengguna masuk sesuai perannya masing-masing.</div>
    </div>
    <div class="service-card reveal" style="text-align:center;transition-delay:100ms;">
      <div class="service-icon" style="margin:0 auto 1rem;background:var(--dark);"><span style="color:#fff;font-weight:800;font-family:'Fraunces',serif;">02</span></div>
      <div class="service-title">Lihat Informasi</div>
      <div class="service-desc">Informasi pendidikan dan pendampingan tersedia dalam satu tempat.</div>
    </div>
    <div class="service-card reveal" style="text-align:center;transition-delay:200ms;">
      <div class="service-icon" style="margin:0 auto 1rem;background:var(--dark);"><span style="color:#fff;font-weight:800;font-family:'Fraunces',serif;">03</span></div>
      <div class="service-title">Lakukan Pendampingan</div>
      <div class="service-desc">Guru dan Pengawas melakukan proses pendampingan.</div>
    </div>
    <div class="service-card reveal" style="text-align:center;transition-delay:300ms;">
      <div class="service-icon" style="margin:0 auto 1rem;background:var(--dark);"><span style="color:#fff;font-weight:800;font-family:'Fraunces',serif;">04</span></div>
      <div class="service-title">Pantau &amp; Laporkan</div>
      <div class="service-desc">Hasil pendampingan dicatat dan dapat dilaporkan.</div>
    </div>
  </div>
</section>

<section class="projects-section" id="informasi">
  <div class="section-header-row">
    <div>
      <div class="section-label">Kabar Terbaru</div>
      <h2 class="section-h2">Informasi Terbaru</h2>
    </div>
    <a href="#" class="view-all-link">Lihat Semua Informasi <i data-lucide="arrow-right" style="width:16px;height:16px;"></i></a>
  </div>
  <div class="projects-grid">
    <article class="project-card reveal">
      <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=500&h=380&fit=crop" alt="Kegiatan pendampingan Guru PAI">
      <div class="project-info">
        <span class="project-badge">Pendampingan</span>
        <div class="project-title">Pendampingan Guru PAI Triwulan II</div>
        <p class="project-desc">Informasi kegiatan pendampingan Guru PAI SMA/SMK Kota Samarinda.</p>
        <div class="project-date">15 Agustus 2026</div>
        <a href="#" class="project-link">Baca Selengkapnya <i data-lucide="arrow-right" style="width:14px;height:14px;"></i></a>
      </div>
    </article>
    <article class="project-card reveal" style="transition-delay:100ms;">
      <img src="https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=500&h=380&fit=crop" alt="Jadwal pendampingan sekolah">
      <div class="project-info">
        <span class="project-badge">Jadwal</span>
        <div class="project-title">Jadwal Pendampingan</div>
        <p class="project-desc">Lihat jadwal pendampingan yang akan datang.</p>
        <div class="project-date">10 Agustus 2026</div>
        <a href="#" class="project-link">Baca Selengkapnya <i data-lucide="arrow-right" style="width:14px;height:14px;"></i></a>
      </div>
    </article>
    <article class="project-card reveal" style="transition-delay:200ms;">
      <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=500&h=380&fit=crop" alt="Panduan penggunaan SiPANDU">
      <div class="project-info">
        <span class="project-badge">Panduan</span>
        <div class="project-title">Panduan Penggunaan SiPANDU</div>
        <p class="project-desc">Panduan sederhana untuk menggunakan SiPANDU.</p>
        <div class="project-date">1 Agustus 2026</div>
        <a href="#" class="project-link">Baca Selengkapnya <i data-lucide="arrow-right" style="width:14px;height:14px;"></i></a>
      </div>
    </article>
  </div>
</section>

<section class="testimonials-section" id="testimonials">
  <div>
    <div class="section-label">Apa Kata Mereka</div>
    <h2 class="section-h2">Cerita dari Guru, Pengawas, dan Orang Tua</h2>
    <div class="testi-grid">
      <div class="testi-card reveal">
        <i data-lucide="quote" style="width:26px;height:26px;color:var(--gold);"></i>
        <p class="testi-quote-text">&ldquo;Dengan SiPANDU, proses pendampingan menjadi lebih teratur dan informasi yang sebelumnya tersebar sekarang lebih mudah ditemukan.&rdquo;</p>
        <div class="testi-name">Guru PAI</div>
        <div class="testi-role">SMA Kota Samarinda</div>
      </div>
      <div class="testi-card reveal" style="transition-delay:100ms;">
        <i data-lucide="quote" style="width:26px;height:26px;color:var(--gold);"></i>
        <p class="testi-quote-text">&ldquo;Saya lebih mudah memahami informasi kegiatan pendidikan anak saya di sekolah.&rdquo;</p>
        <div class="testi-name">Orang Tua/Wali Siswa</div>
        <div class="testi-role">Kota Samarinda</div>
      </div>
    </div>
  </div>
  <img class="testi-img reveal" src="https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=500&h=650&fit=crop" alt="Pengawas PAI mendampingi kegiatan sekolah">
</section>

<section class="faq-section" id="faq">
  <div class="section-header-row" style="justify-content:center;text-align:center;flex-direction:column;">
    <div class="section-label" style="justify-content:center;">Pertanyaan Umum</div>
    <h2 class="section-h2">Pertanyaan yang Sering Ditanyakan</h2>
  </div>
  <div style="max-width:760px;margin:2.5rem auto 0;">
    <div class="faq-item open">
      <div class="faq-q" onclick="this.parentElement.classList.toggle('open')">
        Apa itu SiPANDU?
        <i data-lucide="chevron-down" class="faq-chevron" style="width:20px;height:20px;"></i>
      </div>
      <div class="faq-a">SiPANDU adalah Sistem Pendampingan Terpadu Virtual untuk mendukung proses pendampingan PAI SMA/SMK Kota Samarinda.</div>
    </div>
    <div class="faq-item">
      <div class="faq-q" onclick="this.parentElement.classList.toggle('open')">
        Siapa yang dapat menggunakan SiPANDU?
        <i data-lucide="chevron-down" class="faq-chevron" style="width:20px;height:20px;"></i>
      </div>
      <div class="faq-a">SiPANDU digunakan oleh Pengawas PAI, Guru PAI, dan Admin, serta dapat menyediakan informasi yang relevan bagi Orang Tua/Wali.</div>
    </div>
    <div class="faq-item">
      <div class="faq-q" onclick="this.parentElement.classList.toggle('open')">
        Apakah orang tua harus memahami teknologi?
        <i data-lucide="chevron-down" class="faq-chevron" style="width:20px;height:20px;"></i>
      </div>
      <div class="faq-a">Tidak. SiPANDU dirancang dengan tampilan sederhana, termasuk fitur perbesar teks dan kontras tinggi agar mudah digunakan berbagai usia.</div>
    </div>
    <div class="faq-item">
      <div class="faq-q" onclick="this.parentElement.classList.toggle('open')">
        Apakah data saya aman?
        <i data-lucide="chevron-down" class="faq-chevron" style="width:20px;height:20px;"></i>
      </div>
      <div class="faq-a">Data pengguna dikelola melalui sistem autentikasi dan hak akses sesuai peran pengguna (Admin, Pengawas, atau Guru).</div>
    </div>
  </div>
</section>

<section class="contact-section" id="contact">
  <div class="container" style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:2rem;">
    <div>
      <div class="section-label" style="color:var(--gold);">Mari Terhubung</div>
      <h2 class="contact-h2">Mari Bersama Membangun Pendampingan Pendidikan yang Lebih Baik</h2>
      <p style="font-size:1.05rem;color:rgba(255,255,255,0.85);margin-top:0.5rem;max-width:460px;">SiPANDU hadir untuk membantu Pengawas, Guru, Sekolah, dan Orang Tua terhubung dengan informasi pendidikan secara lebih mudah.</p>
    </div>
    <div>
      <div style="display:flex;flex-direction:column;gap:0.85rem;">
        <div class="contact-info-row"><i data-lucide="mail" style="width:18px;height:18px;color:var(--gold);"></i> pengawas.pai@samarinda.go.id</div>
        <div class="contact-info-row"><i data-lucide="map-pin" style="width:18px;height:18px;color:var(--gold);"></i> Samarinda, Kalimantan Timur</div>
      </div>
      <a href="{{ route('login') }}" class="btn-base btn-on-dark" style="margin-top:1.25rem;">Masuk ke SiPANDU <i data-lucide="arrow-right" style="width:16px;height:16px;"></i></a>
    </div>
  </div>
</section>

</main>

<footer class="main-footer">
  <div class="container footer-grid">
    <div>
      <div style="display:flex;align-items:center;gap:0.75rem;">
        <div class="logo-badge"><i data-lucide="compass" style="width:20px;height:20px;"></i></div>
        <div style="color:#fff;font-weight:700;font-size:1.05rem;font-family:'Fraunces',serif;">SiPANDU VIRTUAL</div>
      </div>
      <p style="font-size:0.95rem;color:rgba(255,255,255,0.65);line-height:1.7;margin-top:0.9rem;">Platform pendampingan Pendidikan Agama Islam untuk SMA/SMK Kota Samarinda.</p>
    </div>
    <div>
      <div class="footer-heading">SiPANDU</div>
      <a href="#home" class="footer-link">Beranda</a>
      <a href="#about" class="footer-link">Tentang</a>
      <a href="#services" class="footer-link">Manfaat</a>
      <a href="#cara-kerja" class="footer-link">Cara Kerja</a>
      <a href="#informasi" class="footer-link">Informasi</a>
    </div>
    <div>
      <div class="footer-heading">Layanan</div>
      <a href="#" class="footer-link">Berita</a>
      <a href="#" class="footer-link">Panduan</a>
      <a href="#faq" class="footer-link">Pertanyaan</a>
      <a href="#contact" class="footer-link">Kontak</a>
    </div>
    <div>
      <div class="footer-heading">Pengguna</div>
      <span class="footer-link">Pengawas PAI</span>
      <span class="footer-link">Guru PAI</span>
      <span class="footer-link">Orang Tua/Wali</span>
    </div>
  </div>
  <div class="container footer-divider">
    <div style="font-size:0.9rem;color:rgba(255,255,255,0.6);">&copy; 2026 SiPANDU VIRTUAL — Pengawas PAI SMA/SMK Kota Samarinda</div>
    <button class="scroll-top-btn" onclick="window.scrollTo({top:0,behavior:'smooth'})" aria-label="Kembali ke atas halaman">
      <i data-lucide="chevron-up" style="width:18px;height:18px;"></i> Ke Atas
    </button>
  </div>
</footer>

<script>
  lucide.createIcons();

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.12 });

  document.querySelectorAll('.reveal').forEach((el) => observer.observe(el));

  document.addEventListener('DOMContentLoaded', function () {
    const savedScale = localStorage.getItem('sipandu-fontscale') || '1';
    document.documentElement.setAttribute('data-fontscale', savedScale);
    const savedContrast = localStorage.getItem('sipandu-contrast');
    if (savedContrast === 'high') document.documentElement.setAttribute('data-contrast', 'high');
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
    const active = html.getAttribute('data-contrast') === 'high';
    if (active) {
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