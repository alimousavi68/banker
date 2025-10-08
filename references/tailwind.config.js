/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./index.html", "./src/**/*.{html,js}"],
  theme: {
    extend: {
      colors: {
        primary: "#004A8F",   // آبی اصلی
        secondary: "#CD3737", // قرمز اصلی
        grayText: "#858585",  // خاکستری متن
        lightBg: "#F6F6F6",   // پس‌زمینه روشن
      },
    },
  },
  plugins: [],
};
