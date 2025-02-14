<?php 

/**
 * @class ControllerMesEv
 * @extends parent<Controller>
 * @details Permet de gérer les actions liées à la page "mesEv"
 */

 class ControllerMesParticipation extends Controller {


    /**
     * @constructor ControllerMesEv
     * @details Constructeur de la classe ControllerMesEv
     * @param Twig\Environment $twig
     * @param Twig\Loader\FileSystemLoader $loader
     * @return void
     */
    public function __construct(\Twig\Environment $twig, \Twig\Loader\FileSystemLoader $loader) {
        parent::__construct($twig, $loader);
    }

        /**
     * @function lister
     * @details Fonction permettant d'afficher la page "Mes evenements" de base
     * @uses ActualiteDao
     * @uses CategorieDao
     * @uses Bd
     * @uses findAllWithCategorie
     * @uses findAll
     * @return void
     */
    public function lister()
    {
        $pdo = Bd::getInstance()->getPdo();

        $loader = new \Twig\Loader\FilesystemLoader('../templates');
        $twig = new \Twig\Environment($loader);

        $managerCategorie = new CategorieDao($this->getPdo());
        $categories = $managerCategorie->findAll();

        $managerEvenement = new EvenementDao($this->getPdo());

        // recuperer les evenements de l'utilisateur connecte
        $user=$_SESSION['user'];
        $evenement = $managerEvenement->findEvtParticipation($user->getUserId());
        // Rendre le template Twig
        echo $this->getTwig()->render('mesParticipation.html.twig', [
            'title' => 'Mes participations',
            'categories' => $categories,
            'evenements' => $evenement
        ]);
    }  

    /**
     * @function desinscrire
     * @details Fonction permettant de se desinscrire l'evenement de l'utilisateur connecté
     * @uses EvenementDao
     * @uses Bd
     * @uses delete
     * @return void
     */
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
        
        if($participerExist != null){
            $managerParticiper->delete($participerExist);
        }
        // Rendre le template Twig
        $this->lister();
    }
}
