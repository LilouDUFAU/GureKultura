<?php

/**
 * @class ControllerMdpReinitialisation
 * @extends parent<Controller>
 * @details Permet de gérer les actions liées à la page "mdpReinitialisation"
 */
class ControllermdpReinitialisation extends Controller {

    /**
     * @constructor ControllerMdpReinitialisation
     * @details Constructeur de la classe ControllerMdpReinitialisation
     * @param Twig\Environment $twig
     * @param Twig\Loader\FileSystemLoader $loader
     * @return void
     */
    public function __construct(\Twig\Environment $twig, \Twig\Loader\FileSystemLoader $loader) {
        parent::__construct($twig, $loader);
    }

    /**
     * @function lister
     * @details Fonction permettant d'afficher la page "Mot de passe oublié"
     * @uses ActualiteDao
     * @uses Bd
     * @uses findAllWithCategorie
     * @return void
     */
    public function lister() {
        $pdo = Bd::getInstance()->getPdo();

        $loader = new \Twig\Loader\FilesystemLoader('../templates');
        $twig = new \Twig\Environment($loader);

        $managerActualite = new ActualiteDao($this->getPdo());
        $actualite = $managerActualite->findAllWithCategorie();

        $managerToken = new TokenDao($this->getPdo());
        $token = $managerToken->find($_GET['tok']);

        $managerUser = new UserDao($this->getPdo());
        $user = $managerUser->find($token->getUserId());
        
        $mailEnvoyer = false;
        $email_to = null;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($_POST != null){
                $email_to = htmlentities($_POST['email_to']);
            }
        }
        $tokenValide = false;

        if ($token != null) {
            $dateExpiration = $token->getDateExpiration();
            $dateActuelle = new DateTime();
            $dateActuelle->format('Y-m-d H:i:s');
            if ($dateExpiration > $dateActuelle) {
                echo("c");
                $tokenValide = true;
            }
        }

        if ($tokenValide == true) {
            echo("Le token est valide");
        }else {
            echo("Le token n'est pas valide");
        }


        $managerCategorie = new CategorieDao($this->getPdo());
        $categorie = $managerCategorie->findAll();
    
        // Rendre le template Twig
        echo $this->getTwig()->render('mdpReinitialisation.html.twig', [
            'title' => 'Réinitialisation du mot de passe',
            'actualites' => $actualite,
            'tokenValide' => $tokenValide,
            'token' => $token,
            'user' => $user,
            'categories' => $categorie
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

        $managerToken = new TokenDao($this->getPdo());
        $token = $managerToken->find($_GET['tok']);

        $managerUser = new UserDao($this->getPdo());
        $user = $managerUser->find($token->getUserId());

        // recuperation des donnees du formulaire
        $donnees = $_POST;
        // boucle de nettoyage des donnees
        var_dump($donnees);
        foreach ($donnees as $key => $value) {
            $donnees[$key] = htmlentities($value);
        }
        var_dump($donnees);
        // validation des donnees du formulaire
        $donneesValides = $validator->valider($donnees);
        

        // si les donnees sont valides
        if ($donneesValides) {
            
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
            
            if($mdpValide) {
                //hasher le mot de passe
                $donnees['mdp'] = $validator->hash_password($donnees['mdp']);

                //enregistrer dans la basse données
                $managerUser->modify($donnees['mdp'],"mdp",$user->getUserId());
            }



            $tokenExist = $managerToken->findUserId($user->getUserId());
            $managerToken->delete($tokenExist);

            $mail = new Mail();
            $objet = "Confirmation de changement de mot de passe";
            $corp = "<h1> Votre mot de passe as correctement était réinitialisser </h1>";
            $mailEnvoyer = $mail->envoieMail($user->getEmail(), $objet, $corp); 

            header('Location: index.php?controlleur=index&methode=lister');
        } else {
            echo "Les données ne sont pas valides";
        }
    }

}