const carousel = document.querySelectorAll('.carousel');
const slides = document.querySelectorAll('.slide');
const slidesToShow = 3; // Nombre de diapositives visibles
const totalSlides = slides.length;
let currentSlide = 0;

document.getElementById('next').addEventListener('click', () => {
  if (currentSlide < totalSlides - slidesToShow) {
    currentSlide += slidesToShow;
  } else {
    currentSlide = 0; // Revenir au début du carrousel
  }
  updateCarousel();
});

document.getElementById('prev').addEventListener('click', () => {
  if (currentSlide > 0) {
    currentSlide -= slidesToShow;
  } else {
    currentSlide = totalSlides - slidesToShow; // Aller à la fin
  }
  updateCarousel();
});

function updateCarousel() {
  const slideWidth = slides[0].clientWidth; // Largeur d'une diapositive
  carousel.style.transform = `translateX(-${currentSlide * slideWidth}px)`;
}
