<?php 

/**
 * @class ControllerCategorie
 * @extends parent<Controller>
 * @details Permet de gérer les actions liées à la page "categorie"
 */
class ControllerCategorie extends Controller {

    /**
     * @constructor ControllerCategorie
     * @details Constructeur de la classe ControllerCategorie
     * @param Twig\Environment $twig
     * @param Twig\Loader\FileSystemLoader $loader
     * @details Constructeur de la classe ControllerCategorie
     * @return void
     */
    public function __construct(\Twig\Environment $twig, \Twig\Loader\FileSystemLoader $loader) {
        parent::__construct($twig, $loader);
    }  


    /**
     * @function lister
     * @details Fonction permettant d'afficher la page "Catégorie"
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
        $evtSport = $managerCategorie->findEvtSport();
        $evtCult = $managerCategorie->findEvtCult();
        $actuSport = $managerCategorie->findActuSport();
        $actuCult = $managerCategorie->findActuCult();

        // Rendre le template Twig
        echo $this->getTwig()->render('categorie.html.twig', [
            'title' => 'Categorie',
            'actualites' => $actualite,
            'categories' => $categorie,
            'EvtSport' => $evtSport,
            'EvtCult' => $evtCult,
            'ActuSport' => $actuSport,
            'ActuCult' => $actuCult,
        ]);
    }   
}