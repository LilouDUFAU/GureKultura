// Fonction pour initialiser un carrousel
function initCarousel(carouselContainer, nextBtnId, prevBtnId) {
  // Récupération des valeurs par défaut et spécifiques
  const defaultSlidesToShow = parseInt(carouselContainer.getAttribute('data-slides-default'), 10);
  const mobileSlidesToShow = parseInt(carouselContainer.getAttribute('data-slides-mobile'), 10);

  // Gestion dynamique du nombre de slides à afficher
  let slidesToShow = defaultSlidesToShow;
  const carousel = carouselContainer.querySelector('.carousel');
  const slides = carouselContainer.querySelectorAll('.slide');
  const totalSlides = slides.length;
  let currentSlide = 0;

  // Fonction pour mettre à jour slidesToShow en fonction de la taille de l'écran
  function updateSlidesToShow() {
    if (window.matchMedia('(max-width: 768px)').matches) {
      // Taille mobile
      slidesToShow = mobileSlidesToShow;
    } else {
      // Taille écran large (par défaut)
      slidesToShow = defaultSlidesToShow;
    }
  }

  // Appeler la mise à jour au démarrage et lors des changements de taille
  updateSlidesToShow();
  window.addEventListener('resize', updateSlidesToShow);
 
  // Gestion du bouton suivant
  document.getElementById(nextBtnId).addEventListener('click', () => {
    if (currentSlide < totalSlides - slidesToShow) {
      currentSlide += slidesToShow;
    } else {
      currentSlide = 0; // Revenir au début
    }
    updateCarousel();
  });

  // Gestion du bouton précédent
  document.getElementById(prevBtnId).addEventListener('click', () => {
    if (currentSlide > 0) {
      currentSlide -= slidesToShow;
    } else {
      currentSlide = totalSlides - slidesToShow; // Aller à la fin
    }
    updateCarousel();
  });

  function updateCarousel() {
    const slideWidth = slides[0]?.clientWidth || 0; // Largeur d'une diapositive
    carousel.style.transform = `translateX(-${currentSlide * (slideWidth + 8)}px)`;
  }
}

// Initialisation des deux carrousels
initCarousel(document.getElementById('carousel1'), 'next1', 'prev1');
initCarousel(document.getElementById('carousel2'), 'next2', 'prev2');
initCarousel(document.getElementById('carousel3'), 'next3', 'prev3');
initCarousel(document.getElementById('carousel4'), 'next4', 'prev4');

