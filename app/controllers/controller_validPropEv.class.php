<?php


/**
 * @class ControllerValidPropEv
 * @extends parent<Controller>
 * @details Permet de gérer les actions liées à la page "de validationd de proposition d'événement"
 */
class ControllerValidPropEv extends Controller
{

    /**
     * @constructor ControllerValidPropEv
     * @details Constructeur de la classe ControllerIndex
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
     * @details Fonction permettant d'afficher la page "validation d'evenement"
     * @uses ActualiteDao
     * @uses EvenementDao
     * @uses Bd
     * @uses findAllWithCategorie
     * @uses findAll
     * @uses findEvtSport
     * @uses findEvtCult
     * @uses findActuSport
     * @uses findActuCult
     * @return void
     */
    public function lister()
    {
        $pdo = Bd::getInstance()->getPdo();

        $loader = new \Twig\Loader\FilesystemLoader('../templates');
        $twig = new \Twig\Environment($loader);

        $managerActualite = new ActualiteDao($this->getPdo());
        $actualite = $managerActualite->findAllWithCategorie();
        $managerEvenement = new EvenementDao($this->getPdo());
        $evenements = $managerEvenement->findNotValid();
        

        // Rendre le template Twig
        echo $this->getTwig()->render('validPropEv.html.twig', [
            'title' => 'Validation de proposition d\'événement',
            // 'description' => 'un site de gestion evenementielle au Pays Basque du Groupe 7'
            'evenements' => $evenements,
            'actualites' => $actualite,
        ]);
    }

    /**
     * @function supprimer
     * @details Fonction permettant de supprimer l'evenement propose
     * @uses EvenementDao
     * @uses Bd
     * @uses delete
     * @return void
     */
    public function supprimer()
    {
        $pdo = Bd::getInstance()->getPdo();
        $managerEvenement = new EvenementDao($pdo);
        $evenement = new Evenement($_POST['evtId']);

        var_dump($evenement);
        $managerEvenement->delete($evenement);
        var_dump($_POST['evtId']);
        header('Location: index.php?controlleur=validPropEv&methode=lister');
    }


    /**
     * @function valider
     * @details Fonction permettant de valider l'evenement propose
     * @uses EvenementDao
     * @uses Bd
     * @uses update
     * @return void
     */
    public function valider()
    {
        $pdo = Bd::getInstance()->getPdo();
        $managerEvenement = new EvenementDao($pdo);
        $evenement = new Evenement($_POST['evtId']);
        $evenement->setISValide(1);
        $managerEvenement->updateValid($evenement);
        header('Location: index.php?controlleur=validPropEv&methode=lister');
    }
}