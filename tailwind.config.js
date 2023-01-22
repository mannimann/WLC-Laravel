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
        primary: "#ff8d00",
        secondary: "#252832",
        primarybg: "#7395AE",
        secondarybg: "#557994",
        secondary2bg: "#557994",

        // primary: "#D4814B",
        // // primary: "#ffa500",
        // secondary: "#252832",
        // primarybg: "#9ebdc7",
        // secondarybg: "#c9dae0",
        // secondary2bg: "#6c9bab", // #538191

        primary_dark: "#ff8d00",
        secondary_dark: "#a1a2a3",
        primarybg_dark: "#1e2e3e",
        secondarybg_dark: "#0e141b",
      },
    },
    fontSize: {
      sm: "1rem",
      base: "1.20rem",
      xl: "1.563rem",
      "2xl": "1.953rem",
      "3xl": "2.441rem",
      "4xl": "3.052rem",
      "5xl": "3.5rem",
    },
  },

  plugins: [require("@tailwindcss/forms")],
};
