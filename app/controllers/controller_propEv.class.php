<?php
// inclure la classe validator
require_once '../app/controllers/validator.class.php';


/**
 * @class ControllerPropEv
 * @extends parent<Controller>
 * @details Permet de gérer les actions liées à la page "Proposition d'événement"
 */
class ControllerPropEv extends Controller
{

    /**
     * @constructor ControllerPropEv
     * @details Constructeur de la classe ControllerPropEv
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
     * @details Fonction permettant d'afficher la page "Proposition d'événement" de base
     * @uses ActualiteDao
     * @uses CategorieDao
     * @uses Bd
     * @uses findAllWithCategorie
     * @uses findAll
     * @return void
     */
    public function lister()
    {
        if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
            $pdo = Bd::getInstance()->getPdo();

            $loader = new \Twig\Loader\FilesystemLoader('../templates');
            $twig = new \Twig\Environment($loader);

            $managerActualite = new ActualiteDao($this->getPdo());
            $actualite = $managerActualite->findAllWithCategorie();

            $managerCategorie = new CategorieDao($this->getPdo());
            $categories = $managerCategorie->findAll();

            // Rendre le template Twig
            echo $this->getTwig()->render('propEv.html.twig', [
                'title' => 'Proposisition d\'événement',
                'actualites' => $actualite,
                'categories' => $categories
            ]);
        } else {
            // L'utilisateur n'est pas connecté, redirigez-le vers la page de connexion
            header('Location: index.php?controlleur=connexion&methode=lister');
        }
    }


    /**
     * @function validerFormulairePropEv
     * @details Fonction permettant de valider les données du formulaire de la page "Proposition d'événement"
     * @uses Validator
     * @uses EvenementDao
     * @uses CategorieDao
     * @uses Bd
     * @uses findAllWithCategorie
     * @uses findAll
     * @uses insererDonneesDansLaBase
     * @return void
     */
    public function validerFormulairePropEv()
    {

        // verifier si l'utilisateur est connecté
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
                    'type' => '.pdf',
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
                    'longueurMax' => 500,
                    'format' => '/^[a-zA-Z0-9\s]+$/'
                ]
            ];

            // instanciation de la classe de validation
            $validator = new Validator($regleValidation);

            // recuperation des donnees du formulaire
            $donnees = $_POST;
            $user = $_SESSION['user'];
            $donnees['userId'] = $user->getUserId();

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

            $user = $_SESSION['user'];
            $donnees['userId'] = $user->getUserId(); 

            if (isset($_FILES['autorisation']) && $_FILES['autorisation']['error'] == 0) {
            // Ajoute les données de l'autorisation dans $donnees
            $donnees['autorisationName'] = $autorisationName;
            }

            if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
            // Ajoute les données de la photo dans $donnees
            $donnees['photoName'] = $photoName;
            }

            // Validation des donnees du formulaire
            $donneesValides = $validator->valider($donnees);

            if (!$donneesValides) {
                $messageErreurs = $validator->getMessageErreurs();
            }

            // Recuperation des erreurs

            // Rendre le template Twig
            $pdo = Bd::getInstance()->getPdo();

            $loader = new \Twig\Loader\FilesystemLoader('../templates');
            $twig = new \Twig\Environment($loader);

            $managerActualite = new ActualiteDao($this->getPdo());
            $actualite = $managerActualite->findAllWithCategorie();

            $managerCategorie = new CategorieDao($this->getPdo());
            $categories = $managerCategorie->findAll();

            if (!empty($messageErreurs)) {
                // Les données ne sont pas valides, affichez les erreurs
                echo $this->getTwig()->render('propEv.html.twig', [
                    'title' => 'Proposition d\'événement',
                    'messageErreurs' => $messageErreurs,
                    'donnees' => $donnees,
                    'actualites' => $actualite,
                    'categories' => $categories,
                ]);
            } else {
                if (!$this->insererDonneesDansLaBase($donnees)) {
                    echo $this->getTwig()->render('propEv.html.twig', [
                        'title' => 'Proposition d\'événement',
                        'erreurBD' => "Erreur lors de l'insertion de l'événement",
                        'donnees' => htmlentities($donnees),
                        'actualites' => $actualite,
                        'categories' => $categories
                    ]);
                    exit();
                }else{
                    if (isset($_FILES['autorisation']) && $_FILES['autorisation']['error'] == 0){
                        // Vérification si le répertoire ../asset/evenement/autorisation/ existe, sinon le créer
                        $cheminDossierAutorisation = '../asset/evenement/autorisation/';
                        if (!is_dir($cheminDossierAutorisation)) {
                            if (!mkdir($cheminDossierAutorisation, 0777, true)) {
                                error_log("Erreur lors de la création du répertoire: " . $cheminDossierAutorisation);
                            }
                        }
                        // Vérification si le répertoire ../asset/evenement/photo/ existe, sinon le créer
                        $cheminDossierPhoto = '../asset/evenement/photo/';
                        if (!is_dir($cheminDossierPhoto)) {
                            if (!mkdir($cheminDossierPhoto, 0777, true)) {
                                error_log("Erreur lors de la création du répertoire: " . $cheminDossierPhoto);
                            }
                        }
                        // La photo est valide, et est donc uploadée dans asset/evenement/autorisation/
                        $cheminAutorisation = '../asset/evenement/autorisation/' . basename($autorisationName);
                        move_uploaded_file($autorisationTmpName, $cheminAutorisation);
                    }
                    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0){
                        // La photo est valide, et est donc uploadée dans asset/evenement/photo/
                        $cheminPhoto = '../asset/evenement/photo/' . basename($photoName);
                        move_uploaded_file($photoTmpName, $cheminPhoto);
                    }
                }
                header('Location: index.php?controlleur=index&methode=lister');

            }
        } else {
            echo $this->getTwig()->render('propEv.html.twig', [
                'title' => 'Proposition d\'événement',
                'messageErreurs' => "Vous devez vous connecter pour proposer un événement"
            ]);
        }
    }


    /**
     * @function insererDonneesDansLaBase
     * @details Fonction permettant d'insérer les données du formulaire de la page "Proposition d'événement" dans la base de données
     * @param array $donnees
     * @uses EvenementDao
     * @uses Bd
     * @uses Evenement
     * @uses insert 
     * @return bool
     */
    private function insererDonneesDansLaBase(array $donnees): bool
    {
        try {
            
            $managerEvenement = new EvenementDao($this->getPdo());

            // Créez un nouvel objet Evenement avec les données du formulaire
            $evenement = new Evenement(
                null,
                $donnees['titre'],
                $donnees['autorisationName'] ?? null,
                $donnees['description'],
                $donnees['email'],
                $donnees['tel'],
                $donnees['nomRep'],
                $donnees['prenomRep'],
                $donnees['debutDate'],
                $donnees['finDate'],
                $donnees['debutHeure'],
                $donnees['finHeure'],
                $donnees['lieu'],
                $donnees['photoName'] ?? null,
                false,
                $donnees['userId'],
                $donnees['cateId']
            );
            // Insérez l'événement dans la base de données
            $managerEvenement->insert($evenement);
            return true;
        } catch (Exception $e) {
            // Log the error message
            error_log("Error inserting event: " . $e->getMessage());
            return false;

        }
        
    }
}