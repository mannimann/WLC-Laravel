const defaultTheme = require("tailwindcss/defaultTheme");

/** @type {import('tailwindcss').Config} */
module.exports = {
  darkMode: "class",
  content: [
    "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
    "./storage/framework/views/*.php",
    "./resources/views/**/*.blade.php",
    "./resources/js/**/*.vue",
  ],

  theme: {
    extend: {
      fontFamily: {
        sans: ["Nunito", ...defaultTheme.fontFamily.sans],
      },
      colors: {
        primary: "#CD7100",
        secondary: "#222222",
        primarybg: "#F2FAFF",
        secondarybg: "#e0f2fe",
        primary_dark: "#ff8d00",
        secondary_dark: "#a1a2a3",
        primarybg_dark: "#1e2e3e",
        secondarybg_dark: "#0e141b",
      },
    },
  },

  plugins: [require("@tailwindcss/forms")],
};
