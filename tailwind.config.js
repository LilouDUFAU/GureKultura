/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./**/*.twig"],
  theme: {
    extend: {},
  },
  plugins: [
    function ({ addUtilities }) {
      addUtilities({
        '.no-spinner': {
          '-moz-appearance': 'textfield',           /* Firefox */
          '-webkit-appearance': 'none',             /* Chrome, Safari, Opera */
          '&::-webkit-inner-spin-button': {
            '-webkit-appearance': 'none',
            margin: '0',
          },
          '&::-webkit-outer-spin-button': {
            '-webkit-appearance': 'none',
            margin: '0',
          },
        },
      });
    },
  ],
}

