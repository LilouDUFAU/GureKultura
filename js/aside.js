function adjustGridHeight() {
    console.log('adjustGridHeight');
    // Récupérer les éléments HTML
    const leftColumn = document.getElementById('left-column');
    const rightColumn = document.getElementById('right-column');
    const gridContainer = document.getElementById('grid-container');

    // Calculer la hauteur minimale entre les deux colonnes
    const minHeight = Math.min(leftColumn.offsetHeight, rightColumn.offsetHeight);

    // Appliquer la hauteur minimale à `max-height` de `grid-container`
    leftColumn.style.maxHeight = `${minHeight}px`;
    console.log(rightColumn.offsetHeight);
}

// Ajuster la hauteur au chargement de la page et lors du redimensionnement
window.addEventListener('load', adjustGridHeight);
window.addEventListener('resize', adjustGridHeight);
