<?php

/**
 * @class ControllerCodeVerif
 * @extends parent <Controller>
 * @details Permet de gérer les actions liées à la page "codeVerif"
 */
class ControllerCodeVerif extends Controller {

    /**
     * @constructor ControllerCodeVerif
     * @details Constructeur de la classe ControllerCodeVerif
     * @param Twig\Environment $twig
     * @param Twig\Loader\FileSystemLoader $loader
     * @return void
     */
    public function __construct(\Twig\Environment $twig, \Twig\Loader\FileSystemLoader $loader) {
        parent::__construct($twig, $loader);
    }


    /**
     * @function lister
     * @details Fonction permettant d'afficher la page "codeVerif"
     * @uses ActualiteDao
     * @uses Bd
     * @uses findAllWithCategorie
     * @return void
     */
    public function lister() {
        $pdo = Bd::getInstance()->getPdo();

        $loader = new \Twig\Loader\FilesystemLoader('../templates');
        $twig = new \Twig\Environment($loader);

        $managerActualite = new ActualiteDao($this->getPdo());
        $actualite = $managerActualite->findAllWithCategorie();

        $managerCategorie = new CategorieDao($this->getPdo());
        $categorie = $managerCategorie->findAll();
        // Rendre le template Twig
        echo $this->getTwig()->render('codeVerif.html.twig', [
            'title' => 'Code Verification',
            'actualites' => $actualite,
            'categories' => $categorie
        ]);
    }
}