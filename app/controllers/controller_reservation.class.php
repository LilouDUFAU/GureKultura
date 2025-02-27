<?php 

/**
 * @class ControllerReservation
 * @extends parent<Controller>
 * @details Permet de gérer les actions liées à la page "reservation"
 */
class ControllerReservation extends Controller
{
    
    /**
     * @constructor ControllerReservation
     * @details Constructeur de la classe ControllerReservation
     * @param Twig\Environment $twig
     * @param Twig\Loader\FileSystemLoader $loader
     * @return void
     */
    public function __construct(\Twig\Environment $twig, \Twig\Loader\FileSystemLoader $loader) {
        parent::__construct($twig, $loader);
    }

    /**
     * @function lister
     * @details Fonction permettant d'afficher la page "Reservation"
     * @uses ActualiteDao
     * @uses CategorieDao
     * @uses Bd
     * @uses findAllWithCategorie
     * @uses findAll
     * @uses findEvtSport
     * @uses findEvtCult
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
        echo $this->getTwig()->render('reservation.html.twig', [
            'title' => 'Reservation',
            'actualites' => $actualite,
            'categories' => $categorie
        ]); 
    }   
}