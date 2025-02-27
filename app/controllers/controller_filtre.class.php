<?php

/**
 * @class ControllerFiltre
 * @extends parent<Controller>
 * @details Permet de gérer les actions liées aux filtres d'événements et d'actualités
 */
class ControllerFiltre extends Controller {
 
    public function ajoutFiltreSession(){
        // Connexion PDO
        $pdo = Bd::getInstance()->getPdo();
    

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if(isset($_POST['listeFiltres'])){
                $strFiltre = htmlentities($_POST['listeFiltres']);
            }
        }
        $filtres = explode(",", $strFiltre);

        // Récupérer les catégories disponibles et leurs sous-catégories
        $managerCategorie = new CategorieDao($pdo);
        $categories = $managerCategorie->findAll();
        

        $managerActualite = new ActualiteDao($this->getPdo());
        $actualite = $managerActualite->findAllWithCategorie();
        $managerEvenement = new EvenementDao($this->getPdo());
        $events = $managerEvenement->findAllWithCategorie();   
        
        if(isset($filtres) && $filtres != ""){
            $_SESSION['filtres'] = $filtres;    
        }
        else{
            $_SESSION['filtres'] = "";
        }
        // Rendre le template Twig
        echo $this->getTwig()->render('index.html.twig', [
            'title' => 'Accueil',
            // 'description' => 'un site de gestion evenementielle au Pays Basque du Groupe 7'
            'events' => $events,
            'actualites' => $actualite,
            'categories' => $categories,
            'filtresSession' => $filtres
        ]);
    }
}