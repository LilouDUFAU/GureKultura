<?php

class ControllerInscription extends Controller {
    public function __construct(\Twig\Environment $twig, \Twig\Loader\FileSystemLoader $loader) {
        parent::__construct($twig, $loader);
    }

    public function afficher($twig, $actualite) {
        echo $twig->render('inscription.html.twig', [
            'title' => 'Inscription',
            'actualites' => $actualite
        ]);
    }
}