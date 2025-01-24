<?php 

/**
 * @class ControllerMesActu
 * @extends parent<Controller>
 * @details Permet de gérer les actions liées à la page "mesActu"
 */

 class ControllerMesActu extends Controller {


    /**
     * @constructor ControllerMesActu
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
     * @details Fonction permettant d'afficher la page "Mes actualités" de base
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

        $managerCategorie = new CategorieDao($this->getPdo());
        $categories = $managerCategorie->findAll();

        // recuperer les evenements de l'utilisateur connecte
        $user=$_SESSION['user'];
        $actualite = $managerActualite->findActuByUser($user->getUserId());

        // $actuAside = $managerActualite->findAllWithCategorie();

        // Rendre le template Twig
        echo $this->getTwig()->render('mesActu.html.twig', [
            'title' => 'Mes actualités',
            'actualites' => $actualite,
            'categories' => $categories
        ]);
    }  

    /**
     * @function supprimerActu
     * @details Fonction permettant de supprimer l'actualité de l'utilisateur connecté
     * @uses ActualiteDAO
     * @uses Bd
     * @uses delete
     * @return void
     */
    public function supprimerActu()
    {
        $pdo = Bd::getInstance()->getPdo();
        $managerActualite = new ActualiteDAO($pdo);
        $actualite = new Actualite($_POST['actuId']);

        $managerActualite->delete($actualite);
        header('Location: index.php?controlleur=mesActu&methode=lister');
    }
}
