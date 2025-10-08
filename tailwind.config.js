/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./*.php",
    "./template-parts/**/*.php",
    "./assets/js/**/*.js",
    "./**/*.html"
  ],
  theme: {
    extend: {
      colors: {
        primary: '#004A8F',
        secondary: '#CD3737',
        grayText: '#858585',
        lightBg: '#F6F6F6',
        border: '#CCCCCC',
        black: '#202020'
      },
      fontFamily: {
        'iran': ['IranYekan', 'sans-serif'],
        'iran-num': ['IranYekanFarsiNumber', 'sans-serif']
      }
    },
  },
  plugins: [],
}