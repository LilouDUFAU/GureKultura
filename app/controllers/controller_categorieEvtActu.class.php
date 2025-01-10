<?php 

class ControllerCategorieEvtActu extends Controller {

    public function __construct(\Twig\Environment $twig, \Twig\Loader\FileSystemLoader $loader) {
        parent::__construct($twig, $loader);
    }

    public function afficher() {
        echo "afficher categorie de l'evenement ou de l'actualite";
    }

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