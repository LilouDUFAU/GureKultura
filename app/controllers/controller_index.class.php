<?php

class ControllerIndex extends Controller
{
    public function __construct(\Twig\Environment $twig, \Twig\Loader\FileSystemLoader $loader)
    {
        parent::__construct($twig, $loader);
    }

    public function afficher()
    {
        echo "afficher connexion";
    }

    public function lister()
    {
        $pdo = Bd::getInstance()->getPdo();

        $loader = new \Twig\Loader\FilesystemLoader('../templates');
        $twig = new \Twig\Environment($loader);

        $managerActualite = new ActualiteDao($this->getPdo());
        $actualite = $managerActualite->findAll();
        $managerEvenement = new EvenementDao($this->getPdo());
        $events = $managerEvenement->findAllWithCategorie();

        // Rendre le template Twig
        echo $this->getTwig()->render('index.html.twig', [
            'title' => 'Accueil',
            // 'description' => 'un site de gestion evenementielle au Pays Basque du Groupe 7'
            'events' => $events,
            'actualites' => $actualite,


        ]);
    }
}