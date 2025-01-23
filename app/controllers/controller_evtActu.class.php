<?php 

/**
 * @class ControllerEvtActu
 * @extends parent<Controller>
 * @details Permet de gérer les actions liées à la page "evtActu"
 */
class ControllerEvtActu extends Controller {

    /**
     * @constructor ControllerEvtActu
     * @details Constructeur de la classe ControllerEvtActu
     * @param Twig\Environment $twig
     * @param Twig\Loader\FileSystemLoader $loader
     * @return void
     */
    public function __construct(\Twig\Environment $twig, \Twig\Loader\FileSystemLoader $loader) {
        parent::__construct($twig, $loader);
    }


    /**
     * @function lister
     * @details Fonction permettant d'afficher la page "evtActu"
     * @uses ActualiteDao
     * @uses EvenementDao
     * @uses Bd
     * @uses findAllWithCategorie
     * @uses find
     * @return void
     */
    public function lister() {
        $pdo = Bd::getInstance()->getPdo();

        $loader = new \Twig\Loader\FilesystemLoader('../templates');
        $twig = new \Twig\Environment($loader);

        $managerActualite = new ActualiteDao($this->getPdo());
        $actualite = $managerActualite->findAllWithCategorie();    

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nom = htmlentities($_POST['nom']);
            $type = htmlentities($_POST['type']);
            $id = htmlentities($_POST['id']);
        }
        
        if ($type == "Evenements"){
            $managerEvtActu = new EvenementDao($pdo);
        } if ($type == "Actualites"){
            $managerEvtActu = new ActualiteDao($pdo);
        }
        $evtActu = $managerEvtActu->find($id);

        // Rendre le template Twig
        echo $this->getTwig()->render('evtActu.html.twig', [
            'title' => $nom,
            'type' => $type,
            'actualites' => $actualite,
            'evtActus' => $evtActu,
        ]);
    }   



    public function inscrire() {
        if (!isset($_POST['evtId']) || !isset($_SESSION['userId'])) {
            $_SESSION['message'] = "Événement ou utilisateur non spécifié.";
            return;
        }
    
        // Ajoutez une ligne de débogage pour vérifier que la méthode est bien appelée
        error_log("Méthode inscrire appelée!");
    
        $eventId = $_POST['evtId'];
        $userId = $_SESSION['userId'];
    
        $evt = new Evenement();
        $evt->setEvtId($eventId);
    
        $inscriptionReussie = $evt->inscrireUtilisateur($userId);
    
        if ($inscriptionReussie) {
            $_SESSION['message'] = "Inscription réussie à l'événement !";
        } else {
            $_SESSION['message'] = "Vous êtes déjà inscrit à cet événement.";
        }
    }
    
    
}