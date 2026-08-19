@once
    <style>
        .theme-switcher {
            position: fixed;
            right: 1rem;
            bottom: 1rem;
            z-index: 100;
        }

        .theme-switcher-panel {
            width: min(360px, calc(100vw - 2rem));
            max-height: min(620px, calc(100vh - 7rem));
            overflow-y: auto;
        }

        .theme-option {
            transition:
                transform 160ms ease,
                border-color 160ms ease,
                background-color 160ms ease;
        }

        .theme-option:hover {
            transform: translateY(-2px);
        }

        .theme-option.active {
            border-color: hsl(var(--p));
            background-color: hsl(var(--p) / 0.10);
        }

        .theme-color-preview {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            width: 72px;
            height: 28px;
            overflow: hidden;
            border-radius: 0.5rem;
            border: 1px solid hsl(var(--bc) / 0.15);
            flex-shrink: 0;
        }

        .theme-color-preview span {
            display: block;
        }

        .theme-switcher-scroll::-webkit-scrollbar {
            width: 6px;
        }

        .theme-switcher-scroll::-webkit-scrollbar-thumb {
            border-radius: 999px;
            background: hsl(var(--bc) / 0.25);
        }
    </style>

    <div
        id="theme-switcher"
        class="theme-switcher"
        x-data="{ open: false }"
    >
        <div
            id="theme-switcher-panel"
            class="theme-switcher-panel card card-compact bg-base-100 border border-base-300 shadow-2xl mb-3 hidden"
        >
            <div class="card-body">

                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h2 class="card-title text-base">
                            <span class="material-icons text-primary">palette</span>
                            Tampilan Sistem
                        </h2>
                        <p class="text-xs text-base-content/60 mt-1">
                            Pilih tema untuk seluruh halaman aplikasi.
                        </p>
                    </div>

                    <button
                        id="theme-panel-close"
                        type="button"
                        class="btn btn-square btn-ghost btn-sm"
                        aria-label="Tutup pilihan tema"
                    >
                        <span class="material-icons text-base">close</span>
                    </button>
                </div>

                <div class="divider my-1"></div>

                <div class="flex items-center justify-between gap-3">
                    <div>
                        <p class="text-xs text-base-content/60">Tema aktif</p>
                        <p id="active-theme-label" class="font-semibold">
                            Si-Pandu Brand
                        </p>
                    </div>

                    <span id="active-theme-badge" class="badge badge-primary gap-1">
                        <span class="material-icons text-xs">check</span>
                        Aktif
                    </span>
                </div>

                <div
                    id="theme-list"
                    class="theme-switcher-scroll grid grid-cols-1 gap-2 mt-2 pr-1"
                >
                    {{-- Diisi oleh JavaScript --}}
                </div>

                <div class="divider my-1"></div>

                <button
                    id="reset-theme"
                    type="button"
                    class="btn btn-outline btn-sm w-full"
                >
                    <span class="material-icons text-base">restart_alt</span>
                    Kembalikan Tema SiPandu Brand
                </button>
            </div>
        </div>

        <button
            id="theme-switcher-toggle"
            type="button"
            class="btn btn-primary btn-circle shadow-xl"
            aria-label="Buka pilihan tema"
            aria-expanded="false"
            title="Ubah tampilan"
        >
            <span class="material-icons">palette</span>
        </button>
    </div>

    <script>
    (() => {
        const THEMES = [
            {
                id: 'sipandu',
                label: 'SiPANDU Warm',
                dark: false,
                colors: ['#FAF7F0', '#3D4A2F', '#A97F34', '#EEF0E3']
            },
            {
                id: 'mmgas',
                label: 'MMG Brand',
                dark: false,
                colors: ['#F8FAFC', '#0D3B6E', '#1565C0', '#F97316']
            },

            {
                id: 'light',
                label: 'Light',
                dark: false,
                colors: ['#FFFFFF', '#570DF8', '#F000B8', '#37CDBE']
            },
            {
                id: 'corporate',
                label: 'Corporate',
                dark: false,
                colors: ['#FFFFFF', '#4B6BFB', '#7B92B2', '#5C7F67']
            },
            {
                id: 'emerald',
                label: 'Emerald',
                dark: false,
                colors: ['#FFFFFF', '#66CC8A', '#377CFB', '#F3CC30']
            },
            {
                id: 'garden',
                label: 'Garden',
                dark: false,
                colors: ['#E9E7E7', '#5C7F67', '#ECF4E7', '#F472B6']
            },
            {
                id: 'winter',
                label: 'Winter',
                dark: false,
                colors: ['#FFFFFF', '#047AF6', '#170670', '#B9E0F2']
            },
            {
                id: 'nord',
                label: 'Nord',
                dark: false,
                colors: ['#ECEFF4', '#5E81AC', '#81A1C1', '#8FBCBB']
            },
            {
                id: 'silk',
                label: 'Silk',
                dark: false,
                colors: ['#F4F1EA', '#95A374', '#C9C394', '#661122']
            },

            {
                id: 'night',
                label: 'Night',
                dark: true,
                colors: ['#0F172A', '#38BDF8', '#818CF8', '#F472B6']
            },
            {
                id: 'dark',
                label: 'Dark',
                dark: true,
                colors: ['#1D232A', '#661AE6', '#D926AA', '#1FB2A6']
            },
            {
                id: 'dracula',
                label: 'Dracula',
                dark: true,
                colors: ['#282A36', '#FF79C6', '#BD93F9', '#FFB86C']
            },
            {
                id: 'forest',
                label: 'Forest',
                dark: true,
                colors: ['#171212', '#1EB854', '#1DB990', '#115930']
            },
            {
                id: 'business',
                label: 'Business',
                dark: true,
                colors: ['#202020', '#1C4F82', '#7D919B', '#EB6B47']
            },
            {
                id: 'coffee',
                label: 'Coffee',
                dark: true,
                colors: ['#20161F', '#018181', '#115962', '#E0D1B3']
            },
            {
                id: 'luxury',
                label: 'Luxury',
                dark: true,
                colors: ['#09090B', '#FFFFFF', '#152747', '#513448']
            },
            {
                id: 'sunset',
                label: 'Sunset',
                dark: true,
                colors: ['#121C22', '#FF865B', '#FD6F9C', '#B387FA']
            },
        ];

        const DEFAULT_THEME = 'sipandu';
        const STORAGE_KEY = 'sipandu-theme';

        const html = document.documentElement;
        const toggle = document.getElementById('theme-switcher-toggle');
        const panel = document.getElementById('theme-switcher-panel');
        const close = document.getElementById('theme-panel-close');
        const list = document.getElementById('theme-list');
        const reset = document.getElementById('reset-theme');
        const activeLabel = document.getElementById('active-theme-label');

        function getTheme(themeId) {
            return THEMES.find((theme) => theme.id === themeId)
                || THEMES.find((theme) => theme.id === DEFAULT_THEME);
        }

        function getSavedTheme() {
            return localStorage.getItem(STORAGE_KEY)
                || html.dataset.theme
                || DEFAULT_THEME;
        }

        function applyTheme(themeId, persist = true) {
            const theme = getTheme(themeId);

            html.setAttribute('data-theme', theme.id);

            if (persist) {
                localStorage.setItem(STORAGE_KEY, theme.id);
            }

            activeLabel.textContent = theme.label;

            document.querySelectorAll('[data-theme-option]').forEach((option) => {
                const isActive = option.dataset.themeOption === theme.id;

                option.classList.toggle('active', isActive);
                option.setAttribute('aria-checked', isActive ? 'true' : 'false');

                const checkIcon = option.querySelector('.theme-check');

                if (checkIcon) {
                    checkIcon.classList.toggle('hidden', !isActive);
                }
            });
        }

        function renderThemeList() {
            list.innerHTML = THEMES.map((theme) => `
                <button
                    type="button"
                    class="theme-option flex items-center gap-3 rounded-xl border border-base-300 bg-base-100 p-3 text-left"
                    data-theme-option="${theme.id}"
                    role="radio"
                    aria-label="Gunakan tema ${theme.label}"
                    aria-checked="false"
                >
                    <span class="theme-color-preview" aria-hidden="true">
                        ${theme.colors.map((color) => `<span style="background:${color}"></span>`).join('')}
                    </span>

                    <span class="min-w-0 flex-1">
                        <span class="block font-semibold">${theme.label}</span>
                        <span class="block text-xs text-base-content/55">
                            ${theme.dark ? 'Tema gelap' : 'Tema terang'}
                        </span>
                    </span>

                    <span class="material-icons theme-check text-primary hidden text-base">
                        check_circle
                    </span>
                </button>
            `).join('');

            document.querySelectorAll('[data-theme-option]').forEach((option) => {
                option.addEventListener('click', () => {
                    applyTheme(option.dataset.themeOption);
                });
            });
        }

        function openPanel() {
            panel.classList.remove('hidden');
            toggle.setAttribute('aria-expanded', 'true');
        }

        function closePanel() {
            panel.classList.add('hidden');
            toggle.setAttribute('aria-expanded', 'false');
        }

        toggle.addEventListener('click', () => {
            panel.classList.contains('hidden') ? openPanel() : closePanel();
        });

        close.addEventListener('click', closePanel);

        reset.addEventListener('click', () => {
            applyTheme(DEFAULT_THEME);
        });

        document.addEventListener('click', (event) => {
            const widget = document.getElementById('theme-switcher');

            if (widget && !widget.contains(event.target)) {
                closePanel();
            }
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                closePanel();
            }
        });

        renderThemeList();
        applyTheme(getSavedTheme(), false);
    })();
</script>
@endonce