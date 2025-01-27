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
        $pdo = Bd::getInstance()->getPdo();
    
        $loader = new \Twig\Loader\FilesystemLoader('../templates');
        $twig = new \Twig\Environment($loader);
    
        // Vérification de l'événement et de l'utilisateur
        if (!isset($_POST['evtId']) || !isset($_SESSION['userId'])) {
            $_SESSION['message'] = "Événement ou utilisateur non spécifié.";
            // Vous pouvez rediriger ou rendre la page sans inscription ici
           
//            header('Location: index.php?controlleur=index&methode=lister');  // Rediriger vers la page de l'événement
            error_log("evtId: " . (isset($_POST['evtId']) ? $_POST['evtId'] : "Non défini"));
            error_log("userId: " . (isset($_SESSION['userId']) ? $_SESSION['userId'] : "Non défini"));

            exit;
        }
    
        $eventId = $_POST['evtId'];
        $userId = $_SESSION['userId'];
    
        $evt = new Evenement();
        $evt->setEvtId($eventId);
    
        // Essayer d'inscrire l'utilisateur à l'événement
        $inscriptionReussie = $evt->inscrireUtilisateur($userId);
    
        if ($inscriptionReussie) {
            $_SESSION['message'] = "Inscription réussie à l'événement !";
        } else {
            $_SESSION['message'] = "Vous êtes déjà inscrit à cet événement.";
        }
    
        // Rendre le template Twig
        // Vérifiez si vous avez besoin d'afficher des actualités (ici on laisse $actualite vide)
        echo $twig->render('evtActu.html.twig', [
            'title' => 'InscriptionEvt',
            // Si vous avez des actualités à afficher, définissez la variable $actualite avant
            'actualites' => isset($actualite) ? $actualite : null,
        ]);
    }
    
    
    
}