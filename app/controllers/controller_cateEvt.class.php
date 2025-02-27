<?php 

/**
 * @class ControllerCategorie
 * @extends parent<Controller>
 * @details Permet de gérer les actions liées à la page "categorie"
 */
class ControllerCateEvt extends Controller {

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
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nom = htmlentities($_POST['nom']);
            $type = htmlentities($_POST['type']);
            $id = htmlentities($_POST['id']);
        }

        $managerActualite = new ActualiteDao($this->getPdo());
        $actualite = $managerActualite->findAllWithCategorie();  
        
        $managerEvenement = new EvenementDao($this->getPdo());
        $evenement = $managerEvenement->findAllWithCategorie();    

        $managerCategorie = new CategorieDao($this->getPdo());
        $categorie = $managerCategorie->findAll();
        
        $evtEnCours = $managerEvenement->findEnCours($id);
        $evtASuivre = $managerEvenement->findAsuivre($id);
        $evtPasser = $managerEvenement->findPasser($id);

        $actuEnCours = $managerActualite->findEnCours($id);
        $actuASuivre = $managerActualite->findAsuivre($id);
        $actuPasser = $managerActualite->findPasser($id);

        // Rendre le template Twig
        echo $this->getTwig()->render('categorieListEvtActu.html.twig', [
            'title' => $nom,
            'actualites' => $actualite,
            'categories' => $categorie,
            'evtsEnCours' => $evtEnCours,
            'evtsASuivre' => $evtASuivre,
            'evtsPasser' => $evtPasser,
            'actusEnCours' => $actuEnCours,
            'actusASuivre' => $actuASuivre,
            'actusPasser' => $actuPasser,
        ]);
    }   
}