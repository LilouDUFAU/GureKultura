/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./**/*.twig"],
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
    
    extend: {
      colors: {
        bg : '#FDF6EE', //couleur du bg principal
        fh : '#F26B3A', //couleur de fond pour header et footer
        text : '#2C3E50 ', //couleur du text (paragraphe etc)
        title : '#2C3E50 ', //couleur des titres
        button : '#D6453D', //couleur des boutons
        tbutton : '#FDF6EE', //couleur du text des boutons
        hbutton : '#B03A2E', //couleur du hover des boutons
        card : '#F8E9D2', //couleur pour le fond des cartes evt et actu
        form : '#F8E9D2', //couleur pour le fond des formulaires
        carousel : '#F8E9D2', //couleur pour le fond du carousel
        tabtitle : '#F2A67E', //couleur pour les titres des onglets
        odd : '#EADBC8', //couleur pour les lignes impaires
        even : '#F5EDE3', //couleur pour les lignes paires
        link: '#0000FF', //couleur pour les liens (bleu)
        error: '#FF0000', //couleur pour les liens (bleu)
      },
      fontFamily: {
        // fontfamily : poppins
        // 'poppins': ['Poppins', 'sans-serif'],
        // fontfamily : robot
        // 'robot': ['Roboto', 'sans-serif'],


        // fontfamily : sen
        'sen': ['Sen', 'sans-serif'],

      },
    },
  },
  plugins: [],
}
