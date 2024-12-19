/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./index.php",
    "./frontend/**/*.php"
  ],
  theme: {
    extend: {
      
    },
    fontFamily: {
       'SF':  'SF-Pro-Text'
    },
    colors: {
      'off-black': '#262626',
      'off-white': '#fafafa',
      'off-gray': '#f2f2f2',
      'off-blue': '#9bcbf7',
      'off-red': '#ec0000',
      'dark-gray': '#ABA5A5',
      'dark-blue': '#3797ef',
      'dark-green': '#0a5a00'
    }
  },
  plugins: [],
}

