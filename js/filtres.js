// Ouvrir la popup
function openFilterPopup() {
    document.getElementById('filter-popup').classList.remove('hidden');
}

// Fermer la popup
function closeFilterPopup() {
    document.getElementById('filter-popup').classList.add('hidden');
}

// Appliquer les filtres
function applyFilters() {
    let selectedCategories = [];
    
    // Récupérer les catégories sélectionnées
    document.querySelectorAll('input[name="filter-category"]:checked').forEach(function(checkbox) {
        selectedCategories.push(checkbox.value);
    });

    // Afficher les catégories sélectionnées dans la console (à remplacer par une action côté serveur si nécessaire)
    console.log("Filtres appliqués :", selectedCategories);

    // Fermer la popup après l'application des filtres
    closeFilterPopup();

    // Rediriger avec les paramètres de filtre dans l'URL ou utiliser AJAX pour filtrer sans recharger la page
    let filterParams = new URLSearchParams();
    selectedCategories.forEach(function(category) {
        filterParams.append('category[]', category);
    });

    // Exemple de redirection avec paramètres de filtre
    window.location.href = 'index.php?controlleur=evtActu&methode=lister&' + filterParams.toString();
}
