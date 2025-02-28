<?php

/**
 * @class ControllerFiltre
 * @extends parent<Controller>
 * @details Permet de gérer les actions liées aux filtres d'événements et d'actualités
 */
class ControllerQuiSommesNous extends Controller {

    public function lister() {
        // Connexion PDO
        $pdo = Bd::getInstance()->getPdo();
  

        // Rendre le template Twig avec les événements, actualités et catégories filtrées
        echo $this->getTwig()->render('quiSommesNous.html.twig', [
            'title' => 'Qui sommes nous',
        ]);
    }    
}