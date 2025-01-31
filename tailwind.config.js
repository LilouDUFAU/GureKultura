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
      principal : {
        rouge : '#A30000', //Pour les appels à l’action (CTA), boutons, titres forts.
        vert : '#165B33',  //Pour les éléments d’accentuation et certaines zones interactives.
        blanc : '#F4F1DE',  //Fond principal pour un rendu sobre et élégant.
        gris : '#3E3E3E',  //Texte, icônes et éléments discrets.
        doré : '#D4A373',  //Pour les événements premium et mises en avant.
      },
      secondaire : {
        rouge : '#B35A30',  //Pour les appels à l’action (CTA), boutons, titres forts.
        vert : '#819D75',  //Pour les éléments d’accentuation et certaines zones interactives.
        blanc : '#E8D8C4',  //Fond principal pour un rendu sobre et élégant.
        gris : '#D9D9D9',  //Texte, icônes et éléments discrets.
        bleu : '#5E7480',  //Pour les événements premium et mises en avant.
      },
      white: '#ffffff',
      black: '#000000',
      gray: {
        100: '#f5f5f5',
        200: '#eeeeee',
        300: '#e0e0e0',
        400: '#bdbdbd',
        500: '#9e9e9e',
        600: '#757575',
        700: '#616161',
        800: '#424242',
        900: '#212121',
      },
      link: '#0000FF',
    },
    extend: {},
  },
  plugins: [],
}
