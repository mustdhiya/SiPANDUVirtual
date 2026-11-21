import './bootstrap';
import { driver } from 'driver.js';
import 'driver.js/dist/driver.css';

function isVisible(el) {
    if (!el) return false;
    const style = window.getComputedStyle(el);
    if (style.display === 'none' || style.visibility === 'hidden' || style.opacity === '0') {
        return false;
    }
    const rect = el.getBoundingClientRect();
    return rect.width > 0 && rect.height > 0;
}

window.startSipanduTour = function (role, config = {}) {
    const isDesktop = window.innerWidth >= 1024;
    const isAdmin = role === 'admin';
    const isPengawas = role === 'pengawas';
    const steps = [];
    const addedElements = new Set();

    const addStep = (el, title, description, side = 'bottom', align = 'center') => {
        if (!el || !isVisible(el) || addedElements.has(el)) return;
        addedElements.add(el);
        steps.push({
            element: el,
            popover: { title, description, side, align },
        });
    };

    // 1. Jika berada di Beranda (memiliki marker data-tour khusus dashboard)
    const welcomeEl = document.querySelector('[data-tour="welcome-card"]');
    const statsEl = document.querySelector('[data-tour="stats-section"]');
    const actionsEl = document.querySelector('[data-tour="primary-actions"]');

    if (welcomeEl || statsEl || actionsEl) {
        addStep(
            welcomeEl,
            'Selamat Datang di SiPANDU VIRTUAL',
            isAdmin
                ? 'Ini adalah Beranda Super Admin & Pengawas. Dari sini Anda memantau semua pengawas, akun, dan laporan triwulan.'
                : isPengawas
                    ? 'Ini adalah Beranda Pengawas PAI. Dari sini Anda memantau guru binaan dan memeriksa laporan triwulan.'
                    : 'Ini adalah Beranda Guru PAI. Dari sini Anda dapat mengunggah dan memantau laporan triwulan Anda.',
            'bottom',
            'start'
        );

        addStep(
            statsEl,
            'Ringkasan Angka Penting',
            'Bagian ini menampilkan ringkasan jumlah tugas, data binaan, atau progres laporan Anda secara cepat.',
            'bottom',
            'center'
        );

        addStep(
            actionsEl,
            'Tombol Pekerjaan Utama',
            isAdmin
                ? 'Tekan tombol besar di sini untuk memeriksa laporan guru, melihat laporan semua pengawas, menyetujui akun baru, atau mengubah kata sandi pengguna.'
                : isPengawas
                    ? 'Tekan tombol besar di sini untuk langsung memeriksa laporan guru binaan, mengunduh rekap, atau membuka Monitoring SIAGA.'
                    : 'Tekan tombol Laporan Triwulan untuk mulai mengunggah berkas wajib, atau gunakan Tanya Pengawas jika butuh bantuan.',
            'top',
            'center'
        );
    } else {
        // 2. Mode Universal untuk SEMUA halaman lain tanpa terkecuali
        const mainEl = document.querySelector('main');
        const headingEl = mainEl ? mainEl.querySelector('h1') : null;
        const pageTitle = headingEl ? headingEl.textContent.trim() : (document.title.split('-')[0] || 'Halaman Ini').trim();

        const headerSection = headingEl ? (headingEl.closest('section') || headingEl.parentElement) : null;
        addStep(
            headerSection || headingEl,
            'Halaman: ' + pageTitle,
            'Di bagian atas ini terdapat judul halaman, ringkasan singkat, serta tombol tindakan utama untuk halaman ' + pageTitle + '.',
            'bottom',
            'start'
        );

        // Deteksi kolom pencarian / filter (GET form)
        const searchForm = mainEl ? mainEl.querySelector('form[method="GET"], form[method="get"]') : null;
        if (searchForm) {
            addStep(
                searchForm,
                'Pencarian & Penyaringan Data',
                'Gunakan kolom ini untuk mencari nama atau menyaring data agar Anda lebih cepat menemukan yang dicari.',
                'bottom',
                'center'
            );
        }

        // Deteksi tabel data utama
        const tableEl = mainEl ? mainEl.querySelector('table') : null;
        const tableWrap = tableEl ? (tableEl.closest('section') || tableEl.parentElement) : null;
        if (tableWrap) {
            addStep(
                tableWrap,
                'Daftar Data di Halaman Ini',
                'Tabel ini menampilkan data secara rapi. Gunakan tombol di sisi kanan tiap baris untuk melihat detail, mengubah, atau mengelola data.',
                'top',
                'center'
            );
        } else {
            // Jika bukan tabel, cek form input (POST/PUT) atau daftar kartu
            const postForm = mainEl ? mainEl.querySelector('form[method="POST"], form[method="post"]') : null;
            if (postForm) {
                addStep(
                    postForm,
                    'Formulir Pengisian Data',
                    'Lengkapi kolom yang bertanda bintang (*) dengan benar, lalu tekan tombol Simpan di bagian bawah formulir.',
                    'top',
                    'center'
                );
            } else {
                const cardsSection = mainEl ? Array.from(mainEl.querySelectorAll('section')).find((s) => s !== headerSection && isVisible(s)) : null;
                if (cardsSection) {
                    addStep(
                        cardsSection,
                        'Isi Utama Halaman',
                        'Pilih kartu atau tombol di bagian ini untuk melanjutkan pekerjaan Anda pada halaman ' + pageTitle + '.',
                        'top',
                        'center'
                    );
                }
            }
        }

        // Deteksi paginasi jika ada
        const paginationEl = mainEl ? mainEl.querySelector('nav[aria-label*="Pagination"], nav[role="navigation"]') : null;
        if (paginationEl) {
            addStep(
                paginationEl,
                'Pindah Halaman (Paginasi)',
                'Jika data lebih dari satu halaman, tekan angka halaman atau tombol Berikutnya di sini.',
                'top',
                'center'
            );
        }
    }

    // 3. Navigasi (Desktop Sidebar / Mobile Bottom Bar)
    if (isDesktop) {
        addStep(
            document.querySelector('[data-tour="sidebar-nav"]'),
            'Menu Navigasi Samping',
            'Semua menu aplikasi tersusun rapi di sisi kiri ini. Cukup klik nama menu yang ingin dibuka.',
            'right',
            'start'
        );
        addStep(
            document.querySelector('[data-tour="font-controls"]'),
            'Perbesar Huruf & Kontras',
            'Jika huruf terasa kecil, tekan A+ untuk memperbesar tulisan atau tekan ikon Kontras agar warna lebih tajam.',
            'bottom',
            'end'
        );
    } else {
        addStep(
            document.querySelector('[data-tour="bottom-nav"]'),
            'Menu Bawah di HP',
            'Saat dibuka di HP, semua menu utama ada di bagian bawah layar ini agar mudah ditekan dengan ibu jari.',
            'top',
            'center'
        );
    }

    // 4. Tombol Tur & Panduan di Header
    addStep(
        document.querySelector('[data-tour="tour-btn"]') || document.querySelector('[data-tour="panduan-btn"]'),
        'Tombol Tur & Panduan Kapan Saja',
        'Anda dapat menekan tombol Tur di atas kapan saja dan di halaman mana saja jika ingin dituntun kembali langkah demi langkah.',
        'bottom',
        'end'
    );

    if (steps.length === 0) return;

    const markCompleted = () => {
        if (config.storageKey) {
            try { localStorage.setItem(config.storageKey, '1'); } catch (e) {}
        }
        if (config.completeUrl && config.csrfToken) {
            fetch(config.completeUrl, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': config.csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({}),
            }).catch(() => {});
        }
    };

    const driverObj = driver({
        showProgress: true,
        animate: true,
        overlayColor: '#000000',
        overlayOpacity: 0.65,
        stagePadding: 10,
        stageRadius: 16,
        progressText: 'Langkah {{current}} dari {{total}}',
        nextBtnText: 'Lanjut →',
        prevBtnText: '← Kembali',
        doneBtnText: 'Selesai',
        allowClose: true,
        popoverClass: 'sipandu-driver-popover',
        steps,
        onDestroyed: markCompleted,
    });

    driverObj.drive();
};

// Jalankan tur otomatis jika halaman meminta (menghindari race condition module script)
window.addEventListener('DOMContentLoaded', () => {
    if (window.__SIPANDU_AUTO_TOUR__ && typeof window.startSipanduTour === 'function') {
        const cfg = window.__SIPANDU_AUTO_TOUR__;
        setTimeout(() => {
            window.startSipanduTour(cfg.role, cfg.options);
        }, 350);
    }
});
