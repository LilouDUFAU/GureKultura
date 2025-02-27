<?php


/**
 * @class ControllerIndex
 * @extends parent<Controller>
 * @details Permet de gérer les actions liées à la page "index"
 */
class ControllerIndex extends Controller
{

    /**
     * @constructor ControllerIndex
     * @details Constructeur de la classe ControllerIndex
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
     * @details Fonction permettant d'afficher la page "index"
     * @uses ActualiteDao
     * @uses EvenementDao
     * @uses Bd
     * @uses findAllWithCategorie
     * @uses findAll
     * @uses findEvtSport
     * @uses findEvtCult
     * @uses findActuSport
     * @uses findActuCult
     * @return void
     */
    public function lister()
    {
        $pdo = Bd::getInstance()->getPdo();

        $loader = new \Twig\Loader\FilesystemLoader('../templates');
        $twig = new \Twig\Environment($loader);

        $managerActualite = new ActualiteDao($this->getPdo());
        $actualite = $managerActualite->findAllWithCategorie();
        $managerEvenement = new EvenementDao($this->getPdo());
        $events = $managerEvenement->findAllWithCategorie();
        
        $managerCategorie = new CategorieDao($this->getPdo());
        $categorie = $managerCategorie->findAll();  
        $filtres = "";
        if(!isset($_SESSION['filtres']) || $_SESSION['filtres'] == ""){
            $filtres = "";
        }
        else{
            $filtres = $_SESSION['filtres'] ;
        }
        // Rendre le template Twig
        echo $this->getTwig()->render('index.html.twig', [
            'title' => 'Accueil',
            // 'description' => 'un site de gestion evenementielle au Pays Basque du Groupe 7'
            'events' => $events,
            'actualites' => $actualite,
            'categories' => $categorie,
            'filtresSession' => $filtres,


        ]);
    }
}