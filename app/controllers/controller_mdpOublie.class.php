<?php 


/**
 * @class ControllerMdpOublie
 * @extends parent<Controller>
 * @details Permet de gérer les actions liées à la page "mdpOublie"
 */
class ControllerMdpOublie extends Controller {

    /**
     * @constructor ControllerMdpOublie
     * @details Constructeur de la classe ControllerMdpOublie
     * @param Twig\Environment $twig
     * @param Twig\Loader\FileSystemLoader $loader
     * @return void
     */
    public function __construct(\Twig\Environment $twig, \Twig\Loader\FileSystemLoader $loader) {
        parent::__construct($twig, $loader);
    }

    /**
     * @function lister
     * @details Fonction permettant d'afficher la page "Mot de passe oublié"
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

        // Rendre le template Twig
        echo $this->getTwig()->render('mdpOublie.html.twig', [
            'title' => 'Mot de passe oublie',
            'actualites' => $actualite
        ]);
    }   
}