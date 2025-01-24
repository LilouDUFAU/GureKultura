<?php
require_once '../app/controllers/validator.class.php';

/**
 * @class ControllerConnexion
 * @extends parent <Controller>
 * @details Permet de gérer les actions liées à la page "connexion"
 */
class ControllerConnexion extends Controller {

    /**
     * @constructor ControllerConnexion
     * @details Constructeur de la classe ControllerConnexion
     * @param \Twig\Environment $twig
     * @param \Twig\Loader\FileSystemLoader $loader
     * @return void
     */
    public function __construct(\Twig\Environment $twig, \Twig\Loader\FileSystemLoader $loader) {
        parent::__construct($twig, $loader);
    }

    /**
     * @function lister
     * @details Fonction permettant d'afficher la page "connexion" de base
     * @uses Bd
     * @uses \Twig\Loader\FilesystemLoader
     * @uses \Twig\Environment
     * @uses ActualiteDao
     * @uses findAllWithCategorie
     * @return void
     */
    public function lister() {
        $pdo = Bd::getInstance()->getPdo();

        $loader = new \Twig\Loader\FilesystemLoader('../templates');
        $twig = new \Twig\Environment($loader);

        $managerActualite = new ActualiteDao($this->getPdo());
        $actualite = $managerActualite->findAllWithCategorie();

        // Rendre le template Twig
        echo $this->getTwig()->render('connexion.html.twig', [
            'title' => 'Connexion',
            'actualites' => $actualite,
        ]);
    }


    /**
     * @function validerFormulaireConnexion
     * @details Fonction permettant de valider les informations de connexion de l'utilisateur
     * @uses Validator
     * @uses UserDao
     * @uses Bd
     * @uses $_POST
     * @uses $_SESSION
     * @uses header
     * @uses getTwig
     * @uses addGlobal
     * @uses findWithEmail
     * @uses identifiantExist
     * @uses passwordExist
     * @return void
     */
    public function validerFormulaireConnexion() {
        // definition des regles de validations que l'on souhaite verifier pour chaque champs du formulaire
        $regleValidation = [
            'email' => [
                'obligatoire' => true,
                'type' => 'email',
                'longueurMin' => 10,
                'longueurMax' => 100,
                'format' => FILTER_VALIDATE_EMAIL
            ],
            'mdp' => [
                'obligatoire' => true,
                'type' => 'string',
                'longueurMin' => 8,
                'longueurMax' => 30,
                'format' => '/^[a-zA-Z0-9\s]+$/'
            ]
        ];

        // instanciation de la classe de validation
        $validator = new Validator($regleValidation);

        // recuperation des donnees du formulaire
        $donnees = $_POST;

        // boucle de nettoyage des donnees
        foreach ($donnees as $key => $value) {
            $donnees[$key] = htmlentities($value);
        }


        // validation des donnees du formulaire
        $donneesValides = $validator->valider($donnees);

        if ($donneesValides) {
            if($validator->identifiantExist($donnees['email'])) {
                $identifiantOk = true;
            } else {
                $identifiantOk = false;
                echo 'Identifiant incorrect';
            }

            if($validator->passwordExist($donnees['mdp'])) {
                $passwordOk = true;
            } else {
                $passwordOk = false;
                echo 'Mot de passe incorrect';
            }

            if($identifiantOk && $passwordOk) {
                $pdo = Bd::getInstance()->getPdo();
                $managerUser = new UserDao($pdo);
                $user = $managerUser->findWithEmail($donnees['email']);
                if ($user->getEstAdmin() == 1) {
                    $user->setRole('moderateur');
                } else {
                    $user->setRole('user');
                }
                $_SESSION['user'] =$user;
                $this->getTwig()->addGlobal('utilisateurConnecte', $user);
                header('Location: index.php?controlleur=index&methode=lister');
            }
        } else {
            echo "Données invalides";
        }
    }
}