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
        $estInscrit = false;
        if ($type == "Evenements"){
            $managerEvtActu = new EvenementDao($pdo);

            $user = $_SESSION['user'];
            $managerParticiper = new ParticiperDAO($pdo);
            $participerExist = $managerParticiper->findUserEvt($user->getUserId(), $id);
            if($participerExist == null  || $participerExist == false){
                $estInscrit = false;
            }
            else{
                $estInscrit = true;
            }
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
            'estInscrit' => $estInscrit
        ]);
    }   



    public function inscrire() {
        $pdo = Bd::getInstance()->getPdo();
        
        $user = $_SESSION['user'];
        $userId = $user->getUserId();
    
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nom = htmlentities($_POST['nom']);
            $type = htmlentities($_POST['type']);
            $evtId = htmlentities($_POST['evtId']);
        }

        $evt = new Evenement();
        $evt->setEvtId($evtId);
        $managerEvenement = new EvenementDao($pdo);
        $evtActu = $managerEvenement->find($evtId);
        $managerActualite = new ActualiteDao($this->getPdo());
        $actualite = $managerActualite->findAllWithCategorie();    

        $managerParticiper = new ParticiperDAO($pdo);
        $estInscrit = true;
        $participerExist = $managerParticiper->findUserEvt($userId, $evtId);


        if ($participerExist == null || $participerExist == false) {
            $dateActuelle = new DateTime('now');
            $dateActuelle->format('Y-m-d H:i:s');
            $participer = new Participer(
                $userId,
                $evtId,
                $dateActuelle
            );

            $managerParticiper->insert($participer);
            $estInscrit = true;  
        }
        
    
        // Rendre le template Twig
        echo $this->getTwig()->render('evtActu.html.twig', [
            'title' => $nom,
            'type' => $type,
            'actualites' => $actualite,
            'estInscrit' => $estInscrit,
            'evtActus' => $evtActu 
        ]);
    }
    


    public function desinscrire() {
        $pdo = Bd::getInstance()->getPdo();
        $loader = new \Twig\Loader\FilesystemLoader('../templates');
        $twig = new \Twig\Environment($loader);
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nom = htmlentities($_POST['nom']);
            $type = htmlentities($_POST['type']);
            $evtId = htmlentities($_POST['evtId']);
        }

        $user = $_SESSION['user'];
        $userId = $user->getUserId();

        $managerEvenement = new EvenementDao($pdo);
        $evtActu = $managerEvenement->find($evtId);
        $managerActualite = new ActualiteDao($this->getPdo());
        $actualite = $managerActualite->findAllWithCategorie();    

        $managerParticiper = new ParticiperDAO($pdo);
        $participerExist = $managerParticiper->findUserEvt($userId, $evtId);
        
        if ($participerExist != null) {
            $managerParticiper->delete($participerExist);
            $estInscrit = false;
        } else {
            $estInscrit = true;
        }
    
        // Rendre le template Twig
        echo $this->getTwig()->render('evtActu.html.twig', [
            'title' => $nom,
            'type' => $type,
            'actualites' => $actualite,
            'estInscrit' => $estInscrit,
            'evtActus' => $evtActu 
        ]);
    }
    
    
}