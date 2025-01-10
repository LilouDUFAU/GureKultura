<?php

class ControllerCompte extends Controller
{

    public function __construct(\Twig\Environment $twig, \Twig\Loader\FileSystemLoader $loader)
    {
        parent::__construct($twig, $loader);
    }

    public function afficher()
    {
        echo "afficher compte";
    }

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
            $user = unserialize($_SESSION['user']);
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
                        $pseudoValide = true;
                    } else {
                        echo "Ce pseudo est déjà utilisé";
                        $pseudoValide = false;
                    }
                    $pseudoChange = true;
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
                
                echo $this->getTwig()->render('compte.html.twig', [
                        'title' => 'Compte',
                    'donnees' => $donnees,
                    'actualites' => $actualite,
                    'categories' => $categories

                ]);
                // if($pfpChange){
                //     $this->modifierDonneesDansLaBase($donnees['pfp'] ,'pfp');
                // }
                // mettre a jour
                // header('Location: index.php?controlleur=compte&methode=lister');
            }
        } else {
            header('Location: index.php?controlleur=connexion&methode=lister');

        }
    }


    public function deconnexion()
    {
        session_unset();
        session_destroy();
        header('Location: index.php?controlleur=index&methode=lister');
    }

    public function supprimerCompte()
    {
        $pdo = Bd::getInstance()->getPdo();
        $managerUser = new UserDao($pdo);
        $user = unserialize($_SESSION['user']); 
        $userId = $user->getUserId();
        $managerUser->delete($user);
        session_unset();
        session_destroy();
        header('Location: index.php?controlleur=index&methode=lister');
    }


    private function modifierDonneesDansLaBase(string $donnees, string $champ)
    {
        try {
            $pdo = Bd::getInstance()->getPdo();
            $managerUser = new UserDao($pdo);

            $user = unserialize($_SESSION['user']); 
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
}