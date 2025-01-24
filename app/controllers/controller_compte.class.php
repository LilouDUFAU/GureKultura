<?php

/**
 * @class ControllerCompte
 * @extends parent<Controller>
 * @details Permet de gérer les actions liées à la page "compte"
 */
class ControllerCompte extends Controller
{

    /**
     * @constructor ControllerCompte
     * @details Constructeur de la classe ControllerCompte
     * @param \Twig\Environment $twig
     * @param \Twig\Loader\FileSystemLoader $loader
     * @return void
     */
    public function __construct(\Twig\Environment $twig, \Twig\Loader\FileSystemLoader $loader)
    {
        parent::__construct($twig, $loader);
    }

    /**
     * @function lister
     * @details Fonction permettant d'afficher la page "compte"
     * @uses ActualiteDao
     * @uses Bd
     * @return void
     */
    public function lister()
    {
        $pdo = Bd::getInstance()->getPdo();

        $loader = new \Twig\Loader\FilesystemLoader('../templates');
        $twig = new \Twig\Environment($loader);

        $managerActualite = new ActualiteDao($this->getPdo());
        $actualite = $managerActualite->findAllWithCategorie();

        // Rendre le template Twig
        echo $this->getTwig()->render('compte.html.twig', [
            'title' => 'Compte',
            'actualites' => $actualite
        ]);
    }

