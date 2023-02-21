const defaultTheme = require("tailwindcss/defaultTheme");

/** @type {import('tailwindcss').Config} */
module.exports = {
  darkMode: "class",
  content: [
    "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
    "./storage/framework/views/*.php",
    "./resources/views/**/*.blade.php",
    "./resources/js/**/*.vue",
    "./node_modules/flowbite/**/*.js",
  ],

  theme: {
    extend: {
      fontFamily: {
        sans: ["Nunito", ...defaultTheme.fontFamily.sans],
      },
      colors: {
        primary: "#e88915",
        secondary: "#252832",
        primarybg: "#dcf3ff",
        secondarybg: "#EAF8FF",
        secondary2bg: "#a0cff5",

        // Ice-Blue
        // primary: "#257ca3",
        // secondary: "#396d7c",
        // primarybg: "#EAF8FF",
        // secondarybg: "#dcf3ff",
        // secondary2bg: "#dcf3ff",

        // gut, aber Verbesserungswürdig
        // primary: "#e88915",
        // secondary: "#252832",
        // primarybg: "#7395AE",
        // secondarybg: "#557994",
        // secondary2bg: "#557994",

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
      xs: "0.8rem",
      sm: "0.9rem",
      base: "1.15rem",
      md: "1.15rem",
      lg: "1.268rem",
      xl: "1.463rem",
      "2xl": "1.853rem",
      "3xl": "2.341rem",
      "4xl": "2.952rem",
      "5xl": "3.4rem",
    },
  },

  daisyui: {
    themes: [
      {
        myTheme: {
          primary: "#15803d",
          secondary: "#edad1a",
          accent: "#e06902",
          neutral: "#374151",
          "base-100": "#111827",
          info: "#2F7FD0",
          success: "#4FE8A3",
          warning: "#F2C240",
          error: "#E73662",
        },
      },
    ],
  },

  plugins: [
    require("@tailwindcss/forms"),
    require("daisyui"),
    require("flowbite/plugin"),
  ],
};
