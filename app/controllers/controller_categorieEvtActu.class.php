<?php 

/**
 * @class ControllerCategorieEvtActu
 * @extends parent<Controller>
 * @details Permet de gérer les actions liées à la page "categorieEvtActu"
 */
class ControllerCategorieEvtActu extends Controller {

    /**
     * @constructor ControllerCategorieEvtActu
     * @details Constructeur de la classe ControllerCategorieEvtActu
     * @param Twig\Environment $twig
     * @param Twig\Loader\FileSystemLoader $loader
     * @return void
     */
    public function __construct(\Twig\Environment $twig, \Twig\Loader\FileSystemLoader $loader) {
        parent::__construct($twig, $loader);
    }


    /**
     * @function lister
     * @details Fonction permettant d'afficher la page "CategorieEvtActu"
     * @uses Bd
     * @uses ActualiteDao
     * @uses EvenementDao
     * @uses findAllWithCategorie
     * @uses findEnCours
     * @uses findAsuivre
     * @uses findPasser
     * @return void
     */
    public function lister() {
        $pdo = Bd::getInstance()->getPdo();

        $loader = new \Twig\Loader\FilesystemLoader('../templates');
        $twig = new \Twig\Environment($loader);

        $managerActualite = new ActualiteDao($this->getPdo());
        $actualite = $managerActualite->findAllWithCategorie();    

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nom = $_POST['nom'];
            $type = $_POST['type'];
            $id = $_POST['id'];
        }
        
        if ($type == "Evenements"){
            $managerEvtActu = new EvenementDao($pdo);
        } if ($type == "Actualites"){
            $managerEvtActu = new ActualiteDao($pdo);
        }
        $evtActuEnCours = $managerEvtActu->findEnCours($id);
        $evtActuASuivre = $managerEvtActu->findAsuivre($id);
        $evtActuPasser = $managerEvtActu->findPasser($id);

        // Rendre le template Twig
        echo $this->getTwig()->render('categorieEvtActu.html.twig', [
            'title' => $nom,
            'type' => $type,
            'actualites' => $actualite,
            'evtActusEnCours' => $evtActuEnCours,
            'evtActusASuivre' => $evtActuASuivre,
            'evtActusPasser' => $evtActuPasser,
        ]);
    }   
}