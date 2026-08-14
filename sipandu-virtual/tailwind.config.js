/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  darkMode: 'class',
  theme: {
    extend: {},
  },
  plugins: [
    require("daisyui"),
  ],
  daisyui: {
    themes: [
      {
        sipandu: {
          ...require("daisyui/src/theming/themes")["light"],
          primary: "#10B981", // Emerald (Kemenag)
          "primary-content": "#ffffff",
          secondary: "#1E3A5F", // Biru Navy
          accent: "#F59E0B",
          neutral: "#1F2937",
          "base-100": "#F8FAFC",
          "base-200": "#F1F5F9",
          "base-300": "#E2E8F0",
          info: "#38BDF8",
          success: "#22C55E",
          warning: "#FACC15",
          error: "#EF4444",
        },
      },
    ],
    base: true,
    styled: true,
    utils: true,
    logs: false,
  },
}