// ============================================================
//  bar.js — SiPANDU VIRTUAL
//  Navigasi sidebar + topbar + theme toggle
//  Sertakan di semua halaman:
//    <script src="../assets/js/bar.js"></script>  (dari subfolder)
//    <script src="../assets/js/bar.js"></script>     (dari root)
// ============================================================

(function () {
  'use strict';

  // ----------------------------------------------------------
  // 1. DETEKSI PATH ROOT
  //    Otomatis menyesuaikan prefix "../" jika berada di subfolder
  // ----------------------------------------------------------
  const inSubfolder = /^\/(admin|guru)\//i.test(window.location.pathname);
  const ROOT = inSubfolder ? '../' : './';

  // ----------------------------------------------------------
  // 2. PETA NAVIGASI LENGKAP
  // ----------------------------------------------------------
  const NAV = {
    // Halaman publik (root)
    public: [
      { icon: 'home',          label: 'Beranda',          href: ROOT + 'index.html' },
      { icon: 'login',         label: 'Masuk',            href: ROOT + 'login.html' },
      { icon: 'person_add',    label: 'Daftar',           href: ROOT + 'register.html' },
    ],

    // Sidebar Guru
    guru: [
      { icon: 'dashboard',     label: 'Dashboard',        href: ROOT + 'guru/dashboard.html' },
      { icon: 'assignment',    label: 'Triwulan I',       href: ROOT + 'guru/tw1.html' },
      { icon: 'school',        label: 'Triwulan II',      href: ROOT + 'guru/tw2.html' },
      { icon: 'visibility',    label: 'Triwulan III',     href: ROOT + 'guru/tw3.html' },
      { icon: 'assessment',    label: 'Triwulan IV',      href: ROOT + 'guru/tw4.html' },
      { icon: 'bar_chart',     label: 'Status SIAGA',     href: ROOT + 'guru/siaga.html' },
      { icon: 'forum',         label: 'Ruang Diskusi',    href: ROOT + 'guru/diskusi.html' },
      { icon: 'folder_open',   label: 'Gudang PAI-BMTS',  href: ROOT + 'guru/gudang.html' },
      { icon: 'person',        label: 'Profil Saya',      href: ROOT + 'guru/profil.html' },
      { divider: true },
      { icon: 'notifications', label: 'Notifikasi',       href: ROOT + 'notifikasi.html' },
      { icon: 'logout',        label: 'Keluar',           href: ROOT + 'login.html', danger: true },
    ],

    // Sidebar Admin / Pengawas
    admin: [
      { icon: 'dashboard',          label: 'Dashboard',             href: ROOT + 'admin/dashboard.html' },
      { icon: 'table_chart',        label: 'Monitoring Center',     href: ROOT + 'admin/monitoring.html' },
      { icon: 'how_to_reg',         label: 'Verifikasi Pendaftaran',href: ROOT + 'admin/approve.html' },
      { divider: true },
      { icon: 'groups',             label: 'Kelola Guru',           href: ROOT + 'admin/guru.html' },
      { icon: 'apartment',          label: 'Kelola Sekolah',        href: ROOT + 'admin/sekolah.html' },
      { icon: 'checklist',          label: 'Dokumen Wajib',         href: ROOT + 'admin/dokumen-wajib.html' },
      { icon: 'event_note',         label: 'Tahun Ajaran',          href: ROOT + 'admin/tahun-ajaran.html' },
      { icon: 'date_range',         label: 'Kelola Triwulan',       href: ROOT + 'admin/triwulan.html' },
      { divider: true },
      { icon: 'leaderboard',        label: 'Matriks Prioritas',     href: ROOT + 'admin/matriks.html' },
      { icon: 'print',              label: 'Laporan & Export',      href: ROOT + 'admin/laporan.html' },
      { icon: 'forum',              label: 'Ruang Diskusi',         href: ROOT + 'admin/diskusi.html' },
      { icon: 'folder_open',        label: 'Gudang PAI-BMTS',       href: ROOT + 'admin/gudang.html' },
      { divider: true },
      { icon: 'notifications',      label: 'Notifikasi',            href: ROOT + 'notifikasi.html' },
      { icon: 'logout',             label: 'Keluar',                href: ROOT + 'login.html', danger: true },
    ],
  };

  // ----------------------------------------------------------
  // 3. DETEKSI ROLE DARI DATA ATTRIBUTE
  //    Tambahkan  data-role="admin"  atau  data-role="guru"
  //    pada tag <body>
  // ----------------------------------------------------------
  function getRole() {
    const body = document.body;
    if (body.dataset.role) return body.dataset.role;
    if (window.location.pathname.includes('/admin/')) return 'admin';
    if (window.location.pathname.includes('/guru/'))  return 'guru';
    return 'public';
  }

  // ----------------------------------------------------------
  // 4. TANDAI ITEM AKTIF
  // ----------------------------------------------------------
  function isActive(href) {
    const current = window.location.pathname.replace(/\\/g, '/');
    const resolved = href.replace(/^(\.\.\/|\.\/)+/, '/').replace('//', '/');
    return current.endsWith(resolved) || current.endsWith(href.replace(/^.*\//, ''));
  }

  // ----------------------------------------------------------
  // 5. BUILD ITEM NAVIGASI (AMAN DARI XSS)
  //    Semua nilai di-set via .textContent / .setAttribute
  //    — tidak ada innerHTML dari data dinamis
  // ----------------------------------------------------------
  function buildNavItem(item, container) {
    if (item.divider) {
      const li  = document.createElement('li');
      const div = document.createElement('div');
      div.className = 'divider my-1';
      li.appendChild(div);
      container.appendChild(li);
      return;
    }

    const li = document.createElement('li');
    const a  = document.createElement('a');

    // href — whitelist: hanya path relatif
    if (/^[a-zA-Z0-9_./#\-]+$/.test(item.href)) {
      a.setAttribute('href', item.href);
    } else {
      a.setAttribute('href', '#');
    }

    a.className = 'touch-target rounded-xl flex items-center gap-3';
    if (item.danger)  a.classList.add('text-error');
    if (isActive(item.href)) a.classList.add('active', 'bg-emerald-50', 'text-emerald-800',
                                             'font-bold', 'dark:bg-emerald-900/30',
                                             'dark:text-emerald-300');

    const icon = document.createElement('span');
    icon.className = 'material-icons';
    icon.textContent = item.icon;   // aman: textContent

    const text = document.createElement('span');
    text.textContent = item.label;  // aman: textContent

    a.appendChild(icon);
    a.appendChild(text);
    li.appendChild(a);
    container.appendChild(li);
  }

  // ----------------------------------------------------------
  // 6. RENDER SIDEBAR ITEMS
  //    Target: <ul id="sipandu-sidebar-nav">
  // ----------------------------------------------------------
  function renderSidebar() {
    const ul = document.getElementById('sipandu-sidebar-nav');
    if (!ul) return;

    const role  = getRole();
    const items = NAV[role] || NAV.public;
    ul.innerHTML = '';
    items.forEach(item => buildNavItem(item, ul));
  }

  // ----------------------------------------------------------
  // 7. THEME TOGGLE
  //    Target tombol: id="sipandu-theme-toggle"
  //    Target ikon:   id="sipandu-theme-icon"
  //    Target label:  id="sipandu-theme-label"
  // ----------------------------------------------------------
  function setupTheme() {
    const html      = document.documentElement;
    const btn       = document.getElementById('sipandu-theme-toggle');
    const iconEl    = document.getElementById('sipandu-theme-icon');
    const labelEl   = document.getElementById('sipandu-theme-label');
    const STORAGE   = 'sipandu-theme';

    function apply(theme) {
      html.setAttribute('data-theme', theme);
      try { localStorage.setItem(STORAGE, theme); } catch (_) {}

      if (!iconEl || !labelEl) return;
      if (theme === 'dark') {
        iconEl.textContent  = 'light_mode';
        labelEl.textContent = 'Mode Siang';
      } else {
        iconEl.textContent  = 'dark_mode';
        labelEl.textContent = 'Mode Malam';
      }
    }

    let saved;
    try { saved = localStorage.getItem(STORAGE); } catch (_) {}
    apply(saved || 'light');

    if (btn) {
      btn.addEventListener('click', () => {
        apply(html.getAttribute('data-theme') === 'light' ? 'dark' : 'light');
      });
    }
  }

  // ----------------------------------------------------------
  // 8. TOPBAR: nama halaman + breadcrumb otomatis
  //    Target: id="sipandu-page-title"
  //    Fallback ke <title> tag
  // ----------------------------------------------------------
  const PAGE_TITLES = {
    // Admin
    'admin/dashboard.html':        'Dashboard Pengawas',
    'admin/monitoring.html':       'Monitoring Center',
    'admin/monitoring-detail.html':'Detail Monitoring Guru',
    'admin/approve.html':          'Verifikasi Pendaftaran',
    'admin/guru.html':             'Kelola Guru Binaan',
    'admin/sekolah.html':          'Kelola Sekolah Binaan',
    'admin/dokumen-wajib.html':    'Kelola Dokumen Wajib',
    'admin/tahun-ajaran.html':     'Kelola Tahun Ajaran',
    'admin/triwulan.html':         'Kelola Triwulan',
    'admin/matriks.html':          'Matriks Prioritas',
    'admin/laporan.html':          'Laporan & Export',
    'admin/diskusi.html':          'Ruang Diskusi (Admin)',
    'admin/gudang.html':           'Gudang PAI-BMTS (Admin)',
    // Guru
    'guru/dashboard.html':         'Dashboard Guru',
    'guru/tw1.html':               'Triwulan I — Perencanaan',
    'guru/tw2.html':               'Triwulan II — Pendampingan',
    'guru/tw3.html':               'Triwulan III — Observasi',
    'guru/tw4.html':               'Triwulan IV — Evaluasi',
    'guru/siaga.html':             'Status SIAGA Saya',
    'guru/diskusi.html':           'Ruang Diskusi',
    'guru/gudang.html':            'Gudang PAI-BMTS',
    'guru/profil.html':            'Profil Saya',
    'guru/tw-terkunci.html':       'Triwulan Terkunci',
    // Root
    'index.html':                  'Beranda SiPANDU VIRTUAL',
    'login.html':                  'Masuk ke Akun',
    'register.html':               'Daftar Akun Guru',
    'pending.html':                'Menunggu Verifikasi',
    'forgot-password.html':        'Lupa Password',
    'notifikasi.html':             'Notifikasi',
    '404.html':                    'Halaman Tidak Ditemukan',
  };

  function setPageTitle() {
    const el = document.getElementById('sipandu-page-title');
    if (!el) return;
    const path    = window.location.pathname.replace(/\\/g, '/');
    const segment = path.split('/').slice(-2).join('/');
    const title   = PAGE_TITLES[segment]
                 || PAGE_TITLES[path.split('/').pop()]
                 || document.title;
    el.textContent = title;
  }

  // ----------------------------------------------------------
  // 9. MOBILE DRAWER — tutup otomatis setelah klik menu item
  // ----------------------------------------------------------
  function setupDrawerAutoClose() {
    const checkbox = document.getElementById('main-drawer');
    if (!checkbox) return;

    document.querySelectorAll('#sipandu-sidebar-nav a').forEach(a => {
      a.addEventListener('click', () => {
        if (window.innerWidth < 1024) checkbox.checked = false;
      });
    });
  }

  // ----------------------------------------------------------
  // 10. INIT
  // ----------------------------------------------------------
  function init() {
    setupTheme();
    renderSidebar();
    setPageTitle();
    setupDrawerAutoClose();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }

})();
