<?php
require_once '../app/controllers/validator.class.php';

/**
 * @class ControllerInscription
 * @exteds parent <Controller>
 * @details Gère les actions liées à la page "inscription"
 */
class ControllerInscription extends Controller {

    /**
     * @constructor ControllerInscription
     * @details Constructeur de la classe ControllerInscription
     * @param Twig\Environment $twig
     * @param Twig\Loader\FileSystemLoader $loader
     * @return void
     */ 
    public function __construct(\Twig\Environment $twig, \Twig\Loader\FileSystemLoader $loader) {
        parent::__construct($twig, $loader);
    }

    /**
     * @function lister
     * @details Fonction permettant d'afficher la page "Inscription" de base
     * @uses ActualiteDao
     * @uses Bd
     * @uses findAllWithCategorie
     * @return void
     */
    public function lister() {
        $pdo = Bd::getInstance()->getPdo();

        $loader = new \Twig\Loader\FilesystemLoader('../templates');
        $twig = new \Twig\Environment($loader);

        $managerActualite = new ActualiteDao($pdo);
        $actualite = $managerActualite->findAllWithCategorie();
        
        // Rendre le template Twig
        echo $twig->render('inscription.html.twig', [
            'title' => 'Inscription',
            'actualites' => $actualite
        ]);
    }

    /**
     * @function validerFormulaireInscription
     * @details Fonction permettant de valider les données du formulaire d'inscription
     * @uses Validator
     * @uses UserDao
     * @uses findWithEmail
     * @uses insert
     * @uses User
     * @return void
     */
    public function validerFormulaireInscription() {
        // definition des regles de validations que l'on souhaite verifier pour chaque champs du formulaire
        $regleValidation = [
            'email' => [
                'obligatoire' => true,
                'type' => 'email',
                'longueurMin' => 10,
                'longueurMax' => 100,
                'format' => FILTER_VALIDATE_EMAIL
            ],
            'nom' => [
                'obligatoire' => true,
                'type' => 'string',
                'longueurMin' => 2,
                'longueurMax' => 100,
                'format' => '/^[a-zA-Z0-9\s]+$/'
            ],
            'pseudo' => [
                'obligatoire' => true,
                'type' => 'string',
                'longueurMin' => 2,
                'longueurMax' => 30,
                'format' => '/^[a-zA-Z0-9\s]+$/'
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
        

        // si les donnees sont valides
        if ($donneesValides) {
            //vérifier que le pseudo est disponible
            if($validator->is_available($donnees['pseudo'])) {
                $pseudoValide = true;
            } else {
                echo "Ce pseudo est déjà utilisé";
                $pseudoValide = false;
            }

            //vérifier que l'email est disponible
            if($validator->is_available($donnees['email'])) {
                $emailValide = true;
            } else {
                echo "Cet email est déjà utilisé";
                $emailValide = false;
            }

            //vérifier que le mot de passe est correct
            if($validator->is_strong($donnees['mdp'])) {
                if($donnees['mdp'] == $donnees['mdp2']) {
                    $mdpValide = true;
                } else {
                    echo "Les mots de passe ne correspondent pas";
                    $mdpValide = false;
                }
            } else {
                echo "Le mot de passe n'est pas assez fort, il doit contenir au moins 8 caractères, une majuscule,un chiffre et un charactère spécial";
            }
            
            if($pseudoValide && $emailValide && $mdpValide) {
                //hasher le mot de passe
                $donnees['mdp'] = $validator->hash_password($donnees['mdp']);

                //enregistrer dans la basse données
                $this->insererDonneesDansLaBase($donnees);
            }

        } else {
            echo "Les données ne sont pas valides";
        }
    }


    /**
     * @function insererDonneesDansLaBase
     * @details Fonction permettant d'insérer les données du formulaire d'inscription dans la base de données
     * @param array $donnees
     * @uses UserDao
     * @uses User
     * @return void
     */
    private function insererDonneesDansLaBase(array $donnees)
    {
        try {
            $pdo = Bd::getInstance()->getPdo();
            $managerUser = new UserDao($pdo);
    
            // Créez un nouvel objet Evenement avec les données du formulaire
            $user = new User(
                null,
                $donnees['nom'],
                $donnees['pseudo'],
                $donnees['email'],
                $donnees['mdp'],
                null,
                null,
                null,
                false
            );
    
            // Log the event data for debugging
            error_log(print_r($user, true));
    
            // Insérez l'événement dans la base de données
            $managerUser->insert($user);

            //enregistrer l'utilisateur dans la session
            $pdo = Bd::getInstance()->getPdo();
                $managerUser = new UserDao($pdo);
                $user = $managerUser->findWithEmail($donnees['email']);
                if ($user->getEstAdmin() == 1) {
                    $user->setRole('admin');
                } else {
                    $user->setRole('user');
                }
                $_SESSION['user'] = $user;
                $this->getTwig()->addGlobal('utilisateurConnecte', $user);
            header('Location: index.php?controlleur=index&methode=lister');
        } catch (Exception $e) {
            // Log the error message
            error_log("Error inserting event: " . $e->getMessage());
            throw $e; // Re-throw the exception if needed
        }
    }
}