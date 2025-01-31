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
     * @function modifierEv
     * @details Fonction permettant de modifier un événement
     * @uses EvenementDao
     * @uses Bd
     * @uses update
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

        $_SESSION['evtActuel'] = $evenementActuel;

        // Rendre le template Twig
        echo $this->getTwig()->render('modifEv.html.twig', [
            'title' => 'Mes événements',
            'actualites' => $actualite,
            'categories' => $categories,
            'evenementActuel' => $evenementActuel
        ]);
    }


    public function validerFormModifEv()
    {
        // Vérifier si l'utilisateur est connecté
        if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
        
            // definition des regles de validations que l'on souhaite verifier pour chaque champs du formulaire
            $regleValidation = [
                'titre' => [
                    'obligatoire' => true,
                    'type' => 'string',
                    'longueurMin' => 5,
                    'longueurMax' => 100,
                    'format' => '/^[a-zA-Z0-9\s]+$/'
                ],
                'cateId' => [
                    'obligatoire' => true,
                    'type' => 'integer',
                    'longueurMin' => 1,
                    'longueurMax' => 100,
                    'format' => '/^[a-zA-Z0-9\s]+$/'
                ],
                'autorisation' => [
                    'obligatoire' => false,
                    'type' => '.pdf ,.jpg, .jpeg, .png',
                    'format' => '/^[a-zA-Z0-9\s]+$/'
                ],
                'email' => [
                    'obligatoire' => true,
                    'type' => 'email',
                    'longueurMin' => 10,
                    'longueurMax' => 100,
                    'format' => FILTER_VALIDATE_EMAIL
                ],
                'tel' => [
                    'obligatoire' => true,
                    'type' => 'string',
                    'longueurMin' => 10,
                    'longueurMax' => 14,
                    'format' => '^0\d(\s|-)?(\d{2}(\s|-)?){4}$'
                ],
                'nomRep' => [
                    'obligatoire' => true,
                    'type' => 'string',
                    'longueurMin' => 2,
                    'longueurMax' => 100,
                    'format' => '/^[a-zA-Z0-9\s]+$/'
                ],
                'prenomRep' => [
                    'obligatoire' => true,
                    'type' => 'string',
                    'longueurMin' => 2,
                    'longueurMax' => 100,
                    'format' => '/^[a-zA-Z0-9\s]+$/'
                ],
                'description' => [
                    'obligatoire' => true,
                    'type' => 'string',
                    'longueurMin' => 30,
                    'longueurMax' => 500,
                    'format' => '/^[a-zA-Z0-9\s]+$/'
                ],
                'debutDate' => [
                    'obligatoire' => true,
                    'type' => 'string',
                    'longueurExacte' => 10,
                    'format' => '/^\d{4}-\d{2}-\d{2}$/'
                ],
                'finDate' => [
                    'obligatoire' => true,
                    'type' => 'string',
                    'longueurExacte' => 10,
                    'format' => '/^\d{4}-\d{2}-\d{2}$/'
                ],
                'debutHeure' => [
                    'obligatoire' => true,
                    'type' => 'string',
                    'longueurExacte' => 5,
                    'format' => '/^\d{2}:\d{2}$/'
                ],
                'finHeure' => [
                    'obligatoire' => true,
                    'type' => 'string',
                    'longueurExacte' => 5,
                    'format' => '/^\d{2}:\d{2}$/'
                ],
                'lieu' => [
                    'obligatoire' => true,
                    'type' => 'string',
                    'longueurMin' => 5,
                    'longueurMax' => 100,
                    'format' => '/^[a-zA-Z0-9\s]+$/'
                ],
                'photo' => [
                    'obligatoire' => false,
                    'type' => 'string',
                    'longueurMin' => 5,
                    'longueurMax' => 100,
                    'format' => '/^[a-zA-Z0-9\s]+$/'
                ]
            ];

            // instanciation de la classe de validation
            $validator = new Validator($regleValidation);

            // recuperation des donnees du formulaire
            $donnees = $_POST;

            // Gestion du fichier autorisation
            if (isset($_FILES['autorisation']) && $_FILES['autorisation']['error'] == 0) {
                // Vérification de la validité du fichier
                $autorisationTmpName = $_FILES['autorisation']['tmp_name'];
                $autorisationName = $_FILES['autorisation']['name'];

                // Ajouter un timestamp au nom de l'autorisation pour s'assurer qu'elle ait un nom unique
                $timestamp = time();
                $autorisationName = pathinfo($autorisationName, PATHINFO_FILENAME) . '_' . $timestamp . '.' . pathinfo($autorisationName, PATHINFO_EXTENSION);
            }

            // Gestion du fichier photo
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
                // Vérification de la validité du fichier
                $photoTmpName = $_FILES['photo']['tmp_name'];
                $photoName = $_FILES['photo']['name'];

                // Ajouter un timestamp au nom de la photo pour s'assurer qu'elle ait un nom unique
                $timestamp = time();
                $photoName = pathinfo($photoName, PATHINFO_FILENAME) . '_' . $timestamp . '.' . pathinfo($photoName, PATHINFO_EXTENSION);
            }

            // recuperer seulement les 5 premiers caracteres de heure debut et fin
            $donnees['debutHeure'] = substr($donnees['debutHeure'], 0, 5);
            $donnees['finHeure'] = substr($donnees['finHeure'], 0, 5);

            // si l'id de la categorie n'est pas defini, alors on recupere celui de la variable de session evenementActuel
            
            if (empty($donnees['cateId'])) {
                $donnees['cateId'] = $_SESSION['evtActuel']['categorieId'];
            }

            // boucle de nettoyage des donnees 
            foreach ($donnees as $key => $value) {
                $donnees[$key] = htmlentities($value);
            }
            $user = $_SESSION['user'];
            $donnees['userId'] = $user->getUserId();

            if (isset($_FILES['autorisation']) && $_FILES['autorisation']['error'] == 0) {
                // Ajoute les données de l'autorisation dans $donnees
                $donnees['autorisationName'] = $autorisationName;
            } else {
                $donnees['autorisationName'] = null;
            }

            if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
                // Ajoute les données de la photo dans $donnees
                $donnees['photoName'] = $photoName;
            } else {
                $donnees['photoName'] = null;
            }


            // validation des donnees du formulaire
            $donneesValides = $validator->valider($donnees);

            if (!$donneesValides) {
                var_dump($donneesValides);
                $messageErreurs = $validator->getMessageErreurs();
            }
            else{
                // verifier quel champ a ete modifie + recuperer la valeur du champ modifie avec un switch case
                if ($donnees['titre'] != $_SESSION['evtActuel']['titre']) {
                    $titreModifie = true;
                }
                else{
                    $titreModifie = false;
                }
                if ($donnees['cateId'] != $_SESSION['evtActuel']['categorieId']) {
                    $categorieModifie = true;
                }
                else{
                    $categorieModifie = false;
                }

                if ($donnees['autorisationName'] != $_SESSION['evtActuel']['autorisation'] && $donnees['autorisationName'] != null) {
                    $autorisationModifie = true;
                }
                else{
                    $autorisationModifie = false;
                }

                if ($donnees['email'] != $_SESSION['evtActuel']['email']) {
                    $emailModifie = true;
                }
                else{
                    $emailModifie = false;
                }

                if ($donnees['tel'] != $_SESSION['evtActuel']['tel']) {
                    $telModifie = true;
                }
                else{
                    $telModifie = false;
                }

                if ($donnees['nomRep'] != $_SESSION['evtActuel']['nomRep']) {
                    $nomRepModifie = true;
                }
                else{
                    $nomRepModifie = false;
                }

                if ($donnees['prenomRep'] != $_SESSION['evtActuel']['prenomRep']) {
                    $prenomRepModifie = true;
                }
                else{
                    $prenomRepModifie = false;
                }

                if ($donnees['description'] != $_SESSION['evtActuel']['description']) {
                    $descriptionModifie = true;
                }
                else{
                    $descriptionModifie = false;
                }

                if ($donnees['debutDate'] != $_SESSION['evtActuel']['dateDebut']) {
                    $debutDateModifie = true;
                }
                else{
                    $debutDateModifie = false;
                }

                if ($donnees['finDate'] != $_SESSION['evtActuel']['dateFin']) {
                    $finDateModifie = true;
                }
                else{
                    $finDateModifie = false;
                }

                if ($donnees['debutHeure'] != $_SESSION['evtActuel']['heureDebut']) {
                    $debutHeureModifie = true;
                }
                else{
                    $debutHeureModifie = false;
                }

                if ($donnees['finHeure'] != $_SESSION['evtActuel']['heureFin']) {
                    $finHeureModifie = true;
                }
                else{
                    $finHeureModifie = false;
                }

                if ($donnees['lieu'] != $_SESSION['evtActuel']['lieu']) {
                    $lieuModifie = true;
                }
                else{
                    $lieuModifie = false;
                }

                if ($donnees['photoName'] != $_SESSION['evtActuel']['photo'] && $donnees['photoName'] != null) {
                    $photoModifie = true;
                }
                else{
                    $photoModifie = false;
                }  
            }

            // recuperation des erreurs

            // Rendre le template Twig
            $pdo = Bd::getInstance()->getPdo();

            $loader = new \Twig\Loader\FilesystemLoader('../templates');
            $twig = new \Twig\Environment($loader);

            $managerActualite = new ActualiteDao($this->getPdo());
            $actualite = $managerActualite->findAllWithCategorie();

            $managerCategorie = new CategorieDao($this->getPdo());
            $categories = $managerCategorie->findAll();

            if (!empty($messageErreurs)) {
                var_dump($messageErreurs);
                // Les données ne sont pas valides, affichez les erreurs
                echo $this->getTwig()->render('modifEv.html.twig', [
                    'title' => 'Proposition d\'événement',
                    'messageErreurs' => $messageErreurs,
                    'donnees' => $donnees,
                    'actualites' => $actualite,
                    'categories' => $categories

                ]);
            } else {

                if (isset($_FILES['autorisation']) && $_FILES['autorisation']['error'] == 0){
                    // L'autorisation est valide, et est donc uploadée dans asset/evenement/autorisation/
                    $cheminAutorisation = '../asset/evenement/autorisation/' . basename($autorisationName);
                    move_uploaded_file($autorisationTmpName, $cheminAutorisation);
                }

                if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0){
                    // La photo est valide, et est donc uploadée dans asset/evenement/photo/
                    $cheminPhoto = '../asset/evenement/photo/' . basename($photoName);
                    move_uploaded_file($photoTmpName, $cheminPhoto);
                }

                if ($titreModifie) {
                    $this->modifierDonneesDansLaBase($donnees['titre'], 'titre');
                }
                if ($categorieModifie) {
                    $this->modifierDonneesDansLaBase($donnees['cateId'], 'cateId');
                }
                if ($autorisationModifie) {
                    $this->modifierDonneesDansLaBase($donnees['autorisationName'], 'autorisation');
                }
                if ($emailModifie) {
                    $this->modifierDonneesDansLaBase($donnees['email'], 'email');
                }
                if ($telModifie) {
                    $this->modifierDonneesDansLaBase($donnees['tel'], 'tel');
                }
                if ($nomRepModifie) {
                    $this->modifierDonneesDansLaBase($donnees['nomRep'], 'nomRep');
                }
                if ($prenomRepModifie) {
                    $this->modifierDonneesDansLaBase($donnees['prenomRep'], 'prenomRep');
                }
                if ($descriptionModifie) {
                    $this->modifierDonneesDansLaBase($donnees['description'], 'description');
                }
                if ($debutDateModifie) {
                    $this->modifierDonneesDansLaBase($donnees['debutDate'], 'dateDebut');
                }
                if ($finDateModifie) {
                    $this->modifierDonneesDansLaBase($donnees['finDate'], 'dateFin');
                }
                if ($debutHeureModifie) {
                    $this->modifierDonneesDansLaBase($donnees['debutHeure'], 'heureDebut');
                }
                if ($finHeureModifie) {
                    $this->modifierDonneesDansLaBase($donnees['finHeure'], 'heureFin');
                }
                if ($lieuModifie) {
                    $this->modifierDonneesDansLaBase($donnees['lieu'], 'lieu');
                }
                if ($photoModifie) {
                    $this->modifierDonneesDansLaBase($donnees['photoName'], 'photo');
                }

                $manager = new EvenementDao($pdo);
                $evenement = $manager->findEventById($_SESSION['evtActuel']['id']);

                header('Location: index.php?controlleur=mesEv&methode=lister');
            }
        } else {
            header('Location: index.php?controlleur=connexion&methode=lister');
        }
    }

    public function modifierDonneesDansLaBase(string $donnees, string $champ){
        try{
            $pdo = Bd::getInstance()->getPdo();
            $managerEvenement = new EvenementDao($pdo);

            $managerEvenement->update($donnees, $champ, $_SESSION['evtActuel']['id']);

            // redirection vers la page de l'événement
            // header('Location: index.php?controlleur=mesEv&methode=lister');
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }
}