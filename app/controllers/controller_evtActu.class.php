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
    
        $loader = new \Twig\Loader\FilesystemLoader('../templates');
        $twig = new \Twig\Environment($loader);
    
    
        $evtId = $_POST['evtId'];
        $user = $_SESSION['user'];
        $userId=$user->getUserId();

        $evt = new Evenement();
        $evt->setEvtId($evtId);
    
        // Essayer d'inscrire l'utilisateur à l'événement
        $managerParticiper = new ParticiperDAO($pdo);
        $estInscrit = true;
        $participerExist = $managerParticiper->findUserEvt($userId, $evtId);
        if($participerExist == null  || $participerExist == false){
            $dateActuelle = new DateTime('now');
            $dateActuelle->format('Y-m-d H:i:s');
            $participer = new Participer(
                $userId,
                $evtId,
                $dateActuelle
            );
            var_dump($participer);
            $managerParticiper->insert($participer);
            $estInscrit = false;
        }
        else{
            $estInscrit = true;
        }

        // Rendre le template Twig
        // Vérifiez si vous avez besoin d'afficher des actualités (ici on laisse $actualite vide)
        echo $twig->render('evtActu.html.twig', [
            'title' => 'InscriptionEvt',
            // Si vous avez des actualités à afficher, définissez la variable $actualite avant
            'actualites' => isset($actualite) ? $actualite : null,
            'estInscrit' => $estInscrit
        ]);
    }


    public function desinscrire() {    
        // Récupérer l'ID de l'utilisateur depuis l'objet 'user' dans la session
        $user = $_SESSION['user'];
        $userId = $user->getUserId();  // Utiliser la méthode appropriée pour récupérer l'ID de l'utilisateur
    
        $eventId = $_POST['evtId'];  // Récupérer l'ID de l'événement depuis le formulaire
    
        // Désinscrire l'utilisateur de l'événement
        $managerParticiper = new ParticiperDAO(Bd::getInstance()->getPdo());
        $participer = $managerParticiper->findUserEvt($userId, $eventId);
    

    

    }
    
}