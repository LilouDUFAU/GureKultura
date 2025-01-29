<?php

/**
 * @class ControllerFiltre
 * @extends parent<Controller>
 * @details Permet de gérer les actions liées aux filtres d'événements et d'actualités
 */
class ControllerFiltre extends Controller {

    public function lister() {
        // Connexion PDO
        $pdo = Bd::getInstance()->getPdo();
    
        // Récupérer les catégories filtrées depuis la requête GET
        $categories = isset($_GET['category']) ? $_GET['category'] : [];
    
        // Préparer la condition de filtre en fonction des catégories choisies
        $eventCondition = "";
        if (!empty($categories)) {
            $eventCondition = " AND cate.nom IN (" . implode(", ", array_map(function($cat) {
                return "'" . $cat->getNom() . "'";  // Utiliser le getter pour 'nom'
            }, $categories)) . ")";
        }
    
        // Récupérer les événements filtrés
        $sqlEvents = "SELECT evtId, titre, photo, lieu, dateDebut, dateFin FROM gk_evenement WHERE 1=1" . $eventCondition;
        $stmtEvents = $pdo->prepare($sqlEvents);
        $stmtEvents->execute();
        $events = $stmtEvents->fetchAll(PDO::FETCH_ASSOC);
    
        // Récupérer les actualités filtrées
        $sqlActualites = "SELECT * FROM gk_actualite WHERE 1=1" . $eventCondition;
        $stmtActualites = $pdo->prepare($sqlActualites);
        $stmtActualites->execute();
        $actualites = $stmtActualites->fetchAll(PDO::FETCH_ASSOC);
    
        // Récupérer les catégories disponibles et leurs sous-catégories
        $managerCategorie = new CategorieDao($pdo);
        $categoriesDisponibles = $managerCategorie->findAll();
    
        // Séparer les catégories principales (Sport, Culture) des sous-catégories
        $sportCategories = array_filter($categoriesDisponibles, function($cat) {
            return $cat->getCategorieOriginale() == 1;  // Sport
        });
    
        $cultureCategories = array_filter($categoriesDisponibles, function($cat) {
            return $cat->getCategorieOriginale() == 2;  // Culture
        });
    
        // Rendre le template Twig avec les événements, actualités et catégories filtrées
        echo $this->getTwig()->render('filtre.html.twig', [
            'events' => $events,
            'actualites' => $actualites,
            'categories' => $categories,
            'sportCategories' => $sportCategories,
            'cultureCategories' => $cultureCategories
        ]);
    }    
}
