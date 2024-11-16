<?php

class ControllerInscription extends Controller {
    public function __construct(\Twig\Environment $twig, \Twig\Loader\FileSystemLoader $loader) {
        parent::__construct($twig, $loader);
    }

    public function afficher() {
        echo "afficher inscription";
    }

    public function lister() {
        $pdo = Bd::getInstance()->getPdo();

        $loader = new \Twig\Loader\FilesystemLoader('../templates');
        $twig = new \Twig\Environment($loader);

        $managerActualite = new ActualiteDao($pdo);
        $actualite = $managerActualite->findAll();
        
        // Rendre le template Twig
        echo $twig->render('inscription.html.twig', [
            'title' => 'Inscription',
            'actualites' => $actualite
        ]);
    }
}