<?php
// inclure la classe validator
require_once '../app/controllers/validator.class.php';


/**
 * @class ControllerModifEv
 * @extends parent<Controller>
 * @details Permet de gérer les actions liées à la page "modifEv"
 */
class ControllerModifEv extends Controller
{

    /**
     * @constructor ControllerModifEv
     * @details Constructeur de la classe ControllerModifEv
     * @param Twig\Environment $twig
     * @param Twig\Loader\FileSystemLoader $loader
     * @return void
     */
    public function __construct(\Twig\Environment $twig, \Twig\Loader\FileSystemLoader $loader)
    {
        parent::__construct($twig, $loader);
    }


    /**
     * @function lister
     * @details Fonction permettant d'afficher la page "modif ev" de base
     * @uses ActualiteDao
     * @uses CategorieDao
     * @uses EvenementDao
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
        $evenement = $managerEvenement->findAllWithCategorie();

        // Rendre le template Twig
        echo $this->getTwig()->render('modifEv.html.twig', [
            'title' => 'Modifier mon événement',
            'actualites' => $actualite,
            'categories' => $categories,
            'evenements' => $evenement
        ]);
    }

    /**
     * @function modifier
     * @details Fonction permettant de modifier un événement
     * @uses EvenementDao
     * @uses Bd
     * @uses update
     * @return void
     */
    public function modifier()
    {

    }


    /**
     * @function modifierEv
     * @details Fonction permettant de modifier un événement
     * @uses EvenementDao
     * @uses Bd
     * @uses update
     * @return void
     */
    public function modifierEv()
    {
        $pdo = Bd::getInstance()->getPdo();

        $loader = new \Twig\Loader\FilesystemLoader('../templates');
        $twig = new \Twig\Environment($loader);

        $managerActualite = new ActualiteDao($this->getPdo());
        $actualite = $managerActualite->findAllWithCategorie();

        $managerCategorie = new CategorieDao($this->getPdo());
        $categories = $managerCategorie->findAll();

        $managerEvenement = new EvenementDao($this->getPdo());
        $evenement = $managerEvenement->findEventById($_POST['evtId']);
        $evenementActuel = [];
        $evenementActuel['id'] = $evenement[0]->getEvtId();
        $evenementActuel['titre'] = $evenement[0]->getTitre();
        $evenementActuel['autorisation'] = $evenement[0]->getAutorisation();
        $evenementActuel['email'] = $evenement[0]->getEmail();
        $evenementActuel['tel'] = $evenement[0]->getTel();
        $evenementActuel['nomRep'] = $evenement[0]->getNomRep();
        $evenementActuel['prenomRep'] = $evenement[0]->getPrenomRep();
        $evenementActuel['description'] = $evenement[0]->getDescription();
        $evenementActuel['dateDebut'] = $evenement[0]->getDateDebut();
        $evenementActuel['dateFin'] = $evenement[0]->getDateFin();
        $evenementActuel['heureDebut'] = $evenement[0]->getHeureDebut();
        $evenementActuel['heureFin'] = $evenement[0]->getHeureFin();
        $evenementActuel['lieu'] = $evenement[0]->getLieu();
        $evenementActuel['photo'] = $evenement[0]->getPhoto();
        $evenementActuel['categorie'] = $evenement[0]->getNomCategorie();
        $evenementActuel['categorieId'] = $evenement[0]->getCateId();

        // Rendre le template Twig
        echo $this->getTwig()->render('modifEv.html.twig', [
            'title' => 'Mes événements',
            'actualites' => $actualite,
            'categories' => $categories,
            'evenementActuel' => $evenementActuel
        ]);
    }
}