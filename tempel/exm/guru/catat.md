Sekarang fokus ke halaman ini. Tolong refactor dan perbaiki secara optimal dengan prinsip:
Hindari over-complicated logic
Hindari over-engineering
Hindari dirty code
Prioritaskan clean, readable, dan maintainable code
UI/UX harus:
Sangat sederhana dan intuitif
Mudah digunakan oleh orang tua yang tidak terbiasa dengan teknologi
Navigasi jelas, tombol besar, dan teks mudah dibaca
Implementasikan dan integrasikan komponen berikut ke dalam halaman:
<!-- Sidebar nav — bar.js isi otomatis -->
<ul id="sipandu-sidebar-nav" class="menu p-4 gap-1"></ul>

<!-- Judul halaman di topbar — otomatis diisi -->
<h1 id="sipandu-page-title"></h1>

<!-- Tombol Mode Malam/Siang -->
<button id="sipandu-theme-toggle" class="btn btn-outline btn-sm gap-2">
  <span class="material-icons" id="sipandu-theme-icon">dark_mode</span>
  <span id="sipandu-theme-label">Mode Malam</span>
</button>

<!-- Drawer toggle mobile -->
<input id="main-drawer" type="checkbox" class="drawer-toggle" />

Lalu:
Rombak ulang layout dan UI/UX secara menyeluruh
Gunakan struktur yang konsisten dan sederhana
Pastikan responsif (mobile-first)
Minimalkan dependency yang tidak perlu
Output yang saya inginkan:
Berikan langsung full code lengkap (HTML, CSS, dan JS jika ada)
Tidak perlu penjelasan panjang
Pastikan code siap pakai tanpa perlu banyak penyesuaian lagi, berikut adalah code nya: