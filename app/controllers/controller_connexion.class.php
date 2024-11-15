<?php

class ControllerConnexion extends Controller {
    public function __construct(\Twig\Environment $twig, \Twig\Loader\FileSystemLoader $loader) {
        parent::__construct($twig, $loader);
    }

    public function afficher($twig, $actualite) {
        echo $twig->render('connexion.html.twig', [
                'title' => 'Connexion',
                'actualites' => $actualite
            ]);
    }
}