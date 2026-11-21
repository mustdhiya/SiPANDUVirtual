/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],

    theme: {
        screens: {
            xs: '480px',
            sm: '640px',
            md: '768px',
            lg: '1024px',
            xl: '1280px',
            '2xl': '1536px',
        },
        extend: {
            fontFamily: {
                display: ['Inter', 'system-ui', 'sans-serif'],
                sans: ['Inter', 'system-ui', 'sans-serif'],
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
            | Tema Utama SiPANDU (Ramah Lansia - Kontras Tinggi & Nyaman di Mata)
            |--------------------------------------------------------------------------
            */
            {
                sipandu: {
                    primary: '#1E4D2B',
                    'primary-content': '#FFFFFF',

                    secondary: '#8C5A00',
                    'secondary-content': '#FFFFFF',

                    accent: '#0F5132',
                    'accent-content': '#FFFFFF',

                    neutral: '#1A2417',
                    'neutral-content': '#FFFFFF',

                    'base-100': '#FFFFFF',
                    'base-200': '#F2F5EE',
                    'base-300': '#D4DEC9',
                    'base-content': '#141B11',

                    info: '#0369A1',
                    'info-content': '#FFFFFF',

                    success: '#15803D',
                    'success-content': '#FFFFFF',

                    warning: '#B45309',
                    'warning-content': '#FFFFFF',

                    error: '#B91C1C',
                    'error-content': '#FFFFFF',
                },
            },

            /*
            |--------------------------------------------------------------------------
            | Tema Kontras Ekstra (Untuk Penglihatan Lebih Tajam)
            |--------------------------------------------------------------------------
            */
            {
                'sipandu-hc': {
                    primary: '#0B3D1A',
                    'primary-content': '#FFFFFF',

                    secondary: '#7C4A00',
                    'secondary-content': '#FFFFFF',

                    accent: '#004085',
                    'accent-content': '#FFFFFF',

                    neutral: '#000000',
                    'neutral-content': '#FFFFFF',

                    'base-100': '#FFFFFF',
                    'base-200': '#F3F4F6',
                    'base-300': '#9CA3AF',
                    'base-content': '#000000',

                    info: '#004E98',
                    'info-content': '#FFFFFF',

                    success: '#0D652D',
                    'success-content': '#FFFFFF',

                    warning: '#9A3412',
                    'warning-content': '#FFFFFF',

                    error: '#991B1B',
                    'error-content': '#FFFFFF',
                },
            },
        ],

        darkTheme: 'sipandu',

        base: true,
        styled: true,
        utils: true,
        logs: false,
    },
};
