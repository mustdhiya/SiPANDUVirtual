/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
  ],
  darkMode: 'class',
  theme: {
    extend: {
      fontFamily: {
        display: ['Fraunces', 'serif'],
        sans: ['Inter', 'sans-serif'],
      },
      borderRadius: {
        card: '1.25rem',
      },
    },
  },
  plugins: [
    require("daisyui"),
  ],
  daisyui: {
    themes: [
      {
        sipandu: {
          "primary": "#3d4a2f",
          "primary-content": "#ffffff",
          "secondary": "#a97f34",
          "secondary-content": "#ffffff",
          "accent": "#a97f34",
          "accent-content": "#ffffff",
          "neutral": "#1f2419",
          "base-100": "#faf7f0",
          "base-200": "#eef0e3",
          "base-300": "#f2e6cc",
          "info": "#38BDF8",
          "success": "#22C55E",
          "warning": "#FACC15",
          "error": "#EF4444",
        },
      },
    ],
    base: true,
    styled: true,
    utils: true,
  },
}