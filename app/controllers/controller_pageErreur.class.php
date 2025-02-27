<?php

/**
 * @class ControllerPageErreur
 * @extends parent<Controller>
 * @details Permet de gérer les erreurs et afficher une page d'erreur avec un message dynamique.
 */
class ControllerPageErreur extends Controller
{
    /**
     * @constructor ControllerPageErreur
     * @details Constructeur de la classe ControllerPageErreur
     * @param Twig\Environment $twig
     * @param Twig\Loader\FileSystemLoader $loader
     * @return void
     */
    public function __construct(\Twig\Environment $twig, \Twig\Loader\FileSystemLoader $loader)
    {
        parent::__construct($twig, $loader);
    }

    /**
     * @function lister
     * @details Fonction permettant d'afficher la page d'erreur avec un message personnalisé.
     * @param string|null $errorMessage Message d'erreur à afficher (optionnel).
     * @return void
     */
    public function lister($errorMessage = "Une erreur inconnue est survenue.")
    {
        
        $pdo = Bd::getInstance()->getPdo();
        $managerCategorie = new CategorieDao($this->getPdo());
        $categorie = $managerCategorie->findAll();
        echo $this->getTwig()->render('pageErreur.html.twig', [
            'title' => 'Erreur',
            'errorMessage' => $errorMessage,
            'categories' => $categorie
        ]);
    }
}
