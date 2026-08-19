/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                display: ['Fraunces', 'serif'],
                sans: ['Inter', 'sans-serif'],
            },
        },
    },

    plugins: [
        require('daisyui'),
    ],

    daisyui: {
        themes: [
            /*
            |--------------------------------------------------------------------------
            | Tema Terang
            |--------------------------------------------------------------------------
            */

            'light',
            'corporate',
            'cupcake',
            'emerald',
            'bumblebee',
            'retro',
            'cyberpunk',
            'valentine',
            'aqua',
            'pastel',
            'nord',
            'lofi',
            'lemonade',
            'winter',
            'garden',
            'silk',

            /*
            |--------------------------------------------------------------------------
            | Tema Gelap
            |--------------------------------------------------------------------------
            */

            'night',
            'dark',
            'dracula',
            'synthwave',
            'forest',
            'halloween',
            'luxury',
            'black',
            'coffee',
            'business',
            'dim',
            'sunset',

            /*
            |--------------------------------------------------------------------------
            | Tema Default SiPANDU / MMG Brand
            |--------------------------------------------------------------------------
            */

            {
                mmgas: {
                    primary: '#0D3B6E',
                    'primary-content': '#ffffff',

                    secondary: '#1565C0',
                    'secondary-content': '#ffffff',

                    accent: '#F97316',
                    'accent-content': '#ffffff',

                    neutral: '#1E293B',
                    'neutral-content': '#ffffff',

                    'base-100': '#F8FAFC',
                    'base-200': '#EFF6FF',
                    'base-300': '#DBEAFE',
                    'base-content': '#0F172A',

                    info: '#38BDF8',
                    'info-content': '#082F49',

                    success: '#22C55E',
                    'success-content': '#052E16',

                    warning: '#FACC15',
                    'warning-content': '#422006',

                    error: '#EF4444',
                    'error-content': '#FFFFFF',
                },
            },

            /*
            |--------------------------------------------------------------------------
            | Tema Resmi SiPANDU Warm Editorial
            |--------------------------------------------------------------------------
            |
            | Ini menyesuaikan landing page olive, gold, cream,
            | dan Fraunces yang Anda buat sebelumnya.
            |
            */

            {
                sipandu: {
                    primary: '#3D4A2F',
                    'primary-content': '#FFFFFF',

                    secondary: '#A97F34',
                    'secondary-content': '#FFFFFF',

                    accent: '#A97F34',
                    'accent-content': '#FFFFFF',

                    neutral: '#1F2419',
                    'neutral-content': '#FFFFFF',

                    'base-100': '#FAF7F0',
                    'base-200': '#EEF0E3',
                    'base-300': '#F2E6CC',
                    'base-content': '#1F2419',

                    info: '#38BDF8',
                    'info-content': '#082F49',

                    success: '#22C55E',
                    'success-content': '#052E16',

                    warning: '#FACC15',
                    'warning-content': '#422006',

                    error: '#EF4444',
                    'error-content': '#FFFFFF',
                },
            },
        ],

        darkTheme: 'night',

        base: true,
        styled: true,
        utils: true,
        logs: false,
    },
};