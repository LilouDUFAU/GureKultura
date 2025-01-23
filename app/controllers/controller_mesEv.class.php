<?php 

/**
 * @class ControllerMesEv
 * @extends parent<Controller>
 * @details Permet de gérer les actions liées à la page "mesEv"
 */

 class ControllerMesEv extends Controller {


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

        $managerActualite = new ActualiteDao($this->getPdo());
        $actualite = $managerActualite->findAllWithCategorie();

        $managerCategorie = new CategorieDao($this->getPdo());
        $categories = $managerCategorie->findAll();

        $managerEvenement = new EvenementDao($this->getPdo());

        // recuperer les evenements de l'utilisateur connecte
        $user=unserialize($_SESSION['user']);
        $evenement = $managerEvenement->findEventByUser($user->getUserId());


        // Rendre le template Twig
        echo $this->getTwig()->render('mesEv.html.twig', [
            'title' => 'Mes événements',
            'actualites' => $actualite,
            'categories' => $categories,
            'evenements' => $evenement
        ]);
    }  

    /**
     * @function supprimerEvt
     * @details Fonction permettant de supprimer l'evenement de l'utilisateur connecté
     * @uses EvenementDao
     * @uses Bd
     * @uses delete
     * @return void
     */
    public function supprimerEvent()
    {
        $pdo = Bd::getInstance()->getPdo();
        $managerEvenement = new EvenementDao($pdo);
        $evenement = new Evenement($_POST['evtId']);

        var_dump($evenement);
        $managerEvenement->delete($evenement);
        var_dump($_POST['evtId']);
        header('Location: index.php?controlleur=mesEv&methode=lister');
    }
}
