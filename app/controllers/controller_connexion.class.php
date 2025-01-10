<?php
require_once '../app/controllers/validator.class.php';

class ControllerConnexion extends Controller {
    public function __construct(\Twig\Environment $twig, \Twig\Loader\FileSystemLoader $loader) {
        parent::__construct($twig, $loader);
    }

    public function afficher() {
        echo "afficher connexion";
    }

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
                $_SESSION['user'] = serialize($user);
                $this->getTwig()->addGlobal('utilisateurConnecte', $user);
                header('Location: index.php?controlleur=index&methode=lister');
            }
        } else {
            echo "Données invalides";
        }
    }
}