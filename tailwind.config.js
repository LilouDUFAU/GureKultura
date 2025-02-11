/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./**/*.twig", "./**/*.php"],
  theme: {
    screens: {
      'sm': '640px',
      // => @media (min-width: 640px) { ... }

      'md': '768px',
      // => @media (min-width: 768px) { ... }

      'lg': '1024px',
      // => @media (min-width: 1024px) { ... }

      'xl': '1280px',
      // => @media (min-width: 1280px) { ... }

      '2xl': '1536px',
      // => @media (min-width: 1536px) { ... }
    },
    colors: {
      transparent: 'transparent',
      bg : '#F6E8EA', //couleur du bg principal
      fh : '#A23145', //couleur de fond pour header et footer
      text : '#651F2B', //couleur du text (paragraphe etc)
      title : '#651F2B', //couleur des titres
      button : '#932D3F', //couleur des boutons
      hbutton : '#7A2534', //couleur du hover des boutons
      card : '#B96473', //couleur pour le fond des cartes evt et actu
      form : '#B96473', //couleur pour le fond des formulaires
      link: '#0000FF', //couleur pour les liens (bleu)
      white: '#ffffff', //blanc
      black: '#000000', //noir
    },
    extend: {},
  },
  plugins: [],
}
