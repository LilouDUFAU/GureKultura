<?php

/**
 * @class ControllerFiltre
 * @extends parent<Controller>
 * @details Permet de gérer les actions liées aux filtres d'événements et d'actualités
 */
class ControllerPolConf extends Controller {

    public function lister() {
        // Connexion PDO
        $pdo = Bd::getInstance()->getPdo();
    

        // Récupérer les catégories disponibles et leurs sous-catégories
        // $managerCategorie = new CategorieDao($pdo);
        // $categories = $managerCategorie->findAll();
        
        // $managerActualite = new ActualiteDao($this->getPdo());
        // $actualite = $managerActualite->findAllWithCategorie();    

        
        // $managerEvenement = new EvenementDao($this->getPdo());
        // $evenement = $managerEvenement->findAllWithCategorie();    

        // Rendre le template Twig avec les événements, actualités et catégories filtrées
        echo $this->getTwig()->render('polConf.html.twig', [
            'title' => 'Politique de confidentialité',
        ]);
    }    
}