    /**
     * @function modifierInfo
     * @details Fonction permettant de modifier les informations de l'utilisateur connecté
     * @uses modifierDonneesDansLaBase
     * @uses Validator
     * @uses UserDao
     * @uses Bd
     * @uses findAllWithCategorie
     * @uses findAll
     * @uses is_available
     * @return void
     */
    public function modifierInfo()
    {
        // verifier
        if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
            // definition des regles de validations que l'on souhaite verifier pour chaque champs du formulaire
            $regleValidation = [
                'nom' => [
                    'obligatoire' => false,
                    'type' => 'string',
                    'longueurMin' => 2,
                    'longueurMax' => 100,
                    'format' => '/^[a-zA-Z0-9\s]+$/'
                ],
                'pseudo' => [
                    'obligatoire' => false,
                    'type' => 'string',
                    'longueurMin' => 2,
                    'longueurMax' => 30,
                    'format' => '/^[a-zA-Z0-9\s]+$/'
                ],
                'bio' => [
                    'obligatoire' => false,
                    'type' => 'string',
                    'longueurMin' => 0,
                    'longueurMax' => 500,
                    'format' => '/^[a-zA-Z0-9\s]+$/'
                ],
                'pfp' => [
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
            // boucle de nettoyage des donnees
            foreach ($donnees as $key => $value) {
                $donnees[$key] = htmlentities($value);
            }
                
            $user = $_SESSION['user'];
            $donnees['userId'] = $user->getUserId();
            



            // validation des donnees du formulaire
            $donneesValides = $validator->valider($donnees);
            if (!$donneesValides) {
                $messageErreurs = $validator->getMessageErreurs();
                var_dump($messageErreurs);
            } else {

                // verifier si le champ pseudo est egal au pseudo en base de donnee de l'utilisateur ayant l'id userId
                if ($donnees['pseudo'] != $user->getPseudo()) {
                    //vérifier que le pseudo est disponible
                    if ($validator->is_available($donnees['pseudo'])) {
                        //$pseudoValide = true;
                        $pseudoChange = true;
                    } else {
                        echo "Ce pseudo est déjà utilisé";
                        //$pseudoValide = false;
                        $pseudoChange = false;
                    }
                    
                } else {
                    $pseudoChange = false;
                }


                // verifier si le champ nom est egal au nom en base de donnee de l'utilisateur ayant l'id userId
                if ($donnees['nom'] != $user->getNom()) {
                    $nomChange = true;
                } else {
                    $nomChange = false;
                }

                // verifier si le champ bio est egal au bio en base de donnee de l'utilisateur ayant l'id userId
                if ($donnees['bio'] != $user->getBio()) {
                    $bioChange = true;
                } else {
                    $bioChange = false;
                }

                // verifier si le champ pfp est egal au pfp en base de donnee de l'utilisateur ayant l'id userId
                // if ( $donnees['pfp'] != $user->getPfp() ) {
                //     $pfpChange= true;
                // }

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
                // Les données ne sont pas valides, affichez les erreurs
                echo $this->getTwig()->render('compte.html.twig', [
                    'title' => 'Compte',
                    'messageErreurs' => $messageErreurs,
                    'donnees' => $donnees,
                    'actualites' => $actualite,
                    'categories' => $categories

                ]);
            } else {
                
                // modifier
                // Les données sont valides, modifiz-les dans la base de données

                if ($pseudoChange) {
                    $this->modifierDonneesDansLaBase($donnees['pseudo'], 'pseudo');
                }

                if ($nomChange) {
                    $this->modifierDonneesDansLaBase($donnees['nom'], 'nom');
                }

                if ($bioChange) {
                    $this->modifierDonneesDansLaBase($donnees['bio'], 'bio');
                }

                // if ($pfpChange) {
                //     $this->modifierDonneesDansLaBase($donnees['pfp'], 'pfp');
                // }
                

                $manager = new UserDao($pdo);
                $_SESSION['user'] = $manager->find($user->getUserId());

                echo $this->getTwig()->render('compte.html.twig', [
                    'title' => 'Compte',
                    'donnees' => $donnees,
                    'actualites' => $actualite,
                    'categories' => $categories

                ]);
            }
        } else {
            header('Location: index.php?controlleur=connexion&methode=lister');

        }
    }


    /**
     * @fuction deconnexion
     * @details Fonction permettant de deconnecter l'utilisateur connecté
     * @uses UserDao
     * @uses Bd
     * @uses delete
     * @return void
     */
    public function deconnexion()
    {
        session_unset();
        session_destroy();
        header('Location: index.php?controlleur=index&methode=lister');
    }

    /**
     * @function supprimerCompte
     * @details Fonction permettant de supprimer le compte de l'utilisateur connecté
     * @uses UserDao
     * @uses Bd
     * @uses delete
     * @return void
     */
    public function supprimerCompte()
    {
        $pdo = Bd::getInstance()->getPdo();
        $managerUser = new UserDao($pdo);
        $user = $_SESSION['user']; 
        $userId = $user->getUserId();
        $managerUser->delete($user);
        session_unset();
        session_destroy();
        header('Location: index.php?controlleur=index&methode=lister');
    }


    /**
     * @function modifierDonneesDansLaBase
     * @details Fonction permettant de modifier les données de l'utilisateur connecté dans la base de données (utilisée par la fonction modifierInfo)
     * @param string $donnees
     * @param string $champ
     * @uses UserDao
     * @uses Bd
     * @uses modify
     * @return void
     */
    private function modifierDonneesDansLaBase(string $donnees, string $champ)
    {
        try {
            $pdo = Bd::getInstance()->getPdo();
            $managerUser = new UserDao($pdo);

            $user = $_SESSION['user']; 
            $userId = $user->getUserId();

            // Insérez l'événement dans la base de données
            $managerUser->modify($donnees, $champ, $userId);

            
            if ($champ == 'pseudo') {
                $user->setPseudo($donnees);
                $this->getTwig()->addGlobal('user', $user);
            } 
            elseif ($champ == 'nom') {
                $user->setNom($donnees);
                $this->getTwig()->addGlobal('user', $user);
            } 
            elseif ($champ == 'bio') {
                $user->setBio($donnees);
                $this->getTwig()->addGlobal('user', $user);
            }
            // elseif ($champ == 'pfp') {
            //     $user->setPfp($donnees);
            //     $this->getTwig()->addGlobal('utilisateurConnecte', $user);

            // }

            // Log the event data for debugging
            error_log(print_r($user, true));
        } catch (Exception $e) {
            // Log the error message
            error_log("Error inserting event: " . $e->getMessage());
            throw $e; // Re-throw the exception if needed
        }
    }

    public function switchRole() {
        $_SESSION['user_role'] = $_SESSION['user']->getRole();
        if ($_SESSION['user_role'] === 'user') {
            $_SESSION['user_role'] = 'admin';
        } else {
            $_SESSION['user_role'] = 'user';
        }

        // Update the user object in the session
        $user = $_SESSION['user'];
        $user->setRole($_SESSION['user_role']);
        $_SESSION['user'] = $user;

        // Redirect to the appropriate page
        header('Location: index.php?controlleur=index&methode=lister');
    }
}