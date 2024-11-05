// Sélectionner l'élément du fil d'Ariane
const breadcrumbContainer = document.getElementById('breadcrumb');

// Récupérer le chemin de l'URL
const path = window.location.pathname.split('/').filter(part => part); // filtre pour exclure les parties vides

// Ajouter le lien "Accueil" au début
breadcrumbContainer.innerHTML += `<li><a href="/">Accueil</a></li>`;

// Parcourir chaque segment du chemin et générer le fil d'Ariane
let pathAccumulator = ''; // Accumulateur pour construire les liens

path.forEach((part, index) => {
    pathAccumulator += `/${part}`; // Construit le lien étape par étape
    const isLast = index === path.length - 1; // Vérifie si c'est le dernier élément

    // Si c'est le dernier élément, on ajoute seulement le texte (pas de lien)
    if (isLast) {
        breadcrumbContainer.innerHTML += `<li>${decodeURIComponent(part)}</li>`;
    } else {
        breadcrumbContainer.innerHTML += `<li><a href="${pathAccumulator}">${decodeURIComponent(part)}</a></li>`;
    }
});
